<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 4;
	session_start();
	if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
		echo "Esta área é restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$sql_PRINCIPAL = mysql_query("SELECT * FROM TAB_APOIO_TPVISIT415421_INTERF WHERE ATIVO = '1' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
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
							<h3>Gestão de Dados dos Projetos 4.1.5, 4.2.1 e Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Cadastro de Tipos de SubAtividades do Projeto Rural (Interfaces) - v 1.1.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_cadastrar_tp_tpsubvisit415421_interf.php" method="post" name="recebe_cadastrar_tp_tpsubvisit415421_interf" enctype="multipart/form-data" id="recebe_cadastrar_tp_tpsubvisit415421_interf">
                    <div class="form-group row">
                        <div class="col-lg-8">
                            <label class="form-label semibold" for="DESCRICAO">Descrição:</label>
                            <input type="text" name="DESCRICAO" class="form-control" id="DESCRICAO" placeholder="Digite a descrição...">
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label semibold" for="ATIVO">Status:</label>
                            <select name="ATIVO" id="ATIVO" class="form-control">
                                <option label="ATIVO" value="1" selected="selected">ATIVO</option>
                                <option label="INATIVO" value="2">INATIVO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="form-label semibold" for="ID_PRINCIPAL">Atividade Principal:</label>
                            <select name="ID_PRINCIPAL" id="ID_PRINCIPAL" class="form-control">
                                <option value="0" selected="selected">Selecione a atividade principal...</option>
                                <?php while ($vetor_PRINCIPAL=mysql_fetch_array($sql_PRINCIPAL)) { ?>
                                <option label="<?php echo $vetor_PRINCIPAL['DESCRICAO']; ?>" value="<?php echo $vetor_PRINCIPAL['ID']; ?>"><?php echo $vetor_PRINCIPAL['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
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
?>