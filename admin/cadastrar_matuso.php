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
			$sql_CATEGORIAS = mysql_query("select * from TAB_APOIO_PROD_CATEG order by ID ASC", $db);
			$sql_UNIDADES = mysql_query("select * from TAB_APOIO_PROD_UNIT order by ID ASC", $db);
?>
<?php require_once("includes/header-completo.php");?>
<style type="text/css">
<!--
#scroll {
  width:100%;
  height:400px;
  overflow:auto;
}
-->
</style>
<script src="tabs/tabcontent.js" type="text/javascript"></script>
<link href="tabs/template1/tabcontent.css" rel="stylesheet" type="text/css" />
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
								<li><a href="#">Cadastro de Ferramentas</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_cadastrar_matuso.php" method="post" name="matuso" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInput">Nome do Produto:</label>
                            <input type="text" name="MATUSO_NOME" class="form-control" id="exampleInput" placeholder="Digite o nome do produto..." >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleSelect">Categoria do Produto:</label>
                            <select name="MATUSO_CATEGORIA" id="exampleSelect" class="form-control">
                                <?php while ($vetor_CATEGORIAS=mysql_fetch_array($sql_CATEGORIAS)) { ?>
                                <option value="<?php echo $vetor_CATEGORIAS['ID'] ?>"><?php echo $vetor_CATEGORIAS['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleSelect">Unidade de Medida do Produto:</label>
                            <select name="MATUSO_UNIDADE" id="exampleSelect" class="form-control">
                                <?php while ($vetor_UNIDADES=mysql_fetch_array($sql_UNIDADES)) { ?>
                                <option value="<?php echo $vetor_UNIDADES['ID'] ?>"><?php echo $vetor_UNIDADES['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInput">Estoque Total do Produto:</label>
                            <input type="text" name="MATUSO_ESTOQUE_ATUAL" class="form-control" id="exampleInput" placeholder="Qtde do estoque total..." >
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInput">Estoque Mínimo do Produto:</label>
                            <input type="text" name="MATUSO_ESTOQUE_MINIMO" class="form-control" id="exampleInput" placeholder="Qtde do estoque mínimo...">
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