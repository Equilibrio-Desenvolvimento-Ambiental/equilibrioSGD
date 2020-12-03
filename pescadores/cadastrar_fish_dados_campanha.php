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
			$id_camp = $_GET['id_camp'];
			$id_familia = $_GET['id_familia'];
			
			$sql_ENTREVISTA = mysql_query("SELECT * FROM TAB_FISH_ACOMP_ENTREVISTA WHERE FISH_AE_ID = '$id_camp';", $db);
			$vetor_ENTREVISTA = mysql_fetch_array($sql_ENTREVISTA);
			$sql_PERCEPCCAO = mysql_query("SELECT * FROM TAB_FISH_ACOMP_PERCEPCAO WHERE FISH_AEP_AE = '$id_camp';", $db);
			$vetor_PERCEPCCAO = mysql_fetch_array($sql_PERCEPCCAO);

			$sql_TECNICO = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC;", $db);
			$sql_CAMPANHA = mysql_query("select * from TAB_FISH_CAMPANHAS order by FISH_CAMP_DESCRICAO  ASC;", $db);
			$sql_EQUIPNUSO = mysql_query("select * from TAB_APOIO_PESCA_EQUIPNUSO order by DESCRICAO  ASC;", $db);
			$sql_MOTIVONPESCAR = mysql_query("select * from TAB_APOIO_PESCA_MOTIVO order by DESCRICAO  ASC;", $db);
			$sql_FICHASNPREENC = mysql_query("select * from TAB_APOIO_PESCA_FICHASNPREENC order by DESCRICAO  ASC;", $db);
			$sql_EQUIPNVIST_M = mysql_query("select * from TAB_APOIO_PESCA_EQUIPNVIST order by DESCRICAO  ASC;", $db);
			$sql_EQUIPPOSSE_M = mysql_query("select * from TAB_APOIO_PESCA_EQUIPPOSSE order by DESCRICAO  ASC;", $db);
			$sql_EQUIPNVIST_E = mysql_query("select * from TAB_APOIO_PESCA_EQUIPNVIST order by DESCRICAO  ASC;", $db);
			$sql_EQUIPPOSSE_E = mysql_query("select * from TAB_APOIO_PESCA_EQUIPPOSSE order by DESCRICAO  ASC;", $db);
			$sql_EQUIPNVIST_T = mysql_query("select * from TAB_APOIO_PESCA_EQUIPNVIST order by DESCRICAO  ASC;", $db);
			$sql_EQUIPPOSSE_T = mysql_query("select * from TAB_APOIO_PESCA_EQUIPPOSSE order by DESCRICAO  ASC;", $db);
			$sql_EQUIPBENEF = mysql_query("select * from TAB_APOIO_PESCA_EQUIPBENEF order by DESCRICAO  ASC;", $db);
			$sql_COMERCIO = mysql_query("select * from TAB_APOIO_PESCA_COMERCIO order by DESCRICAO  ASC;", $db);

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
<script type="text/javascript">
var qtdeCampos_BENEF = 0;
function addCampos_BENEF() {
var objPai_BENEF = document.getElementById("campoPai_BENEF");
var objFilho_BENEF = document.createElement("div");
objFilho_BENEF.setAttribute("id","filho_BENEF"+qtdeCampos_BENEF);
objPai_BENEF.appendChild(objFilho_BENEF);
document.getElementById("filho_BENEF"+qtdeCampos_BENEF).innerHTML = "<table width='100%' border='0'><tr><td width='90%' class='style12'><select name='FISH_ACOMP_ENTR_EQUIPBENEF[]' id='FISH_ACOMP_ENTR_EQUIPBENEF' class='form-control'><option value='0' selected='selected'>Selecione um Benefício...</option><?php while ($vetor_EQUIPBENEF=mysql_fetch_array($sql_EQUIPBENEF)) { ?><option value='<?php echo $vetor_EQUIPBENEF[ID]; ?>'><?php echo $vetor_EQUIPBENEF[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='8%' class='style12'><input type='button' onclick='removerCampo_BENEF("+qtdeCampos_BENEF+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_BENEF++;
}
function removerCampo_BENEF(id) {
var objPai_BENEF = document.getElementById("campoPai_BENEF");
var objFilho_BENEF = document.getElementById("filho_BENEF"+id);
console.log(objPai_BENEF);
var removido = objPai_BENEF.removeChild(objFilho_BENEF);
}

