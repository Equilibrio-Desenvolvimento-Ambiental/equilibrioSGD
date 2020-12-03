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
			$tabela .= '<th align="center"><b>Nome do Produtor</b></th>';
			$tabela .= '<th align="center"><b>Opção de Benefício</b></th>';
			$tabela .= '<th align="center"><b>Número C/C</b></th>';
			$tabela .= '<th align="center"><b>Lote</b></th>';
			$tabela .= '<th align="center"><b>Município de Destino</b></th>';
			$tabela .= '<th align="center"><b>Técnico Responsável</b></th>';
			$tabela .= '<th align="center"><b>Atendido pelo Proj. 4.1.5</b></th>';
			$tabela .= '<th align="center"><b>Atendido pelo Proj. 4.2.1</b></th>';
			$tabela .= '<th align="center"><b>Atendido como Ribeirinho</b></th>';
			$tabela .= '<th align="center"><b>Data do ÚLTIMO EVENTO</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("select * from VIEW_415421_ULTIMASVISITAS where DADOS_ATEND415 = 1 and EVENTOS_DATA < DATE_SUB(NOW( ), INTERVAL 30 DAY) order by FAMILIA_BENEFICIARIO asc", $db); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FAMILIA_BENEFICIARIO'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_BENEFICIO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_NUMERO'].'</td>';
				$tabela .= '<td>'.$vetor['DADOS_LOTERRC'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_MUNICIPIODESTINO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_TECNICO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['DADOS_ATEND415_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['DADOS_ATEND421_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['DADOS_ATENDRIR_DESC'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['EVENTOS_DATA'])).'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_30dias_415.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>