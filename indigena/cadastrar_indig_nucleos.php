<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 8;
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
			$sqlALDEIAS = mysql_query("SELECT * FROM TAB_APOIO_INDIG_ALDEIA WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
?>
<?php require_once("includes/header-completo.php");?>
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
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
							<h3>Gestão de Dados dos Projetos Indígenas</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Cadastro de Núcleos Familiares - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_cadastrar_indig_nucleos.php" method="post" name="recebe_cadastrar_indig_nucleos" enctype="multipart/form-data" id="recebe_cadastrar_indig_nucleos">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="form-label semibold" for="INDIG_NUC_NOME">Nome do Chefe da Família:</label>
                            <input type="text" name="INDIG_NUC_NOME" class="form-control" id="INDIG_NUC_NOME" placeholder="Digite o nome do chefe da família...">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label semibold" for="INDIG_NUC_ALDEIA">Aldeia:</label>
                            <select name="INDIG_NUC_ALDEIA" id="INDIG_NUC_ALDEIA" class="form-control">
                                <option value="0" selected="selected">Selecione uma aldeia...</option>
                                <?php while ($vetorALDEIAS=mysql_fetch_array($sqlALDEIAS)) { ?>
                                <option value="<?php echo $vetorALDEIAS['ID'] ?>"><?php echo $vetorALDEIAS['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
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