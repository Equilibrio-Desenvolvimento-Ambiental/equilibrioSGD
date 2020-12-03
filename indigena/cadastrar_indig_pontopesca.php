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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$sqlFUSOS = mysql_query("SELECT * FROM TAB_APOIO_FUSOS WHERE ID > 0 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
?>
<?php require_once("includes/header-completo.php");?>
<style>
table {
  border-collapse: collapse;
  border: 0px;
}
thead {
  background-color:#090047;
  color:#FFFFFF;
  font-size:16px;
  text-align:center;
  font-weight:bold;
}
th {
  font-weight: normal;
  text-align: left;
}
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
function minteiro(v){
	v=v.replace(/\D/g,"");//Remove tudo o que não é dígito  
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
							<h3>Projetos de Atividades Produtivas - PAP / Projeto de Pesca Para Comercialização</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Cadastro de Pontos de Pesca - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_cadastrar_indig_pontopesca.php" method="post" name="indig_pontopesca" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="form-label semibold" for="INDIG_PP_NOME">Nome do Ponto:</label>
                            <input type="text" name="INDIG_PP_NOME" class="form-control" id="INDIG_PP_NOME" placeholder="Digite o nome...">
                        </div>
					</div>
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="form-label semibold" for="INDIG_PP_COORD_FUSO">Fuso:</label>
                            <select name="INDIG_PP_COORD_FUSO" id="INDIG_PP_COORD_FUSO" class="form-control">
                                <option value="0" selected="selected">Selecione um fuso...</option>
                                <?php while ($vetorFUSOS=mysql_fetch_array($sqlFUSOS)) { ?>
                                <option value="<?php echo $vetorFUSOS['ID'] ?>"><?php echo $vetorFUSOS['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label semibold" for="INDIG_PP_COORD_ESTE">Coord. E:</label>
							<input type="text" name="INDIG_PP_COORD_ESTE" id="INDIG_PP_COORD_ESTE" class="form-control" placeholder="Digite a coordenada...">
						</div>
                        <div class="col-lg-3">
                            <label class="form-label semibold" for="INDIG_PP_COORD_NORTE">Coord. N:</label>
							<input type="text" name="INDIG_PP_COORD_NORTE" id="INDIG_PP_COORD_NORTE" class="form-control" placeholder="Digite a coordenada...">
						</div>
                        <div class="col-lg-3">
                            <label class="form-label semibold" for="INDIG_PP_COORD_ALT">Altitude:</label>
							<input type="text" name="INDIG_PP_COORD_ALT" id="INDIG_PP_COORD_ALT" class="form-control" placeholder="Digite a coordenada...">
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