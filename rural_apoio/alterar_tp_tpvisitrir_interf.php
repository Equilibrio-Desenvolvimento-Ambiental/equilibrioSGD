﻿<?php
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
			$id = $_GET['id'];
			$sql = mysql_query("SELECT * FROM TAB_APOIO_TPVISITRIR_INTERF WHERE ID = '$id';", $db) or die(mysql_error());
			$vetor = mysql_fetch_array($sql);
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
								<li><a href="#">Alteração de Tipos de Atividades do Projeto Ribeirinho (Interfaces) - v 1.1.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_alterar_tp_tpvisitrir_interf.php?id=<?php echo $id; ?>" method="post" name="recebe_alterar_tp_tpvisitrir_interf" enctype="multipart/form-data" id="recebe_alterar_tp_tpvisitrir_interf">
                    <div class="form-group row">
                        <div class="col-lg-8">
                            <label class="form-label semibold" for="DESCRICAO">Descrição:</label>
                            <input type="text" name="DESCRICAO" class="form-control" id="DESCRICAO" placeholder="Digite a descrição..." value="<?php echo $vetor['DESCRICAO']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label semibold" for="ATIVO">Status:</label>
                            <select name="ATIVO" id="ATIVO" class="form-control">
                                <option label="ATIVO" value="1" <?php if (strcasecmp($vetor['ATIVO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>ATIVO</option>
                                <option label="INATIVO" value="2" <?php if (strcasecmp($vetor['ATIVO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>INATIVO</option>
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