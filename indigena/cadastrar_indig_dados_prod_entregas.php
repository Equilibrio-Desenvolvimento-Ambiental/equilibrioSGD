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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$idEntrega = $_GET['idEntrega'];
			$idAldeia = $_GET['idAldeia'];
			
			$sql_PROD_ENTREGA = mysql_query("SELECT * FROM TAB_INDIG_PROD_ENTREGAS WHERE INDIG_MOVENT_ID = '$idEntrega';", $db) or die(mysql_error());
			$vetor_PROD_ENTREGA = mysql_fetch_array($sql_PROD_ENTREGA);
			$sql_PROD_IMAGENS = mysql_query("SELECT * FROM TAB_FISH_ACOMP_PERCEPCAO WHERE FISH_AEP_AE = '$id_camp';", $db) or die(mysql_error());
			$vetor_PROD_IMAGENS = mysql_fetch_array($sql_PROD_IMAGENS);

			$sql_TECNICO = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_PESCADOR = mysql_query("SELECT * FROM TAB_INDIG_FAMILIAS WHERE INDIG_FAM_ALDEIA = '$idAldeia' ORDER BY INDIG_FAM_NOME ASC;", $db) or die(mysql_error());
			$sql_ESPECIES = mysql_query("SELECT * FROM TAB_APOIO_PESCA_ESPECIES WHERE ID > '0' ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
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
var qtdeCamposD = 0;
function addCamposD() {
var objPaiD = document.getElementById("campoPaiD");
var objFilhoD = document.createElement("div");
objFilhoD.setAttribute("id","filhoD"+qtdeCamposD);
objPaiD.appendChild(objFilhoD);
document.getElementById("filhoD"+qtdeCamposD).innerHTML = "<table width='100%' border='0'><tr><td width='40%' class='style12'><input type='text' name='INDIG_MOVIMG_LEGENDA[]' class='form-control'></td><td width='2%' class='style12'></td><td width='40%'><input type='file' name='INDIG_MOVIMG_NOME[]' class='form-control'></td><td width='2%' class='style12'></td><td width='16%' class='style12'><input type='button' onclick='removerCampoD("+qtdeCamposD+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposD++;
}
function removerCampoD(id) {
var objPaiD = document.getElementById("campoPaiD");
var objFilhoD = document.getElementById("filhoD"+id);
console.log(objPaiD);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPaiD.removeChild(objFilhoD);
}

var qtdeCamposC = 0;
function addCamposC() {
var objPaiC = document.getElementById("campoPaiC");
var objFilhoC = document.createElement("div");
objFilhoC.setAttribute("id","filhoC"+qtdeCamposC);
objPaiC.appendChild(objFilhoC);
document.getElementById("filhoC"+qtdeCamposC).innerHTML = "<table width='100%' border='0'><tr><td width='14%' class='style12'><select name='INDIG_MOVPES_PESCADOR[]' id='INDIG_MOVPES_PESCADOR' class='form-control'><option value='0' selected='selected'>Selecione um Pescador...</option><?php while ($vetor_PESCADOR=mysql_fetch_array($sql_PESCADOR)) { ?><option value='<?php echo $vetor_PESCADOR[INDIG_FAM_ID]; ?>'><?php echo $vetor_PESCADOR[INDIG_FAM_NOME]; ?></option><?php } ?></select></td><td width='1%' class='style12'></td><td width='14%' class='style12'><select name='INDIG_MOVPES_ESPECIE[]' id='INDIG_MOVPES_ESPECIE' class='form-control'><option value='0' selected='selected'>Selecione uma Espécie...</option><?php while ($vetor_ESPECIES=mysql_fetch_array($sql_ESPECIES)) { ?><option value='<?php echo $vetor_ESPECIES[ID]; ?>'><?php echo $vetor_ESPECIES[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%' class='style12'></td><td width='14%' class='style12'><input type='text' name='INDIG_MOVPES_QTDE[]' id='INDIG_MOVPES_QTDE' class='form-control' placeholder='Quantidade...' onKeyPress='mascara(this,mvalor)' maxlength='10'></td><td width='1%' class='style12'></td><td width='14%' class='style12'><input type='text' name='INDIG_MOVPES_VALOR[]' id='INDIG_MOVPES_VALOR' class='form-control' placeholder='Valor (KG)...' onKeyPress='mascara(this,mvalor)' maxlength='10'></td><td width='1%' class='style12'></td><td width='14%' class='style12'><input type='text' name='INDIG_MOVPES_TT_DEVIDO[]' id='INDIG_MOVPES_TT_DEVIDO' class='form-control' placeholder='Valor devido...' onKeyPress='mascara(this,mvalor)' maxlength='10'></td><td width='1%' class='style12'></td><td width='14%' class='style12'><input type='text' name='INDIG_MOVPES_TT_PAGO[]' id='INDIG_MOVPES_TT_PAGO' class='form-control' placeholder='Valor pago...' onKeyPress='mascara(this,mvalor)' maxlength='10'></td><td width='1%' class='style12'></td><td width='10%' class='style12'><input type='button' onclick='removerCampoC("+qtdeCamposC+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposC++;
}
function removerCampoC(id) {
var objPaiC = document.getElementById("campoPaiC");
var objFilhoC = document.getElementById("filhoC"+id);
console.log(objPaiC);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPaiC.removeChild(objFilhoC);
}

	
$(document).ready(function(){
	$('#tipoFish').change(function(){
		$('#subtipoFish').load('buscaFish.php?id='+$('#tipoFish').val());
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
							<h3>Projetos de Atividades Produtivas - PAP / Projeto de Pesca Para Comercialização</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Dados da Entrega - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<div style="width: 100%; margin: 0 auto;">
					<ul class="tabs" data-persist="true">
						<li><a href="#view1">Dados Prinicipais</a></li>
						<li><a href="#view3">Pescado/Produção</a></li>
						<li><a href="#view2">Imagens</a></li>
					</ul>
					<div class="tabcontents">
                        <div id="view1">
							<form action="recebe_indig_alterar_prod_entregas.php?idEntrega=<?php echo $idEntrega;?>&idAldeia=<?php echo $idAldeia;?>" method="post" name="recebe_indig_alterar_prod_entregas" enctype="multipart/form-data" id="recebe_indig_alterar_prod_entregas">
								<div class="checkbox-toggle">
									<input type="checkbox" id="check-toggle-2"/>
									<label for="check-toggle-2">Atualizar Pendências de Compra?</label>
								</div>
								<div class="form-group row">
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_DATA">Data da entrega:</label>
										<input type="text" name="INDIG_MOVENT_DATA" class="form-control" id="INDIG_MOVENT_DATA" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_PROD_ENTREGA['INDIG_MOVENT_DATA'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_PROD_ENTREGA['INDIG_MOVENT_DATA'])).'"'; } ?>>
									</div>
									<div class="col-lg-8">
										<label class="form-label semibold" for="INDIG_MOVENT_TECNICO">Técnino Responsável</label>
										<select name="INDIG_MOVENT_TECNICO" id="INDIG_MOVENT_TECNICO" class="form-control">
											<?php while ($vetor_TECNICO=mysql_fetch_array($sql_TECNICO)) { ?>
											<option value="<?php echo $vetor_TECNICO['ID']; ?>" <?php if (strcasecmp($vetor_PROD_ENTREGA['INDIG_MOVENT_TECNICO'], $vetor_TECNICO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TECNICO['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- Data / Técnico -->
								<h4>Pesca</h4>
								<div class="form-group row">
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_PESCA_CX120">Caixas 120l:</label>
										<input type="text" name="INDIG_MOVENT_PESCA_CX120" class="form-control" id="INDIG_MOVENT_PESCA_CX120" placeholder="Caixas..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_PESCA_CX120']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_PESCA_CX160">Caixas 160l:</label>
										<input type="text" name="INDIG_MOVENT_PESCA_CX160" class="form-control" id="INDIG_MOVENT_PESCA_CX160" placeholder="Caixas..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_PESCA_CX160']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_PESCA_GELO">Barras de Gelo:</label>
										<input type="text" name="INDIG_MOVENT_PESCA_GELO" class="form-control" id="INDIG_MOVENT_PESCA_GELO" placeholder="Barras..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_PESCA_GELO']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_PESCA_GL20">Galões 20l:</label>
										<input type="text" name="INDIG_MOVENT_PESCA_GL20" class="form-control" id="INDIG_MOVENT_PESCA_GL20" placeholder="Galões..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_PESCA_GL20']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_PESCA_GL50">Galões 50l:</label>
										<input type="text" name="INDIG_MOVENT_PESCA_GL50" class="form-control" id="INDIG_MOVENT_PESCA_GL50" placeholder="Galões..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_PESCA_GL50']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_PESCA_COMB">Combustível:</label>
										<input type="text" name="INDIG_MOVENT_PESCA_COMB" class="form-control" id="INDIG_MOVENT_PESCA_COMB" placeholder="Litros..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_PESCA_COMB']; ?>">
									</div>
								</div> <!-- Pesca -->
								<h4>Transporte</h4>
								<div class="form-group row">
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_TRANS_CX120">Caixas 120l:</label>
										<input type="text" name="INDIG_MOVENT_TRANS_CX120" class="form-control" id="INDIG_MOVENT_TRANS_CX120" placeholder="Caixas..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_TRANS_CX120']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_TRANS_CX160">Caixas 160l:</label>
										<input type="text" name="INDIG_MOVENT_TRANS_CX160" class="form-control" id="INDIG_MOVENT_TRANS_CX160" placeholder="Caixas..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_TRANS_CX160']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_TRANS_GELO">Barras de Gelo:</label>
										<input type="text" name="INDIG_MOVENT_TRANS_GELO" class="form-control" id="INDIG_MOVENT_TRANS_GELO" placeholder="Barras..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_TRANS_GELO']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_TRANS_GL20">Galões 20l:</label>
										<input type="text" name="INDIG_MOVENT_TRANS_GL20" class="form-control" id="INDIG_MOVENT_TRANS_GL20" placeholder="Galões..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_TRANS_GL20']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_TRANS_GL50">Galões 50l:</label>
										<input type="text" name="INDIG_MOVENT_TRANS_GL50" class="form-control" id="INDIG_MOVENT_TRANS_GL50" placeholder="Galões..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_TRANS_GL50']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_TRANS_COMB">Combustível:</label>
										<input type="text" name="INDIG_MOVENT_TRANS_COMB" class="form-control" id="INDIG_MOVENT_TRANS_COMB" placeholder="Litros..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_TRANS_COMB']; ?>">
									</div>
								</div> <!-- Transporte -->
								<h4>Outros</h4>
								<div class="form-group row">
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_CONSERV_GELO">Gelo para Conservação:</label>
										<input type="text" name="INDIG_MOVENT_CONSERV_GELO" class="form-control" id="INDIG_MOVENT_CONSERV_GELO" placeholder="Caixas..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_CONSERV_GELO']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_RANCHO_GELO">Gelo para Rancho:</label>
										<input type="text" name="INDIG_MOVENT_RANCHO_GELO" class="form-control" id="INDIG_MOVENT_RANCHO_GELO" placeholder="Caixas..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_RANCHO_GELO']; ?>">
									</div>
								</div> <!-- Outros -->
								<h4>Devolução</h4>
								<div class="form-group row">
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_PESCA_CX120_DEV">Caixas 120l/Pesca:</label>
										<input type="text" name="INDIG_MOVENT_PESCA_CX120_DEV" class="form-control" id="INDIG_MOVENT_PESCA_CX120_DEV" placeholder="Caixas..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_PESCA_CX120_DEV']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_PESCA_CX160_DEV">Caixas 160l/Pesca:</label>
										<input type="text" name="INDIG_MOVENT_PESCA_CX160_DEV" class="form-control" id="INDIG_MOVENT_PESCA_CX160_DEV" placeholder="Caixas..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_PESCA_CX160_DEV']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_PESCA_GL20_DEV">Galões 20l/Pesca:</label>
										<input type="text" name="INDIG_MOVENT_PESCA_GL20_DEV" class="form-control" id="INDIG_MOVENT_PESCA_GL20_DEV" placeholder="Galões..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_PESCA_GL20_DEV']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_PESCA_GL50_DEV">Galões 50l/Pesca:</label>
										<input type="text" name="INDIG_MOVENT_PESCA_GL50_DEV" class="form-control" id="INDIG_MOVENT_PESCA_GL50_DEV" placeholder="Galões..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_PESCA_GL50_DEV']; ?>">
									</div>
								</div> <!-- Devolução -->
								<div class="form-group row">
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_TRANS_CX120_DEV">Caixas 120l/Transp:</label>
										<input type="text" name="INDIG_MOVENT_TRANS_CX120_DEV" class="form-control" id="INDIG_MOVENT_TRANS_CX120_DEV" placeholder="Caixas..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_TRANS_CX120_DEV']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_TRANS_CX160_DEV">Caixas 160l/Transp:</label>
										<input type="text" name="INDIG_MOVENT_TRANS_CX160_DEV" class="form-control" id="INDIG_MOVENT_TRANS_CX160_DEV" placeholder="Caixas..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_TRANS_CX160_DEV']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_TRANS_GL20_DEV">Galões 20l/Transp:</label>
										<input type="text" name="INDIG_MOVENT_TRANS_GL20_DEV" class="form-control" id="INDIG_MOVENT_TRANS_GL20_DEV" placeholder="Galões..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_TRANS_GL20_DEV']; ?>">
									</div>
									<div class="col-lg-2">
										<label class="form-label semibold" for="INDIG_MOVENT_TRANS_GL50_DEV">Galões 50l/Transp:</label>
										<input type="text" name="INDIG_MOVENT_TRANS_GL50_DEV" class="form-control" id="INDIG_MOVENT_TRANS_GL50_DEV" placeholder="Galões..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_PROD_ENTREGA['INDIG_MOVENT_TRANS_GL50_DEV']; ?>">
									</div>
								</div>
								</br>
                                <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
							</form>
	                    </div>

                    	<div id="view2">
							<form action="recebe_indig_alterar_prod_imagens.php?idEntrega=<?php echo $idEntrega;?>&idAldeia=<?php echo $idAldeia;?>" method="post" name="recebe_indig_alterar_prod_imagens" enctype="multipart/form-data" id="recebe_indig_alterar_prod_imagens">
                        	<table width="100%">
								<thead>
									<td width="40%">Legenda</td>
									<td width="2%"></td>
									<td width="40%">Imagem</td>
									<td width="2%"></td>
									<td width="16%">&nbsp;</td>
								</thead>
                        	</table>
                        	<div id="campoPaiD"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div><br/>
                        	<input type="button" value="Adicionar" onClick="addCamposD()" class="btn btn-inline"><br/><br/>
                        	<table width="100%">
								<thead>
									<td width="40%">Legenda</td>
									<td width="2%"></td>
									<td width="40%">Imagem</td>
									<td width="2%"></td>
									<td width="16%">Ações</td>
								</thead>
                           		<?php 
                                	$sql_imagem = mysql_query("SELECT * FROM TAB_INDIG_PROD_IMAGENS WHERE INDIG_MOVIMG_ENTREGA = '$idEntrega';", $db) or die(mysql_error());
									$cor = "#D8D8D8";
									while ($vetor_imagem=mysql_fetch_array($sql_imagem)) {
										if (strcasecmp($cor, "#FFFFFF") == 0){
											$cor = "#D8D8D8";
										} else {
											$cor = "#FFFFFF";
										}
								?>
                            	<tr bgcolor="<?php echo $cor; ?>">
									<td width="40%"><?php echo $vetor_imagem['INDIG_MOVIMG_LEGENDA']; ?></td><td width="2%"></td>
									<td width="40%" align="center" valign="middle"><img src="imagens/<?php echo $vetor_imagem['INDIG_MOVIMG_NOME']; ?>" width="150"></td><td width="2%"></td>
									<td width="16%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_prod_imagens.php?idImagem=<?php echo $vetor_imagem['INDIG_MOVIMG_ID']; ?>&idEntrega=<?php echo $idEntrega; ?>&idAldeia=<?php echo $idAldeia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
							  	</tr>
                          		<?php } ?>
                        	</table><br/>
                        	<input name="pesq" type="image" src="imgs/salvar.png" class="float" />
							</form>
                    	</div>

                    	<div id="view3">
							<form action="recebe_indig_alterar_prod_pescado.php?idEntrega=<?php echo $idEntrega;?>&idAldeia=<?php echo $idAldeia;?>" method="post" name="recebe_indig_alterar_prod_pescado" enctype="multipart/form-data" id="recebe_indig_alterar_prod_pescado">
                        	<table width="100%">
								<thead>
									<td width="14%">Pescador</td>
									<td width="1%"></td>
									<td width="14%">Espécie</td>
									<td width="1%"></td>
									<td width="14%">Quantidade (KG)</td>
									<td width="1%"></td>
									<td width="14%">Valor Unit. (R$)</td>
									<td width="1%"></td>
									<td width="14%">Total Devido (R$)</td>
									<td width="1%"></td>
									<td width="14%">Total Pago (R$)</td>
									<td width="1%"></td>
									<td width="10%">&nbsp;</td>
								</thead>
                        	</table>
                        	<div id="campoPaiC"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div><br/>
                        	<input type="button" value="Adicionar" onClick="addCamposC()" class="btn btn-inline"><br/><br/>
                        	<table width="100%">
								<thead>
									<td width="14%">Pescador</td>
									<td width="1%"></td>
									<td width="14%">Espécie</td>
									<td width="1%"></td>
									<td width="14%">Quantidade (KG)</td>
									<td width="1%"></td>
									<td width="14%">Valor Unit. (R$)</td>
									<td width="1%"></td>
									<td width="14%">Total Devido (R$)</td>
									<td width="1%"></td>
									<td width="14%">Total Pago (R$)</td>
									<td width="1%"></td>
									<td width="10%">Ações</td>
								</thead>
                           		<?php 
                                	$sql_Pescado = mysql_query("SELECT TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_ID, TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_ENTREGA, TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_PESCADOR, TAB_INDIG_FAMILIAS.INDIG_FAM_NOME AS INDIG_MOVPES_PESCADOR_DESC, TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA AS INDIG_MOVPES_PESCADOR_ALDEIA, TAB_APOIO_INDIG_ALDEIA.DESCRICAO AS INDIG_MOVPES_PESCADOR_ALDEIA_DESC, TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_ESPECIE, TAB_APOIO_PESCA_ESPECIES.DESCRICAO AS INDIG_MOVPES_ESPECIE_DESC, TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_QTDE, TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_VALOR, TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_TT_DEVIDO, TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_TT_PAGO FROM TAB_INDIG_PROD_PESCADO LEFT OUTER JOIN TAB_INDIG_FAMILIAS ON TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_PESCADOR = TAB_INDIG_FAMILIAS.INDIG_FAM_ID LEFT OUTER JOIN TAB_APOIO_INDIG_ALDEIA ON TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA = TAB_APOIO_INDIG_ALDEIA.ID LEFT OUTER JOIN TAB_APOIO_PESCA_ESPECIES ON TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_ESPECIE = TAB_APOIO_PESCA_ESPECIES.ID WHERE TAB_INDIG_PROD_PESCADO.INDIG_MOVPES_ENTREGA = '$idEntrega' ORDER BY INDIG_MOVPES_PESCADOR_DESC ASC, INDIG_MOVPES_ESPECIE_DESC ASC;", $db) or die(mysql_error());
									$cor = "#D8D8D8";
									while ($vetor_Pescado=mysql_fetch_array($sql_Pescado)) {
										if (strcasecmp($cor, "#FFFFFF") == 0){
											$cor = "#D8D8D8";
										} else {
											$cor = "#FFFFFF";
										}
								?>
                            	<tr bgcolor="<?php echo $cor; ?>">
									<td width="14%" align="center" valign="middle"><?php echo $vetor_Pescado['INDIG_MOVPES_PESCADOR_DESC']; ?></td><td width="1%"></td>
									<td width="14%" align="center" valign="middle"><?php echo $vetor_Pescado['INDIG_MOVPES_ESPECIE_DESC']; ?></td><td width="1%"></td>
									<td width="14%" align="center" valign="middle"><?php echo number_format($vetor_Pescado['INDIG_MOVPES_QTDE'],2,',','.'); ?></td><td width="1%"></td>
									<td width="14%" align="center" valign="middle"><?php echo number_format($vetor_Pescado['INDIG_MOVPES_VALOR'],2,',','.'); ?></td><td width="1%"></td>
									<td width="14%" align="center" valign="middle"><?php echo number_format($vetor_Pescado['INDIG_MOVPES_TT_DEVIDO'],2,',','.'); ?></td><td width="1%"></td>
									<td width="14%" align="center" valign="middle"><?php echo number_format($vetor_Pescado['INDIG_MOVPES_TT_PAGO'],2,',','.'); ?></td><td width="1%"></td>
									<td width="10%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_prod_pescado.php?idPescado=<?php echo $vetor_Pescado['INDIG_MOVPES_ID']; ?>&idEntrega=<?php echo $idEntrega; ?>&idAldeia=<?php echo $idAldeia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
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