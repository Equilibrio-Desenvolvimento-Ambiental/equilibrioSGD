<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 6;
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
			$idPedido = $_GET['idPedido'];
			$sql_DADOS = mysql_query("SELECT TAB_ADM_PEDIDOS.PEDIDO_ID, TAB_ADM_PEDIDOS.PEDIDO_VISITA, TAB_APOIO_TECNICOS.DESCRICAO AS PEDIDO_TECNICO_DESC, TAB_ADM_PEDIDOS.PEDIDO_DTLIM_COMPRA, TAB_ADM_PEDIDOS.PEDIDO_DTLIM_PREP, TAB_ADM_PEDIDOS.PEDIDO_DTLIM_ENTR, TAB_ADM_PEDIDOS.PEDIDO_DTLIM_VISIT, TAB_415421_FAMILIAS.FAMILIA_NUMERO, TAB_APOIO_BENEFICIOS.DESCRICAO AS FAMILIA_BENEFICIO_DESC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_415421_FAMILIAS.FAMILIA_LOCALDESTINO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FAMILIA_MUNICIPIO_DESC, TAB_APOIO_ATENDIMENTO_421.DESCRICAO AS DADOS_ATEND_421, TAB_APOIO_MTATENDIMENTO_421.DESCRICAO AS DADOS_MTNATEND_421, TAB_APOIO_ATENDIMENTO_415.DESCRICAO AS DADOS_ATEND_415, TAB_APOIO_MTATENDIMENTO_415.DESCRICAO AS DADOS_MTNATEND_415, TAB_APOIO_TPPROJETO_415.DESCRICAO AS DADOS_TPPROJETO_415, TAB_APOIO_STPROJETO_415.DESCRICAO AS DADOS_STPROJETO_415, TAB_APOIO_ATENDIMENTO_RIR.DESCRICAO AS DADOS_ATEND_RIR, TAB_APOIO_MTATENDIMENTO_RIR.DESCRICAO AS DADOS_MTNATEND_RIR, TAB_APOIO_TPPROJETO_RIR.DESCRICAO AS DADOS_TPPROJETO_RIR, TAB_APOIO_STPROJETO_RIR.DESCRICAO AS DADOS_STPROJETO_RIR FROM TAB_ADM_PEDIDOS LEFT OUTER JOIN TAB_415421_PLANVISITAS ON TAB_ADM_PEDIDOS.PEDIDO_VISITA = TAB_415421_PLANVISITAS.PLAN_VISIT_ID LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_ADM_PEDIDOS.PEDIDO_TECNICO = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_415421_FAMILIAS ON TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA = TAB_415421_FAMILIAS.FAMILIA_CODIGO LEFT OUTER JOIN TAB_APOIO_BENEFICIOS ON TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_415421_DADOSGERAIS ON TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO LEFT OUTER JOIN TAB_APOIO_TPATENDIMENTO AS TAB_APOIO_ATENDIMENTO_421 ON TAB_415421_DADOSGERAIS.DADOS_ATEND421 = TAB_APOIO_ATENDIMENTO_421.ID LEFT OUTER JOIN TAB_APOIO_TPATENDIMENTO AS TAB_APOIO_ATENDIMENTO_415 ON TAB_415421_DADOSGERAIS.DADOS_ATEND415 = TAB_APOIO_ATENDIMENTO_415.ID LEFT OUTER JOIN TAB_APOIO_TPATENDIMENTO AS TAB_APOIO_ATENDIMENTO_RIR ON TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = TAB_APOIO_ATENDIMENTO_RIR.ID LEFT OUTER JOIN TAB_APOIO_MTATENDIMENTO AS TAB_APOIO_MTATENDIMENTO_421 ON TAB_415421_DADOSGERAIS.DADOS_MOTIVO421 = TAB_APOIO_MTATENDIMENTO_421.ID LEFT OUTER JOIN TAB_APOIO_MTATENDIMENTO AS TAB_APOIO_MTATENDIMENTO_415 ON TAB_415421_DADOSGERAIS.DADOS_MOTIVO415 = TAB_APOIO_MTATENDIMENTO_415.ID LEFT OUTER JOIN TAB_APOIO_MTATENDIMENTO AS TAB_APOIO_MTATENDIMENTO_RIR ON TAB_415421_DADOSGERAIS.DADOS_MOTIVORIR = TAB_APOIO_MTATENDIMENTO_RIR.ID LEFT OUTER JOIN TAB_APOIO_TPPROJETO AS TAB_APOIO_TPPROJETO_415 ON TAB_415421_DADOSGERAIS.DADOS_TPPROJ415 = TAB_APOIO_TPPROJETO_415.ID LEFT OUTER JOIN TAB_APOIO_TPPROJETO AS TAB_APOIO_TPPROJETO_RIR ON TAB_415421_DADOSGERAIS.DADOS_TPPROJRIR = TAB_APOIO_TPPROJETO_RIR.ID LEFT OUTER JOIN TAB_APOIO_STPROJETO AS TAB_APOIO_STPROJETO_415 ON TAB_415421_DADOSGERAIS.DADOS_SITPROJ415 = TAB_APOIO_STPROJETO_415.ID LEFT OUTER JOIN TAB_APOIO_STPROJETO AS TAB_APOIO_STPROJETO_RIR ON TAB_415421_DADOSGERAIS.DADOS_SITPROJRIR = TAB_APOIO_STPROJETO_RIR.ID WHERE TAB_ADM_PEDIDOS.PEDIDO_ID = '$idPedido';", $db);
			$vetor_DADOS = mysql_fetch_array($sql_DADOS);
			$idVisita = $vetor_DADOS['PEDIDO_VISITA'];
