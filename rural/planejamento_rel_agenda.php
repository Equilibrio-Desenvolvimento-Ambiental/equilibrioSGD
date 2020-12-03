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
			$DATA_INI = reverse_date($_POST['DATA_INI_AGENDA']);
			$DATA_FIM = reverse_date($_POST['DATA_FIM_AGENDA']);
			$tecnico = $_SESSION['tecnico'];
			$sql = mysql_query("SELECT 	TAB_415421_PLANVISITAS.PLAN_VISIT_ID, TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO AS FAMILIA_BENEFICIO_DESC, TAB_415421_FAMILIAS.FAMILIA_LOCALDESTINO AS PLAN_LOCALDESTINO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO AS PLAN_VISIT_GRUPO_DESC, TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO FROM TAB_415421_PLANVISITAS LEFT OUTER JOIN TAB_415421_FAMILIAS ON TAB_415421_FAMILIAS.FAMILIA_CODIGO = TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA LEFT OUTER JOIN TAB_APOIO_BENEFICIOS ON TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_APOIO_PLAN_GRUPOS ON TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID WHERE TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tecnico' AND TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO BETWEEN '$DATA_INI' AND '$DATA_FIM' ORDER BY TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO ASC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO ASC;", $db);
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Equilíbrio Desenvolvimento Ambiental - Relatório de Evento - v.1.00</title>
	<link href="../plugin/layout/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="../plugin/layout/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="../plugin/layout/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="../plugin/layout/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="../plugin/layout/img/favicon.png" rel="icon" type="image/png">
	<link href="../plugin/layout/img/favicon.ico" rel="shortcut icon">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
   	<link rel="stylesheet" href="../plugin/layout/css/separate/vendor/select2.min.css">
	<link rel="stylesheet" href="../plugin/layout/css/lib/font-awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../plugin/layout/css/separate/vendor/bootstrap-touchspin.min.css">
	<link rel="stylesheet" href="../plugin/layout/css/lib/font-awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../plugin/layout/css/lib/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../plugin/layout/css/main.css">
