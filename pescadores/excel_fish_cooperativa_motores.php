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
			$tabela .= '<th align="center"><b>FISH_FAM_ID</b></th>';
			$tabela .= '<th align="center"><b>FISH_CPCMTR_TIPO_DESC</b></th>';
			$tabela .= '<th align="center"><b>FISH_CPCMTR_PROPRIO_DESC</b></th>';
			$tabela .= '<th align="center"><b>FISH_CPCMTR_POTENCIA</b></th>';
			$tabela .= '<th align="center"><b>FISH_CPCMTR_ESTADO_DESC</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_APOIO_EMBARC_MOTOR.DESCRICAO AS FISH_CPCMTR_TIPO_DESC, TAB_APOIO_BOOLEANO.DESCRICAO AS FISH_CPCMTR_PROPRIO_DESC, TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_POTENCIA, TAB_APOIO_ESTADOCONSERV.DESCRICAO AS FISH_CPCMTR_ESTADO_DESC FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_COOP_CARACTERIZACAO ON TAB_FISH_COOP_CARACTERIZACAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_FISH_COOCAR_MOTORES ON TAB_FISH_COOCAR_MOTORES.FISH_COOCAR_ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_ID LEFT OUTER JOIN TAB_APOIO_EMBARC_MOTOR ON TAB_APOIO_EMBARC_MOTOR.ID = TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_TIPO LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_APOIO_BOOLEANO.ID = TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_PROPRIO LEFT OUTER JOIN TAB_APOIO_ESTADOCONSERV ON TAB_APOIO_ESTADOCONSERV.ID = TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_CONSERV WHERE TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_ID IS NOT NULL ORDER BY TAB_FISH_FAMILIAS.FISH_FAM_ID ASC, FISH_CPCMTR_TIPO_DESC ASC, FISH_CPCMTR_PROPRIO_DESC DESC, TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_POTENCIA ASC;", $db) or die(mysql_error()); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ID'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_CPCMTR_TIPO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_CPCMTR_PROPRIO_DESC'].'</td>';
				$tabela .= '<td>'. number_format($vetor['FISH_CPCMTR_POTENCIA'],2,',','.').'</td>';
				$tabela .= '<td>'.$vetor['FISH_CPCMTR_ESTADO_DESC'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_fish_cooperativa_motores.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>