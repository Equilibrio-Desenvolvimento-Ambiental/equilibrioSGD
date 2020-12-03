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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id = $_GET['id'];
			$id_evento = $_GET['id_evento'];
			$id_familia = $_GET['id_familia'];
			$sql_EVENTO = mysql_query("SELECT * FROM TAB_415421_EVENTOS WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
			$vetor_EVENTO = mysql_fetch_array($sql_EVENTO);
			$sql_TPEVENTOS = mysql_query("SELECT * FROM TAB_APOIO_EVENTOS ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TECNICOS = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TPDOCUMENTOS = mysql_query("select * from TAB_APOIO_TIPODOC ORDER BY DESCRICAO ASC;", $db);

			$sql = mysql_query("SELECT * FROM TAB_415421_EVENTOS_DOCS WHERE EVEDOC_CODIGO = '$id' AND EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
			$vetor = mysql_fetch_array($sql);
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

<body>
<?php require_once("includes/site-header.php");?>
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Gestão do Projetos 4.1.5 e 4.2.1 e Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Dados de Atividade - Documentos - v 1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="#" method="post" name="#" enctype="multipart/form-data" id="#">
                    <div class="form-group row">
						<div class="col-lg-4">
                        	<label class="form-label semibold" for="EVENTOS_DATA">Data do Evento:</label>
                            <input type="text" name="EVENTOS_DATA" class="form-control" id="EVENTOS_DATA" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_EVENTO['EVENTOS_DATA'])); ?>">
                        </div>
                        <div class="col-lg-8">
                        	<label class="form-label semibold" for="EVENTOS_TIPO">Tipo do Evento:</label>
                            <select name="EVENTOS_TIPO" id="EVENTOS_TIPO" class="form-control">
								<?php while ($vetor_TPEVENTOS=mysql_fetch_array($sql_TPEVENTOS)) { ?>
                                <option label="<?php echo $vetor_TPEVENTOS['DESCRICAO']; ?>" value="<?php echo $vetor_TPEVENTOS['ID']; ?>" <?php if (strcasecmp($vetor_EVENTO['EVENTOS_TIPO'], $vetor_TPEVENTOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPEVENTOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Data do Evento / Tipo do Evento -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="EVENTOS_OBSERVACOES">Observações:</label>
                            <input type="text" name="EVENTOS_OBSERVACOES" class="form-control" id="EVENTOS_OBSERVACOES" placeholder="Digite observações..." value="<?php echo $vetor_EVENTO['EVENTOS_OBSERVACOES']; ?>">
                         </div>	
                    </div> <!-- Observações -->
				</form>
			</div><!--.box-typical-->
			
			<div class="box-typical box-typical-padding">
            	<form action="recebe_alterar_evento_documento.php?id=<?php echo $id; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_alterar_evento_documento" enctype="multipart/form-data" id="recebe_alterar_evento_documento">
                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label class="form-label semibold" for="EVEDOC_DATA">Data:</label>
							<input type='text' name='EVEDOC_DATA' id='EVEDOC_DATA' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10' placeholder='Digite a data...' <?php if(!empty($vetor['EVEDOC_DATA'])) { echo 'value="'.date('d/m/Y', strtotime($vetor['EVEDOC_DATA'])).'"'; } ?>>
                        </div>
                        <div class="col-lg-5">
                            <label class="form-label semibold" for="EVEDOC_TIPO">Tipo:</label>
							<select name="EVEDOC_TIPO" id="EVEDOC_TIPO" class="form-control">
                            <?php while ($vetor_TPDOCUMENTOS=mysql_fetch_array($sql_TPDOCUMENTOS)) { ?>
                            	<option value="<?php echo $vetor_TPDOCUMENTOS['ID']; ?>" <?php if (strcasecmp($vetor['EVEDOC_TIPO'], $vetor_TPDOCUMENTOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPDOCUMENTOS['DESCRICAO']; ?></option><?php } ?>
							</select>
                        </div>
                        <div class="col-lg-5">
                            <label class="form-label semibold" for="EVEDOC_DESCRICAO">Data:</label>
							<input type='text' name='EVEDOC_DESCRICAO' id='EVEDOC_DESCRICAO' class='form-control' placeholder='Digite a descrição...' value="<?php echo $vetor['EVEDOC_DESCRICAO'];?>">
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