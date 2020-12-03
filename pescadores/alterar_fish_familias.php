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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id_familia = $_GET['id_familia'];
			$sql_FAMILIA = mysql_query("select * from TAB_FISH_FAMILIAS where FISH_FAM_ID = '$id_familia';", $db);
			$vetor_FAMILIA = mysql_fetch_array($sql_FAMILIA);

			$sql_BAIRROS = mysql_query("SELECT TAB_APOIO_BAIRROS.ID, TAB_APOIO_BAIRROS.DESCRICAO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS MUNICIPIO, TAB_APOIO_UF.SIGLA AS UF FROM TAB_APOIO_BAIRROS LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_APOIO_BAIRROS.MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_BAIRROS.DESCRICAO ASC, MUNICIPIO ASC;", $db) or die(mysql_error());
			$sql_LOCALIDADES = mysql_query("SELECT TAB_APOIO_LOCALIDADES.ID, TAB_APOIO_LOCALIDADES.DESCRICAO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS MUNICIPIO, TAB_APOIO_UF.SIGLA AS UF FROM TAB_APOIO_LOCALIDADES LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_APOIO_LOCALIDADES.MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_LOCALIDADES.DESCRICAO ASC, MUNICIPIO ASC;", $db) or die(mysql_error());
			$sql_MUNIC_URB = mysql_query("SELECT TAB_APOIO_MUNICIPIOS.ID, TAB_APOIO_MUNICIPIOS.DESCRICAO, TAB_APOIO_UF.SIGLA FROM TAB_APOIO_MUNICIPIOS LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_MUNICIPIOS.DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_USOIMOVEL_URB = mysql_query("SELECT * FROM TAB_APOIO_USOIMOVEL ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_MUNIC_RUR = mysql_query("SELECT TAB_APOIO_MUNICIPIOS.ID, TAB_APOIO_MUNICIPIOS.DESCRICAO, TAB_APOIO_UF.SIGLA FROM TAB_APOIO_MUNICIPIOS LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_MUNICIPIOS.DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_USOIMOVEL_RUR = mysql_query("SELECT * FROM TAB_APOIO_USOIMOVEL ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_FUSOS = mysql_query("SELECT * FROM TAB_APOIO_FUSOS WHERE ID > 0 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TECNICO = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TECNICO_COOPERATIVA = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_CAMPANHA = mysql_query("SELECT * FROM TAB_FISH_CAMPANHAS ORDER BY FISH_CAMP_DESCRICAO  ASC;", $db) or die(mysql_error());

			$sql_ATIVECON_PRINCIPAL = mysql_query("SELECT * FROM TAB_APOIO_ATIVECONOMICA ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_ATIVECON_SECUNDARIA = mysql_query("SELECT * FROM TAB_APOIO_ATIVECONOMICA ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_ATIVPESCA = mysql_query("SELECT * FROM TAB_APOIO_ATIVPESCA ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TPPROJSUHE = mysql_query("SELECT * FROM TAB_APOIO_TPPROJSUHE ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_DESPESAS = mysql_query("SELECT * FROM TAB_APOIO_DESPESAS ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_RENDAOCUPACOES = mysql_query("SELECT * FROM TAB_APOIO_OCUPACAO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COMPONENTES_OUTRASRENDAS = mysql_query("SELECT FISH_FCOMP_ID, FISH_FCOMP_NOME FROM TAB_FISH_FAMILIAS_COMPOSICAO WHERE FISH_FAM_ID = '$id_familia' ORDER BY FISH_FCOMP_NOME ASC;", $db) or die(mysql_error());
			$sql_BENEFSOCIAIS = mysql_query("SELECT * FROM TAB_APOIO_BENEFSOCIAIS ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COMPONENTES_BENEFICIOS = mysql_query("SELECT FISH_FCOMP_ID, FISH_FCOMP_NOME FROM TAB_FISH_FAMILIAS_COMPOSICAO WHERE FISH_FAM_ID = '$id_familia' ORDER BY FISH_FCOMP_NOME ASC;", $db) or die(mysql_error());
			$sql_UNITMEDIDA_TAMANHO = mysql_query("SELECT * FROM TAB_APOIO_UNIDMED_TAMANHO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_UNITMEDIDA_TEMPO = mysql_query("SELECT * FROM TAB_APOIO_UNIDMED_TEMPO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_FREQCONSMPROT_PEIXE = mysql_query("SELECT * FROM TAB_APOIO_FREQCONSUMPROT ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_STATUSATEND = mysql_query("SELECT * FROM TAB_APOIO_STATUSATENDFISH ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
			$sql_CARAC_DESTINOPESCA = mysql_query("SELECT * FROM TAB_APOIO_PESCA_TIPO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COOP_CARACT_COMERCIO = mysql_query("SELECT * FROM TAB_APOIO_PESCA_COMERCIO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());			
			$sql_COOP_CARACT_MOTIVO = mysql_query("SELECT * FROM TAB_APOIO_PESCA_MOTIVO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COOP_CARACT_LOCAIS = mysql_query("SELECT TAB_APOIO_PESCA_LOCAIS.ID, TAB_APOIO_PESCA_LOCAIS.DESCRICAO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS MUNICIPIO_DESC FROM TAB_APOIO_PESCA_LOCAIS LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_APOIO_PESCA_LOCAIS.MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID ORDER BY TAB_APOIO_PESCA_LOCAIS.DESCRICAO ASC, MUNICIPIO_DESC ASC;", $db) or die(mysql_error());
			$sql_COOP_CARACT_ESPECIES = mysql_query("SELECT * FROM TAB_APOIO_PESCA_ESPECIES ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COOP_CARACT_EMBARC_TIPO = mysql_query("SELECT * FROM TAB_APOIO_EMBARC_TIPO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COOP_CARACT_EMBARC_MATERIAL = mysql_query("SELECT * FROM TAB_APOIO_EMBARC_MATERIAL ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COOP_CARACT_EMBARC_CONSERV = mysql_query("SELECT * FROM TAB_APOIO_ESTADOCONSERV ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COOP_CARACT_MOTOR_TIPO = mysql_query("SELECT * FROM TAB_APOIO_EMBARC_MOTOR ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COOP_CARACT_MOTOR_CONSERV = mysql_query("SELECT * FROM TAB_APOIO_ESTADOCONSERV ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COOP_CARACT_TRALHAS = mysql_query("SELECT * FROM TAB_APOIO_PESCA_EQUIP ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
			$sql_CONTRIBUICOESCOOP = mysql_query("SELECT * FROM TAB_APOIO_CONTRIBUICOESCOOP ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_PARTICIPACAOCOOP = mysql_query("SELECT * FROM TAB_APOIO_PARTICIPACAOCOOP ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_MOTIVONAOFILIACAO = mysql_query("SELECT * FROM TAB_APOIO_MOTIVONAOFILIACAO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_DIFICULDADESPRODUCAO = mysql_query("SELECT * FROM TAB_APOIO_DIFICULDADESPRODUCAO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
			$sql_COMP_GENERO = mysql_query("SELECT * FROM TAB_APOIO_GENERO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COMP_PARENTESCO = mysql_query("SELECT * FROM TAB_APOIO_PARENTESCO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COMP_OCUPACAO = mysql_query("SELECT * FROM TAB_APOIO_OCUPACAO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
			$sql_TPPROJETOS_P = mysql_query("select * from TAB_APOIO_TPPROJETO order by DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TPPROJETOS_E = mysql_query("select * from TAB_APOIO_TPPROJETO order by DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TPEVENTOS = mysql_query("SELECT * FROM TAB_APOIO_EVENTOS WHERE DESCRICAO LIKE '%(ATES PESCADOR)%' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TPDOCUMENTOS = mysql_query("select * from TAB_APOIO_TIPODOC WHERE ID > 0 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());

			$sql_RESUMO_EQUIP = mysql_query("select * from TAB_APOIO_PESCA_EQUIP order by DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_RESUMO_COMERCIO = mysql_query("select * from TAB_APOIO_PESCA_COMERCIO order by DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_RESUMO_MOTIVO = mysql_query("select * from TAB_APOIO_PESCA_MOTIVO order by DESCRICAO ASC;", $db) or die(mysql_error());
			
			$sql_DADOS = mysql_query("SELECT * FROM TAB_FISH_DADOS WHERE FISH_FAM_ID = '$id_familia';", $db) or die(mysql_error());
			$num_DADOS = mysql_num_rows($sql_DADOS);
			$vetor_DADOS = mysql_fetch_array($sql_DADOS);

			$sql_PERFILENT = mysql_query("SELECT * FROM TAB_FISH_PERFILENT WHERE FISH_FAM_ID = '$id_familia';", $db) or die(mysql_error());
			$num_PERFILENT = mysql_num_rows($sql_PERFILENT);
			$vetor_PERFILENT = mysql_fetch_array($sql_PERFILENT);

			$sql_RESUMO = mysql_query("SELECT * FROM TAB_FISH_ACOMP_ANTESTRANS WHERE FISH_FAM_ID = '$id_familia';", $db) or die(mysql_error());
			$num_RESUMO = mysql_num_rows($sql_RESUMO);
			$vetor_RESUMO = mysql_fetch_array($sql_RESUMO);

			$sql_COOPERATIVA = mysql_query("SELECT * FROM TAB_FISH_COOP_ENTREVISTA WHERE FISH_FAM_ID = '$id_familia';", $db) or die(mysql_error());
			$num_COOPERATIVA = mysql_num_rows($sql_COOPERATIVA);
			$vetor_COOPERATIVA = mysql_fetch_array($sql_COOPERATIVA);
			$sql_EXPECTATIVAS = mysql_query("SELECT * FROM TAB_FISH_COOP_EXPECTATIVAS WHERE FISH_FAM_ID = '$id_familia';", $db) or die(mysql_error());
			$vetor_EXPECTATIVAS = mysql_fetch_array($sql_EXPECTATIVAS);
			$sql_CARACTERISTICAS = mysql_query("SELECT * FROM TAB_FISH_COOP_CARACTERIZACAO WHERE FISH_FAM_ID = '$id_familia';", $db) or die(mysql_error());
			$vetor_CARACTERISTICAS = mysql_fetch_array($sql_CARACTERISTICAS);
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
<script src="tabs/tabcontent.js" type="text/javascript"></script>
<link href="tabs/template1/tabcontent.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var qtdeCampos_DOC = 0;
function addCampos_DOC() {
var objPai_DOC = document.getElementById("campoPai_DOC"); //Criando o elemento DIV;
var objFilho_DOC = document.createElement("div"); //Definindo atributos ao objFilho:
objFilho_DOC.setAttribute("id","filho_DOC"+qtdeCampos_DOC); //Inserindo o elemento no pai:
objPai_DOC.appendChild(objFilho_DOC); //Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filho_DOC"+qtdeCampos_DOC).innerHTML = "<table width='100%' border='0'><tr><td width='10%' class='style12'><input type='text' name='FISH_DOC_DATA[]' id='FISH_DOC_DATA' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10' placeholder='Digite a data...'></td><td width='1%'></td><td width='30%'><select name='FISH_DOC_TIPO[]' id='FISH_DOC_TIPO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_TPDOCUMENTOS=mysql_fetch_array($sql_TPDOCUMENTOS)) { ?><option value='<?php echo  $vetor_TPDOCUMENTOS[ID]; ?>'><?php echo $vetor_TPDOCUMENTOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='20%' class='style12'><input type='text' name='FISH_DOC_DESCRICAO[]' id='FISH_DOC_DESCRICAO' class='form-control' placeholder='Digite a descrição...'></td><td width='1%'></td><td width='30%' class='style12'><input type='file' name='FISH_DOC_ARQUIVO[]' id='FISH_DOC_ARQUIVO' class='form-control'></td><td width='1%'></td><td width='6%' class='style12'><input type='button' onclick='removerCampo_DOC("+qtdeCampos_DOC+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_DOC++;
}
function removerCampo_DOC(id) {
var objPai_DOC = document.getElementById("campoPai_DOC");
var objFilho_DOC = document.getElementById("filho_DOC"+id);
console.log(objPai_DOC); //Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPai_DOC.removeChild(objFilho_DOC);
}

var qtdeCampos_EVENTO = 0;
function addCampos_EVENTO() {
var objPai_EVENTO = document.getElementById("campoPai_EVENTO"); //Criando o elemento DIV;
var objFilho_EVENTO = document.createElement("div"); //Definindo atributos ao objFilho:
objFilho_EVENTO.setAttribute("id","filho_EVENTO"+qtdeCampos_EVENTO); //Inserindo o elemento no pai:
objPai_EVENTO.appendChild(objFilho_EVENTO); //Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filho_EVENTO"+qtdeCampos_EVENTO).innerHTML = "<table width='100%'><tr><td width='100px'><input type='text' name='FISH_EVE_DATA[]' id='FISH_EVE_DATA' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10' placeholder='Digite as data...'></td><td width='3px'></td><td width='250px'><select name='FISH_EVE_TIPO[]' id='FISH_EVE_TIPO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_TPEVENTOS=mysql_fetch_array($sql_TPEVENTOS)) { ?><option value='<?php echo  $vetor_TPEVENTOS[ID]; ?>'><?php echo str_replace('(ATES PESCADOR) ','',$vetor_TPEVENTOS[DESCRICAO]); ?></option><?php } ?></select></td><td width='3px'></td><td width='400px'><input type='text' name='FISH_EVE_OBSERVACOES[]' id='FISH_EVE_OBSERVACOES' class='form-control' placeholder='Digite observações...'></td><td width='3px'></td><td width='100px'><input type='button' onclick='removerCampo_EVENTO("+qtdeCampos_EVENTO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_EVENTO++;
}
function removerCampo_EVENTO(id) {
var objPai_EVENTO = document.getElementById("campoPai_EVENTO");
var objFilho_EVENTO = document.getElementById("filho_EVENTO"+id);
console.log(objPai_EVENTO); //Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPai_EVENTO.removeChild(objFilho_EVENTO);
}

var qtdeCampos_RESUMO_EQUIP = 0;
function addCampos_RESUMO_EQUIP() {
var objPai_RESUMO_EQUIP = document.getElementById("campoPai_RESUMO_EQUIP");
var objFilho_RESUMO_EQUIP = document.createElement("div");
objFilho_RESUMO_EQUIP.setAttribute("id","filho_RESUMO_EQUIP"+qtdeCampos_RESUMO_EQUIP);
objPai_RESUMO_EQUIP.appendChild(objFilho_RESUMO_EQUIP);
document.getElementById("filho_RESUMO_EQUIP"+qtdeCampos_RESUMO_EQUIP).innerHTML = "<table width='98%'><tr><td width='80%'><select name='FISH_AAE_TIPO[]' id='FISH_AAE_TIPO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_RESUMO_EQUIP=mysql_fetch_array($sql_RESUMO_EQUIP)){ ?><option value='<?php echo $vetor_RESUMO_EQUIP[ID]; ?>'><?php echo $vetor_RESUMO_EQUIP[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='18%'><input type='button' onclick='removerCampo_RESUMO_EQUIP("+qtdeCampos_RESUMO_EQUIP+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_RESUMO_EQUIP++;
}
function removerCampo_RESUMO_EQUIP(id) {
var objPai_RESUMO_EQUIP = document.getElementById("campoPai_RESUMO_EQUIP");
var objFilho_RESUMO_EQUIP = document.getElementById("filho_RESUMO_EQUIP"+id);
console.log(objPai_RESUMO_EQUIP);
var removido = objPai_RESUMO_EQUIP.removeChild(objFilho_RESUMO_EQUIP);
}

var qtdeCampos_RESUMO_COMERCIO = 0;
function addCampos_RESUMO_COMERCIO() {
var objPai_RESUMO_COMERCIO = document.getElementById("campoPai_RESUMO_COMERCIO");
var objFilho_RESUMO_COMERCIO = document.createElement("div");
objFilho_RESUMO_COMERCIO.setAttribute("id","filho_RESUMO_COMERCIO"+qtdeCampos_RESUMO_COMERCIO);
objPai_RESUMO_COMERCIO.appendChild(objFilho_RESUMO_COMERCIO);
document.getElementById("filho_RESUMO_COMERCIO"+qtdeCampos_RESUMO_COMERCIO).innerHTML = "<table width='98%'><tr><td width='80%'><select name='FISH_AAC_TIPO[]' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_RESUMO_COMERCIO=mysql_fetch_array($sql_RESUMO_COMERCIO)){ ?><option value='<?php echo $vetor_RESUMO_COMERCIO[ID]; ?>'><?php echo $vetor_RESUMO_COMERCIO[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='18%'><input type='button' onclick='removerCampo_RESUMO_COMERCIO("+qtdeCampos_RESUMO_COMERCIO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_RESUMO_COMERCIO++;
}
function removerCampo_RESUMO_COMERCIO(id) {
var objPai_RESUMO_COMERCIO = document.getElementById("campoPai_RESUMO_COMERCIO");
var objFilho_RESUMO_COMERCIO = document.getElementById("filho_RESUMO_COMERCIO"+id);
console.log(objPai_RESUMO_COMERCIO);
var removido = objPai_RESUMO_COMERCIO.removeChild(objFilho_RESUMO_COMERCIO);
}

var qtdeCampos_RESUMO_MOTIVO = 0;
function addCampos_RESUMO_MOTIVO() {
var objPai_RESUMO_MOTIVO = document.getElementById("campoPai_RESUMO_MOTIVO");
var objFilho_RESUMO_MOTIVO = document.createElement("div");
objFilho_RESUMO_MOTIVO.setAttribute("id","filho_RESUMO_MOTIVO"+qtdeCampos_RESUMO_MOTIVO);
objPai_RESUMO_MOTIVO.appendChild(objFilho_RESUMO_MOTIVO);
document.getElementById("filho_RESUMO_MOTIVO"+qtdeCampos_RESUMO_MOTIVO).innerHTML = "<table width='98%'><tr><td width='80%'><select name='FISH_AAM_TIPO[]' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_RESUMO_MOTIVO=mysql_fetch_array($sql_RESUMO_MOTIVO)){ ?><option value='<?php echo $vetor_RESUMO_MOTIVO[ID]; ?>'><?php echo $vetor_RESUMO_MOTIVO[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='18%'><input type='button' onclick='removerCampo_RESUMO_MOTIVO("+qtdeCampos_RESUMO_MOTIVO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_RESUMO_MOTIVO++;
}
function removerCampo_RESUMO_MOTIVO(id) {
var objPai_RESUMO_MOTIVO = document.getElementById("campoPai_RESUMO_MOTIVO");
var objFilho_RESUMO_MOTIVO = document.getElementById("filho_RESUMO_MOTIVO"+id);
console.log(objPai_RESUMO_MOTIVO);
var removido = objPai_RESUMO_MOTIVO.removeChild(objFilho_RESUMO_MOTIVO);
}

var qtdeCampos_COOP_PROJETONESA = 0;
function addCampos_COOP_PROJETONESA() {
var objPai_COOP_PROJETONESA = document.getElementById("campoPai_COOP_PROJETONESA");
var objFilho_COOP_PROJETONESA = document.createElement("div");
objFilho_COOP_PROJETONESA.setAttribute("id","filho_COOP_PROJETONESA"+qtdeCampos_COOP_PROJETONESA);
objPai_COOP_PROJETONESA.appendChild(objFilho_COOP_PROJETONESA);
document.getElementById("filho_COOP_PROJETONESA"+qtdeCampos_COOP_PROJETONESA).innerHTML = "<table width='100%'><tr><td width='88%'><select name='FISH_COOUHE_PROJETO[]' id='FISH_COOUHE_PROJETO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_TPPROJSUHE=mysql_fetch_array($sql_TPPROJSUHE)) { ?><option value='<?php echo  $vetor_TPPROJSUHE[ID]; ?>'><?php echo $vetor_TPPROJSUHE[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_PROJETONESA("+qtdeCampos_COOP_PROJETONESA+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_PROJETONESA++;
}
function removerCampo_COOP_PROJETONESA(id) {
var objPai_COOP_PROJETONESA = document.getElementById("campoPai_COOP_PROJETONESA");
var objFilho_COOP_PROJETONESA = document.getElementById("filho_COOP_PROJETONESA"+id);
console.log(objPai_COOP_PROJETONESA);
var removido = objPai_COOP_PROJETONESA.removeChild(objFilho_COOP_PROJETONESA);
}	

var qtdeCampos_COOP_DESPESAS = 0;
function addCampos_COOP_DESPESAS() {
var objPai_COOP_DESPESAS = document.getElementById("campoPai_COOP_DESPESAS");
var objFilho_COOP_DESPESAS = document.createElement("div");
objFilho_COOP_DESPESAS.setAttribute("id","filho_COOP_DESPESAS"+qtdeCampos_COOP_DESPESAS);
objPai_COOP_DESPESAS.appendChild(objFilho_COOP_DESPESAS);
document.getElementById("filho_COOP_DESPESAS"+qtdeCampos_COOP_DESPESAS).innerHTML = "<table width='100%'><tr><td width='55%'><select name='FISH_COODES_DESPESA[]' id='FISH_COODES_DESPESA' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_DESPESAS=mysql_fetch_array($sql_DESPESAS)) { ?><option value='<?php echo  $vetor_DESPESAS[ID]; ?>'><?php echo $vetor_DESPESAS[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='31%'><input type='text' name='FISH_COODES_VALOR[]' id='FISH_COODES_VALOR' class='form-control' placeholder='Valor...' onKeyPress='mascara(this,mvalor)' maxlength='10'></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_DESPESAS("+qtdeCampos_COOP_DESPESAS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_DESPESAS++;
}
function removerCampo_COOP_DESPESAS(id) {
var objPai_COOP_DESPESAS = document.getElementById("campoPai_COOP_DESPESAS");
var objFilho_COOP_DESPESAS = document.getElementById("filho_COOP_DESPESAS"+id);
console.log(objPai_COOP_DESPESAS);
var removido = objPai_COOP_DESPESAS.removeChild(objFilho_COOP_DESPESAS);
}

var qtdeCampos_COOP_OUTRASRENDAS = 0;
function addCampos_COOP_OUTRASRENDAS() {
var objPai_COOP_OUTRASRENDAS = document.getElementById("campoPai_COOP_OUTRASRENDAS");
var objFilho_COOP_OUTRASRENDAS = document.createElement("div");
objFilho_COOP_OUTRASRENDAS.setAttribute("id","filho_COOP_OUTRASRENDAS"+qtdeCampos_COOP_OUTRASRENDAS);
objPai_COOP_OUTRASRENDAS.appendChild(objFilho_COOP_OUTRASRENDAS);
document.getElementById("filho_COOP_OUTRASRENDAS"+qtdeCampos_COOP_OUTRASRENDAS).innerHTML = "<table width='100%'><tr><td width='31%'><select name='FISH_COOREN_COMPONENTE[]' id='FISH_COOREN_COMPONENTE' class='form-control'><option value='0' selected='selected'>Selecione um componente...</option><?php while ($vetor_COMPONENTES_OUTRASRENDAS = mysql_fetch_array($sql_COMPONENTES_OUTRASRENDAS)) { ?><option value='<?php echo $vetor_COMPONENTES_OUTRASRENDAS[FISH_FCOMP_ID]; ?>'><?php echo $vetor_COMPONENTES_OUTRASRENDAS[FISH_FCOMP_NOME]; ?></option><?php } ?></select></td><td width='2%'></td><td width='31%'><select name='FISH_COOREN_OCUPACAO[]' id='FISH_COOREN_OCUPACAO' class='form-control'><option value='0' selected='selected'>Selecione uma ocupação...</option><?php while ($vetor_RENDAOCUPACOES=mysql_fetch_array($sql_RENDAOCUPACOES)) { ?><option value='<?php echo  $vetor_RENDAOCUPACOES[ID]; ?>'><?php echo $vetor_RENDAOCUPACOES[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='20%'><input type='text' name='FISH_COOREN_RENDA[]' id='FISH_COOREN_RENDA' class='form-control' placeholder='Valor...' onKeyPress='mascara(this,mvalor)' maxlength='10'></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_OUTRASRENDAS("+qtdeCampos_COOP_OUTRASRENDAS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_OUTRASRENDAS++;
}
function removerCampo_COOP_OUTRASRENDAS(id) {
var objPai_COOP_OUTRASRENDAS = document.getElementById("campoPai_COOP_OUTRASRENDAS");
var objFilho_COOP_OUTRASRENDAS = document.getElementById("filho_COOP_OUTRASRENDAS"+id);
console.log(objPai_COOP_OUTRASRENDAS);
var removido = objPai_COOP_OUTRASRENDAS.removeChild(objFilho_COOP_OUTRASRENDAS);
}	

var qtdeCampos_COOP_BENEFICIOS= 0;
function addCampos_COOP_BENEFICIOS() {
var objPai_COOP_BENEFICIOS = document.getElementById("campoPai_COOP_BENEFICIOS");
var objFilho_COOP_BENEFICIOS = document.createElement("div");
objFilho_COOP_BENEFICIOS.setAttribute("id","filho_COOP_BENEFICIOS"+qtdeCampos_COOP_BENEFICIOS);
objPai_COOP_BENEFICIOS.appendChild(objFilho_COOP_BENEFICIOS);
document.getElementById("filho_COOP_BENEFICIOS"+qtdeCampos_COOP_BENEFICIOS).innerHTML = "<table width='100%'><tr><td width='31%'><select name='FISH_COOBEN_COMPONENTE[]' id='FISH_COOBEN_COMPONENTE' class='form-control'><option value='0' selected='selected'>Selecione um componente...</option><?php while ($vetor_COMPONENTES_BENEFICIOS = mysql_fetch_array($sql_COMPONENTES_BENEFICIOS)) { ?><option value='<?php echo  $vetor_COMPONENTES_BENEFICIOS[FISH_FCOMP_ID]; ?>'><?php echo $vetor_COMPONENTES_BENEFICIOS[FISH_FCOMP_NOME]; ?></option><?php } ?></select></td><td width='2%'></td><td width='31%'><select name='FISH_COOBEN_BENEFICIO[]' id='FISH_COOBEN_BENEFICIO' class='form-control'><option value='0' selected='selected'>Selecione um benefício...</option><?php while ($vetor_BENEFSOCIAIS = mysql_fetch_array($sql_BENEFSOCIAIS)) { ?><option value='<?php echo  $vetor_BENEFSOCIAIS[ID]; ?>'><?php echo $vetor_BENEFSOCIAIS[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='20%'><input type='text' name='FISH_COOBEN_RENDA[]' id='FISH_COOBEN_RENDA' class='form-control' placeholder='Valor...' onKeyPress='mascara(this,mvalor)' maxlength='10'></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_BENEFICIOS("+qtdeCampos_COOP_BENEFICIOS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_BENEFICIOS++;
}
function removerCampo_COOP_BENEFICIOS(id) {
var objPai_COOP_BENEFICIOS= document.getElementById("campoPai_COOP_BENEFICIOS");
var objFilho_COOP_BENEFICIOS= document.getElementById("filho_COOP_BENEFICIOS"+id);
console.log(objPai_COOP_BENEFICIOS);
var removido = objPai_COOP_BENEFICIOS.removeChild(objFilho_COOP_BENEFICIOS);
}

var qtdeCampos_COOP_DIFICULDADESPRODUCAO = 0;
function addCampos_COOP_DIFICULDADESPRODUCAO() {
var objPai_COOP_DIFICULDADESPRODUCAO = document.getElementById("campoPai_COOP_DIFICULDADESPRODUCAO");
var objFilho_COOP_DIFICULDADESPRODUCAO = document.createElement("div");
objFilho_COOP_DIFICULDADESPRODUCAO.setAttribute("id","filho_COOP_DIFICULDADESPRODUCAO"+qtdeCampos_COOP_DIFICULDADESPRODUCAO);
objPai_COOP_DIFICULDADESPRODUCAO.appendChild(objFilho_COOP_DIFICULDADESPRODUCAO);
document.getElementById("filho_COOP_DIFICULDADESPRODUCAO"+qtdeCampos_COOP_DIFICULDADESPRODUCAO).innerHTML = "<table width='100%'><tr><td width='88%'><select name='FISH_CPXDIF_DIFICULDADE[]' id='FISH_CPXDIF_DIFICULDADE' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_DIFICULDADESPRODUCAO=mysql_fetch_array($sql_DIFICULDADESPRODUCAO)) { ?><option value='<?php echo  $vetor_DIFICULDADESPRODUCAO[ID]; ?>'><?php echo $vetor_DIFICULDADESPRODUCAO[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_DIFICULDADESPRODUCAO("+qtdeCampos_COOP_DIFICULDADESPRODUCAO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_DIFICULDADESPRODUCAO++;
}
function removerCampo_COOP_DIFICULDADESPRODUCAO(id) {
var objPai_COOP_DIFICULDADESPRODUCAO = document.getElementById("campoPai_COOP_DIFICULDADESPRODUCAO");
var objFilho_COOP_DIFICULDADESPRODUCAO = document.getElementById("filho_COOP_DIFICULDADESPRODUCAO"+id);
console.log(objPai_COOP_DIFICULDADESPRODUCAO);
var removido = objPai_COOP_DIFICULDADESPRODUCAO.removeChild(objFilho_COOP_DIFICULDADESPRODUCAO);
}

var qtdeCampos_COOP_CONTRIBUICOESCOOP = 0;
function addCampos_COOP_CONTRIBUICOESCOOP() {
var objPai_COOP_CONTRIBUICOESCOOP = document.getElementById("campoPai_COOP_CONTRIBUICOESCOOP");
var objFilho_COOP_CONTRIBUICOESCOOP = document.createElement("div");
objFilho_COOP_CONTRIBUICOESCOOP.setAttribute("id","filho_COOP_CONTRIBUICOESCOOP"+qtdeCampos_COOP_CONTRIBUICOESCOOP);
objPai_COOP_CONTRIBUICOESCOOP.appendChild(objFilho_COOP_CONTRIBUICOESCOOP);
document.getElementById("filho_COOP_CONTRIBUICOESCOOP"+qtdeCampos_COOP_CONTRIBUICOESCOOP).innerHTML = "<table width='100%'><tr><td width='88%'><select name='FISH_CPXCON_CONTRIBUICAO[]' id='FISH_CPXCON_CONTRIBUICAO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_CONTRIBUICOESCOOP=mysql_fetch_array($sql_CONTRIBUICOESCOOP)) { ?><option value='<?php echo  $vetor_CONTRIBUICOESCOOP[ID]; ?>'><?php echo $vetor_CONTRIBUICOESCOOP[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_CONTRIBUICOESCOOP("+qtdeCampos_COOP_CONTRIBUICOESCOOP+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_CONTRIBUICOESCOOP++;
}
function removerCampo_COOP_CONTRIBUICOESCOOP(id) {
var objPai_COOP_CONTRIBUICOESCOOP = document.getElementById("campoPai_COOP_CONTRIBUICOESCOOP");
var objFilho_COOP_CONTRIBUICOESCOOP = document.getElementById("filho_COOP_CONTRIBUICOESCOOP"+id);
console.log(objPai_COOP_CONTRIBUICOESCOOP);
var removido = objPai_COOP_CONTRIBUICOESCOOP.removeChild(objFilho_COOP_CONTRIBUICOESCOOP);
}

var qtdeCampos_COOP_PARTICIPACAOCOOP = 0;
function addCampos_COOP_PARTICIPACAOCOOP() {
var objPai_COOP_PARTICIPACAOCOOP = document.getElementById("campoPai_COOP_PARTICIPACAOCOOP");
var objFilho_COOP_PARTICIPACAOCOOP = document.createElement("div");
objFilho_COOP_PARTICIPACAOCOOP.setAttribute("id","filho_COOP_PARTICIPACAOCOOP"+qtdeCampos_COOP_PARTICIPACAOCOOP);
objPai_COOP_PARTICIPACAOCOOP.appendChild(objFilho_COOP_PARTICIPACAOCOOP);
document.getElementById("filho_COOP_PARTICIPACAOCOOP"+qtdeCampos_COOP_PARTICIPACAOCOOP).innerHTML = "<table width='100%'><tr><td width='88%'><select name='FISH_CPXPAR_PARTICIPACAO[]' id='FISH_CPXPAR_PARTICIPACAO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_PARTICIPACAOCOOP=mysql_fetch_array($sql_PARTICIPACAOCOOP)) { ?><option value='<?php echo  $vetor_PARTICIPACAOCOOP[ID]; ?>'><?php echo $vetor_PARTICIPACAOCOOP[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_PARTICIPACAOCOOP("+qtdeCampos_COOP_PARTICIPACAOCOOP+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_PARTICIPACAOCOOP++;
}
function removerCampo_COOP_PARTICIPACAOCOOP(id) {
var objPai_COOP_PARTICIPACAOCOOP = document.getElementById("campoPai_COOP_PARTICIPACAOCOOP");
var objFilho_COOP_PARTICIPACAOCOOP = document.getElementById("filho_COOP_PARTICIPACAOCOOP"+id);
console.log(objPai_COOP_PARTICIPACAOCOOP);
var removido = objPai_COOP_PARTICIPACAOCOOP.removeChild(objFilho_COOP_PARTICIPACAOCOOP);
}

var qtdeCampos_COOP_MOTIVONAOFILIACAO = 0;
function addCampos_COOP_MOTIVONAOFILIACAO() {
var objPai_COOP_MOTIVONAOFILIACAO = document.getElementById("campoPai_COOP_MOTIVONAOFILIACAO");
var objFilho_COOP_MOTIVONAOFILIACAO = document.createElement("div");
objFilho_COOP_MOTIVONAOFILIACAO.setAttribute("id","filho_COOP_MOTIVONAOFILIACAO"+qtdeCampos_COOP_MOTIVONAOFILIACAO);
objPai_COOP_MOTIVONAOFILIACAO.appendChild(objFilho_COOP_MOTIVONAOFILIACAO);

document.getElementById("filho_COOP_MOTIVONAOFILIACAO"+qtdeCampos_COOP_MOTIVONAOFILIACAO).innerHTML = "<table width='100%'><tr><td width='88%'><select name='FISH_CPXNAO_MOTIVO[]' id='FISH_CPXNAO_MOTIVO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_MOTIVONAOFILIACAO=mysql_fetch_array($sql_MOTIVONAOFILIACAO)) { ?><option value='<?php echo  $vetor_MOTIVONAOFILIACAO[ID]; ?>'><?php echo $vetor_MOTIVONAOFILIACAO[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_MOTIVONAOFILIACAO("+qtdeCampos_COOP_MOTIVONAOFILIACAO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_MOTIVONAOFILIACAO++;
}
function removerCampo_COOP_MOTIVONAOFILIACAO(id) {
var objPai_COOP_MOTIVONAOFILIACAO = document.getElementById("campoPai_COOP_MOTIVONAOFILIACAO");
var objFilho_COOP_MOTIVONAOFILIACAO = document.getElementById("filho_COOP_MOTIVONAOFILIACAO"+id);
console.log(objPai_COOP_MOTIVONAOFILIACAO);
var removido = objPai_COOP_MOTIVONAOFILIACAO.removeChild(objFilho_COOP_MOTIVONAOFILIACAO);
}

var qtdeCamposCOMPONENTE = 0;
function addCamposCOMPONENTE() {
var objPaiCOMPONENTE = document.getElementById("campoPaiCOMPONENTE");
var objFilhoCOMPONENTE = document.createElement("div");
objFilhoCOMPONENTE.setAttribute("id","filho"+qtdeCamposCOMPONENTE);
objPaiCOMPONENTE.appendChild(objFilhoCOMPONENTE);
document.getElementById("filho"+qtdeCamposCOMPONENTE).innerHTML = "<table width='100%'><tr><td width='30%' class='style12'><input type='text' name='FISH_FCOMP_NOME[]' id='FISH_FCOMP_NOME' class='form-control' placeholder='Nome...'></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='FISH_FCOMP_APELIDO[]' id='FISH_FCOMP_APELIDO' class='form-control' placeholder='Apelido...'></td><td width='1%'></td><td width='30%' class='style12'><select name='FISH_FCOMP_GENERO[]' id='FISH_FCOMP_GENERO' class='form-control'><option value='0' selected='selected'>Gênero...</option><?php while ($vetor_COMP_GENERO = mysql_fetch_array($sql_COMP_GENERO)){ ?><option value='<?php echo $vetor_COMP_GENERO[ID]; ?>'><?php echo $vetor_COMP_GENERO[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='7%'><input type='button' onclick='removerCampoCOMPONENTE("+qtdeCamposCOMPONENTE+")' value='Remover' class='btn btn-inline'></td></tr><tr><td width='30%' class='style12'><select name='FISH_FCOMP_PARENTESCO[]' id='FISH_FCOMP_PARENTESCO' class='form-control'><option value='0' selected='selected'>Parentesco...</option><?php while ($vetor_COMP_PARENTESCO = mysql_fetch_array($sql_COMP_PARENTESCO)){ ?><option value='<?php echo $vetor_COMP_PARENTESCO[ID]; ?>'><?php echo $vetor_COMP_PARENTESCO[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='FISH_FCOMP_DTNASC[]' id='FISH_FCOMP_DTNASC' class='form-control' placeholder='Data de nascimento...' onKeyPress='mascara(this,mdata)'></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='FISH_FCOMP_IDADE[]' id='FISH_FCOMP_IDADE' class='form-control' placeholder='Idade...' onKeyPress='mascara(this,minteiro)'></td><td width='7%'>&nbsp;</td></tr><tr><td width='30%' class='style12'><select name='FISH_FCOMP_OCUPACAO[]' id='FISH_FCOMP_OCUPACAO' class='form-control'><option value='0' selected='selected'>Profissão/Ocupação...</option><?php while ($vetor_COMP_OCUPACAO = mysql_fetch_array($sql_COMP_OCUPACAO)){ ?><option value='<?php echo $vetor_COMP_OCUPACAO[ID]; ?>'><?php echo $vetor_COMP_OCUPACAO[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='30%' class='style12'><select name='FISH_FCOMP_ALFAB_LER[]' id='FISH_FCOMP_ALFAB_LER' class='form-control'><option value='0'>Sabe ler?</option><option value='1'>SIM</option><option value='2'>NÃO</option></select></td><td width='1%'></td><td width='30%' class='style12'><select name='FISH_FCOMP_ALFAB_ESCREVER[]' id='FISH_FCOMP_ALFAB_ESCREVER' class='form-control'><option value='0'>Sabe escrever?</option><option value='1'>SIM</option><option value='2'>NÃO</option></select></td><td width='1%'></td><td width='7%'>&nbsp;</td></tr><tr><td width='30%' class='style12'><select name='FISH_FCOMP_RGP_POSSUI[]' id='FISH_FCOMP_RGP_POSSUI' class='form-control'><option value='0'>Possui Registro de Pesca?</option><option value='1'>SIM</option><option value='2'>NÃO</option></select></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='FISH_FCOMP_RGP_NUMERO[]' id='FISH_FCOMP_RGP_NUMERO' class='form-control' placeholder='Número...'></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='FISH_FCOMP_RGP_DTREGISTRO[]' id='FISH_FCOMP_RGP_DTREGISTRO' class='form-control' placeholder='Data do registro...' onKeyPress='mascara(this,mdata)'></td><td width='1%'><td width='7%'>&nbsp;</td></tr><tr><td width='30%' class='style12'><select name='FISH_FCOMP_RG_POSSUI[]' id='FISH_FCOMP_RG_POSSUI' class='form-control'><option value='0'>Possui R.G.?</option><option value='1'>SIM</option><option value='2'>NÃO</option></select></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='FISH_FCOMP_RG_NUMERO[]' id='FISH_FCOMP_RG_NUMERO' class='form-control' placeholder='Número...'></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='FISH_FCOMP_RG_DTREGISTRO[]' id='FISH_FCOMP_RG_DTREGISTRO' class='form-control' placeholder='Data do registro...' onKeyPress='mascara(this,mdata)'></td><td width='1%'><td width='7%'>&nbsp;</td></tr><tr><td width='30%' class='style12'><select name='FISH_FCOMP_CPF_POSSUI[]' id='FISH_FCOMP_CPF_POSSUI' class='form-control'><option value='0'>Possui C.P.F.?</option><option value='1'>SIM</option><option value='2'>NÃO</option></select></td><td width='1%'></td><td width='30%' class='style12'><input type='text' name='FISH_FCOMP_CPF_NUMERO[]' id='FISH_FCOMP_CPF_NUMERO' class='form-control' placeholder='Número...'></td><td width='1%'></td><td width='30%' class='style12'><select name='FISH_FCOMP_RESIDENTE[]' id='FISH_FCOMP_RESIDENTE' class='form-control'><option value='0'>Residente?</option><option value='1'>SIM</option><option value='2'>NÃO</option></select></td><td width='1%'></td><td width='7%'>&nbsp;</td></tr></table><hr>";
qtdeCamposCOMPONENTE++;
}
function removerCampoCOMPONENTE(id) {
var objPaiCOMPONENTE = document.getElementById("campoPaiCOMPONENTE");
var objFilhoCOMPONENTE = document.getElementById("filho"+id);
console.log(objPaiCOMPONENTE);
var removido = objPaiCOMPONENTE.removeChild(objFilhoCOMPONENTE);
}

var qtdeCampos_COOP_CARACT_MOTIVO = 0;
function addCampos_COOP_CARACT_MOTIVO() {
var objPai_COOP_CARACT_MOTIVO = document.getElementById("campoPai_COOP_CARACT_MOTIVO");
var objFilho_COOP_CARACT_MOTIVO = document.createElement("div");
objFilho_COOP_CARACT_MOTIVO.setAttribute("id","filho_COOP_CARACT_MOTIVO"+qtdeCampos_COOP_CARACT_MOTIVO);
objPai_COOP_CARACT_MOTIVO.appendChild(objFilho_COOP_CARACT_MOTIVO);
document.getElementById("filho_COOP_CARACT_MOTIVO"+qtdeCampos_COOP_CARACT_MOTIVO).innerHTML = "<table width='100%'><tr><td width='88%'><select name='FISH_CPCMOT_MOTIVO[]' id='FISH_CPCMOT_MOTIVO' class='form-control'><option value='0' selected='selected'>Selecione um motivo...</option><?php while ($vetor_COOP_CARACT_MOTIVO=mysql_fetch_array($sql_COOP_CARACT_MOTIVO)) { ?><option value='<?php echo  $vetor_COOP_CARACT_MOTIVO[ID]; ?>'><?php echo $vetor_COOP_CARACT_MOTIVO[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_CARACT_MOTIVO("+qtdeCampos_COOP_CARACT_MOTIVO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_CARACT_MOTIVO++;
}
function removerCampo_COOP_CARACT_MOTIVO(id) {
var objPai_COOP_CARACT_MOTIVO = document.getElementById("campoPai_COOP_CARACT_MOTIVO");
var objFilho_COOP_CARACT_MOTIVO = document.getElementById("filho_COOP_CARACT_MOTIVO"+id);
console.log(objPai_COOP_CARACT_MOTIVO);
var removido = objPai_COOP_CARACT_MOTIVO.removeChild(objFilho_COOP_CARACT_MOTIVO);
}	
	
var qtdeCampos_COOP_CARACT_COMERCIO = 0;
function addCampos_COOP_CARACT_COMERCIO() {
var objPai_COOP_CARACT_COMERCIO = document.getElementById("campoPai_COOP_CARACT_COMERCIO");
var objFilho_COOP_CARACT_COMERCIO = document.createElement("div");
objFilho_COOP_CARACT_COMERCIO.setAttribute("id","filho_COOP_CARACT_COMERCIO"+qtdeCampos_COOP_CARACT_COMERCIO);
objPai_COOP_CARACT_COMERCIO.appendChild(objFilho_COOP_CARACT_COMERCIO);
document.getElementById("filho_COOP_CARACT_COMERCIO"+qtdeCampos_COOP_CARACT_COMERCIO).innerHTML = "<table width='100%'><tr><td width='88%'><select name='FISH_CPCCOM_COMERCIO[]' id='FISH_CPCCOM_COMERCIO' class='form-control'><option value='0' selected='selected'>Selecione um motivo...</option><?php while ($vetor_COOP_CARACT_COMERCIO=mysql_fetch_array($sql_COOP_CARACT_COMERCIO)) { ?><option value='<?php echo  $vetor_COOP_CARACT_COMERCIO[ID]; ?>'><?php echo $vetor_COOP_CARACT_COMERCIO[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_CARACT_COMERCIO("+qtdeCampos_COOP_CARACT_COMERCIO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_CARACT_COMERCIO++;
}
function removerCampo_COOP_CARACT_COMERCIO(id) {
var objPai_COOP_CARACT_COMERCIO = document.getElementById("campoPai_COOP_CARACT_COMERCIO");
var objFilho_COOP_CARACT_COMERCIO = document.getElementById("filho_COOP_CARACT_COMERCIO"+id);
console.log(objPai_COOP_CARACT_COMERCIO);
var removido = objPai_COOP_CARACT_COMERCIO.removeChild(objFilho_COOP_CARACT_COMERCIO);
}
	
var qtdeCampos_COOP_CARACT_LOCAIS = 0;
function addCampos_COOP_CARACT_LOCAIS() {
var objPai_COOP_CARACT_LOCAIS = document.getElementById("campoPai_COOP_CARACT_LOCAIS");
var objFilho_COOP_CARACT_LOCAIS = document.createElement("div");
objFilho_COOP_CARACT_LOCAIS.setAttribute("id","filho_COOP_CARACT_LOCAIS"+qtdeCampos_COOP_CARACT_LOCAIS);
objPai_COOP_CARACT_LOCAIS.appendChild(objFilho_COOP_CARACT_LOCAIS);
document.getElementById("filho_COOP_CARACT_LOCAIS"+qtdeCampos_COOP_CARACT_LOCAIS).innerHTML = "<table width='100%'><tr><td width='88%'><select name='FISH_CPCLOC_LOCAL[]' id='FISH_CPCLOC_LOCAL' class='form-control'><option value='0' selected='selected'>Selecione um motivo...</option><?php while ($vetor_COOP_CARACT_LOCAIS=mysql_fetch_array($sql_COOP_CARACT_LOCAIS)) { ?><option value='<?php echo  $vetor_COOP_CARACT_LOCAIS[ID]; ?>'><?php echo $vetor_COOP_CARACT_LOCAIS[DESCRICAO].'/'.$vetor_COOP_CARACT_LOCAIS[MUNICIPIO_DESC]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_CARACT_LOCAIS("+qtdeCampos_COOP_CARACT_LOCAIS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_CARACT_LOCAIS++;
}
function removerCampo_COOP_CARACT_LOCAIS(id) {
var objPai_COOP_CARACT_LOCAIS = document.getElementById("campoPai_COOP_CARACT_LOCAIS");
var objFilho_COOP_CARACT_LOCAIS = document.getElementById("filho_COOP_CARACT_LOCAIS"+id);
console.log(objPai_COOP_CARACT_LOCAIS);
var removido = objPai_COOP_CARACT_LOCAIS.removeChild(objFilho_COOP_CARACT_LOCAIS);
}

var qtdeCampos_COOP_CARACT_ESPECIES = 0;
function addCampos_COOP_CARACT_ESPECIES() {
var objPai_COOP_CARACT_ESPECIES = document.getElementById("campoPai_COOP_CARACT_ESPECIES");
var objFilho_COOP_CARACT_ESPECIES = document.createElement("div");
objFilho_COOP_CARACT_ESPECIES.setAttribute("id","filho_COOP_CARACT_ESPECIES"+qtdeCampos_COOP_CARACT_ESPECIES);
objPai_COOP_CARACT_ESPECIES.appendChild(objFilho_COOP_CARACT_ESPECIES);
document.getElementById("filho_COOP_CARACT_ESPECIES"+qtdeCampos_COOP_CARACT_ESPECIES).innerHTML = "<table width='100%'><tr><td width='58%'><select name='FISH_CPCESP_ESPECIE[]' id='FISH_CPCESP_ESPECIE' class='form-control'><option value='0' selected='selected'>Selecione uma espécie...</option><?php while ($vetor_COOP_CARACT_ESPECIES = mysql_fetch_array($sql_COOP_CARACT_ESPECIES)) { ?><option value='<?php echo  $vetor_COOP_CARACT_ESPECIES[ID]; ?>'><?php echo $vetor_COOP_CARACT_ESPECIES[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='28%'><input type='text' name='FISH_CPCESP_VALOR[]' id='FISH_CPCESP_VALOR' class='form-control' placeholder='Valor...' onKeyPress='mascara(this,mvalor)' maxlength='10'></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_CARACT_ESPECIES("+qtdeCampos_COOP_CARACT_ESPECIES+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_CARACT_ESPECIES++;
}
function removerCampo_COOP_CARACT_ESPECIES(id) {
var objPai_COOP_CARACT_ESPECIES = document.getElementById("campoPai_COOP_CARACT_ESPECIES");
var objFilho_COOP_CARACT_ESPECIES = document.getElementById("filho_COOP_CARACT_ESPECIES"+id);
console.log(objPai_COOP_CARACT_ESPECIES);
var removido = objPai_COOP_CARACT_ESPECIES.removeChild(objFilho_COOP_CARACT_ESPECIES);
}

var qtdeCampos_COOP_CARACT_EMBARC = 0;
function addCampos_COOP_CARACT_EMBARC() {
var objPai_COOP_CARACT_EMBARC = document.getElementById("campoPai_COOP_CARACT_EMBARC");
var objFilho_COOP_CARACT_EMBARC = document.createElement("div");
objFilho_COOP_CARACT_EMBARC.setAttribute("id","filho_COOP_CARACT_EMBARC"+qtdeCampos_COOP_CARACT_EMBARC);
objPai_COOP_CARACT_EMBARC.appendChild(objFilho_COOP_CARACT_EMBARC);
document.getElementById("filho_COOP_CARACT_EMBARC"+qtdeCampos_COOP_CARACT_EMBARC).innerHTML = "<table width='100%'><tr><td width='19%' class='style12'><select name='FISH_CPCEMB_TIPO[]' id='FISH_CPCEMB_TIPO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_COOP_CARACT_EMBARC_TIPO = mysql_fetch_array($sql_COOP_CARACT_EMBARC_TIPO)) { ?><option value='<?php echo $vetor_COOP_CARACT_EMBARC_TIPO[ID]; ?>'><?php echo $vetor_COOP_CARACT_EMBARC_TIPO[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='14%' class='style12'><select name='FISH_CPCEMB_PROPRIA[]' id='FISH_CPCEMB_PROPRIA' class='form-control'><option value='0'>Própria?</option><option value='1'>SIM</option><option value='2'>NÃO</option></select></td><td width='1%'></td><td width='19%' class='style12'><select name='FISH_CPCEMB_MATERIAL[]' id='FISH_CPCEMB_MATERIAL' class='form-control'><option value='0' selected='selected'>Selecione um material...</option><?php while ($vetor_COOP_CARACT_EMBARC_MATERIAL = mysql_fetch_array($sql_COOP_CARACT_EMBARC_MATERIAL)) { ?><option value='<?php echo $vetor_COOP_CARACT_EMBARC_MATERIAL[ID]; ?>'><?php echo $vetor_COOP_CARACT_EMBARC_MATERIAL[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='14%'><input type='text' name='FISH_CPCEMB_TAMANHO[]' id='FISH_CPCEMB_TAMANHO' class='form-control' placeholder='Tamanho...' onKeyPress='mascara(this,mvalor)' maxlength='10'></td><td width='1%'></td><td width='19%' class='style12'><select name='FISH_CPCEMB_CONSERV[]' id='FISH_CPCEMB_CONSERV' class='form-control'><option value='0' selected='selected'>Conservação...</option><?php while ($vetor_COOP_CARACT_EMBARC_CONSERV = mysql_fetch_array($sql_COOP_CARACT_EMBARC_CONSERV)) { ?><option value='<?php echo $vetor_COOP_CARACT_EMBARC_CONSERV[ID]; ?>'><?php echo $vetor_COOP_CARACT_EMBARC_CONSERV[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_CARACT_EMBARC("+qtdeCampos_COOP_CARACT_EMBARC+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_CARACT_EMBARC++;
}
function removerCampo_COOP_CARACT_EMBARC(id) {
var objPai_COOP_CARACT_EMBARC = document.getElementById("campoPai_COOP_CARACT_EMBARC");
var objFilho_COOP_CARACT_EMBARC = document.getElementById("filho_COOP_CARACT_EMBARC"+id);
console.log(objPai_COOP_CARACT_EMBARC);
var removido = objPai_COOP_CARACT_EMBARC.removeChild(objFilho_COOP_CARACT_EMBARC);
}
	
var qtdeCampos_COOP_CARACT_MOTOR = 0;
function addCampos_COOP_CARACT_MOTOR() {
var objPai_COOP_CARACT_MOTOR = document.getElementById("campoPai_COOP_CARACT_MOTOR");
var objFilho_COOP_CARACT_MOTOR = document.createElement("div");
objFilho_COOP_CARACT_MOTOR.setAttribute("id","filho_COOP_CARACT_MOTOR"+qtdeCampos_COOP_CARACT_MOTOR);
objPai_COOP_CARACT_MOTOR.appendChild(objFilho_COOP_CARACT_MOTOR);
document.getElementById("filho_COOP_CARACT_MOTOR"+qtdeCampos_COOP_CARACT_MOTOR).innerHTML = "<table width='100%'><tr><td width='19%' class='style12'><select name='FISH_CPCMTR_TIPO[]' id='FISH_CPCMTR_TIPO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_COOP_CARACT_MOTOR_TIPO = mysql_fetch_array($sql_COOP_CARACT_MOTOR_TIPO)) { ?><option value='<?php echo $vetor_COOP_CARACT_MOTOR_TIPO[ID]; ?>'><?php echo $vetor_COOP_CARACT_MOTOR_TIPO[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='14%' class='style12'><select name='FISH_CPCMTR_PROPRIO[]' id='FISH_CPCMTR_PROPRIO' class='form-control'><option value='0'>Próprio?</option><option value='1'>SIM</option><option value='2'>NÃO</option></select></td><td width='1%'></td><td width='19%'>&nbsp;</td><td width='1%'></td><td width='14%'><input type='text' name='FISH_CPCMTR_POTENCIA[]' id='FISH_CPCMTR_POTENCIA' class='form-control' placeholder='Potência...' onKeyPress='mascara(this,mvalor)' maxlength='10'></td><td width='1%'></td><td width='19%' class='style12'><select name='FISH_CPCMTR_CONSERV[]' id='FISH_CPCMTR_CONSERV' class='form-control'><option value='0' selected='selected'>Conservação...</option><?php while ($vetor_COOP_CARACT_MOTOR_CONSERV = mysql_fetch_array($sql_COOP_CARACT_MOTOR_CONSERV)) { ?><option value='<?php echo $vetor_COOP_CARACT_MOTOR_CONSERV[ID]; ?>'><?php echo $vetor_COOP_CARACT_MOTOR_CONSERV[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_CARACT_MOTOR("+qtdeCampos_COOP_CARACT_MOTOR+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_CARACT_MOTOR++;
}
function removerCampo_COOP_CARACT_MOTOR(id) {
var objPai_COOP_CARACT_MOTOR = document.getElementById("campoPai_COOP_CARACT_MOTOR");
var objFilho_COOP_CARACT_MOTOR = document.getElementById("filho_COOP_CARACT_MOTOR"+id);
console.log(objPai_COOP_CARACT_MOTOR);
var removido = objPai_COOP_CARACT_MOTOR.removeChild(objFilho_COOP_CARACT_MOTOR);
}

var qtdeCampos_COOP_CARACT_TRALHAS = 0;
function addCampos_COOP_CARACT_TRALHAS() {
var objPai_COOP_CARACT_TRALHAS = document.getElementById("campoPai_COOP_CARACT_TRALHAS");
var objFilho_COOP_CARACT_TRALHAS = document.createElement("div");
objFilho_COOP_CARACT_TRALHAS.setAttribute("id","filho_COOP_CARACT_TRALHAS"+qtdeCampos_COOP_CARACT_TRALHAS);
objPai_COOP_CARACT_TRALHAS.appendChild(objFilho_COOP_CARACT_TRALHAS);
document.getElementById("filho_COOP_CARACT_TRALHAS"+qtdeCampos_COOP_CARACT_TRALHAS).innerHTML = "<table width='100%'><tr><td width='19%' class='style12'><select name='FISH_CPCTRA_TRALHA[]' id='FISH_CPCTRA_TRALHA' class='form-control'><option value='0' selected='selected'>Selecione um equipamento...</option><?php while ($vetor_COOP_CARACT_TRALHAS = mysql_fetch_array($sql_COOP_CARACT_TRALHAS)) { ?><option value='<?php echo $vetor_COOP_CARACT_TRALHAS[ID]; ?>'><?php echo $vetor_COOP_CARACT_TRALHAS[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='54%' class='style12'><input type='text' name='FISH_CPCTRA_DESCRICAO[]' id='FISH_CPCTRA_DESCRICAO' class='form-control' placeholder='Detalhamentos...'></td><td width='1%'></td><td><input type='text' name='FISH_CPCTRA_QTDE[]' id='FISH_CPCTRA_QTDE' class='form-control' placeholder='Quantidade...' onKeyPress='mascara(this,minteiro)'></td><td width='1%'></td><td width='10%'><input type='button' onclick='removerCampo_COOP_CARACT_TRALHAS("+qtdeCampos_COOP_CARACT_TRALHAS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOP_CARACT_TRALHAS++;
}
function removerCampo_COOP_CARACT_TRALHAS(id) {
var objPai_COOP_CARACT_TRALHAS = document.getElementById("campoPai_COOP_CARACT_TRALHAS");
var objFilho_COOP_CARACT_TRALHAS = document.getElementById("filho_COOP_CARACT_TRALHAS"+id);
console.log(objPai_COOP_CARACT_TRALHAS);
var removido = objPai_COOP_CARACT_TRALHAS.removeChild(objFilho_COOP_CARACT_TRALHAS);
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
							<h3>Projetos de ATES para Pescadores</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Famílias - v.1.6.2.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_fish_alterar_familias.php?id_familia=<?php echo $id_familia; ?>" method="post" name="familias" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-9">
                        	<label class="form-label semibold" for="exampleInput">Nome do Chefe/Pescador:</label>
                            <input type="text" name="FISH_FAM_CHEFE_NOME" class="form-control" id="FISH_FAM_CHEFE_NOME" placeholder="Digite o nome do Chefe da Família/Pescador..." value="<?php echo $vetor_FAMILIA['FISH_FAM_CHEFE_NOME']; ?>">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Apelido do Chefe/Pescador:</label>
                            <input type="text" name="FISH_FAM_CHEFE_APELIDO" class="form-control" id="FISH_FAM_CHEFE_APELIDO" placeholder="Digite o apelido..." value="<?php echo $vetor_FAMILIA['FISH_FAM_CHEFE_APELIDO']; ?>">
                        </div>
                    </div> <!-- Nome e Apelido do Chefe -->
                    <div class="form-group row">
                        <div class="col-lg-9">
                        	<label class="form-label semibold" for="exampleInput">Nome do Cônjuge:</label>
                            <input type="text" name="FISH_FAM_CONJ_NOME" class="form-control" id="FISH_FAM_CONJ_NOME" placeholder="Digite o nome do Cônjuge..." value="<?php echo $vetor_FAMILIA['FISH_FAM_CONJ_NOME']; ?>">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Apelido do Cônjuge:</label>
                            <input type="text" name="FISH_FAM_CONJ_APELIDO" class="form-control" id="FISH_FAM_CONJ_APELIDO" placeholder="Digite o apelido..." value="<?php echo $vetor_FAMILIA['FISH_FAM_CONJ_APELIDO']; ?>">
                        </div>
                    </div> <!-- Nome e Apelido do Cônjuge -->
                    <div class="form-group row">
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Participante das Oficinas?</label>
                            <select name="FISH_FAM_STT_OFIC" id="FISH_FAM_STT_OFIC" class="form-control">
                                <option label="NI" value="0" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_OFIC'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_OFIC'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_OFIC'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label semibold" for="exampleInput">Caso Emergencial?</label>
                            <select name="FISH_FAM_STT_EMER" id="FISH_FAM_STT_EMER" class="form-control">
                                <option label="NI" value="0" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_EMER'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_EMER'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_EMER'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Usuário do Porto?</label>
                            <select name="FISH_FAM_STT_PORT" id="FISH_FAM_STT_PORT" class="form-control">
                                <option label="NI" value="0" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_PORT'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_PORT'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_PORT'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="FISH_FAM_STT_COOP">Identificação p/ COOPPBM?</label>
                            <select name="FISH_FAM_STT_COOP" id="FISH_FAM_STT_COOP" class="form-control">
                                <option label="NI" value="0" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_COOP'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_COOP'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_STT_COOP'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                            </select>
                        </div>
                    </div> <!-- Enquadramentos das Famílias de Pescadores -->
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-label semibold" for="exampleInput">Data do Primeiro Atendimento:</label>
                            <input type="text" name="FISH_FAM_DTREGISTRO" class="form-control" id="FISH_FAM_DTREGISTRO" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_FAMILIA['FISH_FAM_DTREGISTRO'])) { echo 'value='.date('d/m/Y', strtotime($vetor_FAMILIA['FISH_FAM_DTREGISTRO'])); } ?>>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Possuí Endereço Urbano?</label>
                            <select name="FISH_FAM_ENDURB" id="FISH_FAM_ENDURB" class="form-control">
                                <option label="NI" value="0" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDURB'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDURB'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDURB'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Possuí Endereço Rural?</label>
                            <select name="FISH_FAM_ENDRUR" id="FISH_FAM_ENDRUR" class="form-control">
                                <option label="NI" value="0" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDRUR'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDRUR'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDRUR'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                            </select>
                        </div>
                    </div> <!-- Data da Entrada e Status dos Endereços -->
                    <div class="form-group row">
                        <div class="col-lg-6">
							<label class="form-label semibold" for="exampleInput">Endereço Urbano:</label>
                            <input type="text" name="FISH_FAM_ENDURB_LOGR" class="form-control" id="FISH_FAM_ENDURB_LOGR" placeholder="Digite o endereço..." value="<?php echo $vetor_FAMILIA['FISH_FAM_ENDURB_LOGR']; ?>">
                        </div>
                        <div class="col-lg-6">
							<label class="form-label semibold" for="exampleInput">Complemente/Ponto de Referência:</label>
                            <input type="text" name="FISH_FAM_ENDURB_COMPL" class="form-control" id="FISH_FAM_ENDURB_COMPL" placeholder="Digite algum complementou ou ponto de referência..." value="<?php echo $vetor_FAMILIA['FISH_FAM_ENDURB_COMPL']; ?>">
                        </div>
                    </div> <!-- Endereço Urbano / Complemento e Ponto de Referência Urbano -->
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Bairro:</label>
                            <select name="FISH_FAM_ENDURB_BAIRRO" id="FISH_FAM_ENDURB_BAIRRO" class="form-control">
								<?php while ($vetor_BAIRROS=mysql_fetch_array($sql_BAIRROS)) { ?>
                                <option value="<?php echo $vetor_BAIRROS['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDURB_BAIRRO'], $vetor_BAIRROS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_BAIRROS['DESCRICAO']." (".$vetor_BAIRROS['MUNICIPIO']."/".$vetor_BAIRROS['UF'].")"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Município:</label>
                            <select name="FISH_FAM_ENDURB_MUNIC" id="FISH_FAM_ENDURB_MUNIC" class="form-control">
								<?php while ($vetor_MUNIC_URB=mysql_fetch_array($sql_MUNIC_URB)) { ?>
                                <option value="<?php echo $vetor_MUNIC_URB['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDURB_MUNIC'], $vetor_MUNIC_URB['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_MUNIC_URB['DESCRICAO']."/".$vetor_MUNIC_URB['SIGLA']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FAM_ENDURB_USO">Uso principal do Imóvel:</label>
                            <select name="FISH_FAM_ENDURB_USO" id="FISH_FAM_ENDURB_USO" class="form-control">
								<?php while ($vetor_USOIMOVEL_URB=mysql_fetch_array($sql_USOIMOVEL_URB)) { ?>
                                <option value="<?php echo $vetor_USOIMOVEL_URB['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDURB_USO'], $vetor_USOIMOVEL_URB['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_USOIMOVEL_URB['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Bairro e Município Urbano e Uso do Imóvel Urbano -->
                    <div class="form-group row">
                        <div class="col-lg-6">
							<label class="form-label semibold" for="exampleInput">Endereço Rural:</label>
                            <input type="text" name="FISH_FAM_ENDRUR_LOGR" class="form-control" id="FISH_FAM_ENDRUR_LOGR" placeholder="Digite o endereço..." value="<?php echo $vetor_FAMILIA['FISH_FAM_ENDRUR_LOGR']; ?>">
                        </div>
                        <div class="col-lg-6">
							<label class="form-label semibold" for="exampleInput">Complemente/Ponto de Referência:</label>
                            <input type="text" name="FISH_FAM_ENDRUR_COMPL" class="form-control" id="FISH_FAM_ENDRUR_COMPL" placeholder="Digite algum complementou ou ponto de referência..." value="<?php echo $vetor_FAMILIA['FISH_FAM_ENDRUR_COMPL']; ?>">
                        </div>
                    </div> <!-- Endereço Rural / Complemento e Ponto de Referência Rural -->
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Localidade Rural:</label>
                            <select name="FISH_FAM_ENDRUR_LOCAL" id="FISH_FAM_ENDRUR_LOCAL" class="form-control">
								<?php while ($vetor_LOCALIDADES=mysql_fetch_array($sql_LOCALIDADES)) { ?>
                                <option value="<?php echo $vetor_LOCALIDADES['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDRUR_LOCAL'], $vetor_LOCALIDADES['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_LOCALIDADES['DESCRICAO']." (".$vetor_LOCALIDADES['MUNICIPIO']."/".$vetor_LOCALIDADES['UF'].")"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Município:</label>
                            <select name="FISH_FAM_ENDRUR_MUNIC" id="FISH_FAM_ENDRUR_MUNIC" class="form-control">
								<?php while ($vetor_MUNIC_RUR=mysql_fetch_array($sql_MUNIC_RUR)) { ?>
                                <option value="<?php echo $vetor_MUNIC_RUR['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDRUR_MUNIC'], $vetor_MUNIC_RUR['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_MUNIC_RUR['DESCRICAO']."/".$vetor_MUNIC_RUR['SIGLA']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FAM_ENDRUR_USO">Uso principal do Imóvel:</label>
                            <select name="FISH_FAM_ENDRUR_USO" id="FISH_FAM_ENDRUR_USO" class="form-control">
								<?php while ($vetor_USOIMOVEL_RUR=mysql_fetch_array($sql_USOIMOVEL_RUR)) { ?>
                                <option value="<?php echo $vetor_USOIMOVEL_RUR['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_ENDRUR_USO'], $vetor_USOIMOVEL_RUR['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_USOIMOVEL_RUR['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Localidade e Município Rural e Uso do Imóvel Rural -->
                    <div class="form-group row">
                        <div class="col-lg-12">
							<label class="form-label semibold" for="FISH_FAM_ENDRUR_ACESSO">Acessos ao Imóvel Rural (TERRA/ÁGUA):</label>
                            <textarea rows="3" name="FISH_FAM_ENDRUR_ACESSO" id="FISH_FAM_ENDRUR_ACESSO" class="form-control" placeholder="Rotas de acesso..."><?php echo $vetor_FAMILIA['FISH_FAM_ENDRUR_ACESSO']; ?></textarea>
                        </div>
					</div> <!-- Acessos ao Imóvel Rural -->
                    <div class="form-group row">
                        <div class="col-lg-3">
							<label class="form-label semibold" for="exampleInput">Telefones:</label>
                            <input type="text" name="FISH_FAM_TELEFONES" class="form-control" id="FISH_FAM_TELEFONES" placeholder="Digite os telefones de contato..." value="<?php echo $vetor_FAMILIA['FISH_FAM_TELEFONES']; ?>">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Coordenadas UTM E:</label>
                            <input type="text" name="FISH_FAM_UTME" class="form-control" id="FISH_FAM_UTME" placeholder="Digite as coordenadas UTM E..." value="<?php echo $vetor_FAMILIA['FISH_FAM_UTME']; ?>">
						</div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Coordenadas UTM N:</label>
                            <input type="text" name="FISH_FAM_UTMN" class="form-control" id="FISH_FAM_UTMN" placeholder="Digite as coordenadas UTM N..." value="<?php echo $vetor_FAMILIA['FISH_FAM_UTMN']; ?>">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Fuso das Coordenadas:</label>
                            <select name="FISH_FAM_FUSO" id="FISH_FAM_FUSO" class="form-control">
								<?php while ($vetor_FUSOS=mysql_fetch_array($sql_FUSOS)) { ?>
                                <option value="<?php echo $vetor_FUSOS['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_FUSO'], $vetor_FUSOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_FUSOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Telefones/Coordenadas UTM E/Coordenadas UTM N/Fuso das Coordenadas -->
                    <div class="form-group row">
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Possuí Outro Cadastro?</label>
                            <select name="FISH_FAM_LINK_STATUS" id="FISH_FAM_LINK_STATUS" class="form-control">
                                <option label="NI" value="0" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_LINK_STATUS'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_LINK_STATUS'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_FAMILIA['FISH_FAM_LINK_STATUS'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
							<label class="form-label semibold" for="exampleInput">Código da Família:</label>
                            <input type="text" name="FISH_FAM_LINK_CODIGO" class="form-control" id="FISH_FAM_LINK_CODIGO" placeholder="Digite o código da Família..." value="<?php echo $vetor_FAMILIA['FISH_FAM_LINK_CODIGO']; ?>">
                        </div>
                        <div class="col-lg-6">
							<?php if ($vetor_FAMILIA['FISH_FAM_LINK_CODIGO'] > 0) { ?>								
                        		<strong><a class="fancybox fancybox.ajax" href="../rural/alterar_familias.php?id_familia=<?php echo $vetor_FAMILIA['FISH_FAM_LINK_CODIGO']; ?>" target="_blank">Acesse o Cadastro</a></strong>
                            <?php } else { ?>
                            	<strong>Acesse o Cadastro</strong>
                            <?php }; ?>    
						</div>
                    </div> <!-- Cadastro ATES/Reparação Rural/Ribeirinhos, Código do Cadastro -->
					</br>
                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
				</form>
			</div><!--.box-typical-->
   			<div class="box-typical box-typical-padding">
                	<div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                           	<li><a href="#view1">Situação Geral</a></li>
                           	<li><a href="#view2">Perfil de Entrada</a></li>
                            <li><a href="#view6">Perfil</a></li>
							<li><a href="#view5">Acompanhamento</a></li>
                            <li><a href="#view8">Composição Familiar</a></li>
                            <li><a href="#view4">Eventos</a></li>
                            <li><a href="#view3">Documentos</a></li>
                           	<li><a href="#view7">COOPPBM</a></li>
                        </ul>
                    </div>
			        <div class="tabcontents">

						<div id="view1">
							<?php if ($num_DADOS > 0) { ?>
								<form action="recebe_fish_alterar_dados.php?id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_fish_alterar_dados" enctype="multipart/form-data" id="recebe_fish_alterar_dados">
									<div class="form-group row">
										<div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Situação Emergêncial?</label>
											<select name="FISH_DADOS_EMERG" id="FISH_DADOS_EMERG" class="form-control">
												<option label="NI" value="0" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_EMERG'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
												<option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_EMERG'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
												<option label="NAO" value="2" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_EMERG'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
											</select>
										</div>
										<div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Família Vulnerável?</label>
											<select name="FISH_DADOS_VULNERAVEL" id="FISH_DADOS_VULNERAVEL" class="form-control">
												<option label="NI" value="0" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_VULNERAVEL'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
												<option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_VULNERAVEL'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
												<option label="NAO" value="2" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_VULNERAVEL'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
											</select>
										</div>
										<div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Barco - Novo?</label>
											<select name="FISH_DADOS_BARCO_NOVO" id="FISH_DADOS_BARCO_NOVO" class="form-control">
												<option label="NI" value="0" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_BARCO_NOVO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
												<option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_BARCO_NOVO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
												<option label="NAO" value="2" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_BARCO_NOVO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
											</select>
										</div>
										<div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Barco - Reparos?</label>
											<select name="FISH_DADOS_BARCO_REPARO" id="FISH_DADOS_BARCO_REPARO" class="form-control">
												<option label="NI" value="0" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_BARCO_REPARO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
												<option label="SIM" value="1" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_BARCO_REPARO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
												<option label="NAO" value="2" <?php if (strcasecmp($vetor_DADOS['FISH_DADOS_BARCO_REPARO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
											</select>
										</div>
									</div> <!-- Linha 01 -->
									<div class="form-group row">
										<div class="col-lg-12">
											<label class="form-label semibold" for="exampleInput">Relato da Situação da Família:</label>
											<textarea rows="2" name="FISH_DADOS_SINTESE" id="FISH_DADOS_SINTESE" class="form-control" placeholder="Digite o relato da situação da família..."><?php echo $vetor_DADOS['FISH_DADOS_SINTESE']; ?></textarea>
										</div>
									</div> <!-- Linha 02 -->    
									<div class="form-group row">
										<div class="col-lg-12">
											<label class="form-label semibold" for="exampleInput">Relato da Situação da Embarcação:</label>
											<textarea rows="2" name="FISH_DADOS_EMBARCACAO" id="FISH_DADOS_EMBARCACAO" class="form-control" placeholder="Digite o relato da situação da embarcação..."><?php echo $vetor_DADOS['FISH_DADOS_EMBARCACAO']; ?></textarea>
										</div>
									</div> <!-- Linha 03 -->
									<input name="salvar" type="image" src="imgs/salvar.png" class="float"/>
								</form>
							<?php } else { ?>
								<form action="recebe_fish_cadastrar_dados.php?id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_fish_cadastrar_dados" enctype="multipart/form-data" id="recebe_fish_cadastrar_dados">
									<input name="gerar" type="image" src="imgs/gerar.png" class="float"/>
								</form>
							<?php } ?>
						</div> <!-- Situação Gerais -->
						
                        <div id="view2">
                           	<?php if ($num_PERFILENT > 0) { ?>
                                <form action="recebe_fish_alterar_perfilent.php?id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_fish_alterar_perfilent" enctype="multipart/form-data" id="recebe_fish_alterar_perfilent">
                                	<h2>Dados da Aplicação</h2><hr>
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Visita Realizada?</label>
                                            <select name="FISH_PERFIL_VISITA" id="FISH_PERFIL_VISITA" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_VISITA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_VISITA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_VISITA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label semibold" for="exampleInput">Data da Visita:</label>
                                            <input type="text" name="FISH_PERFIL_DTVISITA" class="form-control" id="FISH_PERFIL_DTVISITA" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_DTVISITA'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_DTVISITA'])).'"'; } ?>>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label semibold" for="exampleInput">Pesquisador(es):</label>
                                            <input type="text" name="FISH_PERFIL_PESQUISADOR" class="form-control" id="FISH_PERFIL_PESQUISADOR" placeholder="Digite o(s) nome(s) do(s) pesquisador(es)..." value="<?php echo $vetor_PERFILENT['FISH_PERFIL_PESQUISADOR']; ?>">
                                        </div>
                                    </div> <!-- Linha 01 -->
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="exampleInput">Questionário Aplicado?</label>
                                            <select name="FISH_PERFIL_APLIC" id="FISH_PERFIL_APLIC" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_APLIC'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_APLIC'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_APLIC'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label semibold" for="exampleInput">Data da Aplicação:</label>
                                            <input type="text" name="FISH_PERFIL_DTAPLIC" class="form-control" id="FISH_PERFIL_DTAPLIC" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_DTAPLIC'])) { echo 'value='.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_DTAPLIC'])); } ?>>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label semibold" for="exampleInput">Número do Questionário:</label>
                                            <input type="text" name="FISH_PERFIL_QUEST" class="form-control" id="FISH_PERFIL_QUEST" placeholder="Digite o número do questionário..." value="<?php echo $vetor_PERFILENT['FISH_PERFIL_QUEST']; ?>">
                                        </div>
                                    </div> <!-- Linha 02 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Questionário Tabulado?</label>
                                            <select name="FISH_PERFIL_TAB" id="FISH_PERFIL_TAB" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_TAB'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_TAB'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_TAB'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Data da Tabulação:</label>
                                            <input type="text" name="FISH_PERFIL_DTTAB" class="form-control" id="FISH_PERFIL_DTTAB" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_DTTAB'])) { echo 'value='.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_DTTAB'])); } ?>>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="exampleInput">Relatório Concluído?</label>
                                            <select name="FISH_PERFIL_RELAT" id="FISH_PERFIL_RELAT" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_RELAT'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_RELAT'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_RELAT'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold" for="exampleInput">Data do Relatório:</label>
                                            <input type="text" name="FISH_PERFIL_DTRELAT" class="form-control" id="FISH_PERFIL_DTRELAT" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_DTRELAT'])) { echo 'value='.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_DTRELAT'])); } ?>>
                                        </div>
                                    </div> <!-- Linha 03 -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                            				<label class="form-label semibold" for="exampleInput">Observações:</label>
                                            <textarea rows="4" name="FISH_PERFIL_OBS" id="FISH_PERFIL_OBS" class="form-control" placeholder="Digite observações..."><?php echo $vetor_PERFILENT['FISH_PERFIL_OBS']; ?></textarea>
                                        </div>
                                    </div> <!-- Linha 04 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="FISH_PERFIL_QTDEV_LOCO">Tentativas de Visitas:</label>
                                            <input type="text" name="FISH_PERFIL_QTDEV_LOCO" class="form-control" id="FISH_PERFIL_QTDEV_LOCO" placeholder="Digite a quantidade." value="<?php echo $vetor_PERFILENT['FISH_PERFIL_QTDEV_LOCO']; ?>">
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold" for="FISH_PERFIL_QTDEV_FONE">Tentativas por Telefone:</label>
                                            <input type="text" name="FISH_PERFIL_QTDEV_FONE" class="form-control" id="FISH_PERFIL_QTDEV_FONE" placeholder="Digite a quantidade." value="<?php echo $vetor_PERFILENT['FISH_PERFIL_QTDEV_FONE']; ?>">
                                        </div>
                                    </div> <!-- Linha 05 -->
									
                                    <br/><h2>Solicitações do Entrevistado</h2><hr>
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold">Nova Embarcação?</label>
                                            <select name="FISH_PERFIL_P_BARCO" id="FISH_PERFIL_P_BARCO" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_BARCO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_BARCO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_BARCO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold">Novo Motor?</label>
                                            <select name="FISH_PERFIL_P_MOTOR" id="FISH_PERFIL_P_MOTOR" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_MOTOR'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_MOTOR'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_MOTOR'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold">Reparo na Embarcação?</label>
                                            <select name="FISH_PERFIL_P_REPAROS" id="FISH_PERFIL_P_REPAROS" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_REPAROS'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_REPAROS'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_REPAROS'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold">Tralhas?</label>
                                            <select name="FISH_PERFIL_P_TRALHA" id="FISH_PERFIL_P_TRALHA" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_TRALHA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_TRALHA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_TRALHA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Linha 01 -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold">Rancho/Cesta Básica?</label>
                                            <select name="FISH_PERFIL_P_CESTA" id="FISH_PERFIL_P_CESTA" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_CESTA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_CESTA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_CESTA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold">Projeto Geração de Renda?</label>
                                            <select name="FISH_PERFIL_P_RENDA" id="FISH_PERFIL_P_RENDA" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_RENDA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_RENDA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_RENDA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold">Qual Tipo de Projeto?</label>
                                            <select name="FISH_PERFIL_P_PROJ" id="FISH_PERFIL_P_PROJ" class="form-control">
                                                <?php while ($vetor_TPPROJETOS_P=mysql_fetch_array($sql_TPPROJETOS_P)) { ?>
                                                <option value="<?php echo $vetor_TPPROJETOS_P['ID']; ?>" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_PROJ'], $vetor_TPPROJETOS_P['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPPROJETOS_P['DESCRICAO']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold">Atendimento Social?</label>
                                            <select name="FISH_PERFIL_P_ATEND" id="FISH_PERFIL_P_ATEND" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_ATEND'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_ATEND'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_P_ATEND'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
									</div> <!-- Linha 02 -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                            				<label class="form-label semibold">Outras Solicitações:</label>
                                            <textarea rows="2" name="FISH_PERFIL_P_OUTROS" id="FISH_PERFIL_P_OUTROS" class="form-control" placeholder="Digite caso tenham solicitado outros itens..."><?php echo $vetor_PERFILENT['FISH_PERFIL_P_OUTROS']; ?></textarea>
                                        </div>
                                    </div> <!-- Linha 03 -->

                                    <br/><h2>Encaminhamentos Propostos</h2><hr>
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold">Cooperativa?</label>
                                            <select name="FISH_PERFIL_E_COOP" id="FISH_PERFIL_E_COOP" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_COOP'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_COOP'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_COOP'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
									</div> <!-- Linha 01 - Cooperativa-->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold">Nova Embarcação?</label>
                                            <select name="FISH_PERFIL_E_BARCO" id="FISH_PERFIL_E_BARCO" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_BARCO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_BARCO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_BARCO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold">Embarcação Entregue?</label>
                                            <select name="FISH_PERFIL_E_BARCO_ENT" id="FISH_PERFIL_E_BARCO_ENT" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_BARCO_ENT'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_BARCO_ENT'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_BARCO_ENT'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
										<div class="col-lg-3">
                                            <label class="form-label semibold">Data da Entrega:</label>
                                            <input type="text" name="FISH_PERFIL_E_BARCO_ENTDT" class="form-control" id="FISH_PERFIL_E_BARCO_ENTDT" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_E_BARCO_ENTDT'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_E_BARCO_ENTDT'])).'"'; } ?>>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold">Reparo na Embarcação?</label>
                                            <select name="FISH_PERFIL_E_REPAROS" id="FISH_PERFIL_E_REPAROS" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_REPAROS'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_REPAROS'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_REPAROS'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
									</div>  <!-- Linha 02 - Embarcação-->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold">Novo Motor?</label>
                                            <select name="FISH_PERFIL_E_MOTOR" id="FISH_PERFIL_E_MOTOR" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_MOTOR'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_MOTOR'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_MOTOR'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold">Motor Entregue?</label>
                                            <select name="FISH_PERFIL_E_MOTOR_ENT" id="FISH_PERFIL_E_MOTOR_ENT" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_MOTOR_ENT'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_MOTOR_ENT'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_MOTOR_ENT'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
										<div class="col-lg-3">
                                            <label class="form-label semibold">Data da Entrega:</label>
                                            <input type="text" name="FISH_PERFIL_E_MOTOR_ENTDT" class="form-control" id="FISH_PERFIL_E_MOTOR_ENTDT" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_E_MOTOR_ENTDT'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_E_MOTOR_ENTDT'])).'"'; } ?>>
										</div>
                                    </div> <!-- Linha 03 - Motor -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold">Tralhas?</label>
                                            <select name="FISH_PERFIL_E_TRALHA" id="FISH_PERFIL_E_TRALHA" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_TRALHA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_TRALHA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_TRALHA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold">Tralha Entregue?</label>
                                            <select name="FISH_PERFIL_E_TRALHA_ENT" id="FISH_PERFIL_E_TRALHA_ENT" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_TRALHA_ENT'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_TRALHA_ENT'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_TRALHA_ENT'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
										<div class="col-lg-3">
                                            <label class="form-label semibold">Data da Entrega:</label>
                                            <input type="text" name="FISH_PERFIL_E_TRALHA_ENTDT" class="form-control" id="FISH_PERFIL_E_TRALHA_ENTDT" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_E_TRALHA_ENTDT'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_E_TRALHA_ENTDT'])).'"'; } ?>>
										</div>
                                    </div> <!-- Linha 04 - Tralha -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                            				<label class="form-label semibold">Detalhamento da Tralha:</label>
                                            <textarea rows="4" name="FISH_PERFIL_E_TRALHA_DESC" id="FISH_PERFIL_E_TRALHA_DESC" class="form-control" placeholder="Digite o conteúdo da tralha..."><?php echo $vetor_PERFILENT['FISH_PERFIL_E_TRALHA_DESC']; ?></textarea>
                                        </div>
                                    </div> <!-- Linha 05 - Descrição da Tralha -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold">Rancho/Cesta Básica?</label>
                                            <select name="FISH_PERFIL_E_CESTA" id="FISH_PERFIL_E_CESTA" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold">Quantidade Entregue:</label>
                                            <input type="text" name="FISH_PERFIL_E_CESTA_ENTQT" class="form-control" id="FISH_PERFIL_E_CESTA_ENTQT" placeholder="Digite a quantidade..." value="<?php echo $vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENTQT']; ?>">
                                        </div>
                                    </div> <!-- Linha 05 - Rancho - Start -->
                                    <div class="form-group row">
										<div class="col-lg-3">
											<label class="form-label semibold">Primeiro Rancho Entregue?</label>
                                            <select name="FISH_PERFIL_E_CESTA_ENT01" id="FISH_PERFIL_E_CESTA_ENT01" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT01'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT01'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT01'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold">Data da Primeira Entrega:</label>
                                            <input type="text" name="FISH_PERFIL_E_CESTA_ENT01DT" class="form-control" id="FISH_PERFIL_E_CESTA_ENT01DT" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT01DT'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT01DT'])).'"'; } ?>>
                                        </div>
										<div class="col-lg-3">
											<label class="form-label semibold">Segundo Rancho Entregue?</label>
                                            <select name="FISH_PERFIL_E_CESTA_ENT02" id="FISH_PERFIL_E_CESTA_ENT02" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT02'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT02'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT02'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold">Data da Segunda Entrega:</label>
                                            <input type="text" name="FISH_PERFIL_E_CESTA_ENT02DT" class="form-control" id="FISH_PERFIL_E_CESTA_ENT02DT" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT02DT'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT02DT'])).'"'; } ?>>
                                        </div>
                                    </div> <!-- Linha 06 - Rancho - 1ª E 2ª ENTREGAS -->
                                    <div class="form-group row">
										<div class="col-lg-3">
											<label class="form-label semibold">Terceiro Rancho Entregue?</label>
                                            <select name="FISH_PERFIL_E_CESTA_ENT03" id="FISH_PERFIL_E_CESTA_ENT03" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT03'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT03'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT03'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold">Data da Terceira Entrega:</label>
                                            <input type="text" name="FISH_PERFIL_E_CESTA_ENT03DT" class="form-control" id="FISH_PERFIL_E_CESTA_ENT03DT" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT03DT'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT03DT'])).'"'; } ?>>
                                        </div>
										<div class="col-lg-3">
											<label class="form-label semibold">Quarto Rancho Entregue?</label>
                                            <select name="FISH_PERFIL_E_CESTA_ENT04" id="FISH_PERFIL_E_CESTA_ENT04" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT04'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT04'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT04'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold">Data da Quarta Entrega:</label>
                                            <input type="text" name="FISH_PERFIL_E_CESTA_ENT04DT" class="form-control" id="FISH_PERFIL_E_CESTA_ENT04DT" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT04DT'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_E_CESTA_ENT04DT'])).'"'; } ?>>
                                        </div>
                                    </div> <!-- Linha 07 - Rancho - 3ª E 4ª ENTREGAS -->
                                    <div class="form-group row">
                                        <div class="col-lg-3">
											<label class="form-label semibold">Projeto Geração de Renda?</label>
                                            <select name="FISH_PERFIL_E_RENDA" id="FISH_PERFIL_E_RENDA" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_RENDA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_RENDA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_RENDA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold">Qual Tipo de Projeto?</label>
                                            <select name="FISH_PERFIL_E_PROJ" id="FISH_PERFIL_E_PROJ" class="form-control">
                                                <?php while ($vetor_TPPROJETOS_E=mysql_fetch_array($sql_TPPROJETOS_E)) { ?>
                                                <option value="<?php echo $vetor_TPPROJETOS_E['ID']; ?>" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_PROJ'], $vetor_TPPROJETOS_E['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPPROJETOS_E['DESCRICAO']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
											<label class="form-label semibold">Atendimento Social?</label>
                                            <select name="FISH_PERFIL_E_ATEND" id="FISH_PERFIL_E_ATEND" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_ATEND'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_ATEND'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_E_ATEND'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold">Status do Acompanhamento</label>
                                            <select name="FISH_PERFIL_STATUSATEND" id="FISH_PERFIL_STATUSATEND" class="form-control">
                                                <?php while ($vetor_STATUSATEND = mysql_fetch_array($sql_STATUSATEND)) { ?>
                                                <option value="<?php echo $vetor_STATUSATEND['ID']; ?>" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_STATUSATEND'], $vetor_STATUSATEND['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_STATUSATEND['DESCRICAO']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> <!-- Linha 08 - Projetos e 4.6.1 -->
                                    
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                            				<label class="form-label semibold">Outros Encaminhamentos:</label>
                                            <textarea rows="2" name="FISH_PERFIL_E_OUTROS" id="FISH_PERFIL_E_OUTROS" class="form-control" placeholder="Digite caso tenham outros encaminhamentos..."><?php echo $vetor_PERFILENT['FISH_PERFIL_E_OUTROS']; ?></textarea>
                                        </div>
                                    </div>   <!-- Linha 05 -->

                                    <br/><h2>Plano de Transição</h2><hr>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                            				<label class="form-label semibold">Situação relatada na entrevista de aplicação do questionário:</label>
                                            <textarea rows="3" name="FISH_PERFIL_TRAN_RELATO" id="FISH_PERFIL_TRAN_RELATO" class="form-control" placeholder="Digite a situação relatada na entrevista..."><?php echo $vetor_PERFILENT['FISH_PERFIL_TRAN_RELATO']; ?></textarea>
                                        </div>
                                    </div> <!-- Linha Situação -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                            				<label class="form-label semibold">Plano de Atendimento:</label>
                                            <textarea rows="2" name="FISH_PERFIL_TRAN_ATEND" id="FISH_PERFIL_TRAN_ATEND" class="form-control" placeholder="Digite o plano de atendimento..."><?php echo $vetor_PERFILENT['FISH_PERFIL_TRAN_ATEND']; ?></textarea>
                                        </div>
                                    </div> <!-- Linha Atendimento -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                            				<label class="form-label semibold">Resumo:</label>
                                            <textarea rows="2" name="FISH_PERFIL_TRAN_RESUMO" id="FISH_PERFIL_TRAN_RESUMO" class="form-control" placeholder="Digite o plano de atendimento..."><?php echo $vetor_PERFILENT['FISH_PERFIL_TRAN_RESUMO']; ?></textarea>
                                        </div>
                                    </div> <!-- Linha Atendimento -->
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                            				<label class="form-label semibold">Encaminhamento - NE:</label>
                                            <textarea rows="2" name="FISH_PERFIL_TRAN_ENCAM" id="FISH_PERFIL_TRAN_ENCAM" class="form-control" placeholder="Digite o plano de atendimento..."><?php echo $vetor_PERFILENT['FISH_PERFIL_TRAN_ENCAM']; ?></textarea>
                                        </div>
                                    </div> <!-- Linha Atendimento -->
                                    <a class="fancybox fancybox.ajax" href="relatorio_fish_plano_atendimento.php?id_familia=<?php echo $id_familia; ?>" target="_blank"><img src="imgs/imprimir.png" width="25" height="25" border="0"></a> Imprimir Plano de Atendimento  // <a class="fancybox fancybox.ajax" href="relatorio_fish_plano_acompanhamento.php?id_familia=<?php echo $id_familia; ?>" target="_blank"><img src="imgs/imprimir.png" width="25" height="25" border="0"></a> Imprimir Plano de Acompanhamento
									</br></br>
                                    <div class="form-group row">
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="FISH_PERFIL_DEVOLUT">Devolutiva Realizada?</label>
                                            <select name="FISH_PERFIL_DEVOLUT" id="FISH_PERFIL_DEVOLUT" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_DEVOLUT'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_DEVOLUT'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_DEVOLUT'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label semibold" for="FISH_PERFIL_DTDEVOLUT">Data da Devolutiva:</label>
                                            <input type="text" name="FISH_PERFIL_DTDEVOLUT" class="form-control" id="FISH_PERFIL_DTDEVOLUT" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PERFILENT['FISH_PERFIL_DTDEVOLUT'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_PERFILENT['FISH_PERFIL_DTDEVOLUT'])).'"'; } ?>>
                                        </div>
                                        <div class="col-lg-4">
											<label class="form-label semibold" for="FISH_PERFIL_DEVOLUT_ACEITE">Devolutiva Aceita?</label>
                                            <select name="FISH_PERFIL_DEVOLUT_ACEITE" id="FISH_PERFIL_DEVOLUT_ACEITE" class="form-control">
                                                <option label="NI" value="0" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_DEVOLUT_ACEITE'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
                                                <option label="SIM" value="1" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_DEVOLUT_ACEITE'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                                <option label="NAO" value="2" <?php if (strcasecmp($vetor_PERFILENT['FISH_PERFIL_DEVOLUT_ACEITE'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                            </select>
                                        </div>
                                    </div> <!-- Dados da Devolutiva -->
									</br></br>
                                    <input name="pesq" type="image" src="imgs/salvar.png" class="float"/>
                                </form>
                            <?php } else { ?>
                                <form action="recebe_fish_cadastrar_perfilent.php?id_familia=<?php echo $id_familia; ?>" method="post" name="perfilent" enctype="multipart/form-data" id="formID">
                                    <input name="pesq" type="image" src="imgs/gerar.png" class="float"/>
                                </form>
                            <?php } ?>
						</div> <!-- Perfil de Entrada -->

						<div id="view3">
							<div id="scroll">
								<form action="recebe_fish_cadastrar_documentos.php?id_familia=<?php echo $id_familia; ?>" method="post" name="documentos" enctype="multipart/form-data" id="formDocumentos">
									<table width="100%">
									  <thead>
										<td width="10%">Data</td>
										<td width="1%"></td>
										<td width="30%">Tipo</td>
										<td width="1%"></td>
										<td width="20%">Descrição</td>
										<td width="1%"></td>
										<td width="30%">Anexo</td>
										<td width="1%"></td>
										<td width="6%">&nbsp;</td>
									  </thead>
									</table>
									<div id="campoPai_DOC"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
									</br>
									<input type="button" value="Novo Documento" onClick="addCampos_DOC()" class="btn btn-inline">
									<input type="submit" value="Salvar Documentos" class="btn btn-inline">
								</form>
								</br>
								</br>
								<table width="100%">
									<thead>
										<td width="10%">Data</td>
										<td width="1%"></td>
										<td width="30%">Tipo</td>
										<td width="1%"></td>
										<td width="20%">Descrição</td>
										<td width="1%"></td>
										<td width="30%">Anexo</td>
										<td width="1%"></td>
										<td width="10%">Ações</td>
									</thead>
									<?php 
										$sql_DOC = mysql_query("SELECT TAB_FISH_DOCUMENTOS.FISH_DOC_ID, TAB_FISH_DOCUMENTOS.FISH_FAM_ID, TAB_FISH_DOCUMENTOS.FISH_DOC_DATA, TAB_FISH_DOCUMENTOS.FISH_DOC_TIPO, TAB_APOIO_TIPODOC.DESCRICAO AS FISH_DOC_TIPO_DESC, TAB_FISH_DOCUMENTOS.FISH_DOC_DESCRICAO, TAB_FISH_DOCUMENTOS.FISH_DOC_ARQUIVO FROM TAB_FISH_DOCUMENTOS LEFT OUTER JOIN TAB_APOIO_TIPODOC ON TAB_APOIO_TIPODOC.ID = TAB_FISH_DOCUMENTOS.FISH_DOC_TIPO WHERE TAB_FISH_DOCUMENTOS.FISH_FAM_ID = '$id_familia' ORDER BY TAB_FISH_DOCUMENTOS.FISH_DOC_DATA DESC, FISH_DOC_TIPO_DESC ASC;", $db) or die(mysql_error());
										$cor = "#D8D8D8";
										while ($vetor_DOC=mysql_fetch_array($sql_DOC)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
												} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="10%" align="center"><?php echo date('d/m/Y', strtotime($vetor_DOC['FISH_DOC_DATA'])); ?></td>
										<td width="1%"></td>
										<td width="30%"><?php echo $vetor_DOC['FISH_DOC_TIPO_DESC']; ?></td>
										<td width="1%"></td>
										<td width="20%"><?php echo $vetor_DOC['FISH_DOC_DESCRICAO']; ?></td>
										<td width="1%"></td>
										<td width="30%" align="center"><a href="docs/<?php echo $vetor_DOC['FISH_DOC_ARQUIVO']; ?>" target="_blank">Salvar Arquivo</a></td>
										<td width="1%"></td>
										<td width="6%" align="center"><a class="fancybox fancybox.ajax" href="alterar_fish_familias_documentos.php?id=<?php echo $vetor_DOC['FISH_DOC_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_documentos.php?id=<?php echo $vetor_DOC['FISH_DOC_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
							</div>                                
						</div> <!-- Documentos -->

						<div id="view8">
							<div id="scroll">
								<form action="recebe_fish_cadastrar_componente.php?id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_fish_cadastrar_componente" enctype="multipart/form-data" id="recebe_fish_cadastrar_componente">
									<table width="100%">
									  <thead>
										<td width="93%" align="center">Dados do Compoenente Familiar</td>
										<td width="7%">&nbsp;</td>
									  </thead>
									</table>
									<div id="campoPaiCOMPONENTE"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
									<input type="button" value="Novo Componente" onClick="addCamposCOMPONENTE()" class="btn btn-inline">
									<input type="submit" value="Salvar Componentes" class="btn btn-inline">
								</form>
								</br>
								<table width="100%">
									<thead>
										<td width="34%">Nome</td>
										<td width="1%"></td>
										<td width="19%">Gênero</td>
										<td width="1%"></td>
										<td width="19%">Parentesco</td>
										<td width="1%"></td>
										<td width="14%">Residente?</td>
										<td width="1%"></td>
										<td width="10%">Ações</td>
									</thead>
									<?php 
										$sql_COMPONENTE = mysql_query("SELECT TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ID, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME, TAB_APOIO_GENERO.DESCRICAO AS FISH_FCOMP_GENERO_DESC, TAB_APOIO_PARENTESCO.DESCRICAO AS FISH_FCOMP_PARENTESCO_DESC, TAB_APOIO_BOOLEANO.DESCRICAO AS FISH_FCOMP_RESIDENTE_DESC FROM TAB_FISH_FAMILIAS_COMPOSICAO LEFT OUTER JOIN TAB_APOIO_GENERO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_GENERO = TAB_APOIO_GENERO.ID LEFT OUTER JOIN TAB_APOIO_PARENTESCO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_PARENTESCO = TAB_APOIO_PARENTESCO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RESIDENTE = TAB_APOIO_BOOLEANO.ID WHERE TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FAM_ID = '$id_familia' ORDER BY TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_PARENTESCO ASC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_DTNASC DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_IDADE DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME ASC;", $db) or die(mysql_error());
										$cor = "#D8D8D8";
										while ($vetor_COMPONENTE = mysql_fetch_array($sql_COMPONENTE)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
												} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="34%"><?php echo $vetor_COMPONENTE['FISH_FCOMP_NOME']; ?></td>
										<td width="1%"></td>
										<td width="19%"><?php echo $vetor_COMPONENTE['FISH_FCOMP_GENERO_DESC']; ?></td>
										<td width="1%"></td>
										<td width="19%"><?php echo $vetor_COMPONENTE['FISH_FCOMP_PARENTESCO_DESC']; ?></td>
										<td width="1%"></td>
										<td width="14%" align="center"><?php echo $vetor_COMPONENTE['FISH_FCOMP_RESIDENTE_DESC']; ?>?</td>
										<td width="1%"></td>
										<td width="10%"><a class="fancybox fancybox.ajax" href="alterar_fish_familias_componente.php?id=<?php echo $vetor_COMPONENTE['FISH_FCOMP_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_componente.php?id=<?php echo $vetor_COMPONENTE['FISH_FCOMP_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
							</div>                                
						</div> <!-- Componentes Familiares -->

						<div id="view4">
							<div id="scroll">
								<form action="recebe_fish_cadastrar_eventos.php?id_familia=<?php echo $id_familia; ?>" method="post" name="eventos" enctype="multipart/form-data" id="formEventos">
									<table width="100%">
										<thead>
										<td width="100px">Data</td>
										<td width="3px"></td>
										<td width="250px">Tipo do Evento</td>
										<td width="3px"></td>
										<td width="400px">Observações/Breve Descrição</td>
										<td width="3px"></td>
										<td width="100px">&nbsp;</td>
									  </thead>
									</table>
									<div id="campoPai_EVENTO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
									</br>
									<input type="button" value="Novo Evento" onClick="addCampos_EVENTO()" class="btn btn-inline">
									<input type="submit" value="Salvar Eventos" class="btn btn-inline">
								</form>
								</br>
								</br>
								<table width="100%">
										<thead>
										<td width="100px">Data</td>
										<td width="3px"></td>
										<td width="250px">Tipo do Evento</td>
										<td width="3px"></td>
										<td width="400px">Observações/Breve Descrição</td>
										<td width="3px"></td>
										<td width="100px">Ações</td>
									  </thead>
									<?php 
										$sql_EVENTOS = mysql_query("SELECT TAB_FISH_EVENTOS.FISH_EVE_CODIGO, TAB_FISH_EVENTOS.FISH_FAM_ID, TAB_FISH_EVENTOS.FISH_EVE_DATA, TAB_APOIO_EVENTOS.DESCRICAO AS FISH_EVE_TIPO_DESC, TAB_FISH_EVENTOS.FISH_EVE_OBSERVACOES FROM TAB_FISH_EVENTOS LEFT OUTER JOIN TAB_APOIO_EVENTOS ON TAB_FISH_EVENTOS.FISH_EVE_TIPO = TAB_APOIO_EVENTOS.ID WHERE TAB_FISH_EVENTOS.FISH_FAM_ID = '$id_familia' ORDER BY TAB_FISH_EVENTOS.FISH_EVE_DATA DESC;", $db);
										$cor = "#D8D8D8";
										while ($vetor_EVENTOS=mysql_fetch_array($sql_EVENTOS)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
											} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="100px" align="center"><?php echo date('d/m/Y', strtotime($vetor_EVENTOS['FISH_EVE_DATA'])); ?></td><td width="3px"></td>
										<td width="250px"><?php echo $vetor_EVENTOS['FISH_EVE_TIPO_DESC']; ?></td><td width="3px"></td>
										<td width="400px"><?php echo $vetor_EVENTOS['FISH_EVE_OBSERVACOES']; ?></td><td width="3px"></td>
										<td width="100px" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('cadastrar_fish_dados_eventos.php?id_evento=<?php echo $vetor_EVENTOS["FISH_EVE_CODIGO"];?>&id_familia=<?php echo $id_familia;?>','Dados do Evento', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_eventos.php?id_evento=<?php echo $vetor_EVENTOS['FISH_EVE_CODIGO']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="relatorio_fish_evento.php?id_evento=<?php echo $vetor_EVENTOS['FISH_EVE_CODIGO']; ?>" target="_blank"><img src="imgs/imprimir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
							</div>                                
						</div> <!-- Eventos -->

						<div id="view5">
							<h4>Inserir Acompanhamento Técnico // <a class="fancybox fancybox.ajax" href="relatorio_fish_plano_acomp_resumo.php?id_familia=<?php echo $id_familia; ?>" target="_blank"><img src="imgs/imprimir.png" width="25" height="25" border="0"></a> Imprimir Resumo (Bloco A e B)</h4><hr>
							<form action="recebe_fish_cadastrar_campanha.php?id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_fish_inserir_campanha" enctype="multipart/form-data" id="formID">
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_CAMPANHA_CAMPANHA">Campanha:</label>
										<select name="FISH_CAMPANHA_CAMPANHA" id="FISH_CAMPANHA_CAMPANHA" class="form-control">
											<?php while ($vetor_CAMPANHA=mysql_fetch_array($sql_CAMPANHA)) { ?>
											<option value="<?php echo $vetor_CAMPANHA['FISH_CAMP_ID']; ?>"><?php echo $vetor_CAMPANHA['FISH_CAMP_DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_CAMPANHA_DATA">Data da Entrevista:</label>
										<input type="text" name="FISH_CAMPANHA_DATA" class="form-control" id="FISH_CAMPANHA_DATA" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10">
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_CAMPANHA_TECNICO">Técnico:</label>
										<select name="FISH_CAMPANHA_TECNICO" id="FISH_CAMPANHA_TECNICO" class="form-control">
											<?php while ($vetor_TECNICO=mysql_fetch_array($sql_TECNICO)) { ?>
											<option value="<?php echo $vetor_TECNICO['ID']; ?>"><?php echo $vetor_TECNICO['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_CAMPANHA_FICHAS">Fichas entregues:</label>
										<input type="text" name="FISH_CAMPANHA_FICHAS" class="form-control" id="FISH_CAMPANHA_FICHAS" placeholder="Digite a qtde..." onKeyPress="mascara(this,minteiro)">
									</div>
								</div>
								</br>
								<input name="pesq" type="image" src="imgs/salvar.png" class="float" />
							</form>
							</br>
							</br>
							<table width="98%">
								<thead>
									<td width="27%">Campanha</td>
									<td width="2%"></td>
									<td width="27%">Data</td>
									<td width="2%"></td>
									<td width="27%">Técnico</td>
									<td width="2%"></td>
									<td width="10%">Ações</td>
								</thead>
								<?php 
									$sql_CAMPANHAS = mysql_query("SELECT TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_ID, TAB_FISH_ACOMP_ENTREVISTA.FISH_FAM_ID, TAB_FISH_CAMPANHAS.FISH_CAMP_DESCRICAO AS FISH_AE_CAMPANHA, TAB_APOIO_TECNICOS.DESCRICAO AS FISH_AE_TECNICO, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_DT_ENTR_ATUAL FROM TAB_FISH_ACOMP_ENTREVISTA INNER JOIN TAB_FISH_CAMPANHAS ON TAB_FISH_CAMPANHAS.FISH_CAMP_ID = TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_CAMPANHA INNER JOIN TAB_APOIO_TECNICOS ON TAB_APOIO_TECNICOS.ID = TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_TECNICO WHERE TAB_FISH_ACOMP_ENTREVISTA.FISH_FAM_ID = '$id_familia' ORDER BY TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_DT_ENTR_ATUAL DESC, TAB_FISH_CAMPANHAS.FISH_CAMP_DESCRICAO DESC;", $db);
									$cor = "#D8D8D8";
									while ($vetor_CAMPANHAS=mysql_fetch_array($sql_CAMPANHAS)) {
										if (strcasecmp($cor, "#FFFFFF") == 0){
											$cor = "#D8D8D8";
											} else {
											$cor = "#FFFFFF";
										}
								?>
								<tr bgcolor="<?php echo $cor; ?>">
									<td width="27%" align="center"><?php echo $vetor_CAMPANHAS['FISH_AE_CAMPANHA']; ?></td>
									<td width="2%"></td>
									<td width="27%" align="center"><?php echo date('d/m/Y', strtotime($vetor_CAMPANHAS['FISH_AE_DT_ENTR_ATUAL'])); ?></td>
									<td width="2%"></td>
									<td width="27%" align="center"><?php echo $vetor_CAMPANHAS['FISH_AE_TECNICO']; ?></td>
									<td width="2%"></td>
									<td width="10%" align="center">
									<a class="fancybox fancybox.ajax" hef="#" onClick="window.open('cadastrar_fish_dados_campanha.php?id_camp=<?php echo $vetor_CAMPANHAS['FISH_AE_ID'];?>&id_familia=<?php echo $id_familia;?>','Dados do Acompanhamento', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a></td>
								</tr>
								<?php } ?>
							</table>
						</div> <!-- Acompanhamento -->

						<div id="view6">
							<div style="width: 100%; margin: 0 auto;">
								<ul class="tabs" data-persist="true">
									<li><a href="#view6.1">Resumo</a></li>
								</ul>
								<div class="tabcontents">
									<div id="view6.1">
										<?php if ($num_RESUMO > 0) { ?>
											<form action="recebe_fish_alterar_acomp_antestrans.php?id_familia=<?php echo $id_familia; ?>" method="post" name="acomp_antestrans" enctype="multipart/form-data" id="formAcompAntesTrans">
												<h2>Resumo</h2><hr>
												<div class="form-group row">
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_BOO_PESCAVA">02 - Estava pescando?</label>
														<select name="FISH_AA_BOO_PESCAVA" id="FISH_AA_BOO_PESCAVA" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_RESUMO['FISH_PERFISH_AA_BOO_PESCAVAFIL_VISITA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_RESUMO['FISH_AA_BOO_PESCAVA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_RESUMO['FISH_AA_BOO_PESCAVA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_QT_PESCA_QTMES">03 - Pescarias por mês:</label>
														<input type="text" name="FISH_AA_QT_PESCA_QTMES" class="form-control" id="FISH_AA_QT_PESCA_QTMES" placeholder="Digite a qtde..." value="<?php echo $vetor_RESUMO['FISH_AA_QT_PESCA_QTMES'];?>" onKeyPress="mascara(this,minteiro)">
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_QT_PESCA_QTINT">04 - Média de dias:</label>
														<input type="text" name="FISH_AA_QT_PESCA_QTINT" class="form-control" id="FISH_AA_QT_PESCA_QTINT" placeholder="Digite a qtde..." value="<?php echo $vetor_RESUMO['FISH_AA_QT_PESCA_QTINT'];?>" onKeyPress="mascara(this,minteiro)">
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_QT_PESCA_QTDIAS">05 - Total de dias:</label>
														<input type="text" name="FISH_AA_QT_PESCA_QTDIAS" class="form-control" id="FISH_AA_QT_PESCA_QTDIAS" placeholder="Digite a qtde..." value="<?php echo $vetor_RESUMO['FISH_AA_QT_PESCA_QTDIAS'];?>" onKeyPress="mascara(this,minteiro)">
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_QT_PESCA_QTPESSOAS">06 - Quantas pessoas:</label>
														<input type="text" name="FISH_AA_QT_PESCA_QTPESSOAS" class="form-control" id="FISH_AA_QT_PESCA_QTPESSOAS" placeholder="Digite a qtde..." value="<?php echo $vetor_RESUMO['FISH_AA_QT_PESCA_QTPESSOAS'];?>" onKeyPress="mascara(this,minteiro)">
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_QT_PESCA_PRODTEMP">07 - KGs pescado na temporada:</label>
														<input type="text" name="FISH_AA_QT_PESCA_PRODTEMP" class="form-control" id="FISH_AA_QT_PESCA_PRODTEMP" placeholder="Média..." onKeyPress="mascara(this,mvalor)" maxlength="20" value="<?php echo number_format($vetor_RESUMO['FISH_AA_QT_PESCA_PRODTEMP'],2,',','.'); ?>">
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_QT_PESCA_PRODFTEMP">08 - KGs pescado fora da temporada:</label>
														<input type="text" name="FISH_AA_QT_PESCA_PRODFTEMP" class="form-control" id="FISH_AA_QT_PESCA_PRODFTEMP" placeholder="Média..." onKeyPress="mascara(this,mvalor)" maxlength="20" value="<?php echo number_format($vetor_RESUMO['FISH_AA_QT_PESCA_PRODFTEMP'],2,',','.'); ?>">
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_BOO_PESCA_VENDIA">09 - Vendia todo/parte do pescado?</label>
														<select name="FISH_AA_BOO_PESCA_VENDIA" id="FISH_AA_BOO_PESCA_VENDIA" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_RESUMO['FISH_AA_BOO_PESCA_VENDIA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_RESUMO['FISH_AA_BOO_PESCA_VENDIA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_RESUMO['FISH_AA_BOO_PESCA_VENDIA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_VL_PESCA_PRODMEDIA">11 - Valor médio (R$) de venda:</label>
														<input type="text" name="FISH_AA_VL_PESCA_PRODMEDIA" class="form-control" id="FISH_AA_VL_PESCA_PRODMEDIA" placeholder="Média..." onKeyPress="mascara(this,mvalor)" maxlength="20" value="<?php echo number_format($vetor_RESUMO['FISH_AA_VL_PESCA_PRODMEDIA'],2,',','.'); ?>">
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_QT_PESCA_PRODVENDA">10 - Qtde média KG vendido:</label>
														<input type="text" name="FISH_AA_QT_PESCA_PRODVENDA" class="form-control" id="FISH_AA_QT_PESCA_PRODVENDA" placeholder="Média..." onKeyPress="mascara(this,mvalor)" maxlength="20" value="<?php echo number_format($vetor_RESUMO['FISH_AA_QT_PESCA_PRODVENDA'],2,',','.'); ?>">
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_AA_QT_PESCA_PRODCOSUMO">13 - Qtde média KG consumido:</label>
														<input type="text" name="FISH_AA_QT_PESCA_PRODCOSUMO" class="form-control" id="FISH_AA_QT_PESCA_PRODCOSUMO" placeholder="Média..." onKeyPress="mascara(this,mvalor)" maxlength="20" value="<?php echo number_format($vetor_RESUMO['FISH_AA_QT_PESCA_PRODCOSUMO'],2,',','.'); ?>">
													</div>
												</div>
												</br>
												<input name="pesq" type="image" src="imgs/salvar.png" class="float" />
											</form></br>
											<div style="width: 100%; margin: 0 auto;">
												<ul class="tabs" data-persist="true">
													<li><a href="#view6.1.1">Equipamentos</a></li>
													<li><a href="#view6.1.2">Comercialização</a></li>
													<li><a href="#view6.1.3">Motivos de Não Pescar</a></li>
												</ul>
												<div class="tabcontents">
													<div id="view6.1.1">
														<form action="recebe_fish_cadastrar_acomp_at_equip.php?id_familia=<?php echo $id_familia; ?>" method="post" name="atEquip" enctype="multipart/form-data" id="atEquip">
															<table width="100%"><thead><td width="80%">Equipamentos</td><td width="2%"></td><td width="18%">&nbsp;</td></thead></table>
															<div id="campoPai_RESUMO_EQUIP"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
															<br/>
															<input type="button" value="Adicionar" onClick="addCampos_RESUMO_EQUIP()" class="btn btn-inline">
															<br/><br/>
															<table width="100%">
																<thead>
																	<td width="80%">Equipamentos</td>
																	<td width="2%"></td>
																	<td width="18%">Ações</td>
																</thead>
																<?php
																	$sql_ATEquip = mysql_query("SELECT TAB_FISH_ACOMP_AT_EQUIP.FISH_AAE_ID, TAB_APOIO_PESCA_EQUIP.DESCRICAO AS FISH_AAE_TIPO_DESC FROM TAB_FISH_ACOMP_AT_EQUIP LEFT OUTER JOIN  TAB_APOIO_PESCA_EQUIP ON TAB_FISH_ACOMP_AT_EQUIP.FISH_AAE_TIPO = TAB_APOIO_PESCA_EQUIP.ID WHERE TAB_FISH_ACOMP_AT_EQUIP.FISH_AAE_FAM = '$id_familia' ORDER BY FISH_AAE_TIPO_DESC ASC;", $db) or die(mysql_error());
																	$cor = "#D8D8D8";
																	while ($vetor_ATEquip=mysql_fetch_array($sql_ATEquip)) {
																		if (strcasecmp($cor, "#FFFFFF") == 0){
																			$cor = "#D8D8D8";
																		} else {
																			$cor = "#FFFFFF";
																		}
																?>
																<tr bgcolor="<?php echo $cor; ?>">
																	<td width="80%"><?php echo $vetor_ATEquip['FISH_AAE_TIPO_DESC']; ?></td>
																	<td width="2%"></td>
																	<td width="18%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_acomp_at_equip.php?id=<?php echo $vetor_ATEquip['FISH_AAE_ID']; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
																</tr>
																<?php } ?>
															</table>
															</br>
															<input name="salvar" type="image" src="imgs/salvar.png" class="float" />
														</form>
													</div>
													<div id="view6.1.2">
														<form action="recebe_fish_cadastrar_acomp_at_comercio.php?id_familia=<?php echo $id_familia; ?>" method="post" name="atComercio" enctype="multipart/form-data" id="atComercio">
															<table width="100%"><thead><td width="80%">Comercialização</td><td width="2%"></td><td width="18%">&nbsp;</td></thead></table>
															<div id="campoPai_RESUMO_COMERCIO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
															<br/>
															<input type="button" value="Adicionar" onClick="addCampos_RESUMO_COMERCIO()" class="btn btn-inline">
															<br/><br/>
															<table width="100%">
																<thead>
																	<td width="80%">Comercialização</td>
																	<td width="2%"></td>
																	<td width="18%">Ações</td>
																</thead>
																<?php
																	$sql_ATComercio = mysql_query("SELECT TAB_FISH_ACOMP_AT_COMERCIO.FISH_AAC_ID, TAB_APOIO_PESCA_COMERCIO.DESCRICAO AS FISH_AAC_TIPO_DESC FROM TAB_FISH_ACOMP_AT_COMERCIO LEFT OUTER JOIN  TAB_APOIO_PESCA_COMERCIO ON TAB_FISH_ACOMP_AT_COMERCIO.FISH_AAC_TIPO = TAB_APOIO_PESCA_COMERCIO.ID WHERE TAB_FISH_ACOMP_AT_COMERCIO.FISH_AAC_FAM = '$id_familia' ORDER BY FISH_AAC_TIPO_DESC ASC;", $db) or die(mysql_error());
																	$cor = "#D8D8D8";
																	while ($vetor_ATComercio=mysql_fetch_array($sql_ATComercio)) {
																		if (strcasecmp($cor, "#FFFFFF") == 0){
																			$cor = "#D8D8D8";
																		} else {
																			$cor = "#FFFFFF";
																		}
																?>
																<tr bgcolor="<?php echo $cor; ?>">
																	<td width="80%"><?php echo $vetor_ATComercio['FISH_AAC_TIPO_DESC']; ?></td>
																	<td width="2%"></td>
																	<td width="18%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_acomp_at_comercio.php?id=<?php echo $vetor_ATComercio['FISH_AAC_ID']; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
																</tr>
																<?php } ?>
															</table>
															</br>
															<input name="salvar" type="image" src="imgs/salvar.png" class="float" />
														</form>
													</div>
													<div id="view6.1.3">
														<form action="recebe_fish_cadastrar_acomp_at_motivo.php?id_familia=<?php echo $id_familia; ?>" method="post" name="atMotivo" enctype="multipart/form-data" id="atMotivo">
															<table width="100%"><thead><td width="80%">Motivos de Não Pescar</td><td width="2%"></td><td width="18%">&nbsp;</td></thead></table>
															<div id="campoPai_RESUMO_MOTIVO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
															<br/>
															<input type="button" value="Adicionar" onClick="addCampos_RESUMO_MOTIVO()" class="btn btn-inline">
															<br/><br/>
															<table width="100%">
																<thead>
																	<td width="80%">Motivos de Não Pescar</td>
																	<td width="2%"></td>
																	<td width="18%">Ações</td>
																</thead>
																<?php
																	$sql_ATMotivo = mysql_query("SELECT TAB_FISH_ACOMP_AT_MOTIVO.FISH_AAM_ID, TAB_APOIO_PESCA_MOTIVO.DESCRICAO AS FISH_AAM_TIPO_DESC FROM TAB_FISH_ACOMP_AT_MOTIVO LEFT OUTER JOIN  TAB_APOIO_PESCA_MOTIVO ON TAB_FISH_ACOMP_AT_MOTIVO.FISH_AAM_TIPO = TAB_APOIO_PESCA_MOTIVO.ID WHERE TAB_FISH_ACOMP_AT_MOTIVO.FISH_AAM_FAM = '$id_familia' ORDER BY FISH_AAM_TIPO_DESC ASC;", $db) or die(mysql_error());
																	$cor = "#D8D8D8";
																	while ($vetor_ATMotivo=mysql_fetch_array($sql_ATMotivo)) {
																		if (strcasecmp($cor, "#FFFFFF") == 0){
																			$cor = "#D8D8D8";
																		} else {
																			$cor = "#FFFFFF";
																		}
																?>
																<tr bgcolor="<?php echo $cor; ?>">
																	<td width="80%"><?php echo $vetor_ATMotivo['FISH_AAM_TIPO_DESC']; ?></td>
																	<td width="2%"></td>
																	<td width="18%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_acomp_at_motivo.php?id=<?php echo $vetor_ATMotivo['FISH_AAM_ID']; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
																</tr>
																<?php } ?>
															</table>
															</br>
															<input name="salvar" type="image" src="imgs/salvar.png" class="float" />
														</form>

													</div>
												</div>
											</div>
										<?php } else { ?>
											<form action="recebe_fish_cadastrar_acomp_antestrans.php?id_familia=<?php echo $id_familia; ?>" method="post" name="acomp_antestrans" enctype="multipart/form-data" id="formAcompAntesTrans">
												<input name="pesq" type="image" src="imgs/gerar.png" class="float" />
											</form>
										<?php } ?>
									</div> <!-- Perfil de Entrada -->
								</div>
							</div>
						</div> <!-- Perfil -->

						<div id="view7">
							<?php if ($num_COOPERATIVA > 0) { ?>
								<div style="width: 100%; margin: 0 auto;">
									<ul class="tabs" data-persist="true">
										<li><a href="#view7.1">Bloco 01</a></li>
										<li><a href="#view7.2">Bloco 02</a></li>
										<li><a href="#view7.3">Bloco 03</a></li>
									</ul>
									<div class="tabcontents">
										<div id="view7.1">
											<form action="recebe_fish_alterar_cooperativa.php?id_familia=<?php echo $id_familia; ?>&FISH_COOP_ID=<?php echo $vetor_COOPERATIVA['FISH_COOP_ID'];?>" method="post" name="recebe_fish_alterar_cooperativa" enctype="multipart/form-data" id="recebe_fish_alterar_cooperativa">
												<h2>Dados Principais</h2><hr>
												<div class="form-group row">
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOP_QUEST">Número do Questionário:</label>
														<input type="text" name="FISH_COOP_QUEST" class="form-control" id="FISH_COOP_QUEST" placeholder="Número do questionário..." value="<?php echo $vetor_COOPERATIVA['FISH_COOP_QUEST']; ?>">
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOP_NUMNESA">Código NESA:</label>
														<input type="text" name="FISH_COOP_NUMNESA" class="form-control" id="FISH_COOP_NUMNESA" placeholder="Código NESA..." value="<?php echo $vetor_COOPERATIVA['FISH_COOP_NUMNESA']; ?>">
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOP_NUMFAMSIS">N_FAM_SIS Família:</label>
														<input type="text" name="FISH_COOP_NUMFAMSIS" class="form-control" id="FISH_COOP_NUMFAMSIS" placeholder="N_FAM_SIS..." value="<?php echo $vetor_COOPERATIVA['FISH_COOP_NUMFAMSIS']; ?>">
													</div>
												</div> <!-- Número do Questionário, Código NESA e Código WP -->
												<div class="form-group row">
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOP_ENTREVISTA">Entrevistador:</label>
														<select name="FISH_COOP_ENTREVISTA" id="FISH_COOP_ENTREVISTA" class="form-control">
															<?php while ($vetor_TECNICO_COOPERATIVA = mysql_fetch_array($sql_TECNICO_COOPERATIVA)) { ?>
															<option value="<?php echo $vetor_TECNICO_COOPERATIVA['ID']; ?>" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_ENTREVISTA'], $vetor_TECNICO_COOPERATIVA['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TECNICO_COOPERATIVA['DESCRICAO']; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOP_DTENTREVISTA">Data da Entrevista:</label>
														<input type="text" name="FISH_COOP_DTENTREVISTA" class="form-control" id="FISH_COOP_DTENTREVISTA" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_COOPERATIVA['FISH_COOP_DTENTREVISTA'])) { echo 'value='.date('d/m/Y', strtotime($vetor_COOPERATIVA['FISH_COOP_DTENTREVISTA'])); } ?>>
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOP_LOCENTREVISTA">Local da Entrevista:</label>
														<input type="text" name="FISH_COOP_LOCENTREVISTA" class="form-control" id="FISH_COOP_LOCENTREVISTA" placeholder="Local da Entrevista..." value="<?php echo $vetor_COOPERATIVA['FISH_COOP_LOCENTREVISTA']; ?>">
													</div>
												</div> <!-- Dados da Entrevista -->
												<div class="form-group row">
													<div class="col-lg-6">
														<label class="form-label semibold" for="FISH_COOP_ATIVPRINCIPAL">Atividade Econômica Principal:</label>
														<select name="FISH_COOP_ATIVPRINCIPAL" id="FISH_COOP_ATIVPRINCIPAL" class="form-control">
															<?php while ($vetor_ATIVECON_PRINCIPAL = mysql_fetch_array($sql_ATIVECON_PRINCIPAL)) { ?>
															<option value="<?php echo $vetor_ATIVECON_PRINCIPAL['ID']; ?>" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_ATIVPRINCIPAL'], $vetor_ATIVECON_PRINCIPAL['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_ATIVECON_PRINCIPAL['DESCRICAO']; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-lg-6">
														<label class="form-label semibold" for="FISH_COOP_ATIVSECUNDARIA">Atividade Econômica Secundária:</label>
														<select name="FISH_COOP_ATIVSECUNDARIA" id="FISH_COOP_ATIVSECUNDARIA" class="form-control">
															<?php while ($vetor_ATIVECON_SECUNDARIA = mysql_fetch_array($sql_ATIVECON_SECUNDARIA)) { ?>
															<option value="<?php echo $vetor_ATIVECON_SECUNDARIA['ID']; ?>" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_ATIVSECUNDARIA'], $vetor_ATIVECON_SECUNDARIA['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_ATIVECON_SECUNDARIA['DESCRICAO']; ?></option>
															<?php } ?>
														</select>
													</div>
												</div> <!-- Atividades Econômicas -->
												<div class="form-group row">
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOP_ATIVPESCA">Pratica Pesca?</label>
														<select name="FISH_COOP_ATIVPESCA" id="FISH_COOP_ATIVPESCA" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_ATIVPESCA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_ATIVPESCA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_ATIVPESCA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOP_ATIVPESCATEMPO">Tempo de Pescaria <strong>(ANOS)</strong>:</label>
														<input type="text" name="FISH_COOP_ATIVPESCATEMPO" class="form-control" id="FISH_COOP_ATIVPESCATEMPO" placeholder="Tempo de pesca..." onKeyPress="mascara(this,minteiro)" value="<?php echo $vetor_COOPERATIVA['FISH_COOP_ATIVPESCATEMPO']; ?>">
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOP_ATIVPESCAUNIT">Unidade do Tempo:</label>
														<select name="FISH_COOP_ATIVPESCAUNIT" id="FISH_COOP_ATIVPESCAUNIT" class="form-control">
															<?php while ($vetor_UNITMEDIDA_TEMPO = mysql_fetch_array($sql_UNITMEDIDA_TEMPO)) { ?>
															<option value="<?php echo $vetor_UNITMEDIDA_TEMPO['ID']; ?>" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_ATIVPESCAUNIT'], $vetor_UNITMEDIDA_TEMPO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_UNITMEDIDA_TEMPO['DESCRICAO']; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOP_ATIVPESCATIPO">Tipo da Atividade de Pesca:</label>
														<select name="FISH_COOP_ATIVPESCATIPO" id="FISH_COOP_ATIVPESCATIPO" class="form-control">
															<?php while ($vetor_ATIVPESCA = mysql_fetch_array($sql_ATIVPESCA)) { ?>
															<option value="<?php echo $vetor_ATIVPESCA['ID']; ?>" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_ATIVPESCATIPO'], $vetor_ATIVPESCA['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_ATIVPESCA['DESCRICAO']; ?></option>
															<?php } ?>
														</select>
													</div>
												</div> <!-- Atividade da Pesca -->
												<br/><h2>Outros Projetos com a Norte Energia</h2><hr>
												<div class="form-group row">
													<div class="col-lg-12">
														<label class="form-label semibold" for="FISH_COOP_PROJETONESA">Atendida por outro projeto da Norte Energia?</label>

														<select name="FISH_COOP_PROJETONESA" id="FISH_COOP_PROJETONESA" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_PROJETONESA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_PROJETONESA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_PROJETONESA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select><br/>
													</div>
													<div id="scroll_projetosnesa">
														<table width="100%">
															<thead>
																<td width="88%">Projeto</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">&nbsp;</td>
															</thead>
														</table>
														<div id="campoPai_COOP_PROJETONESA"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
														</br>
														<input type="button" value="Novo Projeto" onClick="addCampos_COOP_PROJETONESA()" class="btn btn-inline">
														</br></br>
														<table width="100%">
															<thead>
																<td width="88%">Projeto</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">Ações</td>
															</thead>
															<?php
																$id_COOP_PROJETOSNESA = $vetor_COOPERATIVA['FISH_COOP_ID'];
																$sql_COOP_PROJETOSNESA = mysql_query("SELECT TAB_FISH_COOP_PROJUHE.FISH_COOUHE_ID, TAB_APOIO_TPPROJSUHE.DESCRICAO AS FISH_COOUHE_PROJETO_DESC FROM TAB_FISH_COOP_PROJUHE LEFT OUTER JOIN TAB_APOIO_TPPROJSUHE ON TAB_FISH_COOP_PROJUHE.FISH_COOUHE_PROJETO = TAB_APOIO_TPPROJSUHE.ID WHERE TAB_FISH_COOP_PROJUHE.FISH_COOP_ID = '$id_COOP_PROJETOSNESA' ORDER BY FISH_COOUHE_PROJETO_DESC ASC;", $db) or die( mysql_error());
																$cor = "#D8D8D8";
																while ($vetor_COOP_PROJETOSNESA = mysql_fetch_array($sql_COOP_PROJETOSNESA)) {
																	if (strcasecmp($cor, "#FFFFFF") == 0){
																		$cor = "#D8D8D8";
																	} else {
																		$cor = "#FFFFFF";
																	}
															?>
															<tr bgcolor="<?php echo $cor; ?>">
																<td width="88%"><?php echo $vetor_COOP_PROJETOSNESA['FISH_COOUHE_PROJETO_DESC']; ?></td>
																<td width="2%">&nbsp;</td>
																<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_cooperativa_projuhe.php?FISH_COOUHE_ID=<?php echo $vetor_COOP_PROJETOSNESA['FISH_COOUHE_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
															</tr>
															<?php } ?>
														</table>
													</div>                                
												</div> <!-- Outros Projetos com a Norte Energia -->
												<br/><h2>Principais Despesas da Família</h2><hr>
												<div class="form-group row">
													<div id="scroll_despesas">
														<table width="100%">
															<thead>
																<td width="55%">Despesa</td>
																<td width="2%">&nbsp;</td>
																<td width="31%">Valor (R$)</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">&nbsp;</td>
															</thead>
														</table>
														<div id="campoPai_COOP_DESPESAS"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
														</br>
														<input type="button" value="Nova Despesa" onClick="addCampos_COOP_DESPESAS()" class="btn btn-inline">
														</br></br>
														<table width="100%">
															<thead>
																<td width="55%">Despesa</td>
																<td width="2%">&nbsp;</td>
																<td width="31%">Valor (R$)</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">Ações</td>
															</thead>
															<?php
																$id_COOP_DESPESAS = $vetor_COOPERATIVA['FISH_COOP_ID'];
																$sql_COOP_DESPESAS = mysql_query("SELECT TAB_FISH_COOP_DESPESAS.FISH_COODES_ID, TAB_APOIO_DESPESAS.DESCRICAO AS FISH_COODES_DESPESA_DESC, TAB_FISH_COOP_DESPESAS.FISH_COODES_VALOR FROM TAB_FISH_COOP_DESPESAS LEFT OUTER JOIN TAB_APOIO_DESPESAS ON TAB_FISH_COOP_DESPESAS.FISH_COODES_DESPESA = TAB_APOIO_DESPESAS.ID WHERE TAB_FISH_COOP_DESPESAS.FISH_COOP_ID = '$id_COOP_DESPESAS' ORDER BY TAB_FISH_COOP_DESPESAS.FISH_COODES_VALOR DESC, FISH_COODES_DESPESA_DESC ASC;", $db) or die( mysql_error());
																$cor = "#D8D8D8";
																while ($vetor_COOP_DESPESAS = mysql_fetch_array($sql_COOP_DESPESAS)) {
																	if (strcasecmp($cor, "#FFFFFF") == 0){
																		$cor = "#D8D8D8";
																	} else {
																		$cor = "#FFFFFF";
																	}
															?>
															<tr bgcolor="<?php echo $cor; ?>">
																<td width="55%"><?php echo $vetor_COOP_DESPESAS['FISH_COODES_DESPESA_DESC']; ?></td>
																<td width="2%">&nbsp;</td>
																<td width="31%"><?php echo 'R$ '.number_format($vetor_COOP_DESPESAS['FISH_COODES_VALOR'],2,',','.'); ?></td>
																<td width="2%">&nbsp;</td>
																<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_cooperativa_despesas.php?FISH_COODES_ID=<?php echo $vetor_COOP_DESPESAS['FISH_COODES_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
															</tr>
															<?php } ?>
														</table>
													</div>                                							
												</div> <!-- Principais Despesas da Família -->
												<br/><h2>Origem do Trabalho fora da Pesca</h2><hr>
												<div class="form-group row">
													<div class="col-lg-12">
														<label class="form-label semibold" for="FISH_COOP_OUTRASRENDAS">Além da pesca alguém da família tem outra atividade remunerada?</label>
														<select name="FISH_COOP_OUTRASRENDAS" id="FISH_COOP_OUTRASRENDAS" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_OUTRASRENDAS'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_OUTRASRENDAS'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_OUTRASRENDAS'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select><br/>
													</div>
													<div id="scroll_outrasrendas">
														<table width="100%">
															<thead>
																<td width="31%">Componente</td>
																<td width="2%">&nbsp;</td>
																<td width="31%">Tipo da Atividade</td>
																<td width="2%">&nbsp;</td>
																<td width="20%">Renda Mensal (R$)</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">&nbsp;</td>
															</thead>
														</table>
														<div id="campoPai_COOP_OUTRASRENDAS"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
														</br>
														<input type="button" value="Novo Rendimento" onClick="addCampos_COOP_OUTRASRENDAS()" class="btn btn-inline">
														</br></br>
														<table width="100%">
															<thead>
																<td width="31%">Componente</td>
																<td width="2%">&nbsp;</td>
																<td width="31%">Tipo da Atividade</td>
																<td width="2%">&nbsp;</td>
																<td width="20%">Renda Mensal (R$)</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">Ações</td>
															</thead>
															<?php
																$id_COOP_OUTRASRENDAS = $vetor_COOPERATIVA['FISH_COOP_ID'];
																$sql_COOP_OUTRASRENDAS = mysql_query("SELECT TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_ID, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME AS FISH_COOREN_COMPONENTE_DESC, TAB_APOIO_OCUPACAO.DESCRICAO AS FISH_COOREN_OCUPACAO_DESC, TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_RENDA FROM TAB_FISH_COOP_OUTRASRENDAS LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_COMPONENTE = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ID LEFT OUTER JOIN TAB_APOIO_OCUPACAO ON TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_OCUPACAO = TAB_APOIO_OCUPACAO.ID WHERE TAB_FISH_COOP_OUTRASRENDAS.FISH_COOP_ID = '$id_COOP_OUTRASRENDAS' ORDER BY FISH_COOREN_COMPONENTE_DESC ASC, TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_RENDA DESC;", $db) or die( mysql_error());
																$cor = "#D8D8D8";
																while ($vetor_COOP_OUTRASRENDAS = mysql_fetch_array($sql_COOP_OUTRASRENDAS)) {
																	if (strcasecmp($cor, "#FFFFFF") == 0){
																		$cor = "#D8D8D8";
																	} else {
																		$cor = "#FFFFFF";
																	}
															?>
															<tr bgcolor="<?php echo $cor; ?>">
																<td width="31%"><?php echo $vetor_COOP_OUTRASRENDAS['FISH_COOREN_COMPONENTE_DESC']; ?></td>
																<td width="2%">&nbsp;</td>
																<td width="31%"><?php echo $vetor_COOP_OUTRASRENDAS['FISH_COOREN_OCUPACAO_DESC']; ?></td>
																<td width="2%">&nbsp;</td>
																<td width="20%"><?php echo 'R$ '.number_format($vetor_COOP_OUTRASRENDAS['FISH_COOREN_RENDA'],2,',','.'); ?></td>
																<td width="2%">&nbsp;</td>
																<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_cooperativa_outrasrendas.php?FISH_COOREN_ID=<?php echo $vetor_COOP_OUTRASRENDAS['FISH_COOREN_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
															</tr>
															<?php } ?>
														</table>
													</div>                                							
												</div> <!-- Origem do Trabalho fora da Pesca -->
												<br/><h2>Benefícios Sociais</h2><hr>
												<div class="form-group row">
													<div class="col-lg-12">
														<label class="form-label semibold" for="FISH_COOP_BENEFSOCIAIS">Existem pessoas que recebem algum Benefício Social ou de Distribuição de Renda?</label>
														<select name="FISH_COOP_BENEFSOCIAIS" id="FISH_COOP_BENEFSOCIAIS" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_BENEFSOCIAIS'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_BENEFSOCIAIS'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_BENEFSOCIAIS'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select><br/>
													</div>
													<div id="scroll_beneficios">
														<table width="100%">
															<thead>
																<td width="31%">Componente</td>
																<td width="2%">&nbsp;</td>
																<td width="31%">Tipo do Benefício</td>
																<td width="2%">&nbsp;</td>
																<td width="20%">Renda Mensal (R$)</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">&nbsp;</td>
															</thead>
														</table>
														<div id="campoPai_COOP_BENEFICIOS"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
														</br>
														<input type="button" value="Novo Benefício" onClick="addCampos_COOP_BENEFICIOS()" class="btn btn-inline">
														</br></br>
														<table width="100%">
															<thead>
																<td width="31%">Componente</td>
																<td width="2%">&nbsp;</td>
																<td width="31%">Tipo do Benefício</td>
																<td width="2%">&nbsp;</td>
																<td width="20%">Renda Mensal (R$)</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">Ações</td>
															</thead>
															<?php
																$id_COOP_BENEFICIOS = $vetor_COOPERATIVA['FISH_COOP_ID'];
																$sql_COOP_BENEFICIOS = mysql_query("SELECT TAB_FISH_COOP_BENEFICIOS.FISH_COOBEN_ID, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME AS FISH_COOBEN_COMPONENTE_DESC, TAB_APOIO_BENEFSOCIAIS.DESCRICAO AS FISH_COOBEN_BENEFICIO_DESC, TAB_FISH_COOP_BENEFICIOS.FISH_COOBEN_RENDA FROM TAB_FISH_COOP_BENEFICIOS LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_COOP_BENEFICIOS.FISH_COOBEN_COMPONENTE = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ID LEFT OUTER JOIN TAB_APOIO_BENEFSOCIAIS ON TAB_FISH_COOP_BENEFICIOS.FISH_COOBEN_BENEFICIO = TAB_APOIO_BENEFSOCIAIS.ID WHERE TAB_FISH_COOP_BENEFICIOS.FISH_COOP_ID = '$id_COOP_BENEFICIOS' ORDER BY FISH_COOBEN_COMPONENTE_DESC ASC, TAB_FISH_COOP_BENEFICIOS.FISH_COOBEN_RENDA DESC;", $db) or die( mysql_error());
																$cor = "#D8D8D8";
																while ($vetor_COOP_BENEFICIOS = mysql_fetch_array($sql_COOP_BENEFICIOS)) {
																	if (strcasecmp($cor, "#FFFFFF") == 0){
																		$cor = "#D8D8D8";
																	} else {
																		$cor = "#FFFFFF";
																	}
															?>
															<tr bgcolor="<?php echo $cor; ?>">
																<td width="31%"><?php echo $vetor_COOP_BENEFICIOS['FISH_COOBEN_COMPONENTE_DESC']; ?></td>
																<td width="2%">&nbsp;</td>
																<td width="31%"><?php echo $vetor_COOP_BENEFICIOS['FISH_COOBEN_BENEFICIO_DESC']; ?></td>
																<td width="2%">&nbsp;</td>
																<td width="20%"><?php echo 'R$'.number_format($vetor_COOP_BENEFICIOS['FISH_COOBEN_RENDA'],2,',','.'); ?></td>
																<td width="2%">&nbsp;</td>
																<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_cooperativa_beneficios.php?FISH_COOBEN_ID=<?php echo $vetor_COOP_BENEFICIOS['FISH_COOBEN_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
															</tr>
															<?php } ?>
														</table>
													</div>                                							
												</div> <!-- Benefícios Sociais -->
												<h2>Características Produtivas</h2><hr>
												<div class="form-group row">
													<div class="col-lg-6">
														<label class="form-label semibold" for="FISH_COOP_AGRICULTURA">Pratica Agricultura ou Criação de Animais?</label>
														<select name="FISH_COOP_AGRICULTURA" id="FISH_COOP_AGRICULTURA" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_AGRICULTURA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_AGRICULTURA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_AGRICULTURA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-6">
														<label class="form-label semibold" for="FISH_COOP_AGRICCOMERCIO">Comercializa qualquer produção?</label>
														<select name="FISH_COOP_AGRICCOMERCIO" id="FISH_COOP_AGRICCOMERCIO" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_AGRICCOMERCIO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_AGRICCOMERCIO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_AGRICCOMERCIO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
												</div> <!-- Produz? Comercializa? -->
												<div class="form-group row">
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOP_AGRICPESSOAS">Pessoas que trabalham na Atividade:</label>
														<input type="text" name="FISH_COOP_AGRICPESSOAS" class="form-control" id="FISH_COOP_AGRICPESSOAS" placeholder="Quantidade..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_COOPERATIVA['FISH_COOP_AGRICPESSOAS']; ?>">
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOP_AGRICAREA">Tamanho da Área da Atividade:</label>
														<input type="text" name="FISH_COOP_AGRICAREA" class="form-control" id="FISH_COOP_AGRICAREA" placeholder="Quantidade..." onKeyPress="mascara(this,mvalor)" maxlength="10" value="<?php echo number_format($vetor_COOPERATIVA['FISH_COOP_AGRICAREA'],2,',','.'); ?>">
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOP_AGRICUNIT">Unidade Informada da Área:</label>
														<select name="FISH_COOP_AGRICUNIT" id="FISH_COOP_AGRICUNIT" class="form-control">
															<?php while ($vetor_UNITMEDIDA_TAMANHO = mysql_fetch_array($sql_UNITMEDIDA_TAMANHO)) { ?>
															<option value="<?php echo $vetor_UNITMEDIDA_TAMANHO['ID']; ?>" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_AGRICUNIT'], $vetor_UNITMEDIDA_TAMANHO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_UNITMEDIDA_TAMANHO['DESCRICAO']; ?></option>
															<?php } ?>
														</select>
													</div>
												</div> <!-- Número de pessoas / Área da Produção -->
												<div class="form-group row">
													<div class="col-lg-12">
														<label class="form-label semibold" for="FISH_COOP_AGRICDESCRICAO">Detalhe da Produção:</label>
														<textarea rows="4" name="FISH_COOP_AGRICDESCRICAO" id="FISH_COOP_AGRICDESCRICAO" class="form-control" placeholder="Descrever culturas e animais de criação eformas de comercialização..."><?php echo $vetor_COOPERATIVA['FISH_COOP_AGRICDESCRICAO']; ?></textarea><br/>
													</div>
												</div> <!-- Detalhamento -->
												<h2>Características da Alimentação</h2><hr>
												<div class="form-group row">
													<div class="col-lg-12">
														<label class="form-label semibold" for="FISH_COOP_CONSUMOPEIXE">Frequencia de Consumo de <strong>Peixe</strong>:</label>
														<select name="FISH_COOP_CONSUMOPEIXE" id="FISH_COOP_CONSUMOPEIXE" class="form-control">
															<?php while ($vetor_FREQCONSMPROT_PEIXE = mysql_fetch_array($sql_FREQCONSMPROT_PEIXE)) { ?>
															<option value="<?php echo $vetor_FREQCONSMPROT_PEIXE['ID']; ?>" <?php if (strcasecmp($vetor_COOPERATIVA['FISH_COOP_CONSUMOPEIXE'], $vetor_FREQCONSMPROT_PEIXE['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_FREQCONSMPROT_PEIXE['DESCRICAO']; ?></option>
															<?php } ?>
														</select><br/>
													</div>
												</div> <!-- Consumo de Proteína -->
												<h2>Observações Gerais da Entrevista:</h2><hr>
												<div class="form-group row">
													<div class="col-lg-12">
														<textarea rows="4" name="FISH_COOP_OBSERVACOES" id="FISH_COOP_OBSERVACOES" class="form-control" placeholder="Descrever culturas e animais de criação eformas de comercialização..."><?php echo $vetor_COOPERATIVA['FISH_COOP_OBSERVACOES']; ?></textarea>
													</div>
												</div> <!-- Detalhamento -->
												</br></br>
												<input name="pesq" type="image" src="imgs/salvar.png" class="float" />
											</form>
										</div>
										<div id="view7.2">
											<form action="recebe_fish_alterar_caracterizacao.php?id_familia=<?php echo $id_familia; ?>&FISH_COOCAR_ID=<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_ID'];?>" method="post" name="recebe_fish_alterar_caracterizacao" enctype="multipart/form-data" id="recebe_fish_alterar_caracterizacao">
												<h2>Caracterização da Atividade Pesqueira</h2><hr>
												<div class="form-group row">
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_PESCANDO">Atualmente, está pescando? </label>
														<select name="FISH_COOCAR_PESCANDO" id="FISH_COOCAR_PESCANDO" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_PESCANDO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_PESCANDO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_PESCANDO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-8">
														<label class="form-label semibold" for="FISH_COOCAR_MOTIVO">Se não, porque?</label>
														<input type="text" name="FISH_COOCAR_MOTIVO" class="form-control" id="FISH_COOCAR_MOTIVO" placeholder="Se não, porque não está pescando?" value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_MOTIVO']; ?>">
													</div>
												</div> <!-- Pescando? -->
												<div class="form-group row" id="scroll_motivos">
													<table width="100%">
														<thead>
															<td width="88%">Motivos de <strong>NÃO</strong> estar Pescando</td>
															<td width="2%">&nbsp;</td>
															<td width="10%">&nbsp;</td>
														</thead>
													</table>
													<div id="campoPai_COOP_CARACT_MOTIVO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
													</br>
													<input type="button" value="Novo Motivo" onClick="addCampos_COOP_CARACT_MOTIVO()" class="btn btn-inline">
													</br></br>
													<table width="100%">
														<?php
															$id_COOP_CARACT_MOTIVO = $vetor_CARACTERISTICAS['FISH_COOCAR_ID'];
															$sql_COOP_CARACT_MOTIVO = mysql_query("SELECT TAB_FISH_COOCAR_MOTIVOS.FISH_CPCMOT_ID, TAB_APOIO_PESCA_MOTIVO.DESCRICAO AS FISH_CPCMOT_MOTIVO_DESC FROM TAB_FISH_COOCAR_MOTIVOS LEFT OUTER JOIN TAB_APOIO_PESCA_MOTIVO ON TAB_FISH_COOCAR_MOTIVOS.FISH_CPCMOT_MOTIVO = TAB_APOIO_PESCA_MOTIVO.ID WHERE TAB_FISH_COOCAR_MOTIVOS.FISH_COOCAR_ID = '$id_COOP_CARACT_MOTIVO' ORDER BY FISH_CPCMOT_MOTIVO_DESC ASC;", $db) or die( mysql_error());
															$cor = "#D8D8D8";
															while ($vetor_COOP_CARACT_MOTIVO = mysql_fetch_array($sql_COOP_CARACT_MOTIVO)) {
																if (strcasecmp($cor, "#FFFFFF") == 0){
																	$cor = "#D8D8D8";
																} else {
																	$cor = "#FFFFFF";
																}
														?>
														<tr bgcolor="<?php echo $cor; ?>">
															<td width="88%"><?php echo $vetor_COOP_CARACT_MOTIVO['FISH_CPCMOT_MOTIVO_DESC']; ?></td>
															<td width="2%">&nbsp;</td>
															<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_caracterizacao_motivos.php?FISH_CPCMOT_ID=<?php echo $vetor_COOP_CARACT_MOTIVO['FISH_CPCMOT_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
														</tr>
														<?php } ?>
													</table><hr>
												</div> <!-- Motivos para não Pescar -->
												<div class="form-group row">
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_PESCANDO">Pesca sozinho? </label>
														<select name="FISH_COOCAR_SOZINHO" id="FISH_COOCAR_SOZINHO" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_SOZINHO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_SOZINHO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_SOZINHO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_QTS_PESSOAS">Pesca com qts pessoas?</label>
														<input type="text" name="FISH_COOCAR_QTS_PESSOAS" class="form-control" id="FISH_COOCAR_QTS_PESSOAS" placeholder="Pesca com qts pessoas?" value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_QTS_PESSOAS']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_QTS_FAMILIA">Pesca com qts da família?</label>
														<input type="text" name="FISH_COOCAR_QTS_FAMILIA" class="form-control" id="FISH_COOCAR_QTS_FAMILIA" placeholder="Pesca com qts da família?" value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_QTS_FAMILIA']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
												</div> <!-- Pesca sozinho? / Quantas pessoas? -->
												<div class="form-group row">
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_ORNAMENTAL">Pesca Ornamental? </label>
														<select name="FISH_COOCAR_ORNAMENTAL" id="FISH_COOCAR_ORNAMENTAL" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_ORNAMENTAL'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_ORNAMENTAL'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_ORNAMENTAL'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_CONSUMO">Pesca de Consumo?</label>
														<select name="FISH_COOCAR_CONSUMO" id="FISH_COOCAR_CONSUMO" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_CONSUMO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_CONSUMO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_CONSUMO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_DESTINO">Destino do Peixe de Consumo:</label>
														<select name="FISH_COOCAR_DESTINO" id="FISH_COOCAR_DESTINO" class="form-control">
															<?php while ($vetor_CARAC_DESTINOPESCA = mysql_fetch_array($sql_CARAC_DESTINOPESCA)) { ?>
															<option value="<?php echo $vetor_CARAC_DESTINOPESCA['ID']; ?>" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_DESTINO'], $vetor_CARAC_DESTINOPESCA['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_CARAC_DESTINOPESCA['DESCRICAO']; ?></option>
															<?php } ?>
														</select>
													</div>
												</div> <!-- Tipo da Pesca -->
												<div class="form-group row">
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOCAR_DIAS">Duração média da pescaria:</label>
														<input type="text" name="FISH_COOCAR_DIAS" class="form-control" id="FISH_COOCAR_DIAS" placeholder="Duração média da pescaria..." value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_DIAS']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOCAR_VEZES">Média da pescarias/mês:</label>
														<input type="text" name="FISH_COOCAR_VEZES" class="form-control" id="FISH_COOCAR_VEZES" placeholder="Média da pescarias/mês..." value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_VEZES']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOCAR_KG_FORADEFESO">Média de KG/Pesca <strong>FORA DO DEFESO</strong>:</label>
														<input type="text" name="FISH_COOCAR_KG_FORADEFESO" class="form-control" id="FISH_COOCAR_KG_FORADEFESO" placeholder="Média de KG/Pesca FORA DO DEFESO..." value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_KG_FORADEFESO']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOCAR_KG_DENTRODEFESO">Média de KG/Pesca <strong>NO DEFESO</strong>:</label>
														<input type="text" name="FISH_COOCAR_KG_DENTRODEFESO" class="form-control" id="FISH_COOCAR_KG_DENTRODEFESO" placeholder="Média de KG/Pesca NO DEFESO..." value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_KG_DENTRODEFESO']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
												</div> <!-- Intervalor + Periodicidade + Produção (KG) -->
												<div class="form-group row" id="scroll_especies">
													<table width="100%">
														<thead>
															<td width="58%">Espécie</td>
															<td width="2%">&nbsp;</td>
															<td width="28%">Valor (R$/KG)</td>
															<td width="2%">&nbsp;</td>
															<td width="10%">&nbsp;</td>
														</thead>
													</table>
													<div id="campoPai_COOP_CARACT_ESPECIES"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
													</br>
													<input type="button" value="Nova Espécie" onClick="addCampos_COOP_CARACT_ESPECIES()" class="btn btn-inline">
													</br></br>
													<table width="100%">
														<?php
															$id_COOP_CARACT_ESPECIES = $vetor_CARACTERISTICAS['FISH_COOCAR_ID'];
															$sql_COOP_CARACT_ESPECIES = mysql_query("SELECT TAB_FISH_COOCAR_ESPECIES.FISH_CPCESP_ID, TAB_APOIO_PESCA_ESPECIES.DESCRICAO AS FISH_CPCESP_ESPECIE_DESC, TAB_FISH_COOCAR_ESPECIES.FISH_CPCESP_VALOR FROM TAB_FISH_COOCAR_ESPECIES LEFT OUTER JOIN TAB_APOIO_PESCA_ESPECIES ON TAB_FISH_COOCAR_ESPECIES.FISH_CPCESP_ESPECIE = TAB_APOIO_PESCA_ESPECIES.ID WHERE TAB_FISH_COOCAR_ESPECIES.FISH_COOCAR_ID = '$id_COOP_CARACT_ESPECIES' ORDER BY FISH_CPCESP_ESPECIE_DESC ASC;", $db) or die( mysql_error());
															$cor = "#D8D8D8";
															while ($vetor_COOP_CARACT_ESPECIES = mysql_fetch_array($sql_COOP_CARACT_ESPECIES)) {
																if (strcasecmp($cor, "#FFFFFF") == 0){
																	$cor = "#D8D8D8";
																} else {
																	$cor = "#FFFFFF";
																}
														?>
														<tr bgcolor="<?php echo $cor; ?>">
															<td width="58%"><?php echo $vetor_COOP_CARACT_ESPECIES['FISH_CPCESP_ESPECIE_DESC']; ?></td>
															<td width="2%">&nbsp;</td>
															<td width="28%" align="center"><?php echo 'R$ '.number_format($vetor_COOP_CARACT_ESPECIES['FISH_CPCESP_VALOR'],2,',','.'); ?></td>
															<td width="2%">&nbsp;</td>
															<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_caracterizacao_especies.php?FISH_CPCESP_ID=<?php echo $vetor_COOP_CARACT_ESPECIES['FISH_CPCESP_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
														</tr>
														<?php } ?>
													</table><hr>
												</div> <!-- Espécies -->
												<div class="form-group row" id="scroll_locais">
													<table width="100%">
														<thead>
															<td width="88%">Principais Locais de Pesca</td>
															<td width="2%">&nbsp;</td>
															<td width="10%">&nbsp;</td>
														</thead>
													</table>
													<div id="campoPai_COOP_CARACT_LOCAIS"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
													</br>
													<input type="button" value="Novo Local" onClick="addCampos_COOP_CARACT_LOCAIS()" class="btn btn-inline">
													</br></br>
													<table width="100%">
														<?php
															$id_COOP_CARACT_LOCAIS = $vetor_CARACTERISTICAS['FISH_COOCAR_ID'];
															$sql_COOP_CARACT_LOCAIS = mysql_query("SELECT TAB_FISH_COOCAR_LOCAIS.FISH_CPCLOC_ID, TAB_APOIO_PESCA_LOCAIS.DESCRICAO AS FISH_CPC_LOC_LOCAL_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FISH_CPC_LOC_MUNICIPIO_DESC FROM TAB_FISH_COOCAR_LOCAIS LEFT OUTER JOIN TAB_APOIO_PESCA_LOCAIS ON TAB_FISH_COOCAR_LOCAIS.FISH_CPCLOC_LOCAL = TAB_APOIO_PESCA_LOCAIS.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_APOIO_PESCA_LOCAIS.MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID WHERE TAB_FISH_COOCAR_LOCAIS.FISH_COOCAR_ID = '$id_COOP_CARACT_LOCAIS' ORDER BY FISH_CPC_LOC_LOCAL_DESC ASC, FISH_CPC_LOC_MUNICIPIO_DESC ASC;", $db) or die( mysql_error());
															$cor = "#D8D8D8";
															while ($vetor_COOP_CARACT_LOCAIS = mysql_fetch_array($sql_COOP_CARACT_LOCAIS)) {
																if (strcasecmp($cor, "#FFFFFF") == 0){
																	$cor = "#D8D8D8";
																} else {
																	$cor = "#FFFFFF";
																}
														?>
														<tr bgcolor="<?php echo $cor; ?>">
															<td width="88%"><?php echo $vetor_COOP_CARACT_LOCAIS['FISH_CPC_LOC_LOCAL_DESC'].'/'.$vetor_COOP_CARACT_LOCAIS['FISH_CPC_LOC_MUNICIPIO_DESC']; ?></td>
															<td width="2%">&nbsp;</td>
															<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_caracterizacao_locais.php?FISH_CPCLOC_ID=<?php echo $vetor_COOP_CARACT_LOCAIS['FISH_CPCLOC_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
														</tr>
														<?php } ?>
													</table><hr>
												</div> <!-- Locais de Pesca -->
												<div class="form-group row" id="scroll_comercio">
													<table width="100%">
														<thead>
															<td width="88%">Principais Locais de Comercialização</td>
															<td width="2%">&nbsp;</td>
															<td width="10%">&nbsp;</td>
														</thead>
													</table>
													<div id="campoPai_COOP_CARACT_COMERCIO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
													</br>
													<input type="button" value="Novo" onClick="addCampos_COOP_CARACT_COMERCIO()" class="btn btn-inline">
													</br></br>
													<table width="100%">
														<?php
															$id_COOP_CARACT_COMERCIO = $vetor_CARACTERISTICAS['FISH_COOCAR_ID'];
															$sql_COOP_CARACT_COMERCIO = mysql_query("SELECT TAB_FISH_COOCAR_COMERCIO.FISH_CPCCOM_ID, TAB_APOIO_PESCA_COMERCIO.DESCRICAO AS FISH_CPCCOM_COMERCIO_DESC FROM TAB_FISH_COOCAR_COMERCIO INNER JOIN TAB_APOIO_PESCA_COMERCIO ON TAB_FISH_COOCAR_COMERCIO.FISH_CPCCOM_COMERCIO = TAB_APOIO_PESCA_COMERCIO.ID WHERE TAB_FISH_COOCAR_COMERCIO.FISH_COOCAR_ID = '$id_COOP_CARACT_COMERCIO' ORDER BY FISH_CPCCOM_COMERCIO_DESC ASC;", $db) or die( mysql_error());
															$cor = "#D8D8D8";
															while ($vetor_COOP_CARACT_COMERCIO = mysql_fetch_array($sql_COOP_CARACT_COMERCIO)) {
																if (strcasecmp($cor, "#FFFFFF") == 0){
																	$cor = "#D8D8D8";
																} else {
																	$cor = "#FFFFFF";
																}
														?>
														<tr bgcolor="<?php echo $cor; ?>">
															<td width="88%"><?php echo $vetor_COOP_CARACT_COMERCIO['FISH_CPCCOM_COMERCIO_DESC']; ?></td>
															<td width="2%">&nbsp;</td>
															<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_caracterizacao_comercio.php?FISH_CPCCOM_ID=<?php echo $vetor_COOP_CARACT_COMERCIO['FISH_CPCCOM_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
														</tr>
														<?php } ?>
													</table><hr>
												</div> <!-- Comercialização -->
												<div class="form-group row">
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOCAR_DESP_COMBS">Despesas/Combustível(R$):</label>
														<input type="text" name="FISH_COOCAR_DESP_COMBS" class="form-control" id="FISH_COOCAR_DESP_COMBS" placeholder="Despesas com Combustível (R$)..." value="<?php echo number_format($vetor_CARACTERISTICAS['FISH_COOCAR_DESP_COMBS'],2,',','.'); ?>" onKeyPress="mascara(this,mvalor)" >
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOCAR_DESP_GELO">Despesas/Gelo(R$):</label>
														<input type="text" name="FISH_COOCAR_DESP_GELO" class="form-control" id="FISH_COOCAR_DESP_GELO" placeholder="Despesas com Gelo (R$)..." value="<?php echo number_format($vetor_CARACTERISTICAS['FISH_COOCAR_DESP_GELO'],2,',','.'); ?>" onKeyPress="mascara(this,mvalor)" >
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOCAR_DESP_RANCHO">Despesas/Rancho(R$):</label>
														<input type="text" name="FISH_COOCAR_DESP_RANCHO" class="form-control" id="FISH_COOCAR_DESP_RANCHO" placeholder="Despesas com Rancho (R$)..." value="<?php echo number_format($vetor_CARACTERISTICAS['FISH_COOCAR_DESP_RANCHO'],2,',','.'); ?>" onKeyPress="mascara(this,mvalor)" >
													</div>
													<div class="col-lg-3">
														<label class="form-label semibold" for="FISH_COOCAR_DESP_OUTROS">Despesas/Outros(R$):</label>
														<input type="text" name="FISH_COOCAR_DESP_OUTROS" class="form-control" id="FISH_COOCAR_DESP_OUTROS" placeholder="Despesas com Outros (R$)..." value="<?php echo number_format($vetor_CARACTERISTICAS['FISH_COOCAR_DESP_OUTROS'],2,',','.'); ?>" onKeyPress="mascara(this,mvalor)" >
													</div>
												</div> <!-- Despesas -->
												<hr><h2>Locomoção/Transporte para Pescarias</h2>
												<div class="form-group row">
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_CANOA_PROP">Pesca com Canoa Própria?</label>
														<select name="FISH_COOCAR_CANOA_PROP" id="FISH_COOCAR_CANOA_PROP" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_CANOA_PROP'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_CANOA_PROP'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_CANOA_PROP'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_CANOA_PROP_QTS">Se sim, quantas?</label>
														<input type="text" name="FISH_COOCAR_CANOA_PROP_QTS" class="form-control" id="FISH_COOCAR_CANOA_PROP_QTS" placeholder="Quantas canoas próprias..." value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_CANOA_PROP_QTS']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
												</div> <!-- Canoa Própria -->
												<div class="form-group row">
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_BARCO_PROP">Pesca com Barco Próprio?</label>
														<select name="FISH_COOCAR_BARCO_PROP" id="FISH_COOCAR_BARCO_PROP" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_BARCO_PROP'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_BARCO_PROP'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_BARCO_PROP'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_BARCO_PROP_QTS">Se sim, quantos?</label>
														<input type="text" name="FISH_COOCAR_BARCO_PROP_QTS" class="form-control" id="FISH_COOCAR_BARCO_PROP_QTS" placeholder="Quantos barcos próprios..." value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_BARCO_PROP_QTS']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
												</div> <!-- Barco Próprio -->
												<div class="form-group row">
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_CANOA_PROP">Pesca com Barco Alugado?</label>
														<select name="FISH_COOCAR_BARCO_ALUG" id="FISH_COOCAR_BARCO_ALUG" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_BARCO_ALUG'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_BARCO_ALUG'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_BARCO_ALUG'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_BARCO_ALUG_QTS">Se sim, quantos?</label>
														<input type="text" name="FISH_COOCAR_BARCO_ALUG_QTS" class="form-control" id="FISH_COOCAR_BARCO_ALUG_QTS" placeholder="Quantos barcos alugados..." value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_BARCO_ALUG_QTS']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
												</div> <!-- Barco Alugado -->
												<div class="form-group row" id="scroll_embarcacoes">
													<table width="100%">
														<thead>
															<td width="19%">Tipo</td>
															<td width="1%">&nbsp;</td>
															<td width="14%">Própria</td>
															<td width="1%">&nbsp;</td>
															<td width="19%">Material</td>
															<td width="1%">&nbsp;</td>
															<td width="14%">Tamanho</td>
															<td width="1%">&nbsp;</td>
															<td width="19%">Conservação</td>
															<td width="1%">&nbsp;</td>
															<td width="10%">&nbsp;</td>
														</thead>
													</table>
													<div id="campoPai_COOP_CARACT_EMBARC"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
													</br>
													<input type="button" value="Nova Embarcação" onClick="addCampos_COOP_CARACT_EMBARC()" class="btn btn-inline">
													</br></br>
													<table width="100%">
														<?php
															$id_COOP_CARACT_EMBARC = $vetor_CARACTERISTICAS['FISH_COOCAR_ID'];
															$sql_COOP_CARACT_EMBARC = mysql_query("SELECT TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_ID, TAB_APOIO_EMBARC_TIPO.DESCRICAO AS FISH_CPCEMB_TIPO_DESC, TAB_APOIO_BOOLEANO.DESCRICAO AS FISH_CPCEMB_PROPRIA_DESC, TAB_APOIO_EMBARC_MATERIAL.DESCRICAO AS FISH_CPCEMB_MATERIAL_DESC, TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_TAMANHO, TAB_APOIO_ESTADOCONSERV.DESCRICAO AS FISH_CPCEMB_CONSERV_DESC FROM TAB_FISH_COOCAR_EMBARC LEFT OUTER JOIN TAB_APOIO_EMBARC_TIPO ON TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_TIPO = TAB_APOIO_EMBARC_TIPO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_PROPRIA = TAB_APOIO_BOOLEANO.ID LEFT OUTER JOIN TAB_APOIO_EMBARC_MATERIAL ON TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_MATERIAL = TAB_APOIO_EMBARC_MATERIAL.ID LEFT OUTER JOIN TAB_APOIO_ESTADOCONSERV ON TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_CONSERV = TAB_APOIO_ESTADOCONSERV.ID WHERE TAB_FISH_COOCAR_EMBARC.FISH_COOCAR_ID = '$id_COOP_CARACT_EMBARC' ORDER BY FISH_CPCEMB_PROPRIA_DESC DESC, FISH_CPCEMB_TIPO_DESC ASC, FISH_CPCEMB_MATERIAL_DESC ASC, TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_TAMANHO DESC;", $db) or die( mysql_error());
															$cor = "#D8D8D8";
															while ($vetor_COOP_CARACT_EMBARC = mysql_fetch_array($sql_COOP_CARACT_EMBARC)) {
																if (strcasecmp($cor, "#FFFFFF") == 0){
																	$cor = "#D8D8D8";
																} else {
																	$cor = "#FFFFFF";
																}
														?>
														<tr bgcolor="<?php echo $cor; ?>">
															<td width="19%"><?php echo $vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_TIPO_DESC']; ?></td><td width="1%">&nbsp;</td>
															<td width="14%"><?php echo $vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_PROPRIA_DESC']; ?></td><td width="1%">&nbsp;</td>
															<td width="19%"><?php echo $vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_MATERIAL_DESC']; ?></td><td width="1%">&nbsp;</td>
															<td width="14%"><?php echo number_format($vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_TAMANHO'],2,',','.'); ?></td><td width="1%">&nbsp;</td>
															<td width="19%"><?php echo $vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_CONSERV_DESC']; ?></td><td width="1%">&nbsp;</td>
															<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_caracterizacao_embarc.php?FISH_CPCEMB_ID=<?php echo $vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
														</tr>
														<?php } ?>
													</table><hr>
												</div> <!-- Embarcações -->
												<div class="form-group row">
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_MOTOR_PROP">Pesca com Motor Próprio?</label>
														<select name="FISH_COOCAR_MOTOR_PROP" id="FISH_COOCAR_MOTOR_PROP" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_MOTOR_PROP'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_MOTOR_PROP'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_MOTOR_PROP'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_MOTOR_PROP_QTS">Se sim, quantos?</label>
														<input type="text" name="FISH_COOCAR_MOTOR_PROP_QTS" class="form-control" id="FISH_COOCAR_MOTOR_PROP_QTS" placeholder="Quantos motores próprios..." value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_MOTOR_PROP_QTS']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
												</div> <!-- Motor Próprio -->
												<div class="form-group row">
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_MOTOR_ALUG">Pesca com Motor Emprestado?</label>
														<select name="FISH_COOCAR_MOTOR_ALUG" id="FISH_COOCAR_MOTOR_ALUG" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_MOTOR_ALUG'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_MOTOR_ALUG'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_CARACTERISTICAS['FISH_COOCAR_MOTOR_ALUG'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOCAR_MOTOR_ALUG_QTS">Se sim, quantos?</label>
														<input type="text" name="FISH_COOCAR_MOTOR_ALUG_QTS" class="form-control" id="FISH_COOCAR_MOTOR_ALUG_QTS" placeholder="Quantas canoas próprias..." value="<?php echo $vetor_CARACTERISTICAS['FISH_COOCAR_MOTOR_ALUG_QTS']; ?>" onKeyPress="mascara(this,minteiro)" >
													</div>
												</div> <!-- Motor Emprestado -->
												<div class="form-group row" id="scroll_motores">
													<table width="100%">
														<thead>
															<td width="19%">Tipo</td>
															<td width="1%">&nbsp;</td>
															<td width="14%">Próprio</td>
															<td width="1%">&nbsp;</td>
															<td width="19%">&nbsp;</td>
															<td width="1%">&nbsp;</td>
															<td width="14%">Potência (HP)</td>
															<td width="1%">&nbsp;</td>
															<td width="19%">Conservação</td>
															<td width="1%">&nbsp;</td>
															<td width="10%">&nbsp;</td>
														</thead>
													</table>
													<div id="campoPai_COOP_CARACT_MOTOR"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
													</br>
													<input type="button" value="Novo Motor" onClick="addCampos_COOP_CARACT_MOTOR()" class="btn btn-inline">
													</br></br>
													<table width="100%">
														<?php
															$id_COOP_CARACT_MOTOR = $vetor_CARACTERISTICAS['FISH_COOCAR_ID'];
															$sql_COOP_CARACT_MOTOR = mysql_query("SELECT TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_ID, TAB_APOIO_EMBARC_MOTOR.DESCRICAO AS FISH_CPCMTR_TIPO_DESC, TAB_APOIO_BOOLEANO.DESCRICAO AS FISH_CPCMTR_PROPRIO_DESC, TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_POTENCIA, TAB_APOIO_ESTADOCONSERV.DESCRICAO AS FISH_CPCMTR_CONSERV_DESC FROM TAB_FISH_COOCAR_MOTORES LEFT OUTER JOIN TAB_APOIO_EMBARC_MOTOR ON TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_TIPO = TAB_APOIO_EMBARC_MOTOR.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_PROPRIO = TAB_APOIO_BOOLEANO.ID LEFT OUTER JOIN TAB_APOIO_ESTADOCONSERV ON TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_CONSERV = TAB_APOIO_ESTADOCONSERV.ID WHERE TAB_FISH_COOCAR_MOTORES.FISH_COOCAR_ID = '$id_COOP_CARACT_MOTOR' ORDER BY FISH_CPCMTR_PROPRIO_DESC DESC, FISH_CPCMTR_TIPO_DESC ASC, TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_POTENCIA DESC;", $db) or die( mysql_error());
															$cor = "#D8D8D8";
															while ($vetor_COOP_CARACT_MOTOR = mysql_fetch_array($sql_COOP_CARACT_MOTOR)) {
																if (strcasecmp($cor, "#FFFFFF") == 0){
																	$cor = "#D8D8D8";
																} else {
																	$cor = "#FFFFFF";
																}
														?>
														<tr bgcolor="<?php echo $cor; ?>">
															<td width="19%"><?php echo $vetor_COOP_CARACT_MOTOR['FISH_CPCMTR_TIPO_DESC']; ?></td><td width="1%">&nbsp;</td>
															<td width="14%"><?php echo $vetor_COOP_CARACT_MOTORC['FISH_CPCMTR_PROPRIO_DESC']; ?></td><td width="1%">&nbsp;</td>
															<td width="19%">&nbsp;</td>
															<td width="1%">&nbsp;</td>
															<td width="14%"><?php echo number_format($vetor_COOP_CARACT_MOTOR['FISH_CPCMTR_POTENCIA'],2,',','.'); ?></td><td width="1%">&nbsp;</td>
															<td width="19%"><?php echo $vetor_COOP_CARACT_MOTOR['FISH_CPCMTR_CONSERV_DESC']; ?></td><td width="1%">&nbsp;</td>
															<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_caracterizacao_motor.php?FISH_CPCMTR_ID=<?php echo $vetor_COOP_CARACT_MOTOR['FISH_CPCMTR_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
														</tr>
														<?php } ?>
													</table><hr>
												</div> <!-- Motores -->
												<div class="form-group row" id="scroll_tralhas">
													<table width="100%">
														<thead>
															<td width="19%">Tipo</td>
															<td width="1%">&nbsp;</td>
															<td width="54%">Descrição</td>
															<td width="1%">&nbsp;</td>
															<td width="19%">Qtde.</td>
															<td width="1%">&nbsp;</td>
															<td width="10%">&nbsp;</td>
														</thead>
													</table>
													<div id="campoPai_COOP_CARACT_TRALHAS"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
													</br>
													<input type="button" value="Novo Equipamento" onClick="addCampos_COOP_CARACT_TRALHAS()" class="btn btn-inline">
													</br></br>
													<table width="100%">
														<?php
															$id_COOP_CARACT_TRALHAS = $vetor_CARACTERISTICAS['FISH_COOCAR_ID'];
															$sql_COOP_CARACT_TRALHAS = mysql_query("SELECT TAB_FISH_COOCAR_TRALHAS.FISH_CPCTRA_ID, TAB_APOIO_PESCA_EQUIP.DESCRICAO AS FISH_CPCTRA_TRALHA_DESC, TAB_FISH_COOCAR_TRALHAS.FISH_CPCTRA_DESCRICAO, TAB_FISH_COOCAR_TRALHAS.FISH_CPCTRA_QTDE FROM TAB_FISH_COOCAR_TRALHAS LEFT OUTER JOIN TAB_APOIO_PESCA_EQUIP ON TAB_FISH_COOCAR_TRALHAS.FISH_CPCTRA_TRALHA = TAB_APOIO_PESCA_EQUIP.ID WHERE TAB_FISH_COOCAR_TRALHAS.FISH_COOCAR_ID = '$id_COOP_CARACT_TRALHAS' ORDER BY FISH_CPCTRA_TRALHA_DESC ASC, TAB_FISH_COOCAR_TRALHAS.FISH_CPCTRA_QTDE ASC", $db) or die( mysql_error());
															$cor = "#D8D8D8";
															while ($vetor_COOP_CARACT_TRALHAS = mysql_fetch_array($sql_COOP_CARACT_TRALHAS)) {
																if (strcasecmp($cor, "#FFFFFF") == 0){
																	$cor = "#D8D8D8";
																} else {
																	$cor = "#FFFFFF";
																}
														?>
														<tr bgcolor="<?php echo $cor; ?>">
															<td width="19%"><?php echo $vetor_COOP_CARACT_TRALHAS['FISH_CPCTRA_TRALHA_DESC']; ?></td>
															<td width="1%">&nbsp;</td>
															<td width="54%"><?php echo $vetor_COOP_CARACT_TRALHAS['FISH_CPCTRA_DESCRICAO']; ?></td>
															<td width="1%">&nbsp;</td>
															<td width="14%"><?php echo $vetor_COOP_CARACT_TRALHAS['FISH_CPCTRA_QTDE']; ?></td><td width="1%">&nbsp;</td>
															<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_caracterizacao_tralhas.php?FISH_CPCTRA_ID=<?php echo $vetor_COOP_CARACT_TRALHAS['FISH_CPCTRA_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
														</tr>
														<?php } ?>
													</table><hr>
												</div> <!-- Tralhas -->
												<input name="pesq" type="image" src="imgs/salvar.png" class="float" />
											</form>
										</div>
										<div id="view7.3">
											<form action="recebe_fish_alterar_expectativas.php?id_familia=<?php echo $id_familia; ?>&FISH_COOEXP_ID=<?php echo $vetor_EXPECTATIVAS['FISH_COOEXP_ID'];?>" method="post" name="recebe_fish_alterar_expectativas" enctype="multipart/form-data" id="recebe_fish_alterar_expectativas">
												<h2>Expectativas Relacionadas À Cooperativa</h2><hr>
												<div class="form-group row">
													<div class="col-lg-4">
														<label class="form-label semibold" for="FISH_COOEXP_PART">Participa de alguma Instituição? </label>
														<select name="FISH_COOEXP_PART" id="FISH_COOEXP_PART" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_EXPECTATIVAS['FISH_COOEXP_PART'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_EXPECTATIVAS['FISH_COOEXP_PART'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_EXPECTATIVAS['FISH_COOEXP_PART'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select>
													</div>
													<div class="col-lg-8">
														<label class="form-label semibold" for="FISH_COOEXP_PART_QUAL">Se sim, qual?:</label>
														<input type="text" name="FISH_COOEXP_PART_QUAL" class="form-control" id="FISH_COOEXP_PART_QUAL" placeholder="Nome da cooperativa, associação, sindicato ou colônia..." value="<?php echo $vetor_EXPECTATIVAS['FISH_COOEXP_PART_QUAL']; ?>">
													</div>
												</div> <!-- Participa e de qual Instituição? -->
												<hr><h2>Dificuldades para desenvolver as Atividades Econômica</h2>
												<div class="form-group row">
													<div class="col-lg-12">
														<textarea rows="4" name="FISH_COOEXP_DIFICULDADES" id="FISH_COOEXP_DIFICULDADES" class="form-control" placeholder="Descrever as dificuldades para desenvolver a atividade econômica..."><?php echo $vetor_EXPECTATIVAS['FISH_COOEXP_DIFICULDADES']; ?></textarea><br/>
													</div>
													<div id="scroll_dificuldades">
														<table width="100%">
															<thead>
																<td width="88%">Dificuldades para desenvolver as Atividades Econômica</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">&nbsp;</td>
															</thead>
														</table>
														<div id="campoPai_COOP_DIFICULDADESPRODUCAO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
														</br>
														<input type="button" value="Novo" onClick="addCampos_COOP_DIFICULDADESPRODUCAO()" class="btn btn-inline">
														</br></br>
														<table width="100%">
															<thead>
																<td width="88%">Dificuldades para desenvolver as Atividades Econômica</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">Ações</td>
															</thead>
															<?php
																$id_COOP_DIFICULDADES = $vetor_EXPECTATIVAS['FISH_COOEXP_ID'];
																$sql_COOP_DIFICULDADES = mysql_query("SELECT TAB_FISH_COOEXP_DIFICULDADES.FISH_CPXDIF_ID, TAB_APOIO_DIFICULDADESPRODUCAO.DESCRICAO AS FISH_CPXDIF_DIFICULDADE_DESC FROM TAB_FISH_COOEXP_DIFICULDADES LEFT OUTER JOIN TAB_APOIO_DIFICULDADESPRODUCAO ON TAB_FISH_COOEXP_DIFICULDADES.FISH_CPXDIF_DIFICULDADE = TAB_APOIO_DIFICULDADESPRODUCAO.ID WHERE TAB_FISH_COOEXP_DIFICULDADES.FISH_COOEXP_ID = '$id_COOP_DIFICULDADES' ORDER BY FISH_CPXDIF_DIFICULDADE_DESC ASC;", $db) or die( mysql_error());
																$cor = "#D8D8D8";
																while ($vetor_COOP_DIFICULDADES = mysql_fetch_array($sql_COOP_DIFICULDADES)) {
																	if (strcasecmp($cor, "#FFFFFF") == 0){
																		$cor = "#D8D8D8";
																	} else {
																		$cor = "#FFFFFF";
																	}
															?>
															<tr bgcolor="<?php echo $cor; ?>">
																<td width="88%"><?php echo $vetor_COOP_DIFICULDADES['FISH_CPXDIF_DIFICULDADE_DESC']; ?></td>
																<td width="2%">&nbsp;</td>
																<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_expectativas_dificuldades.php?FISH_CPXDIF_ID=<?php echo $vetor_COOP_DIFICULDADES['FISH_CPXDIF_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
															</tr>
															<?php } ?>
														</table>
													</div>                                
												</div> <!-- Dificuldades -->
												<hr><h2>Contribuições da Cooperativa para as Atividades Econômicas</h2>
												<div class="form-group row">
													<div class="col-lg-12">
														<textarea rows="4" name="FISH_COOEXP_CONTRIBUICAO" id="FISH_COOEXP_CONTRIBUICAO" class="form-control" placeholder="Descrever as contribuições da Cooperativa as atividade econômicas..."><?php echo $vetor_EXPECTATIVAS['FISH_COOEXP_CONTRIBUICAO']; ?></textarea><br/>
													</div>
													<div id="scroll_constribuicoes">
														<table width="100%">
															<thead>
																<td width="88%">Contribuições da Cooperativa para as Atividades Econômicas</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">&nbsp;</td>
															</thead>
														</table>
														<div id="campoPai_COOP_CONTRIBUICOESCOOP"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
														</br>
														<input type="button" value="Novo" onClick="addCampos_COOP_CONTRIBUICOESCOOP()" class="btn btn-inline">
														</br></br>
														<table width="100%">
															<thead>
																<td width="88%">Contribuições da Cooperativa para as Atividades Econômicas</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">Ações</td>
															</thead>
															<?php
																$id_COOP_CONTRIBUICOESCOOP = $vetor_EXPECTATIVAS['FISH_COOEXP_ID'];
																$sql_COOP_CONTRIBUICOESCOOP = mysql_query("SELECT TAB_FISH_COOEXP_CONTRIBUICOES.FISH_CPXCON_ID, TAB_APOIO_CONTRIBUICOESCOOP.DESCRICAO AS FISH_CPXCON_CONTRIBUICAO_DESC FROM TAB_FISH_COOEXP_CONTRIBUICOES LEFT OUTER JOIN TAB_APOIO_CONTRIBUICOESCOOP ON TAB_FISH_COOEXP_CONTRIBUICOES.FISH_CPXCON_CONTRIBUICAO = TAB_APOIO_CONTRIBUICOESCOOP.ID WHERE TAB_FISH_COOEXP_CONTRIBUICOES.FISH_COOEXP_ID = '$id_COOP_CONTRIBUICOESCOOP' ORDER BY FISH_CPXCON_CONTRIBUICAO_DESC ASC;", $db) or die( mysql_error());
																$cor = "#D8D8D8";
																while ($vetor_COOP_CONTRIBUICOESCOOP = mysql_fetch_array($sql_COOP_CONTRIBUICOESCOOP)) {
																	if (strcasecmp($cor, "#FFFFFF") == 0){
																		$cor = "#D8D8D8";
																	} else {
																		$cor = "#FFFFFF";
																	}
															?>
															<tr bgcolor="<?php echo $cor; ?>">
																<td width="88%"><?php echo $vetor_COOP_CONTRIBUICOESCOOP['FISH_CPXCON_CONTRIBUICAO_DESC']; ?></td>
																<td width="2%">&nbsp;</td>
																<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_expectativas_contribuicoescoop.php?FISH_CPXCON_ID=<?php echo $vetor_COOP_CONTRIBUICOESCOOP['FISH_CPXCON_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
															</tr>
															<?php } ?>
														</table>
													</div>                                
												</div> <!-- Dificuldades -->
												<hr><h2>Filiação à Cooperativa</h2>
												<div class="form-group row">
													<div class="col-lg-12">
														<label class="form-label semibold" for="FISH_COOEXP_PART">Pretende se filiar a Cooperativa de Pescadores de Belo Monte? </label>
														<select name="FISH_COOEXP_FILIACAO" id="FISH_COOEXP_FILIACAO" class="form-control">
															<option label="NI" value="0" <?php if (strcasecmp($vetor_EXPECTATIVAS['FISH_COOEXP_FILIACAO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
															<option label="SIM" value="1" <?php if (strcasecmp($vetor_EXPECTATIVAS['FISH_COOEXP_FILIACAO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
															<option label="NAO" value="2" <?php if (strcasecmp($vetor_EXPECTATIVAS['FISH_COOEXP_FILIACAO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
														</select><br/>
													</div>
													<div class="col-lg-12">
														<label class="form-label semibold" for="FISH_COOEXP_FILI_SIM">Se sim, como vê sua participação?</label>
														<textarea rows="4" name="FISH_COOEXP_FILI_SIM" id="FISH_COOEXP_FILI_SIM" class="form-control" placeholder="Descrever as perspectivas como filiado/cooperado..."><?php echo $vetor_EXPECTATIVAS['FISH_COOEXP_FILI_SIM']; ?></textarea><br/>
													</div>
													<div id="scroll_participacaocoop">
														<table width="100%">
															<thead>
																<td width="88%">Perspectivas como Cooperado</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">&nbsp;</td>
															</thead>
														</table>
														<div id="campoPai_COOP_PARTICIPACAOCOOP"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
														</br>
														<input type="button" value="Novo" onClick="addCampos_COOP_PARTICIPACAOCOOP()" class="btn btn-inline">
														</br></br>
														<table width="100%">
															<thead>
																<td width="88%">Perspectivas como Cooperado</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">Ações</td>
															</thead>
															<?php
																$id_COOP_PARTICIPACAOCOOP = $vetor_EXPECTATIVAS['FISH_COOEXP_ID'];
																$sql_COOP_PARTICIPACAOCOOP = mysql_query("SELECT TAB_FISH_COOEXP_PARTICIPACAO.FISH_CPXPAR_ID, TAB_APOIO_PARTICIPACAOCOOP.DESCRICAO AS FISH_CPXPAR_PARTICIPACAO_DESC FROM TAB_FISH_COOEXP_PARTICIPACAO LEFT OUTER JOIN TAB_APOIO_PARTICIPACAOCOOP ON TAB_FISH_COOEXP_PARTICIPACAO.FISH_CPXPAR_PARTICIPACAO = TAB_APOIO_PARTICIPACAOCOOP.ID WHERE TAB_FISH_COOEXP_PARTICIPACAO.FISH_COOEXP_ID = '$id_COOP_PARTICIPACAOCOOP' ORDER BY FISH_CPXPAR_PARTICIPACAO_DESC ASC;", $db) or die( mysql_error());
																$cor = "#D8D8D8";
																while ($vetor_COOP_PARTICIPACAOCOOP = mysql_fetch_array($sql_COOP_PARTICIPACAOCOOP)) {
																	if (strcasecmp($cor, "#FFFFFF") == 0){
																		$cor = "#D8D8D8";
																	} else {
																		$cor = "#FFFFFF";
																	}
															?>
															<tr bgcolor="<?php echo $cor; ?>">
																<td width="88%"><?php echo $vetor_COOP_PARTICIPACAOCOOP['FISH_CPXPAR_PARTICIPACAO_DESC']; ?></td>
																<td width="2%">&nbsp;</td>
																<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_expectativas_participacaocoop.php?FISH_CPXPAR_ID=<?php echo $vetor_COOP_PARTICIPACAOCOOP['FISH_CPXPAR_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
															</tr>
															<?php } ?>
														</table><br/>
													</div>
													<div class="col-lg-12">
														<label class="form-label semibold" for="FISH_COOEXP_FILI_NAO">Se não, justifique...</label>
														<textarea rows="4" name="FISH_COOEXP_FILI_NAO" id="FISH_COOEXP_FILI_NAO" class="form-control" placeholder="Descrever as justificativas..."><?php echo $vetor_EXPECTATIVAS['FISH_COOEXP_FILI_NAO']; ?></textarea><br/>
													</div>
													<div id="scroll_motivonaofiliacao">
														<table width="100%">
															<thead>
																<td width="88%">Motivos para não participação como Cooperado</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">&nbsp;</td>
															</thead>
														</table>
														<div id="campoPai_COOP_MOTIVONAOFILIACAO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
														</br>
														<input type="button" value="Novo" onClick="addCampos_COOP_MOTIVONAOFILIACAO()" class="btn btn-inline">
														</br></br>
														<table width="100%">
															<thead>
																<td width="88%">Motivos para não participação como Cooperado</td>
																<td width="2%">&nbsp;</td>
																<td width="10%">Ações</td>
															</thead>
															<?php
																$id_COOP_MOTIVONAOFILIACAO = $vetor_EXPECTATIVAS['FISH_COOEXP_ID'];
																$sql_COOP_MOTIVONAOFILIACAO = mysql_query("SELECT TAB_FISH_COOEXP_NAOFILIACAO.FISH_CPXNAO_ID, TAB_APOIO_MOTIVONAOFILIACAO.DESCRICAO AS FISH_CPXNAO_MOTIVO_DESC FROM TAB_FISH_COOEXP_NAOFILIACAO LEFT OUTER JOIN TAB_APOIO_MOTIVONAOFILIACAO ON TAB_FISH_COOEXP_NAOFILIACAO.FISH_CPXNAO_MOTIVO = TAB_APOIO_MOTIVONAOFILIACAO.ID WHERE TAB_FISH_COOEXP_NAOFILIACAO.FISH_COOEXP_ID = '$id_COOP_MOTIVONAOFILIACAO' ORDER BY FISH_CPXNAO_MOTIVO_DESC ASC;", $db) or die( mysql_error());
																$cor = "#D8D8D8";
																while ($vetor_COOP_MOTIVONAOFILIACAO = mysql_fetch_array($sql_COOP_MOTIVONAOFILIACAO)) {
																	if (strcasecmp($cor, "#FFFFFF") == 0){
																		$cor = "#D8D8D8";
																	} else {
																		$cor = "#FFFFFF";
																	}
															?>
															<tr bgcolor="<?php echo $cor; ?>">
																<td width="88%"><?php echo $vetor_COOP_MOTIVONAOFILIACAO['FISH_CPXNAO_MOTIVO_DESC']; ?></td>
																<td width="2%">&nbsp;</td>
																<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_expectativas_motivonaofiliacao.php?FISH_CPXNAO_ID=<?php echo $vetor_COOP_MOTIVONAOFILIACAO['FISH_CPXNAO_ID']; ?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
															</tr>
															<?php } ?>
														</table>
													</div>
												</div> <!-- Filiação Cooperativa -->
												<hr><h2>Percepção do Entrevistador</h2>
												<div class="form-group row">
													<div class="col-lg-12">
														<textarea rows="4" name="FISH_COOEXP_PERCEPCAO" id="FISH_COOEXP_PERCEPCAO" class="form-control" placeholder="Descrever as percepções do entrevistador..."><?php echo $vetor_EXPECTATIVAS['FISH_COOEXP_PERCEPCAO']; ?></textarea>
													</div>
												</div> <!-- Percepções -->
												</br></br>
												<input name="pesq" type="image" src="imgs/salvar.png" class="float" />
											</form>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<form action="recebe_fish_cadastrar_cooperativa.php?id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_fish_cadastrar_cooperativa" enctype="multipart/form-data" id="recebe_fish_cadastrar_cooperativa">
									<input name="pesq" type="image" src="imgs/gerar.png" class="float"/>
								</form>
							<?php } ?>
						</div> <!-- Cooperativa -->

					</div></br>
            </div><!--.box-typical-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}}
?>
			

