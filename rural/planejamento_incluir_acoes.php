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
			$id_visita = $_GET['id_visita'];
			$id_familia = $_GET['id_familia'];
			
			$sql_TPVISIT415 = mysql_query("select * from TAB_APOIO_TPVISIT415 order by DESCRICAO ASC", $db);
			$sql_TPVISIT421 = mysql_query("select * from TAB_APOIO_TPVISIT421 order by DESCRICAO ASC", $db);
			$sql_TPVISITRIR = mysql_query("select * from TAB_APOIO_TPVISITRIR order by DESCRICAO ASC", $db);
			$sql_TECNICOS = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC", $db);

			$sql_TPMATCONSUMO = mysql_query("select TAB_ADM_MATCONSUMO.MATCONS_ID, TAB_ADM_MATCONSUMO.MATCONS_NOME, TAB_APOIO_PROD_UNIT.DESCRICAO as MATCONS_UNIDADE_DESC from TAB_ADM_MATCONSUMO left outer join TAB_APOIO_PROD_UNIT on TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID order by TAB_ADM_MATCONSUMO.MATCONS_NOME asc;", $db);
			$sql_CCUSTO_CON = mysql_query("select * from TAB_ADM_CENTROCUSTO order by CCUSTO_CODIGO asc, CCUSTO_DESCRICAO asc;", $db);
			
			$sql_TPMATKITS = mysql_query("select * from TAB_ADM_MATKITS order by MATKIT_NOME ASC", $db);
			$sql_CCUSTO_KIT = mysql_query("select * from TAB_ADM_CENTROCUSTO order by CCUSTO_CODIGO asc, CCUSTO_DESCRICAO asc;", $db);
			
			$sql_TPMATUSO = mysql_query("SELECT tab_adm_matuso.MATUSO_ID, tab_adm_matuso.MATUSO_NOME, tab_apoio_prod_unit.DESCRICAO AS MATUSO_UNIDADE_DESC FROM tab_adm_matuso LEFT OUTER JOIN tab_apoio_prod_unit ON tab_apoio_prod_unit.ID = tab_adm_matuso.MATUSO_UNIDADE ORDER BY tab_adm_matuso.MATUSO_NOME ASC;", $db);
			$sql_CCUSTO_USO = mysql_query("select * from TAB_ADM_CENTROCUSTO order by CCUSTO_CODIGO asc, CCUSTO_DESCRICAO asc;", $db);
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
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
var qtdeCamposC = 0;
function addCamposC() {
var objPaiC = document.getElementById("campoPaiC");
//Criando o elemento DIV;
var objFilhoC = document.createElement("div");
//Definindo atributos ao objFilho:
objFilhoC.setAttribute("id","filhoC"+qtdeCamposC);
//Inserindo o elemento no pai:
objPaiC.appendChild(objFilhoC);
//Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filhoC"+qtdeCamposC).innerHTML = "<table width='100%' border='0'><tr><td width='80%' class='style12'><select name='PLANTEC_TECNICO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um Técnico...</option><?php while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) { ?><option value='<?php echo $vetor_TECNICOS[ID]; ?>'><?php echo $vetor_TECNICOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='18%' class='style12'><input type='button' onclick='removerCampoC("+qtdeCamposC+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposC++;
}
function removerCampoC(id) {
var objPaiC = document.getElementById("campoPaiC");
var objFilhoC = document.getElementById("filhoC"+id);
console.log(objPaiC);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPaiC.removeChild(objFilhoC);
}

