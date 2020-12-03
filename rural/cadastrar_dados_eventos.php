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
			$id_evento = $_GET['id_evento'];
			$id_familia = $_GET['id_familia'];
			
			$sql_EVENTO = mysql_query("SELECT * FROM TAB_415421_EVENTOS WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
			$vetor_EVENTO = mysql_fetch_array($sql_EVENTO);

			$sql_TPEVENTOS = mysql_query("SELECT * FROM TAB_APOIO_EVENTOS ORDER BY DESCRICAO ASC", $db) or die(mysql_error());
			$sql_TECNICOS = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS ORDER BY DESCRICAO ASC", $db) or die(mysql_error());
			$sql_TPDOCUMENTOS = mysql_query("SELECT * FROM TAB_APOIO_TIPODOC WHERE ID > 0 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
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
document.getElementById("filhoTECNICOS"+qtdeCamposTECNICOS).innerHTML = "<table width='100%' border='0'><tr><td width='80%' class='style12'><select name='TECNICOS_TECNICO[]' id='TECNICOS_TECNICO' class='form-control'><option value='0' selected='selected'>Selecione um Técnico...</option><?php while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) { ?><option value='<?php echo $vetor_TECNICOS[ID]; ?>'><?php echo $vetor_TECNICOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='18%' class='style12'><input type='button' onclick='removerCampoTECNICOS("+qtdeCamposTECNICOS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
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
document.getElementById("filhoIMAGENS"+qtdeCamposIMAGENS).innerHTML = "<table width='100%' border='0'><tr><td width='40%' class='style12'><input type='text' name='IMAGEM_LEGENDA[]' class='form-control'></td><td width='2%' class='style12'></td><td width='40%'><input type='file' name='IMAGEM_NOME[]' class='form-control'></td><td width='2%' class='style12'></td><td width='16%' class='style12'><input type='button' onclick='removerCampoIMAGENS("+qtdeCamposIMAGENS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposIMAGENS++;
}
function removerCampoIMAGENS(id) {
var objPaiIMAGENS = document.getElementById("campoPaiIMAGENS");
var objFilhoIMAGENS = document.getElementById("filhoIMAGENS"+id);
console.log(objPaiIMAGENS);
var removido = objPaiIMAGENS.removeChild(objFilhoIMAGENS);
}

var qtdeCamposEVEDOCS = 0;
function addCamposEVEDOCS() {
var objPaiEVEDOCS = document.getElementById("campoPaiEVEDOCS");
var objFilhoEVEDOCS = document.createElement("div");
objFilhoEVEDOCS.setAttribute("id","filhoEVEDOCS"+qtdeCamposEVEDOCS);
objPaiEVEDOCS.appendChild(objFilhoEVEDOCS);
document.getElementById("filhoEVEDOCS"+qtdeCamposEVEDOCS).innerHTML = "<table width='100%' border='0'><tr><td width='10%' class='style12'><input type='text' name='EVEDOC_DATA[]' id='EVEDOC_DATA' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10' placeholder='Digite a data...' value='<?php echo date('d/m/Y', strtotime($vetor_EVENTO['EVENTOS_DATA'])); ?>'></td><td width='1%'></td><td width='30%'><select name='EVEDOC_TIPO[]' id='EVEDOC_TIPO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_TPDOCUMENTOS=mysql_fetch_array($sql_TPDOCUMENTOS)) { ?><option value='<?php echo  $vetor_TPDOCUMENTOS[ID]; ?>'><?php echo $vetor_TPDOCUMENTOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%'></td><td width='20%' class='style12'><input type='text' name='EVEDOC_DESCRICAO[]' id='EVEDOC_DESCRICAO' class='form-control' placeholder='Digite a descrição...'></td><td width='1%'></td><td width='30%' class='style12'><input type='file' name='EVEDOC_ARQUIVO[]' id='EVEDOC_ARQUIVO' class='form-control'></td><td width='1%'></td><td width='6%' class='style12'><input type='button' onclick='removerCampoEVEDOCS("+qtdeCamposEVEDOCS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposEVEDOCS++;
}
function removerCampoEVEDOCS(id) {
var objPaiEVEDOCS = document.getElementById("campoPaiEVEDOCS");
var objFilhoEVEDOCS = document.getElementById("filhoEVEDOCS"+id);
console.log(objPaiEVEDOCS);
var removido = objPaiEVEDOCS.removeChild(objFilhoEVEDOCS);
}
	
$(document).ready(function(){
	$('#tipo415').change(function(){
		$('#subtipo415').load('busca415.php?id='+$('#tipo415').val());
    })
	$('#tipo421').change(function(){
		$('#subtipo421').load('busca421.php?id='+$('#tipo421').val());
	});
	$('#tipo415421_interf').change(function(){
		$('#subtipo415421_interf').load('busca415421_interf.php?id='+$('#tipo415421_interf').val());
	});
	$('#tiporir415').change(function(){
		$('#subtiporir415').load('buscarir415.php?id='+$('#tiporir415').val());
    })
	$('#tiporir421').change(function(){
		$('#subtiporir421').load('buscarir421.php?id='+$('#tiporir421').val());
	});
	$('#tiporir_interf').change(function(){
		$('#subtiporir_interf').load('buscarir_interf.php?id='+$('#tiporir_interf').val());
	});
	$('#tiporir').change(function(){
		$('#subtiporir').load('buscarir.php?id='+$('#tiporir').val());
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
							<h3>Gestão de Dados dos Projetos 4.1.5, 4.2.1 e Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Dados do Evento - v.1.1.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_alterar_eventos.php?id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_alterar_eventos" enctype="multipart/form-data" id="recebe_alterar_eventos">
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
					</br>
                    <input name="salvar" type="image" src="imgs/salvar.png" class="float" />
				</form>
			</div><!--.box-typical-->
			<div class="box-typical box-typical-padding">
                <form action="recebe_cadastrar_dados_eventos.php?id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_cadastrar_dados_eventos" enctype="multipart/form-data" id="recebe_cadastrar_dados_eventos">
                    <div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">Reparação</a></li>
                            <li><a href="#view2">ATES</a></li>
                            <li><a href="#view3">Rural//Interface</a></li>
                            <li><a href="#view4">RIR Reparação</a></li>
                            <li><a href="#view5">RIR ATES</a></li>
                            <li><a href="#view6">RIR//Interface</a></li>
                            <li><a href="#view7">Técnicos</a></li>
                            <li><a href="#view8">Reg. Fotográfico</a></li>
                            <li><a href="#view9">Documentos</a></li>
                            <li><a href="#view10">RIR (1ª Versão)</a></li>
                        </ul>

	                    <div class="tabcontents">
                    
                        <div id="view1">
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de Reparação</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de Reparação</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='28%' class='style12'>
                            <select name="tipo415" id="tipo415" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("SELECT * FROM TAB_APOIO_TPVISIT415 WHERE ATIVO = 1 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'></td>
							<td width='28%' class='style12'>
                            	<select name="subtipo415" id="subtipo415" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>
                            	<img src="imgs/if_system.png" name="btnPadrao415" class="float" width="20" height="20" border="0" />
                            </td>
                            <td width='30%'><textarea rows='4' class='form-control' name='CLASS415_DESCRICAO'></textarea></td>
                            <td width='10%' class='style12'></td>
                          </tr>
                        </table>
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de Reparação</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de Reparação</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="2%"></td>
                            <td width="8%">Ações</td>
                          </thead>
                          <?php 
                                $sql_projeto415 = mysql_query("SELECT TAB_415_CLASSIFICACAO.CLASS415_CODIGO, TAB_APOIO_TPVISIT415.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISIT415.DESCRICAO AS SUBTIPO, TAB_415_CLASSIFICACAO.CLASS415_DESCRICAO FROM TAB_415_CLASSIFICACAO LEFT OUTER JOIN TAB_APOIO_TPSUBVISIT415 ON  TAB_415_CLASSIFICACAO.CLASS415_TIPO = TAB_APOIO_TPSUBVISIT415.ID LEFT OUTER JOIN TAB_APOIO_TPVISIT415 ON TAB_APOIO_TPSUBVISIT415.ID_PRINCIPAL = TAB_APOIO_TPVISIT415.ID WHERE TAB_415_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_projeto415=mysql_fetch_array($sql_projeto415)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="28%"><?php echo $vetor_projeto415['TIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="28%"><?php echo $vetor_projeto415['SUBTIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="30%"><?php echo $vetor_projeto415['CLASS415_DESCRICAO']; ?></td>
                            <td width="2%"></td>
                            <td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_evento_class415.php?id=<?php echo $vetor_projeto415['CLASS415_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_evento_class415.php?id=<?php echo $vetor_projeto415['CLASS415_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>

                        <div id="view2">
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de ATES</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de ATES</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='28%' class='style12'>
                            <select name="tipo421" id="tipo421" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("SELECT * FROM TAB_APOIO_TPVISIT421 WHERE ATIVO = 1 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'></td>
							<td width='28%' class='style12'>
                            	<select name="subtipo421" id="subtipo421" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>
                            	<img src="imgs/if_system.png" name="btnPadrao421" class="float" width="20" height="20" border="0" />
                            </td>
                            <td width='30%'><textarea rows='4' class='form-control' name='CLASS421_DESCRICAO'></textarea></td>
                            <td width='10%' class='style12'></td>
                          </tr>
                        </table>
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de ATES</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de ATES</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="2%"></td>
                            <td width="8%">Ações</td>
                          </thead>
                          <?php 
                                $sql_projeto421 = mysql_query("SELECT TAB_421_CLASSIFICACAO.CLASS421_CODIGO, TAB_APOIO_TPVISIT421.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISIT421.DESCRICAO AS SUBTIPO, TAB_421_CLASSIFICACAO.CLASS421_DESCRICAO FROM TAB_421_CLASSIFICACAO LEFT OUTER JOIN TAB_APOIO_TPSUBVISIT421 ON  TAB_421_CLASSIFICACAO.CLASS421_TIPO = TAB_APOIO_TPSUBVISIT421.ID LEFT OUTER JOIN TAB_APOIO_TPVISIT421 ON TAB_APOIO_TPSUBVISIT421.ID_PRINCIPAL = TAB_APOIO_TPVISIT421.ID WHERE TAB_421_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_projeto421=mysql_fetch_array($sql_projeto421)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="28%"><?php echo $vetor_projeto421['TIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="28%"><?php echo $vetor_projeto421['SUBTIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="30%"><?php echo $vetor_projeto421['CLASS421_DESCRICAO']; ?></td>
                            <td width="2%"></td>
                            <td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_evento_class421.php?id=<?php echo $vetor_projeto421['CLASS421_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_evento_class421.php?id=<?php echo $vetor_projeto421['CLASS421_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>
							
                        <div id="view3">
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de Interface</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de Interface</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='28%' class='style12'>
                            <select name="tipo415421_interf" id="tipo415421_interf" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("SELECT * FROM TAB_APOIO_TPVISIT415421_INTERF WHERE ATIVO = 1 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'></td>
							<td width='28%' class='style12'>
                            	<select name="subtipo415421_interf" id="subtipo415421_interf" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>
                            	<img src="imgs/if_system.png" name="btnPadrao415421_interf" class="float" width="20" height="20" border="0" />
                            </td>
                            <td width='30%'><textarea rows='4' class='form-control' name='CLASS415421_DESCRICAO'></textarea></td>
                            <td width='10%' class='style12'></td>
                          </tr>
                        </table>
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de Interface</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de Interface</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="2%"></td>
                            <td width="8%">Ações</td>
                          </thead>
                          <?php 
                                $sql_projeto415421_interf = mysql_query("SELECT TAB_415421_CLASSIFICACAO.CLASS415421_CODIGO, TAB_APOIO_TPVISIT415421_INTERF.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISIT415421_INTERF.DESCRICAO AS SUBTIPO, TAB_415421_CLASSIFICACAO.CLASS415421_DESCRICAO FROM TAB_415421_CLASSIFICACAO LEFT OUTER JOIN TAB_APOIO_TPSUBVISIT415421_INTERF ON TAB_415421_CLASSIFICACAO.CLASS415421_TIPO = TAB_APOIO_TPSUBVISIT415421_INTERF.ID LEFT OUTER JOIN TAB_APOIO_TPVISIT415421_INTERF ON TAB_APOIO_TPSUBVISIT415421_INTERF.ID_PRINCIPAL = TAB_APOIO_TPVISIT415421_INTERF.ID WHERE TAB_415421_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_projeto415421_interf=mysql_fetch_array($sql_projeto415421_interf)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="28%"><?php echo $vetor_projeto415421_interf['TIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="28%"><?php echo $vetor_projeto415421_interf['SUBTIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="30%"><?php echo $vetor_projeto415421_interf['CLASS415421_DESCRICAO']; ?></td>
                            <td width="2%"></td>
                            <td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_evento_class415421_interf.php?id=<?php echo $vetor_projeto415421_interf['CLASS415421_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_evento_class415421_interf.php?id=<?php echo $vetor_projeto415421_interf['CLASS415421_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>

                        <div id="view4">
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de Reparação</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de Reparação</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='28%' class='style12'>
                            <select name="tiporir415" id="tiporir415" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("SELECT * FROM TAB_APOIO_TPVISITRIR415 WHERE ATIVO = 1 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'></td>
							<td width='28%' class='style12'>
                            	<select name="subtiporir415" id="subtiporir415" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>
                            	<img src="imgs/if_system.png" name="btnPadraoRIR415" class="float" width="20" height="20" border="0" />
                            </td>
                            <td width='30%'><textarea rows='4' class='form-control' name='CLASSRIR415_DESCRICAO'></textarea></td>
                            <td width='10%' class='style12'></td>
                          </tr>
                        </table>
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de Reparação</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de Reparação</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="2%"></td>
                            <td width="8%">Ações</td>
                          </thead>
                          <?php 
                                $sql_projetorir415 = mysql_query("SELECT TAB_RIR415_CLASSIFICACAO.CLASSRIR415_CODIGO, TAB_APOIO_TPVISITRIR415.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISITRIR415.DESCRICAO AS SUBTIPO, TAB_RIR415_CLASSIFICACAO.CLASSRIR415_DESCRICAO FROM TAB_RIR415_CLASSIFICACAO LEFT OUTER JOIN TAB_APOIO_TPSUBVISITRIR415 ON  TAB_RIR415_CLASSIFICACAO.CLASSRIR415_TIPO = TAB_APOIO_TPSUBVISITRIR415.ID LEFT OUTER JOIN TAB_APOIO_TPVISITRIR415 ON TAB_APOIO_TPSUBVISITRIR415.ID_PRINCIPAL = TAB_APOIO_TPVISITRIR415.ID WHERE TAB_RIR415_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_projetorir415=mysql_fetch_array($sql_projetorir415)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="28%"><?php echo $vetor_projetorir415['TIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="28%"><?php echo $vetor_projetorir415['SUBTIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="30%"><?php echo $vetor_projetorir415['CLASSRIR415_DESCRICAO']; ?></td>
                            <td width="2%"></td>
                            <td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_evento_classrir415.php?id=<?php echo $vetor_projetorir415['CLASSRIR415_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_evento_classrir415.php?id=<?php echo $vetor_projetorir415['CLASSRIR415_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>							

                        <div id="view5">
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de ATES</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de ATES</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='28%' class='style12'>
                            <select name="tiporir421" id="tiporir421" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("SELECT * FROM TAB_APOIO_TPVISITRIR421 WHERE ATIVO = 1 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'></td>
							<td width='28%' class='style12'>
                            	<select name="subtiporir421" id="subtiporir421" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>
                            	<img src="imgs/if_system.png" name="btnPadraoRIR421" class="float" width="20" height="20" border="0" />
                            </td>
                            <td width='30%'><textarea rows='4' class='form-control' name='CLASSRIR421_DESCRICAO'></textarea></td>
                            <td width='10%' class='style12'></td>
                          </tr>
                        </table>
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de ATES</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de ATES</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="2%"></td>
                            <td width="8%">Ações</td>
                          </thead>
                          <?php 
                                $sql_projetorir421 = mysql_query("SELECT TAB_RIR421_CLASSIFICACAO.CLASSRIR421_CODIGO, TAB_APOIO_TPVISITRIR421.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISITRIR421.DESCRICAO AS SUBTIPO, TAB_RIR421_CLASSIFICACAO.CLASSRIR421_DESCRICAO FROM TAB_RIR421_CLASSIFICACAO LEFT OUTER JOIN TAB_APOIO_TPSUBVISITRIR421 ON  TAB_RIR421_CLASSIFICACAO.CLASSRIR421_TIPO = TAB_APOIO_TPSUBVISITRIR421.ID LEFT OUTER JOIN TAB_APOIO_TPVISITRIR421 ON TAB_APOIO_TPSUBVISITRIR421.ID_PRINCIPAL = TAB_APOIO_TPVISITRIR421.ID WHERE TAB_RIR421_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_projetorir421=mysql_fetch_array($sql_projetorir421)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="28%"><?php echo $vetor_projetorir421['TIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="28%"><?php echo $vetor_projetorir421['SUBTIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="30%"><?php echo $vetor_projetorir421['CLASSRIR421_DESCRICAO']; ?></td>
                            <td width="2%"></td>
                            <td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_evento_classrir421.php?id=<?php echo $vetor_projetorir421['CLASSRIR421_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_evento_classrir421.php?id=<?php echo $vetor_projetorir421['CLASSRIR421_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>
							
                        <div id="view6">
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de Interface</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de Interface</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='28%' class='style12'>
                            <select name="tiporir_interf" id="tiporir_interf" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("SELECT * FROM TAB_APOIO_TPVISITRIR_INTERF WHERE ATIVO = 1 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'></td>
							<td width='28%' class='style12'>
                            	<select name="subtiporir_interf" id="subtiporir_interf" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>
                            	<img src="imgs/if_system.png" name="btnPadraoRIR_interf" class="float" width="20" height="20" border="0" />
                            </td>
                            <td width='30%'><textarea rows='4' class='form-control' name='CLASSRIRINT_DESCRICAO'></textarea></td>
                            <td width='10%' class='style12'></td>
                          </tr>
                        </table>
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de Interface</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de Interface</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="2%"></td>
                            <td width="8%">Ações</td>
                          </thead>
                          <?php 
                                $sql_projetorir_interf = mysql_query("SELECT TAB_RIRINT_CLASSIFICACAO.CLASSRIRINT_CODIGO, TAB_APOIO_TPVISITRIR_INTERF.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISITRIR_INTERF.DESCRICAO AS SUBTIPO, TAB_RIRINT_CLASSIFICACAO.CLASSRIRINT_DESCRICAO FROM TAB_RIRINT_CLASSIFICACAO LEFT OUTER JOIN TAB_APOIO_TPSUBVISITRIR_INTERF ON  TAB_RIRINT_CLASSIFICACAO.CLASSRIRINT_TIPO = TAB_APOIO_TPSUBVISITRIR_INTERF.ID LEFT OUTER JOIN TAB_APOIO_TPVISITRIR_INTERF ON TAB_APOIO_TPSUBVISITRIR_INTERF.ID_PRINCIPAL = TAB_APOIO_TPVISITRIR_INTERF.ID WHERE TAB_RIRINT_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_projetorir_interf=mysql_fetch_array($sql_projetorir_interf)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="28%"><?php echo $vetor_projetorir_interf['TIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="28%"><?php echo $vetor_projetorir_interf['SUBTIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="30%"><?php echo $vetor_projetorir_interf['CLASSRIRINT_DESCRICAO']; ?></td>
                            <td width="2%"></td>
                            <td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_evento_classrir_interf.php?id=<?php echo $vetor_projetorir_interf['CLASSRIRINT_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_evento_classrir_interf.php?id=<?php echo $vetor_projetorir_interf['CLASSRIRINT_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>

	                    <div id="view7">
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
                                $sql_tecnicosev = mysql_query("SELECT TAB_415421_TECNICOS.TECNICOS_CODIGO, TAB_APOIO_TECNICOS.DESCRICAO AS TECNICOS_TECNICO_DESC FROM TAB_415421_TECNICOS LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_415421_TECNICOS.TECNICOS_TECNICO = TAB_APOIO_TECNICOS.ID WHERE TAB_415421_TECNICOS.EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_tecnicosev=mysql_fetch_array($sql_tecnicosev)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                            ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="80%"><?php echo $vetor_tecnicosev['TECNICOS_TECNICO_DESC']; ?></td>
                            <td width="2%"></td>
                            <td width="18%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_excluir_evento_tecnico.php?id=<?php echo $vetor_tecnicosev['TECNICOS_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
	                    </div>
                    
                    	<div id="view8">
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
                                $sql_imagem = mysql_query("SELECT * FROM TAB_415421_IMAGENS WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_imagem=mysql_fetch_array($sql_imagem)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                            ?>
                            <tr bgcolor="<?php echo $cor; ?>">
                                <td width="40%"><?php echo $vetor_imagem['IMAGEM_LEGENDA']; ?></td>
                                <td width="2%"></td>
                                <td width="40%" align="center" valign="middle"><img src="imagens/<?php echo $vetor_imagem['IMAGEM_NOME']; ?>" width="200"></td>
                                <td width="2%"></td>
                                <td width="16%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_evento_imagem.php?id=<?php echo $vetor_imagem['IMAGEM_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_evento_imagem.php?id=<?php echo $vetor_imagem['IMAGEM_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                    	</div>

						<div id="view9">
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
							<div id="campoPaiEVEDOCS"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
							</br>
							<input type="button" value="Novo Documento" onClick="addCamposEVEDOCS()" class="btn btn-inline">
							</br></br>
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
									$sql_documentos = mysql_query("SELECT TAB_415421_EVENTOS_DOCS.EVEDOC_CODIGO, TAB_415421_EVENTOS_DOCS.EVEDOC_DATA, TAB_APOIO_TIPODOC.DESCRICAO AS EVEDOC_TIPO_DESC, TAB_415421_EVENTOS_DOCS.EVEDOC_DESCRICAO, TAB_415421_EVENTOS_DOCS.EVEDOC_ARQUIVO FROM TAB_415421_EVENTOS_DOCS LEFT OUTER JOIN TAB_APOIO_TIPODOC ON TAB_APOIO_TIPODOC.ID = TAB_415421_EVENTOS_DOCS.EVEDOC_TIPO WHERE TAB_415421_EVENTOS_DOCS.EVENTOS_CODIGO = '$id_evento' ORDER BY TAB_415421_EVENTOS_DOCS.EVEDOC_DATA DESC, EVEDOC_TIPO_DESC ASC;", $db) or die(mysql_error());
									$cor = "#D8D8D8";
									while ($vetor_documentos=mysql_fetch_array($sql_documentos)) {
										if (strcasecmp($cor, "#FFFFFF") == 0){
											$cor = "#D8D8D8";
										} else {
											$cor = "#FFFFFF";
										}
								?>
								<tr bgcolor="<?php echo $cor; ?>">
									<td width="10%" align="center"><?php echo date('d/m/Y', strtotime($vetor_documentos['EVEDOC_DATA'])); ?></td>
									<td width="1%"></td>
									<td width="30%"><?php echo $vetor_documentos['EVEDOC_TIPO_DESC']; ?></td>
									<td width="1%"></td>
									<td width="20%"><?php echo $vetor_documentos['EVEDOC_DESCRICAO']; ?></td>
									<td width="1%"></td>
									<td width="30%" align="center"><a href="docs/<?php echo $vetor_documentos['EVEDOC_ARQUIVO']; ?>" target="_blank">Salvar Arquivo</a></td>
									<td width="1%"></td>
                                	<td width="6%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_evento_documento.php?id=<?php echo $vetor_documentos['EVEDOC_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_evento_documento.php?id=<?php echo $vetor_documentos['EVEDOC_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
								</tr>
								<?php } ?>
							</table>
						</div> <!-- Documentos -->
							
                        <div id="view10">
                        <!-- <table width="100%">
                          <thead>
                            <td width="28%">Atividade</td>
                            <td width="2%"></td>
                            <td width="28%">SubAtividade</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='28%' class='style12'>
                            <select name="tiporir" id="tiporir" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("select * from TAB_APOIO_TPVISITRIR where ATIVO = 1 order by DESCRICAO ASC", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'></td>
							<td width='28%' class='style12'>
                            	<select name="subtiporir" id="subtiporir" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>
                            	<img src="imgs/if_system.png" name="btnPadraorir" class="float" width="20" height="20" border="0" />
                            </td>
                            <td width='30%'><textarea rows='4' class='form-control' name='CLASSRIR_DESCRICAO'></textarea></td>
                            <td width='10%' class='style12'></td>
                          </tr>
                        </table>
                        <br/>
                        <br/> --> <!-- Parte Superior Oculta -->
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
                                $sql_projetorir = mysql_query("SELECT TAB_RIR_CLASSIFICACAO.CLASSRIR_CODIGO, TAB_APOIO_TPVISITRIR.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISITRIR.DESCRICAO AS SUBTIPO, TAB_RIR_CLASSIFICACAO.CLASSRIR_DESCRICAO FROM TAB_RIR_CLASSIFICACAO LEFT OUTER JOIN TAB_APOIO_TPSUBVISITRIR ON  TAB_RIR_CLASSIFICACAO.CLASSRIR_TIPO = TAB_APOIO_TPSUBVISITRIR.ID LEFT OUTER JOIN TAB_APOIO_TPVISITRIR ON TAB_APOIO_TPSUBVISITRIR.ID_PRINCIPAL = TAB_APOIO_TPVISITRIR.ID WHERE TAB_RIR_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_projetorir=mysql_fetch_array($sql_projetorir)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="28%"><?php echo $vetor_projetorir['TIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="28%"><?php echo $vetor_projetorir['SUBTIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="30%"><?php echo $vetor_projetorir['CLASSRIR_DESCRICAO']; ?></td>
                            <td width="2%"></td>
                            <td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_evento_classrir.php?id=<?php echo $vetor_projetorir['CLASSRIR_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_excluir_evento_classrir.php?id=<?php echo $vetor_projetorir['CLASSRIR_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>
                    
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