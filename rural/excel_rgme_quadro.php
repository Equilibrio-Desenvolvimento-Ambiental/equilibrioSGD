<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 5;
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
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			if(isset($_POST["filter01"])){
				$filter = $_POST["filter01"];
			} else {
				$filter = 0;
			}
			if($filter == 0) {
				echo"<script language=\"JavaScript\"> location.href=\"rel_export_415421.php\"; </script>";
			}
			if($filter == 41501 || $filter == 42101 || $filter == 41511 || $filter == 42111){
				$tabela = '<table border=1>';
				$tabela .= '<thead>';
				$tabela .= '<tr>';
				$tabela .= '<th align="center"><b>Município</b></th>';
				$tabela .= '<th align="center"><b>Setor de Atendimento</b></th>';
				$tabela .= '<th align="center"><b>Atividade / Evento</b></th>';
				$tabela .= '<th align="center"><b>Sub-Atividade</b></th>';
				$tabela .= '<th align="center"><b>Total</b></th>';
				$tabela .= '</tr>';
				$tabela .= '</thead>';
			} else if($filter == 41502 || $filter == 42102 || $filter == 41512 || $filter == 42112){
				$tabela = '<table border=1>';
				$tabela .= '<thead>';
				$tabela .= '<tr>';
				$tabela .= '<th align="center"><b>Opção de Benefício</b></th>';
				$tabela .= '<th align="center"><b>Atividade / Evento</b></th>';
				$tabela .= '<th align="center"><b>Sub-Atividade</b></th>';
				$tabela .= '<th align="center"><b>Total</b></th>';
				$tabela .= '</tr>';
				$tabela .= '</thead>';
			} else if($filter == 41503 || $filter == 42103 || $filter == 41513 || $filter == 42113){
				$tabela = '<table border=1>';
				$tabela .= '<thead>';
				$tabela .= '<tr>';
				$tabela .= '<th align="center"><b>Município</b></th>';
				$tabela .= '<th align="center"><b>Setor de Atendimento</b></th>';
				$tabela .= '<th align="center"><b>Opção de Benefício</b></th>';
				$tabela .= '<th align="center"><b>Atividade / Evento</b></th>';
				$tabela .= '<th align="center"><b>Sub-Atividade</b></th>';
				$tabela .= '<th align="center"><b>Total</b></th>';
				$tabela .= '</tr>';
				$tabela .= '</thead>';
			} else if($filter == 41504 || $filter == 42104 || $filter == 41514 || $filter == 42114){
				$tabela = '<table border=1>';
				$tabela .= '<thead>';
				$tabela .= '<tr>';
				$tabela .= '<th align="center"><b>Município</b></th>';
				$tabela .= '<th align="center"><b>Setor de Atendimento</b></th>';
				$tabela .= '<th align="center"><b>Evento</b></th>';
				$tabela .= '<th align="center"><b>Total</b></th>';
				$tabela .= '</tr>';
				$tabela .= '</thead>';
			} else if($filter == 41505 || $filter == 42105 || $filter == 41515 || $filter == 42115){
				$tabela = '<table border=1>';
				$tabela .= '<thead>';
				$tabela .= '<tr>';
				$tabela .= '<th align="center"><b>Técnico Responsável</b></th>';
				$tabela .= '<th align="center"><b>Evento</b></th>';
				$tabela .= '<th align="center"><b>Total</b></th>';
				$tabela .= '</tr>';
				$tabela .= '</thead>';
			}

			if($filter == 41501) {
				$DATA_INI = reverse_date($_POST['DATA_INI_41501']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_41501']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, CLASS415_TPATIV_DESC AS CAMPO_ATIV, CLASS415_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASS415_CODIGO) AS CAMPO_CONTADOR FROM VIEW_415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASS415_TPSUBATIV <> '29' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, CLASS415_TPATIV_DESC, CLASS415_TPSUBATIV_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, CLASS415_TPATIV_DESC, CLASS415_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_415_QUADRO_MUNIC_E_SETOR_X_ATIV.xls';
			}
			if($filter == 41502) {
				$DATA_INI = reverse_date($_POST['DATA_INI_41502']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_41502']);
				$sql = mysql_query("SELECT FAMILIA_BENEFICIO_DESC AS CAMPO_BENEF, CLASS415_TPATIV_DESC AS CAMPO_ATIV, CLASS415_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASS415_CODIGO) AS CAMPO_CONTADOR FROM VIEW_415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASS415_TPSUBATIV <> '29' GROUP BY FAMILIA_BENEFICIO_DESC, CLASS415_TPATIV_DESC, CLASS415_TPSUBATIV_DESC ORDER BY FAMILIA_BENEFICIO_DESC, CLASS415_TPATIV_DESC, CLASS415_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_415_QUADRO_BENEF_X_ATIV.xls';
			}
			if($filter == 41503) {
				$DATA_INI = reverse_date($_POST['DATA_INI_41503']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_41503']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, FAMILIA_BENEFICIO_DESC AS CAMPO_BENEF, CLASS415_TPATIV_DESC AS CAMPO_ATIV, CLASS415_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASS415_CODIGO) AS CAMPO_CONTADOR FROM VIEW_415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASS415_TPSUBATIV <> '29' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_BENEFICIO_DESC, CLASS415_TPATIV_DESC, CLASS415_TPSUBATIV_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_BENEFICIO_DESC, CLASS415_TPATIV_DESC, CLASS415_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_415_QUADRO_MUNIC_E_SETOR_E_BENEF_X_ATIV.xls';
			}
			if($filter == 41504) {
				$DATA_INI = reverse_date($_POST['DATA_INI_41504']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_41504']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, EVENTOS_TIPO_DESC AS CAMPO_EVENTO, COUNT(DISTINCT EVENTOS_CODIGO) AS CAMPO_CONTADOR FROM VIEW_415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASS415_TPSUBATIV <> '29' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, EVENTOS_TIPO_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC ASC, FAMILIA_SETORDESTINO_DESC ASC, EVENTOS_TIPO_DESC ASC;", $db) or die(mysql_error());
				$arquivo='REL_415_QUADRO_MUNIC_E_SETOR_X_EVENTO.xls';
			}
			if($filter == 41505) {
				$DATA_INI = reverse_date($_POST['DATA_INI_41505']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_41505']);
				$sql = mysql_query("SELECT FAMILIA_TECNICO_DESC AS CAMPO_TECNICO, EVENTOS_TIPO_DESC AS CAMPO_EVENTO, COUNT(DISTINCT EVENTOS_CODIGO) AS CAMPO_CONTADOR FROM VIEW_415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASS415_TPSUBATIV <> '29' GROUP BY FAMILIA_TECNICO_DESC, EVENTOS_TIPO_DESC ORDER BY FAMILIA_TECNICO_DESC ASC, EVENTOS_TIPO_DESC ASC;", $db) or die(mysql_error());
				$arquivo='REL_415_QUADRO_TEC_X_EVENTO.xls';
			}
			if($filter == 42101) {
				$DATA_INI = reverse_date($_POST['DATA_INI_42101']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_42101']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, CLASS421_TPATIV_DESC AS CAMPO_ATIV, CLASS421_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASS421_CODIGO) AS CAMPO_CONTADOR FROM VIEW_421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, CLASS421_TPATIV_DESC, CLASS421_TPSUBATIV_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, CLASS421_TPATIV_DESC, CLASS421_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_421_QUADRO_MUNIC_E_SETOR_X_ATIV.xls';
			}
			if($filter == 42102) {
				$DATA_INI = reverse_date($_POST['DATA_INI_42102']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_42102']);
				$sql = mysql_query("SELECT FAMILIA_BENEFICIO_DESC AS CAMPO_BENEF, CLASS421_TPATIV_DESC AS CAMPO_ATIV, CLASS421_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASS421_CODIGO) AS CAMPO_CONTADOR FROM VIEW_421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY FAMILIA_BENEFICIO_DESC, CLASS421_TPATIV_DESC, CLASS421_TPSUBATIV_DESC ORDER BY FAMILIA_BENEFICIO_DESC, CLASS421_TPATIV_DESC, CLASS421_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_421_QUADRO_BENEF_X_ATIV.xls';
			}
			if($filter == 42103) {
				$DATA_INI = reverse_date($_POST['DATA_INI_42103']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_42103']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, FAMILIA_BENEFICIO_DESC AS CAMPO_BENEF, CLASS421_TPATIV_DESC AS CAMPO_ATIV, CLASS421_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASS421_CODIGO) AS CAMPO_CONTADOR FROM VIEW_421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_BENEFICIO_DESC, CLASS421_TPATIV_DESC, CLASS421_TPSUBATIV_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_BENEFICIO_DESC, CLASS421_TPATIV_DESC, CLASS421_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_421_QUADRO_MUNIC_E_SETOR_E_BENEF_X_ATIV.xls';
			}
			if($filter == 42104) {
				$DATA_INI = reverse_date($_POST['DATA_INI_42104']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_42104']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, EVENTOS_TIPO_DESC AS CAMPO_EVENTO, COUNT(DISTINCT EVENTOS_CODIGO) AS CAMPO_CONTADOR FROM VIEW_421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, EVENTOS_TIPO_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC ASC, FAMILIA_SETORDESTINO_DESC ASC, EVENTOS_TIPO_DESC ASC;", $db) or die(mysql_error());
				$arquivo='REL_421_QUADRO_MUNIC_E_SETOR_X_EVENTO.xls';
			}
			if($filter == 42105) {
				$DATA_INI = reverse_date($_POST['DATA_INI_42105']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_42105']);
				$sql = mysql_query("SELECT FAMILIA_TECNICO_DESC AS CAMPO_TECNICO, EVENTOS_TIPO_DESC AS CAMPO_EVENTO, COUNT(DISTINCT EVENTOS_CODIGO) AS CAMPO_CONTADOR FROM VIEW_421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY FAMILIA_TECNICO_DESC, EVENTOS_TIPO_DESC ORDER BY FAMILIA_TECNICO_DESC ASC, EVENTOS_TIPO_DESC ASC;", $db) or die(mysql_error());
				$arquivo='REL_421_QUADRO_TEC_X_EVENTO.xls';
			}

			if($filter == 41511) {
				$DATA_INI = reverse_date($_POST['DATA_INI_41511']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_41511']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, CLASSRIR415_TPATIV_DESC AS CAMPO_ATIV, CLASSRIR415_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASSRIR415_CODIGO) AS CAMPO_CONTADOR FROM VIEW_RIR415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASSRIR415_TPSUBATIV <> '21' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, CLASSRIR415_TPATIV_DESC, CLASSRIR415_TPSUBATIV_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, CLASSRIR415_TPATIV_DESC, CLASSRIR415_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_RIR415_QUADRO_MUNIC_E_SETOR_X_ATIV.xls';
			}
			if($filter == 41512) {
				$DATA_INI = reverse_date($_POST['DATA_INI_41512']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_41512']);
				$sql = mysql_query("SELECT FAMILIA_BENEFICIO_DESC AS CAMPO_BENEF, CLASSRIR415_TPATIV_DESC AS CAMPO_ATIV, CLASSRIR415_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASSRIR415_CODIGO) AS CAMPO_CONTADOR FROM VIEW_RIR415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASSRIR415_TPSUBATIV <> '21' GROUP BY FAMILIA_BENEFICIO_DESC, CLASSRIR415_TPATIV_DESC, CLASSRIR415_TPSUBATIV_DESC ORDER BY FAMILIA_BENEFICIO_DESC, CLASSRIR415_TPATIV_DESC, CLASSRIR415_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_RIR415_QUADRO_BENEF_X_ATIV.xls';
			}
			if($filter == 41513) {
				$DATA_INI = reverse_date($_POST['DATA_INI_41513']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_41513']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, FAMILIA_BENEFICIO_DESC AS CAMPO_BENEF, CLASSRIR415_TPATIV_DESC AS CAMPO_ATIV, CLASSRIR415_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASSRIR415_CODIGO) AS CAMPO_CONTADOR FROM VIEW_RIR415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASSRIR415_TPSUBATIV <> '21' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_BENEFICIO_DESC, CLASSRIR415_TPATIV_DESC, CLASSRIR415_TPSUBATIV_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_BENEFICIO_DESC, CLASSRIR415_TPATIV_DESC, CLASSRIR415_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_RIR415_QUADRO_MUNIC_E_SETOR_E_BENEF_X_ATIV.xls';
			}
			if($filter == 41514) {
				$DATA_INI = reverse_date($_POST['DATA_INI_41514']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_41514']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, EVENTOS_TIPO_DESC AS CAMPO_EVENTO, COUNT(DISTINCT EVENTOS_CODIGO) AS CAMPO_CONTADOR FROM VIEW_RIR415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASSRIR415_TPSUBATIV <> '21' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, EVENTOS_TIPO_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC ASC, FAMILIA_SETORDESTINO_DESC ASC, EVENTOS_TIPO_DESC ASC;", $db) or die(mysql_error());
				$arquivo='REL_RIR415_QUADRO_MUNIC_E_SETOR_X_EVENTO.xls';
			}
			if($filter == 41515) {
				$DATA_INI = reverse_date($_POST['DATA_INI_41515']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_41515']);
				$sql = mysql_query("SELECT FAMILIA_TECNICO_DESC AS CAMPO_TECNICO, EVENTOS_TIPO_DESC AS CAMPO_EVENTO, COUNT(DISTINCT EVENTOS_CODIGO) AS CAMPO_CONTADOR FROM VIEW_RIR415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASSRIR415_TPSUBATIV <> '21' GROUP BY FAMILIA_TECNICO_DESC, EVENTOS_TIPO_DESC ORDER BY FAMILIA_TECNICO_DESC ASC, EVENTOS_TIPO_DESC ASC;", $db) or die(mysql_error());
				$arquivo='REL_RIR415_QUADRO_TEC_X_EVENTO.xls';
			}
			if($filter == 42111) {
				$DATA_INI = reverse_date($_POST['DATA_INI_42111']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_42111']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, CLASSRIR421_TPATIV_DESC AS CAMPO_ATIV, CLASSRIR421_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASSRIR421_CODIGO) AS CAMPO_CONTADOR FROM VIEW_RIR421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, CLASSRIR421_TPATIV_DESC, CLASSRIR421_TPSUBATIV_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, CLASSRIR421_TPATIV_DESC, CLASSRIR421_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_RIR421_QUADRO_MUNIC_E_SETOR_X_ATIV.xls';
			}
			if($filter == 42112) {
				$DATA_INI = reverse_date($_POST['DATA_INI_42112']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_42112']);
				$sql = mysql_query("SELECT FAMILIA_BENEFICIO_DESC AS CAMPO_BENEF, CLASSRIR421_TPATIV_DESC AS CAMPO_ATIV, CLASSRIR421_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASSRIR421_CODIGO) AS CAMPO_CONTADOR FROM VIEW_RIR421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY FAMILIA_BENEFICIO_DESC, CLASSRIR421_TPATIV_DESC, CLASSRIR421_TPSUBATIV_DESC ORDER BY FAMILIA_BENEFICIO_DESC, CLASSRIR421_TPATIV_DESC, CLASSRIR421_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_RIR421_QUADRO_BENEF_X_ATIV.xls';
			}
			if($filter == 42113) {
				$DATA_INI = reverse_date($_POST['DATA_INI_42113']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_42113']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, FAMILIA_BENEFICIO_DESC AS CAMPO_BENEF, CLASSRIR421_TPATIV_DESC AS CAMPO_ATIV, CLASSRIR421_TPSUBATIV_DESC AS CAMPO_SUBATIV, COUNT(CLASSRIR421_CODIGO) AS CAMPO_CONTADOR FROM VIEW_RIR421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_BENEFICIO_DESC, CLASSRIR421_TPATIV_DESC, CLASSRIR421_TPSUBATIV_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_BENEFICIO_DESC, CLASSRIR421_TPATIV_DESC, CLASSRIR421_TPSUBATIV_DESC;", $db) or die(mysql_error());
				$arquivo='REL_RIR421_QUADRO_MUNIC_E_SETOR_E_BENEF_X_ATIV.xls';
			}
			if($filter == 42114) {
				$DATA_INI = reverse_date($_POST['DATA_INI_42114']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_42114']);
				$sql = mysql_query("SELECT FAMILIA_MUNICIPIODESTINO_DESC AS CAMPO_MUNIC, FAMILIA_SETORDESTINO_DESC AS CAMPO_SETOR, EVENTOS_TIPO_DESC AS CAMPO_EVENTO, COUNT(DISTINCT EVENTOS_CODIGO) AS CAMPO_CONTADOR FROM VIEW_RIR421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, EVENTOS_TIPO_DESC ORDER BY FAMILIA_MUNICIPIODESTINO_DESC ASC, FAMILIA_SETORDESTINO_DESC ASC, EVENTOS_TIPO_DESC ASC;", $db) or die(mysql_error());
				$arquivo='REL_RIR421_QUADRO_MUNIC_E_SETOR_X_EVENTO.xls';
			}
			if($filter == 42115) {
				$DATA_INI = reverse_date($_POST['DATA_INI_42115']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_42115']);
				$sql = mysql_query("SELECT FAMILIA_TECNICO_DESC AS CAMPO_TECNICO, EVENTOS_TIPO_DESC AS CAMPO_EVENTO, COUNT(DISTINCT EVENTOS_CODIGO) AS CAMPO_CONTADOR FROM VIEW_RIR421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' GROUP BY FAMILIA_TECNICO_DESC, EVENTOS_TIPO_DESC ORDER BY FAMILIA_TECNICO_DESC ASC, EVENTOS_TIPO_DESC ASC;", $db) or die(mysql_error());
				$arquivo='REL_RIR421_QUADRO_TEC_X_EVENTO.xls';
			}

			$tabela .= '<tbody>';
			if($filter == 41501 || $filter == 42101 || $filter == 41511 || $filter == 42111){
				while ($vetor=mysql_fetch_array($sql)) {
					$tabela .= '<tr>';
					$tabela .= '<td>'.$vetor['CAMPO_MUNIC'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_SETOR'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_ATIV'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_SUBATIV'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_CONTADOR'].'</td>';
					$tabela .= '</tr>';
				}
			} else if($filter == 41502 || $filter == 42102 || $filter == 41512 || $filter == 42112){
				while ($vetor=mysql_fetch_array($sql)) {
					$tabela .= '<tr>';
					$tabela .= '<td>'.$vetor['CAMPO_BENEF'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_ATIV'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_SUBATIV'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_CONTADOR'].'</td>';
					$tabela .= '</tr>';
				}
			} else if($filter == 41503 || $filter == 42103 || $filter == 41513 || $filter == 42113){
				while ($vetor=mysql_fetch_array($sql)) {
					$tabela .= '<tr>';
					$tabela .= '<td>'.$vetor['CAMPO_MUNIC'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_SETOR'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_BENEF'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_ATIV'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_SUBATIV'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_CONTADOR'].'</td>';
					$tabela .= '</tr>';
				}
			} else if($filter == 41504 || $filter == 42104 || $filter == 41514 || $filter == 42114){
				while ($vetor=mysql_fetch_array($sql)) {
					$tabela .= '<tr>';
					$tabela .= '<td>'.$vetor['CAMPO_MUNIC'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_SETOR'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_EVENTO'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_CONTADOR'].'</td>';
					$tabela .= '</tr>';
				}
			} else if($filter == 41505 || $filter == 42105 || $filter == 41515 || $filter == 42115){
				while ($vetor=mysql_fetch_array($sql)) {
					$tabela .= '<tr>';
					$tabela .= '<td>'.$vetor['CAMPO_TECNICO'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_EVENTO'].'</td>';
					$tabela .= '<td>'.$vetor['CAMPO_CONTADOR'].'</td>';
					$tabela .= '</tr>';
				}
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset='utf-8'");
			header("Content-Disposition: attachment; filename=$arquivo");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>