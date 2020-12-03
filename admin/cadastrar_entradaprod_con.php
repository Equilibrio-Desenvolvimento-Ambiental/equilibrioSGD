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
			$sql_MATCONSUMO = mysql_query("select TAB_ADM_MATCONSUMO.MATCONS_ID, TAB_ADM_MATCONSUMO.MATCONS_NOME, TAB_APOIO_PROD_UNIT.DESCRICAO as MATCONS_UNIDADE_DESC from TAB_ADM_MATCONSUMO left outer join TAB_APOIO_PROD_UNIT on TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID order by TAB_ADM_MATCONSUMO.MATCONS_NOME asc;", $db);
			$sql_FORNECEDOR = mysql_query("SELECT FORNEC_ID, FORNEC_NOME, FORNEC_NOMEFANT FROM TAB_ADM_FORNECEDOR ORDER BY FORNEC_NOME ASC, FORNEC_NOMEFANT ASC;", $db);
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
<script type="text/javascript">
/* MÃ¡scaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mdata(v){  
    v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito  
    v=v.replace(/(\d{2})(\d)/,"$1/$2");  
    v=v.replace(/(\d{2})(\d)/,"$1/$2");  
    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");  
    return v;  
}  
function mvalor(v){
	v=v.replace(/\D/g,"");//Remove tudo o que não é dígito  
	v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões  
	v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares
	v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos  
	return v;  
}  
function id(el){
	return document.getElementById( el );
}
window.onload = function(){  
    id('telefone').onkeypress = function(){  
        mascara( this, mtel);  
    }
    id('telefone2').onkeypress = function(){  
        mascara( this, mtel);  
    }
}
</script>
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
								<li><a href="#">Entrada de Materiais de Uso Compartilhado</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_cadastrar_entradaprod_con.php" method="post" name="entradaprod_con" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Data:</label>
                            <input type="text" name="PRODENTC_DATA" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleSelect">Produto:</label>
                            <select name="PRODENTC_PRODUTO" id="exampleSelect" class="form-control">
                                <?php while ($vetor_MATCONSUMO=mysql_fetch_array($sql_MATCONSUMO)) { ?>
                                <option value="<?php echo $vetor_MATCONSUMO['MATCONS_ID']; ?>"><?php echo $vetor_MATCONSUMO['MATCONS_NOME'].' ('.$vetor_MATCONSUMO['MATCONS_UNIDADE_DESC'].')'; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleSelect">Fornecedor:</label>
                            <select name="PRODENTC_FORNEC" id="exampleSelect" class="form-control">
                                <?php while ($vetor_FORNECEDOR=mysql_fetch_array($sql_FORNECEDOR)) { ?>
                                <option value="<?php echo $vetor_FORNECEDOR['FORNEC_ID']; ?>"><?php echo $vetor_FORNECEDOR['FORNEC_NOME'].' ('.$vetor_FORNECEDOR['FORNEC_NOMEFANT'].')'; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Valor (R$):</label>
                            <input type="text" name="PRODENTC_VALOR" class="form-control" id="exampleInput" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="0,00">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Quantidade:</label>
                            <input type="text" name="PRODENTC_QTDE" class="form-control" id="exampleInput" placeholder="Digite a qtde..." value="1" >
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