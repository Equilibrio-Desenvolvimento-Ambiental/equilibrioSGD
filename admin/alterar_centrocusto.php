<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 6;
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
			$sql = mysql_query("select * from TAB_ADM_CENTROCUSTO where CCUSTO_ID = '$id';", $db);
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
							<h3>Tabelas de Apoio - Gestão de Suprimentos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Centros de Custo</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_alterar_centrocusto.php?id=<?php echo $id; ?>" method="post" name="centrocusto" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
	                    <label for="exampleSelect" class="col-sm-2 form-control-label">Código:</label>
                    	<div class="col-sm-10">
	                    	<input type="text" name="CCUSTO_CODIGO" class="form-control" id="exampleInput" placeholder="Digite o código do Centro de Custo..." value="<?php echo $vetor['CCUSTO_CODIGO']; ?>">
                    	</div><br/><br/>
	                    <label for="exampleSelect" class="col-sm-2 form-control-label">Descrição:</label>
                    	<div class="col-sm-10">
	                    	<input type="text" name="CCUSTO_DESCRICAO" class="form-control" id="exampleInput" placeholder="Digite a descrição do Centro de Custo..." value="<?php echo $vetor['CCUSTO_DESCRICAO']; ?>">
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