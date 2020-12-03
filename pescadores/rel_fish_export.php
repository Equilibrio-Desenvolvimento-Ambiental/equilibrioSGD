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
			$sql_TPEVENTOS_01 = mysql_query("select * from TAB_APOIO_EVENTOS order by DESCRICAO ASC", $db);
			$sql_TPEVENTOS_02 = mysql_query("select * from TAB_APOIO_EVENTOS order by DESCRICAO ASC", $db);
			$sql_TPATIV_01 = mysql_query("select * from TAB_APOIO_TPVISITFISH order by DESCRICAO ASC", $db);
			$sql_TPATIV_02 = mysql_query("select * from TAB_APOIO_TPVISITFISH order by DESCRICAO ASC", $db);
			$sql_TPSUBATIV_01 = mysql_query("select * from TAB_APOIO_TPSUBVISITFISH order by DESCRICAO ASC", $db);
			$sql_TPSUBATIV_02 = mysql_query("select * from TAB_APOIO_TPSUBVISITFISH order by DESCRICAO ASC", $db);
?>
<?php require_once("includes/header-completo.php");?>
<script type="text/javascript">
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
function mtel(v){
    v=v.replace(/\D/g,"");
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2");
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript">  
$(document).ready(function(){  
		$("#palco01 > div").hide(); 
		$("#filter01").change(function(){  
                $("#palco01 > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
});  
$(document).ready(function(){  
		$("#palco02 > div").hide(); 
		$("#filter02").change(function(){  
                $("#palco02 > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
});  
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
							<h3>Projetos de Atendimento dos Pescadores</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Geração de Dados - v.1.0.0.7</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<table id="table-sm" class="table table-bordered table-hover table-sm">
				<thead><tr><th colspan="3">Exportação de dados - Acompanhamentos</th></tr></thead>
				<tbody>
					<tr>
						<td colspan="3">
							<div class="form-group row">
								<div class="col-lg-4">
									<label class="form-label semibold" for="FISH_REL_FILTER_ACOMP_CAMP">Campanha:</label>
									<select name="FISH_REL_FILTER_ACOMP_CAMP" id="FISH_REL_FILTER_ACOMP_CAMP" class="form-control">
	                                    <option value="0" selected>Selecione uma Campanha...</option>
										<?php while ($vetor_TPEVENTOS_01=mysql_fetch_array($sql_TPEVENTOS_01)) { ?>
										<option value="<?php echo $vetor_TPEVENTOS_01['ID'] ?>"><?php echo $vetor_TPEVENTOS_01['DESCRICAO'] ?></option><?php } ?>
									</select>
								</div>
								<div class="col-lg-4">
									<label class="form-label semibold" for="FISH_REL_FILTER_ACOMP_DTINI">Data Inicial:</label>
									<input type="text" name="FISH_REL_FILTER_ACOMP_DTINI" class="form-control" id="FISH_REL_FILTER_ACOMP_DTINI" placeholder="Data Inicial..." onKeyPress="mascara(this,mdata)" maxlength="10">
								</div>
								<div class="col-lg-4">
									<label class="form-label semibold" for="FISH_REL_FILTER_ACOMP_CAMP">Data Final:</label>
									<input type="text" name="FISH_REL_FILTER_ACOMP_DTFIM" class="form-control" id="FISH_REL_FILTER_ACOMP_DTFIM" placeholder="Data Inicial..." onKeyPress="mascara(this,mdata)" maxlength="10">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center" width="33%"><label class="form-label semibold">Blocos Completo</label><a class="fancybox fancybox.ajax" href="excel_fish_acomp_completo.php"><img src="imgs/excel.png" width="100" height="100" border="0"></td>

						<td align="center" width="33%"><label class="form-label semibold">Multiplas Respostas - Bloco B</label><a class="fancybox fancybox.ajax" href="excel_fish_acomp_quest_b01.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Questão B01"></a>&nbsp;&nbsp;&nbsp;<a class="fancybox fancybox.ajax" href="excel_fish_acomp_quest_b12.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Questão B12"></a>&nbsp;&nbsp;&nbsp;<a class="fancybox fancybox.ajax" href="excel_fish_acomp_quest_b14.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Questão B14"></td>

						<td align="center" width="33%"><label class="form-label semibold">Multiplas Respostas - Bloco C</label><a class="fancybox fancybox.ajax" href="excel_fish_acomp_quest_c14.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Questão C14"></a>&nbsp;&nbsp;&nbsp;<a class="fancybox fancybox.ajax" href="excel_fish_acomp_quest_c21.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Questão C21"></a></td>
					</tr>
				</tbody>
			</table></br>

			<form action="excel_fish_eventos_lista.php" method="post" name="form_eventos_lista" onSubmit="return validaForm()">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th colspan="2">Exportação de Listagem e Dados dos Atendimentos - EMERGENCIAIS</th>
                        </tr>
                    </thead>
                	<tbody>
                    	<tr>
                            <td width="40%">
                                <select name="filter01" id="filter01" class="form-control" required>
                                    <option value="0" selected>Selecione a exportação desejada...</option>
                                    <option value="1">Por Tipo de Evento/Por Período de Data</option>
                                    <option value="2">Por Tipo de Evento/Qualquer Período de Data</option>
                                    <option value="3">Qualquer Tipo de Evento/Por Período de Data</option>
                                    <option value="4">Por Tipo de Atividade/Por Período de Data</option>
                                    <option value="5">Por Tipo de Atividade/Qualquer Período de Data</option>
                                    <option value="6">Qualquer Tipo de Atividade/Por Período de Data</option>
                                    <option value="7">Por Tipo de Sub-Atividade/Por Período de Data</option>
                                    <option value="8">Por Tipo de Sub-Atividade/Qualquer Período de Data</option>
                                    <option value="9">Qualquer Tipo de Sub-Atividade/Por Período de Data</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco01">
                                    <div id="0">&nbsp;</div>
                                    <div id="1">
                                    	Tipo do Evento: <select name="FISH_EVE_TIPO_01" id="FISH_EVE_TIPO_01" class="form-control">
                                            <?php while ($vetor_TPEVENTOS_01=mysql_fetch_array($sql_TPEVENTOS_01)) { ?>
                                            <option value="<?php echo $vetor_TPEVENTOS_01['ID'] ?>"><?php echo $vetor_TPEVENTOS_01['DESCRICAO'] ?></option><?php } ?>
										</select>
										Data Inicio: <input type="text" name="FISH_EVE_DATA_INI_01" class="form-control" id="FISH_EVE_DATA_INI_01" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="FISH_EVE_DATA_FIM_01" class="form-control" id="FISH_EVE_DATA_FIM_01" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                       
                                    </div>
                                    <div id="2">
                                    	Tipo do Evento: <select name="FISH_EVE_TIPO_02" id="FISH_EVE_TIPO_02" class="form-control">
                                            <?php while ($vetor_TPEVENTOS_02=mysql_fetch_array($sql_TPEVENTOS_02)) { ?>
                                            <option value="<?php echo $vetor_TPEVENTOS_02['ID'] ?>"><?php echo $vetor_TPEVENTOS_02['DESCRICAO'] ?></option><?php } ?>
										</select>
                                    </div>
                                    <div id="3">
										Data Inicio: <input type="text" name="FISH_EVE_DATA_INI_03" class="form-control" id="FISH_EVE_DATA_INI_03" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="FISH_EVE_DATA_FIM_03" class="form-control" id="FISH_EVE_DATA_FIM_03" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                       
                                    </div>
                                    <div id="4">
                                    	Tipo da Atividade: <select name="FISH_CLASS_TIPO_04" id="FISH_CLASS_TIPO_04" class="form-control">
                                            <?php while ($vetor_TPATIV_01=mysql_fetch_array($sql_TPATIV_01)) { ?>
                                            <option value="<?php echo $vetor_TPATIV_01['ID'] ?>"><?php echo $vetor_TPATIV_01['DESCRICAO'] ?></option><?php } ?>
										</select>
										Data Inicio: <input type="text" name="FISH_EVE_DATA_INI_04" class="form-control" id="FISH_EVE_DATA_INI_04" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="FISH_EVE_DATA_FIM_04" class="form-control" id="FISH_EVE_DATA_FIM_04" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                       
                                    </div>
                                    <div id="5">
                                    	Tipo da Atividade: <select name="FISH_CLASS_TIPO_05" id="FISH_CLASS_TIPO_05" class="form-control">
                                            <?php while ($vetor_TPATIV_02=mysql_fetch_array($sql_TPATIV_02)) { ?>
                                            <option value="<?php echo $vetor_TPATIV_02['ID'] ?>"><?php echo $vetor_TPATIV_02['DESCRICAO'] ?></option><?php } ?>
										</select>
                                    </div>
                                    <div id="6">
										Data Inicio: <input type="text" name="FISH_EVE_DATA_INI_06" class="form-control" id="FISH_EVE_DATA_INI_06" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="FISH_EVE_DATA_FIM_06" class="form-control" id="FISH_EVE_DATA_FIM_06" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                       
                                    </div>
                                    <div id="7">
                                    	Tipo da Sub-Atividade: <select name="FISH_CLASS_SUBTIPO_07" id="FISH_CLASS_SUBTIPO_07" class="form-control">
                                            <?php while ($vetor_TPSUBATIV_01=mysql_fetch_array($sql_TPSUBATIV_01)) { ?>
                                            <option value="<?php echo $vetor_TPSUBATIV_01['ID'] ?>"><?php echo $vetor_TPSUBATIV_01['DESCRICAO'] ?></option><?php } ?>
										</select>
										Data Inicio: <input type="text" name="FISH_EVE_DATA_INI_07" class="form-control" id="FISH_EVE_DATA_INI_07" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="FISH_EVE_DATA_FIM_07" class="form-control" id="FISH_EVE_DATA_FIM_07" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                       
                                    </div>
                                    <div id="8">
                                    	Tipo da Sub-Atividade: <select name="FISH_CLASS_SUBTIPO_08" id="FISH_CLASS_SUBTIPO_08" class="form-control">
                                            <?php while ($vetor_TPSUBATIV_02=mysql_fetch_array($sql_TPSUBATIV_02)) { ?>
                                            <option value="<?php echo $vetor_TPSUBATIV_02['ID'] ?>"><?php echo $vetor_TPSUBATIV_02['DESCRICAO'] ?></option><?php } ?>
										</select>
                                    </div>
                                    <div id="9">
										Data Inicio: <input type="text" name="FISH_EVE_DATA_INI_09" class="form-control" id="FISH_EVE_DATA_INI_09" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="FISH_EVE_DATA_FIM_09" class="form-control" id="FISH_EVE_DATA_FIM_09" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                       
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
				</table>
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                    <tr>
                        <th><input name="buscar" class="float" type="image" src="imgs/buscar.png" value="Buscar" /></th>
                    </tr>
                    </thead>
                </table>
			</form></br>
            <table id="table-sm" class="table table-bordered table-hover table-sm">
            	<thead>
                	<tr>
                    	<th colspan="3">Exportações em EXCEL</th>
                    </tr>
                </thead>
                <tbody>
                	<tr>
                    	<td align="center" width="33%"><label class="form-label semibold" for="exampleInput">Geral de Encaminhamentos</label><a class="fancybox fancybox.ajax" href="excel_fish_encaminhamentos_geral.php"><img src="imgs/excel.png" width="50" height="50" border="0"></td>
                    	<td align="center" width="33%"><label class="form-label semibold" for="exampleInput">1ªCampanha de Acompanhamento</label><a class="fancybox fancybox.ajax" href="excel_fish_1camp_acomp.php"><img src="imgs/excel.png" width="50" height="50" border="0"></td>
                    	<td align="center" width="33%"><label class="form-label semibold" for="exampleInput">Geral de Eventos</label><a class="fancybox fancybox.ajax" href="excel_fish_eventos_geral.php"><img src="imgs/excel.png" width="50" height="50" border="0"></td>
                    </tr>
				</tbody>
            </table></br>

			<table id="table-sm" class="table table-bordered table-hover table-sm">
				<thead><tr><th colspan="5">Exportação de dados - Cooperativa</th></tr></thead>
				<tbody>
					<tr>
						<td align="center"><label class="form-label semibold">Planilha Completa / Resposatas Únicas</label><a class="fancybox fancybox.ajax" href="excel_fish_coop_completo.php"><img src="imgs/excel.png" width="100" height="100" border="0"></td>

						<td align="center"><label class="form-label semibold">Composição Familiar</label><a class="fancybox fancybox.ajax" href="excel_fish_composicaofamiliar_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Composição Familiar"></a></td>

						<td align="center"><label class="form-label semibold">Multiplas Respostas - Bloco 01</label><a class="fancybox fancybox.ajax" href="excel_fish_projuhe_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Outros Programas da Norte Energia/UHE Belo Monte"></a><a class="fancybox fancybox.ajax" href="excel_fish_despesas_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Despesas da Família"></a><br/><a class="fancybox fancybox.ajax" href="excel_fish_outrasrendas_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Outras Rendas (R$)"></a><a class="fancybox fancybox.ajax" href="excel_fish_beneficios_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Benefícios Sociais"></a></td>

						<td align="center"><label class="form-label semibold">Multiplas Respostas - Bloco 02</label><a class="fancybox fancybox.ajax" href="excel_fish_motivos_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Motivos de Não Pescar"></a><a class="fancybox fancybox.ajax" href="excel_fish_especies_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Espécies mais pescadas"></a><a class="fancybox fancybox.ajax" href="excel_fish_locais_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Pontos de pesca"></a><br/>
							
						<a class="fancybox fancybox.ajax" href="excel_fish_comercio_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Comercialização da produção"></a><a class="fancybox fancybox.ajax" href="excel_fish_embarc_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Embarcações"></a><a class="fancybox fancybox.ajax" href="excel_fish_embarc_valid.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Embarcações (Validação)"></a><br/>
							
						<a class="fancybox fancybox.ajax" href="excel_fish_motores_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Motores"></a><a class="fancybox fancybox.ajax" href="excel_fish_motores_valid.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Motores (Validação)"></a><a class="fancybox fancybox.ajax" href="excel_fish_tralhas_completo.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Tralhas"></a></td>

						<td align="center"><label class="form-label semibold">Multiplas Respostas - Bloco 03</label><a class="fancybox fancybox.ajax" href="#"><img src="imgs/excel.png" width="50" height="50" border="0"></a>&nbsp;&nbsp;&nbsp;<a class="fancybox fancybox.ajax" href="#"><img src="imgs/excel.png" width="50" height="50" border="0"></a></td>

					</tr>
				</tbody>
			</table></br>

			<table id="table-sm" class="table table-bordered table-hover table-sm">
				<thead><tr><th colspan="5">Exportação de dados - Adesão</th></tr></thead>
				<tbody>
					<tr>
						<td align="center"><label class="form-label semibold">Dados Gerais</label><a class="fancybox fancybox.ajax" href="excel_fish_cooperativa_dadosgerais.php"><img src="imgs/excel.png" width="50" height="50" border="0"></td>

						<td align="center"><label class="form-label semibold">Embarcação</label><a class="fancybox fancybox.ajax" href="excel_fish_cooperativa_embarcacoes.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Embarcação"></a></td>

						<td align="center"><label class="form-label semibold">Motores</label><a class="fancybox fancybox.ajax" href="excel_fish_cooperativa_motores.php"><img src="imgs/excel.png" width="50" height="50" border="0" alt="Motores"></a></td>
						
					</tr>
				</tbody>
			</table></br>


		</div>
	</div>
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>