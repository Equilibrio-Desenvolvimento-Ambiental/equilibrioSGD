<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 5;
	session_start();
	if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
		echo "Esta área é restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id = $_GET['id'];
			$sql_FAMILIA = mysql_query("select * from TAB_415421_FAMESPECIAIS where FAMESP_CODIGO = '$id';", $db);
			$vetor_FAMILIA = mysql_fetch_array($sql_FAMILIA);

			$sql_TECNICOS = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC", $db);
			$sql_GRUPOS = mysql_query("select * from TAB_APOIO_PLAN_GRUPOS order by DESCRICAO ASC", $db);
			$sql_FAMILIAS = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_APOIO_BENEFICIOS.DESCRICAO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO from TAB_415421_FAMILIAS left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID order by TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc;", $db);
?>
<?php require_once("includes/header-completo.php");?>
<style type="text/css">
<!--
#scroll {
  width:100%;
  height:auto;
  overflow:auto;
}
-->
</style>
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
							<h3>Gestão do Projetos 4.1.5 - Reparação Rural / 4.2.1 - ATES / Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Familias Espciais (Agenda) - v.1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_alterar_familias_especiais.php?id=<?php echo $id; ?>" method="post" name="familias_especiais" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInputEmail1">Família:</label>
                            <select name="FAMESP_FAMILIA" id="exampleSelect" class="form-control">
                                <option value="0" selected="selected">Selecione uma família...</option>
                                <?php while ($vetor_FAMILIAS=mysql_fetch_array($sql_FAMILIAS)) { ?>
                                <option value="<?php echo $vetor_FAMILIAS['FAMILIA_CODIGO']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FAMESP_FAMILIA'], $vetor_FAMILIAS['FAMILIA_CODIGO']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_FAMILIAS['FAMILIA_BENEFICIARIO'].' ('.$vetor_FAMILIAS['DESCRICAO'].')'; ?></option><?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Técnico:</label>
                            <select name="FAMESP_TECNICO" id="exampleSelect" class="form-control">
                                <option value="0" selected="selected">Selecione um técnioco...</option>
                                <?php while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) { ?>
                                <option value="<?php echo $vetor_TECNICOS['ID'] ?>" <?php if (strcasecmp($vetor_FAMILIA['FAMESP_TECNICO'], $vetor_TECNICOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TECNICOS['DESCRICAO'] ?></option><?php } ?>
                            </select>
                         </div>	
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Grupo:</label>
							<select name="FAMESP_GRUPO" id="exampleSelect" class="form-control">
                                <option value="0" selected="selected">Selecione um grupo...</option>
                                <?php while ($vetor_GRUPOS=mysql_fetch_array($sql_GRUPOS)) { ?>
                                <option value="<?php echo $vetor_GRUPOS['ID'] ?>" <?php if (strcasecmp($vetor_FAMILIA['FAMESP_GRUPO'], $vetor_GRUPOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_GRUPOS['DESCRICAO'] ?></option><?php } ?>
                            </select>
                        </div>
                    </div>
					</br>
                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
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