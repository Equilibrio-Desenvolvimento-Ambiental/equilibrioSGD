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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$sql_MUNICIPIO = mysql_query("SELECT TAB_APOIO_MUNICIPIOS.ID, TAB_APOIO_MUNICIPIOS.DESCRICAO, TAB_APOIO_UF.SIGLA AS UF FROM TAB_APOIO_MUNICIPIOS LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_MUNICIPIOS.DESCRICAO ASC, TAB_APOIO_UF.DESCRICAO ASC;", $db);
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
							<h3>Tabelas de Apoio</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Cadastro de Bairros</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_cadastrar_tp_bairros.php" method="post" name="tp_bairros" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
	                    <label for="exampleSelect" class="col-sm-2 form-control-label">Nome do Bairro:</label>
                    	<div class="col-sm-10">
	                    	<input type="text" name="DESCRICAO" class="form-control" id="DESCRICAO" placeholder="Digite o nome do bairros...">
                    	</div>
					</div>
					<div class="form-group row">
						<label for="exampleSelect" class="col-sm-2 form-control-label">Município:</label>
						<div class="col-sm-10">
							<select name="MUNICIPIO" id="MUNICIPIO" class="form-control">
                              <option value="0" selected="selected">Selecione o Município...</option>
                              <?php while ($vetor_MUNICIPIO=mysql_fetch_array($sql_MUNICIPIO)) { ?>
                              <option value="<?php echo $vetor_MUNICIPIO['ID'] ?>"><?php echo $vetor_MUNICIPIO['DESCRICAO']."/".$vetor_MUNICIPIO['UF']; ?></option>
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