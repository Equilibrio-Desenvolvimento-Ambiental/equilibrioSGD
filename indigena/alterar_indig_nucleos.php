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
		$sqlPERMISSAO = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
		$numBusca = mysql_num_rows($sqlPERMISSAO);
		if ($numBusca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$sqlALDEIAS = mysql_query("SELECT * FROM TAB_APOIO_INDIG_ALDEIA WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$INDIG_NUC_ID = $_GET['INDIG_NUC_ID'];
			$sql = mysql_query("SELECT * FROM TAB_INDIG_NUCLEOS WHERE INDIG_NUC_ID = '$INDIG_NUC_ID';", $db);
			$vetor = mysql_fetch_array($sql);

			$tmpALDEIA = $vetor['INDIG_NUC_ALDEIA'];
			
			//QUERYS PARA COMPOR OS COMBOBOX DAS INCLUSÕES
			//COMPOSIÇÃO FAMILIAR
			$sqlCOMPONENTES = mysql_query("SELECT TAB_INDIG_FAMILIAS.* FROM TAB_INDIG_FAMILIAS WHERE TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA = '$tmpALDEIA' AND TAB_INDIG_FAMILIAS.INDIG_FAM_ID IN (SELECT TAB_INDIG_FAMILIAS.INDIG_FAM_ID FROM TAB_INDIG_FAMILIAS LEFT OUTER JOIN TAB_INDIG_REL_NUCLEOS_FAMILIAS ON TAB_INDIG_REL_NUCLEOS_FAMILIAS.FAMILIA_ID = TAB_INDIG_FAMILIAS.INDIG_FAM_ID WHERE TAB_INDIG_REL_NUCLEOS_FAMILIAS.NUCLEO_ID IS NULL) ORDER BY TAB_INDIG_FAMILIAS.INDIG_FAM_NOME ASC;", $db) or die(mysql_error());
			$sqlPARENTESCOS = mysql_query("SELECT * FROM TAB_APOIO_PARENTESCO WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
			//LOCALIZAÇÃO/CONTATOS
			$sql_NUCLOC_TECNICOS = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_NUCLOC_MUNICIPIOS = mysql_query("SELECT TAB_APOIO_MUNICIPIOS.ID, TAB_APOIO_MUNICIPIOS.DESCRICAO, TAB_APOIO_UF.SIGLA FROM TAB_APOIO_MUNICIPIOS LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_MUNICIPIOS.DESCRICAO ASC, TAB_APOIO_UF.DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_NUCLOC_FUSOS = mysql_query("SELECT * FROM TAB_APOIO_FUSOS WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
			//OBSERVAÇÕES GERAIS
			$sql_NUCOBS_TECNICOS = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
			//EVENTOS
			$sql_NUCEVE_TECNICOS = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_NUCEVE_EVENTOS = mysql_query("SELECT * FROM TAB_APOIO_EVENTOS WHERE DESCRICAO LIKE '%(INDIGENA)%' AND ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
			//DOCUMENTOS ANEXOS
			$sql_NUCDOC_TECNICOS = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_NUCDOC_TPDOCUMENTOS = mysql_query("SELECT * FROM TAB_APOIO_TIPODOC WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
?>
<?php require_once("includes/header-completo.php");?>
<style type="text/css">
#scroll {
  width:100%;
  height:auto;
  overflow:auto;
}
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
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){ v_obj.value=v_fun(v_obj.value) }
function mdata(v){  
    v=v.replace(/\D/g,"");
    v=v.replace(/(\d{2})(\d)/,"$1/$2");  
    v=v.replace(/(\d{2})(\d)/,"$1/$2");  
    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");  
    return v;
}  
function mvalor(v){
	v=v.replace(/\D/g,"");
	v=v.replace(/(\d)(\d{8})$/,"$1.$2");
	v=v.replace(/(\d)(\d{5})$/,"$1.$2");
	v=v.replace(/(\d)(\d{2})$/,"$1,$2");
	return v;
}  
function minteiro(v){
	v=v.replace(/\D/g,"");
	return v;  
}  
function id(el){ return document.getElementById( el ); }
window.onload = function(){  
    id('telefone').onkeypress = function(){ mascara( this, mtel); }
    id('telefone2').onkeypress = function(){ mascara( this, mtel); }
}
</script>

<script src="jquery-1.3.2.min.js" type="text/javascript"></script>

<script type="text/javascript">
	
var qtdeCamposComponente = 0;
function addCamposComponente() {
var objPaiComponente = document.getElementById("campoPaiComponente");
var objFilhoComponente = document.createElement("div");
objFilhoComponente.setAttribute("id","filho"+qtdeCamposComponente);
objPaiComponente.appendChild(objFilhoComponente);
document.getElementById("filho"+qtdeCamposComponente).innerHTML = "<table width='100%'><tr><td width='8%' class='style12'><input type='text' name='INDIG_REL_NF_ORDEM[]' id='INDIG_REL_NF_ORDEM' class='form-control' placeholder='Ordem...' onKeyPress='mascara(this,minteiro)' maxlength='2'></td><td width='2%'></td><td width='38%' class='style12'><select name='FAMILIA_ID[]' class='form-control'><option value='0' selected='selected'>Selecione um Componente...</option><?php while ($vetorCOMPONENTES=mysql_fetch_array($sqlCOMPONENTES)){ ?><option value='<?php echo $vetorCOMPONENTES[INDIG_FAM_ID]; ?>'><?php echo $vetorCOMPONENTES[INDIG_FAM_NOME]; ?></option><?php } ?></select></td><td width='2%'></td><td width='38%' class='style12'><select name='INDIG_REL_NF_PARENTESCO[]' class='form-control'><option value='0' selected='selected'>Selecione um Grau de Parentesco...</option><?php while ($vetorPARENTESCOS=mysql_fetch_array($sqlPARENTESCOS)){ ?><option value='<?php echo $vetorPARENTESCOS[ID]; ?>'><?php echo $vetorPARENTESCOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampoComponente("+qtdeCamposComponente+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposComponente++;
}
function removerCampoComponente(id) {
var objPaiComponente = document.getElementById("campoPaiComponente");
var objFilhoComponente = document.getElementById("filho"+id);
console.log(objPaiComponente);
var removido = objPaiComponente.removeChild(objFilhoComponente);
}

var qtdeCamposLOCALIZACAO = 0;
function addCamposLOCALIZACAO() {
var objPaiLOCALIZACAO = document.getElementById("campoPaiLOCALIZACAO");
var objFilhoLOCALIZACAO = document.createElement("div");
objFilhoLOCALIZACAO.setAttribute("id","filho"+qtdeCamposLOCALIZACAO);
objPaiLOCALIZACAO.appendChild(objFilhoLOCALIZACAO);
document.getElementById("filho"+qtdeCamposLOCALIZACAO).innerHTML = "<table width='100%'><tr><td width='30%' colspan='2' class='style12'><input type='text' name='INDIG_NUCLOC_DATA[]' id='INDIG_NUCLOC_DATA' class='form-control' placeholder='Data da visita...' onKeyPress='mascara(this,mdata)'></td><td width='1%'></td><td width='30%' class='style12'><select name='INDIG_NUCLOC_TECNICO[]' id='INDIG_NUCLOC_TECNICO' class='form-control'><option value='0' selected='selected'>Técnico...</option><?php while ($vetor_NUCLOC_TECNICOS=mysql_fetch_array($sql_NUCLOC_TECNICOS)){ ?><option value='<?php echo $vetor_NUCLOC_TECNICOS[ID]; ?>'><?php echo $vetor_NUCLOC_TECNICOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='INDIG_NUCLOC_TELEFONES[]' id='INDIG_NUCLOC_TELEFONES' class='form-control' placeholder='Telefones de contato...'></td><td width='1%'></td><td width='7%'>&nbsp;</td></tr><tr><td width='14%' class='style12'><select name='INDIG_NUCLOC_OUTROEND_CASAINDIO[]' id='INDIG_NUCLOC_OUTROEND_CASAINDIO' class='form-control'><option value='0'>Utiliza Casa do Índio?</option><option value='1'>SIM</option><option value='2'>NÃO</option></select></td><td width='14%' class='style12'><select name='INDIG_NUCLOC_OUTROEND_POSSUI[]' id='INDIG_NUCLOC_OUTROEND_POSSUI' class='form-control'><option value='0'>Possuí outro endereço?</option><option value='1'>SIM</option><option value='2'>NÃO</option></select></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='INDIG_NUCLOC_OUTROEND_DESCRICAO[]' id='INDIG_NUCLOC_OUTROEND_DESCRICAO' class='form-control' placeholder='Endereço completo...'></td><td width='1%'></td><td width='30%' class='style12'><select name='INDIG_NUCLOC_OUTROEND_MUNIC[]' id='INDIG_NUCLOC_OUTROEND_MUNIC' class='form-control'><option value='0' selected='selected'>Selecione um município...</option><?php while ($vetor_NUCLOC_MUNICIPIOS=mysql_fetch_array($sql_NUCLOC_MUNICIPIOS)){ ?><option value='<?php echo $vetor_NUCLOC_MUNICIPIOS[ID]; ?>'><?php echo $vetor_NUCLOC_MUNICIPIOS[DESCRICAO].'/'.$vetor_NUCLOC_MUNICIPIOS[SIGLA]; ?></option><?php } ?></select></td><td width='1%'></td><td width='7%'><input type='button' onclick='removerCampoLOCALIZACAO("+qtdeCamposLOCALIZACAO+")' value='Remover' class='btn btn-inline'></td></tr><tr><td width='30%' colspan='2' class='style12'><select name='INDIG_NUCLOC_COORDMOR_FUSO[]' id='INDIG_NUCLOC_COORDMOR_FUSO' class='form-control'><option value='0' selected='selected'>Fuso geográfico...</option><?php while ($vetor_NUCLOC_FUSOS=mysql_fetch_array($sql_NUCLOC_FUSOS)){ ?><option value='<?php echo $vetor_NUCLOC_FUSOS[ID]; ?>'><?php echo $vetor_NUCLOC_FUSOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='INDIG_NUCLOC_COORDMOR_UTME[]' id='INDIG_NUCLOC_COORDMOR_UTME' class='form-control' placeholder='Coord. UTM E...'></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='INDIG_NUCLOC_COORDMOR_UTMN[]' id='INDIG_NUCLOC_COORDMOR_UTMN' class='form-control' placeholder='Coord. UTM N...'></td><td width='7%'>&nbsp;</td></tr></table><hr>";
qtdeCamposLOCALIZACAO++;
}
function removerCampoLOCALIZACAO(id) {
var objPaiLOCALIZACAO = document.getElementById("campoPaiLOCALIZACAO");
var objFilhoLOCALIZACAO = document.getElementById("filho"+id);
console.log(objPaiLOCALIZACAO);
var removido = objPaiLOCALIZACAO.removeChild(objFilhoLOCALIZACAO);
}

var qtdeCamposOBSERVACAO = 0;
function addCamposOBSERVACAO() {
var objPaiOBSERVACAO = document.getElementById("campoPaiOBSERVACAO");
var objFilhoOBSERVACAO = document.createElement("div");
objFilhoOBSERVACAO.setAttribute("id","filho"+qtdeCamposOBSERVACAO);
objPaiOBSERVACAO.appendChild(objFilhoOBSERVACAO);
document.getElementById("filho"+qtdeCamposOBSERVACAO).innerHTML = "<table width='100%'><tr><td width='13%' class='style12'><input type='text' name='INDIG_NUCOBS_DATA[]' id='INDIG_NUCOBS_DATA' class='form-control' placeholder='Data da visita...' onKeyPress='mascara(this,mdata)'></td><td width='2%'></td><td width='18%' class='style12'><select name='INDIG_NUCOBS_TECNICO[]' id='INDIG_NUCOBS_TECNICO' class='form-control'><option value='0' selected='selected'>Técnico...</option><?php while ($vetor_NUCOBS_TECNICOS=mysql_fetch_array($sql_NUCOBS_TECNICOS)){ ?><option value='<?php echo $vetor_NUCOBS_TECNICOS[ID]; ?>'><?php echo $vetor_NUCOBS_TECNICOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='53%' class='style12'><textarea rows='4' class='form-control' name='INDIG_NUCOBS_OBSERVACAO[]' id='INDIG_NUCOBS_OBSERVACAO'></textarea></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampoOBSERVACAO("+qtdeCamposOBSERVACAO+")' value='Remover' class='btn btn-inline'></td></tr></table><hr>";
qtdeCamposOBSERVACAO++;
}
function removerCampoOBSERVACAO(id) {
var objPaiOBSERVACAO = document.getElementById("campoPaiOBSERVACAO");
var objFilhoOBSERVACAO = document.getElementById("filho"+id);
console.log(objPaiOBSERVACAO);
var removido = objPaiOBSERVACAO.removeChild(objFilhoOBSERVACAO);
}
	
var qtdeCamposDOCUMENTO = 0;
function addCamposDOCUMENTO() {
var objPaiDOCUMENTO = document.getElementById("campoPaiDOCUMENTO");
var objFilhoDOCUMENTO = document.createElement("div");
objFilhoDOCUMENTO.setAttribute("id","filhoDOCUMENTO"+qtdeCamposDOCUMENTO);
objPaiDOCUMENTO.appendChild(objFilhoDOCUMENTO);
document.getElementById("filhoDOCUMENTO"+qtdeCamposDOCUMENTO).innerHTML = "<table width='100%' border='0'><tr><td width='10%' class='style12'><input type='text' name='INDIG_NUCDOC_DATA[]' id='INDIG_NUCDOC_DATA' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10' placeholder='Data da visita...'></td><td width='1%'></td><td width='18%' class='style12'><select name='INDIG_NUCDOC_TECNICO[]' id='INDIG_NUCDOC_TECNICO' class='form-control'><option value='0' selected='selected'>Técnico...</option><?php while ($vetor_NUCDOC_TECNICOS=mysql_fetch_array($sql_NUCDOC_TECNICOS)){ ?><option value='<?php echo $vetor_NUCDOC_TECNICOS[ID]; ?>'><?php echo $vetor_NUCDOC_TECNICOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='18%'><select name='INDIG_NUCDOC_TIPO[]' id='INDIG_NUCDOC_TIPO' class='form-control'><option value='0' selected='selected'>Tipo do documento...</option><?php while ($vetor_NUCDOC_TPDOCUMENTOS=mysql_fetch_array($sql_NUCDOC_TPDOCUMENTOS)) { ?><option value='<?php echo  $vetor_NUCDOC_TPDOCUMENTOS[ID]; ?>'><?php echo $vetor_NUCDOC_TPDOCUMENTOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='18%' class='style12'><input type='text' name='INDIG_NUCDOC_DESCRICAO[]' id='INDIG_NUCDOC_DESCRICAO' class='form-control' placeholder='Descrição...'></td><td width='1%'></td><td width='21%' class='style12'><input type='file' name='INDIG_NUCDOC_ARQUIVO[]' id='INDIG_NUCDOC_ARQUIVO' class='form-control'></td><td width='1%'></td><td width='10%' class='style12'><input type='button' onclick='removerCampoDOCUMENTO("+qtdeCamposDOCUMENTO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposDOCUMENTO++;
}
function removerCampoDOCUMENTO(id) {
var objPaiDOCUMENTO = document.getElementById("campoPaiDOCUMENTO");
var objFilhoDOCUMENTO = document.getElementById("filhoDOCUMENTO"+id);
console.log(objPaiDOCUMENTO);
var removido = objPaiDOCUMENTO.removeChild(objFilhoDOCUMENTO);
}	

var qtdeCamposEVENTO = 0;
function addCamposEVENTO() {
var objPaiEVENTO = document.getElementById("campoPaiEVENTO");
var objFilhoEVENTO = document.createElement("div");
objFilhoEVENTO.setAttribute("id","filho"+qtdeCamposEVENTO);
objPaiEVENTO.appendChild(objFilhoEVENTO);
document.getElementById("filho"+qtdeCamposEVENTO).innerHTML = "<table width='100%'><tr><td width='19%'><input type='text' name='INDIG_NUCEVE_DATA[]' id='INDIG_NUCEVE_DATA' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10' placeholder='Data da visita...'></td><td width='1%'></td><td width='19%' class='style12'><select name='INDIG_NUCEVE_TECNICO[]' id='INDIG_NUCEVE_TECNICO' class='form-control'><option value='0' selected='selected'>Técnico...</option><?php while ($vetor_NUCEVE_TECNICOS=mysql_fetch_array($sql_NUCEVE_TECNICOS)){ ?><option value='<?php echo $vetor_NUCEVE_TECNICOS[ID]; ?>'><?php echo $vetor_NUCEVE_TECNICOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='24%' class='style12'><select name='INDIG_NUCEVE_TIPO[]' id='INDIG_NUCEVE_TIPO' class='form-control'><option value='0' selected='selected'>Tipo do Evento...</option><?php while ($vetor_NUCEVE_EVENTOS=mysql_fetch_array($sql_NUCEVE_EVENTOS)){ ?><option value='<?php echo $vetor_NUCEVE_EVENTOS[ID]; ?>'><?php echo str_replace('(INDIGENA) ', '', $vetor_NUCEVE_EVENTOS[DESCRICAO]); ?></option><?php } ?></select></td><td width='1%'></td><td width='24%' class='style12'><input type='text' name='INDIG_NUCEVE_DESCRICAO[]' id='INDIG_NUCEVE_DESCRICAO' class='form-control' placeholder='Observações...'></td><td width='1%'></td><td width='10%'><input type='button' onclick='removerCampoEVENTO("+qtdeCamposEVENTO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposEVENTO++;
}
function removerCampoEVENTO(id) {
var objPaiEVENTO = document.getElementById("campoPaiEVENTO");
var objFilhoEVENTO = document.getElementById("filho"+id);
console.log(objPaiEVENTO);
var removido = objPaiEVENTO.removeChild(objFilhoEVENTO);
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
							<h3>Gestão de Dados dos Projetos Indígenas</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Núcleos Familiares - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_alterar_indig_nucleos.php?INDIG_NUC_ID=<?php echo $INDIG_NUC_ID; ?>" method="post" name="recebe_alterar_indig_nucleos" enctype="multipart/form-data" id="recebe_alterar_indig_nucleos">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="form-label semibold" for="INDIG_NUC_NOME">Nome do chefe da família:</label>
                            <input type="text" name="INDIG_NUC_NOME" class="form-control" id="INDIG_NUC_NOME" placeholder="Digite o nome do chefe da família..." value="<?php echo $vetor['INDIG_NUC_NOME']; ?>">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label semibold" for="INDIG_NUC_ALDEIA">Aldeia:</label>
							<select name="INDIG_NUC_ALDEIA" id="INDIG_NUC_ALDEIA" class="form-control">
								<?php while ($vetorALDEIAS=mysql_fetch_array($sqlALDEIAS)) { ?>
								<option value="<?php echo $vetorALDEIAS['ID']; ?>" <?php if (strcasecmp($vetor['INDIG_NUC_ALDEIA'], $vetorALDEIAS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetorALDEIAS['DESCRICAO']; ?></option>
								<?php } ?>
							</select>
                        </div>
                    </div>
					<div style="width: 100%; margin: 0 auto;">
						<ul class="tabs" data-persist="true">
							<li><a href="#view1">Composição Familiar</a></li>
							<li><a href="#view2">Localização/Contatos</a></li>
							<li><a href="#view3">Observações</a></li>
							<li><a href="#view4">Eventos</a></li>
							<li><a href="#view5">Anexos</a></li>
						</ul>
						<div class="tabcontents">
							<div id="view1">
								<table width="100%">
									<thead>
										<td width="8%">Ordem</td>
										<td width="2%"></td>
										<td width="38%">Nome</td>
										<td width="2%"></td>
										<td width="38%">Grau de Parentesco</td>
										<td width="2%"></td>
										<td width="10%">&nbsp;</td>
									  </thead>
								</table>
								<div id="campoPaiComponente"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div></br>
								<input type="button" value="Inserir" onClick="addCamposComponente()" class="btn btn-inline">
								</br></br>
								<table width="100%">
									<thead>
										<td width="8%">Ordem</td>
										<td width="2%"></td>
										<td width="38%">Nome</td>
										<td width="2%"></td>
										<td width="38%">Grau de Parentesco</td>
										<td width="2%"></td>
										<td width="10%">Ações</td>
									</thead>
									<?php 
										$sql_LIST_COMPONENTES = mysql_query("SELECT TAB_INDIG_FAMILIAS.INDIG_FAM_ID, TAB_INDIG_FAMILIAS.INDIG_FAM_NOME, TAB_INDIG_REL_NUCLEOS_FAMILIAS.INDIG_REL_NF_ORDEM, TAB_APOIO_PARENTESCO.DESCRICAO AS INDIG_REL_NF_PARENTESCO FROM TAB_INDIG_REL_NUCLEOS_FAMILIAS LEFT OUTER JOIN TAB_INDIG_FAMILIAS ON TAB_INDIG_REL_NUCLEOS_FAMILIAS.FAMILIA_ID = TAB_INDIG_FAMILIAS.INDIG_FAM_ID LEFT OUTER JOIN TAB_APOIO_PARENTESCO ON TAB_INDIG_REL_NUCLEOS_FAMILIAS.INDIG_REL_NF_PARENTESCO = TAB_APOIO_PARENTESCO.ID WHERE TAB_INDIG_REL_NUCLEOS_FAMILIAS.NUCLEO_ID = '$INDIG_NUC_ID' ORDER BY TAB_INDIG_REL_NUCLEOS_FAMILIAS.INDIG_REL_NF_ORDEM ASC, TAB_INDIG_FAMILIAS.INDIG_FAM_NOME ASC;", $db) or die(mysql_error());
										$cor = "#D8D8D8";
										while ($vetor_LIST_COMPONENTES=mysql_fetch_array($sql_LIST_COMPONENTES)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
												} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="8%"><?php echo $vetor_LIST_COMPONENTES['INDIG_REL_NF_ORDEM'];?></td>
										<td width="2%"></td>
										<td width="38%"><?php echo $vetor_LIST_COMPONENTES['INDIG_FAM_NOME'];?></td>
										<td width="2%"></td>
										<td width="38%"><?php echo $vetor_LIST_COMPONENTES['INDIG_REL_NF_PARENTESCO'];?></td>
										<td width="2%"></td>
										<td width="10%" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('cadastrar_indig_familias_dados.php?idPessoa=<?php echo $vetor_LIST_COMPONENTES['INDIG_FAM_ID']; ?>','Dados do Componente Familiar', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_rel_nucleos_familias.php?NUCLEO_ID=<?php echo $INDIG_NUC_ID; ?>&FAMILIA_ID=<?php echo $vetor_LIST_COMPONENTES['INDIG_FAM_ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
							</div> <!-- Aba Comp. Familiar-->
							<div id="view2">
								<table width="100%">
									<thead>
										<td width="90%">Endereços / Telefones / Coordenadas</td>
										<td width="10%">&nbsp;</td>
									  </thead>
								</table>
								<div id="campoPaiLOCALIZACAO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div></br>
								<input type="button" value="Inserir" onClick="addCamposLOCALIZACAO()" class="btn btn-inline">
								</br></br>
								<table width="100%">
									<thead>
										<td width="93%" colspan="7">Endereços / Telefones / Coordenadas</td>
										<td width="7%">Ações</td>
									</thead>
									<?php 
										$sql_LIST_LOCALIZACOES = mysql_query("SELECT TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_ID, TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_NUCLEO, TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_DATA, TAB_APOIO_TECNICOS.DESCRICAO AS INDIG_NUCLOC_TECNICO_DESC, TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_TELEFONES, TAB_APOIO_BOOLEANO_CASAINDIO.DESCRICAO AS INDIG_NUCLOC_OUTROEND_CASAINDIO_DESC, TAB_APOIO_BOOLEANO_POSSUI.DESCRICAO AS INDIG_NUCLOC_OUTROEND_POSSUI_DESC, TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_OUTROEND_DESCRICAO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS INDIG_NUCLOC_OUTROEND_MUNIC_DESC, TAB_APOIO_UF.SIGLA AS INDIG_NUCLOC_OUTROEND_MUNIC_UF, TAB_APOIO_FUSOS.DESCRICAO AS INDIG_NUCLOC_COORDMOR_FUSO_DESC, TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_COORDMOR_UTME, TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_COORDMOR_UTMN FROM TAB_INDIG_NUCLEOS_LOCALIZACAO LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_TECNICO = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_CASAINDIO ON TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_OUTROEND_CASAINDIO = TAB_APOIO_BOOLEANO_CASAINDIO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_POSSUI ON TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_OUTROEND_POSSUI = TAB_APOIO_BOOLEANO_POSSUI.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_OUTROEND_MUNIC = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID LEFT OUTER JOIN TAB_APOIO_FUSOS ON TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_COORDMOR_FUSO = TAB_APOIO_FUSOS.ID WHERE TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_NUCLEO = '$INDIG_NUC_ID' ORDER BY TAB_INDIG_NUCLEOS_LOCALIZACAO.INDIG_NUCLOC_DATA DESC;", $db) or die(mysql_error());
										$cor = "#D8D8D8";
										while ($vetor_LIST_LOCALIZACOES=mysql_fetch_array($sql_LIST_LOCALIZACOES)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
												} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="30%" colspan="2"><strong>Data:</strong><br/><?php echo 
										date('d/m/Y', strtotime($vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_DATA']));?></td>
										<td width="1%"></td>
										<td width="30%"><strong>Técnico:</strong><br/><?php echo $vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_TECNICO_DESC'];?></td>
										<td width="1%"></td>
										<td width="30%"><strong>Telefones:</strong><br/><?php echo $vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_TELEFONES'];?></td>
										<td width="1%"></td>
										<td width="7%"></td>
									</tr>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="14%"><strong>Casa do Índio?</strong><br/><?php echo $vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_OUTROEND_CASAINDIO_DESC'];?></td>
										<td width="14%"><strong>Outro endereço?</strong><br/><?php echo $vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_OUTROEND_POSSUI_DESC'];?></td>
										<td width="1%"></td>
										<td width="30%"><strong>Endereço completo:</strong><br/><?php echo $vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_OUTROEND_DESCRICAO'];?></td>
										<td width="1%"></td>
										<td width="30%"><strong>Município:</strong><br/><?php echo $vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_OUTROEND_MUNIC_DESC'].'/'.$vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_OUTROEND_MUNIC_UF'];?></td>
										<td width="1%"></td>
										<td width="7%" align="center"><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_nucleos_localizacoes.php?NUCLEO_ID=<?php echo $INDIG_NUC_ID; ?>&LOCALIZACAO_ID=<?php echo $vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="30%" colspan="2"><strong>Fuso:</strong><br/><?php echo $vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_COORDMOR_FUSO_DESC'];?></td>
										<td width="1%"></td>
										<td width="30%"><strong>Coord. UTM E:</strong><br/><?php echo $vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_COORDMOR_UTME'];?></td>
										<td width="1%"></td>
										<td width="30%"><strong>Coord. UTM N:</strong><br/><?php echo $vetor_LIST_LOCALIZACOES['INDIG_NUCLOC_COORDMOR_UTMN'];?></td>
										<td width="7%"></td>
									</tr>
									<?php } ?>
								</table>
							</div> <!-- Aba Localização/Contatos-->
							<div id="view3">
								<table width="100%">
									<thead>
										<td width="13%">Data da Visita</td>
										<td width="2%">&nbsp;</td>
										<td width="18%">Técnino</td>
										<td width="2%">&nbsp;</td>
										<td width="53%">Observações</td>
										<td width="2%">&nbsp;</td>
										<td width="10%">&nbsp;</td>
									  </thead>
								</table>
								<div id="campoPaiOBSERVACAO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div></br>
								<input type="button" value="Inserir" onClick="addCamposOBSERVACAO()" class="btn btn-inline">
								</br></br>
								<table width="100%">
									<thead>
										<td width="13%">Data da Visita</td>
										<td width="2%">&nbsp;</td>
										<td width="18%">Técnico</td>
										<td width="2%">&nbsp;</td>
										<td width="53%">Observações</td>
										<td width="2%">&nbsp;</td>
										<td width="10%">Ações</td>
									</thead>
									<?php 
										$sql_LIST_OBSERVACOES = mysql_query("SELECT TAB_INDIG_NUCLEOS_OBSERVACOES.INDIG_NUCOBS_ID, TAB_INDIG_NUCLEOS_OBSERVACOES.INDIG_NUCOBS_NUCLEO, TAB_INDIG_NUCLEOS_OBSERVACOES.INDIG_NUCOBS_DATA, TAB_APOIO_TECNICOS.DESCRICAO AS INDIG_NUCOBS_TECNICO_DESC, TAB_INDIG_NUCLEOS_OBSERVACOES.INDIG_NUCOBS_OBSERVACAO FROM TAB_INDIG_NUCLEOS_OBSERVACOES LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_INDIG_NUCLEOS_OBSERVACOES.INDIG_NUCOBS_TECNICO = TAB_APOIO_TECNICOS.ID WHERE TAB_INDIG_NUCLEOS_OBSERVACOES.INDIG_NUCOBS_NUCLEO = '$INDIG_NUC_ID' ORDER BY TAB_INDIG_NUCLEOS_OBSERVACOES.INDIG_NUCOBS_DATA DESC, TAB_INDIG_NUCLEOS_OBSERVACOES.INDIG_NUCOBS_ID ASC;", $db) or die(mysql_error());
										$cor = "#D8D8D8";
										while ($vetor_LIST_OBSERVACOES=mysql_fetch_array($sql_LIST_OBSERVACOES)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
												} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="13%"><?php echo 
										date('d/m/Y', strtotime($vetor_LIST_OBSERVACOES['INDIG_NUCOBS_DATA']));?></td>
										<td width="2%"></td>
										<td width="18%"><?php echo $vetor_LIST_OBSERVACOES['INDIG_NUCOBS_TECNICO_DESC'];?></td>
										<td width="2%"></td>
										<td width="53%"><?php echo $vetor_LIST_OBSERVACOES['INDIG_NUCOBS_OBSERVACAO'];?></td>
										<td width="2%"></td>
										<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_nucleos_observacoes.php?NUCLEO_ID=<?php echo $INDIG_NUC_ID; ?>&OBSERVACAO_ID=<?php echo $vetor_LIST_OBSERVACOES['INDIG_NUCOBS_ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
							</div> <!-- Aba Observações-->
							<div id="view4">
								<table width="100%">
									<thead>
										<td width="19%">Data da Visita</td>
										<td width="1%">&nbsp;</td>
										<td width="19%">Técnino</td>
										<td width="1%">&nbsp;</td>
										<td width="24%">Tipo do Evento</td>
										<td width="1%">&nbsp;</td>
										<td width="24%">Observações<td>
										<td width="1%">&nbsp;</td>
										<td width="10%">&nbsp;</td>
									  </thead>
								</table>
								<div id="campoPaiEVENTO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div></br>
								<input type="button" value="Inserir" onClick="addCamposEVENTO()" class="btn btn-inline">
								</br></br>
								<table width="100%">
									<thead>
										<td width="19%">Data da Visita</td>
										<td width="1%">&nbsp;</td>
										<td width="19%">Técnino</td>
										<td width="1%">&nbsp;</td>
										<td width="24%">Tipo do Evento</td>
										<td width="1%">&nbsp;</td>
										<td width="24%">Observações<td>
										<td width="1%">&nbsp;</td>
										<td width="10%">&nbsp;</td>
									</thead>
									<?php 
										$sql_LIST_EVENTOS = mysql_query("SELECT TAB_INDIG_NUCLEOS_EVENTOS.INDIG_NUCEVE_ID, TAB_INDIG_NUCLEOS_EVENTOS.INDIG_NUCEVE_NUCLEO, TAB_INDIG_NUCLEOS_EVENTOS.INDIG_NUCEVE_DATA, TAB_APOIO_TECNICOS.DESCRICAO AS INDIG_NUCEVE_TECNICO_DESC, TAB_APOIO_EVENTOS.DESCRICAO AS INDIG_NUCEVE_TIPO_DESC, TAB_INDIG_NUCLEOS_EVENTOS.INDIG_NUCEVE_DESCRICAO, TAB_APOIO_BOOLEANO.DESCRICAO AS INDIG_NUCEVE_CHECKED_DESC FROM TAB_INDIG_NUCLEOS_EVENTOS LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_INDIG_NUCLEOS_EVENTOS.INDIG_NUCEVE_TECNICO = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_APOIO_EVENTOS ON TAB_INDIG_NUCLEOS_EVENTOS.INDIG_NUCEVE_TIPO = TAB_APOIO_EVENTOS.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_INDIG_NUCLEOS_EVENTOS.INDIG_NUCEVE_CHECKED = TAB_APOIO_BOOLEANO.ID WHERE TAB_INDIG_NUCLEOS_EVENTOS.INDIG_NUCEVE_NUCLEO = '$INDIG_NUC_ID' ORDER BY TAB_INDIG_NUCLEOS_EVENTOS.INDIG_NUCEVE_DATA DESC, INDIG_NUCEVE_TIPO_DESC ASC;", $db) or die(mysql_error());
										$cor = "#D8D8D8";
										while ($vetor_LIST_EVENTOS=mysql_fetch_array($sql_LIST_EVENTOS)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
												} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="19%"><?php echo 
										date('d/m/Y', strtotime($vetor_LIST_EVENTOS['INDIG_NUCEVE_DATA']));?></td>
										<td width="1%"></td>
										<td width="19%"><?php echo $vetor_LIST_EVENTOS['INDIG_NUCEVE_TECNICO_DESC'];?></td>
										<td width="1%"></td>
										<td width="24%"><?php echo str_replace('(INDIGENA) ', '', $vetor_LIST_EVENTOS['INDIG_NUCEVE_TIPO_DESC']);?></td>
										<td width="1%"></td>
										<td width="24%"><?php echo $vetor_LIST_EVENTOS['INDIG_NUCEVE_DESCRICAO'];?></td>
										<td width="1%"></td>
										<td width="10%" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('cadastrar_indig_nucleos_eventos_dados.php?INDIG_NUCEVE_ID=<?php echo $vetor_LIST_EVENTOS['INDIG_NUCEVE_ID'];?>&INDIG_NUC_ID=<?php echo $INDIG_NUC_ID; ?>','Dados do Evento', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_nucleos_eventos.php?NUCLEO_ID=<?php echo $INDIG_NUC_ID; ?>&INDIG_NUCEVE_ID=<?php echo $vetor_LIST_EVENTOS['INDIG_NUCEVE_ID'];?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="relatorio_indig_nucleos_evento.php?NUCLEO_ID=<?php echo $INDIG_NUC_ID; ?>&EVENTO_ID=<?php echo $vetor_LIST_EVENTOS['INDIG_NUCEVE_ID'];?>" target="_blank"><img src="imgs/imprimir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
							</div> <!-- Aba Eventos-->
							<div id="view5">
								<table width="100%">
									<thead>
										<td width="10%">Data da Visita</td>
										<td width="1%">&nbsp;</td>
										<td width="18%">Técnico</td>
										<td width="1%">&nbsp;</td>
										<td width="18%">Tipo</td>
										<td width="1%">&nbsp;</td>
										<td width="18%">Descrição</td>
										<td width="1%">&nbsp;</td>
										<td width="18%">Anexo</td>
										<td width="1%">&nbsp;</td>
										<td width="10%">&nbsp;</td>
									  </thead>
								</table>
								<div id="campoPaiDOCUMENTO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div></br>
								<input type="button" value="Inserir" onClick="addCamposDOCUMENTO()" class="btn btn-inline">
								</br></br>
								<table width="100%">
									<thead>
										<td width="10%">Data da Visita</td>
										<td width="1%">&nbsp;</td>
										<td width="18%">Técnico</td>
										<td width="1%">&nbsp;</td>
										<td width="18%">Tipo</td>
										<td width="1%">&nbsp;</td>
										<td width="18%">Descrição</td>
										<td width="1%">&nbsp;</td>
										<td width="18%">Anexo</td>
										<td width="1%">&nbsp;</td>
										<td width="10%">&nbsp;</td>
									</thead>
									<?php 
										$sql_LIST_ANEXOS = mysql_query("SELECT TAB_INDIG_NUCLEOS_DOCUMENTOS.INDIG_NUCDOC_ID, TAB_INDIG_NUCLEOS_DOCUMENTOS.INDIG_NUCDOC_DATA, TAB_APOIO_TECNICOS.DESCRICAO AS INDIG_NUCDOC_TECNICO_DESC, TAB_APOIO_TIPODOC.DESCRICAO AS INDIG_NUCDOC_TIPO_DESC, TAB_INDIG_NUCLEOS_DOCUMENTOS.INDIG_NUCDOC_DESCRICAO, TAB_INDIG_NUCLEOS_DOCUMENTOS.INDIG_NUCDOC_ARQUIVO FROM TAB_INDIG_NUCLEOS_DOCUMENTOS LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_INDIG_NUCLEOS_DOCUMENTOS.INDIG_NUCDOC_TECNICO = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_APOIO_TIPODOC ON TAB_INDIG_NUCLEOS_DOCUMENTOS.INDIG_NUCDOC_TIPO = TAB_APOIO_TIPODOC.ID WHERE TAB_INDIG_NUCLEOS_DOCUMENTOS.INDIG_NUCDOC_NUCLEO = '$INDIG_NUC_ID' ORDER BY TAB_INDIG_NUCLEOS_DOCUMENTOS.INDIG_NUCDOC_DATA DESC;", $db) or die(mysql_error());
										$cor = "#D8D8D8";
										while ($vetor_LIST_ANEXOS=mysql_fetch_array($sql_LIST_ANEXOS)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
												} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="10%"><?php echo 
										date('d/m/Y', strtotime($vetor_LIST_ANEXOS['INDIG_NUCDOC_DATA']));?></td>
										<td width="1%"></td>
										<td width="18%"><?php echo $vetor_LIST_ANEXOS['INDIG_NUCDOC_TECNICO_DESC'];?></td>
										<td width="1%"></td>
										<td width="18%"><?php echo $vetor_LIST_ANEXOS['INDIG_NUCDOC_TIPO_DESC'];?></td>
										<td width="1%"></td>
										<td width="18%"><?php echo $vetor_LIST_ANEXOS['INDIG_NUCDOC_DESCRICAO'];?></td>
										<td width="1%"></td>
                                        <td width="18%" align="center"><a href="docs/<?php echo $vetor_LIST_ANEXOS['INDIG_NUCDOC_ARQUIVO']; ?>" target="_blank">Salvar Arquivo</a></td>
										<td width="1%">&nbsp;</td>
										<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_nucleos_documentos.php?NUCLEO_ID=<?php echo $INDIG_NUC_ID; ?>&DOCUMENTO_ID=<?php echo $vetor_LIST_ANEXOS['INDIG_NUCDOC_ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
							</div> <!-- Aba Anexos-->
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