var qtdeCampos_COMERCIO = 0;
function addCampos_COMERCIO() {
var objPai_COMERCIO = document.getElementById("campoPai_COMERCIO");
var objFilho_COMERCIO = document.createElement("div");
objFilho_COMERCIO.setAttribute("id","filho_COMERCIO"+qtdeCampos_COMERCIO);
objPai_COMERCIO.appendChild(objFilho_COMERCIO);
document.getElementById("filho_COMERCIO"+qtdeCampos_COMERCIO).innerHTML = "<table width='100%' border='0'><tr><td width='90%' class='style12'><select name='FISH_ACOMP_ENTR_COMERCIO[]' id='FISH_ACOMP_ENTR_COMERCIO' class='form-control'><option value='0' selected='selected'>Selecione um Tipo de Comercialização...</option><?php while ($vetor_COMERCIO=mysql_fetch_array($sql_COMERCIO)) { ?><option value='<?php echo $vetor_COMERCIO[ID]; ?>'><?php echo $vetor_COMERCIO[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='8%' class='style12'><input type='button' onclick='removerCampo_COMERCIO("+qtdeCampos_COMERCIO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COMERCIO++;
}
function removerCampo_COMERCIO(id) {
var objPai_COMERCIO = document.getElementById("campoPai_COMERCIO");
var objFilho_COMERCIO = document.getElementById("filho_COMERCIO"+id);
console.log(objPai_COMERCIO);
var removido = objPai_COMERCIO.removeChild(objFilho_COMERCIO);
}

