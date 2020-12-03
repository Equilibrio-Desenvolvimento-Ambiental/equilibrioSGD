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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db);
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
			$tabela .= '<th align="center"><b>Nome</b></th>';
			$tabela .= '<th align="center"><b>Aldeia</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_INDIG_NUCLEOS.INDIG_NUC_ID, TAB_INDIG_NUCLEOS.INDIG_NUC_NOME, TAB_INDIG_NUCLEOS.INDIG_NUC_ALDEIA, TAB_APOIO_INDIG_ALDEIA.DESCRICAO AS INDIG_NUC_ALDEIA_DESC FROM TAB_INDIG_NUCLEOS LEFT OUTER JOIN TAB_APOIO_INDIG_ALDEIA ON TAB_INDIG_NUCLEOS.INDIG_NUC_ALDEIA = TAB_APOIO_INDIG_ALDEIA.ID ORDER BY TAB_INDIG_NUCLEOS.INDIG_NUC_NOME ASC, TAB_INDIG_NUCLEOS.INDIG_NUC_ALDEIA ASC;", $db); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['INDIG_NUC_ID'].'</td>';
				$tabela .= '<td>'.$vetor['INDIG_NUC_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['INDIG_NUC_ALDEIA_DESC'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_indig_nucleos.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>