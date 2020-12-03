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
			$tabela = '<table border=1>';
			$tabela .= '<thead>';
			$tabela .= '<tr>';
			$tabela .= '<th align="center"><b>Código</b></th>';
			$tabela .= '<th align="center"><b>Nome do Produto</b></th>';
			$tabela .= '<th align="center"><b>Categoria do Produto</b></th>';
			$tabela .= '<th align="center"><b>Unidade de Medida do Produto</b></th>';
			$tabela .= '<th align="center"><b>Estoque Atual do Produto</b></th>';
			$tabela .= '<th align="center"><b>Estoque Em Uso do Produto</b></th>';
			$tabela .= '<th align="center"><b>Estoque Reservado do Produto</b></th>';
			$tabela .= '<th align="center"><b>Estoque Mínimo do Produto</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("select TAB_ADM_MATUSO.MATUSO_ID, TAB_ADM_MATUSO.MATUSO_NOME, TAB_APOIO_PROD_CATEG.DESCRICAO as MATUSO_CATEGORIA_DESC, TAB_APOIO_PROD_UNIT.DESCRICAO as MATUSO_UNIDADE_DESC, 	TAB_ADM_MATUSO.MATUSO_ESTOQUE_ATUAL, TAB_ADM_MATUSO.MATUSO_ESTOQUE_RESERVA, TAB_ADM_MATUSO.MATUSO_ESTOQUE_USO, TAB_ADM_MATUSO.MATUSO_ESTOQUE_MINIMO from TAB_ADM_MATUSO left outer join TAB_APOIO_PROD_CATEG on TAB_APOIO_PROD_CATEG.ID = TAB_ADM_MATUSO.MATUSO_CATEGORIA left outer join TAB_APOIO_PROD_UNIT on TAB_APOIO_PROD_UNIT.ID = TAB_ADM_MATUSO.MATUSO_UNIDADE order by TAB_ADM_MATUSO.MATUSO_NOME asc;", $db); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['MATUSO_ID'].'</td>';
				$tabela .= '<td>'.$vetor['MATUSO_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['MATUSO_CATEGORIA_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['MATUSO_UNIDADE_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['MATUSO_ESTOQUE_ATUAL'].'</td>';
				$tabela .= '<td>'.$vetor['MATUSO_ESTOQUE_USO'].'</td>';
				$tabela .= '<td>'.$vetor['MATUSO_ESTOQUE_RESERVA'].'</td>';
				$tabela .= '<td>'.$vetor['MATUSO_ESTOQUE_MINIMO'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_matuso.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>