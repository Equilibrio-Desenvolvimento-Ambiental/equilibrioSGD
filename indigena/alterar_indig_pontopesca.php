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
			$sqlFUSOS = mysql_query("SELECT * FROM TAB_APOIO_FUSOS WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sqlALDEIAS = mysql_query("SELECT TAB_APOIO_INDIG_ALDEIA.ID, CONCAT('ALDEIA: ',TAB_APOIO_INDIG_ALDEIA.DESCRICAO,' - TI: ',TAB_APOIO_INDIG_TI.DESCRICAO,' - ROTA: ',TAB_APOIO_INDIG_ROTA.DESCRICAO) AS NOME FROM TAB_APOIO_INDIG_ALDEIA LEFT OUTER JOIN TAB_INDIG_REL_TI_ALDEIA ON TAB_INDIG_REL_TI_ALDEIA.ALDEIA_ID = TAB_APOIO_INDIG_ALDEIA.ID LEFT OUTER JOIN TAB_APOIO_INDIG_TI ON TAB_INDIG_REL_TI_ALDEIA.TI_ID = TAB_APOIO_INDIG_TI.ID LEFT OUTER JOIN TAB_INDIG_REL_ROTA_TI ON TAB_INDIG_REL_ROTA_TI.TI_ID = TAB_APOIO_INDIG_TI.ID LEFT OUTER JOIN TAB_APOIO_INDIG_ROTA ON TAB_APOIO_INDIG_ROTA.ID = TAB_INDIG_REL_ROTA_TI.ROTA_ID WHERE TAB_APOIO_INDIG_ALDEIA.ID > 0 ORDER BY TAB_APOIO_INDIG_ALDEIA.DESCRICAO ASC, TAB_APOIO_INDIG_TI.DESCRICAO ASC, TAB_APOIO_INDIG_ROTA.DESCRICAO ASC;", $db) or die(mysql_error());
			$sqlEQUIP = mysql_query("SELECT * FROM TAB_APOIO_PESCA_EQUIP WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sqlESPECIES = mysql_query("SELECT * FROM TAB_APOIO_PESCA_ESPECIES WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
			$INDIG_PP_ID = $_GET['INDIG_PP_ID'];
			$sql = mysql_query("SELECT * FROM TAB_INDIG_PONTOPESCA WHERE INDIG_PP_ID = '$INDIG_PP_ID';", $db);
			$vetor = mysql_fetch_array($sql);
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
var qtdeCamposALDEIAS = 0;
function addCamposALDEIAS() {
var objPaiALDEIAS = document.getElementById("campoPaiALDEIAS");
var objFilhoALDEIAS = document.createElement("div");
objFilhoALDEIAS.setAttribute("id","filhoALDEIAS"+qtdeCamposALDEIAS);
objPaiALDEIAS.appendChild(objFilhoALDEIAS);
document.getElementById("filhoALDEIAS"+qtdeCamposALDEIAS).innerHTML = "<table width='100%' border='0'><tr><td width='80%' class='style12'><select name='INDIG_PPA_ALDEIA[]' id='INDIG_PPA_ALDEIA' class='form-control'><option value='0' selected='selected'>Selecione uma aldeia...</option><?php while ($vetorALDEIAS=mysql_fetch_array($sqlALDEIAS)) { ?><option value='<?php echo $vetorALDEIAS[ID]; ?>'><?php echo $vetorALDEIAS[NOME]; ?></option><?php } ?></select></td><td width='2%'></td><td width='18%' class='style12'><input type='button' onclick='removerCampoALDEIAS("+qtdeCamposALDEIAS+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposALDEIAS++;
}
function removerCampoALDEIAS(id) {
var objPaiALDEIAS = document.getElementById("campoPaiALDEIAS");
var objFilhoALDEIAS = document.getElementById("filhoALDEIAS"+id);
console.log(objPaiALDEIAS);
var removido = objPaiALDEIAS.removeChild(objFilhoALDEIAS);
}

var qtdeCamposEQUIP = 0;
function addCamposEQUIP() {
var objPaiEQUIP = document.getElementById("campoPaiEQUIP");
var objFilhoEQUIP = document.createElement("div");
objFilhoEQUIP.setAttribute("id","filhoEQUIP"+qtdeCamposEQUIP);
objPaiEQUIP.appendChild(objFilhoEQUIP);
document.getElementById("filhoEQUIP"+qtdeCamposEQUIP).innerHTML = "<table width='100%' border='0'><tr><td width='28%' class='style12'><input type='text' name='INDIG_PPE_DATAREG[]' id='INDIG_PPE_DATAREG' class='form-control' onKeyPress='mascara(this,mdata)' maxlength='10' placeholder='Digite as data...'></td><td width='2%'></td><td width='28%' class='style12'><select name='INDIG_PPE_ESPECIE[]' id='INDIG_PPE_ESPECIE' class='form-control'><option value='0' selected='selected'>Selecione uma espécie...</option><?php while ($vetorESPECIES=mysql_fetch_array($sqlESPECIES)) { ?><option value='<?php echo $vetorESPECIES[ID]; ?>'><?php echo $vetorESPECIES[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='28%' class='style12'><select name='INDIG_PPE_EQUIP[]' id='INDIG_PPE_EQUIP' class='form-control'><option value='0' selected='selected'>Selecione um equipamento...</option><?php while ($vetorEQUIP=mysql_fetch_array($sqlEQUIP)) { ?><option value='<?php echo $vetorEQUIP[ID]; ?>'><?php echo $vetorEQUIP[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%' class='style12'><input type='button' onclick='removerCampoEQUIP("+qtdeCamposEQUIP+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposEQUIP++;
}
function removerCampoEQUIP(id) {
var objPaiEQUIP = document.getElementById("campoPaiEQUIP");
var objFilhoEQUIP = document.getElementById("filhoEQUIP"+id);
console.log(objPaiEQUIP);
var removido = objPaiEQUIP.removeChild(objFilhoEQUIP);
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
							<h3>Projetos de Atividades Produtivas - PAP / Projeto de Pesca Para Comercialização</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Pontos de Pesca - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_alterar_indig_pontopesca.php?INDIG_PP_ID=<?php echo $INDIG_PP_ID; ?>" method="post" name="indig_pontopesca" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="form-label semibold" for="INDIG_PP_NOME">Nome do Ponto:</label>
                            <input type="text" name="INDIG_PP_NOME" class="form-control" id="INDIG_PP_NOME" placeholder="Digite o nome..." value="<?php echo $vetor['INDIG_PP_NOME']; ?>">
                        </div>
					</div>
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="form-label semibold" for="INDIG_PP_COORD_FUSO">Fuso:</label>
                            <select name="INDIG_PP_COORD_FUSO" id="INDIG_PP_COORD_FUSO" class="form-control">
                                <option value="0" selected="selected">Selecione um fuso...</option>
                                <?php while ($vetorFUSOS=mysql_fetch_array($sqlFUSOS)) { ?>
                                <option value="<?php echo $vetorFUSOS['ID'] ?>" <?php if (strcasecmp($vetor['INDIG_PP_COORD_FUSO'], $vetorFUSOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetorFUSOS['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label semibold" for="INDIG_PP_COORD_ESTE">Coord. E:</label>
							<input type="text" name="INDIG_PP_COORD_ESTE" id="INDIG_PP_COORD_ESTE" class="form-control" placeholder="Digite a coordenada..." value="<?php echo number_format($vetor['INDIG_PP_COORD_ESTE'],4,',',''); ?>">
						</div>
                        <div class="col-lg-3">
                            <label class="form-label semibold" for="INDIG_PP_COORD_NORTE">Coord. N:</label>
							<input type="text" name="INDIG_PP_COORD_NORTE" id="INDIG_PP_COORD_NORTE" class="form-control" placeholder="Digite a coordenada..." value="<?php echo number_format($vetor['INDIG_PP_COORD_NORTE'],4,',',''); ?>">
						</div>
                        <div class="col-lg-3">
                            <label class="form-label semibold" for="INDIG_PP_COORD_ALT">Altitude:</label>
							<input type="text" name="INDIG_PP_COORD_ALT" id="INDIG_PP_COORD_ALT" class="form-control" placeholder="Digite a coordenada..." value="<?php echo number_format($vetor['INDIG_PP_COORD_ALT'],4,',',''); ?>">
						</div>
                    </div>
                    </br>
                    <input name="salvar" type="image" src="imgs/salvar.png" class="float" />
                </form>
			</div><!--.box-typical-->
			<div class="box-typical box-typical-padding">
				<div style="width: 100%; margin: 0 auto;">
					<ul class="tabs" data-persist="true">
						<li><a href="#view1">Aldeias</a></li>
						<li><a href="#view2">Pescado/Produção</a></li>
						<li><a href="#view3">Equipamentos Utilizados</a></li>
					</ul>
					<div class="tabcontents">

                    	<div id="view1">
							<form action="recebe_indig_cadastrar_pontopesca_aldeia.php?INDIG_PP_ID=<?php echo $INDIG_PP_ID;?>" method="post" name="recebe_indig_cadastrar_pontopesca_aldeia" enctype="multipart/form-data" id="recebe_indig_cadastrar_pontopesca_aldeia">
                        	<table width="100%">
								<thead>
									<td width="80%">Aldeia / TI / Rota</td>
									<td width="2%"></td>
									<td width="18%">&nbsp;</td>
								</thead>
                        	</table>
                        	<div id="campoPaiALDEIAS"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div><br/>
                        	<input type="button" value="Adicionar" onClick="addCamposALDEIAS()" class="btn btn-inline"><br/><br/>
                        	<table width="100%">
								<thead>
									<td width="80%">Aldeia / TI / Rota</td>
									<td width="2%"></td>
									<td width="18%">Ações</td>
								</thead>
                           		<?php 
                                	$sqlPontosPesca_Aldeias = mysql_query("SELECT TAB_INDIG_PONTOPESCA_ALDEIA.INDIG_PPA_ID, TAB_INDIG_PONTOPESCA_ALDEIA.INDIG_PPA_PONTO, TAB_INDIG_PONTOPESCA_ALDEIA.INDIG_PPA_ALDEIA, CONCAT('ALDEIA: ',TAB_APOIO_INDIG_ALDEIA.DESCRICAO,' - TI: ',TAB_APOIO_INDIG_TI.DESCRICAO,' - ROTA: ',TAB_APOIO_INDIG_ROTA.DESCRICAO) AS NOME FROM TAB_INDIG_PONTOPESCA_ALDEIA LEFT OUTER JOIN TAB_APOIO_INDIG_ALDEIA ON TAB_APOIO_INDIG_ALDEIA.ID = TAB_INDIG_PONTOPESCA_ALDEIA.INDIG_PPA_ALDEIA LEFT OUTER JOIN TAB_INDIG_REL_TI_ALDEIA ON TAB_INDIG_REL_TI_ALDEIA.ALDEIA_ID = TAB_APOIO_INDIG_ALDEIA.ID LEFT OUTER JOIN TAB_APOIO_INDIG_TI ON TAB_INDIG_REL_TI_ALDEIA.TI_ID = TAB_APOIO_INDIG_TI.ID LEFT OUTER JOIN TAB_INDIG_REL_ROTA_TI ON TAB_INDIG_REL_ROTA_TI.TI_ID = TAB_APOIO_INDIG_TI.ID LEFT OUTER JOIN TAB_APOIO_INDIG_ROTA ON TAB_APOIO_INDIG_ROTA.ID = TAB_INDIG_REL_ROTA_TI.ROTA_ID WHERE TAB_INDIG_PONTOPESCA_ALDEIA.INDIG_PPA_PONTO = '$INDIG_PP_ID' ORDER BY TAB_APOIO_INDIG_ALDEIA.DESCRICAO ASC, TAB_APOIO_INDIG_TI.DESCRICAO ASC, TAB_APOIO_INDIG_ROTA.DESCRICAO ASC;", $db) or die(mysql_error());
									$cor = "#D8D8D8";
									while ($vetorPontosPesca_Aldeias=mysql_fetch_array($sqlPontosPesca_Aldeias)) {
										if (strcasecmp($cor, "#FFFFFF") == 0){
											$cor = "#D8D8D8";
										} else {
											$cor = "#FFFFFF";
										}
								?>
                            	<tr bgcolor="<?php echo $cor; ?>">
									<td width="80%"><?php echo $vetorPontosPesca_Aldeias['NOME']; ?></td><td width="2%"></td>
									<td width="18%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_pontopesca_aldeia.php?idRegistro=<?php echo $vetorPontosPesca_Aldeias['INDIG_PPA_ID']; ?>&INDIG_PP_ID=<?php echo $INDIG_PP_ID; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
							  	</tr>
                          		<?php } ?>
                        	</table><br/>
                        	<input name="pesq" type="image" src="imgs/salvar.png" class="float" />
							</form>
                    	</div>

						<div id="view2">&nbsp;</div>

						<div id="view3">
							<form action="recebe_indig_cadastrar_pontopesca_equip.php?INDIG_PP_ID=<?php echo $INDIG_PP_ID;?>" method="post" name="recebe_indig_cadastrar_pontopesca_equip" enctype="multipart/form-data" id="recebe_indig_cadastrar_pontopesca_equip">
                        	<table width="100%">
								<thead>
									<td width="28%">Data da Pesquisa</td>
									<td width="2%"></td>
									<td width="28%">Espécie</td>
									<td width="2%"></td>
									<td width="28%">Equipamento Utilizado</td>
									<td width="2%"></td>
									<td width="10%">&nbsp;</td>
								</thead>
                        	</table>
                        	<div id="campoPaiEQUIP"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div><br/>
                        	<input type="button" value="Adicionar" onClick="addCamposEQUIP()" class="btn btn-inline"><br/><br/>
                        	<table width="100%">
								<thead>
									<td width="28%">Data da Pesquisa</td>
									<td width="2%"></td>
									<td width="28%">Espécie</td>
									<td width="2%"></td>
									<td width="28%">Equipamento Utilizado</td>
									<td width="2%"></td>
									<td width="10%">Ações</td>
								</thead>
                           		<?php 
                                	$sqlPontosPesca_Equip = mysql_query("SELECT TAB_INDIG_PONTOPESCA_EQUIP.INDIG_PPE_ID, TAB_INDIG_PONTOPESCA_EQUIP.INDIG_PPE_PONTO, TAB_INDIG_PONTOPESCA_EQUIP.INDIG_PPE_DATAREG, TAB_APOIO_PESCA_ESPECIES.DESCRICAO AS INDIG_PPE_ESPECIE_DESC, TAB_APOIO_PESCA_EQUIP.DESCRICAO AS INDIG_PPE_EQUIP_DESC FROM TAB_INDIG_PONTOPESCA_EQUIP INNER JOIN TAB_APOIO_PESCA_ESPECIES ON TAB_INDIG_PONTOPESCA_EQUIP.INDIG_PPE_ESPECIE = TAB_APOIO_PESCA_ESPECIES.ID INNER JOIN TAB_APOIO_PESCA_EQUIP ON TAB_INDIG_PONTOPESCA_EQUIP.INDIG_PPE_EQUIP = TAB_APOIO_PESCA_EQUIP.ID WHERE TAB_INDIG_PONTOPESCA_EQUIP.INDIG_PPE_PONTO = '$INDIG_PP_ID' ORDER BY TAB_INDIG_PONTOPESCA_EQUIP.INDIG_PPE_DATAREG DESC, INDIG_PPE_ESPECIE_DESC ASC, INDIG_PPE_EQUIP_DESC ASC;", $db) or die(mysql_error());
									$cor = "#D8D8D8";
									while ($vetorPontosPesca_Equip=mysql_fetch_array($sqlPontosPesca_Equip)) {
										if (strcasecmp($cor, "#FFFFFF") == 0){
											$cor = "#D8D8D8";
										} else {
											$cor = "#FFFFFF";
										}
								?>
                            	<tr bgcolor="<?php echo $cor; ?>">
									<td width="28%" align="center" valign="middle"><?php echo date('d/m/Y', strtotime($vetorPontosPesca_Equip['INDIG_PPE_DATAREG'])); ?></td>
									<td width="2%"></td>
									<td width="28%" align="center" valign="middle"><?php echo $vetorPontosPesca_Equip['INDIG_PPE_ESPECIE_DESC']; ?></td>
									<td width="2%"></td>
									<td width="28%" align="center" valign="middle"><?php echo $vetorPontosPesca_Equip['INDIG_PPE_EQUIP_DESC']; ?></td>
									<td width="2%"></td>
									<td width="10%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_pontopesca_equip.php?idRegistro=<?php echo $vetorPontosPesca_Equip['INDIG_PPE_ID']; ?>&INDIG_PP_ID=<?php echo $INDIG_PP_ID; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
							  	</tr>
                          		<?php } ?>
                        	</table><br/>
                        	<input name="pesq" type="image" src="imgs/salvar.png" class="float" />
							</form>
                    	</div>
					
					</div>
                </div>
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