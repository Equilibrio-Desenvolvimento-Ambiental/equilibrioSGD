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
			$tabela = '<table border=1>';
			$tabela .= '<thead>';
			$tabela .= '<tr>';
			$tabela .= '<th align="center"><b>Opção de Benefício</b></th>';
			$tabela .= '<th align="center"><b>Nome do Produtor</b></th>';
			$tabela .= '<th align="center"><b>Local de Destino</b></th>';
			$tabela .= '<th align="center"><b>Município de Destino</b></th>';
			$tabela .= '<th align="center"><b>Técnico Responsável</b></th>';
			$tabela .= '<th align="center"><b>Técnico(s) da Ação</b></th>';
			$tabela .= '<th align="center"><b>Grupo Semanal</b></th>';
			$tabela .= '<th align="center"><b>Data Prevista</b></th>';
			$tabela .= '<th align="center"><b>Ações de Reparação Rural</b></th>';
			$tabela .= '<th align="center"><b>Ações de ATES</b></th>';
			$tabela .= '<th align="center"><b>Ações para Ribeirinhos</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("select TAB_415421_PLANVISITAS.PLAN_VISIT_ID, TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO AS FAMILIA_BENEFICIO_DESC, TAB_415421_FAMILIAS.FAMILIA_LOCALDESTINO AS PLAN_LOCALDESTINO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TECNICOS.DESCRICAO AS PLAN_VISIT_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO AS PLAN_VISIT_GRUPO_DESC, TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO, TAB_415421_PLANVISITAS.PLAN_VISIT_EXECUCAO, TAB_APOIO_BOOLEANO.DESCRICAO AS PLAN_VISIT_CONCLUIDA_DESC, GROUP_CONCAT(DISTINCT VIEW_415_PLANVISITAS.TEXTO ORDER BY VIEW_415_PLANVISITAS.TEXTO SEPARATOR '; ') AS PLAN_VISIT_415, GROUP_CONCAT(DISTINCT VIEW_421_PLANVISITAS.TEXTO ORDER BY VIEW_421_PLANVISITAS.TEXTO SEPARATOR '; ') AS PLAN_VISIT_421, GROUP_CONCAT(DISTINCT VIEW_RIR_PLANVISITAS.TEXTO ORDER BY VIEW_RIR_PLANVISITAS.TEXTO SEPARATOR '; ') AS PLAN_VISIT_RIR, GROUP_CONCAT(DISTINCT VIEW_TECNINCOS_PLANVISITAS.TEXTO ORDER BY VIEW_TECNINCOS_PLANVISITAS.TEXTO SEPARATOR '; ') AS PLAN_VISIT_TEC FROM TAB_415421_PLANVISITAS LEFT OUTER JOIN TAB_415421_FAMILIAS ON TAB_415421_FAMILIAS.FAMILIA_CODIGO = TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA LEFT OUTER JOIN TAB_APOIO_BENEFICIOS ON TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_APOIO_PLAN_GRUPOS ON TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_APOIO_BOOLEANO.ID = TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA LEFT OUTER JOIN VIEW_415_PLANVISITAS ON VIEW_415_PLANVISITAS.VISITA = TAB_415421_PLANVISITAS.PLAN_VISIT_ID LEFT OUTER JOIN VIEW_421_PLANVISITAS ON VIEW_421_PLANVISITAS.VISITA = TAB_415421_PLANVISITAS.PLAN_VISIT_ID LEFT OUTER JOIN VIEW_RIR_PLANVISITAS ON VIEW_RIR_PLANVISITAS.VISITA = TAB_415421_PLANVISITAS.PLAN_VISIT_ID LEFT OUTER JOIN VIEW_TECNINCOS_PLANVISITAS ON VIEW_TECNINCOS_PLANVISITAS.VISITA = TAB_415421_PLANVISITAS.PLAN_VISIT_ID where TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY TAB_415421_PLANVISITAS.PLAN_VISIT_ID ORDER BY TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO ASC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO ASC;", $db); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FAMILIA_BENEFICIO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_BENEFICIARIO'].'</td>';
				$tabela .= '<td>'.$vetor['PLAN_LOCALDESTINO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_MUNICIPIODESTINO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['PLAN_VISIT_TECNICO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['PLAN_VISIT_TEC'].'</td>';
				$tabela .= '<td>'.$vetor['PLAN_VISIT_GRUPO_DESC'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['PLAN_VISIT_PREVISAO'])).'</td>';
				$tabela .= '<td>'.$vetor['PLAN_VISIT_415'].'</td>';
				$tabela .= '<td>'.$vetor['PLAN_VISIT_421'].'</td>';
				$tabela .= '<td>'.$vetor['PLAN_VISIT_RIR'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_agenda.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>