﻿<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 7;
	session_start();
	if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
		echo "Esta área é restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db) or die(mysql_error());
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
			$tabela .= '<th align="center"><b>Código - Família</b></th>';
			$tabela .= '<th align="center"><b>Nome - Chefe da Família</b></th>';
			$tabela .= '<th align="center"><b>Nome - Conjuge da Família</b></th>';
			$tabela .= '<th align="center"><b>Quest. - Cooperativa</b></th>';
			$tabela .= '<th align="center"><b>Entrevistador</b></th>';
			$tabela .= '<th align="center"><b>Dt. Entrev. - Cooperativa</b></th>';
			$tabela .= '<th align="center"><b>Possuí Outras Rendas </b></th>';
			$tabela .= '<th align="center"><b>Além da pesca alguém da família tem outra atividade remunerada?</b></th>';
			$tabela .= '<th align="center"><b>Componente Familair</b></th>';
			$tabela .= '<th align="center"><b>Tipo da Atividade de Renda</b></th>';
			$tabela .= '<th align="center"><b>Remuneração Mensal (R$)</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME, TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST, TAB_APOIO_TECNICOS.DESCRICAO AS FISH_COOP_ENTREVISTA_DESC, TAB_FISH_COOP_ENTREVISTA.FISH_COOP_DTENTREVISTA, TAB_APOIO_BOOLEANO.DESCRICAO AS FISH_COOP_OUTRASRENDAS_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME AS FISH_COOREN_COMPONENTE_DESC, TAB_APOIO_OCUPACAO.DESCRICAO AS FISH_COOREN_OCUPACAO_DESC, TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_RENDA FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_COOP_ENTREVISTA ON TAB_FISH_COOP_ENTREVISTA.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ENTREVISTA = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_FISH_COOP_OUTRASRENDAS ON TAB_FISH_COOP_OUTRASRENDAS.FISH_COOP_ID = TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ID LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_COMPONENTE = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ID LEFT OUTER JOIN TAB_APOIO_OCUPACAO ON TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_OCUPACAO = TAB_APOIO_OCUPACAO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_FISH_COOP_ENTREVISTA.FISH_COOP_OUTRASRENDAS = TAB_APOIO_BOOLEANO.ID WHERE TAB_FISH_FAMILIAS.FISH_FAM_STT_COOP = 1 AND TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ID IS NOT NULL ORDER BY TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST ASC, FISH_COOREN_COMPONENTE_DESC ASC, FISH_COOREN_OCUPACAO_DESC ASC, TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_RENDA DESC;", $db) or die(mysql_error()); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ID'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CHEFE_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CONJ_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOP_QUEST'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOP_ENTREVISTA_DESC'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['FISH_COOP_DTENTREVISTA'])).'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOP_OUTRASRENDAS_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOREN_COMPONENTE_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOREN_OCUPACAO_DESC'].'</td>';
				$tabela .= '<td>'.number_format($vetor['FISH_COOREN_RENDA'],2,',','.').'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_fish_outrasrendas_completo.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>