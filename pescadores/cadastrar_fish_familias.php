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
			$sql_BAIRROS = mysql_query("SELECT TAB_APOIO_BAIRROS.ID, TAB_APOIO_BAIRROS.DESCRICAO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS MUNICIPIO, TAB_APOIO_UF.SIGLA AS UF FROM TAB_APOIO_BAIRROS LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_APOIO_BAIRROS.MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_BAIRROS.DESCRICAO ASC, MUNICIPIO ASC;", $db) or die(mysql_error());
			$sql_LOCALIDADES = mysql_query("SELECT TAB_APOIO_LOCALIDADES.ID, TAB_APOIO_LOCALIDADES.DESCRICAO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS MUNICIPIO, TAB_APOIO_UF.SIGLA AS UF FROM TAB_APOIO_LOCALIDADES LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_APOIO_LOCALIDADES.MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_LOCALIDADES.DESCRICAO ASC, MUNICIPIO ASC;", $db) or die(mysql_error());
			$sql_MUNIC_URB = mysql_query("SELECT TAB_APOIO_MUNICIPIOS.ID, TAB_APOIO_MUNICIPIOS.DESCRICAO, TAB_APOIO_UF.SIGLA FROM TAB_APOIO_MUNICIPIOS LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_MUNICIPIOS.DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_USOIMOVEL_URB = mysql_query("SELECT * FROM TAB_APOIO_USOIMOVEL WHERE ID > 0 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_MUNIC_RUR = mysql_query("SELECT TAB_APOIO_MUNICIPIOS.ID, TAB_APOIO_MUNICIPIOS.DESCRICAO, TAB_APOIO_UF.SIGLA FROM TAB_APOIO_MUNICIPIOS LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_MUNICIPIOS.DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_USOIMOVEL_RUR = mysql_query("SELECT * FROM TAB_APOIO_USOIMOVEL WHERE ID > 0 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_FUSOS = mysql_query("select * from TAB_APOIO_FUSOS order by DESCRICAO ASC;", $db) or die(mysql_error());
?>
<?php require_once("includes/header-completo.php");?>
<style type="text/css">
<!--
#scroll {
  width:100%;
  height:400px;
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
							<h3>Familias - Projetos de Atendimento dos Pescadores</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Cadastro de Famílias - v.1.0.5.3</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_fish_cadastrar_familias.php" method="post" name="familias" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-9">
                        	<label class="form-label semibold" for="exampleInput">Nome do Chefe/Pescador:</label>
                            <input type="text" name="FISH_FAM_CHEFE_NOME" class="form-control" id="FISH_FAM_CHEFE_NOME" placeholder="Digite o nome do Chefe da Família/Pescador...">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Apelido do Chefe/Pescador:</label>
                            <input type="text" name="FISH_FAM_CHEFE_APELIDO" class="form-control" id="FISH_FAM_CHEFE_APELIDO" placeholder="Digite o apelido...">
                        </div>
                    </div> <!-- Nome e Apelido do Chefe -->
                    <div class="form-group row">
                        <div class="col-lg-9">
                        	<label class="form-label semibold" for="exampleInput">Nome do Cônjuge:</label>
                            <input type="text" name="FISH_FAM_CONJ_NOME" class="form-control" id="FISH_FAM_CONJ_NOME" placeholder="Digite o nome do Cônjuge...">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Apelido do Cônjuge:</label>
                            <input type="text" name="FISH_FAM_CONJ_APELIDO" class="form-control" id="FISH_FAM_CONJ_APELIDO" placeholder="Digite o apelido...">
                        </div>
                    </div> <!-- Nome e Apelido do Cônjuge -->
                    <div class="form-group row">
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Participante das Oficinas?</label>
                            <select name="FISH_FAM_STT_OFIC" id="FISH_FAM_STT_OFIC" class="form-control">
                                <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                <option label="SIM" value="1">SIM</option>
                                <option label="NAO" value="2">NÃO</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label semibold" for="exampleInput">Caso Emergencial?</label>
                            <select name="FISH_FAM_STT_EMER" id="FISH_FAM_STT_EMER" class="form-control">
                                <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                <option label="SIM" value="1">SIM</option>
                                <option label="NAO" value="2">NÃO</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Usuário do Porto?</label>
                            <select name="FISH_FAM_STT_PORT" id="FISH_FAM_STT_PORT" class="form-control">
                                <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                <option label="SIM" value="1">SIM</option>
                                <option label="NAO" value="2">NÃO</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="FISH_FAM_STT_COOP">Identificação p/ COOPPBM?</label>
                            <select name="FISH_FAM_STT_COOP" id="FISH_FAM_STT_COOP" class="form-control">
                                <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                <option label="SIM" value="1">SIM</option>
                                <option label="NAO" value="2">NÃO</option>
                            </select>
                        </div>
                    </div> <!-- Enquadramentos das Famílias de Pescadores -->
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-label semibold" for="exampleInput">Data do Primeiro Atendimento:</label>
                            <input type="text" name="FISH_FAM_DTREGISTRO" class="form-control" id="FISH_FAM_DTREGISTRO" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Possuí Endereço Urbano?</label>
                            <select name="FISH_FAM_ENDURB" id="FISH_FAM_ENDURB" class="form-control">
                                <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                <option label="SIM" value="1">SIM</option>
                                <option label="NAO" value="2">NÃO</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Possuí Endereço Rural?</label>
                            <select name="FISH_FAM_ENDRUR" id="FISH_FAM_ENDRUR" class="form-control">
                                <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                <option label="SIM" value="1">SIM</option>
                                <option label="NAO" value="2">NÃO</option>
                            </select>
                        </div>
                    </div> <!-- Data da Entrada e Status dos Endereços -->
                    <div class="form-group row">
                        <div class="col-lg-6">
							<label class="form-label semibold" for="exampleInput">Endereço Urbano:</label>
                            <input type="text" name="FISH_FAM_ENDURB_LOGR" class="form-control" id="FISH_FAM_ENDURB_LOGR" placeholder="Digite o endereço...">
                        </div>
                        <div class="col-lg-6">
							<label class="form-label semibold" for="exampleInput">Complemente/Ponto de Referência:</label>
                            <input type="text" name="FISH_FAM_ENDURB_COMPL" class="form-control" id="FISH_FAM_ENDURB_COMPL" placeholder="Digite algum complementou ou ponto de referência...">
                        </div>
                    </div> <!-- Endereço Urbano / Complemento e Ponto de Referência Urbano -->
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Bairro:</label>
                            <select name="FISH_FAM_ENDURB_BAIRRO" id="FISH_FAM_ENDURB_BAIRRO" class="form-control">
                                <option value="0" selected="selected">Selecione um Bairro...</option>
								<?php while ($vetor_BAIRROS=mysql_fetch_array($sql_BAIRROS)) { ?>
                                <option value="<?php echo $vetor_BAIRROS['ID']; ?>"><?php echo $vetor_BAIRROS['DESCRICAO']." (".$vetor_BAIRROS['MUNICIPIO']."/".$vetor_BAIRROS['UF'].")"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Município:</label>
                            <select name="FISH_FAM_ENDURB_MUNIC" id="FISH_FAM_ENDURB_MUNIC" class="form-control">
                                <option value="0" selected="selected">Selecione um Município...</option>
								<?php while ($vetor_MUNIC_URB=mysql_fetch_array($sql_MUNIC_URB)) { ?>
                                <option value="<?php echo $vetor_MUNIC_URB['ID']; ?>"><?php echo $vetor_MUNIC_URB['DESCRICAO']."/".$vetor_MUNIC_URB['SIGLA']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FAM_ENDURB_USO">Uso principal do Imóvel:</label>
                            <select name="FISH_FAM_ENDURB_USO" id="FISH_FAM_ENDURB_USO" class="form-control">
                                <option value="0" selected="selected">Selecione um Tipo de Uso...</option>
								<?php while ($vetor_USOIMOVEL_URB=mysql_fetch_array($sql_USOIMOVEL_URB)) { ?>
                                <option value="<?php echo $vetor_USOIMOVEL_URB['ID']; ?>"><?php echo $vetor_USOIMOVEL_URB['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Bairro e Município Urbano e Uso do Imóvel Urbano -->
                    <div class="form-group row">
                        <div class="col-lg-6">
							<label class="form-label semibold" for="exampleInput">Endereço Rural:</label>
                            <input type="text" name="FISH_FAM_ENDRUR_LOGR" class="form-control" id="FISH_FAM_ENDRUR_LOGR" placeholder="Digite o endereço...">
                        </div>
                        <div class="col-lg-6">
							<label class="form-label semibold" for="exampleInput">Complemente/Ponto de Referência:</label>
                            <input type="text" name="FISH_FAM_ENDRUR_COMPL" class="form-control" id="FISH_FAM_ENDRUR_COMPL" placeholder="Digite algum complementou ou ponto de referência...">
                        </div>
                    </div> <!-- Endereço Rural / Complemento e Ponto de Referência Rural -->
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Localidade Rural:</label>
                            <select name="FISH_FAM_ENDRUR_LOCAL" id="FISH_FAM_ENDRUR_LOCAL" class="form-control">
                                <option value="0" selected="selected">Selecione uma Localidade...</option>
								<?php while ($vetor_LOCALIDADES=mysql_fetch_array($sql_LOCALIDADES)) { ?>
                                <option value="<?php echo $vetor_LOCALIDADES['ID']; ?>"><?php echo $vetor_LOCALIDADES['DESCRICAO']." (".$vetor_LOCALIDADES['MUNICIPIO']."/".$vetor_LOCALIDADES['UF'].")"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Município:</label>
                            <select name="FISH_FAM_ENDRUR_MUNIC" id="FISH_FAM_ENDRUR_MUNIC" class="form-control">
                                <option value="0" selected="selected">Selecione um Município...</option>
								<?php while ($vetor_MUNIC_RUR=mysql_fetch_array($sql_MUNIC_RUR)) { ?>
                                <option value="<?php echo $vetor_MUNIC_RUR['ID']; ?>"><?php echo $vetor_MUNIC_RUR['DESCRICAO']."/".$vetor_MUNIC_RUR['SIGLA']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_FAM_ENDRUR_USO">Uso principal do Imóvel:</label>
                            <select name="FISH_FAM_ENDRUR_USO" id="FISH_FAM_ENDRUR_USO" class="form-control">
                                <option value="0" selected="selected">Selecione um Tipo de Uso...</option>
								<?php while ($vetor_USOIMOVEL_RUR=mysql_fetch_array($sql_USOIMOVEL_RUR)) { ?>
                                <option value="<?php echo $vetor_USOIMOVEL_RUR['ID']; ?>"><?php echo $vetor_USOIMOVEL_RUR['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Localidade e Município Rural e Uso do Imóvel Rural -->
                    <div class="form-group row">
                        <div class="col-lg-12">
							<label class="form-label semibold" for="FISH_FAM_ENDRUR_ACESSO">Acessos ao Imóvel Rural (TERRA/ÁGUA):</label>
                            <textarea rows="3" name="FISH_FAM_ENDRUR_ACESSO" id="FISH_FAM_ENDRUR_ACESSO" class="form-control" placeholder="Rotas de acesso..."></textarea>
                        </div>
					</div> <!-- Acessos ao Imóvel Rural -->
                    <div class="form-group row">
                        <div class="col-lg-3">
							<label class="form-label semibold" for="exampleInput">Telefones:</label>
                            <input type="text" name="FISH_FAM_TELEFONES" class="form-control" id="FISH_FAM_TELEFONES" placeholder="Digite os telefones de contato...">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Coordenadas UTM E:</label>
                            <input type="text" name="FISH_FAM_UTME" class="form-control" id="FISH_FAM_UTME" placeholder="Digite as coordenadas UTM E...">
						</div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Coordenadas UTM N:</label>
                            <input type="text" name="FISH_FAM_UTMN" class="form-control" id="FISH_FAM_UTMN" placeholder="Digite as coordenadas UTM N...">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Fuso das Coordenadas:</label>
                            <select name="FISH_FAM_FUSO" id="FISH_FAM_FUSO" class="form-control">
                                <option value="0" selected="selected">Selecione uma Opção...</option>
								<?php while ($vetor_FUSOS=mysql_fetch_array($sql_FUSOS)) { ?>
                                <option value="<?php echo $vetor_FUSOS['ID']; ?>"><?php echo $vetor_FUSOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Telefones/Coordenadas UTM E/Coordenadas UTM N/Fuso das Coordenadas -->
                    <div class="form-group row">
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Possuí Outro Cadastro?</label>
                            <select name="FISH_FAM_LINK_STATUS" id="FISH_FAM_LINK_STATUS" class="form-control">
                                <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                <option label="SIM" value="1">SIM</option>
                                <option label="NAO" value="2">NÃO</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
							<label class="form-label semibold" for="exampleInput">Código da Família:</label>
                            <input type="text" name="FISH_FAM_LINK_CODIGO" class="form-control" id="FISH_FAM_LINK_CODIGO" placeholder="Digite o código da Família...">
                        </div>
                        <div class="col-lg-6">&nbsp;</div>
                    </div> <!-- Cadastro ATES/Reparação Rural/Ribeirinhos, Código do Cadastro -->
                    </br>
			</div><!--.box-typical-->
   			<div class="box-typical box-typical-padding">
                	<div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">Situação Geral</a></li>
                        </ul>
                        <div class="tabcontents">
                            <div id="view1">
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label class="form-label semibold" for="exampleInput">Situação Emergêncial?</label>
                                        <select name="FISH_DADOS_EMERG" id="FISH_DADOS_EMERG" class="form-control">
                                            <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                            <option label="SIM" value="1">SIM</option>
                                            <option label="NAO" value="2">NÃO</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label semibold" for="exampleInput">Família Vulnerável?</label>
                                        <select name="FISH_DADOS_VULNERAVEL" id="FISH_DADOS_VULNERAVEL" class="form-control">
                                            <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                            <option label="SIM" value="1">SIM</option>
                                            <option label="NAO" value="2">NÃO</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label semibold" for="exampleInput">Barco - Novo?</label>
                                        <select name="FISH_DADOS_BARCO_NOVO" id="FISH_DADOS_BARCO_NOVO" class="form-control">
                                            <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                            <option label="SIM" value="1">SIM</option>
                                            <option label="NAO" value="2">NÃO</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label semibold" for="exampleInput">Barco - Reparos?</label>
                                        <select name="FISH_DADOS_BARCO_REPARO" id="FISH_DADOS_BARCO_REPARO" class="form-control">
                                            <option label="NI" value="0" selected="selected">Selecione uma opção...</option>
                                            <option label="SIM" value="1">SIM</option>
                                            <option label="NAO" value="2">NÃO</option>
                                        </select>
                                    </div>
                                </div> <!-- Linha 01 -->
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label class="form-label semibold" for="exampleInput">Relato da Situação da Família:</label>
                                        <textarea rows="2" name="FISH_DADOS_SINTESE" id="FISH_DADOS_SINTESE" class="form-control" placeholder="Digite o relato da situação da família..."></textarea>
                                    </div>
                                </div> <!-- Linha 02 -->    
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label class="form-label semibold" for="exampleInput">Relato da Situação da Embarcação:</label>
                                        <textarea rows="2" name="FISH_DADOS_EMBARCACAO" id="FISH_DADOS_EMBARCACAO" class="form-control" placeholder="Digite o relato da situação da embarcação..."></textarea>
                                    </div>
                                </div> <!-- Linha 03 -->
                            </div> <!-- Dados Gerais -->
						</div>
                    </div>
					</br>
            </div><!--.box-typical-->
			<input name="pesq" type="image" src="imgs/salvar.png" class="float" />
            </form>
		</div><!--.container-fluid-->
	</div><!--.page-content-->
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>