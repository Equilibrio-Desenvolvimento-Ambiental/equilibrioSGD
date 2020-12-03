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
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			if(isset($_POST["rgme"])){
				$rgme = $_POST["rgme"];
			} else {
				$data_atual = reverse_date(date("d/m/Y"));
				$sql_RGME_DATA = mysql_query("select ID from TAB_APOIO_RGME where '$data_atual' between DATA_INICIAL and DATA_FINAL;", $db);
				$vetor_RGME_DATA=mysql_fetch_array($sql_RGME_DATA);
				$rgme = $vetor_RGME_DATA[ID];
			}
			$sql_TECNICOS = mysql_query("SELECT DISTINCT TAB_APOIO_TECNICOS.ID AS TECNICO_ID, TAB_APOIO_TECNICOS.DESCRICAO AS TECNICO_NOME FROM TAB_APOIO_TECNICOS LEFT  OUTER JOIN TAB_415421_FAMILIAS ON TAB_415421_FAMILIAS.FAMILIA_TECNICO = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_415421_DADOSGERAIS ON  TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO WHERE (TAB_415421_DADOSGERAIS.DADOS_ATEND421 = 1 OR TAB_415421_DADOSGERAIS.DADOS_ATEND415 = 1 OR TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = 1) ORDER BY TAB_APOIO_TECNICOS.ID ASC;", $db);
			$contador = 0;
        	while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) {
				$tectemp = $vetor_TECNICOS['TECNICO_ID'];
				$tecnicos['ID'][$contador] = $vetor_TECNICOS['TECNICO_ID'];
				$tecnicos['NOME'][$contador] = $vetor_TECNICOS['TECNICO_NOME'];
				$sqlVisit01 = mysql_query("select count(TAB_415421_PLANVISITAS.PLAN_VISIT_ID) as REALIZADAS from TAB_415421_PLANVISITAS where TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tectemp' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' and TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA = '1';", $db);
				$sqlVisit02 = mysql_query("select count(TAB_415421_PLANVISITAS.PLAN_VISIT_ID) as NAOREALIZADAS from TAB_415421_PLANVISITAS where TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tectemp' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' and TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA = '2';", $db);
				$vetorVisit01=mysql_fetch_array($sqlVisit01);
				$vetorVisit02=mysql_fetch_array($sqlVisit02);
				$vetorValores['REALIZADAS'][$contador] = $vetorVisit01['REALIZADAS'];
				$vetorValores['NAOREALIZADAS'][$contador] = $vetorVisit02['NAOREALIZADAS'];
				$vetorValores['TOTAIS'][$contador] = $vetorVisit01['REALIZADAS'] + $vetorVisit02['NAOREALIZADAS'];
				$sqlPlanejado = mysql_query("select count(distinct TAB_415421_PLANVISITAS.PLAN_VISIT_ID) as SEM_PLANEJAMENTO from TAB_415421_PLANVISITAS where (TAB_415421_PLANVISITAS.PLAN_VISIT_ID not in (select distinct TAB_415_PLANVISITAS.PLAN_VISIT_ID from TAB_415_PLANVISITAS) and TAB_415421_PLANVISITAS.PLAN_VISIT_ID not in (select distinct TAB_421_PLANVISITAS.PLAN_VISIT_ID from TAB_421_PLANVISITAS) and TAB_415421_PLANVISITAS.PLAN_VISIT_ID not in (select distinct TAB_RIR_PLANVISITAS.PLAN_VISIT_ID from TAB_RIR_PLANVISITAS)) and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' AND TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tectemp';", $db);
				$vetorPlanejado=mysql_fetch_array($sqlPlanejado);
				$vetorValores['SEM_PLANEJAMENTO'][$contador] = $vetorPlanejado['SEM_PLANEJAMENTO'];
				$vetorValores['CALCULO'][$contador] = -90+((($vetorValores['REALIZADAS'][$contador]*100)/($vetorValores['REALIZADAS'][$contador]+$vetorValores['NAOREALIZADAS'][$contador]))*1.8);
				$tecnicos['PONTEIRO'][$contador] = 'transform: rotate('.$vetorValores['CALCULO'][$contador].'deg);';
				$contador++;
			}
			$sql_RGME = mysql_query("select * from TAB_APOIO_RGME order by ANO, MES asc;", $db);
