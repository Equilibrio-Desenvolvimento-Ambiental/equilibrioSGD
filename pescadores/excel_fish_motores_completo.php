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
			$tabela .= '<th align="center"><b>Pratica Atividade de Pesca?</b></th>';
			$tabela .= '<th align="center"><b>Possuí Motor(es) Proprio(s)?</b></th>';
			$tabela .= '<th align="center"><b>Possuí Motor(es) Emprestado(s)?</b></th>';
			$tabela .= '<th align="center"><b>Tipo do Motor</b></th>';
			$tabela .= '<th align="center"><b>Próprio?</b></th>';
			$tabela .= '<th align="center"><b>Potência</b></th>';
			$tabela .= '<th align="center"><b>Estado de Conservação</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME, TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST, TAB_APOIO_TECNICOS.DESCRICAO AS FISH_COOP_ENTREVISTA_DESC, TAB_FISH_COOP_ENTREVISTA.FISH_COOP_DTENTREVISTA, TAB_APOIO_BOOLEANO_PESCA.DESCRICAO AS FISH_COOP_ATIVPESCA_DESC, TAB_APOIO_BOOLEANO_MOTOR_PROP.DESCRICAO AS FISH_COOCAR_MOTOR_PROP_DESC, TAB_APOIO_BOOLEANO_MOTOR_ALUG.DESCRICAO AS FISH_COOCAR_MOTOR_ALUG_DESC, TAB_APOIO_EMBARC_MOTOR.DESCRICAO AS FISH_CPCMTR_TIPO_DESC, TAB_APOIO_BOOLEANO_CPCMTR_PROPRIO.DESCRICAO AS FISH_CPCMTR_PROPRIO_DESC, TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_POTENCIA, TAB_APOIO_ESTADOCONSERV.DESCRICAO AS FISH_CPCMTR_CONSERV_DESC FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_COOP_ENTREVISTA ON TAB_FISH_COOP_ENTREVISTA.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ENTREVISTA = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_PESCA ON TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ATIVPESCA = TAB_APOIO_BOOLEANO_PESCA.ID LEFT OUTER JOIN TAB_FISH_COOP_CARACTERIZACAO ON TAB_FISH_COOP_CARACTERIZACAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_FISH_COOCAR_MOTORES ON TAB_FISH_COOCAR_MOTORES.FISH_COOCAR_ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_MOTOR_PROP ON TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_MOTOR_PROP = TAB_APOIO_BOOLEANO_MOTOR_PROP.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_MOTOR_ALUG ON TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_MOTOR_ALUG = TAB_APOIO_BOOLEANO_MOTOR_ALUG.ID LEFT OUTER JOIN TAB_APOIO_EMBARC_MOTOR ON TAB_APOIO_EMBARC_MOTOR.ID = TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_TIPO LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_CPCMTR_PROPRIO ON TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_PROPRIO = TAB_APOIO_BOOLEANO_CPCMTR_PROPRIO.ID LEFT OUTER JOIN TAB_APOIO_ESTADOCONSERV ON TAB_APOIO_ESTADOCONSERV.ID = TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_CONSERV WHERE TAB_FISH_FAMILIAS.FISH_FAM_STT_COOP = 1 AND TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ID IS NOT NULL ORDER BY TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST ASC, FISH_CPCMTR_TIPO_DESC ASC, FISH_CPCMTR_PROPRIO_DESC DESC, TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_POTENCIA DESC, FISH_CPCMTR_CONSERV_DESC ASC;", $db) or die(mysql_error()); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ID'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CHEFE_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CONJ_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOP_QUEST'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOP_ENTREVISTA_DESC'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['FISH_COOP_DTENTREVISTA'])).'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOP_ATIVPESCA_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOCAR_MOTOR_PROP_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOCAR_MOTOR_ALUG_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_CPCMTR_TIPO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_CPCMTR_PROPRIO_DESC'].'</td>';
				$tabela .= '<td>'.number_format($vetor['FISH_CPCMTR_POTENCIA'],2,',','.').'</td>';
				$tabela .= '<td>'.$vetor['FISH_CPCMTR_CONSERV_DESC'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_fish_motores_completo.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>