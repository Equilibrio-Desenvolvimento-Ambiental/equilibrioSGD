<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	session_start();
	if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
		echo "Esta área é restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	}else{
		function reverse_date( $date ){
			return (strstr($date,'-')) ? implode('/', array_reverse(explode('-', $date))) : implode('-', array_reverse(explode('/', $date))); }
		if(strcasecmp($_SESSION['nivel'],'3') == 0){
			$data_atual = reverse_date(date("d/m/Y"));
			$sql_RGME_DATA = mysql_query("select ID from TAB_APOIO_RGME where '$data_atual' between DATA_INICIAL and DATA_FINAL;", $db);
			$vetor_RGME_DATA=mysql_fetch_array($sql_RGME_DATA);
			$rgme = $vetor_RGME_DATA['ID'];
			$tecnico = $_SESSION['tecnico'];
			$sqlVisit01 = mysql_query("select count(TAB_415421_PLANVISITAS.PLAN_VISIT_ID) as REALIZADAS from TAB_415421_PLANVISITAS where TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tecnico' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' and TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA = '1';", $db);
			$sqlVisit02 = mysql_query("select count(TAB_415421_PLANVISITAS.PLAN_VISIT_ID) as NAOREALIZADAS from TAB_415421_PLANVISITAS where TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tecnico' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' and TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA = '2';", $db);
			$vetorVisit01=mysql_fetch_array($sqlVisit01);
			$vetorVisit02=mysql_fetch_array($sqlVisit02);
			$sqlPlanejado = mysql_query("select count(distinct TAB_415421_PLANVISITAS.PLAN_VISIT_ID) as SEM_PLANEJAMENTO from TAB_415421_PLANVISITAS where (TAB_415421_PLANVISITAS.PLAN_VISIT_ID not in (select distinct TAB_415_PLANVISITAS.PLAN_VISIT_ID from TAB_415_PLANVISITAS) and TAB_415421_PLANVISITAS.PLAN_VISIT_ID not in (select distinct TAB_421_PLANVISITAS.PLAN_VISIT_ID from TAB_421_PLANVISITAS) and TAB_415421_PLANVISITAS.PLAN_VISIT_ID not in (select distinct TAB_RIR_PLANVISITAS.PLAN_VISIT_ID from TAB_RIR_PLANVISITAS)) and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' AND TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tecnico';", $db);
			$vetorPlanejado=mysql_fetch_array($sqlPlanejado);
			$contNaoPlanejado = $vetorPlanejado['SEM_PLANEJAMENTO'];
			$contVisit01 = $vetorVisit01['REALIZADAS'];
			$contVisit02 = $vetorVisit02['NAOREALIZADAS'];
			$total_visitas = $contVisit01 + $contVisit02;
			$calculo = -90+((($contVisit01*100)/($contVisit01+$contVisit02))*1.8);
			$ponteiro = 'transform: rotate('.$calculo.'deg);';
		} else {
			$ponteiro = 'transform: rotate(0deg);';
			$contNaoPlanejado = 0;
			$contVisit01 = 0;
			$contVisit02 = 0;
			$total_visitas = 0;
		}
		$sql_projeto = mysql_query("select B.NOME, B.LINKPASTA from TAB_MAIN_USERS_PROJECTS A, TAB_MAIN_PROJECTS B where A.ID_PROJETO = B.ID_PROJETO and A.ID_USER = '$_SESSION[user]' order by B.ORDEM", $db);
