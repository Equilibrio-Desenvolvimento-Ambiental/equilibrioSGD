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
			$tabela .= '<th align="center"><b>Data</b></th>';
			$tabela .= '<th align="center"><b>Produto</b></th>';
			$tabela .= '<th align="center"><b>Centro de Custo</b></th>';
			$tabela .= '<th align="center"><b>Valor (R$)</b></th>';
			$tabela .= '<th align="center"><b>Qtde.</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("select TAB_ADM_ENTRADAS_CON.PRODENTC_ID, TAB_ADM_ENTRADAS_CON.PRODENTC_DATA, TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO, TAB_ADM_MATCONSUMO.MATCONS_NOME, TAB_APOIO_PROD_UNIT.DESCRICAO as MATCONS_UNIDADE_DESC, TAB_ADM_ENTRADAS_CON.PRODENTC_CCUSTO, TAB_ADM_CENTROCUSTO.CCUSTO_CODIGO, TAB_ADM_CENTROCUSTO.CCUSTO_DESCRICAO, TAB_ADM_ENTRADAS_CON.PRODENTC_VALOR, TAB_ADM_ENTRADAS_CON.PRODENTC_QTDE from TAB_ADM_ENTRADAS_CON left outer join TAB_ADM_MATCONSUMO on TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO = TAB_ADM_MATCONSUMO.MATCONS_ID left outer join TAB_APOIO_PROD_UNIT on TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID left outer join TAB_ADM_CENTROCUSTO on TAB_ADM_ENTRADAS_CON.PRODENTC_CCUSTO = TAB_ADM_CENTROCUSTO.CCUSTO_ID order by TAB_ADM_ENTRADAS_CON.PRODENTC_DATA desc, TAB_ADM_MATCONSUMO.MATCONS_NOME asc, TAB_ADM_CENTROCUSTO.CCUSTO_CODIGO asc", $db); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['PRODENTC_ID'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['PRODENTC_DATA'])).'</td>';
				$tabela .= '<td>'.$vetor['MATCONS_NOME'].' ('.$vetor['MATCONS_UNIDADE_DESC'].')'.'</td>';
				$tabela .= '<td>'.$vetor['CCUSTO_CODIGO'].' - '.$vetor['CCUSTO_DESCRICAO'].'</td>';
				$tabela .= '<td>'.'R$ '.number_format($vetor['PRODENTC_VALOR'],2,',','.').'</td>';
				$tabela .= '<td>'.$vetor['PRODENTC_QTDE'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_entradaprod_con.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>