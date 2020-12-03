<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 8;
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
			$tabela = '<table border=1>';
			$tabela .= '<thead>';
			$tabela .= '<tr>';
			$tabela .= '<th align="center"><b>Código</b></th>';
			$tabela .= '<th align="center"><b>Descrição</b></th>';
			$tabela .= '<th align="center"><b>Ativa?</b></th>';
			$tabela .= '<th align="center"><b>Atividade Principal - Código</b></th>';
			$tabela .= '<th align="center"><b>Atividade Principal - Descricao</b></th>';
			$tabela .= '<th align="center"><b>Atividade Principal - Ativa?</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_APOIO_TPSUBVISITINDIG.ID, TAB_APOIO_TPSUBVISITINDIG.DESCRICAO, TAB_APOIO_BOOLEANO_SUBATIV.DESCRICAO AS ATIVO_DESC, TAB_APOIO_TPVISITINDIG.ID AS ATIV_ID, TAB_APOIO_TPVISITINDIG.DESCRICAO AS ATIV_DESCRICAO, TAB_APOIO_BOOLEANO_ATIV.DESCRICAO AS ATIV_ATIVO_DESC FROM TAB_APOIO_TPSUBVISITINDIG LEFT OUTER JOIN TAB_APOIO_TPVISITINDIG ON TAB_APOIO_TPSUBVISITINDIG.ID_PRINCIPAL = TAB_APOIO_TPVISITINDIG.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_SUBATIV ON TAB_APOIO_TPSUBVISITINDIG.ATIVO = TAB_APOIO_BOOLEANO_SUBATIV.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ATIV ON TAB_APOIO_TPVISITINDIG.ATIVO = TAB_APOIO_BOOLEANO_ATIV.ID ORDER BY TAB_APOIO_TPSUBVISITINDIG.ID ASC;", $db) or die(mysql_error()); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['ID'].'</td>';
				$tabela .= '<td>'.$vetor['DESCRICAO'].'</td>';
				$tabela .= '<td>'.$vetor['ATIVO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['ATIV_ID'].'</td>';
				$tabela .= '<td>'.$vetor['ATIV_DESCRICAO'].'</td>';
				$tabela .= '<td>'.$vetor['ATIV_ATIVO_DESC'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_tp_tpsubvisitindig.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>