﻿<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 3;
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
			$sql_RUC = mysql_query("select * from TAB_APOIO_RUC order by DESCRICAO ASC", $db);
			$sql_PERIODO = mysql_query("select * from TAB_APOIO_PERIODO order by DESCRICAO ASC", $db);
			$sql_EVENTO = mysql_query("select * from TAB_APOIO_EVENUC_IN order by DESCRICAO ASC", $db);
			$sql_ATIVIDADE = mysql_query("select * from TAB_APOIO_ATIVNUC_IN order by DESCRICAO ASC", $db);
			$sql_ENTIDADES = mysql_query("select * from TAB_APOIO_ENTIDINST order by DESCRICAO ASC", $db);
			$sql_TECNICOS = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC", $db);
			$sql_PERCEPCOES = mysql_query("select * from TAB_APOIO_PERCEPCOES order by DESCRICAO ASC", $db);
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
function mtel(v){
    v=v.replace(/\D/g,"");
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2");
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");
    return v;
}
function mdata(v){  
    v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito  
    v=v.replace(/(\d{2})(\d)/,"$1/$2");  
    v=v.replace(/(\d{2})(\d)/,"$1/$2");  
    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");  
    return v;  
}  
function id( el ){
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
var qtdeCampos = 0;
function addCampos() {
var objPai = document.getElementById("campoPai");
//Criando o elemento DIV;
var objFilho = document.createElement("div");
//Definindo atributos ao objFilho:
objFilho.setAttribute("id","filho"+qtdeCampos);
//Inserindo o elemento no pai:
objPai.appendChild(objFilho);
//Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filho"+qtdeCampos).innerHTML = "<table width='100%' border='0'><tr><td width='76%' class='style12'><select name='ATIV_TECNICOS[]' id='exampleSelect' class='form-control'><option value='' selected='selected'>Selecione um técnico...</option><?php while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) { ?><option value='<?php echo  $vetor_TECNICOS[ID]; ?>'><?php echo $vetor_TECNICOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='4%' class='style12'></td><td width='20%' class='style12'><input type='button' onclick='removerCampo("+qtdeCampos+")' value='Apagar' class='btn btn-inline'></td></tr></table>";
qtdeCampos++;
}
function removerCampo(id) {
var objPai = document.getElementById("campoPai");
var objFilho = document.getElementById("filho"+id);
console.log(objPai);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPai.removeChild(objFilho);
}

var qtdeCamposB = 0;
function addCamposB() {
var objPaiB = document.getElementById("campoPaiB");
//Criando o elemento DIV;
var objFilhoB = document.createElement("div");
//Definindo atributos ao objFilho:
objFilhoB.setAttribute("id","filhoB"+qtdeCamposB);
//Inserindo o elemento no pai:
objPaiB.appendChild(objFilhoB);
//Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filhoB"+qtdeCamposB).innerHTML = "<table width='100%' border='0'><tr><td width='76%' class='style12'><select name='ATIV_ENTIDINST[]' id='exampleSelect' class='form-control'><option value='' selected='selected'>Selecione uma Entidade</option><?php while ($vetor_ENTIDADES=mysql_fetch_array($sql_ENTIDADES)) { ?><option value='<?php echo  $vetor_ENTIDADES[ID]; ?>'><?php echo $vetor_ENTIDADES[DESCRICAO]; ?></option><?php } ?></select></td><td width='4%' class='style12'></td><td width='20%' class='style12'><input type='button' onclick='removerCampoB("+qtdeCamposB+")' value='Apagar' class='btn btn-inline'></td></tr></table>";
qtdeCamposB++;
}
function removerCampoB(id) {
var objPaiB = document.getElementById("campoPaiB");
var objFilhoB = document.getElementById("filhoB"+id);
console.log(objPaiB);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPaiB.removeChild(objFilhoB);
}

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
document.getElementById("filhoC"+qtdeCamposC).innerHTML = "<table width='100%' border='0'><tr><td width='76%' class='style12'><select name='ATIV_PERCEPCOES[]' id='exampleSelect' class='form-control'><option value='' selected='selected'>Selecione uma Percepção</option><?php while ($vetor_PERCEPCOES=mysql_fetch_array($sql_PERCEPCOES)) { ?><option value='<?php echo  $vetor_PERCEPCOES[ID]; ?>'><?php echo $vetor_PERCEPCOES[DESCRICAO]; ?></option><?php } ?></select></td><td width='4%' class='style12'></td><td width='20%' class='style12'><input type='button' onclick='removerCampoC("+qtdeCamposC+")' value='Apagar' class='btn btn-inline'></td></tr></table>";
qtdeCamposC++;
}
function removerCampoC(id) {
var objPaiC = document.getElementById("campoPaiC");
var objFilhoC = document.getElementById("filhoC"+id);
console.log(objPaiC);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPaiC.removeChild(objFilhoC);
}