?>
<?php require_once("includes/header-completo.php");?>
<style type="text/css">
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
#scroll {
  width:100%;
  height:auto;
  overflow:auto;
}
</style>
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
							<h3>Tabelas de Apoio - Gestão de Suprimentos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Materiais de Consumo</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
 			<div class="row">
	            <div class="col-xl-6 dahsboard-column">
	                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
						<header class="widget-header-dark">Dados do Pedido / Visita</header>
	                    <div class="box-typical box-typical-padding">
                        	<table width="85%">
                            	<tr><td>
                                	<strong>Técnico Responsável: </strong>
                                    <?php echo $vetor_DADOS['PEDIDO_TECNICO_DESC']; ?> <br/><br/>
                                	<strong>Data limite para Aquisição: </strong>
                                    <?php echo $vetor_DADOS['PEDIDO_DTLIM_COMPRA']; ?> <br/>
                                	<strong>Data limite para Montagem:  </strong>
                                    <?php echo $vetor_DADOS['PEDIDO_DTLIM_PREP']; ?> <br/>
                                	<strong>Data limite para Entrega:  </strong>
                                    <?php echo $vetor_DADOS['PEDIDO_DTLIM_ENTR']; ?> <br/>
                                	<strong>Data da Visita:  </strong>
                                    <?php echo $vetor_DADOS['PEDIDO_DTLIM_VISIT']; ?> <br/>
                                </td></tr>
                            </table>
	                    </div><!--.box-typical-body-->
	                </section><!--.box-typical-dashboard-->
	            </div><!--.col-->
	            <div class="col-xl-6 dahsboard-column">
	                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
						<header class="widget-header-dark">Dados da Família</header>
	                    <div class="box-typical box-typical-padding">
                        	<table width="85%">
                            	<tr><td>
                                	<strong>Produtor: </strong>
                                    <?php echo $vetor_DADOS['FAMILIA_BENEFICIARIO']; ?><br/>
                                    <strong>Benefício: </strong>
                                    <?php echo $vetor_DADOS['FAMILIA_BENEFICIO_DESC']; ?><br/>
                                    <strong>Localidade: </strong>
                                    <?php echo $vetor_DADOS['FAMILIA_LOCALDESTINO'].' / '.$vetor_DADOS['FAMILIA_MUNICIPIO_DESC']; ?><br/><br/>
                                    <strong>Dados Projeto(s):</strong><br/>
                                    <strong>Atendido pelo 4.2.1: </strong>
                                    <?php echo $vetor_DADOS['DADOS_ATEND_421'].' ('.$vetor_DADOS['DADOS_MTNATEND_421'].')'; ?><br/>
                                    <strong>Atendido pelo 4.1.5: </strong>
                                    <?php echo $vetor_DADOS['DADOS_ATEND_415'].' ('.$vetor_DADOS['DADOS_MTNATEND_415'].')'; ?><br/>
                                    <strong>Projeto: </strong>
                                    <?php echo $vetor_DADOS['DADOS_TPPROJETO_415'].' -> '.$vetor_DADOS['DADOS_STPROJETO_415']; ?><br/>
                                    <strong>Atendido pelo RIR: </strong>
                                    <?php echo $vetor_DADOS['DADOS_ATEND_RIR'].' ('.$vetor_DADOS['DADOS_MTNATEND_RIR'].')'; ?><br/>
                                    <strong>Projeto: </strong>
                                    <?php echo $vetor_DADOS['DADOS_TPPROJETO_RIR'].' -> '.$vetor_DADOS['DADOS_STPROJETO_RIR']; ?><br/>
                               </td></tr>
                              </table>
	                    </div><!--.box-typical-body-->
	                </section><!--.box-typical-dashboard-->
	            </div><!--.col-->
	        </div>
			<div class="box-typical box-typical-padding">
                <div style="width: 100%; margin: 0 auto;">
                    <ul class="tabs" data-persist="true">
                        <li><a href="#view5">Mat. de Entrega</a></li>
                        <li><a href="#view6">Kits</a></li>
                        <li><a href="#view7">Ferramentas</a></li>
                    </ul>

                    <div class="tabcontents">
                
                    <div id="view5">
                        <table width="100%">
                            <thead>
                                <td width="40%">Tipo(s) de Produto</td>
                                <td width="2%">&nbsp;</td>
                                <td width="16%">Quantidade</td>
                                <td width="2%">&nbsp;</td>
                                <td width="40%">Centro de Custo</td>
                            </thead>
                            <?php
                                $sql_PLANMAT_CONSUMO = mysql_query("SELECT TAB_415421_PLANMAT_CONSUMO.PLANMATC_CODIGO, TAB_415421_PLANMAT_CONSUMO.PLAN_VISIT_ID, TAB_ADM_MATCONSUMO.MATCONS_NOME AS PLANMATC_TIPO_DESCRICAO, TAB_APOIO_PROD_UNIT.DESCRICAO AS PLANMATC_TIPO_UNIDADE, TAB_415421_PLANMAT_CONSUMO.PLANMATC_QTDE, TAB_ADM_CENTROCUSTO.CCUSTO_CODIGO AS PLANMATC_TIPO_CCUSTO_COD, TAB_ADM_CENTROCUSTO.CCUSTO_DESCRICAO AS PLANMATC_TIPO_CCUSTO_DESC FROM TAB_415421_PLANMAT_CONSUMO LEFT OUTER JOIN TAB_ADM_MATCONSUMO ON TAB_415421_PLANMAT_CONSUMO.PLANMATC_TIPO = TAB_ADM_MATCONSUMO.MATCONS_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID LEFT OUTER JOIN TAB_ADM_CENTROCUSTO ON TAB_415421_PLANMAT_CONSUMO.PLANMATC_CCUSTO = TAB_ADM_CENTROCUSTO.CCUSTO_ID WHERE TAB_415421_PLANMAT_CONSUMO.PLAN_VISIT_ID = '$idVisita' ORDER BY PLANMATC_TIPO_DESCRICAO ASC, PLANMATC_TIPO_CCUSTO_COD ASC;", $db);
                                        $cor = "#D8D8D8";
                                        while ($vetor_PLANMAT_CONSUMO=mysql_fetch_array($sql_PLANMAT_CONSUMO)) {
                                            if (strcasecmp($cor, "#FFFFFF") == 0){
                                                $cor = "#D8D8D8";
                                            } else {
                                                $cor = "#FFFFFF";
                                            }
                                    ?>
                                  <tr bgcolor="<?php echo $cor; ?>">
                                    <td width="40%"><?php echo $vetor_PLANMAT_CONSUMO['PLANMATC_TIPO_DESCRICAO'].' ('.$vetor_PLANMAT_CONSUMO['PLANMATC_TIPO_UNIDADE'].')'; ?></td>
                                    <td width="2%"></td>
                                    <td width="16%" align="center"><?php echo $vetor_PLANMAT_CONSUMO['PLANMATC_QTDE']; ?></td>
                                    <td width="2%"></td>
                                    <td width="40%"><?php echo $vetor_PLANMAT_CONSUMO['PLANMATC_TIPO_CCUSTO_COD'].' - '.$vetor_PLANMAT_CONSUMO['PLANMATC_TIPO_CCUSTO_DESC']; ?></td>
                                  </tr>
                                  <?php } ?>
                                </table>
                            </div>
    
                    <div id="view6">
                        <table width="100%">
                            <thead>
                                <td width="40%">Kit(s) Completo(s)</td>
                                <td width="2%">&nbsp;</td>
                                <td width="16%">Quantidade</td>
                                <td width="2%">&nbsp;</td>
                                <td width="40%">Centro de Custo</td>
                            </thead>
                            <?php
                                $sql_PLANMAT_KITS = mysql_query("SELECT TAB_415421_PLANMAT_KITS.PLANMATK_CODIGO, TAB_415421_PLANMAT_KITS.PLAN_VISIT_ID, TAB_ADM_MATKITS.MATKIT_NOME AS PLANMATK_TIPO_DESCRICAO, TAB_415421_PLANMAT_KITS.PLANMATK_QTDE, TAB_ADM_CENTROCUSTO.CCUSTO_CODIGO AS PLANMATK_TIPO_CCUSTO_COD, TAB_ADM_CENTROCUSTO.CCUSTO_DESCRICAO AS PLANMATK_TIPO_CCUSTO_DESC FROM TAB_415421_PLANMAT_KITS LEFT OUTER JOIN TAB_ADM_MATKITS ON TAB_415421_PLANMAT_KITS.PLANMATK_TIPO = TAB_ADM_MATKITS.MATKIT_ID LEFT OUTER JOIN TAB_ADM_CENTROCUSTO ON TAB_415421_PLANMAT_KITS.PLANMATK_CCUSTO = TAB_ADM_CENTROCUSTO.CCUSTO_ID WHERE TAB_415421_PLANMAT_KITS.PLAN_VISIT_ID = '$idVisita' ORDER BY PLANMATK_TIPO_DESCRICAO ASC, PLANMATK_TIPO_CCUSTO_COD ASC;", $db);
                                        $cor = "#D8D8D8";
                                        while ($vetor_PLANMAT_KITS=mysql_fetch_array($sql_PLANMAT_KITS)) {
                                            if (strcasecmp($cor, "#FFFFFF") == 0){
                                                $cor = "#D8D8D8";
                                            } else {
                                                $cor = "#FFFFFF";
                                            }
                                    ?>
                                  <tr bgcolor="<?php echo $cor; ?>">
                                    <td width="40%"><?php echo $vetor_PLANMAT_KITS['PLANMATK_TIPO_DESCRICAO']; ?></td>
                                    <td width="2%"></td>
                                    <td width="16%" align="center"><?php echo $vetor_PLANMAT_KITS['PLANMATK_QTDE']; ?></td>
                                    <td width="2%"></td>
                                    <td width="40%"><?php echo $vetor_PLANMAT_KITS['PLANMATK_TIPO_CCUSTO_COD'].' - '.$vetor_PLANMAT_KITS['PLANMATK_TIPO_CCUSTO_DESC']; ?></td>
                                  </tr>
                                  <?php } ?>
                                </table>
                            </div>

                    <div id="view7">
                        <table width="100%">
                            <thead>
                                <td width="40%">Tipo(s) de Ferramenta(s)</td>
                                <td width="2%">&nbsp;</td>
                                <td width="16%">Quantidade</td>
                                <td width="2%">&nbsp;</td>
                                <td width="40%">Centro de Custo</td>
                            </thead>
                            <?php
                                $sql_PLANMAT_USO = mysql_query("SELECT TAB_415421_PLANMAT_USO.PLANMATU_CODIGO, TAB_415421_PLANMAT_USO.PLAN_VISIT_ID, TAB_ADM_MATUSO.MATUSO_NOME AS PLANMATU_TIPO_DESCRICAO, TAB_APOIO_PROD_UNIT.DESCRICAO AS PLANMATU_TIPO_UNIDADE, TAB_415421_PLANMAT_USO.PLANMATU_QTDE, TAB_ADM_CENTROCUSTO.CCUSTO_CODIGO AS PLANMATU_TIPO_CCUSTO_COD, TAB_ADM_CENTROCUSTO.CCUSTO_DESCRICAO AS PLANMATU_TIPO_CCUSTO_DESC FROM TAB_415421_PLANMAT_USO LEFT OUTER JOIN TAB_ADM_MATUSO ON TAB_415421_PLANMAT_USO.PLANMATU_TIPO = TAB_ADM_MATUSO.MATUSO_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATUSO.MATUSO_UNIDADE = TAB_APOIO_PROD_UNIT.ID LEFT OUTER JOIN TAB_ADM_CENTROCUSTO ON TAB_415421_PLANMAT_USO.PLANMATU_CCUSTO = TAB_ADM_CENTROCUSTO.CCUSTO_ID WHERE TAB_415421_PLANMAT_USO.PLAN_VISIT_ID = '$idVisita' ORDER BY PLANMATU_TIPO_DESCRICAO ASC, PLANMATU_TIPO_CCUSTO_COD ASC;", $db);
                                        $cor = "#D8D8D8";
                                        while ($vetor_PLANMAT_USO=mysql_fetch_array($sql_PLANMAT_USO)) {
                                            if (strcasecmp($cor, "#FFFFFF") == 0){
                                                $cor = "#D8D8D8";
                                            } else {
                                                $cor = "#FFFFFF";
                                            }
                                    ?>
                                  <tr bgcolor="<?php echo $cor; ?>">
                                    <td width="40%"><?php echo $vetor_PLANMAT_USO['PLANMATU_TIPO_DESCRICAO'].' ('.$vetor_PLANMAT_USO['PLANMATU_TIPO_UNIDADE'].')'; ?></td>
                                    <td width="2%"></td>
                                    <td width="16%" align="center"><?php echo $vetor_PLANMAT_USO['PLANMATU_QTDE']; ?></td>
                                    <td width="2%"></td>
                                    <td width="40%"><?php echo $vetor_PLANMAT_USO['PLANMATU_TIPO_CCUSTO_COD'].' - '.$vetor_PLANMAT_USO['PLANMATU_TIPO_CCUSTO_DESC']; ?></td>
                                  </tr>
                                  <?php } ?>
                                </table>
                            </div>
                            
                    </div>
                </div>
                </br>
        </div><!--.box-typical-->
            <section class="card">
                <div class="card-block">
                    <div class="row">
                        <form action="gestao_pass02_invalidar_pedido.php?idPedido=<?php echo $idPedido; ?>" method="post" name="matuso" enctype="multipart/form-data" id="formID">
                            <input name="invalidar_pedido" type="image" src="imgs/gestao_invalidar.png" class="float" />
                            <label for="exampleSelect" class="col-sm-2 form-control-label">Justificativa:</label>
                            <div class="col-lg-6"><input type="text" name="PEDIDO_OBS" class="form-control" id="PEDIDO_OBS" placeholder="Digite a justificativa..."></div>
                        </form>
                        <a href="gestao_pass02_validar_pedido.php?idPedido=<?php echo $idPedido; ?>"><img src="imgs/gestao_validar.png" border="0"></a></td>
                    </div>
                </div>
             </section>
		</div><!--.container-fluid-->
	</div><!--.page-content-->
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>