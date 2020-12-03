﻿<?php
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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$sqlALDEIAS = mysql_query("SELECT * FROM TAB_APOIO_INDIG_ALDEIA WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$INDIG_FAM_ID = $_GET['INDIG_FAM_ID'];
			$sql = mysql_query("SELECT * FROM TAB_INDIG_FAMILIAS WHERE INDIG_FAM_ID = '$INDIG_FAM_ID';", $db);
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
							<h3>Projetos de Atividades Produtivas - PAP / Projeto de Pesca Para Comercialização</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Componentes Familiares Indígenas - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_alterar_indig_pessoas.php?INDIG_FAM_ID=<?php echo $INDIG_FAM_ID; ?>" method="post" name="indig_pessoas" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="form-label semibold" for="INDIG_FAM_NOME">Descrição:</label>
                            <input type="text" name="INDIG_FAM_NOME" class="form-control" id="INDIG_FAM_NOME" placeholder="Digite o nome..." value="<?php echo $vetor['INDIG_FAM_NOME']; ?>">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label semibold" for="INDIG_FAM_ALDEIA">Aldeia:</label>
							<select name="INDIG_FAM_ALDEIA" id="INDIG_FAM_ALDEIA" class="form-control">
								<?php while ($vetorALDEIAS=mysql_fetch_array($sqlALDEIAS)) { ?>
								<option value="<?php echo $vetorALDEIAS['ID']; ?>" <?php if (strcasecmp($vetor['INDIG_FAM_ALDEIA'], $vetorALDEIAS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetorALDEIAS['DESCRICAO']; ?></option>
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