?>
<?php require_once("includes/header-completo.php");?>
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
                        	<h3>Seja bem vindo <?php echo $_SESSION['nome']; ?></h3>
                            <ol class="breadcrumb breadcrumb-simple">
                            	<li><a href="#">Inicio</a></li><li><a href="#">Inicio</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
			</header>
            
 			<div class="row">
	            <div class="col-xl-6 dahsboard-column">
	                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
						<header class="widget-header-dark">Projetos</header>
	                    <div class="box-typical-body panel-body">
                            <table id="table-sm" class="table table-bordered table-hover table-sm">
                                <thead><tr><th></th></tr></thead>
                                <tbody>
                                <tr><td>Abaixo listamos seus projetos:</td></tr>
                                <tr><td></td></tr>
                                <?php 
                                    while ($vetor_projeto=mysql_fetch_array($sql_projeto)) { 
                                ?>
                                <tr>
                                    <td><a href="<?php echo $vetor_projeto['LINKPASTA']; ?>"><?php echo $vetor_projeto['NOME']; ?></a></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
	                    </div><!--.box-typical-body-->
	                </section><!--.box-typical-dashboard-->
	            </div><!--.col-->
	            <div class="col-xl-6 dahsboard-column">
					<section class="widget">
						<header class="widget-header-dark">Controle de Visitas de Campo</header>
						<div class="tab-content widget-tabs-content">
							<div class="tab-pane active" id="w-1-tab-1" role="tabpanel">
								<center>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <article class="statistic-box yellow">
                                            <div>
                                                <div class="number"><?php echo $total_visitas; ?></div>
                                                <div class="caption"><div>Total de<br/>Visitas este Mês</div></div>
                                            </div>
                                        </article>
                                    </div><!--.col-->
                                    <div class="col-sm-6">
                                        <article class="statistic-box purple">
                                            <div>
                                                <div class="number"><?php echo $contNaoPlanejado; ?></div>
                                                <div class="caption"><div>Planejamentos<br/>Não Realizados</div></div>
												<div class="percent"><div class="arrow up"></div>
                                                	<p>
                                                    <?php if(strcasecmp($total_visitas,'0')==0)
														{ echo '0'; }
													else
														{ echo round(($contNaoPlanejado/$total_visitas)*100,0);}
													?>%</p>
                                                </div>
                                            </div>
                                        </article>
                                    </div><!--.col-->
                                    <div class="col-sm-6">
                                        <article class="statistic-box green">
                                            <div>
                                                <div class="number"><?php echo $contVisit01; ?></div>
                                                <div class="caption"><div>Visitas<br/>Realizadas</div></div>
												<div class="percent"><div class="arrow up"></div>
                                                	<p>
                                                    <?php if(strcasecmp($total_visitas,'0')==0)
														{ echo '0'; }
													else
														{ echo round(($contVisit01/$total_visitas)*100,0);}
													?>%</p>
                                                </div>
                                            </div>
                                        </article>
                                    </div><!--.col-->
                                    <div class="col-sm-6">
                                        <article class="statistic-box red">
                                            <div>
                                                <div class="number"><?php echo $contVisit02; ?></div>
                                                <div class="caption"><div>Visitas Não<br/>Realizadas</div></div>
												<div class="percent"><div class="arrow down"></div>
                                                	<p>
                                                    <?php if(strcasecmp($total_visitas,'0')==0)
														{ echo '0'; }
													else
														{ echo round(($contVisit02/$total_visitas)*100,0);}
													?>%</p>
                                                </div>
                                            </div>
                                        </article>
                                    </div><!--.col-->
	                			</div><!--.row-->
                                </center>
                            </div>
							<div class="tab-pane" id="w-1-tab-2" role="tabpanel">
								<center>
								<div id="gaugeDemo" class="gauge gauge-big gauge-red">
                               	<div class="gauge-arrow" data-percentage="100" style=" <?php echo $ponteiro;?> ">
                                </div>
                                </div>
                                </center>
							</div>
							<div class="tab-pane" id="w-1-tab-3" role="tabpanel">
								<center>Eventos</center>
							</div>
						</div>
						<div class="widget-tabs-nav bordered">
							<ul class="tbl-row" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#w-1-tab-1" role="tab">
										<i class="font-icon font-icon-chart-3"></i>
										Situação Atual
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#w-1-tab-2" role="tab">
										<i class="font-icon font-icon-notebook-lines"></i>
										Evolução
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#w-1-tab-3" role="tab">
										<i class="font-icon font-icon-pin"></i>
										Eventos
									</a>
								</li>
							</ul>
						</div>
					</section><!--.widget-->
	            </div><!--.col-->
	        </div>
        </div>
	</div>
    <?php require_once("includes/footer-bootstrap.php");?>    
</body>
</html>
<?php
}
?>