var qtdeCamposMatConsumo = 0;
function addCamposMatConsumo() {
var objPaiMatConsumo = document.getElementById("campoPaiMatConsumo");
//Criando o elemento DIV;
var objFilhoMatConsumo = document.createElement("div");
//Definindo atributos ao objFilho:
objFilhoMatConsumo.setAttribute("id","filhoMatConsumo"+qtdeCamposMatConsumo);
//Inserindo o elemento no pai:
objPaiMatConsumo.appendChild(objFilhoMatConsumo);
//Escrevendo algo no filho recém-criado:
document.getElementById("filhoMatConsumo"+qtdeCamposMatConsumo).innerHTML = "<table width='100%' border='0'><tr><td width='35%' class='style12'><select name='PLANMATC_TIPO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um Material...</option><?php while ($vetor_TPMATCONSUMO=mysql_fetch_array($sql_TPMATCONSUMO)) { ?><option value='<?php echo $vetor_TPMATCONSUMO[MATCONS_ID]; ?>'><?php echo $vetor_TPMATCONSUMO[MATCONS_NOME].' ('.$vetor_TPMATCONSUMO[MATCONS_UNIDADE_DESC].')'; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='15%' class='style12'><input type=text name='PLANMATC_QTDE[]' class='form-control' id='exampleInput' placeholder='Quantidade...'><td width='2%' class='style12'></td><td width='35%' class='style12'><select name='PLANMATC_CCUSTO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um Centro de Custo...</option><?php while ($vetor_CCUSTO_CON=mysql_fetch_array($sql_CCUSTO_CON)) { ?><option value='<?php echo $vetor_CCUSTO_CON[CCUSTO_ID]; ?>'><?php echo $vetor_CCUSTO_CON[CCUSTO_CODIGO].' - '.$vetor_CCUSTO_CON[CCUSTO_DESCRICAO]; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='9%' class='style12'><input type='button' onclick='removerCampoMatConsumo("+qtdeCamposMatConsumo+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposMatConsumo++;
}
function removerCampoMatConsumo(id) {
var objPaiMatConsumo = document.getElementById("campoPaiMatConsumo");
var objFilhoMatConsumo = document.getElementById("filhoMatConsumo"+id);
console.log(objPaiMatConsumo);
//Removendo o DIV com id específico:
var removido = objPaiMatConsumo.removeChild(objFilhoMatConsumo);
}

var qtdeCamposMatKits = 0;
function addCamposMatKits() {
var objPaiMatKits = document.getElementById("campoPaiMatKits");
//Criando o elemento DIV;
var objFilhoMatKits = document.createElement("div");
//Definindo atributos ao objFilho:
objFilhoMatKits.setAttribute("id","filhoMatKits"+qtdeCamposMatKits);
//Inserindo o elemento no pai:
objPaiMatKits.appendChild(objFilhoMatKits);
//Escrevendo algo no filho recém-criado:
document.getElementById("filhoMatKits"+qtdeCamposMatKits).innerHTML = "<table width='100%' border='0'><tr><td width='35%' class='style12'><select name='PLANMATK_TIPO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um Kit...</option><?php while ($vetor_TPMATKITS=mysql_fetch_array($sql_TPMATKITS)) { ?><option value='<?php echo $vetor_TPMATKITS[MATKIT_ID]; ?>'><?php echo $vetor_TPMATKITS[MATKIT_NOME]; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='15%' class='style12'><input type='text' name='PLANMATK_QTDE[]' class='form-control' id='exampleInput' placeholder='Quantidade...'><td width='2%' class='style12'></td><td width='35%' class='style12'><select name='PLANMATK_CCUSTO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um Centro de Custo...</option><?php while ($vetor_CCUSTO_KIT=mysql_fetch_array($sql_CCUSTO_KIT)) { ?><option value='<?php echo $vetor_CCUSTO_KIT[CCUSTO_ID]; ?>'><?php echo $vetor_CCUSTO_KIT[CCUSTO_CODIGO].' - '.$vetor_CCUSTO_KIT[CCUSTO_DESCRICAO]; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='9%' class='style12'><input type='button' onclick='removerCampoMatKits("+qtdeCamposMatKits+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposMatKits++;
}
function removerCampoMatKits(id) {
var objPaiMatKits = document.getElementById("campoPaiMatKits");
var objFilhoMatKits = document.getElementById("filhoMatKits"+id);
console.log(objPaiMatKits);
//Removendo o DIV com id específico:
var removido = objPaiMatKits.removeChild(objFilhoMatKits);
}

