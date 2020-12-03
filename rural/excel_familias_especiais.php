<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 2;
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
			$tabela = '<table border=1>';
			$tabela .= '<thead>';
			$tabela .= '<tr>';
			$tabela .= '<th align="center"><b>Cod.</b></th>';
			$tabela .= '<th align="center"><b>Beneficiário/Produtor</b></th>';
			$tabela .= '<th align="center"><b>Benefício</b></th>';
			$tabela .= '<th align="center"><b>Técnico</b></th>';
			$tabela .= '<th align="center"><b>Grupo</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("select TAB_415421_FAMESPECIAIS.FAMESP_CODIGO, TAB_APOIO_TECNICOS.DESCRICAO as FAMESP_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO as FAMESP_GRUPO_DESC, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMESP_BENEFICIO_DESC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO from TAB_415421_FAMESPECIAIS left outer join TAB_415421_FAMILIAS on TAB_415421_FAMESPECIAIS.FAMESP_FAMILIA = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_TECNICOS on TAB_415421_FAMESPECIAIS.FAMESP_TECNICO = TAB_APOIO_TECNICOS.ID left outer join TAB_APOIO_PLAN_GRUPOS on TAB_415421_FAMESPECIAIS.FAMESP_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID order by TAB_APOIO_TECNICOS.DESCRICAO asc, TAB_APOIO_PLAN_GRUPOS.DESCRICAO asc, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc;", $db); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FAMESP_CODIGO'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_BENEFICIARIO'].'</td>';
				$tabela .= '<td>'.$vetor['FAMESP_BENEFICIO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FAMESP_TECNICO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FAMESP_GRUPO_DESC'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_familias_especiais.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>