</script>
<body>
<?php require_once("includes/site-header.php");?>
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Familias - Projetos de Atendimento dos Pescadores</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Dados da Campanha - v.1.0.4.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<div style="width: 100%; margin: 0 auto;">
					<ul class="tabs" data-persist="true">
						<li><a href="#view1">Bloco C</a></li>
						<li><a href="#view2">Bloco C - Q. 14</a></li>
						<li><a href="#view3">Bloco C - Q. 21</a></li>
						<li><a href="#view4">Bloco D</a></li>
						<li><a href="#view5">Fichas de Acompanhamento</a></li>
					</ul>

					<div class="tabcontents">
                    
                        <div id="view1">
							<form action="recebe_fish_alterar_acomp_entrevista.php?id_camp=<?php echo $id_camp;?>&id_familia=<?php echo $id_familia;?>" method="post" name="entrevista" enctype="multipart/form-data" id="entrevista">
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_CAMPANHA">Campanha</label>
										<select name="FISH_AE_CAMPANHA" id="FISH_AE_CAMPANHA" class="form-control">
											<?php while ($vetor_CAMPANHA=mysql_fetch_array($sql_CAMPANHA)) { ?>
											<option value="<?php echo $vetor_CAMPANHA['FISH_CAMP_ID']; ?>" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_CAMPANHA'], $vetor_CAMPANHA['FISH_CAMP_ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_CAMPANHA['FISH_CAMP_DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_TECNICO">Técnino Responsável</label>
										<select name="FISH_AE_TECNICO" id="FISH_AE_TECNICO" class="form-control">
											<?php while ($vetor_TECNICO=mysql_fetch_array($sql_TECNICO)) { ?>
											<option value="<?php echo $vetor_TECNICO['ID']; ?>" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_TECNICO'], $vetor_TECNICO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TECNICO['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- Campanha / Técnico -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_DT_ENTR_ATUAL">01 - Data da entrevista atual:</label>
										<input type="text" name="FISH_AE_DT_ENTR_ATUAL" class="form-control" id="FISH_AE_DT_ENTR_ATUAL" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_ENTREVISTA['FISH_AE_DT_ENTR_ATUAL'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_ENTREVISTA['FISH_AE_DT_ENTR_ATUAL'])).'"'; } ?>>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_DT_ENTR_ANTERIOR">02 - Data da entrevista anterior:</label>
										<input type="text" name="FISH_AE_DT_ENTR_ANTERIOR" class="form-control" id="FISH_AE_DT_ENTR_ANTERIOR" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_ENTREVISTA['FISH_AE_DT_ENTR_ANTERIOR'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_ENTREVISTA['FISH_AE_DT_ENTR_ANTERIOR'])).'"'; } ?>>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_QT_ENTR_INTERVDIAS">03 - Número de dias:</label>
										<input type="text" name="FISH_AE_QT_ENTR_INTERVDIAS" class="form-control" id="FISH_AE_QT_ENTR_INTERVDIAS" placeholder="Intervalo..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_ENTREVISTA['FISH_AE_QT_ENTR_INTERVDIAS']; ?>">
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_PESCA_REALIZOU">04 - Realizou alguma pescaria?</label>
										<select name="FISH_AE_BOO_PESCA_REALIZOU" id="FISH_AE_BOO_PESCA_REALIZOU" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_REALIZOU'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_REALIZOU'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_REALIZOU'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
								</div> <!-- Questão 01, 02, 03, 04 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_QT_PESCA_QTDEPESCARIAS">05 - Quantas pescarias no período:</label>
										<input type="text" name="FISH_AE_QT_PESCA_QTDEPESCARIAS" class="form-control" id="FISH_AE_QT_PESCA_QTDEPESCARIAS" placeholder="Quantidade..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_ENTREVISTA['FISH_AE_QT_PESCA_QTDEPESCARIAS']; ?>">
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_QT_PESCA_MEDIADIASPESCARIAS">06 - Média/Dia por pescaria:</label>
										<input type="text" name="FISH_AE_QT_PESCA_MEDIADIASPESCARIAS" class="form-control" id="FISH_AE_QT_PESCA_MEDIADIASPESCARIAS" placeholder="Média..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_ENTREVISTA['FISH_AE_QT_PESCA_MEDIADIASPESCARIAS']; ?>">
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_QT_PESCA_TOTALDIASPESCARIAS">07 - Total de dias pescando:</label>
										<input type="text" name="FISH_AE_QT_PESCA_TOTALDIASPESCARIAS" class="form-control" id="FISH_AE_QT_PESCA_TOTALDIASPESCARIAS" placeholder="Total..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_ENTREVISTA['FISH_AE_QT_PESCA_TOTALDIASPESCARIAS']; ?>">
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_QT_ENTR_INTERVDIAS">08 - Média/Pessoas por pescaria:</label>
										<input type="text" name="FISH_AE_QT_PESCA_MEDIAPESSOASPESCARIA" class="form-control" id="FISH_AE_QT_PESCA_MEDIAPESSOASPESCARIA" placeholder="Média..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_ENTREVISTA['FISH_AE_QT_PESCA_MEDIAPESSOASPESCARIA']; ?>">
									</div>
								</div> <!-- Questão 05, 06, 07, 08 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_PESCA_USOUEQUIPS">09 - Utilizou os equipamentos?</label>
										<select name="FISH_AE_BOO_PESCA_USOUEQUIPS" id="FISH_AE_BOO_PESCA_USOUEQUIPS" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_USOUEQUIPS'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_USOUEQUIPS'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_USOUEQUIPS'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
									<div class="col-lg-9">
										<label class="form-label semibold">10 - Se não, Porque?</label>
										<select name="FISH_AE_FK_PESCA_NUSOUEQUIPS" id="FISH_AE_FK_PESCA_NUSOUEQUIPS" class="form-control">
											<?php while ($vetor_EQUIPNUSO=mysql_fetch_array($sql_EQUIPNUSO)) { ?>
											<option value="<?php echo $vetor_EQUIPNUSO['ID']; ?>" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_FK_PESCA_NUSOUEQUIPS'], $vetor_EQUIPNUSO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_EQUIPNUSO['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- Questão 09, 10 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_PESCA_LOCALMUDOU">11 - Mudou local de pesca?</label>
										<select name="FISH_AE_BOO_PESCA_LOCALMUDOU" id="FISH_AE_BOO_PESCA_LOCALMUDOU" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_LOCALMUDOU'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_LOCALMUDOU'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_LOCALMUDOU'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_PESCA_LOCALMELHOR">12 - Novo local é melhor?</label>
										<select name="FISH_AE_BOO_PESCA_LOCALMELHOR" id="FISH_AE_BOO_PESCA_LOCALMELHOR" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_LOCALMELHOR'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_LOCALMELHOR'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_LOCALMELHOR'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_PESCA_RESULTMELHOR">13 - Melhoraram resultados?</label>
										<select name="FISH_AE_BOO_PESCA_RESULTMELHOR" id="FISH_AE_BOO_PESCA_RESULTMELHOR" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_RESULTMELHOR'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_RESULTMELHOR'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_RESULTMELHOR'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" >14 - Como melhorou?<br/>ABA AO LADO</label>
									</div>
								</div> <!-- Questão 11, 12, 13, 14 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_PESCA_ESPECIESMUDOU">15 - Mudaram as espécies?</label>
										<select name="FISH_AE_BOO_PESCA_ESPECIESMUDOU" id="FISH_AE_BOO_PESCA_ESPECIESMUDOU" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_ESPECIESMUDOU'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_ESPECIESMUDOU'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_ESPECIESMUDOU'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_PESCA_CONDVIDAMELHOR">16 - Melhorou condição de vida?</label>
										<select name="FISH_AE_BOO_PESCA_CONDVIDAMELHOR" id="FISH_AE_BOO_PESCA_CONDVIDAMELHOR" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_CONDVIDAMELHOR'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_CONDVIDAMELHOR'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_CONDVIDAMELHOR'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
											<option label="NAOSABE" value="3" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_CONDVIDAMELHOR'],'3') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SABE</option>
										</select>
									</div>
								</div> <!-- Questão 15, 16 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_QT_PESCA_MEDIAKQPESCARIA">17 - Media/Pescado por pescaria:</label>
										<input type="text" name="FISH_AE_QT_PESCA_MEDIAKQPESCARIA" class="form-control" id="FISH_AE_QT_PESCA_MEDIAKQPESCARIA" placeholder="Média..." onKeyPress="mascara(this,mvalor)" maxlength="20" value="<?php echo number_format($vetor_ENTREVISTA['FISH_AE_QT_PESCA_MEDIAKQPESCARIA'],2,',','.'); ?>">
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_PESCA_PRODVENDIDA">18 - Peixe pescado foi vendido?</label>
										<select name="FISH_AE_BOO_PESCA_PRODVENDIDA" id="FISH_AE_BOO_PESCA_PRODVENDIDA" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_PRODVENDIDA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_PRODVENDIDA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_PRODVENDIDA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>									
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_QT_PESCA_MEDIAKQVENDIDO">19 - Média/KG vendido por pescaria:</label>
										<input type="text" name="FISH_AE_QT_PESCA_MEDIAKQVENDIDO" class="form-control" id="FISH_AE_QT_PESCA_MEDIAKQVENDIDO" placeholder="Média..." onKeyPress="mascara(this,mvalor)" maxlength="10" value="<?php echo number_format($vetor_ENTREVISTA['FISH_AE_QT_PESCA_MEDIAKQVENDIDO'],2,',','.'); ?>">
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_VL_PESCA_VALORKQVENDIDO">20 - Média/Valor por KG:</label>
										<input type="text" name="FISH_AE_VL_PESCA_VALORKQVENDIDO" class="form-control" id="FISH_AE_VL_PESCA_VALORKQVENDIDO" placeholder="Média..." onKeyPress="mascara(this,mvalor)" maxlength="10" value="<?php echo number_format($vetor_ENTREVISTA['FISH_AE_VL_PESCA_VALORKQVENDIDO'],2,',','.'); ?>">
									</div>
								</div> <!-- Questão 17, 18, 19, 20 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" >21 - Locais de Pesca:<br/>ABA AO LADO</label>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_QT_PESCA_MEDIAKQCONSUMO">22 - Média/KG consumido:</label>
										<input type="text" name="FISH_AE_QT_PESCA_MEDIAKQCONSUMO" class="form-control" id="FISH_AE_QT_PESCA_MEDIAKQCONSUMO" placeholder="Média..." onKeyPress="mascara(this,mvalor)" maxlength="10" value="<?php echo number_format($vetor_ENTREVISTA['FISH_AE_QT_PESCA_MEDIAKQCONSUMO'],2,',','.'); ?>">
									</div>
									<div class="col-lg-6">
										<label class="form-label semibold" for="FISH_AE_FK_PESCA_NENHUMAPESCARIA">23 - Se não Pescou, Porque?</label>
										<select name="FISH_AE_FK_PESCA_NENHUMAPESCARIA" id="FISH_AE_FK_PESCA_NENHUMAPESCARIA" class="form-control">
											<?php while ($vetor_MOTIVONPESCAR=mysql_fetch_array($sql_MOTIVONPESCAR)) { ?>
											<option value="<?php echo $vetor_MOTIVONPESCAR['ID']; ?>" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_FK_PESCA_NENHUMAPESCARIA'], $vetor_MOTIVONPESCAR['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_MOTIVONPESCAR['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- Questão 22, 23 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_PESCA_SATISFACAO">24 - Satisfeito com os equip.?</label>
										<select name="FISH_AE_BOO_PESCA_SATISFACAO" id="FISH_AE_BOO_PESCA_SATISFACAO" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_SATISFACAO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_SATISFACAO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_SATISFACAO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
                                    <div class="col-lg-9">
                           				<label class="form-label semibold" for="FISH_AE_TXT_PESCA_SATISFACAO">24.1 - Se não, Porque?:</label>
                                        <textarea rows="2" name="FISH_AE_TXT_PESCA_SATISFACAO" id="FISH_AE_TXT_PESCA_SATISFACAO" class="form-control" placeholder="Digite..."><?php echo $vetor_ENTREVISTA['FISH_AE_TXT_PESCA_SATISFACAO']; ?></textarea>
                                    </div>
								</div> <!-- Questão 24, 24.1 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_ATEND_SATISFACAO">25 - Satisfeito com o atendimento?</label>
										<select name="FISH_AE_BOO_ATEND_SATISFACAO" id="FISH_AE_BOO_ATEND_SATISFACAO" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_ATEND_SATISFACAO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_ATEND_SATISFACAO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_ATEND_SATISFACAO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
                                    <div class="col-lg-9">
                           				<label class="form-label semibold" for="FISH_AE_TXT_ATEND_SATISFACAO">25.1 - Se não, Porque?:</label>
                                        <textarea rows="2" name="FISH_AE_TXT_ATEND_SATISFACAO" id="FISH_AE_TXT_ATEND_SATISFACAO" class="form-control" placeholder="Digite..."><?php echo $vetor_ENTREVISTA['FISH_AE_TXT_ATEND_SATISFACAO']; ?></textarea>
                                    </div>
								</div> <!-- Questão 25, 25.1 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_COOP_FILIACAO">26 - Filiação à cooperativa?</label>
										<select name="FISH_AE_BOO_COOP_FILIACAO" id="FISH_AE_BOO_COOP_FILIACAO" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_COOP_FILIACAO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_COOP_FILIACAO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_COOP_FILIACAO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
											<option label="NAOSABE" value="3" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_COOP_FILIACAO'],'3') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SABE</option>
										</select>
									</div>
                                    <div class="col-lg-9">
                           				<label class="form-label semibold" for="FISH_AE_TXT_COOP_FILIACAO">26.1 - Se não, Porque?:</label>
                                        <textarea rows="2" name="FISH_AE_TXT_COOP_FILIACAO" id="FISH_AE_TXT_COOP_FILIACAO" class="form-control" placeholder="Digite..."><?php echo $vetor_ENTREVISTA['FISH_AE_TXT_COOP_FILIACAO']; ?></textarea>
                                    </div>
								</div> <!-- Questão 26, 26.1 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AE_BOO_PESCA_FICHASOK">27 - Preenchendo as Fichas?</label>
										<select name="FISH_AE_BOO_PESCA_FICHASOK" id="FISH_AE_BOO_PESCA_FICHASOK" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_FICHASOK'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_FICHASOK'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_BOO_PESCA_FICHASOK'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>									
									<div class="col-lg-9">
										<label class="form-label semibold">28 - Se não, Porque?</label>
										<select name="FISH_AE_FK_PESCA_FICHASMOTIVO" id="FISH_AE_FK_PESCA_FICHASMOTIVO" class="form-control">
											<?php while ($vetor_FICHASNPREENC=mysql_fetch_array($sql_FICHASNPREENC)) { ?>
											<option value="<?php echo $vetor_FICHASNPREENC['ID']; ?>" <?php if (strcasecmp($vetor_ENTREVISTA['FISH_AE_FK_PESCA_FICHASMOTIVO'], $vetor_FICHASNPREENC['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_FICHASNPREENC['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- Questão 22, 23 -->
								</br>
                                <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
							</form>
	                    </div>

	                    <div id="view2">
			                <form action="recebe_fish_cadastrar_acomp_entr_equipbenef.php?id_camp=<?php echo $id_camp; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="entr_Benef" enctype="multipart/form-data" id="entr_Benef">
								<table width="100%"><thead><td width="90%">Benefícios dos Equipamentos</td><td width="2%"></td><td width="8%">&nbsp;</td></thead></table>
								<div id="campoPai_BENEF"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
								<br/>
								<input type="button" value="Adicionar" onClick="addCampos_BENEF()" class="btn btn-inline">
								<br/><br/>
								<table width="100%">
									<thead>
										<td width="90%">Benefícios dos Equipamentos</td>
										<td width="2%"></td>
										<td width="8%">Ações</td>
									</thead>
									<?php
										$sql_AcompEntrBenef = mysql_query("SELECT TAB_FISH_ACOMP_ENTR_EQUIPNUSO.FISH_AEE_ID, TAB_APOIO_PESCA_EQUIPBENEF.DESCRICAO AS FISH_AEE_TIPO_DESC FROM TAB_FISH_ACOMP_ENTR_EQUIPNUSO LEFT OUTER JOIN  TAB_APOIO_PESCA_EQUIPBENEF ON TAB_FISH_ACOMP_ENTR_EQUIPNUSO.FISH_AEE_TIPO = TAB_APOIO_PESCA_EQUIPBENEF.ID WHERE TAB_FISH_ACOMP_ENTR_EQUIPNUSO.FISH_AEE_AE = '$id_camp' ORDER BY FISH_AEE_TIPO_DESC ASC;", $db) or die(mysql_error());
										$cor = "#D8D8D8";
										while ($vetor_AcompEntrBenef=mysql_fetch_array($sql_AcompEntrBenef)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
											} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="90%"><?php echo $vetor_AcompEntrBenef['FISH_AEE_TIPO_DESC']; ?></td>
										<td width="2%"></td>
										<td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_acomp_entr_equipbenef.php?id=<?php echo $vetor_AcompEntrBenef['FISH_AEE_ID']; ?>&id_camp=<?php echo $id_camp; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
			                    </br>
            			        <input name="salvar" type="image" src="imgs/salvar.png" class="float" />
                			</form>
	                    </div>
					
	                    <div id="view3">
			                <form action="recebe_fish_cadastrar_acomp_entr_comercio.php?id_camp=<?php echo $id_camp; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="entr_Comercio" enctype="multipart/form-data" id="entr_Comercio">
								<table width="100%"><thead><td width="90%">Comercialização do Pescado</td><td width="2%"></td><td width="8%">&nbsp;</td></thead></table>
								<div id="campoPai_COMERCIO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
								<br/>
								<input type="button" value="Adicionar" onClick="addCampos_COMERCIO()" class="btn btn-inline">
								<br/><br/>
								<table width="100%">
									<thead>
										<td width="90%">Comercialização do Pescado</td>
										<td width="2%"></td>
										<td width="8%">Ações</td>
									</thead>
									<?php
										$sql_AcompEntrComercio = mysql_query("SELECT TAB_FISH_ACOMP_ENTR_COMERCIO.FISH_AEC_ID, TAB_APOIO_PESCA_COMERCIO.DESCRICAO AS FISH_AEC_TIPO_DESC FROM TAB_FISH_ACOMP_ENTR_COMERCIO LEFT OUTER JOIN TAB_APOIO_PESCA_COMERCIO ON TAB_APOIO_PESCA_COMERCIO.ID = TAB_FISH_ACOMP_ENTR_COMERCIO.FISH_AEC_TIPO WHERE TAB_FISH_ACOMP_ENTR_COMERCIO.FISH_AEC_AE = '$id_camp' ORDER BY TAB_APOIO_PESCA_COMERCIO.DESCRICAO ASC;", $db) or die(mysql_error());
										$cor = "#D8D8D8";
										while ($vetor_AcompEntrComercio=mysql_fetch_array($sql_AcompEntrComercio)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
											} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="90%"><?php echo $vetor_AcompEntrComercio['FISH_AEC_TIPO_DESC']; ?></td>
										<td width="2%"></td>
										<td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_acomp_entr_comercio.php?id=<?php echo $vetor_AcompEntrComercio['FISH_AEC_ID']; ?>&id_camp=<?php echo $id_camp; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
			                    </br>
            			        <input name="salvar" type="image" src="imgs/salvar.png" class="float" />
                			</form>
	                    </div>
					
                        <div id="view4">
							<form action="recebe_fish_alterar_acomp_percepcao.php?id_camp=<?php echo $id_camp;?>&id_familia=<?php echo $id_familia;?>" method="post" name="percepcao" enctype="multipart/form-data" id="percepcao">
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_BOO_MOTOR">01 - Vistoriou o Motor?</label>
										<select name="FISH_AP_BOO_MOTOR" id="FISH_AP_BOO_MOTOR" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_MOTOR'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_MOTOR'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_MOTOR'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
									<div class="col-lg-6">
										<label class="form-label semibold" for="FISH_AP_FK_MOTORNVIST">02 - Se não, Porque?</label>
										<select name="FISH_AP_FK_MOTORNVIST" id="FISH_AP_FK_MOTORNVIST" class="form-control">
											<?php while ($vetor_EQUIPNVIST_M=mysql_fetch_array($sql_EQUIPNVIST_M)) { ?>
											<option value="<?php echo $vetor_EQUIPNVIST_M['ID']; ?>" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_FK_MOTORNVIST'], $vetor_EQUIPNVIST_M['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_EQUIPNVIST_M['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_FK_MOTORPOSSE">04 - Estava em posse do pescador?</label>
										<select name="FISH_AP_FK_MOTORPOSSE" id="FISH_AP_FK_MOTORPOSSE" class="form-control">
											<?php while ($vetor_EQUIPPOSSE_M=mysql_fetch_array($sql_EQUIPPOSSE_M)) { ?>
											<option value="<?php echo $vetor_EQUIPPOSSE_M['ID']; ?>" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_FK_MOTORPOSSE'], $vetor_EQUIPPOSSE_M['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_EQUIPPOSSE_M['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- Questão 01, 02, 04 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_BOO_MOTORCONSERV">03 - Está em boa conservação?</label>
										<select name="FISH_AP_BOO_MOTORCONSERV" id="FISH_AP_BOO_MOTORCONSERV" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_MOTORCONSERV'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_MOTORCONSERV'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_MOTORCONSERV'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
                                    <div class="col-lg-9">
                           				<label class="form-label semibold" for="FISH_AP_TXT_MOTORCONSERV">03.1 - Se não, Porque?:</label>
                                        <textarea rows="2" name="FISH_AP_TXT_MOTORCONSERV" id="FISH_AP_TXT_MOTORCONSERV" class="form-control" placeholder="Digite..."><?php echo $vetor_PERCEPCCAO['FISH_AP_TXT_MOTORCONSERV']; ?></textarea>
                                    </div>
								</div> <!-- Questão 03, 03.1 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_BOO_EMBARC">05 - Vistoriou a Embarcação?</label>
										<select name="FISH_AP_BOO_EMBARC" id="FISH_AP_BOO_EMBARC" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EMBARC'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EMBARC'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EMBARC'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
									<div class="col-lg-6">
										<label class="form-label semibold" for="FISH_AP_FK_EMBARCNVIST">06 - Se não, Porque?</label>
										<select name="FISH_AP_FK_EMBARCNVIST" id="FISH_AP_FK_EMBARCNVIST" class="form-control">
											<?php while ($vetor_EQUIPNVIST_E=mysql_fetch_array($sql_EQUIPNVIST_E)) { ?>
											<option value="<?php echo $vetor_EQUIPNVIST_E['ID']; ?>" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_FK_EMBARCNVIST'], $vetor_EQUIPNVIST_E['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_EQUIPNVIST_E['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_FK_EMBARCPOSSE">08 - Estava em posse do pescador?</label>
										<select name="FISH_AP_FK_EMBARCPOSSE" id="FISH_AP_FK_EMBARCPOSSE" class="form-control">
											<?php while ($vetor_EQUIPPOSSE_E=mysql_fetch_array($sql_EQUIPPOSSE_E)) { ?>
											<option value="<?php echo $vetor_EQUIPPOSSE_E['ID']; ?>" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_FK_EMBARCPOSSE'], $vetor_EQUIPPOSSE_E['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_EQUIPPOSSE_E['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- Questão 05, 06, 08 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_BOO_EMBARCCONSERV">07 - Está em boa conservação?</label>
										<select name="FISH_AP_BOO_EMBARCCONSERV" id="FISH_AP_BOO_EMBARCCONSERV" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EMBARCCONSERV'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EMBARCCONSERV'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EMBARCCONSERV'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
                                    <div class="col-lg-9">
                           				<label class="form-label semibold" for="FISH_AP_TXT_EMBARCCONSERV">07.1 - Se não, Porque?:</label>
                                        <textarea rows="2" name="FISH_AP_TXT_EMBARCCONSERV" id="FISH_AP_TXT_EMBARCCONSERV" class="form-control" placeholder="Digite..."><?php echo $vetor_PERCEPCCAO['FISH_AP_TXT_EMBARCCONSERV']; ?></textarea>
                                    </div>
								</div> <!-- Questão 07, 07.1 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_BOO_TRALHA">09 - Vistoriou a Tralha?</label>
										<select name="FISH_AP_BOO_TRALHA" id="FISH_AP_BOO_TRALHA" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_TRALHA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_TRALHA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_TRALHA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
									<div class="col-lg-6">
										<label class="form-label semibold" for="FISH_AP_FK_TRALHANVIST">10 - Se não, Porque?</label>
										<select name="FISH_AP_FK_TRALHANVIST" id="FISH_AP_FK_TRALHANVIST" class="form-control">
											<?php while ($vetor_EQUIPNVIST_T=mysql_fetch_array($sql_EQUIPNVIST_T)) { ?>
											<option value="<?php echo $vetor_EQUIPNVIST_T['ID']; ?>" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_FK_TRALHANVIST'], $vetor_EQUIPNVIST_T['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_EQUIPNVIST_T['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_FK_TRALHAPOSSE">12 - Estava em posse do pescador?</label>
										<select name="FISH_AP_FK_TRALHAPOSSE" id="FISH_AP_FK_TRALHAPOSSE" class="form-control">
											<?php while ($vetor_EQUIPPOSSE_T=mysql_fetch_array($sql_EQUIPPOSSE_T)) { ?>
											<option value="<?php echo $vetor_EQUIPPOSSE_T['ID']; ?>" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_FK_TRALHAPOSSE'], $vetor_EQUIPPOSSE_T['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_EQUIPPOSSE_T['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- Questão 09, 10, 12 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_BOO_TRALHACONSERV">11 - Está em boa conservação?</label>
										<select name="FISH_AP_BOO_TRALHACONSERV" id="FISH_AP_BOO_TRALHACONSERV" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_TRALHACONSERV'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_TRALHACONSERV'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_TRALHACONSERV'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
                                    <div class="col-lg-9">
                           				<label class="form-label semibold" for="FISH_AP_TXT_TRALHACONSERV">11.1 - Se não, Porque?:</label>
                                        <textarea rows="2" name="FISH_AP_TXT_TRALHACONSERV" id="FISH_AP_TXT_TRALHACONSERV" class="form-control" placeholder="Digite..."><?php echo $vetor_PERCEPCCAO['FISH_AP_TXT_TRALHACONSERV']; ?></textarea>
                                    </div>
								</div> <!-- Questão 11, 11.1 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_BOO_EVIDPESCANDO">13 - Evidências de pesca?</label>
										<select name="FISH_AP_BOO_EVIDPESCANDO" id="FISH_AP_BOO_EVIDPESCANDO" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EVIDPESCANDO'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EVIDPESCANDO'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EVIDPESCANDO'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
                                    <div class="col-lg-9">
                           				<label class="form-label semibold" for="FISH_AP_TXT_EVIDPESCANDO">13.1 - Se não, Porque?:</label>
                                        <textarea rows="2" name="FISH_AP_TXT_EVIDPESCANDO" id="FISH_AP_TXT_EVIDPESCANDO" class="form-control" placeholder="Digite..."><?php echo $vetor_PERCEPCCAO['FISH_AP_TXT_EVIDPESCANDO']; ?></textarea>
                                    </div>
								</div> <!-- Questão 13, 13.1 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_BOO_EVIDVENDA">14 - Indícios de venda do equipamento?</label>
										<select name="FISH_AP_BOO_EVIDVENDA" id="FISH_AP_BOO_EVIDVENDA" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EVIDVENDA'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EVIDVENDA'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EVIDVENDA'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
                                    <div class="col-lg-9">
                           				<label class="form-label semibold" for="FISH_AP_TXT_EVIDVENDA">14.1 - Se sim, Porque?:</label>
                                        <textarea rows="2" name="FISH_AP_TXT_EVIDVENDA" id="FISH_AP_TXT_EVIDVENDA" class="form-control" placeholder="Digite..."><?php echo $vetor_PERCEPCCAO['FISH_AP_TXT_EVIDVENDA']; ?></textarea>
                                    </div>
								</div> <!-- Questão 14, 14.1 -->
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="FISH_AP_BOO_EVIDFALSIDADE">15 - Indícios de falsidade na entrevista?</label>
										<select name="FISH_AP_BOO_EVIDFALSIDADE" id="FISH_AP_BOO_EVIDFALSIDADE" class="form-control">
											<option label="NI" value="0" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EVIDFALSIDADE'],'0') == 0) : ?>selected="selected"<?php endif; ?>>NÃO INFORMADO (N/I)</option>
											<option label="SIM" value="1" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EVIDFALSIDADE'],'1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
											<option label="NAO" value="2" <?php if (strcasecmp($vetor_PERCEPCCAO['FISH_AP_BOO_EVIDFALSIDADE'],'2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
										</select>
									</div>
                                    <div class="col-lg-9">
                           				<label class="form-label semibold" for="FISH_AP_TXT_EVIDFALSIDADE">15.1 - Se sim, Porque?:</label>
                                        <textarea rows="2" name="FISH_AP_TXT_EVIDFALSIDADE" id="FISH_AP_TXT_EVIDFALSIDADE" class="form-control" placeholder="Digite..."><?php echo $vetor_PERCEPCCAO['FISH_AP_TXT_EVIDFALSIDADE']; ?></textarea>
                                    </div>
								</div> <!-- Questão 15, 15.1 -->
								<div class="form-group row">
                                    <div class="col-lg-12">
                           				<label class="form-label semibold" for="FISH_AP_TXT_PERCEPCOES">16 - Percepções Gerais:</label>
                                        <textarea rows="3" name="FISH_AP_TXT_PERCEPCOES" id="FISH_AP_TXT_PERCEPCOES" class="form-control" placeholder="Digite..."><?php echo $vetor_PERCEPCCAO['FISH_AP_TXT_PERCEPCOES']; ?></textarea>
                                    </div>
								</div> <!-- Questão 16 -->
								<div class="form-group row">
                                    <div class="col-lg-12">
                           				<label class="form-label semibold" for="FISH_AP_TXT_OBSERVACOES">17 - Observações Gerais:</label>
                                        <textarea rows="3" name="FISH_AP_TXT_OBSERVACOES" id="FISH_AP_TXT_OBSERVACOES" class="form-control" placeholder="Digite..."><?php echo $vetor_PERCEPCCAO['FISH_AP_TXT_OBSERVACOES']; ?></textarea>
                                    </div>
								</div> <!-- Questão 17 -->
								</br>
                                <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
							</form>
	                    </div>

	                    <div id="view5">
							<table width="100%">
								<thead>
									<td width="15%" align="center">Ficha de Pesca</td>
									<td width="2%">&nbsp;</td>
									<td width="33%" align="center">Data da Saída</td>
									<td width="2%">&nbsp;</td>
									<td width="33%" align="center">Data da Chegada</td>
									<td width="2%">&nbsp;</td>
									<td width="13%">&nbsp;</td>
								</thead>
							</table>
							<div id="campoPai_FICHA"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
							<br/>
							<input type="button" value="Adicionar" onClick="addCampos_FICHA()" class="btn btn-inline">
							<br/><br/>
							<table width="100%">
								<thead>
									<td width="15%" align="center">Ficha de Pesca</td>
									<td width="2%">&nbsp;</td>
									<td width="33%" align="center">Data da Saída</td>
									<td width="2%">&nbsp;</td>
									<td width="33%" align="center">Data da Chegada</td>
									<td width="2%">&nbsp;</td>
									<td width="13%">&nbsp;</td>
								</thead>
								<?php
									$sql_AcompEntrFichas = mysql_query("SELECT TAB_FISH_ACOMP_FICHA.FISH_ACOMP_ID, TAB_FISH_ACOMP_FICHA.FISH_AEF_AE, TAB_FISH_ACOMP_FICHA.FISH_ACOMP_DT_SAIDA, TAB_FISH_ACOMP_FICHA.FISH_ACOMP_DT_CHEG FROM TAB_FISH_ACOMP_FICHA WHERE TAB_FISH_ACOMP_FICHA.FISH_AEF_AE = '$id_camp' ORDER BY TAB_FISH_ACOMP_FICHA.FISH_ACOMP_DT_SAIDA DESC, TAB_FISH_ACOMP_FICHA.FISH_ACOMP_DT_CHEG DESC;", $db) or die(mysql_error());
									$cor = "#D8D8D8";
									$contador_AcompEntrFichas=mysql_num_rows($sql_AcompEntrFichas);
									while ($vetor_AcompEntrFichas=mysql_fetch_array($sql_AcompEntrFichas)) {
										if (strcasecmp($cor, "#FFFFFF") == 0){
											$cor = "#D8D8D8";
										} else {
											$cor = "#FFFFFF";
										}
								?>
								<tr bgcolor="<?php echo $cor; ?>">
									<td width="15%" align="center"><?php echo $contador_AcompEntrFichas; ?></td>
									<td width="2%"></td>
									<td width="33%" align="center">
										<?php if(!empty($vetor_AcompEntrFichas['FISH_ACOMP_DT_SAIDA'])) { echo date('d/m/Y', strtotime($vetor_AcompEntrFichas['FISH_ACOMP_DT_SAIDA'])); } ?>
									</td>
									<td width="2%"></td>
									<td width="33%" align="center">
										<?php if(!empty($vetor_AcompEntrFichas['FISH_ACOMP_DT_CHEG'])) { echo date('d/m/Y', strtotime($vetor_AcompEntrFichas['FISH_ACOMP_DT_CHEG'])); } ?>
									</td>
									<td width="2%"></td>
									<td width="13%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_acomp_entr_fichas.php?id=<?php echo $vetor_AcompEntrFichas['FISH_ACOMP_ID']; ?>&id_camp=<?php echo $id_camp; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
								</tr>
								<?php
									$contador_AcompEntrFichas--;} ?>
							</table>
		                    </br>
           			        <input name="salvar" type="image" src="imgs/salvar.png" class="float" />
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