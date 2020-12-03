<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 7;
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
			$id = $_GET['id'];
			$id_familia = $_GET['id_familia'];
			$sql = mysql_query("SELECT * FROM TAB_FISH_DOCUMENTOS WHERE FISH_DOC_ID = '$id' AND FISH_FAM_ID = '$id_familia';", $db) or die(mysql_error());
			$vetor = mysql_fetch_array($sql);
			$sql_TPDOCUMENTOS = mysql_query("select * from TAB_APOIO_TIPODOC ORDER BY DESCRICAO ASC;", $db);
?>
<?php require_once("includes/header-completo.php");?>
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
							<h3>Projetos de ATES para Pescadores</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Documentos - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_fish_alterar_documentos.php?id=<?php echo $id; ?>&id_familia=<?php echo $id_familia;?>" method="post" name="recebe_alterar_fish_documentos" enctype="multipart/form-data" id="recebe_alterar_fish_documentos">
                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label class="form-label semibold" for="FISH_DOC_DATA">Data:</label>
							<input type='text' name='FISH_DOC_DATA' id='FISH_DOC_DATA' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10' placeholder='Digite a data...' <?php if(!empty($vetor['FISH_DOC_DATA'])) { echo 'value="'.date('d/m/Y', strtotime($vetor['FISH_DOC_DATA'])).'"'; } ?>>
                        </div>
                        <div class="col-lg-5">
                            <label class="form-label semibold" for="FISH_DOC_TIPO">Tipo:</label>
							<select name="FISH_DOC_TIPO" id="FISH_DOC_TIPO" class="form-control">
                            <?php while ($vetor_TPDOCUMENTOS=mysql_fetch_array($sql_TPDOCUMENTOS)) { ?>
                            	<option value="<?php echo $vetor_TPDOCUMENTOS['ID']; ?>" <?php if (strcasecmp($vetor['FISH_DOC_TIPO'], $vetor_TPDOCUMENTOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPDOCUMENTOS['DESCRICAO']; ?></option><?php } ?>
							</select>
                        </div>
                        <div class="col-lg-5">
                            <label class="form-label semibold" for="FISH_DOC_DESCRICAO">Data:</label>
							<input type='text' name='FISH_DOC_DESCRICAO' id='FISH_DOC_DESCRICAO' class='form-control' placeholder='Digite a descrição...' value="<?php echo $vetor['FISH_DOC_DESCRICAO'];?>">
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