var qtdeCamposD = 0;
function addCamposD() {
var objPaiD = document.getElementById("campoPaiD");
//Criando o elemento DIV;
var objFilhoD = document.createElement("div");
//Definindo atributos ao objFilho:
objFilhoD.setAttribute("id","filhoD"+qtdeCamposD);
//Inserindo o elemento no pai:
objPaiD.appendChild(objFilhoD);
//Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filhoD"+qtdeCamposD).innerHTML = "<table width='100%' border='0'><tr><td width='22%' class='style12'><input type='text' name='ATIV_LEGENDAS[]'></td><td width='4%' class='style12'></td><td width='50%' class='style12'><input type='file' name='ATIV_IMAGENS[]'></td><td width='4%' class='style12'></td><td width='20%' class='style12'><input type='button' onclick='removerCampoD("+qtdeCamposD+")' value='Apagar' class='btn btn-inline'></td></tr></table>";
qtdeCamposD++;
}
function removerCampoD(id) {
var objPaiD = document.getElementById("campoPaiD");
var objFilhoD = document.getElementById("filhoD"+id);
console.log(objPaiD);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPaiD.removeChild(objFilhoD);
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
							<h3>Gestão do Projeto 4.4.4</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Cadastro de Atividade Institucional</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_cadastrar_ativ_in.php" method="post" name="ativ_in" enctype="multipart/form-data" id="formID">
                <div class="row">
					<div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label semibold" for="exampleInput">Data:</label>
							<input type="text" name="ATIV_DATA" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10">
						</fieldset>
					</div>
					<div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label" for="exampleInputEmail1">Nº de Participantes:</label>
							<input type="text" name="ATIV_PARTICIPANTES" class="form-control" id="exampleInput" placeholder="Digite o n° de participantes...">
						</fieldset>
					</div>
					<div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label" for="exampleInputEmail1">Bairro/RUC:</label>
							<select name="ATIV_RUC" id="exampleSelect" class="form-control">
                              <option value="" selected="selected">Selecione o bairro/RUC...</option>
                              <?php while ($vetor_RUC=mysql_fetch_array($sql_RUC)) { ?>
                              <option value="<?php echo $vetor_RUC['ID'] ?>"><?php echo $vetor_RUC['DESCRICAO'] ?></option>
                              <?php } ?>
                            </select>
						</fieldset>
					</div>
                    <div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label" for="exampleInputEmail1">Período:</label>
							<select name="ATIV_PERIODO" id="exampleSelect" class="form-control">
                              <option value="" selected="selected">Selecione o período...</option>
                              <?php while ($vetor_PERIODO=mysql_fetch_array($sql_PERIODO)) { ?>
                              <option value="<?php echo $vetor_PERIODO['ID'] ?>"><?php echo $vetor_PERIODO['DESCRICAO'] ?></option>
                              <?php } ?>
                            </select>
						</fieldset>
					</div>
				</div><!--.row-->
                <div class="form-group row">
						<label for="exampleSelect" class="col-sm-2 form-control-label">Tipo do Evento:</label>
						<div class="col-sm-10">
							<select name="ATIV_EVENTO" id="exampleSelect" class="form-control">
                              <option value="" selected="selected">Selecione o tipo do evento...</option>
                              <?php while ($vetor_EVENTO=mysql_fetch_array($sql_EVENTO)) { ?>
                              <option value="<?php echo $vetor_EVENTO['ID'] ?>"><?php echo $vetor_EVENTO['DESCRICAO'] ?></option>
                              <?php } ?>
                            </select>
						</div>
				</div>
                <div class="form-group row">
						<label for="exampleSelect" class="col-sm-2 form-control-label">Tipo da Atividade:</label>
						<div class="col-sm-10">
							<select name="ATIV_ATIVIDADE" id="exampleSelect" class="form-control">
                              <option value="" selected="selected">Selecione o tipo da atividade...</option>
                              <?php while ($vetor_ATIVIDADE=mysql_fetch_array($sql_ATIVIDADE)) { ?>
                              <option value="<?php echo $vetor_ATIVIDADE['ID'] ?>"><?php echo $vetor_ATIVIDADE['DESCRICAO'] ?></option>
                              <?php } ?>
                            </select>
						</div>
				</div>
                <div class="form-group row">
						<label for="exampleSelect" class="col-sm-2 form-control-label">Descrição da Atividade:</label>
						<div class="col-sm-10">
							<textarea rows="4" name="ATIV_DESCRICAO" class="form-control" placeholder="Digite a descrição da atividade..."></textarea>
						</div>
				</div>
                <div class="form-group row">
						<label for="exampleSelect" class="col-sm-2 form-control-label">Percepções Descritivas:</label>
						<div class="col-sm-10">
							<textarea rows="4" name="ATIV_PERCEPCAO" class="form-control" placeholder="Digite as percepções descritivas..."></textarea>
						</div>
				</div>
                </br>
                <div style="width: 100%; margin: 0 auto;">
                    <ul class="tabs" data-persist="true">
                    <li><a href="#view1">Envolvidos/Participantes</a></li>
                    <li><a href="#view2">Técnicos Responsáveis</a></li>
                    <li><a href="#view3">Registro Fotográfico</a></li>
                    <li><a href="#view4">Percepções Qualitativas</a></li>
                    </ul>
                    <div class="tabcontents">
                        <div id="view1">
                            <table width="100%" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="76%">Entidade / Associação / Participante</td>
                                <td width="4%">&nbsp;</td>
                                <td width="20%">&nbsp;</td>
                              </tr>
                            </table>
                            <div id="campoPaiB"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                            <br>
                            <input type="button" value="Adicionar" onClick="addCamposB()" class="btn btn-inline">
                        </div>
                        <div id="view2">
                            <table width="100%" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="76%">Técnico Responsável</td>
                                <td width="4%">&nbsp;</td>
                                <td width="20%">&nbsp;</td>
                              </tr>
                            </table>
                            <div id="campoPai"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                            <br>
                            <input type="button" value="Adicionar" onClick="addCampos()" class="btn btn-inline">
                        </div>
                        <div id="view3">
                            <table width="100%" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="22%">Legenda</td>
                                <td width="4%">&nbsp;</td>
                                <td width="50%">Imagem</td>
                                <td width="4%">&nbsp;</td>
                                <td width="20%">&nbsp;</td>
                              </tr>
                            </table>
                            <div id="campoPaiD"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                            <br>
                            <input type="button" value="Adicionar" onClick="addCamposD()" class="btn btn-inline">
                        </div>
                        <div id="view4">
                            <table width="100%" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="76%">Percepção Qualitativa</td>
                                <td width="4%">&nbsp;</td>
                                <td width="20%">&nbsp;</td>
                              </tr>
                            </table>
                            <div id="campoPaiC"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                            <br>
                            <input type="button" value="Adicionar" onClick="addCamposC()" class="btn btn-inline">
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