var qtdeCamposMatUsos = 0;
function addCamposMatUsos() {
var objPaiMatUsos = document.getElementById("campoPaiMatUsos");
//Criando o elemento DIV;
var objFilhoMatUsos = document.createElement("div");
//Definindo atributos ao objFilho:
objFilhoMatUsos.setAttribute("id","filhoMatUsos"+qtdeCamposMatUsos);
//Inserindo o elemento no pai:
objPaiMatUsos.appendChild(objFilhoMatUsos);
//Escrevendo algo no filho recém-criado:
document.getElementById("filhoMatUsos"+qtdeCamposMatUsos).innerHTML = "<table width='100%' border='0'><tr><td width='35%' class='style12'><select name='PLANMATU_TIPO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um Material...</option><?php while ($vetor_TPMATUSO=mysql_fetch_array($sql_TPMATUSO)) { ?><option value='<?php echo $vetor_TPMATUSO[MATUSO_ID]; ?>'><?php echo $vetor_TPMATUSO[MATUSO_NOME].' ('.$vetor_TPMATUSO[MATUSO_UNIDADE_DESC].')'; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='15%' class='style12'><input type='text' name='PLANMATU_QTDE[]' class='form-control' id='exampleInput' placeholder='Quantidade...'><td width='2%' class='style12'></td><td width='35%' class='style12'><select name='PLANMATU_CCUSTO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um Centro de Custo...</option><?php while ($vetor_CCUSTO_USO=mysql_fetch_array($sql_CCUSTO_USO)) { ?><option value='<?php echo $vetor_CCUSTO_USO[CCUSTO_ID]; ?>'><?php echo $vetor_CCUSTO_USO[CCUSTO_CODIGO].' - '.$vetor_CCUSTO_USO[CCUSTO_DESCRICAO]; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='9%' class='style12'><input type='button' onclick='removerCampoMatUsos("+qtdeCamposMatUsos+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposMatUsos++;
}
function removerCampoMatUsos(id) {
var objPaiMatUsos = document.getElementById("campoPaiMatUsos");
var objFilhoMatUsos = document.getElementById("filhoMatUsos"+id);
console.log(objPaiMatUsos);
//Removendo o DIV com id específico:
var removido = objPaiMatUsos.removeChild(objFilhoMatUsos);
}