?>
<?php require_once("includes/header-completo.php");?>
<script type="text/javascript">  
$(document).ready(function(){  
        $("#palco > div").hide();  
		$("#filter").change(function(){  
                $("#palco > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
});  
</script>
<script src="../plugin/print.js/print.min.js"></script>
<link rel="stylesheet" type="text/css" href="../plugin/print.js/print.min.css">
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
							<h3>Familias - Projetos 4.1.5 / 4.2.1 / Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Quadro Geral da Situação das Visitas de Campo</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
			<form action="planejamento_painel_adm.php" method="post" name="form_select_rgme" onSubmit="return validaForm()">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Selecione o mês para gerenciar as visitas:</th>
                        </tr>
                    </thead>
                	<tbody>
                    	<tr>
                            <td>
                                <select name="rgme" id="rgme" class="form-control" required>
                                    <option value="0" selected>Selecione o Relatório desejado...</option>
                              		<?php while ($vetor_RGME=mysql_fetch_array($sql_RGME)) { ?>
                              			<option label="<?php echo $vetor_RGME['DESCRICAO']; ?>" value="<?php echo $vetor_RGME['ID'] ?>" <?php if (strcasecmp($vetor_RGME['ID'], $rgme) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_RGME['DESCRICAO']." - Período: ".date('d/m/Y', strtotime($vetor_RGME['DATA_INICIAL']))." até ".date('d/m/Y', strtotime($vetor_RGME['DATA_FINAL'])); ?></option>
                              <?php } ?>
                                </select>
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
			</div>
            <section class="tabs-section">
				<div class="tabs-section-nav tabs-section-nav-inline">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" href="#tabs-4-tab-1" role="tab" data-toggle="tab">
								Quantitativos - ATES/Rep. Rural
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-4-tab-2" role="tab" data-toggle="tab">
								Quantitativos - Ribeirinhos
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-4-tab-3" role="tab" data-toggle="tab">
								Evolução - ATES/Rep. Rural
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-4-tab-4" role="tab" data-toggle="tab">
								Quantitativos - Ribeirinhos
							</a>
						</li>
					</ul>
				</div><!--.tabs-section-nav-->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="tabs-4-tab-1">
                        <div class="row">
                            <div class="col-xl-6 dahsboard-column">
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][0]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <article class="statistic-box yellow">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['TOTAIS'][0]; ?></div>
                                                        <div class="caption"><div>Total de<br/>Visitas no Mês</div></div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box purple">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['SEM_PLANEJAMENTO'][0]; ?></div>
                                                        <div class="caption"><div>Planejamentos<br/>Não Realizados</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][0]/$vetorValores['TOTAIS'][0])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box green">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['REALIZADAS'][0]; ?></div>
                                                        <div class="caption"><div>Visitas<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['REALIZADAS'][0]/$vetorValores['TOTAIS'][0])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box red">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['NAOREALIZADAS'][0]; ?></div>
                                                        <div class="caption"><div>Visitas Não<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow down"></div>
                                                            <p><?php echo round(($vetorValores['NAOREALIZADAS'][0]/$vetorValores['TOTAIS'][0])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                        </div><!--.row-->
                                    
                                    </center></div><!--.box-typical-body-->
                                </section><!--.box-typical-dashboard-->
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][1]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <article class="statistic-box yellow">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['TOTAIS'][1]; ?></div>
                                                        <div class="caption"><div>Total de<br/>Visitas no Mês</div></div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box purple">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['SEM_PLANEJAMENTO'][1]; ?></div>
                                                        <div class="caption"><div>Planejamentos<br/>Não Realizados</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][1]/$vetorValores['TOTAIS'][1])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box green">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['REALIZADAS'][1]; ?></div>
                                                        <div class="caption"><div>Visitas<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['REALIZADAS'][1]/$vetorValores['TOTAIS'][1])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box red">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['NAOREALIZADAS'][1]; ?></div>
                                                        <div class="caption"><div>Visitas Não<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow down"></div>
                                                            <p><?php echo round(($vetorValores['NAOREALIZADAS'][1]/$vetorValores['TOTAIS'][1])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                        </div><!--.row-->
                                    
                                    </center></div><!--.box-typical-body-->
                                </section>
                            </div><!--.col-->
                            <div class="col-xl-6 dahsboard-column">
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][2]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <article class="statistic-box yellow">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['TOTAIS'][2]; ?></div>
                                                        <div class="caption"><div>Total de<br/>Visitas no Mês</div></div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box purple">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['SEM_PLANEJAMENTO'][2]; ?></div>
                                                        <div class="caption"><div>Planejamentos<br/>Não Realizados</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][2]/$vetorValores['TOTAIS'][2])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box green">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['REALIZADAS'][2]; ?></div>
                                                        <div class="caption"><div>Visitas<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['REALIZADAS'][2]/$vetorValores['TOTAIS'][2])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box red">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['NAOREALIZADAS'][2]; ?></div>
                                                        <div class="caption"><div>Visitas Não<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow down"></div>
                                                            <p><?php echo round(($vetorValores['NAOREALIZADAS'][2]/$vetorValores['TOTAIS'][2])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                        </div><!--.row-->
                                    
                                    </center></div><!--.box-typical-body-->
                                </section><!--.box-typical-dashboard-->
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][5]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <article class="statistic-box yellow">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['TOTAIS'][5]; ?></div>
                                                        <div class="caption"><div>Total de<br/>Visitas no Mês</div></div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box purple">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['SEM_PLANEJAMENTO'][5]; ?></div>
                                                        <div class="caption"><div>Planejamentos<br/>Não Realizados</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][5]/$vetorValores['TOTAIS'][5])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box green">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['REALIZADAS'][5]; ?></div>
                                                        <div class="caption"><div>Visitas<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['REALIZADAS'][5]/$vetorValores['TOTAIS'][5])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box red">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['NAOREALIZADAS'][5]; ?></div>
                                                        <div class="caption"><div>Visitas Não<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow down"></div>
                                                            <p><?php echo round(($vetorValores['NAOREALIZADAS'][5]/$vetorValores['TOTAIS'][5])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                        </div><!--.row-->
                                    
                                    </center></div><!--.box-typical-body-->
                                </section><!--.box-typical-dashboard-->
                            </div><!--.col-->
                        </div>                    
                    </div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-2">
						<div class="row">
                            <div class="col-xl-6 dahsboard-column">
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][4]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <article class="statistic-box yellow">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['TOTAIS'][4]; ?></div>
                                                        <div class="caption"><div>Total de<br/>Visitas no Mês</div></div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box purple">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['SEM_PLANEJAMENTO'][4]; ?></div>
                                                        <div class="caption"><div>Planejamentos<br/>Não Realizados</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][4]/$vetorValores['TOTAIS'][4])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box green">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['REALIZADAS'][4]; ?></div>
                                                        <div class="caption"><div>Visitas<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['REALIZADAS'][4]/$vetorValores['TOTAIS'][4])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box red">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['NAOREALIZADAS'][4]; ?></div>
                                                        <div class="caption"><div>Visitas Não<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow down"></div>
                                                            <p><?php echo round(($vetorValores['NAOREALIZADAS'][4]/$vetorValores['TOTAIS'][4])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                        </div><!--.row-->
                                    
                                    </center></div><!--.box-typical-body-->
                                </section><!--.box-typical-dashboard-->
                            </div><!--.col-->
                            <div class="col-xl-6 dahsboard-column">
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][6]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <article class="statistic-box yellow">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['TOTAIS'][6]; ?></div>
                                                        <div class="caption"><div>Total de<br/>Visitas no Mês</div></div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box purple">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['SEM_PLANEJAMENTO'][6]; ?></div>
                                                        <div class="caption"><div>Planejamentos<br/>Não Realizados</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][6]/$vetorValores['TOTAIS'][6])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box green">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['REALIZADAS'][6]; ?></div>
                                                        <div class="caption"><div>Visitas<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow up"></div>
                                                            <p><?php echo round(($vetorValores['REALIZADAS'][6]/$vetorValores['TOTAIS'][6])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                            <div class="col-sm-6">
                                                <article class="statistic-box red">
                                                    <div>
                                                        <div class="number"><?php echo $vetorValores['NAOREALIZADAS'][6]; ?></div>
                                                        <div class="caption"><div>Visitas Não<br/>Realizadas</div></div>
                                                        <div class="percent"><div class="arrow down"></div>
                                                            <p><?php echo round(($vetorValores['NAOREALIZADAS'][6]/$vetorValores['TOTAIS'][6])*100,0);?>%</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div><!--.col-->
                                        </div><!--.row-->
                                    
                                    </center></div><!--.box-typical-body-->
                                </section><!--.box-typical-dashboard-->
                            </div><!--.col-->
                        </div>                    
					</div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-3">
                        <div class="row">
                            <div class="col-xl-6 dahsboard-column">
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][0]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div id="gaugeDemo" class="gauge gauge-big gauge-red">
                                        <div class="gauge-arrow" data-percentage="100" style=" <?php echo $tecnicos['PONTEIRO'][0];?> ">
                                        </div>
                                        </div>
                                    </center></div><!--.box-typical-body-->
                                </section><!--.box-typical-dashboard-->
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][1]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div id="gaugeDemo" class="gauge gauge-big gauge-red">
                                        <div class="gauge-arrow" data-percentage="100" style=" <?php echo $tecnicos['PONTEIRO'][1];?> ">
                                        </div>
                                        </div>
                                    </center></div><!--.box-typical-body-->
                                </section>
                            </div><!--.col-->
                            <div class="col-xl-6 dahsboard-column">
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][2]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div id="gaugeDemo" class="gauge gauge-big gauge-red">
                                        <div class="gauge-arrow" data-percentage="100" style=" <?php echo $tecnicos['PONTEIRO'][2];?> ">
                                        </div>
                                        </div>
                                    </center></div><!--.box-typical-body-->
                                </section><!--.box-typical-dashboard-->
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][5]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div id="gaugeDemo" class="gauge gauge-big gauge-red">
                                        <div class="gauge-arrow" data-percentage="100" style=" <?php echo $tecnicos['PONTEIRO'][5];?> ">
                                        </div>
                                        </div>
                                    </center></div><!--.box-typical-body-->
                                </section><!--.box-typical-dashboard-->
                            </div><!--.col-->
                        </div>                    
                    </div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-4">
						<div class="row">
                            <div class="col-xl-6 dahsboard-column">
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][4]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div id="gaugeDemo" class="gauge gauge-big gauge-red">
                                        <div class="gauge-arrow" data-percentage="100" style=" <?php echo $tecnicos['PONTEIRO'][4];?> ">
                                        </div>
                                        </div>
                                    </center></div><!--.box-typical-body-->
                                </section><!--.box-typical-dashboard-->
                            </div><!--.col-->
                            <div class="col-xl-6 dahsboard-column">
                                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
                                    <header class="widget-header-dark"><?php echo $tecnicos['NOME'][6]; ?></header>
                                    <div class="tab-content widget-tabs-content"><center>
                                        <div id="gaugeDemo" class="gauge gauge-big gauge-red">
                                        <div class="gauge-arrow" data-percentage="100" style=" <?php echo $tecnicos['PONTEIRO'][6];?> ">
                                        </div>
                                        </div>
                                    </center></div><!--.box-typical-body-->
                                </section><!--.box-typical-dashboard-->
                            </div><!--.col-->
                        </div>                    
                    </div><!--.tab-pane-->
				</div><!--.tab-content-->
			</section><!--.tabs-section-->
            <div><a href="planejamento_painel_print.php?rgme=<?php echo $rgme; ?>" target="_blank"><img src="imgs/imprimir.png" border="0"></a><br/><br/></div>
			<section class="card">
				<div class="card-block">
					<table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th align="center" valign="middle">Tecnico de Campo</th>
							<th align="center" valign="middle">Total de<br/>Visitas no Mês</th>
							<th align="center" valign="middle">Planejamentos<br/>Não Realizados</th>
							<th align="center" valign="middle">%</th>
							<th align="center" valign="middle">Visitas<br/>Realizadas</th>
							<th align="center" valign="middle">%</th>
							<th align="center" valign="middle">Visitas Não<br/>Realizadas</th>
							<th align="center" valign="middle">%</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td><?php echo $tecnicos['NOME'][0]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][0]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][0]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][0]/$vetorValores['TOTAIS'][0])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][0]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][0]/$vetorValores['TOTAIS'][0])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][0]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][0]/$vetorValores['TOTAIS'][0])*100,0);?>%</td>
						</tr>
						<tr>
							<td><?php echo $tecnicos['NOME'][1]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][1]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][1]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][1]/$vetorValores['TOTAIS'][1])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][1]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][1]/$vetorValores['TOTAIS'][1])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][1]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][1]/$vetorValores['TOTAIS'][1])*100,0);?>%</td>
						</tr>
						<tr>
							<td><?php echo $tecnicos['NOME'][2]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][2]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][2]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][2]/$vetorValores['TOTAIS'][2])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][2]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][2]/$vetorValores['TOTAIS'][2])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][2]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][2]/$vetorValores['TOTAIS'][2])*100,0);?>%</td>
						</tr>
						<tr>
							<td><?php echo $tecnicos['NOME'][5]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][5]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][5]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][5]/$vetorValores['TOTAIS'][5])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][5]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][5]/$vetorValores['TOTAIS'][5])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][5]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][5]/$vetorValores['TOTAIS'][5])*100,0);?>%</td>
						</tr>
						<tr>
							<td><?php echo $tecnicos['NOME'][4]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][4]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][4]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][4]/$vetorValores['TOTAIS'][4])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][4]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][4]/$vetorValores['TOTAIS'][4])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][4]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][4]/$vetorValores['TOTAIS'][4])*100,0);?>%</td>
						</tr>
						<tr>
							<td><?php echo $tecnicos['NOME'][6]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][6]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][6]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][6]/$vetorValores['TOTAIS'][6])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][6]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][6]/$vetorValores['TOTAIS'][6])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][6]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][6]/$vetorValores['TOTAIS'][6])*100,0);?>%</td>
						</tr>
						</tbody>
					</table>
				</div>
			</section>
            
		</div>
	</div>
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>