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
			$tabela .= '<th align="center"><b>Ativo?</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_APOIO_TPSUBVISITRIR415.ID, TAB_APOIO_TPSUBVISITRIR415.DESCRICAO, TAB_APOIO_TPVISITRIR415.DESCRICAO AS ID_PRINCIPAL, TAB_APOIO_BOOLEANO.DESCRICAO AS ATIVO FROM TAB_APOIO_TPSUBVISITRIR415 LEFT OUTER JOIN TAB_APOIO_TPVISITRIR415 ON  TAB_APOIO_TPSUBVISITRIR415.ID_PRINCIPAL = TAB_APOIO_TPVISITRIR415.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_APOIO_TPSUBVISITRIR415.ATIVO = TAB_APOIO_BOOLEANO.ID ORDER BY TAB_APOIO_TPSUBVISITRIR415.ID ASC;", $db) or die(mysql_error()); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['ID'].'</td>';
				$tabela .= '<td>'.$vetor['DESCRICAO'].'</td>';
				$tabela .= '<td>'.$vetor['ID_PRINCIPAL'].'</td>';
				$tabela .= '<td>'.$vetor['ATIVO'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_tp_tpsubvisitrir415.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>