$(document).ready(function(){
	$('#tipo415').change(function(){
		$('#subtipo415').load('busca415.php?id='+$('#tipo415').val());
    })
	$('#tipo421').change(function(){
		$('#subtipo421').load('busca421.php?id='+$('#tipo421').val());
	});
	$('#tiporir').change(function(){
		$('#subtiporir').load('buscarir.php?id='+$('#tiporir').val());
	});
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
							<h3>Gestão do Projetos 4.1.5/4.2.1/Ribeirinhos - Reparação Rural e ATES</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Ações Planejadas para a Visita Técnica - v.1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_cadastrar_acoes_visitas.php?id_visita=<?php echo $id_visita; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="tp_acoes_visitas" enctype="multipart/form-data" id="formID">
                    <div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">Ações do Projeto 4.1.5</a></li>
                            <li><a href="#view2">Ações do Projeto 4.2.1</a></li>
                            <li><a href="#view3">Ações do Projeto Ribeirinhos</a></li>
                            <li><a href="#view4">Técnicos Responsáveis</a></li>
                            <li><a href="#view5">Mat. de Entrega</a></li>
                            <li><a href="#view6">Kits</a></li>
                            <li><a href="#view7">Ferramentas</a></li>
                        </ul>

	                    <div class="tabcontents">
                    
                        <div id="view1">
                        <table width="100%">
                          <thead>
                            <td width="43%">Tipo de Visita do Projeto 4.1.5</td>
                            <td width="2%">&nbsp;</td>
                            <td width="43%">SubTipo de Visita do Projeto 4.1.5</td>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">&nbsp;</td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='43%' class='style12'>
                            <select name="tipo415" id="tipo415" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("select * from TAB_APOIO_TPVISIT415 where ATIVO = 1 order by DESCRICAO ASC", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'>&nbsp;</td>
							<td width='43%' class='style12'>
                            	<select name="subtipo415" id="subtipo415" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>&nbsp;</td>
                            <td width='10%' class='style12'>&nbsp;</td>
                          </tr>
                        </table>
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="43%">Tipo de Visita do Projeto 4.1.5</td>
                            <td width="2%"></td>
                            <td width="43%">SubTipo de Visita do Projeto 4.1.5</td>
                            <td width="2%"></td>
                            <td width="10%">Ações</td>
                          </thead>
                          <?php 
                                $sql_projeto415 = mysql_query("select TAB_415_PLANVISITAS.PLAN415_CODIGO, TAB_415_PLANVISITAS.PLAN_VISIT_ID, TAB_415_PLANVISITAS.PLAN415_TIPO, TAB_APOIO_TPVISIT415.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISIT415.DESCRICAO AS SUBTIPO from TAB_415_PLANVISITAS left outer join TAB_APOIO_TPSUBVISIT415 on TAB_415_PLANVISITAS.PLAN415_TIPO = TAB_APOIO_TPSUBVISIT415.ID left outer join TAB_APOIO_TPVISIT415 on TAB_APOIO_TPSUBVISIT415.ID_PRINCIPAL = TAB_APOIO_TPVISIT415.ID where TAB_415_PLANVISITAS.PLAN_VISIT_ID = '$id_visita';", $db);
								$cor = "#D8D8D8";
                                while ($vetor_projeto415=mysql_fetch_array($sql_projeto415)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="43%"><?php echo $vetor_projeto415['TIPO']; ?></td>
                            <td width="2%">&nbsp;</td>
                            <td width="43%"><?php echo $vetor_projeto415['SUBTIPO']; ?></td>
                            <td width="2%">&nbsp;</td>
                            <td width="10%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_excluir_acao_plan415.php?id=<?php echo $vetor_projeto415['PLAN415_CODIGO']; ?>&id_visita=<?php echo $id_visita; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>

                    	<div id="view2">
                        <table width="100%">
                          <thead>
                            <td width="43%">Tipo de Visita do Projeto 4.2.1</td>
                            <td width="2%">&nbsp;</td>
                            <td width="43%">SubTipo de Visita do Projeto 4.2.1</td>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">&nbsp;</td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='43%' class='style12'>
                            <select name="tipo421" id="tipo421" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("select * from TAB_APOIO_TPVISIT421 where ATIVO = 1 order by DESCRICAO ASC", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'>&nbsp;</td>
							<td width='43%' class='style12'>
                            	<select name="subtipo421" id="subtipo421" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>&nbsp;</td>
                            <td width='10%' class='style12'>&nbsp;</td>
                          </tr>                        
                        </table>
                        <br/>
						<br/>
                        <table width="100%">
                          <thead>
                            <td width="43%">Tipo de Visita do Projeto 4.2.1</td>
                            <td width="2%">&nbsp;</td>
                            <td width="43%">SubTipo de Visita do Projeto 4.2.1</td>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">Ações</td>
                          </thead>
                          <?php 
                                $sql_projeto421 = mysql_query("select TAB_421_PLANVISITAS.PLAN421_CODIGO, TAB_421_PLANVISITAS.PLAN_VISIT_ID, TAB_421_PLANVISITAS.PLAN421_TIPO, TAB_APOIO_TPVISIT421.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISIT421.DESCRICAO AS SUBTIPO from TAB_421_PLANVISITAS left outer join TAB_APOIO_TPSUBVISIT421 on TAB_421_PLANVISITAS.PLAN421_TIPO = TAB_APOIO_TPSUBVISIT421.ID left outer join TAB_APOIO_TPVISIT421 on TAB_APOIO_TPSUBVISIT421.ID_PRINCIPAL = TAB_APOIO_TPVISIT421.ID where TAB_421_PLANVISITAS.PLAN_VISIT_ID = '$id_visita';", $db);
								$cor = "#D8D8D8";
                                while ($vetor_projeto421=mysql_fetch_array($sql_projeto421)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="43%"><?php echo $vetor_projeto421['TIPO']; ?></td>
                            <td width="2%">&nbsp;</td>
                            <td width="43%"><?php echo $vetor_projeto421['SUBTIPO']; ?></td>
                            <td width="2%">&nbsp;</td>
                            <td width="10%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_excluir_acao_plan421.php?id=<?php echo $vetor_projeto421['PLAN421_CODIGO']; ?>&id_visita=<?php echo $id_visita; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                    	</div>

                        <div id="view3">
                        <table width="100%">
                          <thead>
                            <td width="43%">Tipo de Visita Ribeirinhos</td>
                            <td width="2%">&nbsp;</td>
                            <td width="43%">SubTipo de Visita Ribeirinhos</td>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">&nbsp;</td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='43%' class='style12'>
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
                            <td width='2%' class='style12'>&nbsp;</td>
							<td width='43%' class='style12'>
                            	<select name="subtiporir" id="subtiporir" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>&nbsp;</td>
                            <td width='10%' class='style12'>&nbsp;</td>
                          </tr>
                        </table>
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="43%">Tipo de Visita Ribeirinhos</td>
                            <td width="2%">&nbsp;</td>
                            <td width="43%">SubTipo de Visita Ribeirinhos</td>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">Ações</td>
                          </thead>
                          <?php 
                                $sql_projetorir = mysql_query("select TAB_RIR_PLANVISITAS.PLANRIR_CODIGO, TAB_RIR_PLANVISITAS.PLAN_VISIT_ID, TAB_RIR_PLANVISITAS.PLANRIR_TIPO, TAB_APOIO_TPVISITRIR.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISITRIR.DESCRICAO AS SUBTIPO from TAB_RIR_PLANVISITAS left outer join TAB_APOIO_TPSUBVISITRIR on TAB_RIR_PLANVISITAS.PLANRIR_TIPO = TAB_APOIO_TPSUBVISITRIR.ID left outer join TAB_APOIO_TPVISITRIR on TAB_APOIO_TPSUBVISITRIR.ID_PRINCIPAL = TAB_APOIO_TPVISITRIR.ID where TAB_RIR_PLANVISITAS.PLAN_VISIT_ID = '$id_visita';", $db);
								$cor = "#D8D8D8";
                                while ($vetor_projetorir=mysql_fetch_array($sql_projetorir)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="43%"><?php echo $vetor_projetorir['TIPO']; ?></td>
                            <td width="2%">&nbsp;</td>
                            <td width="43%"><?php echo $vetor_projetorir['SUBTIPO']; ?></td>
                            <td width="2%">&nbsp;</td>
                            <td width="10%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_excluir_acao_planrir.php?id=<?php echo $vetor_projetorir['PLANRIR_CODIGO']; ?>&id_visita=<?php echo $id_visita; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>
                    
	                    <div id="view4">
                        <table width="100%">
                          <thead>
                            <td width="88%">Técnico(s) Responsável(is)</td>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">&nbsp;</td>
                          </thead>
                        </table>
                        <div id="campoPaiC"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                        <br/>
                        <input type="button" value="Adicionar" onClick="addCamposC()" class="btn btn-inline">
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="88%">Técnicos Responsáveis</td>
                            <td width="2%">&nbsp;</td>
                            <td width="10%">Ações</td>
                          </thead>
                            <?php
                                $sql_tecnicosev = mysql_query("select a.*, b.DESCRICAO as PLANTEC_TECNICO_DESC from TAB_415421_PLANTECNICOS a, TAB_APOIO_TECNICOS b where a.PLANTEC_TECNICO = b.ID and a.PLAN_VISIT_ID = '$id_visita';", $db);
								$cor = "#D8D8D8";
                                while ($vetor_tecnicosev=mysql_fetch_array($sql_tecnicosev)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                            ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="88%"><?php echo $vetor_tecnicosev['PLANTEC_TECNICO_DESC']; ?></td>
                            <td width="2%"></td>
                            <td width="10%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_excluir_acao_tecnico.php?id=<?php echo $vetor_tecnicosev['PLANTEC_CODIGO']; ?>&id_visita=<?php echo $id_visita; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
	                    </div>

	                    <div id="view5">
                        	<table width="100%">
                            	<thead>
                                	<td width="35%">Tipo(s) de Produto</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="15%">Quantidade</td>
                                    <td width="2%">&nbsp;</td>
                                	<td width="35%">Centro de Custo</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="9%">&nbsp;</td>
                                </thead>
                            </table>
                            <div id="campoPaiMatConsumo"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                            <br/>
                            <input type="button" value="Adicionar" onClick="addCamposMatConsumo()" class="btn btn-inline">
                            <br/><br/>
                            <table width="100%">
                            	<thead>
                                	<td width="35%">Tipo(s) de Produto</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="15%">Quantidade</td>
                                    <td width="2%">&nbsp;</td>
                                	<td width="35%">Centro de Custo</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="9%">&nbsp;</td>
                                </thead>
                                <?php
									$sql_PLANMAT_CONSUMO = mysql_query("SELECT TAB_415421_PLANMAT_CONSUMO.PLANMATC_CODIGO, TAB_415421_PLANMAT_CONSUMO.PLAN_VISIT_ID, TAB_ADM_MATCONSUMO.MATCONS_NOME AS PLANMATC_TIPO_DESCRICAO, TAB_APOIO_PROD_UNIT.DESCRICAO AS PLANMATC_TIPO_UNIDADE, TAB_415421_PLANMAT_CONSUMO.PLANMATC_QTDE, TAB_ADM_CENTROCUSTO.CCUSTO_CODIGO AS PLANMATC_TIPO_CCUSTO_COD, TAB_ADM_CENTROCUSTO.CCUSTO_DESCRICAO AS PLANMATC_TIPO_CCUSTO_DESC FROM TAB_415421_PLANMAT_CONSUMO LEFT OUTER JOIN TAB_ADM_MATCONSUMO ON TAB_415421_PLANMAT_CONSUMO.PLANMATC_TIPO = TAB_ADM_MATCONSUMO.MATCONS_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID LEFT OUTER JOIN TAB_ADM_CENTROCUSTO ON TAB_415421_PLANMAT_CONSUMO.PLANMATC_CCUSTO = TAB_ADM_CENTROCUSTO.CCUSTO_ID WHERE TAB_415421_PLANMAT_CONSUMO.PLAN_VISIT_ID = '$id_visita' ORDER BY PLANMATC_TIPO_DESCRICAO ASC, PLANMATC_TIPO_CCUSTO_COD ASC;", $db);
                                            $cor = "#D8D8D8";
                                            while ($vetor_PLANMAT_CONSUMO=mysql_fetch_array($sql_PLANMAT_CONSUMO)) {
                                                if (strcasecmp($cor, "#FFFFFF") == 0){
                                                    $cor = "#D8D8D8";
                                                } else {
                                                    $cor = "#FFFFFF";
                                                }
                                        ?>
                                      <tr bgcolor="<?php echo $cor; ?>">
                                        <td width="35%"><?php echo $vetor_PLANMAT_CONSUMO['PLANMATC_TIPO_DESCRICAO'].' ('.$vetor_PLANMAT_CONSUMO['PLANMATC_TIPO_UNIDADE'].')'; ?></td>
                                        <td width="2%"></td>
                                        <td width="15%" align="center"><?php echo $vetor_PLANMAT_CONSUMO['PLANMATC_QTDE']; ?></td>
                                        <td width="2%"></td>
                                        <td width="35%"><?php echo $vetor_PLANMAT_CONSUMO['PLANMATC_TIPO_CCUSTO_COD'].' - '.$vetor_PLANMAT_CONSUMO['PLANMATC_TIPO_CCUSTO_DESC']; ?></td>
                                        <td width="2%"></td>
                                        <td width="9%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_excluir_planmatc.php?id=<?php echo $vetor_PLANMAT_CONSUMO['PLANMATC_CODIGO']; ?>&id_visita=<?php echo $id_visita; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                                      </tr>
                                      <?php } ?>
                                    </table>
                                </div>
        
                        <div id="view6">
                        	<table width="100%">
                            	<thead>
                                	<td width="35%">Kit(s) Completo(s)</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="15%">Quantidade</td>
                                    <td width="2%">&nbsp;</td>
                                	<td width="35%">Centro de Custo</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="9%">&nbsp;</td>
                                </thead>
                            </table>
                            <div id="campoPaiMatKits"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                            <br/>
                            <input type="button" value="Adicionar" onClick="addCamposMatKits()" class="btn btn-inline">
                            <br/><br/>
                            <table width="100%">
                            	<thead>
                                	<td width="35%">Kit(s) Completo(s)</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="15%">Quantidade</td>
                                    <td width="2%">&nbsp;</td>
                                	<td width="35%">Centro de Custo</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="9%">&nbsp;</td>
                                </thead>
                                <?php
									$sql_PLANMAT_KITS = mysql_query("SELECT TAB_415421_PLANMAT_KITS.PLANMATK_CODIGO, TAB_415421_PLANMAT_KITS.PLAN_VISIT_ID, TAB_ADM_MATKITS.MATKIT_NOME AS PLANMATK_TIPO_DESCRICAO, TAB_415421_PLANMAT_KITS.PLANMATK_QTDE, TAB_ADM_CENTROCUSTO.CCUSTO_CODIGO AS PLANMATK_TIPO_CCUSTO_COD, TAB_ADM_CENTROCUSTO.CCUSTO_DESCRICAO AS PLANMATK_TIPO_CCUSTO_DESC FROM TAB_415421_PLANMAT_KITS LEFT OUTER JOIN TAB_ADM_MATKITS ON TAB_415421_PLANMAT_KITS.PLANMATK_TIPO = TAB_ADM_MATKITS.MATKIT_ID LEFT OUTER JOIN TAB_ADM_CENTROCUSTO ON TAB_415421_PLANMAT_KITS.PLANMATK_CCUSTO = TAB_ADM_CENTROCUSTO.CCUSTO_ID WHERE TAB_415421_PLANMAT_KITS.PLAN_VISIT_ID = '$id_visita' ORDER BY PLANMATK_TIPO_DESCRICAO ASC, PLANMATK_TIPO_CCUSTO_COD ASC;", $db);
                                            $cor = "#D8D8D8";
                                            while ($vetor_PLANMAT_KITS=mysql_fetch_array($sql_PLANMAT_KITS)) {
                                                if (strcasecmp($cor, "#FFFFFF") == 0){
                                                    $cor = "#D8D8D8";
                                                } else {
                                                    $cor = "#FFFFFF";
                                                }
                                        ?>
                                      <tr bgcolor="<?php echo $cor; ?>">
                                        <td width="35%"><?php echo $vetor_PLANMAT_KITS['PLANMATK_TIPO_DESCRICAO']; ?></td>
                                        <td width="2%"></td>
                                        <td width="15%" align="center"><?php echo $vetor_PLANMAT_KITS['PLANMATK_QTDE']; ?></td>
                                        <td width="2%"></td>
                                        <td width="35%"><?php echo $vetor_PLANMAT_KITS['PLANMATK_TIPO_CCUSTO_COD'].' - '.$vetor_PLANMAT_KITS['PLANMATK_TIPO_CCUSTO_DESC']; ?></td>
                                        <td width="2%"></td>
                                        <td width="9%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_excluir_planmatk.php?id=<?php echo $vetor_PLANMAT_KITS['PLANMATK_CODIGO']; ?>&id_visita=<?php echo $id_visita; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                                      </tr>
                                      <?php } ?>
                                    </table>
                                </div>

                        <div id="view7">
                        	<table width="100%">
                            	<thead>
                                	<td width="35%">Tipo(s) de Ferramenta(s)</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="15%">Quantidade</td>
                                    <td width="2%">&nbsp;</td>
                                	<td width="35%">Centro de Custo</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="9%">&nbsp;</td>
                                </thead>
                            </table>
                            <div id="campoPaiMatUsos"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                            <br/>
                            <input type="button" value="Adicionar" onClick="addCamposMatUsos()" class="btn btn-inline">
                            <br/><br/>
                            <table width="100%">
                            	<thead>
                                	<td width="35%">Tipo(s) de Ferramenta(s)</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="15%">Quantidade</td>
                                    <td width="2%">&nbsp;</td>
                                	<td width="35%">Centro de Custo</td>
                                    <td width="2%">&nbsp;</td>
                                    <td width="9%">&nbsp;</td>
                                </thead>
                                <?php
									$sql_PLANMAT_USO = mysql_query("SELECT TAB_415421_PLANMAT_USO.PLANMATU_CODIGO, TAB_415421_PLANMAT_USO.PLAN_VISIT_ID, TAB_ADM_MATUSO.MATUSO_NOME AS PLANMATU_TIPO_DESCRICAO, TAB_APOIO_PROD_UNIT.DESCRICAO AS PLANMATU_TIPO_UNIDADE, TAB_415421_PLANMAT_USO.PLANMATU_QTDE, TAB_ADM_CENTROCUSTO.CCUSTO_CODIGO AS PLANMATU_TIPO_CCUSTO_COD, TAB_ADM_CENTROCUSTO.CCUSTO_DESCRICAO AS PLANMATU_TIPO_CCUSTO_DESC FROM TAB_415421_PLANMAT_USO LEFT OUTER JOIN TAB_ADM_MATUSO ON TAB_415421_PLANMAT_USO.PLANMATU_TIPO = TAB_ADM_MATUSO.MATUSO_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATUSO.MATUSO_UNIDADE = TAB_APOIO_PROD_UNIT.ID LEFT OUTER JOIN TAB_ADM_CENTROCUSTO ON TAB_415421_PLANMAT_USO.PLANMATU_CCUSTO = TAB_ADM_CENTROCUSTO.CCUSTO_ID WHERE TAB_415421_PLANMAT_USO.PLAN_VISIT_ID = '$id_visita' ORDER BY PLANMATU_TIPO_DESCRICAO ASC, PLANMATU_TIPO_CCUSTO_COD ASC;", $db);
                                            $cor = "#D8D8D8";
                                            while ($vetor_PLANMAT_USO=mysql_fetch_array($sql_PLANMAT_USO)) {
                                                if (strcasecmp($cor, "#FFFFFF") == 0){
                                                    $cor = "#D8D8D8";
                                                } else {
                                                    $cor = "#FFFFFF";
                                                }
                                        ?>
                                      <tr bgcolor="<?php echo $cor; ?>">
                                        <td width="35%"><?php echo $vetor_PLANMAT_USO['PLANMATU_TIPO_DESCRICAO'].' ('.$vetor_PLANMAT_USO['PLANMATU_TIPO_UNIDADE'].')'; ?></td>
                                        <td width="2%"></td>
                                        <td width="15%" align="center"><?php echo $vetor_PLANMAT_USO['PLANMATU_QTDE']; ?></td>
                                        <td width="2%"></td>
                                        <td width="35%"><?php echo $vetor_PLANMAT_USO['PLANMATU_TIPO_CCUSTO_COD'].' - '.$vetor_PLANMAT_USO['PLANMATU_TIPO_CCUSTO_DESC']; ?></td>
                                        <td width="2%"></td>
                                        <td width="9%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_excluir_planmatu.php?id=<?php echo $vetor_PLANMAT_USO['PLANMATU_CODIGO']; ?>&id_visita=<?php echo $id_visita; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
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