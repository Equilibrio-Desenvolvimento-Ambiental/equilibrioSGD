<?php
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
			$tabela .= '<th align="center"><b>Participa de Outro Programa ou Projeto da NE/UHE-Belo Monte?</b></th>';
			$tabela .= '<th align="center"><b>Programa/Projeto Conforme Citado pelo Entrevistado</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME, TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST, TAB_APOIO_TECNICOS.DESCRICAO AS  FISH_COOP_ENTREVISTA_DESC, TAB_FISH_COOP_ENTREVISTA.FISH_COOP_DTENTREVISTA, TAB_APOIO_BOOLEANO.DESCRICAO AS FISH_COOP_PROJETONESA_DESC, TAB_APOIO_TPPROJSUHE.DESCRICAO AS FISH_COOUHE_PROJETO_DESC FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_COOP_ENTREVISTA ON TAB_FISH_COOP_ENTREVISTA.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ENTREVISTA = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_FISH_COOP_ENTREVISTA.FISH_COOP_PROJETONESA = TAB_APOIO_BOOLEANO.ID LEFT OUTER JOIN TAB_FISH_COOP_PROJUHE ON TAB_FISH_COOP_PROJUHE.FISH_COOP_ID = TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ID LEFT OUTER JOIN TAB_APOIO_TPPROJSUHE ON TAB_FISH_COOP_PROJUHE.FISH_COOUHE_PROJETO = TAB_APOIO_TPPROJSUHE.ID WHERE TAB_FISH_FAMILIAS.FISH_FAM_STT_COOP = 1 AND TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ID IS NOT NULL ORDER BY TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST ASC, FISH_COOUHE_PROJETO_DESC ASC;", $db) or die(mysql_error()); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ID'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CHEFE_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CONJ_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOP_QUEST'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOP_ENTREVISTA_DESC'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['FISH_COOP_DTENTREVISTA'])).'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOP_PROJETONESA_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOUHE_PROJETO_DESC'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_fish_projuhe_completo.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>