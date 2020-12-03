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
			$sql_MUNICIPIOS = mysql_query("SELECT TAB_APOIO_MUNICIPIOS.ID, TAB_APOIO_MUNICIPIOS.DESCRICAO, TAB_APOIO_UF.SIGLA FROM TAB_APOIO_MUNICIPIOS LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_MUNICIPIOS.DESCRICAO ASC;", $db);
			$sql = mysql_query("select * from TAB_ADM_FORNECEDOR where FORNEC_ID = '$id';", $db);
			$vetor = mysql_fetch_array($sql);
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
							<h3>Gestão de Suprimentos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Fornecedores</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_alterar_fornecedor.php?id=<?php echo $id; ?>" method="post" name="fornecedor" enctype="multipart/form-data" id="formID">

                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Razão Social/Nome</label>
                                <input type="text" name="FORNEC_NOME" class="form-control" id="FORNEC_NOME" placeholder="Digite a razão social/nome..." value="<?php echo $vetor['FORNEC_NOME']; ?>">
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Nome Fantasia</label>
                                <input type="text" name="FORNEC_NOMEFANT" class="form-control" id="FORNEC_NOMEFANT" placeholder="Digite o nome fantasia..." value="<?php echo $vetor['FORNEC_NOMEFANT']; ?>">
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">C.P.F./C.N.P.J.</label>
                                <input type="text" name="FORNEC_CPFCNPJ" class="form-control" id="FORNEC_CPFCNPJ" placeholder="Digite o número do documento..." value="<?php echo $vetor['FORNEC_CPFCNPJ']; ?>">
                            </fieldset>
                        </div>
                    </div><!--.row-->
                   
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Nome do Responsável</label>
                                <input type="text" name="FORNEC_NOMERESP" class="form-control" id="FORNEC_NOMERESP" placeholder="Digite o nome do responsável..." value="<?php echo $vetor['FORNEC_NOMERESP']; ?>">
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Inscrição Estadual</label>
                                <input type="text" name="FORNEC_INSCEST" class="form-control" id="FORNEC_INSCEST" placeholder="Digite a inscrição estadual..." value="<?php echo $vetor['FORNEC_INSCEST']; ?>">
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Inscrição Municipal</label>
                                <input type="text" name="FORNEC_INSCMUN" class="form-control" id="FORNEC_INSCMUN" placeholder="Digite a inscrição municipal..." value="<?php echo $vetor['FORNEC_INSCMUN']; ?>">
                            </fieldset>
                        </div>
                    </div><!--.row-->
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Endereço</label>
                                <input type="text" name="FORNEC_ENDERECO" class="form-control" id="FORNEC_ENDERECO" placeholder="Digite o logradouro/endereço..." value="<?php echo $vetor['FORNEC_ENDERECO']; ?>">
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Número</label>
                                <input type="text" name="FORNEC_NUMERO" class="form-control" id="FORNEC_NUMERO" placeholder="Digite o número..." value="<?php echo $vetor['FORNEC_NUMERO']; ?>">
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Complemento</label>
                                <input type="text" name="FORNEC_COMPL" class="form-control" id="FORNEC_COMPL" placeholder="Digite o complemento..." value="<?php echo $vetor['FORNEC_COMPL']; ?>">
                            </fieldset>
                        </div>
                    </div><!--.row-->
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Bairro</label>
                                <input type="text" name="FORNEC_BAIRRO" class="form-control" id="FORNEC_BAIRRO" placeholder="Digite o bairro...." value="<?php echo $vetor['FORNEC_BAIRRO']; ?>">
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Município</label>
                                    <select name="FORNEC_MUNICIPIO" id="FORNEC_MUNICIPIO" class="form-control">
                                        <?php while ($vetor_MUNICIPIOS=mysql_fetch_array($sql_MUNICIPIOS)) { ?>
                                        <option value="<?php echo $vetor_MUNICIPIOS['ID']; ?>" <?php if (strcasecmp($vetor['FORNEC_MUNICIPIO'], $vetor_MUNICIPIOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_MUNICIPIOS['DESCRICAO'].'/'.$vetor_MUNICIPIOS['SIGLA']; ?></option>
                                        <?php } ?>
                                    </select>
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">C.E.P.</label>
                                <input type="text" name="FORNEC_CEP" class="form-control" id="FORNEC_CEP" placeholder="Digite o C.E.P...." value="<?php echo $vetor['FORNEC_CEP']; ?>">
                            </fieldset>
                        </div>
                    </div><!--.row-->
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Telefone</label>
                                <input type="text" name="FORNEC_FONE01" class="form-control" id="FORNEC_FONE01" placeholder="Digite o telefone..." value="<?php echo $vetor['FORNEC_FONE01']; ?>">
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">Celular</label>
                                <input type="text" name="FORNEC_FONE02" class="form-control" id="FORNEC_FONE02" placeholder="Digite o telefone celular..." value="<?php echo $vetor['FORNEC_FONE02']; ?>">
                            </fieldset>
                        </div>
                        <div class="col-lg-4">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="exampleInput">E-mail</label>
                                <input type="text" name="FORNEC_EMAIL" class="form-control" id="FORNEC_EMAIL" placeholder="Digite o e-mail..." value="<?php echo $vetor['FORNEC_EMAIL']; ?>"> 
                            </fieldset>
                        </div>
                    </div><!--.row-->
                    
                    <div class="form-group row">
                    	<div class="col-lg-12">
                            <label for="exampleInput" class="form-label semibold">Observações</label>
                            <textarea rows="4" name="FORNEC_ANOTACOES" id="FORNEC_ANOTACOES" class="form-control" placeholder="Digite suas observações..."><?php echo $vetor['FORNEC_ANOTACOES']; ?></textarea>
						</div>
                    </div>
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