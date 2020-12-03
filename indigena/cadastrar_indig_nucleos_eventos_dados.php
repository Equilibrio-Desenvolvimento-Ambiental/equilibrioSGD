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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$INDIG_NUC_ID = $_GET['INDIG_NUC_ID'];
			$INDIG_NUCEVE_ID = $_GET['INDIG_NUCEVE_ID'];

			$sql_TPTECNICOS_PRINCIPAL = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql = mysql_query("SELECT * FROM TAB_INDIG_NUCLEOS_EVENTOS WHERE INDIG_NUCEVE_ID = '$INDIG_NUCEVE_ID';", $db) or die(mysql_error());
			$vetor = mysql_fetch_array($sql);
			

			$sql_TPTECNICOS = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TPEVENTOS = mysql_query("SELECT * FROM TAB_APOIO_EVENTOS WHERE DESCRICAO LIKE '%(INDIGENA)%' AND ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TPDOCUMENTOS = mysql_query("SELECT * FROM TAB_APOIO_TIPODOC WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
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
<script type="text/javascript">

var qtdeCamposTECNICOS = 0;
function addCamposTECNICOS() {
var objPaiTECNICOS = document.getElementById("campoPaiTECNICOS");
var objFilhoTECNICOS = document.createElement("div");
objFilhoTECNICOS.setAttribute("id","filhoTECNICOS"+qtdeCamposTECNICOS);
objPaiTECNICOS.appendChild(objFilhoTECNICOS);
document.getElementById("filhoTECNICOS"+qtdeCamposTECNICOS).innerHTML = "<table width='100%' border='0'><tr><td width='80%' class='style12'><select name='INDIG_NUCEVI_TECNICO[]' id='INDIG_NUCEVI_TECNICO' class='form-control'><option value='0' selected='selected'>Selecione um Técnico...</option><?php while ($vetor_TPTECNICOS=mysql_fetch_array($sql_TPTECNICOS)) { ?><option value='<?php echo $vetor_TPTECNICOS[ID]; ?>'><?php echo $vetor_TPTECNICOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='18%' class='style12'><input type='button' onclick='removerCampoTECNICOS("+qtdeCamposTECNICOS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposTECNICOS++;
}
function removerCampoTECNICOS(id) {
var objPaiTECNICOS = document.getElementById("campoPaiTECNICOS");
var objFilhoTECNICOS = document.getElementById("filhoTECNICOS"+id);
console.log(objPaiTECNICOS);
var removido = objPaiTECNICOS.removeChild(objFilhoTECNICOS);
}

var qtdeCamposIMAGENS = 0;
function addCamposIMAGENS() {
var objPaiIMAGENS = document.getElementById("campoPaiIMAGENS");
var objFilhoIMAGENS = document.createElement("div");
objFilhoIMAGENS.setAttribute("id","filhoIMAGENS"+qtdeCamposIMAGENS);
objPaiIMAGENS.appendChild(objFilhoIMAGENS);
document.getElementById("filhoIMAGENS"+qtdeCamposIMAGENS).innerHTML = "<table width='100%' border='0'><tr><td width='40%' class='style12'><input type='text' name='INDIG_NUCEVI_LEGENDA[]' id='INDIG_NUCEVI_LEGENDA' class='form-control'></td><td width='2%' class='style12'></td><td width='40%'><input type='file' name='INDIG_NUCEVI_ARQUIVO[]' id='INDIG_NUCEVI_ARQUIVO' class='form-control'></td><td width='2%' class='style12'></td><td width='16%' class='style12'><input type='button' onclick='removerCampoIMAGENS("+qtdeCamposIMAGENS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposIMAGENS++;
}
function removerCampoIMAGENS(id) {
var objPaiIMAGENS = document.getElementById("campoPaiIMAGENS");
var objFilhoIMAGENS = document.getElementById("filhoIMAGENS"+id);
console.log(objPaiIMAGENS);
var removido = objPaiIMAGENS.removeChild(objFilhoIMAGENS);
}

var qtdeCamposDOCUMENTOS = 0;
function addCamposDOCUMENTOS() {
var objPaiDOCUMENTOS = document.getElementById("campoPaiDOCUMENTOS");
var objFilhoDOCUMENTOS = document.createElement("div");
objFilhoDOCUMENTOS.setAttribute("id","filhoDOCUMENTOS"+qtdeCamposDOCUMENTOS);
objPaiDOCUMENTOS.appendChild(objFilhoDOCUMENTOS);
document.getElementById("filhoDOCUMENTOS"+qtdeCamposDOCUMENTOS).innerHTML = "<table width='100%' border='0'><tr><td width='35%'><select name='INDIG_NUCEVD_TIPO[]' id='INDIG_NUCEVD_TIPO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_TPDOCUMENTOS=mysql_fetch_array($sql_TPDOCUMENTOS)) { ?><option value='<?php echo  $vetor_TPDOCUMENTOS[ID]; ?>'><?php echo $vetor_TPDOCUMENTOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='25%' class='style12'><input type='text' name='INDIG_NUCEVD_DESCRICAO[]' id='INDIG_NUCEVD_DESCRICAO' class='form-control' placeholder='Digite a descrição...'></td><td width='1%'></td><td width='30%' class='style12'><input type='file' name='INDIG_NUCEVD_ARQUIVO[]' id='INDIG_NUCEVD_ARQUIVO' class='form-control'></td><td width='1%'></td><td width='6%' class='style12'><input type='button' onclick='removerCampoDOCUMENTOS("+qtdeCamposDOCUMENTOS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposDOCUMENTOS++;
}
function removerCampoDOCUMENTOS(id) {
var objPaiDOCUMENTOS = document.getElementById("campoPaiDOCUMENTOS");
var objFilhoDOCUMENTOS = document.getElementById("filhoDOCUMENTOS"+id);
console.log(objPaiDOCUMENTOS);
var removido = objPaiDOCUMENTOS.removeChild(objFilhoDOCUMENTOS);
}
	
$(document).ready(function(){
	$('#tipo').change(function(){
		$('#subtipo').load('busca.php?id='+$('#tipo').val());
    })
});
</script>
<body>
<?php require_once("includes/site-header.php");?>
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Gestão de Dados dos Projetos Indígenas</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Dados do Evento - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_indig_alterar_nucleos_eventos.php?INDIG_NUCEVE_ID=<?php echo $INDIG_NUCEVE_ID; ?>&INDIG_NUC_ID=<?php echo $INDIG_NUC_ID; ?>" method="post" name="recebe_indig_alterar_nucleos_eventos" enctype="multipart/form-data" id="recebe_indig_alterar_nucleos_eventos">
                    <div class="form-group row">
						<div class="col-lg-4">
                        	<label class="form-label semibold" for="INDIG_NUCEVE_DATA">Data do Evento:</label>
                            <input type="text" name="INDIG_NUCEVE_DATA" class="form-control" id="INDIG_NUCEVE_DATA" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor['INDIG_NUCEVE_DATA'])); ?>">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="INDIG_NUCEVE_TECNICO">Técnico Principal :</label>
                            <select name="INDIG_NUCEVE_TECNICO" id="INDIG_NUCEVE_TECNICO" class="form-control">
								<?php while ($vetor_TPTECNICOS_PRINCIPAL = mysql_fetch_array($sql_TPTECNICOS_PRINCIPAL)) { ?>
                                <option value="<?php echo $vetor_TPTECNICOS_PRINCIPAL['ID']; ?>" <?php if (strcasecmp($vetor['INDIG_NUCEVE_TECNICO'], $vetor_TPTECNICOS_PRINCIPAL['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPTECNICOS_PRINCIPAL['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="INDIG_NUCEVE_TIPO">Tipo do Evento:</label>
                            <select name="INDIG_NUCEVE_TIPO" id="INDIG_NUCEVE_TIPO" class="form-control">
								<?php while ($vetor_TPEVENTOS=mysql_fetch_array($sql_TPEVENTOS)) { ?>
                                <option value="<?php echo $vetor_TPEVENTOS['ID']; ?>" <?php if (strcasecmp($vetor['INDIG_NUCEVE_TIPO'], $vetor_TPEVENTOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPEVENTOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Data do Evento / Tipo do Evento -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="INDIG_NUCEVE_DESCRICAO">Observações:</label>
                            <input type="text" name="INDIG_NUCEVE_DESCRICAO" class="form-control" id="INDIG_NUCEVE_DESCRICAO" placeholder="Digite observações..." value="<?php echo $vetor['INDIG_NUCEVE_DESCRICAO']; ?>">
                         </div>	
                    </div> <!-- Observações -->
					</br>
                    <input name="salvar" type="image" src="imgs/salvar.png" class="float" />
				</form>
			</div><!--.box-typical-->
			<div class="box-typical box-typical-padding">
                <form action="recebe_indig_cadastrar_nucleos_eventos_dados.php?INDIG_NUCEVE_ID=<?php echo $INDIG_NUCEVE_ID;?>&INDIG_NUC_ID=<?php echo $INDIG_NUC_ID;?>" method="post" name="recebe_indig_cadastrar_nucleos_eventos_dados" enctype="multipart/form-data" id="recebe_indig_cadastrar_nucleos_eventos_dados">
                    <div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">Atividade/Sub-Atividade</a></li>
                            <li><a href="#view2">Técnicos</a></li>
                            <li><a href="#view3">Reg. Fotográfico</a></li>
                            <li><a href="#view4">Documentos</a></li>
                        </ul>

	                    <div class="tabcontents">
                    
                        <div id="view1">
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='28%' class='style12'>
                            <select name="tipo" id="tipo" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("SELECT * FROM TAB_APOIO_TPVISITINDIG WHERE ID > '0' AND ATIVO = '1' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'></td>
							<td width='28%' class='style12'>
                            	<select name="subtipo" id="subtipo" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>
                            	<img src="imgs/if_system.png" name="btnPadrao" class="float" width="20" height="20" border="0" />
                            </td>
                            <td width='30%'><textarea rows='4' class='form-control' name='INDIG_NUCEVC_DESCRICAO'></textarea></td>
                            <td width='10%' class='style12'></td>
                          </tr>
                        </table>
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="2%"></td>
                            <td width="8%">Ações</td>
                          </thead>
                          <?php 
                                $sql_CLASSIFICACAO = mysql_query("SELECT TAB_INDIG_NUCLEOS_EVENTOS_CLASSIFICACAO.INDIG_NUCEVC_ID, TAB_APOIO_TPVISITINDIG.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISITINDIG.DESCRICAO AS SUBTIPO, TAB_INDIG_NUCLEOS_EVENTOS_CLASSIFICACAO.INDIG_NUCEVC_DESCRICAO FROM TAB_INDIG_NUCLEOS_EVENTOS_CLASSIFICACAO LEFT OUTER JOIN TAB_APOIO_TPSUBVISITINDIG ON TAB_INDIG_NUCLEOS_EVENTOS_CLASSIFICACAO.INDIG_NUCEVC_TIPO = TAB_APOIO_TPSUBVISITINDIG.ID LEFT OUTER JOIN TAB_APOIO_TPVISITINDIG ON TAB_APOIO_TPSUBVISITINDIG.ID_PRINCIPAL = TAB_APOIO_TPVISITINDIG.ID WHERE TAB_INDIG_NUCLEOS_EVENTOS_CLASSIFICACAO.INDIG_NUCEVC_EVENTO = '$INDIG_NUCEVE_ID' ORDER BY TIPO ASC, SUBTIPO ASC;", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_CLASSIFICACAO=mysql_fetch_array($sql_CLASSIFICACAO)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            	<td width="28%"><?php echo $vetor_CLASSIFICACAO['TIPO']; ?></td>
								<td width="2%"></td>
								<td width="28%"><?php echo $vetor_CLASSIFICACAO['SUBTIPO']; ?></td>
								<td width="2%"></td>
								<td width="30%"><?php echo $vetor_CLASSIFICACAO['INDIG_NUCEVC_DESCRICAO']; ?></td>
								<td width="2%"></td>
								<td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_indig_nucleos_eventos_classificacao.php?INDIG_NUCEVC_ID=<?php echo $vetor_CLASSIFICACAO['INDIG_NUCEVC_ID']; ?>&INDIG_NUCEVE_ID=<?php echo $INDIG_NUCEVE_ID; ?>&INDIG_NUC_ID=<?php echo $INDIG_NUC_ID; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_nucleos_eventos_classificacao.php?INDIG_NUCEVC_ID=<?php echo $vetor_CLASSIFICACAO['INDIG_NUCEVC_ID']; ?>&INDIG_NUCEVE_ID=<?php echo $INDIG_NUCEVE_ID; ?>&INDIG_NUC_ID=<?php echo $INDIG_NUC_ID; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>

	                    <div id="view2">
                        <table width="100%">
                          <thead>
                            <td width="80%">Técnicos Responsáveis</td>
                            <td width="2%"></td>
                            <td width="18%">&nbsp;</td>
                          </thead>
                        </table>
                        <div id="campoPaiTECNICOS"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                        <br/>
                        <input type="button" value="Adicionar" onClick="addCamposTECNICOS()" class="btn btn-inline">
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="80%">Técnicos Responsáveis</td>
                            <td width="2%"></td>
                            <td width="18%">Ações</td>
                          </thead>
                            <?php
                                $sql_TECNICOS = mysql_query("SELECT TAB_INDIG_NUCLEOS_EVENTOS_TECNICOS.INDIG_NUCEVT_ID, TAB_APOIO_TECNICOS.DESCRICAO AS INDIG_NUCEVI_TECNICO_DESC FROM TAB_INDIG_NUCLEOS_EVENTOS_TECNICOS LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_INDIG_NUCLEOS_EVENTOS_TECNICOS.INDIG_NUCEVI_TECNICO = TAB_APOIO_TECNICOS.ID WHERE TAB_INDIG_NUCLEOS_EVENTOS_TECNICOS.INDIG_NUCEVI_EVENTO = '$INDIG_NUCEVE_ID' ORDER BY TAB_APOIO_TECNICOS.DESCRICAO ASC;", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                            ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="80%"><?php echo $vetor_TECNICOS['INDIG_NUCEVI_TECNICO_DESC']; ?></td>
                            <td width="2%"></td>
                            <td width="18%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_nucleos_eventos_tecnico.php?INDIG_NUCEVT_ID=<?php echo $vetor_TECNICOS['INDIG_NUCEVT_ID']; ?>&INDIG_NUCEVE_ID=<?php echo $INDIG_NUCEVE_ID; ?>&INDIG_NUC_ID=<?php echo $INDIG_NUC_ID; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
	                    </div>
                    
                    	<div id="view3">
                        <table width="100%">
                          <thead>
                            <td width="40%">Legenda</td>
                            <td width="2%"></td>
                            <td width="40%">Imagem</td>
                            <td width="2%"></td>
                            <td width="16%">&nbsp;</td>
                          </thead>
                        </table>
                        <div id="campoPaiIMAGENS"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                        <br/>
                        <input type="button" value="Nova Imagem" onClick="addCamposIMAGENS()" class="btn btn-inline">
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="40%">Legenda</td>
                            <td width="2%"></td>
                            <td width="40%">Imagem</td>
                            <td width="2%"></td>
                            <td width="16%">Ações</td>
                          </thead>
                           <?php 
                                $sql_IMAGENS = mysql_query("SELECT TAB_INDIG_NUCLEOS_EVENTOS_IMAGENS.INDIG_NUCEVI_ID, TAB_INDIG_NUCLEOS_EVENTOS_IMAGENS.INDIG_NUCEVI_ARQUIVO, TAB_INDIG_NUCLEOS_EVENTOS_IMAGENS.INDIG_NUCEVI_LEGENDA FROM TAB_INDIG_NUCLEOS_EVENTOS_IMAGENS WHERE TAB_INDIG_NUCLEOS_EVENTOS_IMAGENS.INDIG_NUCEVI_EVENTO = '$INDIG_NUCEVE_ID' ORDER BY TAB_INDIG_NUCLEOS_EVENTOS_IMAGENS.INDIG_NUCEVI_LEGENDA ASC;", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_IMAGENS=mysql_fetch_array($sql_IMAGENS)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                            ?>
                            <tr bgcolor="<?php echo $cor; ?>">
                                <td width="40%"><?php echo $vetor_IMAGENS['INDIG_NUCEVI_LEGENDA']; ?></td>
                                <td width="2%"></td>
                                <td width="40%" align="center" valign="middle"><img src="imagens/<?php echo $vetor_IMAGENS['INDIG_NUCEVI_ARQUIVO']; ?>" width="200"></td>
                                <td width="2%"></td>
                                <td width="16%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_indig_nucleos_eventos_imagem.php?INDIG_NUCEVI_ID=<?php echo $vetor_IMAGENS['INDIG_NUCEVI_ID']; ?>&INDIG_NUCEVE_ID=<?php echo $INDIG_NUCEVE_ID; ?>&INDIG_NUC_ID=<?php echo $INDIG_NUC_ID; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_nucleos_eventos_imagem.php?INDIG_NUCEVI_ID=<?php echo $vetor_IMAGENS['INDIG_NUCEVI_ID']; ?>&INDIG_NUCEVE_ID=<?php echo $INDIG_NUCEVE_ID; ?>&INDIG_NUC_ID=<?php echo $INDIG_NUC_ID; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                    	</div>

						<div id="view4">
							<table width="100%">
							  <thead>
								<td width="35%">Tipo</td>
								<td width="1%"></td>
								<td width="25%">Descrição</td>
								<td width="1%"></td>
								<td width="30%">Anexo</td>
								<td width="1%"></td>
								<td width="6%">&nbsp;</td>
							  </thead>
							</table>
							<div id="campoPaiDOCUMENTOS"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
							</br>
							<input type="button" value="Novo Documento" onClick="addCamposDOCUMENTOS()" class="btn btn-inline">
							</br></br>
							<table width="100%">
								<thead>
									<td width="35%">Tipo</td>
									<td width="1%"></td>
									<td width="25%">Descrição</td>
									<td width="1%"></td>
									<td width="30%">Anexo</td>
									<td width="1%"></td>
									<td width="6%">Ações</td>
								</thead>
  							  	<?php
									$sql_DOCUMENTOS = mysql_query("SELECT TAB_INDIG_NUCLEOS_EVENTOS_DOCUMENTOS.INDIG_NUCEVD_ID, TAB_APOIO_TIPODOC.DESCRICAO AS INDIG_NUCEVD_TIPO_DESC, TAB_INDIG_NUCLEOS_EVENTOS_DOCUMENTOS.INDIG_NUCEVD_DESCRICAO, TAB_INDIG_NUCLEOS_EVENTOS_DOCUMENTOS.INDIG_NUCEVD_ARQUIVO FROM TAB_INDIG_NUCLEOS_EVENTOS_DOCUMENTOS LEFT OUTER JOIN TAB_APOIO_TIPODOC ON TAB_INDIG_NUCLEOS_EVENTOS_DOCUMENTOS.INDIG_NUCEVD_TIPO = TAB_APOIO_TIPODOC.ID WHERE TAB_INDIG_NUCLEOS_EVENTOS_DOCUMENTOS.INDIG_NUCEVD_EVENTO = '$INDIG_NUCEVE_ID' ORDER BY INDIG_NUCEVD_TIPO_DESC ASC;", $db) or die(mysql_error());
									$cor = "#D8D8D8";
									while ($vetor_DOCUMENTOS=mysql_fetch_array($sql_DOCUMENTOS)) {
										if (strcasecmp($cor, "#FFFFFF") == 0){
											$cor = "#D8D8D8";
										} else {
											$cor = "#FFFFFF";
										}
								?>
								<tr bgcolor="<?php echo $cor; ?>">
									<td width="35%"><?php echo $vetor_DOCUMENTOS['INDIG_NUCEVD_TIPO_DESC']; ?></td>
									<td width="1%"></td>
									<td width="25%"><?php echo $vetor_DOCUMENTOS['INDIG_NUCEVD_DESCRICAO']; ?></td>
									<td width="1%"></td>
									<td width="30%" align="center"><a href="docs/<?php echo $vetor_DOCUMENTOS['INDIG_NUCEVD_ARQUIVO']; ?>" target="_blank">Salvar Arquivo</a></td>
									<td width="1%"></td>
                                	<td width="6%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_indig_nucleos_eventos_documento.php?INDIG_NUCEVD_ID=<?php echo $vetor_DOCUMENTOS['INDIG_NUCEVD_ID']; ?>&INDIG_NUCEVE_ID=<?php echo $INDIG_NUCEVE_ID; ?>&INDIG_NUC_ID=<?php echo $INDIG_NUC_ID; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_nucleos_eventos_documento.php?INDIG_NUCEVD_ID=<?php echo $vetor_DOCUMENTOS['INDIG_NUCEVD_ID']; ?>&INDIG_NUCEVE_ID=<?php echo $INDIG_NUCEVE_ID; ?>&INDIG_NUC_ID=<?php echo $INDIG_NUC_ID; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
								</tr>
								<?php } ?>
							</table>
						</div> <!-- Documentos -->
							
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