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
			$id_familia = $_GET['id_familia'];
			$tecnico = $_SESSION['tecnico'];
			
			$sql_FAMILIA = mysql_query("select * from TAB_415421_FAMILIAS where FAMILIA_CODIGO = '$id_familia';", $db);
			$vetor_FAMILIA = mysql_fetch_array($sql_FAMILIA);
			$sql_BENEFICIOS = mysql_query("select * from TAB_APOIO_BENEFICIOS order by DESCRICAO ASC;", $db);
			$sql_MUNICIPIOS = mysql_query("select * from TAB_APOIO_MUNICIPIOS order by DESCRICAO ASC;", $db);
			$sql_SETETORATEND = mysql_query("select * from TAB_APOIO_SETORATEND order by DESCRICAO ASC;", $db);
			$sql_FUSOS = mysql_query("select * from TAB_APOIO_FUSOS order by DESCRICAO ASC;", $db);
			$sql_TECNICOS = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC;", $db);
			$sql_GRUPOS = mysql_query("select * from TAB_APOIO_PLAN_GRUPOS order by DESCRICAO ASC", $db);

			$sql_DADOSGERAIS = mysql_query("select * from TAB_415421_DADOSGERAIS where FAMILIA_CODIGO = '$id_familia';", $db);
			$vetor_DADOSGERAIS = mysql_fetch_array($sql_DADOSGERAIS);
			$sql_DADOSSALDO = mysql_query("select * from TAB_415421_DADOSSALDO where FAMILIA_CODIGO = '$id_familia';", $db);
			$vetor_DADOSSALDO = mysql_fetch_array($sql_DADOSSALDO);
			$sql_CARACTRIR = mysql_query("select * from TAB_415421_PONTOOCUP where FAMILIA_CODIGO = '$id_familia';", $db);
			$vetor_CARACTRIR = mysql_fetch_array($sql_CARACTRIR);
			$sql_EMATER = mysql_query("select * from TAB_415421_EMATER where FAMILIA_CODIGO = '$id_familia';", $db);
			$num_EMATER = mysql_num_rows($sql_EMATER);
			$vetor_EMATER = mysql_fetch_array($sql_EMATER);
	
			$sql_TPATENDIMENTO421 = mysql_query("select * from TAB_APOIO_TPATENDIMENTO order by DESCRICAO ASC;", $db);
			$sql_MTATENDIMENTO421 = mysql_query("select * from TAB_APOIO_MTATENDIMENTO order by DESCRICAO ASC;", $db);
			$sql_TPATENDIMENTO415 = mysql_query("select * from TAB_APOIO_TPATENDIMENTO order by DESCRICAO ASC;", $db);
			$sql_MTATENDIMENTO415 = mysql_query("select * from TAB_APOIO_MTATENDIMENTO order by DESCRICAO ASC;", $db);
			$sql_TPATENDIMENTORIR = mysql_query("select * from TAB_APOIO_TPATENDIMENTO order by DESCRICAO ASC;", $db);
			$sql_MTATENDIMENTORIR = mysql_query("select * from TAB_APOIO_MTATENDIMENTO order by DESCRICAO ASC;", $db);
			$sql_PEADS = mysql_query("select * from TAB_APOIO_PEADS order by DESCRICAO ASC;", $db);
			$sql_TPPROJETO = mysql_query("select * from TAB_APOIO_TPPROJETO order by DESCRICAO ASC;", $db);
			$sql_STPROJETO = mysql_query("select * from TAB_APOIO_STPROJETO order by DESCRICAO ASC;", $db);
			$sql_TPPROJETO_RIR = mysql_query("select * from TAB_APOIO_TPPROJETO order by DESCRICAO ASC;", $db);
			$sql_STPROJETO_RIR = mysql_query("select * from TAB_APOIO_STPROJETO order by DESCRICAO ASC;", $db);

			$sql_STPROJETO_RIR_AVI = mysql_query("select * from TAB_APOIO_STPROJETO order by DESCRICAO ASC;", $db);
			$sql_STPROJETO_RIR_VIV = mysql_query("select * from TAB_APOIO_STPROJETO order by DESCRICAO ASC;", $db);
			$sql_STPROJETO_RIR_ROC = mysql_query("select * from TAB_APOIO_STPROJETO order by DESCRICAO ASC;", $db);

			$sql_STPROJETO_RIR_CASAFAR = mysql_query("select * from TAB_APOIO_STPROJETO order by DESCRICAO ASC;", $db);
			$sql_STPROJETO_RIR_BARCACA = mysql_query("select * from TAB_APOIO_STPROJETO order by DESCRICAO ASC;", $db);
			$sql_STPROJETO_RIR_GALPAO = mysql_query("select * from TAB_APOIO_STPROJETO order by DESCRICAO ASC;", $db);
			$sql_STPROJETO_RIR_AVI2CIC = mysql_query("select * from TAB_APOIO_STPROJETO order by DESCRICAO ASC;", $db);
			
			$sql_STPROCESSO_CAR = mysql_query("select * from TAB_APOIO_STPROCESSOS order by DESCRICAO ASC;", $db);
			$sql_STPROCESSO_DAP = mysql_query("select * from TAB_APOIO_STPROCESSOS order by DESCRICAO ASC;", $db);
			$sql_STPROCESSO_DLA = mysql_query("select * from TAB_APOIO_STPROCESSOS order by DESCRICAO ASC;", $db);
			$sql_STSALDO = mysql_query("select * from TAB_APOIO_STSALDO order by DESCRICAO ASC;", $db);
			$sql_TPEVENTOS = mysql_query("SELECT * FROM TAB_APOIO_EVENTOS WHERE DESCRICAO LIKE '%(ATES/REP. RURAL)%' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_PARENTESCOS = mysql_query("select * from TAB_APOIO_PARENTESCO order by DESCRICAO ASC;", $db);
			$sql_BENEFICIO_ORIGINAL = mysql_query("select * from TAB_APOIO_BENEFICIOS order by DESCRICAO ASC;", $db);
			$sql_BENEFICIO_OFERTADO = mysql_query("select * from TAB_APOIO_BENEFICIOS order by DESCRICAO ASC;", $db);
			$sql_MUNICIPIO_DOMICILIO = mysql_query("select * from TAB_APOIO_MUNICIPIOS order by DESCRICAO ASC;", $db);
			$sql_PONTOOCUPACAO = mysql_query("select POCUP_CODIGO, POCUP_PROCESSO from TAB_RIR_PONTOOCUP order by POCUP_PROCESSO asc;", $db);
			$sql_VISITASPENDENTES = mysql_query("select PLAN_VISIT_ID, PLAN_VISIT_PREVISAO, PLAN_VISIT_EXECUCAO from TAB_415421_PLANVISITAS where PLAN_VISIT_FAMILIA = '$id_familia' and PLAN_VISIT_CONCLUIDA = '2' and PLAN_VISIT_TECNICO = '$tecnico' order by PLAN_VISIT_EXECUCAO desc;", $db);
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
<script type="text/javascript">

var qtdeCampos_EVENTO = 0;
function addCampos_EVENTO() {
var objPai_EVENTO = document.getElementById("campoPai_EVENTO"); //Criando o elemento DIV;
var objFilho_EVENTO = document.createElement("div"); //Definindo atributos ao objFilho:
objFilho_EVENTO.setAttribute("id","filho_EVENTO"+qtdeCampos_EVENTO); //Inserindo o elemento no pai:
objPai_EVENTO.appendChild(objFilho_EVENTO); //Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filho_EVENTO"+qtdeCampos_EVENTO).innerHTML = "<table width='100%'><tr><td width='110px'><input type='text' name='EVENTOS_DATA[]' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10'  id='exampleInput' placeholder='Digite as data...'></td><td width='3px'></td><td width='250px'><select name='EVENTOS_TIPO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_TPEVENTOS=mysql_fetch_array($sql_TPEVENTOS)) { ?><option value='<?php echo  $vetor_TPEVENTOS[ID]; ?>'><?php echo str_replace('(ATES/REP. RURAL) ','',$vetor_TPEVENTOS[DESCRICAO]); ?></option><?php } ?></select></td><td width='3px'></td><td width='400px'><input type='text' name='EVENTOS_OBSERVACOES[]' class='form-control' id='exampleInput' placeholder='Digite observações...'></td><td width='3px'></td><td width='100px'><input type='button' onclick='removerCampo_EVENTO("+qtdeCampos_EVENTO+")' value='Remover' class='btn btn-inline'></td></tr><tr><td width='110px'>&nbsp;</td><td width='3px'></td><td width='250px'><select name='VISITA_BAIXA[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Visita realizada não é da AGENDA!</option><?php while ($vetor_VISITASPENDENTES=mysql_fetch_array($sql_VISITASPENDENTES)) { ?><option value='<?php echo  $vetor_VISITASPENDENTES[PLAN_VISIT_ID]; ?>'><?php echo date('d/m/Y', strtotime($vetor_VISITASPENDENTES[PLAN_VISIT_PREVISAO])); ?></option><?php } ?></select></td><td width='3px'></td><td width='400px'>&nbsp;</td><td width='3px'></td><td width='100px'>&nbsp;</td></tr></table>";
qtdeCampos_EVENTO++;
}
function removerCampo_EVENTO(id) {
var objPai_EVENTO = document.getElementById("campoPai_EVENTO");
var objFilho_EVENTO = document.getElementById("filho_EVENTO"+id);
console.log(objPai_EVENTO); //Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPai_EVENTO.removeChild(objFilho_EVENTO);
}

var qtdeCampos_DOC = 0;
function addCampos_DOC() {
var objPai_DOC = document.getElementById("campoPai_DOC"); //Criando o elemento DIV;
var objFilho_DOC = document.createElement("div"); //Definindo atributos ao objFilho:
objFilho_DOC.setAttribute("id","filho_DOC"+qtdeCampos_DOC); //Inserindo o elemento no pai:
objPai_DOC.appendChild(objFilho_DOC); //Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filho_DOC"+qtdeCampos_DOC).innerHTML = "<table width='100%' border='0'><tr><td width='15%' class='style12'><input type='text' name='DOC_DATA[]' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10'  id='exampleInput' placeholder='Digite as data...'></td><td width='1%'></td><td width='40%' class='style12'><input type='text' name='DOC_DESCRICAO[]' class='form-control'></td><td width='1%'></td><td width='32%' class='style12'><input type='file' name='DOC_ARQUIVO[]' class='form-control'></td><td width='1%'></td><td width='10%' class='style12'><input type='button' onclick='removerCampo_DOC("+qtdeCampos_DOC+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_DOC++;
}
function removerCampo_DOC(id) {
var objPai_DOC = document.getElementById("campoPai_DOC");
var objFilho_DOC = document.getElementById("filho_DOC"+id);
console.log(objPai_DOC); //Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPai_DOC.removeChild(objFilho_DOC);
}

var qtdeCampos_COMPFAM = 0;
function addCampos_COMPFAM() {
var objPai_COMPFAM = document.getElementById("campoPai_COMPFAM"); //Criando o elemento DIV;
var objFilho_COMPFAM = document.createElement("div"); //Definindo atributos ao objFilho:
objFilho_COMPFAM.setAttribute("id","filho_COMPFAM"+qtdeCampos_COMPFAM); //Inserindo o elemento no pai:
objPai_COMPFAM.appendChild(objFilho_COMPFAM); //Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filho_COMPFAM"+qtdeCampos_COMPFAM).innerHTML = "<table width='100%'><tr><td width='44%'><input type='text' name='COMPFAM_NOME[]' class='form-control' id='exampleInput' placeholder='Digite o nome do componente...'></td><td width='1%'></td><td width='29%'><select name='COMPFAM_PARENTESCO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um tipo de parentesco...</option><?php while ($vetor_PARENTESCOS=mysql_fetch_array($sql_PARENTESCOS)) { ?><option value='<?php echo  $vetor_PARENTESCOS[ID]; ?>'><?php echo $vetor_PARENTESCOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='14%'><select name='COMPFAM_RESIDENTE[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione uma opção...</option><option value='1'>SIM</option><option value='2'>NÃO</option><option value='0'>N/I</option></select></td><td width='1%'></td><td width='10%'><input type='button' onclick='removerCampo_COMPFAM("+qtdeCampos_COMPFAM+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COMPFAM++;
}
function removerCampo_COMPFAM(id) {
var objPai_COMPFAM = document.getElementById("campoPai_COMPFAM");
var objFilho_COMPFAM = document.getElementById("filho_COMPFAM"+id);
console.log(objPai_COMPFAM); //Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPai_COMPFAM.removeChild(objFilho_COMPFAM);
}

var qtdeCampos_SOCIAL = 0;
function addCampos_SOCIAL() {
var objPai_SOCIAL = document.getElementById("campoPai_SOCIAL"); //Criando o elemento DIV;
var objFilho_SOCIAL = document.createElement("div"); //Definindo atributos ao objFilho:
objFilho_SOCIAL.setAttribute("id","filho_SOCIAL"+qtdeCampos_SOCIAL); //Inserindo o elemento no pai:
objPai_SOCIAL.appendChild(objFilho_SOCIAL); //Escrevendo algo no filho recém-criado:
document.getElementById("filho_SOCIAL"+qtdeCampos_SOCIAL).innerHTML = "<table width='100%'><tr><td width='10%'><label class='form-label semibold'>Data do Encaminhamento:</label><input type='text' name='SOCIAL_DATA[]' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10' id='SOCIAL_DATA[]' placeholder='Digite as data...'></td><td width='2%'></td><td width='64%'><label class='form-label semibold'>Detalhamento:</label><textarea rows='3' name='SOCIAL_DESCRICAO[]' class='form-control' id='SOCIAL_DESCRICAO[]' placeholder='Digite o detalhamento da situação...'></textarea></td><td width='2%'></td><td width='10%'><label class='form-label semibold'>Concluída?</label><select name='SOCIAL_CONCLUIDA[]' id='SOCIAL_CONCLUIDA[]' class='form-control'><option value='1'>SIM</option><option value='2' selected='selected'>NÃO</option></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_SOCIAL("+qtdeCampos_SOCIAL+")' value='Remover' class='btn btn-inline'></td></tr></table><table width='100%'><tr><td width='49%'><label class='form-label semibold'>Encaminhamento Proposto:</label><textarea rows='2' name='SOCIAL_ENCAMINHAMENTO[]' class='form-control' id='SOCIAL_ENCAMINHAMENTO[]' placeholder='Digite o encaminhamento proposto...'></textarea></td><td width='2%'></td><td width='49%'><label class='form-label semibold'>Retorno do Encaminhamento:</label><textarea rows='2' name='SOCIAL_RETORNO[]' class='form-control' id='SOCIAL_RETORNO[]' placeholder='Digite o retorno do encaminhamento...'></textarea></td></tr></table><hr>";
qtdeCampos_SOCIAL++;
}
function removerCampo_SOCIAL(id) {
var objPai_SOCIAL = document.getElementById("campoPai_SOCIAL");
var objFilho_SOCIAL = document.getElementById("filho_SOCIAL"+id);
console.log(objPai_SOCIAL); //Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPai_SOCIAL.removeChild(objFilho_SOCIAL);
}

var qtdeCampos_IMAGEMSOC = 0;
function addCampos_IMAGEMSOC() {
var objPai_IMAGEMSOC = document.getElementById("campoPai_IMAGEMSOC");
//Criando o elemento DIV;
var objFilho_IMAGEMSOC = document.createElement("div");
//Definindo atributos ao objFilho:
objFilho_IMAGEMSOC.setAttribute("id","filho_IMAGEMSOC"+qtdeCampos_IMAGEMSOC);
//Inserindo o elemento no pai:
objPai_IMAGEMSOC.appendChild(objFilho_IMAGEMSOC);
//Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filho_IMAGEMSOC"+qtdeCampos_IMAGEMSOC).innerHTML = "<table width='100%' border='0'><tr><td width='10%'><input type='text' name='IMAGEMSOC_DATA[]' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10' id='IMAGEMSOC_DATA[]' placeholder='Digite as data...'></td><td width='2%'></td><td width='40%'><input type='text' name='IMAGEMSOC_LEGENDA[]' id='IMAGEMSOC_LEGENDA[]' class='form-control'></td><td width='2%'></td><td width='34%'><input type='file' name='IMAGEMSOC_NOME[]' id='IMAGEMSOC_NOME[]' class='form-control'></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_IMAGEMSOC("+qtdeCampos_IMAGEMSOC+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_IMAGEMSOC++;
}
function removerCampo_IMAGEMSOC(id) {
var objPai_IMAGEMSOC = document.getElementById("campoPai_IMAGEMSOC");
var objFilho_IMAGEMSOC = document.getElementById("filho_IMAGEMSOC"+id);
console.log(objPai_IMAGEMSOC);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPai_IMAGEMSOC.removeChild(objFilho_IMAGEMSOC);
}
</script>
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
							<h3>Gestão do Projetos 4.1.5 e 4.2.1 e Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Famílias de ATES e Reparação Rural - v 1.0.4.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_alterar_familias.php?id_familia=<?php echo $id_familia; ?>" method="post" name="familias" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Número C/C:</label>
                            <input type="text" name="FAMILIA_NUMERO" class="form-control" id="exampleInput" placeholder="Digite o númeroCS C4 da C/C..." value="<?php echo $vetor_FAMILIA['FAMILIA_NUMERO']; ?>">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInputEmail1">Processo Fundiário:</label>
                            <input type="text" name="FAMILIA_FUNDIARIO" class="form-control" id="exampleInput" placeholder="Digite o processo fundiário..." value="<?php echo $vetor_FAMILIA['FAMILIA_FUNDIARIO']; ?>">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInputEmail1">Tipo de Benefício/Grupo:</label>
                            <select name="FAMILIA_BENEFICIO" id="exampleSelect" class="form-control">
								<?php while ($vetor_BENEFICIOS=mysql_fetch_array($sql_BENEFICIOS)) { ?>
                                <option label="<?php echo $vetor_BENEFICIOS['DESCRICAO']; ?>" value="<?php echo $vetor_BENEFICIOS['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FAMILIA_BENEFICIO'], $vetor_BENEFICIOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_BENEFICIOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Número C/C/Processo Fundiário/Tipo de Benefício/Grupo -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInputEmail1">Benefíciario:</label>
                            <input type="text" name="FAMILIA_BENEFICIARIO" class="form-control" id="exampleInput" placeholder="Digite o nome do benefíciario..." value="<?php echo $vetor_FAMILIA['FAMILIA_BENEFICIARIO']; ?>">
                         </div>	
                    </div> <!-- Benefíciario -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Local de Origem:</label>
                            <input type="text" name="FAMILIA_LOCALORIGEM" class="form-control" id="exampleInput" placeholder="Digite a localidade de origem..." value="<?php echo $vetor_FAMILIA['FAMILIA_LOCALORIGEM']; ?>">
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Local de Destino:</label>
                            <input type="text" name="FAMILIA_LOCALDESTINO" class="form-control" id="exampleInput" placeholder="Digite a localidade de destino..." value="<?php echo $vetor_FAMILIA['FAMILIA_LOCALDESTINO']; ?>">
                        </div>
                    </div> <!-- Local de Origem/Local de Destino -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Município de Destino:</label>
                            <select name="FAMILIA_MUNICIPIODESTINO" id="exampleSelect" class="form-control">
								<?php while ($vetor_MUNICIPIOS=mysql_fetch_array($sql_MUNICIPIOS)) { ?>
                                <option label="<?php echo $vetor_MUNICIPIOS['DESCRICAO']; ?>" value="<?php echo $vetor_MUNICIPIOS['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FAMILIA_MUNICIPIODESTINO'], $vetor_MUNICIPIOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_MUNICIPIOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
							<label class="form-label semibold" for="exampleInputEmail1">Setor de Atendimento:</label>
                            <select name="FAMILIA_SETORATEND" id="exampleSelect" class="form-control">
								<?php while ($vetor_SETETORATEND=mysql_fetch_array($sql_SETETORATEND)) { ?>
                                <option label="<?php echo $vetor_SETETORATEND['DESCRICAO']; ?>" value="<?php echo $vetor_SETETORATEND['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FAMILIA_SETORATEND'], $vetor_SETETORATEND['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_SETETORATEND['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Município de Destino/Setor de Atendimento -->
                    <div class="form-group row">
                        <div class="col-lg-3">
							<label class="form-label semibold" for="exampleInput">Telefones:</label>
                            <input type="text" name="FAMILIA_TELEFONES" class="form-control" id="exampleInput" placeholder="Digite os telefones de contato..." value="<?php echo $vetor_FAMILIA['FAMILIA_TELEFONES']; ?>">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Coordenadas UTM E:</label>
                            <input type="text" name="FAMILIA_UTME" class="form-control" id="exampleInput" placeholder="Digite as coordenadas UTM E..." value="<?php echo $vetor_FAMILIA['FAMILIA_UTME']; ?>">
						</div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Coordenadas UTM N:</label>
                            <input type="text" name="FAMILIA_UTMN" class="form-control" id="exampleInput" placeholder="Digite as coordenadas UTM N..." value="<?php echo $vetor_FAMILIA['FAMILIA_UTMN']; ?>">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Fuso das Coordenadas:</label>
                            <select name="FAMILIA_FUSOGEO" id="exampleSelect" class="form-control">
								<?php while ($vetor_FUSOS=mysql_fetch_array($sql_FUSOS)) { ?>
                                <option label="<?php echo $vetor_FUSOS['DESCRICAO']; ?>" value="<?php echo $vetor_FUSOS['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FAMILIA_FUSOGEO'], $vetor_FUSOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_FUSOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Telefones/Coordenadas UTM E/Coordenadas UTM N/Fuso das Coordenadas -->
                    <div class="form-group row">
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Familia Residente?</label>
                            <select name="FAMILIA_RESIDENTE" id="exampleSelect" class="form-control">
                            	<option label="SIM" value="1" <?php if (strcasecmp($vetor_FAMILIA['FAMILIA_RESIDENTE'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_FAMILIA['FAMILIA_RESIDENTE'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                <option label="NÃO INFORMADO (N/I)" value="0" <?php if (strcasecmp($vetor_FAMILIA['FAMILIA_RESIDENTE'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Técnico Responsável:</label>
                            <select name="FAMILIA_TECNICO" id="exampleSelect" class="form-control">
                            	<?php while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) { ?>
                                <option label="<?php echo $vetor_TECNICOS['DESCRICAO']; ?>" value="<?php echo $vetor_TECNICOS['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FAMILIA_TECNICO'], $vetor_TECNICOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TECNICOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Grupo Semanal:</label>
                            <select name="FAMILIA_GRUPO" id="exampleSelect" class="form-control">
                            	<?php while ($vetor_GRUPOS=mysql_fetch_array($sql_GRUPOS)) { ?>
                                <option label="<?php echo $vetor_GRUPOS['DESCRICAO']; ?>" value="<?php echo $vetor_GRUPOS['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FAMILIA_GRUPO'], $vetor_GRUPOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_GRUPOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Familia Residente?/Técnico Responsável/Grupos Semanal -->
					</br>
                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
				</form>
			</div><!--.box-typical-->
   			<div class="box-typical box-typical-padding">
                	<div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">Dados Gerais</a></li>
                            <li><a href="#view6">Composição Familiar</a></li>
                            <li><a href="#view2">Saldo Remanescente</a></li>
                            <li><a href="#view5">Dados Ribeirinhos</a></li>
                            <li><a href="#view3">Eventos</a></li>
                            <li><a href="#view7">Atend. Social</a></li>
                            <li><a href="#view4">Documentos</a></li>
                            <?php
								if ($num_EMATER > 0) { ?>
                            	<li><a href="#view8">EMATER</a></li>
                            <?php
								}
							?>
                        </ul>
                        <div class="tabcontents">
                            <div id="view1">
                                <form action="recebe_alterar_dadosgerais.php?id_familia=<?php echo $id_familia; ?>" method="post" name="dadosgerais" enctype="multipart/form-data" id="formID">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Lote:</label>
                                            <input type="text" name="DADOS_LOTERRC" class="form-control" id="exampleInput" placeholder="Digite o número do lote do RRC..." value="<?php echo $vetor_DADOSGERAIS['DADOS_LOTERRC']; ?>">
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Família Vulnerável?</label>
                                            <select name="DADOS_VULNERAVEL" id="exampleSelect" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_VULNERAVEL'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_VULNERAVEL'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                                <option label="NÃO INFORMADO (N/I)" value="0" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_VULNERAVEL'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInputEmail1">Família Indígena?</label>
                                            <select name="DADOS_INDIGENA" id="exampleSelect" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_INDIGENA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_INDIGENA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                                <option label="NÃO INFORMADO (N/I)" value="0" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_INDIGENA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                            </select>
                                        </div>
                                    </div> <!-- Lote RRC/Família Vulnerável?/Família Indígena? -->

                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInputEmail1">Atendido pelo 4.2.1?</label>
                                            <select name="DADOS_ATEND421" id="exampleSelect" class="form-control">
                                            	<?php while ($vetor_TPATENDIMENTO421=mysql_fetch_array($sql_TPATENDIMENTO421)) { ?>
                                                <option label="<?php echo $vetor_TPATENDIMENTO421['DESCRICAO']; ?>" value="<?php echo $vetor_TPATENDIMENTO421['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_ATEND421'], $vetor_TPATENDIMENTO421['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPATENDIMENTO421['DESCRICAO']; ?></option>
                                                <?php } ?>
                                             </select>
                                        </div> <!-- ATENDIDO PELO 4.2.1.-->
                                        <div class="col-lg-8">
											<label class="form-label semibold" for="exampleInputEmail1">Motivo do Não Atendimento:</label>
                                            <select name="DADOS_MOTIVO421" id="exampleSelect" class="form-control">
												<?php while ($vetor_MTATENDIMENTO421=mysql_fetch_array($sql_MTATENDIMENTO421)) { ?>
                                                <option label="<?php echo $vetor_MTATENDIMENTO421['DESCRICAO']; ?>" value="<?php echo $vetor_MTATENDIMENTO421['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_MOTIVO421'], $vetor_MTATENDIMENTO421['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_MTATENDIMENTO421['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- Atendido pelo 4.2.1/Motivo do Não Atendimento -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
											<label class="form-label semibold" for="exampleInputEmail1">Observações sobre Atendimento do 4.2.1:</label>
                                            <input type="text" name="DADOS_OBS421" class="form-control" id="exampleInput" placeholder="Digite as observações sobre o motivo do não atendimento pelo projeto 4.2.1..." value="<?php echo $vetor_DADOSGERAIS['DADOS_OBS421']; ?>">
                                        </div>
                                    </div> <!-- Observações sobre Atendimento do 4.2.1 -->
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Data de Entrada (4.2.1):</label>
                                            <input type="text" name="DADOS_DTENTRADA_421" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_DADOSGERAIS['DADOS_DTENTRADA_421'])); ?>">
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Data de Saída (4.2.1):</label>
                                            <input type="text" name="DADOS_DTSAIDA_421" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_DADOSGERAIS['DADOS_DTSAIDA_421'])); ?>">
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInputEmail1">Tipo de PEADS:</label>
                                            <select name="DADOS_PEADS" id="exampleSelect" class="form-control">
												<?php while ($vetor_PEADS=mysql_fetch_array($sql_PEADS)) { ?>
                                                <option label="<?php echo $vetor_PEADS['DESCRICAO']; ?>" value="<?php echo $vetor_PEADS['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_PEADS'], $vetor_PEADS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_PEADS['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- Data de Entrada (4.2.1)/Data de Saída (4.2.1)/PEADS -->
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInputEmail1">Atendido pelo 4.1.5?</label>
                                            <select name="DADOS_ATEND415" id="exampleSelect" class="form-control">
                                            	<?php while ($vetor_TPATENDIMENTO415=mysql_fetch_array($sql_TPATENDIMENTO415)) { ?>
                                                <option label="<?php echo $vetor_TPATENDIMENTO415['DESCRICAO']; ?>" value="<?php echo $vetor_TPATENDIMENTO415['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_ATEND415'], $vetor_TPATENDIMENTO415['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPATENDIMENTO415['DESCRICAO']; ?></option>
                                                <?php } ?>
                                             </select>
                                        </div> <!-- ATENDIDO PELO 4.1.5.-->
                                        <div class="col-lg-8">
											<label class="form-label semibold" for="exampleInputEmail1">Motivo do Não Atendimento:</label>
                                            <select name="DADOS_MOTIVO415" id="exampleSelect" class="form-control">
												<?php while ($vetor_MTATENDIMENTO415=mysql_fetch_array($sql_MTATENDIMENTO415)) { ?>
                                                <option label="<?php echo $vetor_MTATENDIMENTO415['DESCRICAO']; ?>" value="<?php echo $vetor_MTATENDIMENTO415['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_MOTIVO415'], $vetor_MTATENDIMENTO415['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_MTATENDIMENTO415['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- Atendido pelo 4.1.5/Motivo do Não Atendimento -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
											<label class="form-label semibold" for="exampleInputEmail1">Observações sobre Atendimento do 4.1.5:</label>
                                            <input type="text" name="DADOS_OBS415" class="form-control" id="exampleInput" placeholder="Digite as observações sobre o motivo do não atendimento pelo projeto 4.1.5..." value="<?php echo $vetor_DADOSGERAIS['DADOS_OBS415']; ?>">
                                        </div>
                                    </div> <!-- Observações sobre Atendimento do 4.1.5 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Data de Entrada (4.1.5):</label>
                                            <input type="text" name="DADOS_DTENTRADA_415" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_DADOSGERAIS['DADOS_DTENTRADA_415'])); ?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Data de Saída (4.1.5):</label>
                                            <input type="text" name="DADOS_DTSAIDA_415" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_DADOSGERAIS['DADOS_DTSAIDA_415'])); ?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInputEmail1">Tipo de Projeto (4.1.5):</label>
                                            <select name="DADOS_TPPROJ415" id="exampleSelect" class="form-control">
												<?php while ($vetor_TPPROJETO=mysql_fetch_array($sql_TPPROJETO)) { ?>
                                                <option label="<?php echo $vetor_TPPROJETO['DESCRICAO']; ?>" value="<?php echo $vetor_TPPROJETO['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_TPPROJ415'], $vetor_TPPROJETO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPPROJETO['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInputEmail1">Status do Projeto (4.1.5):</label>
                                            <select name="DADOS_SITPROJ415" id="exampleSelect" class="form-control">
												<?php while ($vetor_STPROJETO=mysql_fetch_array($sql_STPROJETO)) { ?>
                                                <option label="<?php echo $vetor_STPROJETO['DESCRICAO']; ?>" value="<?php echo $vetor_STPROJETO['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_SITPROJ415'], $vetor_STPROJETO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROJETO['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- Data de Entrada (4.1.5)/Data de Saída (4.1.5)/Tipo de Projeto (4.1.5)/Status do Projeto (4.1.5) -->
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInputEmail1">Atendido como Ribeirinho?</label>
                                            <select name="DADOS_ATENDRIR" id="exampleSelect" class="form-control">
                                            	<?php while ($vetor_TPATENDIMENTORIR=mysql_fetch_array($sql_TPATENDIMENTORIR)) { ?>
                                                <option label="<?php echo $vetor_TPATENDIMENTORIR['DESCRICAO']; ?>" value="<?php echo $vetor_TPATENDIMENTORIR['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_ATENDRIR'], $vetor_TPATENDIMENTORIR['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPATENDIMENTORIR['DESCRICAO']; ?></option>
                                                <?php } ?>
                                             </select>
                                        </div> <!-- ATENDIDO PELO Ribeirinhos-->
                                        <div class="col-lg-8">
											<label class="form-label semibold" for="exampleInputEmail1">Motivo do Não Atendimento:</label>
                                            <select name="DADOS_MOTIVORIR" id="exampleSelect" class="form-control">
												<?php while ($vetor_MTATENDIMENTORIR=mysql_fetch_array($sql_MTATENDIMENTORIR)) { ?>
                                                <option label="<?php echo $vetor_MTATENDIMENTORIR['DESCRICAO']; ?>" value="<?php echo $vetor_MTATENDIMENTORIR['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_MOTIVORIR'], $vetor_MTATENDIMENTORIR['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_MTATENDIMENTORIR['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- Atendido como Ribeirinho/Motivo do Não Atendimento -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
											<label class="form-label semibold" for="exampleInputEmail1">Observações sobre Atendimento como Ribeirinho:</label>
                                            <input type="text" name="DADOS_OBSRIR" class="form-control" id="exampleInput" placeholder="Digite as observações sobre o motivo do não atendimento como Ribeirinho..." value="<?php echo $vetor_DADOSGERAIS['DADOS_OBSRIR']; ?>">
                                        </div>
                                    </div> <!-- Observações sobre Atendimento como Ribeirinho -->
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInputEmail1">Tipo de Projeto no P.O.:</label>
                                            <select name="DADOS_TPPROJRIR" id="exampleSelect" class="form-control">
												<?php while ($vetor_TPPROJETO_RIR=mysql_fetch_array($sql_TPPROJETO_RIR)) { ?>
                                                <option label="<?php echo $vetor_TPPROJETO_RIR['DESCRICAO']; ?>" value="<?php echo $vetor_TPPROJETO_RIR['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_TPPROJRIR'], $vetor_TPPROJETO_RIR['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPPROJETO_RIR['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInputEmail1">Status do Projeto no P.O.:</label>
                                            <select name="DADOS_SITPROJRIR" id="exampleSelect" class="form-control">
												<?php while ($vetor_STPROJETO_RIR=mysql_fetch_array($sql_STPROJETO_RIR)) { ?>
                                                <option label="<?php echo $vetor_STPROJETO_RIR['DESCRICAO']; ?>" value="<?php echo $vetor_STPROJETO_RIR['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_SITPROJRIR'], $vetor_STPROJETO_RIR['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROJETO_RIR['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInputEmail1">Aviário Implantado?</label>
                                            <select name="DADOS_RIR_AVIARIO" id="exampleSelect" class="form-control">
												<?php while ($vetor_STPROJETO_RIR_AVI=mysql_fetch_array($sql_STPROJETO_RIR_AVI)) { ?>
                                                <option label="<?php echo $vetor_STPROJETO_RIR_AVI['DESCRICAO']; ?>" value="<?php echo $vetor_STPROJETO_RIR_AVI['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_AVIARIO'], $vetor_STPROJETO_RIR_AVI['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROJETO_RIR_AVI['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- Tipo de Projeto Ribeirinho / Status do Projeto Ribeirinho / Aviário Implantado -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInputEmail1">Viveiro Implantado?</label>
                                            <select name="DADOS_RIR_VIVEIRO" id="exampleSelect" class="form-control">
												<?php while ($vetor_STPROJETO_RIR_VIV=mysql_fetch_array($sql_STPROJETO_RIR_VIV)) { ?>
                                                <option label="<?php echo $vetor_STPROJETO_RIR_VIV['DESCRICAO']; ?>" value="<?php echo $vetor_STPROJETO_RIR_VIV['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_VIVEIRO'], $vetor_STPROJETO_RIR_VIV['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROJETO_RIR_VIV['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInputEmail1">Roça Implantada?</label>
                                            <select name="DADOS_RIR_ROCA" id="exampleSelect" class="form-control">
												<?php while ($vetor_STPROJETO_RIR_ROC=mysql_fetch_array($sql_STPROJETO_RIR_ROC)) { ?>
                                                <option label="<?php echo $vetor_STPROJETO_RIR_ROC['DESCRICAO']; ?>" value="<?php echo $vetor_STPROJETO_RIR_ROC['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_ROCA'], $vetor_STPROJETO_RIR_ROC['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROJETO_RIR_ROC['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInputEmail1">Fossa  Implantada?</label>
                                            <select name="DADOS_RIR_FOSSA" id="exampleSelect" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_FOSSA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_FOSSA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                                <option label="NÃO INFORMADO (N/I)" value="0" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_FOSSA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInputEmail1">Filtro Entregue?</label>
                                            <select name="DADOS_RIR_FILTRO" id="exampleSelect" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_FILTRO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_FILTRO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                                <option label="NÃO INFORMADO (N/I)" value="0" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_FILTRO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                            </select>
                                        </div>
                                    </div> <!-- Viveiro, Roça, Fossa e Filtro Implantados? -->

                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="DADOS_RIR_CASAFARINHA">Casa de Farinha Implantada?</label>
                                            <select name="DADOS_RIR_CASAFARINHA" id="DADOS_RIR_CASAFARINHA" class="form-control">
												<?php while ($vetor_STPROJETO_RIR_CASAFAR=mysql_fetch_array($sql_STPROJETO_RIR_CASAFAR)) { ?>
                                                <option value="<?php echo $vetor_STPROJETO_RIR_CASAFAR['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_CASAFARINHA'], $vetor_STPROJETO_RIR_CASAFAR['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROJETO_RIR_CASAFAR['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="DADOS_RIR_BARCACA">Barcaça Implantada?</label>
                                            <select name="DADOS_RIR_BARCACA" id="DADOS_RIR_BARCACA" class="form-control">
												<?php while ($vetor_STPROJETO_RIR_BARCACA=mysql_fetch_array($sql_STPROJETO_RIR_BARCACA)) { ?>
                                                <option value="<?php echo $vetor_STPROJETO_RIR_BARCACA['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_BARCACA'], $vetor_STPROJETO_RIR_BARCACA['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROJETO_RIR_BARCACA['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="DADOS_RIR_GALPAO">Galpão Implantado?</label>
                                            <select name="DADOS_RIR_GALPAO" id="DADOS_RIR_GALPAO" class="form-control">
												<?php while ($vetor_STPROJETO_RIR_GALPAO=mysql_fetch_array($sql_STPROJETO_RIR_GALPAO)) { ?>
                                                <option value="<?php echo $vetor_STPROJETO_RIR_GALPAO['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_GALPAO'], $vetor_STPROJETO_RIR_GALPAO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROJETO_RIR_GALPAO['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="DADOS_RIR_AVIARIO2CICLO">Aviário 2º Ciclo Implantado?</label>
                                            <select name="DADOS_RIR_AVIARIO2CICLO" id="DADOS_RIR_AVIARIO2CICLO" class="form-control">
												<?php while ($vetor_STPROJETO_RIR_AVI2CIC=mysql_fetch_array($sql_STPROJETO_RIR_AVI2CIC)) { ?>
                                                <option value="<?php echo $vetor_STPROJETO_RIR_AVI2CIC['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_RIR_AVIARIO2CICLO'], $vetor_STPROJETO_RIR_AVI2CIC['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROJETO_RIR_AVI2CIC['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
									</div> <!-- Aviários 2ºCiclo, Casa de Farinha, Galpão e Barcaça Implantados? -->
									
									<div class="form-group row">
                                        <div class="col-lg-4">
                                            <label class="form-label semibold" for="exampleInputEmail1">CAR Emitido?</label>
                                            <select name="DADOS_CAR" id="exampleSelect" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_CAR'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_CAR'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                                <option label="NÃO INFORMADO (N/I)" value="0" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_CAR'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-8">
											<label class="form-label semibold" for="exampleInputEmail1">Status do Processo do CAR:</label>
                                            <select name="DADOS_CAR_STATUS" id="exampleSelect" class="form-control">
												<?php while ($vetor_STPROCESSO_CAR=mysql_fetch_array($sql_STPROCESSO_CAR)) { ?>
                                                <option label="<?php echo $vetor_STPROCESSO_CAR['DESCRICAO']; ?>" value="<?php echo $vetor_STPROCESSO_CAR['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_CAR_STATUS'], $vetor_STPROCESSO_CAR['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROCESSO_CAR['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- CAR Emitido?/Status do Processo do CAR -->
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label class="form-label semibold" for="exampleInputEmail1">DAP Emitido?</label>
                                            <select name="DADOS_DAP" id="exampleSelect" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_DAP'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_DAP'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                                <option label="NÃO INFORMADO (N/I)" value="0" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_DAP'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-8">
											<label class="form-label semibold" for="exampleInputEmail1">Status do Processo do DAP:</label>
                                            <select name="DADOS_DAP_STATUS" id="exampleSelect" class="form-control">
												<?php while ($vetor_STPROCESSO_DAP=mysql_fetch_array($sql_STPROCESSO_DAP)) { ?>
                                                <option label="<?php echo $vetor_STPROCESSO_DAP['DESCRICAO']; ?>" value="<?php echo $vetor_STPROCESSO_DAP['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_DAP_STATUS'], $vetor_STPROCESSO_DAP['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROCESSO_DAP['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- DAP Emitido?/Status do Processo do DAP -->
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label class="form-label semibold" for="exampleInputEmail1">DLA Emitido?</label>
                                            <select name="DADOS_DLA" id="exampleSelect" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_DLA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_DLA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                                <option label="NÃO INFORMADO (N/I)" value="0" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_DLA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-8">
											<label class="form-label semibold" for="exampleInputEmail1">Status do Processo do DLA:</label>
                                            <select name="DADOS_DLA_STATUS" id="exampleSelect" class="form-control">
												<?php while ($vetor_STPROCESSO_DLA=mysql_fetch_array($sql_STPROCESSO_DLA)) { ?>
                                                <option label="<?php echo $vetor_STPROCESSO_DLA['DESCRICAO']; ?>" value="<?php echo $vetor_STPROCESSO_DLA['ID']; ?>" <?php if (strcasecmp($vetor_DADOSGERAIS['DADOS_DLA_STATUS'], $vetor_STPROCESSO_DLA['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STPROCESSO_DLA['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- DLA Emitido?/Status do Processo do DLA -->
                                    </br>
                                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
                                </form>
                            </div> <!-- Dados Gerais -->
    
                            <div id="view2">
                                <form action="recebe_alterar_dadossaldo.php?id_familia=<?php echo $id_familia; ?>" method="post" name="dadossaldo" enctype="multipart/form-data" id="formID">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Data de Aquisição do Imóvel:</label>
                                            <input type="text" name="SALDO_DATAAQUISICAO" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_DADOSSALDO['SALDO_DATAAQUISICAO'])); ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label semibold" for="exampleInputEmail1">Possuí Saldo Remanescente?</label>
                                            <select name="SALDO_POSSUISALDO" id="exampleSelect" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOSSALDO['SALDO_POSSUISALDO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_DADOSSALDO['SALDO_POSSUISALDO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                                <option label="NÃO INFORMADO (N/I)" value="0" <?php if (strcasecmp($vetor_DADOSSALDO['SALDO_POSSUISALDO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Valor do Saldo (R$):</label>
                                            <input type="text" name="SALDO_VALOR" class="form-control" id="exampleInput" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo $vetor_DADOSSALDO['SALDO_VALOR']; ?>">
                                        </div>
                                    </div> <!-- Data de Aquisição do Imóvel/Possuí Saldo Remanescente?/Valor do Saldo (R$) -->
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Data da 1ª Parcela:</label>
                                            <input type="text" name="SALDO_DTPARC_01" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_DADOSSALDO['SALDO_DTPARC_01'])); ?>">
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Data da 2ª Parcela:</label>
                                            <input type="text" name="SALDO_DTPARC_02" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_DADOSSALDO['SALDO_DTPARC_02'])); ?>">
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Data da 3ª Parcela:</label>
                                            <input type="text" name="SALDO_DTPARC_03" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_DADOSSALDO['SALDO_DTPARC_03'])); ?>">
                                        </div>
                                    </div> <!-- Data da 1ª Parcela/Data da 2ª Parcela/Data da 3ª Parcela -->
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Data da Aplicação:</label>
                                            <input type="text" name="SALDO_DATAPLAPLIC" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_DADOSSALDO['SALDO_DATAPLAPLIC'])); ?>">
                                        </div>
                                        <div class="col-lg-8">
											<label class="form-label semibold" for="exampleInputEmail1">Status do Saldo Remanescente:</label>
                                            <select name="SALDO_STATUS" id="exampleSelect" class="form-control">
												<?php while ($vetor_STSALDO=mysql_fetch_array($sql_STSALDO)) { ?>
                                                <option label="<?php echo $vetor_STSALDO['DESCRICAO']; ?>" value="<?php echo $vetor_STSALDO['ID']; ?>" <?php if (strcasecmp($vetor_DADOSSALDO['SALDO_STATUS'], $vetor_STSALDO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STSALDO['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- Data da Aplicação/Status do Saldo Remanescente -->
                                    </br>
                                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
                                </form>
                            </div> <!-- Saldo Remanescente -->
    
                            <div id="view3">
                                <div id="scroll">
                                    <form action="recebe_cadastrar_eventos.php?id_familia=<?php echo $id_familia; ?>" method="post" name="eventos" enctype="multipart/form-data" id="formID">
                                        <table width="100%">
                                          <tr align="center" bgcolor="#0D0C9B" >
                                            <td width="110px"><strong><font color="#FFFFFF">Data do Evento</font></strong></td>
                                            <td width="3px"></td>
                                            <td width="250px"><strong><font color="#FFFFFF">Tipo do Evento</font></strong></td>
                                            <td width="3px"></td>
                                            <td width="400px"><strong><font color="#FFFFFF">Observações</font></strong></td>
                                            <td width="3px"></td>
                                            <td width="100px">&nbsp;</td>
                                          </tr>
                                        </table>
                                        <div id="campoPai_EVENTO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                                        </br>
    	                                <input type="button" value="Novo Evento" onClick="addCampos_EVENTO()" class="btn btn-inline">
										<input type="submit" value="Salvar Eventos" class="btn btn-inline">
                                    </form>
                                    </br>
                                    </br>
                                    <table width="100%">
                                        <tr align="center" bgcolor="#0D0C9B">
                                            <td width="110px"><strong><font color="#FFFFFF">Data do Evento</font></strong></td>
                                            <td width="3px"></td>
                                            <td width="250px"><strong><font color="#FFFFFF">Tipo de Evento</font></strong></td>
                                            <td width="3px"></td>
                                            <td width="400px"><strong><font color="#FFFFFF">Observações</font></strong></td>
                                            <td width="3px"></td>
                                            <td width="100px"><strong><font color="#FFFFFF">Ações</font></strong></td>
                                        </tr>
										<?php 
											$sql_EVENTOS = mysql_query("select a.*, b.DESCRICAO as EVENTOS_TIPO_DESC from TAB_415421_EVENTOS a, TAB_APOIO_EVENTOS b where a.EVENTOS_TIPO = b.ID and a.FAMILIA_CODIGO = '$id_familia' order by a.EVENTOS_DATA DESC;", $db);
											$cor = "#D8D8D8";
											while ($vetor_EVENTOS=mysql_fetch_array($sql_EVENTOS)) {
												if (strcasecmp($cor, "#FFFFFF") == 0){
													$cor = "#D8D8D8";
												} else {
													$cor = "#FFFFFF";
												}
										?>
                                        <tr bgcolor="<?php echo $cor; ?>">
                                            <td width="110px" align="center"><?php echo date('d/m/Y', strtotime($vetor_EVENTOS['EVENTOS_DATA'])); ?></td>
                                            <td width="3px"></td>
                                            <td width="250px"><?php echo $vetor_EVENTOS['EVENTOS_TIPO_DESC']; ?></td>
                                            <td width="3px"></td>
                                            <td width="400px"><?php echo $vetor_EVENTOS['EVENTOS_OBSERVACOES']; ?></td>
                                            <td width="3px"></td>
                                            <td width="100px" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('cadastrar_dados_eventos.php?id_evento=<?php echo $vetor_EVENTOS["EVENTOS_CODIGO"];?>&id_familia=<?php echo $id_familia;?>','Dados do Evento', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_eventos.php?id_evento=<?php echo $vetor_EVENTOS['EVENTOS_CODIGO']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="relatorio_evento.php?id_evento=<?php echo $vetor_EVENTOS['EVENTOS_CODIGO']; ?>" target="_blank"><img src="imgs/imprimir.png" width="25" height="25" border="0"></a></td>
                                        </tr>
                                        <?php } ?>
									</table>
								</div>                                
                            </div> <!-- Eventos -->
    
                            <div id="view4">
                                <div id="scroll">
                                    <form action="recebe_cadastrar_documentos.php?id_familia=<?php echo $id_familia; ?>" method="post" name="documentos" enctype="multipart/form-data" id="formID">
                                        <table width="100%">
                                          <tr align="center" bgcolor="#0D0C9B" >
                                            <td width="15%"><strong><font color="#FFFFFF">Data</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="40%"><strong><font color="#FFFFFF">Descrição</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="32%"><strong><font color="#FFFFFF">Arquivo</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="10%">&nbsp;</td>
                                          </tr>
                                        </table>
                                        <div id="campoPai_DOC"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                                        </br>
    	                                <input type="button" value="Novo Documento" onClick="addCampos_DOC()" class="btn btn-inline">
										<input type="submit" value="Salvar Documentos" class="btn btn-inline">
                                    </form>
                                    </br>
                                    </br>
                                    <table width="100%">
                                        <tr align="center" bgcolor="#0D0C9B">
                                            <td width="15%"><strong><font color="#FFFFFF">Data</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="40%"><strong><font color="#FFFFFF">Descrição</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="32%"><strong><font color="#FFFFFF">Anexo</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="10%"><strong><font color="#FFFFFF">Ações</font></strong></td>
                                        </tr>
										<?php 
											$sql_DOC = mysql_query("select * from TAB_415421_DOCUMENTOS where FAMILIA_CODIGO = '$id_familia' order by DOC_DATA DESC;", $db);
											$cor = "#D8D8D8";
											while ($vetor_DOC=mysql_fetch_array($sql_DOC)) {
												if (strcasecmp($cor, "#FFFFFF") == 0){
													$cor = "#D8D8D8";
												} else {
													$cor = "#FFFFFF";
												}
										?>
                                        <tr bgcolor="<?php echo $cor; ?>">
                                            <td width="15%" align="center"><?php echo date('d/m/Y', strtotime($vetor_DOC['DOC_DATA'])); ?></td>
                                            <td width="1%"></td>
                                            <td width="40%"><?php echo $vetor_DOC['DOC_DESCRICAO']; ?></td>
                                            <td width="1%"></td>
                                            <td width="32%" align="center"><a href="imagens/<?php echo $vetor_DOC['DOC_ARQUIVO']; ?>" target="_blank">Salvar Arquivo</a></td>
                                            <td width="1%"></td>
                                            <td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_excluir_documentos.php?id=<?php echo $vetor_DOC['DOC_CODIGO']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                                        </tr>
                                        <?php } ?>
									</table>
								</div>                                
                            </div> <!-- Documentos -->

                            <div id="view5">
                                <form action="recebe_alterar_caractrir.php?id_familia=<?php echo $id_familia; ?>" method="post" name="caractrir" enctype="multipart/form-data" id="formID">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
											<label class="form-label semibold" for="exampleInput">Processo Fundiário da Família:</label>
                                            <input type="text" name="CARACTRIR_FUNDIARIO" class="form-control" id="exampleInput" placeholder="Digite o número do Processo Fundiário..." value="<?php echo $vetor_CARACTRIR['CARACTRIR_FUNDIARIO']; ?>">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label semibold" for="exampleInputEmail1">Ponto de Ocupação:</label>
                                            <select name="CARACTRIR_PONTOOCUP" id="exampleSelect" class="form-control">
												<?php while ($vetor_PONTOOCUPACAO=mysql_fetch_array($sql_PONTOOCUPACAO )) { ?>
                                                <option label="<?php echo $vetor_PONTOOCUPACAO['POCUP_PROCESSO']; ?>" value="<?php echo $vetor_PONTOOCUPACAO['POCUP_CODIGO']; ?>" <?php if (strcasecmp($vetor_CARACTRIR['CARACTRIR_PONTOOCUP'], $vetor_PONTOOCUPACAO['POCUP_CODIGO']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_PONTOOCUPACAO['POCUP_PROCESSO']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> <!-- Fundiário / Ponto de Ocupação -->
                                    <div class="form-group row">
                                        <div class="col-lg-6">
											<label class="form-label semibold" for="exampleInput">Processo Rural / Tratamento Concedido:</label>
                                            <select name="CARACTRIR_BENEFORIGINAL" id="exampleSelect" class="form-control">
												<?php while ($vetor_BENEFICIO_ORIGINAL=mysql_fetch_array($sql_BENEFICIO_ORIGINAL)) { ?>
                                                <option label="<?php echo $vetor_BENEFICIO_ORIGINAL['DESCRICAO']; ?>" value="<?php echo $vetor_BENEFICIO_ORIGINAL['ID']; ?>" <?php if (strcasecmp($vetor_CARACTRIR['CARACTRIR_BENEFORIGINAL'], $vetor_BENEFICIO_ORIGINAL['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_BENEFICIO_ORIGINAL['DESCRICAO']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
											<label class="form-label semibold" for="exampleInput">Modalidade Ofertada:</label>
                                            <select name="CARACTRIR_BENEFOFERTADO" id="exampleSelect" class="form-control">
												<?php while ($vetor_BENEFICIO_OFERTADO=mysql_fetch_array($sql_BENEFICIO_OFERTADO)) { ?>
                                                <option label="<?php echo $vetor_BENEFICIO_OFERTADO['DESCRICAO']; ?>" value="<?php echo $vetor_BENEFICIO_OFERTADO['ID']; ?>" <?php if (strcasecmp($vetor_CARACTRIR['CARACTRIR_BENEFOFERTADO'], $vetor_BENEFICIO_OFERTADO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_BENEFICIO_OFERTADO['DESCRICAO']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> <!-- Benefício Original e Ofertado -->
                                    <div class="form-group row">
                                        <div class="col-lg-8">
											<label class="form-label semibold" for="exampleInput">Endereço do domicílio:</label>
                                            <input type="text" name="CARACTRIR_DOMICILIO" class="form-control" id="exampleInput" placeholder="Digite o endereço completo..." value="<?php echo $vetor_CARACTRIR['CARACTRIR_DOMICILIO']; ?>">
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInputEmail1">Município do domicílio:</label>
                                            <select name="CARACTRIR_MUNICIPIO" id="exampleSelect" class="form-control">
												<?php while ($vetor_MUNICIPIO_DOMICILIO=mysql_fetch_array($sql_MUNICIPIO_DOMICILIO)) { ?>
                                                <option label="<?php echo $vetor_MUNICIPIO_DOMICILIO['DESCRICAO']; ?>" value="<?php echo $vetor_MUNICIPIO_DOMICILIO['ID']; ?>" <?php if (strcasecmp($vetor_CARACTRIR['CARACTRIR_MUNICIPIO'], $vetor_MUNICIPIO_DOMICILIO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_MUNICIPIO_DOMICILIO['DESCRICAO']; ?></option>
                                                <?php } ?>
											</select>
                                        </div>
                                    </div> <!-- Endereço do Domicílio -->
                                    </br>
                                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
                                </form>
                            </div> <!-- Dados Ribeirinhos -->

                            <div id="view6">
                                <div id="scroll">
                                    <form action="recebe_cadastrar_compfam.php?id_familia=<?php echo $id_familia; ?>" method="post" name="compfamiliar" enctype="multipart/form-data" id="formID">
                                        <table width="100%">
                                          <tr align="center" bgcolor="#0D0C9B" >
                                            <td width="44%"><strong><font color="#FFFFFF">Nome</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="29%"><strong><font color="#FFFFFF">Grau de Parentesco</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Residente?</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="10%">&nbsp;</td>
                                          </tr>
                                        </table>
                                        <div id="campoPai_COMPFAM"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                                        </br>
    	                                <input type="button" value="Novo Componente" onClick="addCampos_COMPFAM()" class="btn btn-inline">
										<input type="submit" value="Salvar Componentes" class="btn btn-inline">
                                    </form>
                                    </br>
                                    </br>
                                    <table width="100%">
                                        <tr align="center" bgcolor="#0D0C9B">
                                            <td width="44%"><strong><font color="#FFFFFF">Nome</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="29%"><strong><font color="#FFFFFF">Grau de Parentesco</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Residente?</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="10%"><strong><font color="#FFFFFF">Ações</font></strong></td>
                                        </tr>
										<?php 
											$sql_COMPFAM = mysql_query("select TAB_415421_COMPFAMILIAR.COMPFAM_CODIGO, TAB_415421_COMPFAMILIAR.FAMILIA_CODIGO, TAB_415421_COMPFAMILIAR.COMPFAM_NOME, TAB_APOIO_PARENTESCO.DESCRICAO AS COMPFAM_PARENTESCO_DESC, TAB_APOIO_BOOLEANO.DESCRICAO AS COMPFAM_RESIDENTE_DESC from TAB_415421_COMPFAMILIAR left outer join TAB_APOIO_PARENTESCO ON TAB_415421_COMPFAMILIAR.COMPFAM_PARENTESCO = TAB_APOIO_PARENTESCO.ID left outer join TAB_APOIO_BOOLEANO ON TAB_415421_COMPFAMILIAR.COMPFAM_RESIDENTE = TAB_APOIO_BOOLEANO.ID where  TAB_415421_COMPFAMILIAR.FAMILIA_CODIGO = '$id_familia' order by TAB_415421_COMPFAMILIAR.COMPFAM_NOME asc;", $db);
											$cor = "#D8D8D8";
											while ($vetor_COMPFAM=mysql_fetch_array($sql_COMPFAM)) {
												if (strcasecmp($cor, "#FFFFFF") == 0){
													$cor = "#D8D8D8";
												} else {
													$cor = "#FFFFFF";
												}
										?>
                                        <tr bgcolor="<?php echo $cor; ?>">
                                            <td width="44%"><?php echo $vetor_COMPFAM['COMPFAM_NOME']; ?></td>
                                            <td width="1%"></td>
                                            <td width="29%"><?php echo $vetor_COMPFAM['COMPFAM_PARENTESCO_DESC']; ?></td>
                                            <td width="1%"></td>
                                            <td width="14%"><?php echo $vetor_COMPFAM['COMPFAM_RESIDENTE_DESC']; ?></td>
                                            <td width="1%"></td>
                                            
                                            <td width="10%" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('cadastrar_dados_compfam.php?id_compfam=<?php echo $vetor_COMPFAM["COMPFAM_CODIGO"];?>&id_familia=<?php echo $id_familia;?>','Dados do Componente Familiar', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_compfam.php?id_compfam=<?php echo $vetor_COMPFAM['COMPFAM_CODIGO']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                                        </tr>
                                        <?php } ?>
									</table>
								</div>                                
                            </div> <!-- Composição Familiar -->

                            <?php
								if ($num_EMATER > 0) { ?>
	                            <div id="view8">
                                <form action="recebe_alterar_emater.php?id_familia=<?php echo $id_familia; ?>" method="post" name="emater" enctype="multipart/form-data" id="formID">
                                    <div class="form-group row">
                                    	<h4>Uso da Propriedade</h4>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Reside no Lote?</font></strong></label>
                                            <select name="EMATER_G01_Q01" id="EMATER_G01_Q01" class="form-control">
                                              <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G01_Q01'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G01_Q01'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Produz no Lote?</font></strong></label>
                                            <select name="EMATER_G01_Q02" id="EMATER_G01_Q02" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G01_Q02'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NÃO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G01_Q02'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Grupo 01 -->

                                    <div class="form-group row">
                                    	<h4>O Que Influenciou?</h4>
                                        <div class="col-lg-12">
											<label class="form-label semibold" for="exampleInputEmail1"><strong><font color="#FF0004">De que forma situações ocorridas no decorrer do processo de remanejamento, como: prazos, caracteríticas da propriedade etc, interferiram na recepção da ATES e no desenvolvimento do lote?</font></strong></label>
                                            <input type="text" name="EMATER_G02_Q01" id="EMATER_G02_Q01" class="form-control" placeholder="Digite o texto..." value="<?php echo $vetor_EMATER['EMATER_G02_Q01']; ?>">
                                        </div>
                                        <div class="col-lg-12">
											<label class="form-label semibold" for="exampleInputEmail1"><strong><font color="#FF0004">Quais os fatores objetivos e, de que forma esses fatores influenciaram de forma negativa na renda bruta anual?</font></strong></label>
                                            <input type="text" name="EMATER_G02_Q02" id="EMATER_G02_Q02" class="form-control" placeholder="Digite o texto..." value="<?php echo $vetor_EMATER['EMATER_G02_Q02']; ?>">
                                        </div>
                                    </div> <!-- Grupo 02 -->

                                    <div class="form-group row">
                                    	<h4>Composição da Renda</h4>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">% da Renda proveniente do Lote:</font></strong></label>
                                            <select name="EMATER_G03_Q01" id="EMATER_G03_Q01" class="form-control">
                                              <option label="BAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q01'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXA</option>
                                                <option label="MEDIA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q01'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIA</option>
                                                <option label="ALTA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q01'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTA</option>
                                                <option label="TOTAL" value="4" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q01'],'4') == 0) : ?>selected="selected"<?php endif; ?>>TOTAL</option>
                                                <option label="NENHUMA" value="5" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q01'],'5') == 0) : ?>selected="selected"<?php endif; ?>>NENHUMA</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">% da Renda não proveniente ao Lote:</font></strong></label>
                                            <select name="EMATER_G03_Q02" id="EMATER_G03_Q02" class="form-control">
                                              <option label="BAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q02'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXA</option>
                                                <option label="MEDIA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q02'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIA</option>
                                                <option label="ALTA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q02'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTA</option>
                                                <option label="TOTAL" value="4" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q02'],'4') == 0) : ?>selected="selected"<?php endif; ?>>TOTAL</option>
                                                <option label="NENHUMA" value="5" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q02'],'5') == 0) : ?>selected="selected"<?php endif; ?>>NENHUMA</option>
                                          </select>
                                      </div>
                                    </div> <!-- Grupo 03.01 -->
                                    <div class="form-group row">
                                       <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Faixa de Renda Bruta Anual (R$) (Para fins de Crédito Rural/EMATER):</font></strong></label>
                                            <select name="EMATER_G03_Q03" id="EMATER_G03_Q03" class="form-control">
                                              <option label="INFERIOR" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q03'],'1') == 0) : ?>selected="selected"<?php endif; ?>>Renda Bruta Anual Inferior A R$ 20 mil</option>
                                              <option label="SUPERIOR" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q03'],'2') == 0) : ?>selected="selected"<?php endif; ?>>Renda Bruta Anual Superior A R$ 20 mil</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Faixa de Renda Bruta Anual (R$) (Cálculo de Faixas/Equilíbrio):</font></strong></label>
                                            <select name="EMATER_G03_Q03A" id="EMATER_G03_Q03A" class="form-control">
                                              <option label="MUITOBAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q03A'],'1') == 0) : ?>selected="selected"<?php endif; ?>>Muito Baixa</option>
                                              <option label="BAIXA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q03A'],'2') == 0) : ?>selected="selected"<?php endif; ?>>Baixa</option>
                                              <option label="MEDIA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q03A'],'3') == 0) : ?>selected="selected"<?php endif; ?>>Média</option>
                                              <option label="ALTA" value="4" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q03A'],'4') == 0) : ?>selected="selected"<?php endif; ?>>Alta</option>
                                              <option label="MUITOALTA" value="5" <?php if (strcasecmp($vetor_EMATER['EMATER_G03_Q03A'],'5') == 0) : ?>selected="selected"<?php endif; ?>>Muito Alta</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Valor da Renda Bruta Anual (R$):</font></strong></label>
                                            <input type="text" name="EMATER_G03_Q04" id="EMATER_G03_Q04" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G03_Q04'],2,',','.'); ?>">
                                        </div>
                                    </div> <!-- Grupo 03.02 -->
                                    
                                    <div class="form-group row">
                                    	<h4>Composição da Renda Externa</h4>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Acesso a Benefícios de Transferência de Renda?</font></strong></label>
                                            <select name="EMATER_G04_Q01" id="EMATER_G04_Q01" class="form-control">
                                              <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G04_Q01'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G04_Q01'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Valor dos Benefícios de Transferência de Renda (ANUAL)(R$):</font></strong></label>
                                            <input type="text" name="EMATER_G04_Q02" id="EMATER_G04_Q02" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G04_Q02'],2,',','.')?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Acesso a Benefícios Sociais Socioassistênciais?</font></strong></label>
                                            <select name="EMATER_G04_Q03" id="EMATER_G04_Q03" class="form-control">
                                              <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G04_Q03'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G04_Q03'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Valor dos Benefícios Sociais Socioassistênciais (ANUAL)(R$):</font></strong></label>
                                            <input type="text" name="EMATER_G04_Q04" id="EMATER_G04_Q04" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G04_Q04'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 04.01 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Alguém Possuí Emprego Fixo Fora do Lote?</font></strong></label>
                                            <select name="EMATER_G04_Q05" id="EMATER_G04_Q05" class="form-control">
                                              <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G04_Q05'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G04_Q05'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                          </select>
                                      </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Valor Total dos Rendimentos de Empregos Fixos Fora do Lote (ANUAL)(R$):</font></strong></label>
                                            <input type="text" name="EMATER_G04_Q06" id="EMATER_G04_Q06" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G04_Q06'],2,',','.')?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Alguém Possuí Emprego Temporário Fora do Lote?</font></strong></label>
                                            <select name="EMATER_G04_Q07" id="EMATER_G04_Q07" class="form-control">
                                              <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G04_Q07'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G04_Q07'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Valor Total dos Rendimentos de Empregos Temporários Fora do Lote (ANUAL)(R$):</font></strong></label>
                                            <input type="text" name="EMATER_G04_Q08" id="EMATER_G04_Q08" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G04_Q08'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 04.02 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Alguém Possuí Renda com Pesca Comercial?</font></strong></label>
                                            <select name="EMATER_G04_Q09" id="EMATER_G04_Q09" class="form-control">
                                              <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G04_Q09'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G04_Q09'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Valor Total da Renda da Pesca Comercial (ANUAL)(R$):</font></strong></label>
                                            <input type="text" name="EMATER_G04_Q10" id="EMATER_G04_Q10" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G04_Q10'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 04.03 -->

                                    <div class="form-group row">
                                    	<h4>Características Familiar</h4>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Número de Membros da Família:</font></strong></label>
                                            <input type="text" name="EMATER_G05_Q01" id="EMATER_G05_Q01" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo $vetor_EMATER['EMATER_G05_Q01']; ?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Força de Trabalho Familiar:</font></strong></label>
                                            <select name="EMATER_G05_Q02" id="EMATER_G05_Q02" class="form-control">
                                              <option label="BAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q02'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXA FORÇA DE TRABALHO (MENOR OU IGUAL QUE 2.25)</option>
                                                <option label="MEDIA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q02'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIA FORÇA DE TRABALHO (MAIOR QUE 2.25 E MENOR OU IGUAL QUE 3.75)</option>
                                                <option label="ALTA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q02'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTA FORÇA DE TRABALHO (MAIOR QUE 3.75)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Valor do Cálculo da Força de Trabalho Familiar:</font></strong></label>
                                            <input type="text" name="EMATER_G05_Q03" id="EMATER_G05_Q03" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G05_Q03'],2,',','.')?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Família Atendida Como Vulnerário pelo Projeto 4.6.2?</label>
                                            <select name="EMATER_G05_Q08" id="EMATER_G05_Q08" class="form-control">
                                              <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q08'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q08'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Grupo 05.01 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Faixa de Renda Per Capta:</font></strong></label>
                                            <select name="EMATER_G05_Q04" id="EMATER_G05_Q04" class="form-control">
                                              <option label="POBREZA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q04'],'1') == 0) : ?>selected="selected"<?php endif; ?>>01 - Pobreza (Abaixo de R$ 177,00/mês/pessoa)</option>
                                                <option label="BAIXA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q04'],'2') == 0) : ?>selected="selected"<?php endif; ?>>02 - Renda Baixa (Acima de R$ 177,00 e Abaixo de 1/2 Salário Mínimo (R$ 468,50)/mês/pessoa)</option>
                                                <option label="MEDIA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q04'],'3') == 0) : ?>selected="selected"<?php endif; ?>>03 - Renda Média (Acima de 1/2 Salário Mínimo (R$ 468,50) e Abaixo de 1 Salário Mínimo (R$ 937,00)/mês/pessoa)</option>
                                                <option label="MODERADA" value="4" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q04'],'4') == 0) : ?>selected="selected"<?php endif; ?>>04 - Renda Moderada (Acima de 1 Salário Mínimo (R$ 937,00) e Abaixo de 2 Salários Mínimos (R$ 1.874,00)/mês/pessoa)</option>
                                                <option label="ALTA" value="5" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q04'],'5') == 0) : ?>selected="selected"<?php endif; ?>>05 - Renda Alta (Acima de 2 Salários Mínimos (R$ 1.874,00)/mês/pessoa)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Valor Calculado da Renda Per Capta (R$):</font></strong></label>
                                            <input type="text" name="EMATER_G05_Q05" id="EMATER_G05_Q05" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G05_Q05'],2,',','.')?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Faixa de Vulnerabilidade, Conforme IDF (2017):</label>
                                            <select name="EMATER_G05_Q06" id="EMATER_G05_Q06" class="form-control">
                                                <option label="NAOINFORMADO" value="0" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q06'],'0') == 0) : ?>selected="selected"<?php endif; ?>>IDF Não Informado</option>
                                                <option label="BAIXO" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q06'],'1') == 0) : ?>selected="selected"<?php endif; ?>>IDF Baixo (Entre 0,00 e 0,49)</option>
                                                <option label="MEDIO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q06'],'2') == 0) : ?>selected="selected"<?php endif; ?>>IDF Médio (Entre 0,50 e 0,79)</option>
                                                <option label="ALTO" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G05_Q06'],'3') == 0) : ?>selected="selected"<?php endif; ?>>IDF Alto (Entre 0,80 e 1,00)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Valor Calculado do IDF da Família em 2017 (ou Último):</label>
                                            <input type="text" name="EMATER_G05_Q07" id="EMATER_G05_Q07" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G05_Q07'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 05.02 -->

                                    <div class="form-group row">
                                    	<h4>Interesse em Desenvolver a Propriedade</h4>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Mostra interesse em desenvolver o lote sob o ponto de vista produtivo?</font></strong></label>
                                            <select name="EMATER_G06_Q01" id="EMATER_G06_Q01" class="form-control">
                                                <option label="BAIXO" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q01'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXO</option>
                                                <option label="MEDIO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q01'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIO</option>
                                                <option label="ALTO" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q01'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">É receptivo às ações da ATES?</font></strong></label>
                                            <select name="EMATER_G06_Q02" id="EMATER_G06_Q02" class="form-control">
                                                <option label="BAIXO" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q02'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXO</option>
                                                <option label="MEDIO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q02'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIO</option>
                                                <option label="ALTO" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q02'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Participa das atividades coletivas e socioculturais promovidas pelo Projeto de Reparação?</font></strong></label>
                                            <select name="EMATER_G06_Q03" id="EMATER_G06_Q03" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q03'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q03'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Acesso ou Distância dificultam seguir as orientações de ATES?</font></strong></label>
                                            <select name="EMATER_G06_Q04" id="EMATER_G06_Q04" class="form-control">
                                                <option label="BAIXO" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q04'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXO</option>
                                                <option label="MEDIO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q04'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIO</option>
                                                <option label="ALTO" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q04'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Grupo 06.01 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Recursos financeiros dificultam seguir as orientações de ATES?</font></strong></label>
                                            <select name="EMATER_G06_Q05" id="EMATER_G06_Q05" class="form-control">
                                                <option label="BAIXO" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q05'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXO</option>
                                                <option label="MEDIO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q05'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIO</option>
                                                <option label="ALTO" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q05'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Mão de Obra disponpivel dificulta seguir as orientações de ATES?</font></strong></label>
                                            <select name="EMATER_G06_Q06" id="EMATER_G06_Q06" class="form-control">
                                                <option label="BAIXO" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q06'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXO</option>
                                                <option label="MEDIO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q06'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIO</option>
                                                <option label="ALTO" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q06'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Resistência-Melindres dificultam seguir as orientações de ATES?</font></strong></label>
                                            <select name="EMATER_G06_Q07" id="EMATER_G06_Q07" class="form-control">
                                                <option label="BAIXO" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q07'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXO</option>
                                                <option label="MEDIO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q07'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIO</option>
                                                <option label="ALTO" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q07'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Existem atividades planejadas para o futuro?</font></strong></label>
                                            <select name="EMATER_G06_Q11" id="EMATER_G06_Q11" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q11'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q11'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Grupo 06.02 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui CAR?</font></strong></label>
                                            <select name="EMATER_G06_Q08" id="EMATER_G06_Q08" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q08'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q08'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui DAP?</font></strong></label>
                                            <select name="EMATER_G06_Q09" id="EMATER_G06_Q09" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q09'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q09'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui DLA?</font></strong></label>
                                            <select name="EMATER_G06_Q10" id="EMATER_G06_Q10" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q10'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G06_Q10'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Grupo 06.03 -->

                                    <div class="form-group row">
                                    	<h4>Infraestrutura na Propriedade</h4>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Tipo de Moradia:</font></strong></label>
                                            <select name="EMATER_G07_Q01" id="EMATER_G07_Q01" class="form-control">
                                                <option label="NI" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q01'],'1') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO</option>
                                                <option label="ALVENARIA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q01'],'2') == 0) : ?>selected="selected"<?php endif; ?>>ALVENARIA</option>
                                                <option label="MADEIRA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q01'],'3') == 0) : ?>selected="selected"<?php endif; ?>>MADEIRA</option>
                                                <option label="PALHA" value="4" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q01'],'4') == 0) : ?>selected="selected"<?php endif; ?>>PALHA</option>
                                                <option label="BARRO" value="5" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q01'],'5') == 0) : ?>selected="selected"<?php endif; ?>>BARRO</option>
                                                <option label="OUTROS" value="6" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q01'],'6') == 0) : ?>selected="selected"<?php endif; ?>>OUTROS</option>
                                                <option label="NAOTEM" value="7" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q01'],'7') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Tipo de Acesso à Energia Elétrica:</font></strong></label>
                                            <select name="EMATER_G07_Q02" id="EMATER_G07_Q02" class="form-control">
                                                <option label="NI" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q02'],'1') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO</option>
                                                <option label="REDE" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q02'],'2') == 0) : ?>selected="selected"<?php endif; ?>>REDE</option>
                                                <option label="SOLAR" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q02'],'3') == 0) : ?>selected="selected"<?php endif; ?>>SOLAR</option>
                                                <option label="GERADOR" value="4" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q02'],'4') == 0) : ?>selected="selected"<?php endif; ?>>GERADOR</option>
                                                <option label="OUTROS" value="5" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q02'],'5') == 0) : ?>selected="selected"<?php endif; ?>>OUTROS</option>
                                                <option label="NAOTEM" value="6" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q02'],'6') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Tipo de Acesso à Água:</font></strong></label>
                                            <select name="EMATER_G07_Q03" id="EMATER_G07_Q03" class="form-control">
                                                <option label="NI" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q03'],'1') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO</option>
                                                <option label="POCO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q03'],'2') == 0) : ?>selected="selected"<?php endif; ?>>POÇO</option>
                                                <option label="RIO" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q03'],'3') == 0) : ?>selected="selected"<?php endif; ?>>RIO/NASCENTE</option>
                                                <option label="MICROSISTEMA" value="4" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q03'],'4') == 0) : ?>selected="selected"<?php endif; ?>>MICROSISTEMA</option>
                                                <option label="OUTROS" value="5" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q03'],'5') == 0) : ?>selected="selected"<?php endif; ?>>OUTROS</option>
                                                <option label="NAOTEM" value="6" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q03'],'6') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><font color="#FF0004"><strong>Principal Meio de Transporte/Veículo:</strong></font></label>
                                            <select name="EMATER_G07_Q04" id="EMATER_G07_Q04" class="form-control">
                                                <option label="NI" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q04'],'1') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO</option>
                                                <option label="CARRO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q04'],'2') == 0) : ?>selected="selected"<?php endif; ?>>CARRO (OU CAMINHONETE)</option>
                                                <option label="MOTO" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q04'],'3') == 0) : ?>selected="selected"<?php endif; ?>>MOTO</option>
                                                <option label="BICICLETA" value="4" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q04'],'4') == 0) : ?>selected="selected"<?php endif; ?>>BICICLETA</option>
                                                <option label="BARCO" value="5" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q04'],'5') == 0) : ?>selected="selected"<?php endif; ?>>BARCO</option>
                                                <option label="OUTROS" value="6" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q04'],'6') == 0) : ?>selected="selected"<?php endif; ?>>OUTROS</option>
                                                <option label="NAOTEM" value="7" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q04'],'7') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                            </select>
                                        </div>
                                    </div> <!-- Grupo 07.01 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui máquinas e implementos agrícolas?</font></strong></label>
                                            <select name="EMATER_G07_Q05" id="EMATER_G07_Q05" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q05'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q05'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui ferramentas motorizadas?</font></strong></label>
                                            <select name="EMATER_G07_Q06" id="EMATER_G07_Q06" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q06'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q06'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui galinheiro?</font></strong><label>
                                            <select name="EMATER_G07_Q07" id="EMATER_G07_Q07" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q07'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q07'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui aprisco (curral para ovelhas)?</font></strong></label>
                                            <select name="EMATER_G07_Q08" id="EMATER_G07_Q08" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q08'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q08'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Grupo 07.02 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui chiqueiro de porco?</font></strong></label>
                                            <select name="EMATER_G07_Q09" id="EMATER_G07_Q09" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q09'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q09'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui curral para gado?</font></strong></label>
                                            <select name="EMATER_G07_Q10" id="EMATER_G07_Q10" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q10'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q10'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui cocho para gado?</font></strong></label>
                                            <select name="EMATER_G07_Q11" id="EMATER_G07_Q11" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q11'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q11'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui barcaça para secagem de cacau?</font></strong></label>
                                            <select name="EMATER_G07_Q12" id="EMATER_G07_Q12" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q12'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>

                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q12'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Grupo 07.03 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput"><strong><font color="#FF0004">Possui viveiro de mudas?</font></strong></label>
                                            <select name="EMATER_G07_Q13" id="EMATER_G07_Q13" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q13'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G07_Q13'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Grupo 07.04 -->

                                    <div class="form-group row">
                                    	<h4>Uso do solo</h4>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Área Total da Propriedade (hectares):</label>
                                            <input type="text" name="EMATER_G08_Q01" id="EMATER_G08_Q01" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G08_Q01']; ?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Faixa da Área Total da Propriedade:</label>
                                            <select name="EMATER_G08_Q02" id="EMATER_G08_Q02" class="form-control">
                                                <option label="BAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G08_Q02'],'1') == 0) : ?>selected="selected"<?php endif; ?>>PEQUENA PROPRIEDADE (MENOR OU IGUAL A 70ha)</option>
                                                <option label="MEDIA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G08_Q02'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIA PROPRIEDADE (MAIOR QUE 70ha E MENOR OU IGUAL A 140ha)</option>
                                                <option label="GRANDE" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G08_Q02'],'3') == 0) : ?>selected="selected"<?php endif; ?>>GRANDE PROPRIEDADE (MAIOR QUE 140ha)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Área de Floresta (hectares):</label>
                                            <input type="text" name="EMATER_G08_Q03" id="EMATER_G08_Q03" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G08_Q03']; ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">% Relativa de Floresta:</label>
                                            <input type="text" name="EMATER_G08_Q04" id="EMATER_G08_Q04" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G08_Q04'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 08.01 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Área de Capoeira (hectares):</label>
                                            <input type="text" name="EMATER_G08_Q05" id="EMATER_G08_Q05" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G08_Q05']; ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">% Relativa de Capoeira:</label>
                                            <input type="text" name="EMATER_G08_Q06" id="EMATER_G08_Q06" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G08_Q06'],2,',','.')?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Área de Pasto Sujo (hectares):</label>
                                            <input type="text" name="EMATER_G08_Q07" id="EMATER_G08_Q07" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G08_Q07']; ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">% Relativa de Pasto Sujo:</label>
                                            <input type="text" name="EMATER_G08_Q08" id="EMATER_G08_Q08" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G08_Q08'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 08.02 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Área de Pasto Limpo (hectares):</label>
                                            <input type="text" name="EMATER_G08_Q09" id="EMATER_G08_Q09" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G08_Q09']; ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">% Relativa de Pasto Limpo:</label>
                                            <input type="text" name="EMATER_G08_Q10" id="EMATER_G08_Q10" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G08_Q10'],2,',','.')?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Área de Cacau Produtivo (hectares):</label>
                                            <input type="text" name="EMATER_G08_Q11" id="EMATER_G08_Q11" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G08_Q11']; ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">% Relativa de Cacau Produtivo:</label>
                                            <input type="text" name="EMATER_G08_Q12" id="EMATER_G08_Q12" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G08_Q12'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 08.03 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Área de Cacau Não Produtivo (hectares):</label>
                                            <input type="text" name="EMATER_G08_Q13" id="EMATER_G08_Q13" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G08_Q13']; ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">% Relativa de Cacau Não Produtivo:</label>
                                            <input type="text" name="EMATER_G08_Q14" id="EMATER_G08_Q14" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G08_Q14'],2,',','.')?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Área de Outras Culturas Perenes (hectares):</label>
                                            <input type="text" name="EMATER_G08_Q15" id="EMATER_G08_Q15" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G08_Q15']; ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">% Relativa de Outras Culturas Perenes:</label>
                                            <input type="text" name="EMATER_G08_Q16" id="EMATER_G08_Q16" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G08_Q16'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 08.04 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Área de Lavouras Temporárias (hectares):</label>
                                            <input type="text" name="EMATER_G08_Q17" id="EMATER_G08_Q17" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G08_Q17']; ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">% Relativa de Lavouras Temporárias:</label>
                                            <input type="text" name="EMATER_G08_Q18" id="EMATER_G08_Q18" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G08_Q18'],2,',','.')?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Área de Pomasr/Quintal Agroflorestal (hectares):</label>
                                            <input type="text" name="EMATER_G08_Q19" id="EMATER_G08_Q19" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G08_Q19']; ?>">
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">% Relativa de Pomasr/Quintal Agroflorestal:</label>
                                            <input type="text" name="EMATER_G08_Q20" id="EMATER_G08_Q20" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G08_Q20'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 08.05 -->

                                    <div class="form-group row">
                                    	<h4>Atividades Produtivas</h4>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Bovinocultura de Cria (Faixa):</label>
                                            <select name="EMATER_G09_Q01" id="EMATER_G09_Q01" class="form-control">
                                                <option label="NAOPOSSUI" value="0" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q01'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                                <option label="BAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q01'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXA QUANTIDADE (MENOR OU IGUAL A 50 CABEÇAS)</option>
                                                <option label="MEDIA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q01'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIA QUANTIDADE (MAIOR QUE 50 E MENOR OU IGUAL A 100 CABEÇAS)</option>
                                                <option label="ALTA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q01'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTA QUANTIDADE (MAIOR QUE 100 CABEÇAS)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Bovinocultura de Cria (Número de Cabeças):</label>
                                            <input type="text" name="EMATER_G09_Q02" id="EMATER_G09_Q02" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G09_Q02']; ?>">
                                        </div>
<!--                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Bovinocultura Leiteira (Faixa):</label>
                                            <select name="EMATER_G09_Q03" id="EMATER_G09_Q03" class="form-control">
                                                <option label="BAIXA" value="1" <?php // if (strcasecmp($vetor_EMATER['EMATER_G09_Q03'],'1') == 0) : ?>selected="selected"<?php // endif; ?>>BAIXA QUANTIDADE</option>
                                                <option label="MEDIA" value="2" <?php // if (strcasecmp($vetor_EMATER['EMATER_G09_Q03'],'2') == 0) : ?>selected="selected"<?php // endif; ?>>MÉDIA QUANTIDADE</option>
                                                <option label="ALTA" value="3" <?php // if (strcasecmp($vetor_EMATER['EMATER_G09_Q03'],'3') == 0) : ?>selected="selected"<?php // endif; ?>>ALTA QUANTIDADE</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Bovinocultura Leiteira (Número de Cabeças):</label>
                                            <input type="text" name="EMATER_G09_Q04" id="EMATER_G09_Q04" class="form-control" placeholder="Digite o valor..." value="<?php // echo $vetor_EMATER['EMATER_G09_Q04']; ?>">
                                        </div> -->
                                    </div> <!-- Grupo 09.01 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Criação de Aves (Faixa):</label>
                                            <select name="EMATER_G09_Q05" id="EMATER_G09_Q05" class="form-control">
                                                <option label="NAOPOSSUI" value="0" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q05'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                                <option label="BAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q05'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXA QUANTIDADE (MENOR OU IGUAL A 40 BICOS)</option>
                                                <option label="MEDIA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q05'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIA QUANTIDADE (MAIOR QUE 40 E MENOR OU IGUAL A 70 BICOS)</option>
                                                <option label="ALTA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q05'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTA QUANTIDADE (MAIOR QUE 70 BICOS)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Criação de Aves (Número de Cabeças):</label>
                                            <input type="text" name="EMATER_G09_Q06" id="EMATER_G09_Q06" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G09_Q06']; ?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Criação de Suínos (Faixa):</label>
                                            <select name="EMATER_G09_Q07" id="EMATER_G09_Q07" class="form-control">
                                                <option label="NAOPOSSUI" value="0" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q07'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                                <option label="BAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q07'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXA QUANTIDADE (MENOR OU IGUAL A 5 UNIDADES)</option>
                                                <option label="MEDIA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q07'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIA QUANTIDADE (MAIOR QUE 5 E MENOR OU IGUAL A 10 UNIDADES)</option>
                                                <option label="ALTA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q07'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTA QUANTIDADE (MAIOR QUE 10 CABEÇAS)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Criação de Suínos (Número de Cabeças):</label>
                                            <input type="text" name="EMATER_G09_Q08" id="EMATER_G09_Q08" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G09_Q08']; ?>">
                                        </div>
                                    </div> <!-- Grupo 09.02 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Criação de Caprinos e Ovinos (Faixa):</label>
                                            <select name="EMATER_G09_Q09" id="EMATER_G09_Q09" class="form-control">
                                                <option label="NAOPOSSUI" value="0" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q09'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                                <option label="BAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q09'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXA QUANTIDADE</option>
                                                <option label="MEDIA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q09'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIA QUANTIDADE</option>
                                                <option label="ALTA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q09'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTA QUANTIDADE</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Criação de Caprinos e Ovinos (Número de Cabeças):</label>
                                            <input type="text" name="EMATER_G09_Q10" id="EMATER_G09_Q10" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G09_Q10']; ?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Piscicultura m² de Lamina de Água (Faixa):</label>
                                            <select name="EMATER_G09_Q11" id="EMATER_G09_Q11" class="form-control">
                                                <option label="NAOPOSSUI" value="0" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q11'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                                <option label="PEQUENO" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q11'],'1') == 0) : ?>selected="selected"<?php endif; ?>>TANQUE PEQUENO (MENOR OU IGUAL A 500m²)</option>
                                                <option label="MEDIO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q11'],'2') == 0) : ?>selected="selected"<?php endif; ?>>TANQUE MÉDIO (MAIOR QUE 500M² E MENOR OU IGUAL A 1500m²)</option>
                                                <option label="GRANDE" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q11'],'3') == 0) : ?>selected="selected"<?php endif; ?>>TANQUE GRANDE (MAIOR QUE 1500m²)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Piscicultura m² de Lamina de Água (Qtde.):</label>
                                            <input type="text" name="EMATER_G09_Q12" id="EMATER_G09_Q12" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G09_Q12'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 09.03 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Lavoura de Cacau (Número de Pés) (Faixa):</label>
                                            <select name="EMATER_G09_Q13" id="EMATER_G09_Q13" class="form-control">
                                                <option label="NAOPOSSUI" value="0" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q13'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                                <option label="BAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q13'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXA QUANTIDADE (MENOR OU IGUAL A 5.000 PÉS)</option>
                                                <option label="MEDIA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q13'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIA QUANTIDADE (MAIOR QUE 5.000 PÉS E MENOR OU IGUAL A 10.000 PÉS)</option>
                                                <option label="ALTA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q13'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTA QUANTIDADE (MAIOR QUE 10.000 PÉS)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Lavoura de Cacau (Número de Pés):</label>
                                            <input type="text" name="EMATER_G09_Q14" id="EMATER_G09_Q14" class="form-control" placeholder="Digite o valor..." value="<?php echo $vetor_EMATER['EMATER_G09_Q14']; ?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Produtividade da Lavoura de Cacau (Kg/Pé) (Faixa):</label>
                                            <select name="EMATER_G09_Q15" id="EMATER_G09_Q15" class="form-control">
                                                <option label="NAOPOSSUI" value="0" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q15'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO POSSUI</option>
                                                <option label="BAIXA" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q15'],'1') == 0) : ?>selected="selected"<?php endif; ?>>BAIXA PRODUTIVIDADE (MENOR OU IGUAL A 0,5 KG/PÉ)</option>
                                                <option label="MEDIA" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q15'],'2') == 0) : ?>selected="selected"<?php endif; ?>>MÉDIA PRODUTIVIDADE (MAIOR QUE0,5 KG/PÉ E MENOR OU IGUAL A 1,0 KG/PÉ)</option>
                                                <option label="ALTA" value="3" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q15'],'3') == 0) : ?>selected="selected"<?php endif; ?>>ALTA PRODUTIVIDADE (MAIOR QUE 1,0 KG/PÉ)</option>
                                                <option label="IMPRODUTIVO" value="4" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q15'],'4') == 0) : ?>selected="selected"<?php endif; ?>>IMPRODUTIVO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Produtividade da Lavoura de Cacau (Kg/Pé):</label>
                                            <input type="text" name="EMATER_G09_Q16" id="EMATER_G09_Q16" class="form-control" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo number_format($vetor_EMATER['EMATER_G09_Q16'],2,',','.')?>">
                                        </div>
                                    </div> <!-- Grupo 09.04 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Possui Lavouras Perenes?</label>
                                            <select name="EMATER_G09_Q17" id="EMATER_G09_Q17" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q17'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q17'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Possui Lavouras Semi-Perenes?</label>
                                            <select name="EMATER_G09_Q18" id="EMATER_G09_Q18" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q18'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q18'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Possui Lavouras Temporárias? (Grãos e Tubérculos)</label>
                                            <select name="EMATER_G09_Q19" id="EMATER_G09_Q19" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q19'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q19'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Possui Lavouras de Hortaliças? </label>
                                            <select name="EMATER_G09_Q20" id="EMATER_G09_Q20" class="form-control">
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q20'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_EMATER['EMATER_G09_Q20'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Grupo 09.05 -->
                                    
                                    </br>
                                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
                                </form>
                            </div> <!-- EMATER -->
                            <?php
								}
							?>
                            
							<div id="view7">
                                <div style="width: 100%; margin: 0 auto;">
                                    <ul class="tabs" data-persist="true">
                                        <li><a href="#view7_1">Encaminhamentos</a></li>
                                        <li><a href="#view7_2">Imagens</a></li>
                                    </ul>
                                    <div class="tabcontents">
                                        <div id="view7_1">
                                            <div id="scroll">
                                                <form action="recebe_cadastrar_atendsocial.php?id_familia=<?php echo $id_familia; ?>" method="post" name="atendosocial" enctype="multipart/form-data" id="formID">
                                                    <div id="campoPai_SOCIAL"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                                                    </br>
                                                    <input type="button" value="Novo Encaminhamento" onClick="addCampos_SOCIAL()" class="btn btn-inline">
                                                    <input type="submit" value="Salvar Encaminhamentos" class="btn btn-inline">
                                                </form>
                                                </br>
                                                </br>
                                                <table width="100%">
                                                    <tr align="center" bgcolor="#0D0C9B">
                                                        <td width="10%"><strong><font color="#FFFFFF">Data</font></strong></td>
                                                        <td width="2%"></td>
                                                        <td width="64%"><strong><font color="#FFFFFF">Detalhamento</font></strong></td>
                                                        <td width="2%"></td>
                                                        <td width="10%"><strong><font color="#FFFFFF">Concluído?</font></strong></td>
                                                        <td width="2%"></td>
                                                        <td width="10%"><strong><font color="#FFFFFF">Ações</font></strong></td>
                                                    </tr>
                                                    <?php 
                                                        $sql_SOCIAL = mysql_query("SELECT TAB_415421_SOCIAIS.SOCIAL_CODIGO, TAB_415421_SOCIAIS.SOCIAL_DATA, TAB_415421_SOCIAIS.SOCIAL_DESCRICAO, TAB_APOIO_BOOLEANO.DESCRICAO FROM TAB_415421_SOCIAIS LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_415421_SOCIAIS.SOCIAL_CONCLUIDA = TAB_APOIO_BOOLEANO.ID WHERE TAB_415421_SOCIAIS.FAMILIA_CODIGO = '$id_familia' ORDER BY TAB_415421_SOCIAIS.SOCIAL_DATA DESC, TAB_415421_SOCIAIS.SOCIAL_DESCRICAO ASC;", $db);
                                                        $cor = "#D8D8D8";
                                                        while ($vetor_SOCIAL=mysql_fetch_array($sql_SOCIAL)) {
                                                            if (strcasecmp($cor, "#FFFFFF") == 0){
                                                                $cor = "#D8D8D8";
                                                            } else {
                                                                $cor = "#FFFFFF";
                                                            }
                                                    ?>
                                                    <tr bgcolor="<?php echo $cor; ?>">
                                                        <td width="10%"><?php echo date('d/m/Y', strtotime($vetor_SOCIAL['SOCIAL_DATA'])); ?></td>
                                                        <td width="2%"></td>
                                                        <td width="64%"><?php echo $vetor_SOCIAL['SOCIAL_DESCRICAO']; ?></td>
                                                        <td width="2%"></td>
                                                        <td width="10%"><?php echo $vetor_SOCIAL['DESCRICAO']; ?></td>
                                                        <td width="2%"></td>
                                                        
                                                        <td width="10%" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('alterar_atendsocial.php?id_atendsocial=<?php echo $vetor_SOCIAL["SOCIAL_CODIGO"];?>&id_familia=<?php echo $id_familia;?>','Dados do Encaminhamento', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_atendsocial.php?id_atendsocial=<?php echo $vetor_SOCIAL['SOCIAL_CODIGO']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>                                
                                        </div> <!-- Encaminhamentos -->

                                        <div id="view7_2">
                                        	<div id="scroll">
                                                <table width="100%">
                                                  <tr align="center" bgcolor="#0D0C9B">
                                                    <td width="10%"><strong><font color="#FFFFFF">Data</font></strong></td>
                                                    <td width="2%"></td>
                                                    <td width="40%"><strong><font color="#FFFFFF">Legenda</font></strong></td>
                                                    <td width="2%"></td>
                                                    <td width="34%"><strong><font color="#FFFFFF">Imagem</font></strong></td>
                                                    <td width="2%"></td>
                                                    <td width="10%">&nbsp;</td>
                                                  </tr>
                                                </table>
                                                <form action="recebe_cadastrar_imagemsoc.php?id_familia=<?php echo $id_familia; ?>" method="post" name="imagemsoc" enctype="multipart/form-data" id="formID">
	                                                <div id="campoPai_IMAGEMSOC"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
	                                                <br/>
	                                                <input type="button" value="Nova Imagem" onClick="addCampos_IMAGEMSOC()" class="btn btn-inline">
	                                                <input type="submit" value="Salvar Imagens" class="btn btn-inline">
                                                </form>
                                                <br/>
                                                <br/>
                                                <table width="100%">
                                                  <tr align="center" bgcolor="#0D0C9B">
                                                    <td width="10%"><strong><font color="#FFFFFF">Data</font></strong></td>
                                                    <td width="2%"></td>
                                                    <td width="40%"><strong><font color="#FFFFFF">Legenda</font></strong></td>
                                                    <td width="2%"></td>
                                                    <td width="34%"><strong><font color="#FFFFFF">Imagem</font></strong></td>
                                                    <td width="2%"></td>
                                                    <td width="10%">&nbsp;</td>
                                                  </tr>
                                                   <?php 
                                                        $sql_imagem = mysql_query("SELECT * FROM TAB_415421_IMAGENSSOC WHERE FAMILIA_CODIGO = '$id_familia' ORDER BY IMAGEMSOC_DATA DESC, IMAGEMSOC_LEGENDA ASC;", $db);
                                                        $cor = "#D8D8D8";
                                                        while ($vetor_imagem=mysql_fetch_array($sql_imagem)) {
                                                            if (strcasecmp($cor, "#FFFFFF") == 0){
                                                                $cor = "#D8D8D8";
                                                            } else {
                                                                $cor = "#FFFFFF";
                                                            }
                                                    ?>
                                                    <tr bgcolor="<?php echo $cor; ?>">
                                                        <td width="10%" align="center" valign="middle"><?php echo date('d/m/Y', strtotime($vetor_imagem['IMAGEMSOC_DATA'])); ?></td>
                                                        <td width="2%"></td>
                                                        <td width="40%" align="center" valign="middle"><?php echo $vetor_imagem['IMAGEMSOC_LEGENDA']; ?></td>
                                                        <td width="2%"></td>
                                                        <td width="34%" align="center" valign="middle"><img src="imagens/<?php echo $vetor_imagem['IMAGEMSOC_NOME']; ?>" width="150"></td>
                                                        <td width="2%"></td>
                                                        <td width="2%"></td>
                                                        <td width="10%" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('alterar_imagemsoc.php?id_imagem=<?php echo $vetor_imagem["IMAGEMSOC_CODIGO"];?>&id_familia=<?php echo $id_familia;?>','Imagens do Encaminhamento', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_imagemsoc.php?id_imagem=<?php echo $vetor_imagem['IMAGEMSOC_CODIGO']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                                                  </tr>
                                                  <?php } ?>
                                                </table>
                                            
                                            </div>
                                        </div> <!-- Imagens dos Atendimentos -->

                                    </div>
                                </div>
                            </div> <!-- Atendimentos Sociais -->

						</div>
                    </div>
					</br>
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