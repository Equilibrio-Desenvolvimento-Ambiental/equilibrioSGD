﻿<?php 
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
			$sql_MUNICIPIOS = mysql_query("select * from TAB_APOIO_MUNICIPIOS order by DESCRICAO ASC", $db);
			$sql_SETETORATEND = mysql_query("select * from TAB_APOIO_SETORATEND order by DESCRICAO ASC", $db);
			$sql_DATUM = mysql_query("select * from TAB_APOIO_DATUM order by DESCRICAO ASC", $db);
			$sql_HEMISFERIOS = mysql_query("select * from TAB_APOIO_HEMISFERIOS order by DESCRICAO ASC", $db);
			$sql_FUSOS = mysql_query("select * from TAB_APOIO_FUSOS order by DESCRICAO ASC", $db);
			$sql_TIPOLOGIAVEGETAL = mysql_query("select * from TAB_APOIO_TIPOLOGIAVEGETAL order by DESCRICAO ASC", $db);
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
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
window.onload = function(){  
    id('telefone').onkeypress = function(){  
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
document.getElementById("filho"+qtdeCampos).innerHTML = "<table width='100%' border='0'><tr><td width='89%' class='style12'><select name='POTIPVEG_TIPO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um tipo de tipologia vegetal...</option><?php while ($vetor_TIPOLOGIAVEGETAL=mysql_fetch_array($sql_TIPOLOGIAVEGETAL)) { ?><option value='<?php echo  $vetor_TIPOLOGIAVEGETAL[ID]; ?>'><?php echo $vetor_TIPOLOGIAVEGETAL[DESCRICAO]; ?></option><?php } ?></select></td><td width='1%' class='style12'></td><td width='10%' class='style12'><input type='button' onclick='removerCampo("+qtdeCampos+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos++;
}
function removerCampo(id) {
var objPai = document.getElementById("campoPai");
var objFilho = document.getElementById("filho"+id);
console.log(objPai);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPai.removeChild(objFilho);
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
							<h3>Gestão dos Projetos 4.1.5 e 4.2.1 - Reparação Rural e ATES</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Cadastro de Pontos de Ocupação</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_cadastrar_pontoocup.php" method="post" name="pontoocup" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInput">Número do Processo do Ponto de Ocupação:</label>
                            <input type="text" name="POCUP_PROCESSO" class="form-control" id="exampleInput" placeholder="Digite o número do processo..." >
                        </div>
                    </div> <!-- Número do Processo -->
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInputEmail1">Área de uso (ha):</label>
                            <input type="text" name="POCUP_AREAUSO" class="form-control" id="exampleInput" placeholder="Digite a área de uso..." value="0">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInputEmail1">Área de lavoura cacaueira (ha):</label>
                            <input type="text" name="POCUP_AREACACAU" class="form-control" id="exampleInput" placeholder="Digite a área de lavoura cacaueira..." value="0">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInputEmail1">Área de pastagem (ha):</label>
                            <input type="text" name="POCUP_AREAPASTAGEM" class="form-control" id="exampleInput" placeholder="Digite a área de pastagem..." value="0">
                        </div>
                    </div> <!-- Áreas: Uso, Lavoura Cacaueira, Pastagem -->
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInputEmail1">Área de Floresta primária (ha):</label>
                            <input type="text" name="POCUP_AREAFLO_PRI" class="form-control" id="exampleInput" placeholder="Digite a área de floresta primária..." value="0">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInputEmail1">Área de Floresta secundária (ha):</label>
                            <input type="text" name="POCUP_AREAFLO_SEC" class="form-control" id="exampleInput" placeholder="Digite a área de floresta secundária..." value="0">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInputEmail1">Outras (ha):</label>
                            <input type="text" name="POCUP_AREAOUTRAS" class="form-control" id="exampleInput" placeholder="Digite as outras áreas..." value="0">
                        </div>
                    </div> <!-- Áreas: Floresta Primária, Floresta Secundária, Outras Áreas -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInputEmail1">Descreva as outras áreas:</label>
                            <input type="text" name="POCUP_AREAOUTRAS_TXT" class="form-control" id="exampleInput" placeholder="Digite a descrição das outras áreas...">
                         </div>	
                    </div> <!-- Descrição das Outras Áreas -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Município:</label>
                            <select name="POCUP_MUNICIPIO" id="exampleSelect" class="form-control">
                                <option value="0" selected="selected">Selecione o município...</option>
                                <?php while ($vetor_MUNICIPIOS=mysql_fetch_array($sql_MUNICIPIOS)) { ?>
                                <option value="<?php echo $vetor_MUNICIPIOS['ID'] ?>"><?php echo $vetor_MUNICIPIOS['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Setor:</label>
                            <select name="POCUP_SETOR" id="exampleSelect" class="form-control">
                                <option value="0" selected="selected">Selecione o setor...</option>
                                <?php while ($vetor_SETETORATEND=mysql_fetch_array($sql_SETETORATEND)) { ?>
                                <option value="<?php echo $vetor_SETETORATEND['ID'] ?>"><?php echo $vetor_SETETORATEND['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Município / Setor -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Descrição do acesso:</label>
                            <input type="text" name="POCUP_ACESSO_DESC" class="form-control" id="exampleInput" placeholder="Digite a descrição do acesso...">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Coord. UTM-E do acesso:</label>
                            <input type="text" name="POCUP_ACESSO_UTME" class="form-control" id="exampleInput" placeholder="Digite a coordenada...">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Coord. UTM-N do acesso:</label>
                            <input type="text" name="POCUP_ACESSO_UTMN" class="form-control" id="exampleInput" placeholder="Digite a coordenada...">
                        </div>
                    </div> <!-- Coordenada UTM E/UTM N do Acesso / Descrição do Acesso -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">DATUM do Ponto de Ocupação:</label>
                            <select name="POCUP_PONTO_DATUM" id="exampleSelect" class="form-control">
                            	<option value="0" selected="selected">Selecione o DATUM...</option>
                                <?php while ($vetor_DATUM=mysql_fetch_array($sql_DATUM)) { ?>
                                <option value="<?php echo $vetor_DATUM['ID'] ?>"><?php echo $vetor_DATUM['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Hemisfério do Ponto de Ocupação:</label>
                            <select name="POCUP_PONTO_HEMISFERIO" id="exampleSelect" class="form-control">
                            	<option value="0" selected="selected">Selecione o hemisfério...</option>
                                <?php while ($vetor_HEMISFERIOS=mysql_fetch_array($sql_HEMISFERIOS)) { ?>
                                <option value="<?php echo $vetor_HEMISFERIOS['ID'] ?>"><?php echo $vetor_HEMISFERIOS['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- DATUM / Hemisfério -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Fuso do Ponto de Ocupação:</label>
                            <select name="POCUP_PONTO_FUSO" id="exampleSelect" class="form-control">
                            	<option value="0" selected="selected">Selecione o fuso...</option>
                                <?php while ($vetor_FUSOS=mysql_fetch_array($sql_FUSOS)) { ?>
                                <option value="<?php echo $vetor_FUSOS['ID'] ?>"><?php echo $vetor_FUSOS['DESCRICAO'] ?></option>
                                <?php } ?>
							</select>
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Coord. UTM-E do Ponto:</label>
                            <input type="text" name="POCUP_PONTO_UTME" class="form-control" id="exampleInput" placeholder="Digite as coordenadas...">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Coord. UTM-N do Ponto:</label>
                            <input type="text" name="POCUP_PONTO_UTMN" class="form-control" id="exampleInput" placeholder="Digite as coordenadas...">
                        </div>
                    </div> <!-- Telefones/Coordenadas UTM E/Coordenadas UTM N/Fuso das Coordenadas -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Confrontante (Norte):</label>
                            <input type="text" name="POCUP_CONF_NORTE" class="form-control" id="exampleInput" placeholder="Digite os confrontantes ao NORTE...">
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Confrontante (Sul):</label>
                            <input type="text" name="POCUP_CONF_SIL" class="form-control" id="exampleInput" placeholder="Digite os confrontantes ao SUL...">
                        </div>
                    </div> <!-- Confrontantes Norte / Sul -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Confrontante (Leste):</label>
                            <input type="text" name="POCUP_CONF_LESTE" class="form-control" id="exampleInput" placeholder="Digite os confrontantes à LESTE...">
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Confrontante (Oeste):</label>
                            <input type="text" name="POCUP_CONF_OESTE" class="form-control" id="exampleInput" placeholder="Digite os confrontantes à OESTE...">
                        </div>
                    </div> <!-- Confrontantes Leste / Oeste -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInput">Mapa Da Caracterização Socioambiental Dos Pontos De Ocupação Da Área (Por Ponto De Ocupação):</label>
                            <input type="file" name="POCUP_MAPA" class="form-control" id="exampleInput" placeholder="Selecione o arquivo do mapa..." >
                        </div>
                    </div> <!-- Mapa -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInput">Planejamento Ambiental E Econômico Do Ponto De Ocupação:</label>
							<textarea rows="4" name="POCUP_PLANEJAMENTO" class="form-control" placeholder="Descrição técnica considerando as fragilidades e restrições, bem como as potencialidades da área...."></textarea>
						</div>
                    </div> <!-- Planejamento -->
                    </br>
                    
					<div style="width: 100%; margin: 0 auto;">
                    	<ul class="tabs" data-persist="true">
                        	<li><a href="#view1">Tipologia Vegetal</a></li>
                        </ul>
        				<div class="tabcontents">
                        	<div id="view1">
                            	<div id="scroll">
                                	<table width="100%">
                                    	<tr align="center" bgcolor="#0D0C9B" >
                                            <td colspan="3"><strong><font color="#FFFFFF">Tipo de Tipologia Vegetal</font></strong></td>
                                        </tr>
                                    </table>
                                    <div id="campoPai">
                                    	<img src="imgs/separacao.png" alt="" width="10" height="10"/>
                                    </div><br/>
                                   	<input type="button" value="Nova Tipologia" onClick="addCampos()" class="btn btn-inline">
								</div>
							</div>
						</div>
					</div><br/>
                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
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