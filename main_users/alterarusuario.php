<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 1;
	session_start();
	if($_SESSION['nivel'] != 1) {
		echo"Você não tem permissão para ficar nesta area ".$_SESSION['nome'];
		echo ". Esta é uma área restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
			$num_permissao = mysql_num_rows($sql_permissao);
				if ($num_permissao == 0) {
					echo "Esta área é restrita. Clique ";
					echo "<a href=\"../index.html\">aqui</a>";
					echo " para fazer o LOGIN.";
					exit;
				} else {
					$id = $_GET['id'];
					$sql = mysql_query("select * from TAB_MAIN_USERS where ID_USER = '$id'", $db);
					$vetor = mysql_fetch_array($sql);
					$sql_projetos = mysql_query("select * from TAB_MAIN_PROJECTS order by NOME asc", $db);
					$sql_permissoes = mysql_query("select a.ID_ITEM, b.NOME from TAB_MAIN_USERS_PROJECTS a, TAB_MAIN_PROJECTS b where a.ID_USER = '$id' and a.ID_PROJETO=b.ID_PROJETO order by b.NOME", $db);
?>
<?php require_once("includes/header-completo.php");?>
<body class="with-side-menu">
<?php require_once("includes/site-header.php");?>
	<div class="mobile-menu-left-overlay"></div>
	<nav class="side-menu">
	    <ul class="side-menu-list">
	        <?php include"includes/menu.php"; ?>
	        </ul>
	    </section>
	</nav><!--.side-menu-->
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Controle de Usuários</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Usuários</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_alterarusuario.php?id=<?php echo $id; ?>" method="post" name="usuarios" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                            <label for="exampleSelect" class="col-sm-2 form-control-label">Nome do Usuário:</label>
                            <div class="col-sm-10">
                                <input type="text" name="nomeUsuario" class="form-control" id="exampleInput" value="<?php echo $vetor['NOME']; ?>" placeholder="Digite o nome do usuário..." >
                            </div>
                    </div>
                    <div class="form-group row">
                            <label for="exampleSelect" class="col-sm-2 form-control-label">Login do Usuário:</label>
                            <div class="col-sm-10">
                                <input type="text" name="loginUsuario" value="<?php echo $vetor['USUARIO']; ?>" class="form-control" id="exampleInput" placeholder="Digite o login do usuário...">
                            </div>
                    </div>
                    <div class="form-group row">
                            <label for="exampleSelect" class="col-sm-2 form-control-label">Senha do Usuário:</label>
                            <div class="col-sm-10">
                                <input type="password" name="senhaUsuario" value="<?php echo $vetor['SENHA']; ?>"class="form-control" id="exampleInput" placeholder="Digite a senha do usuário...">
                            </div>
                    </div>
                    <div class="form-group row">
                            <label for="exampleSelect" class="col-sm-2 form-control-label">Nível de Acesso do Usuário:</label>
                            <div class="col-sm-10">
                                <select name="nivelUsuario" id="exampleSelect" class="form-control">
									<option value="0" <?php if (strcasecmp($vetor['NIVEL'], '0') == 0) : ?>selected="selected"<?php endif; ?>>Selecione um nível...</option>
									<option value="1" <?php if (strcasecmp($vetor['NIVEL'], '1') == 0) : ?>selected="selected"<?php endif; ?>>Administrador</option>
                                    <option value="2" <?php if (strcasecmp($vetor['NIVEL'], '2') == 0) : ?>selected="selected"<?php endif; ?>>Usuário</option>
                                    <option value="3" <?php if (strcasecmp($vetor['NIVEL'], '3') == 0) : ?>selected="selected"<?php endif; ?>>Técnico de Campo</option>
                                </select>
                            </div>
                    </div>
                    <div class="form-group row">
                            <label for="exampleSelect" class="col-sm-2 form-control-label">Usuário Ativo?</label>
                            <div class="col-sm-10">
                                <select name="ativoUsuario" id="exampleSelect" class="form-control">
                                  <option value="1" <?php if (strcasecmp($vetor['ATIVO'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                  <option value="2" <?php if (strcasecmp($vetor['ATIVO'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                </select>
                            </div>
                    </div>
                    <div class="form-group row">
                            <label for="exampleSelect" class="col-sm-2 form-control-label">Permissões à Projetos:</label>
                            <div class="col-sm-10">
                                <select name="permissoesUsuario[]" MULTIPLE id="exampleSelect" class="form-control">
                                  <?php while ($vetor_projetos=mysql_fetch_array($sql_projetos)) { ?>
                                   <option value="<?php echo $vetor_projetos['ID_PROJETO']; ?>"><?php echo $vetor_projetos['NOME']; ?></option>
                                  <?php } ?>
                                </select>
                            </div>
                    </div>
					</br>
                    <table id="table-sm" class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Nome do Projeto</th>
                                <th width="120"></th>
                            </tr>
                        </thead>
                        <tbody>
							<?php 
								while ($vetor_permissoes=mysql_fetch_array($sql_permissoes)) {
							?>
							<tr>
								<td class="color-blue-grey-lighter"><?php echo $vetor_permissoes['NOME']; ?></td>
								<td><a href="recebe_excluirusuarioprojeto.php?id_user=<?php echo $id; ?>&amp;id_perm=<?php echo $vetor_permissoes['ID_ITEM']; ?>">Excluir</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </br>
                    <input name="salvar" type="image" src="imgs/salvar.png" class="float" />
			</form>
			</div><!--.box-typical-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
}
?>