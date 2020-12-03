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
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      ); }
			$tecnico = $_SESSION['tecnico'];
			$data_atual = reverse_date(date("d/m/Y"));
			$sql_RGME_DATA = mysql_query("select ID from TAB_APOIO_RGME where '$data_atual' between DATA_INICIAL and DATA_FINAL;", $db);
			$vetor_RGME_DATA=mysql_fetch_array($sql_RGME_DATA);
			$rgme = $vetor_RGME_DATA['ID'];
			$sql_GRUPOS = mysql_query("select * from TAB_APOIO_PLAN_GRUPOS order by DESCRICAO ASC", $db);
			$sql_FAMILIAS = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_APOIO_BENEFICIOS.DESCRICAO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO from TAB_415421_FAMILIAS left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID WHERE TAB_415421_FAMILIAS.FAMILIA_TECNICO = '$tecnico' order by TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc;", $db);
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
							<h3>Familias - Projetos 4.1.5 / 4.2.1 / Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Planejamento de Visitas Mensais - RGM-E - v.1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="planejamento_recebe_cadastrar_visita.php" method="post" name="planejamento_recebe_cadastrar_visita" enctype="multipart/form-data" id="formID">
					<input type="hidden" name="PLAN_VISIT_TECNICO" id="PLAN_VISIT_TECNICO" value="<?php echo $tecnico;?>">
					<input type="hidden" name="PLAN_VISIT_RGME" id="PLAN_VISIT_RGME" value="<?php echo $rgme;?>">
                    <div class="form-group row">
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Data:</label>
                            <input type="text" name="PLAN_VISIT_PREVISAO" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)">
                        </div>
                        <div class="col-lg-9">
                        	<label class="form-label semibold" for="exampleSelect">Família:</label>
                            	<select name="PLAN_VISIT_FAMILIA" id="exampleSelect" class="form-control">
                                	<?php while ($vetor_FAMILIAS=mysql_fetch_array($sql_FAMILIAS)) { ?>
                                    <option value="<?php echo $vetor_FAMILIAS['FAMILIA_CODIGO']; ?>"><?php echo $vetor_FAMILIAS['FAMILIA_BENEFICIARIO'].' ('.$vetor_FAMILIAS['DESCRICAO'].')'; ?></option><?php } ?>
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