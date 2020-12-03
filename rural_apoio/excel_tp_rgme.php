<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 4;
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
			$tabela .= '<th align="center"><b>Código</b></th>';
			$tabela .= '<th align="center"><b>Descrição</b></th>';
			$tabela .= '<th align="center"><b>Data Inicial</b></th>';
			$tabela .= '<th align="center"><b>Data Final</b></th>';
			$tabela .= '<th align="center"><b>Ano</b></th>';
			$tabela .= '<th align="center"><b>Mês</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("select * from TAB_APOIO_RGME order by ANO, MES asc;", $db); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['ID'].'</td>';
				$tabela .= '<td>'.$vetor['DESCRICAO'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['DATA_INICIAL'])).'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['DATA_FINAL'])).'</td>';
				$tabela .= '<td>'.$vetor['ANO'].'</td>';
				$tabela .= '<td>'.$vetor['MES'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_tp_rgme.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>