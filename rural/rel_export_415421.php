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
		$("#palco03 > div").hide(); 
		$("#filter03").change(function(){  
                $("#palco03 > div").hide();  
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
							<h3>Gestão de Dados dos Projetos 4.1.5, 4.2.1 e Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Exportações de Dados - v. 1.1.2.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="excel_rgme_quadro.php" method="post" name="excel_rgme_quadro" onSubmit="return validaForm()">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
						<tr><th colspan="2">Quadros de Atividades</th></tr>
					</thead>
                	<tbody>
                    	<tr>
                            <td width="50%">
                                <select name="filter01" id="filter01" class="form-control" required>
                                    <option value="0" selected>Selecione o Relatório desejado...</option>
                                    <option value="41501">Rural/Reparação - Atividades/Sub-Atividades - Por Município/Setores</option>
                                    <option value="41502">Rural/Reparação - Atividades/Sub-Atividades - Por Opção de Benefício</option>
                                    <option value="41503">Rural/Reparação - Atividades/Sub-Atividades - Por Município/Setores & Opção de Benefício</option>
                                    <option value="41504">Rural/Reparação - Eventos - Por Município/Setores</option>
                                    <option value="41505">Rural/Reparação - Eventos - Por Técnico</option>
                                    <option value="42101">Rural/ATES - Atividades/Sub-Atividades - Por Município/Setores</option>
                                    <option value="42102">Rural/ATES - Atividades/Sub-Atividades - Por Opção de Benefício</option>
                                    <option value="42103">Rural/ATES - Atividades/Sub-Atividades - Por Município/Setores & Opção de Benefício</option>
                                    <option value="42104">Rural/ATES - Eventos - Por Município/Setores</option>
                                    <option value="42105">Rural/ATES - Eventos - Por Técnico</option>
                                    <option value="41511">RIR/Reparação - Atividades/Sub-Atividades - Por Município/Setores</option>
                                    <option value="41512">RIR/Reparação - Atividades/Sub-Atividades - Por Opção de Benefício</option>
                                    <option value="41513">RIR/Reparação - Atividades/Sub-Atividades - Por Município/Setores & Opção de Benefício</option>
                                    <option value="41514">RIR/Reparação - Eventos - Por Município/Setores</option>
                                    <option value="41515">RIR/Reparação - Eventos - Por Técnico</option>
                                    <option value="42111">RIR/ATES - Atividades/Sub-Atividades - Por Município/Setores</option>
                                    <option value="42112">RIR/ATES - Atividades/Sub-Atividades - Por Opção de Benefício</option>
                                    <option value="42113">RIR/ATES - Atividades/Sub-Atividades - Por Município/Setores & Opção de Benefício</option>
                                    <option value="42114">RIR/ATES - Eventos - Por Município/Setores</option>
                                    <option value="42115">RIR/ATES - Eventos - Por Técnico</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco01">
                                    <div id="0">&nbsp;</div>
                                    <div id="41501">
										Data Inicio: <input type="text" name="DATA_INI_41501" class="form-control" id="DATA_INI_41501" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_41501" class="form-control" id="DATA_FIM_41501" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="41502">
										Data Inicio: <input type="text" name="DATA_INI_41502" class="form-control" id="DATA_INI_41502" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_41502" class="form-control" id="DATA_FIM_41502" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="41503">
										Data Inicio: <input type="text" name="DATA_INI_41503" class="form-control" id="DATA_INI_41503" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_41503" class="form-control" id="DATA_FIM_41503" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="41504">
										Data Inicio: <input type="text" name="DATA_INI_41504" class="form-control" id="DATA_INI_41504" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_41504" class="form-control" id="DATA_FIM_41504" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="41505">
										Data Inicio: <input type="text" name="DATA_INI_41505" class="form-control" id="DATA_INI_41505" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_41505" class="form-control" id="DATA_FIM_41505" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="42101">
										Data Inicio: <input type="text" name="DATA_INI_42101" class="form-control" id="DATA_INI_42101" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_42101" class="form-control" id="DATA_FIM_42101" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="42102">
										Data Inicio: <input type="text" name="DATA_INI_42102" class="form-control" id="DATA_INI_42102" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_42102" class="form-control" id="DATA_FIM_42102" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="42103">
										Data Inicio: <input type="text" name="DATA_INI_42103" class="form-control" id="DATA_INI_42103" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_42103" class="form-control" id="DATA_FIM_42103" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="42104">
										Data Inicio: <input type="text" name="DATA_INI_42104" class="form-control" id="DATA_INI_42104" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_42104" class="form-control" id="DATA_FIM_42104" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="42105">
										Data Inicio: <input type="text" name="DATA_INI_42105" class="form-control" id="DATA_INI_42105" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_42105" class="form-control" id="DATA_FIM_42105" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="41511">
										Data Inicio: <input type="text" name="DATA_INI_41511" class="form-control" id="DATA_INI_41511" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_41511" class="form-control" id="DATA_FIM_41511" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="41512">
										Data Inicio: <input type="text" name="DATA_INI_41512" class="form-control" id="DATA_INI_41512" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_41512" class="form-control" id="DATA_FIM_41512" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="41513">
										Data Inicio: <input type="text" name="DATA_INI_41513" class="form-control" id="DATA_INI_41513" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_41513" class="form-control" id="DATA_FIM_41513" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="41514">
										Data Inicio: <input type="text" name="DATA_INI_41514" class="form-control" id="DATA_INI_41514" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_41514" class="form-control" id="DATA_FIM_41514" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="41515">
										Data Inicio: <input type="text" name="DATA_INI_41515" class="form-control" id="DATA_INI_41515" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_41515" class="form-control" id="DATA_FIM_41515" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="42111">
										Data Inicio: <input type="text" name="DATA_INI_42111" class="form-control" id="DATA_INI_42111" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_42111" class="form-control" id="DATA_FIM_42111" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="42112">
										Data Inicio: <input type="text" name="DATA_INI_42112" class="form-control" id="DATA_INI_42112" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_42112" class="form-control" id="DATA_FIM_42112" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="42113">
										Data Inicio: <input type="text" name="DATA_INI_42113" class="form-control" id="DATA_INI_42113" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_42113" class="form-control" id="DATA_FIM_42113" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="42114">
										Data Inicio: <input type="text" name="DATA_INI_42114" class="form-control" id="DATA_INI_42114" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_42114" class="form-control" id="DATA_FIM_42114" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="42115">
										Data Inicio: <input type="text" name="DATA_INI_42115" class="form-control" id="DATA_INI_42115" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_42115" class="form-control" id="DATA_FIM_42115" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
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
            </form>
            </br>
			<form action="excel_rgme_lista.php" method="post" name="excel_rgme_lista" onSubmit="return validaForm()">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr><th colspan="2">Relação Nominal de Atividades Realizadas no Período</th></tr>
                    </thead>
                	<tbody>
                    	<tr>
                            <td width="50%">
                                <select name="filter03" id="filter03" class="form-control" required>
                                    <option value="7" selected>Selecione o Relatório desejado...</option>
                                    <option value="8">RURAL - Reparação</option>
                                    <option value="9">RURAL - ATES</option>
                                    <option value="20">Ribeirinhos - Reparação</option>
                                    <option value="21">Ribeirinhos - ATES</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco03">
                                    <div id="7">&nbsp;</div>
                                    <div id="8">
										Data Inicio: <input type="text" name="DATA_INI_08" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_08" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="9">
										Data Inicio: <input type="text" name="DATA_INI_09" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_09" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="20">
										Data Inicio: <input type="text" name="DATA_INI_20" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_20" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="21">
										Data Inicio: <input type="text" name="DATA_INI_21" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="DATA_FIM_21" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
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
            </form>

            </br>
			<form action="excel_agenda.php" method="post" name="form_gerar_agenda" onSubmit="return validaForm()">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead><tr><th colspan="2">Geração de Dados da Agenda</th></tr></thead>
                	<tbody>
                    	<tr>
                            <td width="50%">
								Data Inicio: <input type="text" name="DATA_INI_AGENDA" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10">
                            </td>
                            <td>
								Data Fim: <input type="text" name="DATA_FIM_AGENDA" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">
                            </td>
						</tr>                            
                    </tbody>
				</table>
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                    <tr>
                        <th><input name="buscar" class="float" type="image" src="imgs/gerar.png" value="Gerar Agenda" /></th>
                    </tr>
                    </thead>
                </table>
            </form>
            </br>
            <table id="table-sm" class="table table-bordered table-hover table-sm">
            	<thead>
                	<tr>
                    	<th colspan="3">Listagem de Famílias - ÚLTIMO EVENTO > 30 DIAS:</th>
                    </tr>
                </thead>
                <tbody>
                	<tr>
                    	<td align="center" width="33%"><label class="form-label semibold" for="exampleInput">4.1.5</label><a class="fancybox fancybox.ajax" href="excel_30dias_415.php"><img src="imgs/excel.png" width="50" height="50" border="0"></td>
                    	<td align="center" width="33%"><label class="form-label semibold" for="exampleInput">4.2.1</label><a class="fancybox fancybox.ajax" href="excel_30dias_421.php"><img src="imgs/excel.png" width="50" height="50" border="0"></td>
                    	<td align="center" width="33%"><label class="form-label semibold" for="exampleInput">Ribeirinhos</label><a class="fancybox fancybox.ajax" href="excel_30dias_rir.php"><img src="imgs/excel.png" width="50" height="50" border="0"></td>
                    </tr>
				</tbody>
            </table><br/>

            <table id="table-beneficios" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th width="40%" align="center">Opção de Benefício</th>
                        <th width="40%" align="center">Qtde. de Beneficiários</th>
                        <th width="20%" align="center">Exportar</th>
                    </tr>
                </thead>
                <tbody>
					<?php
						$sql_Beneficios = mysql_query("SELECT TAB_APOIO_BENEFICIOS.ID AS BENEF_ID, TAB_APOIO_BENEFICIOS.DESCRICAO AS BENEF_NOME, COUNT(TAB_415421_FAMILIAS.FAMILIA_CODIGO) AS BENEF_CONT FROM TAB_APOIO_BENEFICIOS LEFT OUTER JOIN TAB_415421_FAMILIAS ON TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID LEFT OUTER JOIN TAB_415421_DADOSGERAIS ON TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO WHERE (TAB_415421_DADOSGERAIS.DADOS_ATEND421 = 1 OR TAB_415421_DADOSGERAIS.DADOS_ATEND415 = 1 OR TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = 1) GROUP BY TAB_APOIO_BENEFICIOS.ID, TAB_APOIO_BENEFICIOS.DESCRICAO ORDER BY BENEF_NOME ASC;", $db) or die(mysql_error());
						while ($vetor_Beneficios = mysql_fetch_array($sql_Beneficios)) { ?>
                    <tr>
                        <td><?php echo $vetor_Beneficios['BENEF_NOME']; ?></td>
                        <td align="center"><?php echo $vetor_Beneficios['BENEF_CONT']; ?></td>
                        <td align="center"><a class="fancybox fancybox.ajax" href="excel_familias_beneficios.php?id=<?php echo $vetor_Beneficios['BENEF_ID'];?>"><img src="imgs/excel.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>

		</div>
	</div>
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>