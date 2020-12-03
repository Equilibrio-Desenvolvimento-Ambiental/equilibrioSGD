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
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			$tabela = '<table border=1>';
			$tabela .= '<thead>';
			$tabela .= '<tr>';
			$tabela .= '<th align="center"><b>Bairro/RUC</b></th>';
			$tabela .= '<th align="center"><b>Tipo da Atividade</b></th>';
			$tabela .= '<th align="center"><b>Total de Participantes</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			if(isset($_POST["filter01"])){
				$filter = $_POST["filter01"];
			} else {
				$filter = 0;
			}
			if($filter == 0) {
				echo"<script language=\"JavaScript\"> location.href=\"rel_export_444.php\"; </script>";
			}
			if($filter == 1) {
				echo"<script language=\"JavaScript\"> location.href=\"rel_export_444.php\"; </script>";
			}
			if($filter == 2) {
				$ATIV_DATA_INI = reverse_date($_POST['ATIV_DATA_INI_02']);
				$ATIV_DATA_FIM = reverse_date($_POST['ATIV_DATA_FIM_02']);
				$sql = mysql_query("select ATIV_RUC, ATIV_ATIVIDADE, Sum(ATIV_PARTICIPANTES) AS SOMA from VIEW_444_ATIV_GR where ATIV_DATA between '$ATIV_DATA_INI' and '$ATIV_DATA_FIM' group by ATIV_RUC, ATIV_ATIVIDADE order by ATIV_RUC, ATIV_ATIVIDADE", $db);
				$arquivo='REL_444_ATIV_GR_QUADRO.xls';
			}
			if($filter == 3) {
				$ATIV_DATA_INI = reverse_date($_POST['ATIV_DATA_INI_03']);
				$ATIV_DATA_FIM = reverse_date($_POST['ATIV_DATA_FIM_03']);
				$sql = mysql_query("select ATIV_RUC, ATIV_ATIVIDADE, Sum(ATIV_PARTICIPANTES) AS SOMA from VIEW_444_ATIV_SC where ATIV_DATA between '$ATIV_DATA_INI' and '$ATIV_DATA_FIM' group by ATIV_RUC, ATIV_ATIVIDADE order by ATIV_RUC, ATIV_ATIVIDADE", $db);
				$arquivo='REL_444_ATIV_SC_QUADRO.xls';
			}
			if($filter == 4) {
				$ATIV_DATA_INI = reverse_date($_POST['ATIV_DATA_INI_04']);
				$ATIV_DATA_FIM = reverse_date($_POST['ATIV_DATA_FIM_04']);
				$sql = mysql_query("select ATIV_RUC, ATIV_ATIVIDADE, Sum(ATIV_PARTICIPANTES) AS SOMA from VIEW_444_ATIV_MA where ATIV_DATA between '$ATIV_DATA_INI' and '$ATIV_DATA_FIM' group by ATIV_RUC, ATIV_ATIVIDADE order by ATIV_RUC, ATIV_ATIVIDADE", $db);
				$arquivo='REL_444_ATIV_MA_QUADRO.xls';
			}
			if($filter == 5) {
				$ATIV_DATA_INI = reverse_date($_POST['ATIV_DATA_INI_05']);
				$ATIV_DATA_FIM = reverse_date($_POST['ATIV_DATA_FIM_05']);
				$sql = mysql_query("select ATIV_RUC, ATIV_ATIVIDADE, Sum(ATIV_PARTICIPANTES) AS SOMA from VIEW_444_ATIV_IN where ATIV_DATA between '$ATIV_DATA_INI' and '$ATIV_DATA_FIM' group by ATIV_RUC, ATIV_ATIVIDADE order by ATIV_RUC, ATIV_ATIVIDADE", $db);
				$arquivo='REL_444_ATIV_IN_QUADRO.xls';
			}
			$tabela .= '<tbody>';
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$filter.'</td>';
				$tabela .= '<td>'.$vetor['ATIV_RUC'].'</td>';
				$tabela .= '<td>'.$vetor['ATIV_ATIVIDADE'].'</td>';
				$tabela .= '<td>'.$vetor['SOMA'].'</td>';
				$tabela .= '</tr>';
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