<style>
table {
	border:0; border-collapse:collapse; width:100%;
	background-color:#FFFFFF;
	font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
}
h1 {
	font-size:24px;
}
p {
	font-size:14px;
}
</style>
</head>
<body>
    <table>
      <tbody>
        <tr>
          <td align="left" valign="middle"><img src="imgs/Logo NE.png" width="300" height="96" alt=""/></td>
          <td align="right" valign="middle"><img src="imgs/Logo Equilibrio.jpg" width="250" height="124" alt=""/></td>
        </tr>
      </tbody>
    </table><br/>
    <table>
        <tbody>
            <tr><td align="center"><h1>AGENDA</h1></td></tr>
            <tr><td align="center"><h1>TÉCNICO: <?php echo $_SESSION['nome']; ?><br>
          Período: <?php echo $_POST['DATA_INI_AGENDA']; ?> até <?php echo $_POST['DATA_FIM_AGENDA']; ?></h1></td></tr>
	    </tbody>	
    </table><br/>
	<?php 
        while ($vetor=mysql_fetch_array($sql)) {
    ?>
    <table>
    <tr align="left">
    <td width="25%"><strong>Data Prevista:</strong></td>
    <td width="25%"><?php echo date('d/m/Y', strtotime($vetor['PLAN_VISIT_PREVISAO'])); ?></td>
    <td width="25%"><strong>Grupo:</strong></td>
    <td width="25%"><?php echo $vetor['PLAN_VISIT_GRUPO_DESC']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Beneficiário:</strong></td>
        <td colspan="3"><strong><?php echo $vetor['FAMILIA_BENEFICIARIO']; ?></strong></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Opção do Benefício:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_BENEFICIO_DESC']; ?></td>
        <td width="25%"><strong>Localidade/Município:</strong></td>
        <td width="25%"><?php echo $vetor['PLAN_LOCALDESTINO_DESC']; ?>, <?php echo $vetor['FAMILIA_MUNICIPIODESTINO_DESC']; ?></td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
    	<?php
			$idVisita = $vetor['PLAN_VISIT_ID'];
			$sqlAcoes415 = mysql_query("SELECT TAB_415_PLANVISITAS.PLAN415_CODIGO, TAB_APOIO_TPVISIT415.DESCRICAO AS PLAN415_TIPO_DESC, TAB_APOIO_TPSUBVISIT415.DESCRICAO AS PLAN415_SUBTIPO_DESC FROM TAB_415_PLANVISITAS LEFT OUTER JOIN TAB_APOIO_TPSUBVISIT415 ON TAB_415_PLANVISITAS.PLAN415_TIPO = TAB_APOIO_TPSUBVISIT415.ID LEFT OUTER JOIN TAB_APOIO_TPVISIT415 ON TAB_APOIO_TPSUBVISIT415.ID_PRINCIPAL = TAB_APOIO_TPVISIT415.ID WHERE TAB_415_PLANVISITAS.PLAN_VISIT_ID = '$idVisita' ORDER BY PLAN415_TIPO_DESC ASC, PLAN415_SUBTIPO_DESC ASC;", $db);
			$numAcoes415 = mysql_num_rows($sqlAcoes415);
			$sqlAcoes421 = mysql_query("SELECT TAB_421_PLANVISITAS.PLAN421_CODIGO, TAB_APOIO_TPVISIT421.DESCRICAO AS PLAN421_TIPO_DESC, TAB_APOIO_TPSUBVISIT421.DESCRICAO AS PLAN421_SUBTIPO_DESC FROM TAB_421_PLANVISITAS LEFT OUTER JOIN TAB_APOIO_TPSUBVISIT421 ON TAB_421_PLANVISITAS.PLAN421_TIPO = TAB_APOIO_TPSUBVISIT421.ID LEFT OUTER JOIN TAB_APOIO_TPVISIT421 ON TAB_APOIO_TPSUBVISIT421.ID_PRINCIPAL = TAB_APOIO_TPVISIT421.ID WHERE TAB_421_PLANVISITAS.PLAN_VISIT_ID = '$idVisita' ORDER BY PLAN421_TIPO_DESC ASC, PLAN421_SUBTIPO_DESC ASC;", $db);
			$numAcoes421 = mysql_num_rows($sqlAcoes421);
			$sqlAcoesRIR = mysql_query("SELECT TAB_RIR_PLANVISITAS.PLANRIR_CODIGO, TAB_APOIO_TPVISITRIR.DESCRICAO AS PLANRIR_TIPO_DESC, TAB_APOIO_TPSUBVISITRIR.DESCRICAO AS PLANRIR_SUBTIPO_DESC FROM TAB_RIR_PLANVISITAS LEFT OUTER JOIN TAB_APOIO_TPSUBVISITRIR ON TAB_RIR_PLANVISITAS.PLANRIR_TIPO = TAB_APOIO_TPSUBVISITRIR.ID LEFT OUTER JOIN TAB_APOIO_TPVISITRIR ON TAB_APOIO_TPSUBVISITRIR.ID_PRINCIPAL = TAB_APOIO_TPVISITRIR.ID WHERE TAB_RIR_PLANVISITAS.PLAN_VISIT_ID = '$idVisita' ORDER BY PLANRIR_TIPO_DESC ASC, PLANRIR_SUBTIPO_DESC ASC;", $db);
			$numAcoesRIR = mysql_num_rows($sqlAcoesRIR);
			$sqlTecnicos = mysql_query("SELECT TAB_415421_PLANTECNICOS.PLANTEC_CODIGO, TAB_APOIO_TECNICOS.DESCRICAO FROM TAB_415421_PLANTECNICOS LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_415421_PLANTECNICOS.PLANTEC_TECNICO = TAB_APOIO_TECNICOS.ID WHERE TAB_415421_PLANTECNICOS.PLAN_VISIT_ID = '$idVisita' AND TAB_415421_PLANTECNICOS.PLANTEC_TECNICO <> '$tecnico' ORDER BY TAB_APOIO_TECNICOS.DESCRICAO ASC;", $db);
			$numTecnicos = mysql_num_rows($sqlTecnicos);
			$sqlPlanMatC = mysql_query("SELECT TAB_415421_PLANMAT_CONSUMO.PLANMATC_CODIGO, TAB_ADM_MATCONSUMO.MATCONS_NOME AS PLANMATC_TIPO_DESC, TAB_APOIO_PROD_UNIT.DESCRICAO AS PLANMATC_TIPO_UNIDADE, TAB_415421_PLANMAT_CONSUMO.PLANMATC_QTDE FROM TAB_415421_PLANMAT_CONSUMO LEFT OUTER JOIN TAB_ADM_MATCONSUMO ON TAB_415421_PLANMAT_CONSUMO.PLANMATC_TIPO = TAB_ADM_MATCONSUMO.MATCONS_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID WHERE TAB_415421_PLANMAT_CONSUMO.PLAN_VISIT_ID = '$idVisita' ORDER BY PLANMATC_TIPO_DESC ASC;", $db);
			$numPlanMatC = mysql_num_rows($sqlPlanMatC);
			$sqlPlanMatK = mysql_query("SELECT TAB_415421_PLANMAT_KITS.PLANMATK_CODIGO, TAB_ADM_MATKITS.MATKIT_NOME AS PLANMATK_TIPO_DESC, TAB_415421_PLANMAT_KITS.PLANMATK_QTDE FROM TAB_415421_PLANMAT_KITS LEFT OUTER JOIN TAB_ADM_MATKITS ON TAB_415421_PLANMAT_KITS.PLANMATK_TIPO = TAB_ADM_MATKITS.MATKIT_ID WHERE TAB_415421_PLANMAT_KITS.PLAN_VISIT_ID = '$idVisita' ORDER BY PLANMATK_TIPO_DESC ASC;", $db);
			$numPlanMatK = mysql_num_rows($sqlPlanMatK);
			$sqlPlanMatU = mysql_query("SELECT TAB_415421_PLANMAT_USO.PLANMATU_CODIGO, TAB_ADM_MATUSO.MATUSO_NOME AS PLANMATU_TIPO_DESC, TAB_APOIO_PROD_UNIT.DESCRICAO AS PLANMATU_TIPO_UNIDADE FROM TAB_415421_PLANMAT_USO LEFT OUTER JOIN TAB_ADM_MATUSO ON TAB_415421_PLANMAT_USO.PLANMATU_TIPO = TAB_ADM_MATUSO.MATUSO_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATUSO.MATUSO_UNIDADE = TAB_APOIO_PROD_UNIT.ID WHERE TAB_415421_PLANMAT_USO.PLAN_VISIT_ID = '$idVisita' ORDER BY PLANMATU_TIPO_DESC ASC;", $db);
			$numPlanMatU = mysql_num_rows($sqlPlanMatU);
			if ($numAcoes415 != 0) { ?>
            	<tr>
                <td colspan="4">
                    <table id="table-xs" class="table table-bordered table-hover table-xs">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="45%">Atividade Prevista - Projeto de Reparação Rural - 4.1.5</th>
                            <th width="50%">Sub-Atividade Prevista</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
							while ($vetorAcoes415=mysql_fetch_array($sqlAcoes415)) { ?>
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="45%"><?php echo $vetorAcoes415['PLAN415_TIPO_DESC']; ?></td>
                            <td width="50%" class="color-blue-grey-lighter"><?php echo $vetorAcoes415['PLAN415_SUBTIPO_DESC']; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </td>
                </tr>
            <?php }
			if ($numAcoes421 != 0) { ?>
            	<tr>
                <td colspan="4">
                    <table id="table-xs" class="table table-bordered table-hover table-xs">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="45%">Atividade Prevista - Projeto de Reparação Rural - 4.2.1</th>
                            <th width="50%">Sub-Atividade Prevista</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
							while ($vetorAcoes421=mysql_fetch_array($sqlAcoes421)) { ?>
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="45%"><?php echo $vetorAcoes421['PLAN421_TIPO_DESC']; ?></td>
                            <td width="50%" class="color-blue-grey-lighter"><?php echo $vetorAcoes421['PLAN421_SUBTIPO_DESC']; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </td>
                </tr>
            <?php }
			if ($numAcoesRIR != 0) { ?>
            	<tr>
                <td colspan="4">
                    <table id="table-xs" class="table table-bordered table-hover table-xs">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="45%">Atividade Prevista - Ribeirinhos</th>
                            <th width="50%">Sub-Atividade Prevista</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
							while ($vetorAcoesRIR=mysql_fetch_array($sqlAcoesRIR)) { ?>
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="45%"><?php echo $vetorAcoesRIR['PLANRIR_TIPO_DESC']; ?></td>
                            <td width="50%" class="color-blue-grey-lighter"><?php echo $vetorAcoesRIR['PLANRIR_SUBTIPO_DESC']; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </td>
                </tr>
            <?php }
			if ($numTecnicos != 0) { ?>
            	<tr>
                <td colspan="4">
                    <table id="table-xs" class="table table-bordered table-hover table-xs">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="95%">Acompanhamento de Outros Técnicos?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
							while ($vetorTecnicos=mysql_fetch_array($sqlTecnicos)) { ?>
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="95%"><?php echo $vetorTecnicos['DESCRICAO']; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </td>
                </tr>
            <?php }
			if ($numPlanMatC != 0) { ?>
            	<tr>
                <td colspan="4">
                    <table id="table-xs" class="table table-bordered table-hover table-xs">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="75%" colspan="2"><strong>Material de Entrega solicitado para o Atendimento:</strong></th>
                            <th width="20%"><strong>Quantidade</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
							while ($vetorPlanMatC=mysql_fetch_array($sqlPlanMatC)) { ?>
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="40%"><?php echo $vetorPlanMatC['PLANMATC_TIPO_DESC']; ?></td>
                            <td width="35%"><?php echo $vetorPlanMatC['PLANMATC_TIPO_UNIDADE']; ?></td>
                            <td width="20%"><?php echo $vetorPlanMatC['PLANMATC_QTDE']; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </td>
                </tr>
            <?php }
			if ($numPlanMatK != 0) { ?>
            	<tr>
                <td colspan="4">
                    <table id="table-xs" class="table table-bordered table-hover table-xs">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="75%"><strong>Kits Completos solicitados para o Atendimento:</strong></th>
                            <th width="20%"><strong>Quantidade</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
							while ($vetorPlanMatK=mysql_fetch_array($sqlPlanMatK)) { ?>
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="70%"><?php echo $vetorPlanMatK['PLANMATK_TIPO_DESC']; ?></td>
                            <td width="20%"><?php echo $vetorPlanMatK['PLANMATK_QTDE']; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </td>
                </tr>
            <?php }
			if ($numPlanMatU != 0) { ?>
            	<tr>
                <td colspan="4">
                    <table id="table-xs" class="table table-bordered table-hover table-xs">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="95%"><strong>Ferramentas solicitadas para o Atendimento:</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
							while ($vetorPlanMatU=mysql_fetch_array($sqlPlanMatU)) { ?>
                        <tr>
                            <td width="5%">&nbsp;</td>
                            <td width="95%"><?php echo $vetorPlanMatU['PLANMATU_TIPO_DESC']; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </td>
                </tr>
            <?php }
	     ?>
    </table><br/><br/>
    <?php } ?>
    <br/>
</body>
</html>
<?php
}
}
?>