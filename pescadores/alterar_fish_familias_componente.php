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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id = $_GET['id'];
			$id_familia = $_GET['id_familia'];
			$sql_FAMILIA_COMPOSICAO = mysql_query("SELECT * FROM TAB_FISH_FAMILIAS_COMPOSICAO where FISH_FCOMP_ID = '$id';", $db) or die(mysql_error());
			$vetor_FAMILIA_COMPOSICAO = mysql_fetch_array($sql_FAMILIA_COMPOSICAO);
			
			$sql_COMP_GENERO = mysql_query("SELECT * FROM TAB_APOIO_GENERO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COMP_PARENTESCO = mysql_query("SELECT * FROM TAB_APOIO_PARENTESCO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COMP_OCUPACAO = mysql_query("SELECT * FROM TAB_APOIO_OCUPACAO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());

			$sql_COMP_ESTADOCIVIL = mysql_query("SELECT * FROM TAB_APOIO_ESTADOCIVIL ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COMP_NACIONALIDADE = mysql_query("SELECT * FROM TAB_APOIO_NACIONALIDADES ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COMP_NATURALIDADE = mysql_query("SELECT TAB_APOIO_MUNICIPIOS.ID, TAB_APOIO_MUNICIPIOS.DESCRICAO, TAB_APOIO_UF.SIGLA FROM TAB_APOIO_MUNICIPIOS LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_UF.ID = TAB_APOIO_MUNICIPIOS.UF ORDER BY TAB_APOIO_MUNICIPIOS.DESCRICAO ASC, TAB_APOIO_UF.DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_COMP_RG_UF = mysql_query("SELECT * FROM TAB_APOIO_UF ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			
			$sql_PROJETOS = mysql_query("SELECT * FROM TAB_APOIO_CONTRIBUICOESCOOP ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());

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

var qtdeCampos_COOPINT_PROJETO = 0;
function addCampos_COOPINT_PROJETO() {
var objPai_COOPINT_PROJETO = document.getElementById("campoPai_COOPINT_PROJETO");
var objFilho_COOPINT_PROJETO = document.createElement("div");
objFilho_COOPINT_PROJETO.setAttribute("id","filho_COOPINT_PROJETO"+qtdeCampos_COOPINT_PROJETO);
objPai_COOPINT_PROJETO.appendChild(objFilho_COOPINT_PROJETO);
document.getElementById("filho_COOPINT_PROJETO"+qtdeCampos_COOPINT_PROJETO).innerHTML = "<table width='100%'><tr><td width='68%'><select name='FISH_FIPROJ_PROJETO[]' id='FISH_FIPROJ_PROJETO' class='form-control'><option value='0' selected='selected'>Selecione um tipo...</option><?php while ($vetor_PROJETOS=mysql_fetch_array($sql_PROJETOS)) { ?><option value='<?php echo  $vetor_PROJETOS[ID]; ?>'><?php echo $vetor_PROJETOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='18%'><input type='text' name='FISH_FIPROJ_ORDEM[]' id='FISH_FIPROJ_ORDEM' class='form-control' placeholder='Ordem...'></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo_COOPINT_PROJETO("+qtdeCampos_COOPINT_PROJETO+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos_COOPINT_PROJETO++;
}
function removerCampo_COOPINT_PROJETO(id) {
var objPai_COOPINT_PROJETO = document.getElementById("campoPai_COOPINT_PROJETO");
var objFilho_COOPINT_PROJETO = document.getElementById("filho_COOPINT_PROJETO"+id);
console.log(objPai_COOPINT_PROJETO);
var removido = objPai_COOPINT_PROJETO.removeChild(objFilho_COOPINT_PROJETO);
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
								<li><a href="#">Alteração de Componentes Familiares - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_fish_alterar_familias_componente.php?id=<?php echo $id; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_fish_alterar_familias_componente" enctype="multipart/form-data" id="recebe_fish_alterar_familias_componente">
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_NOME">Nome do Componente:</label>
                            <input type="text" name="FISH_FCOMP_NOME" class="form-control" id="FISH_FCOMP_NOME" placeholder="Nome..." value="<?php echo $vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_NOME']; ?>">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_APELIDO">Apelido do Componente:</label>
                            <input type="text" name="FISH_FCOMP_APELIDO" class="form-control" id="FISH_FCOMP_APELIDO" placeholder="Apelido..." value="<?php echo $vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_APELIDO']; ?>">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_GENERO">Gênero do Componente:</label>
                            <select name="FISH_FCOMP_GENERO" id="FISH_FCOMP_GENERO" class="form-control">
								<?php while ($vetor_COMP_GENERO=mysql_fetch_array($sql_COMP_GENERO)){?> 
								<option value="<?php echo $vetor_COMP_GENERO['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_GENERO'], $vetor_COMP_GENERO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_COMP_GENERO['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Nome, Apelido e Gênero do Componente -->
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_PARENTESCO">Parentesco com o Chefe da Família:</label>
                            <select name="FISH_FCOMP_PARENTESCO" id="FISH_FCOMP_PARENTESCO" class="form-control">
								<?php while ($vetor_COMP_PARENTESCO=mysql_fetch_array($sql_COMP_PARENTESCO)){?> 
								<option value="<?php echo $vetor_COMP_PARENTESCO['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_PARENTESCO'], $vetor_COMP_PARENTESCO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_COMP_PARENTESCO['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label semibold" for="FISH_FCOMP_DTNASC">Data de nascimento do Componente:</label>
                            <input type="text" name="FISH_FCOMP_DTNASC" class="form-control" id="FISH_FCOMP_DTNASC" placeholder="Data de nascimento..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_DTNASC'])) { echo 'value='.date('d/m/Y', strtotime($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_DTNASC'])); } ?>>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label semibold" for="FISH_FCOMP_IDADE">Idade do Componente:</label>
                            <input type="text" name="FISH_FCOMP_IDADE" class="form-control" id="FISH_FCOMP_IDADE" placeholder="Idade..." onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_IDADE'];?>">
                        </div>
					</div> <!-- Parentesco e Idade -->
					<div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_ESTADOCIVIL">Estado Civíl:</label>
                            <select name="FISH_FCOMP_ESTADOCIVIL" id="FISH_FCOMP_ESTADOCIVIL" class="form-control">
								<?php while ($vetor_COMP_ESTADOCIVIL=mysql_fetch_array($sql_COMP_ESTADOCIVIL)){?> 
								<option value="<?php echo $vetor_COMP_ESTADOCIVIL['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ESTADOCIVIL'], $vetor_COMP_ESTADOCIVIL['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_COMP_ESTADOCIVIL['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_NACIONALIDADE">Nacionalidade:</label>
                            <select name="FISH_FCOMP_NACIONALIDADE" id="FISH_FCOMP_NACIONALIDADE" class="form-control">
								<?php while ($vetor_COMP_NACIONALIDADE=mysql_fetch_array($sql_COMP_NACIONALIDADE)){?> 
								<option value="<?php echo $vetor_COMP_NACIONALIDADE['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_NACIONALIDADE'], $vetor_COMP_NACIONALIDADE['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_COMP_NACIONALIDADE['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_NATURALIDADE">Naturalidade:</label>
                            <select name="FISH_FCOMP_NATURALIDADE" id="FISH_FCOMP_NATURALIDADE" class="form-control">
								<?php while ($vetor_COMP_NATURALIDADE=mysql_fetch_array($sql_COMP_NATURALIDADE)){?> 
								<option value="<?php echo $vetor_COMP_NATURALIDADE['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_NATURALIDADE'], $vetor_COMP_NATURALIDADE['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_COMP_NATURALIDADE['DESCRICAO'].'/'.$vetor_COMP_NATURALIDADE['SIGLA']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
					</div> <!--Estado Civíl, Nacionalidade e Naturalidade-->
					<div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_OCUPACAO">Profissão/Ocupação do Componente:</label>
                            <select name="FISH_FCOMP_OCUPACAO" id="FISH_FCOMP_OCUPACAO" class="form-control">
								<?php while ($vetor_COMP_OCUPACAO=mysql_fetch_array($sql_COMP_OCUPACAO)){?> 
								<option value="<?php echo $vetor_COMP_OCUPACAO['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_OCUPACAO'], $vetor_COMP_OCUPACAO['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_COMP_OCUPACAO['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
						<div class="col-lg-4">
                            <label class="form-label semibold" for="FISH_FCOMP_ALFAB_LER">Sabe Ler?</label>
                            <select name="FISH_FCOMP_ALFAB_LER" id="FISH_FCOMP_ALFAB_LER" class="form-control">
                                <option value="0" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ALFAB_LER'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option value="1" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ALFAB_LER'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option value="2" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ALFAB_LER'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                <option value="3" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ALFAB_LER'], '3') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SABE</option>
                                <option value="4" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ALFAB_LER'], '4') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SE APLICA</option>
                            </select>
                        </div>
						<div class="col-lg-4">
                            <label class="form-label semibold" for="FISH_FCOMP_ALFAB_ESCREVER">Sabe Escrever?</label>
                            <select name="FISH_FCOMP_ALFAB_ESCREVER" id="FISH_FCOMP_ALFAB_ESCREVER" class="form-control">
                                <option value="0" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ALFAB_ESCREVER'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option value="1" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ALFAB_ESCREVER'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option value="2" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ALFAB_ESCREVER'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                <option value="3" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ALFAB_ESCREVER'], '3') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SABE</option>
                                <option value="4" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ALFAB_ESCREVER'], '4') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SE APLICA</option>
                            </select>
                        </div>
                    </div> <!-- Ocupação, Alfabetização -->
                    <div class="form-group row">
						<div class="col-lg-4">
                            <label class="form-label semibold" for="FISH_FCOMP_RGP_POSSUI">Possuí Registro de Pescador?</label>
                            <select name="FISH_FCOMP_RGP_POSSUI" id="FISH_FCOMP_RGP_POSSUI" class="form-control">
                                <option value="0" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RGP_POSSUI'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option value="1" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RGP_POSSUI'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option value="2" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RGP_POSSUI'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                <option value="3" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RGP_POSSUI'], '3') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SABE</option>
                                <option value="4" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RGP_POSSUI'], '4') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SE APLICA</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_RGP_NUMERO">Número do Registro:</label>
                            <input type="text" name="FISH_FCOMP_RGP_NUMERO" class="form-control" id="FISH_FCOMP_RGP_NUMERO" placeholder="Número do registro..." value="<?php echo $vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RGP_NUMERO']; ?>">
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label semibold" for="FISH_FCOMP_RGP_DTREGISTRO">Data de Registro:</label>
                            <input type="text" name="FISH_FCOMP_RGP_DTREGISTRO" class="form-control" id="FISH_FCOMP_RGP_DTREGISTRO" placeholder="Data de registro..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RGP_DTREGISTRO'])) { echo 'value='.date('d/m/Y', strtotime($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RGP_DTREGISTRO'])); } ?>>
                        </div>
                    </div> <!-- Dados do Registro de Pesca -->
					<div class="form-group row">
						<div class="col-lg-4">
                            <label class="form-label semibold" for="FISH_FCOMP_RG_POSSUI">Possuí R.G.?</label>
                            <select name="FISH_FCOMP_RG_POSSUI" id="FISH_FCOMP_RG_POSSUI" class="form-control">
                                <option value="0" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RG_POSSUI'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option value="1" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RG_POSSUI'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option value="2" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RG_POSSUI'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                <option value="3" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RG_POSSUI'], '3') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SABE</option>
                                <option value="4" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RG_POSSUI'], '4') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SE APLICA</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_RG_NUMERO">Número do R.G.:</label>
                            <input type="text" name="FISH_FCOMP_RG_NUMERO" class="form-control" id="FISH_FCOMP_RG_NUMERO" placeholder="Número do R.G...." value="<?php echo $vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RG_NUMERO']; ?>">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_RG_ORGAO">Expedição:</label>
                            <input type="text" name="FISH_FCOMP_RG_ORGAO" class="form-control" id="FISH_FCOMP_RG_ORGAO" placeholder="Expedição...." value="<?php echo $vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RG_ORGAO']; ?>">
                        </div>
                    </div> <!-- Dados do R.G. - Parte 01-->
					<div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_RG_UF">Estado do Registro:</label>
                            <select name="FISH_FCOMP_RG_UF" id="FISH_FCOMP_RG_UF" class="form-control">
								<?php while ($vetor_COMP_RG_UF=mysql_fetch_array($sql_COMP_RG_UF)){?> 
								<option value="<?php echo $vetor_COMP_RG_UF['ID']; ?>" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RG_UF'], $vetor_COMP_RG_UF['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_COMP_RG_UF['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label semibold" for="FISH_FCOMP_RG_DTREGISTRO">Data de Registro:</label>
                            <input type="text" name="FISH_FCOMP_RG_DTREGISTRO" class="form-control" id="FISH_FCOMP_RG_DTREGISTRO" placeholder="Data de registro..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RG_DTREGISTRO'])) { echo 'value='.date('d/m/Y', strtotime($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RG_DTREGISTRO'])); } ?>>
                        </div>
                    </div> <!-- Dados do R.G. - Parte 02-->
					<div class="form-group row">
						<div class="col-lg-4">
                            <label class="form-label semibold" for="FISH_FCOMP_CPF_POSSUI">Possuí C.P.F.?</label>
                            <select name="FISH_FCOMP_CPF_POSSUI" id="FISH_FCOMP_CPF_POSSUI" class="form-control">
                                <option value="0" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_CPF_POSSUI'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option value="1" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_CPF_POSSUI'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option value="2" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_CPF_POSSUI'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                                <option value="3" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_CPF_POSSUI'], '3') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SABE</option>
                                <option value="4" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_CPF_POSSUI'], '4') == 0) : ?>selected="selected"<?php endif; ?>>NÃO SE APLICA</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FCOMP_CPF_NUMERO">Número do C.P.F.:</label>
                            <input type="text" name="FISH_FCOMP_CPF_NUMERO" class="form-control" id="FISH_FCOMP_CPF_NUMERO" placeholder="Número do C.P.F...." value="<?php echo $vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_CPF_NUMERO']; ?>">
                        </div>
						<div class="col-lg-4">
                            <label class="form-label semibold" for="FISH_FCOMP_RESIDENTE">Componente residente?</label>
                            <select name="FISH_FCOMP_RESIDENTE" id="FISH_FCOMP_RESIDENTE" class="form-control">
                                <option value="0" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RESIDENTE'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
                                <option value="1" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RESIDENTE'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
                                <option value="2" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_RESIDENTE'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
                            </select>
                        </div>
                    </div> <!-- Dados do C.P.F. -->
					</br>
					<table id="table-sm" class="table table-bordered table-hover table-sm">
						<thead><tr><th colspan="4"><font color="#000000">Participação no Processo de ATES</font></th></tr></thead>
						<tbody>
							<tr>
								<td colspan="1">
								<label class="form-label semibold" for="FISH_FCOMP_ATES_DELEGADO">Delegado?</label>
								<select name="FISH_FCOMP_ATES_DELEGADO" id="FISH_FCOMP_ATES_DELEGADO" class="form-control">
									<option value="0" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ATES_DELEGADO'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
									<option value="1" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ATES_DELEGADO'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
									<option value="2" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ATES_DELEGADO'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
								</select>
								</td>
								<td colspan="1">
								<label class="form-label semibold" for="FISH_FCOMP_ATES_FICHAPROPOSTA">Proposta de Adesão?</label>
								<select name="FISH_FCOMP_ATES_FICHAPROPOSTA" id="FISH_FCOMP_ATES_FICHAPROPOSTA" class="form-control">
									<option value="0" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ATES_FICHAPROPOSTA'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
									<option value="1" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ATES_FICHAPROPOSTA'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
									<option value="2" <?php if (strcasecmp($vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ATES_FICHAPROPOSTA'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
								</select>
								</td>
								<td colspan="1">
								<label class="form-label semibold" for="FISH_FCOMP_ATES_NUMEROCOOPP">Matrícula do Cooperado:</label>
								<input type="text" name="FISH_FCOMP_ATES_NUMEROCOOPP" class="form-control" id="FISH_FCOMP_CPF_NUMERO" placeholder="Número do C.P.F...." value="<?php echo $vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ATES_NUMEROCOOPP']; ?>">
								</td>
							</tr>
						</tbody>
					</table>
					</br>
					<table id="table-sm" class="table table-bordered table-hover table-sm">
						<thead><tr><th colspan="4"><font color="#000000">Foto Pessoal</font></th></tr></thead>
						<tbody>
							<tr>
                                <td colspan="1" align="center" valign="middle"><img src="fotospessoais/<?php echo $vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_FOTOPESSOAL']; ?>" width="120px" height="160px"></td>
								<td colspan="2">
									<label class="form-label semibold" for="FISH_FCOMP_FOTOPESSOAL">Arquivo:</label>
									<input type='file' name="FISH_FCOMP_FOTOPESSOAL" class="form-control" id="FISH_FCOMP_FOTOPESSOAL"?>
								</td>
								<td colspan="1" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="relatorio_fish_cooperativa_ficha.php?id=<?php echo $vetor_FAMILIA_COMPOSICAO['FISH_FCOMP_ID']; ?>"><img src="imgs/individual_form.png" width="50" height="50" border="0"></a><a class="fancybox fancybox.ajax" href="relatorio_fish_cooperativa_formulario.php?id_familia=<?php echo $id_familia; ?>"><img src="imgs/full_form.png" width="50" height="50" border="0"></a></td>
							</tr>
						</tbody>
					</table>
					</br>
					<div class="form-group row">
						<div class="col-lg-2"><input name="pesq" type="image" src="imgs/salvar.png" class="float" /></div>
					</div>
				</form>
			</div><!--.box-typical--><br>
   			<div class="box-typical box-typical-padding">
                	<div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                           	<li><a href="#view1">Dados do Questionário</a></li>
                           	<li><a href="#view2">Projetos Preteridos</a></li>
                            <li><a href="#view3">Documentos Pessoais</a></li>
                        </ul>
                    </div>
			        <div class="tabcontents">
						<div id="view1">
						</div> <!-- Dados do Questionário -->
                        <div id="view2">
							<div id="scroll_projetos">
								<form action="recebe_fish_cadastrar_coopint_projeto.php?id=<?php echo $id; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_fish_cadastrar_coopint_projeto" enctype="multipart/form-data" id="recebe_fish_cadastrar_coopint_projeto">
									<table width="100%">
										<thead>
											<td width="68%">Projetos Preteridos</td>
											<td width="2%">&nbsp;</td>
											<td width="18%">Ordem</td>
											<td width="2%">&nbsp;</td>
											<td width="10%">&nbsp;</td>
										</thead>
									</table>
									<div id="campoPai_COOPINT_PROJETO"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
									</br><input type="button" value="Novo" onClick="addCampos_COOPINT_PROJETO()" class="btn btn-inline">
									<input type="submit" value="Salvar" class="btn btn-inline"></br></br>
								</form>
								<table width="100%">
									<thead>
										<td width="68%">Projetos Preteridos</td>
										<td width="2%">&nbsp;</td>
										<td width="18%">Ordem</td>
										<td width="2%">&nbsp;</td>
										<td width="10%">Ações</td>
									</thead>
									<?php
										$sql_COOPINT_PROJETO = mysql_query("SELECT TAB_FISH_COOPINT_PROJETO.FISH_FIPROJ_ID, TAB_FISH_COOPINT_PROJETO.FISH_FIPROJ_ORDEM, TAB_APOIO_CONTRIBUICOESCOOP.DESCRICAO AS FISH_FIPROJ_PROJETO_DESC FROM TAB_FISH_COOPINT_PROJETO LEFT OUTER JOIN TAB_APOIO_CONTRIBUICOESCOOP ON TAB_APOIO_CONTRIBUICOESCOOP.ID = TAB_FISH_COOPINT_PROJETO.FISH_FIPROJ_PROJETO WHERE TAB_FISH_COOPINT_PROJETO.FISH_FCOMP_ID = '$id' ORDER BY TAB_FISH_COOPINT_PROJETO.FISH_FIPROJ_ORDEM ASC, FISH_FIPROJ_PROJETO_DESC ASC;", $db) or die( mysql_error());
										$cor = "#D8D8D8";
										while ($vetor_COOPINT_PROJETO = mysql_fetch_array($sql_COOPINT_PROJETO)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
											} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="68%"><?php echo $vetor_COOPINT_PROJETO['FISH_FIPROJ_PROJETO_DESC']; ?></td>
										<td width="2%">&nbsp;</td>
										<td width="18%" align="center"><?php echo $vetor_COOPINT_PROJETO['FISH_FIPROJ_ORDEM']; ?></td>
										<td width="2%">&nbsp;</td>
										<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_coopint_projeto.php?FISH_FIPROJ_ID=<?php echo $vetor_COOPINT_PROJETO['FISH_FIPROJ_ID']; ?>&id=<?php echo $id;?>&id_familia=<?php echo $id_familia;?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
							</div>                                
						</div> <!-- Projetos Preteridos -->
						<div id="view3">
						</div> <!-- Documentos Pessoais -->
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