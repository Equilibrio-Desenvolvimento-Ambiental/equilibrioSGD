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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
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
			$tabela .= '<th align="center"><b>Data</b></th>';
			$tabela .= '<th align="center"><b>Número C/C</b></th>';
			$tabela .= '<th align="center"><b>Opção de Benefício</b></th>';
			$tabela .= '<th align="center"><b>Lote</b></th>';
			$tabela .= '<th align="center"><b>Beneficiário</b></th>';
			$tabela .= '<th align="center"><b>Município</b></th>';
			$tabela .= '<th align="center"><b>Setor de Atendimento</b></th>';
			$tabela .= '<th align="center"><b>Localidade</b></th>';
			$tabela .= '<th align="center"><b>Técnico Responsável</b></th>';
			$tabela .= '<th align="center"><b>Evento</b></th>';
			$tabela .= '<th align="center"><b>Técnico da Atividade</b></th>';
			$tabela .= '<th align="center"><b>Atividade</b></th>';
			$tabela .= '<th align="center"><b>Sub-Atividade</b></th>';
			$tabela .= '<th align="center"><b>Relato da Atividade</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			if(isset($_POST["filter03"])){
				$filter = $_POST["filter03"];
			} else {
				$filter = 0;
			}
			if($filter == 7) {
				echo"<script language=\"JavaScript\"> location.href=\"rel_export_415421.php\"; </script>";
				exit;
			}
			if($filter == 8) {
				$DATA_INI = reverse_date($_POST['DATA_INI_08']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_08']);
				$sql = mysql_query("SELECT EVENTOS_DATA, FAMILIA_NUMERO, FAMILIA_BENEFICIO_DESC, FAMILIA_LOTE, FAMILIA_BENEFICIARIO, FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_LOCALDESTINO, FAMILIA_TECNICO_DESC, EVENTOS_TIPO_DESC, EVENTOS_TECNICOS_DESC, CLASS415_TPATIV_DESC AS CLASS_TPATIV_DESC, CLASS415_TPSUBATIV_DESC AS CLASS_TPSUBATIV_DESC, CLASS415_DESCRICAO AS CLASS_DESCRICAO FROM VIEW_415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASS415_TPSUBATIV <> '29' ORDER BY FAMILIA_BENEFICIO_DESC ASC, FAMILIA_BENEFICIARIO ASC, EVENTOS_DATA ASC, CLASS415_TPATIV_DESC ASC, CLASS415_TPSUBATIV_DESC ASC;", $db);
				$arquivo='REL_415_LISTA_ATIV.xls';
			}
			if($filter == 9) {
				$DATA_INI = reverse_date($_POST['DATA_INI_09']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_09']);
				$sql = mysql_query("SELECT EVENTOS_DATA, FAMILIA_NUMERO, FAMILIA_BENEFICIO_DESC, FAMILIA_LOTE, FAMILIA_BENEFICIARIO, FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_LOCALDESTINO, FAMILIA_TECNICO_DESC, EVENTOS_TIPO_DESC, EVENTOS_TECNICOS_DESC, CLASS421_TPATIV_DESC AS CLASS_TPATIV_DESC, CLASS421_TPSUBATIV_DESC AS CLASS_TPSUBATIV_DESC, CLASS421_DESCRICAO AS CLASS_DESCRICAO FROM VIEW_421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' ORDER BY FAMILIA_BENEFICIO_DESC ASC, FAMILIA_BENEFICIARIO ASC, EVENTOS_DATA ASC, CLASS421_TPATIV_DESC ASC, CLASS421_TPSUBATIV_DESC ASC;", $db);
				$arquivo='REL_421_LISTA_ATIV.xls';
			}
			if($filter == 20) {
				$DATA_INI = reverse_date($_POST['DATA_INI_20']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_20']);
				$sql = mysql_query("SELECT EVENTOS_DATA, FAMILIA_NUMERO, FAMILIA_BENEFICIO_DESC, FAMILIA_LOTE, FAMILIA_BENEFICIARIO, FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_LOCALDESTINO, FAMILIA_TECNICO_DESC, EVENTOS_TIPO_DESC, EVENTOS_TECNICOS_DESC, CLASSRIR415_TPATIV_DESC AS CLASS_TPATIV_DESC, CLASSRIR415_TPSUBATIV_DESC AS CLASS_TPSUBATIV_DESC, CLASSRIR415_DESCRICAO AS CLASS_DESCRICAO FROM VIEW_RIR415_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' AND CLASSRIR415_TPSUBATIV <> '21' ORDER BY FAMILIA_BENEFICIO_DESC ASC, FAMILIA_BENEFICIARIO ASC, EVENTOS_DATA ASC, CLASSRIR415_TPATIV_DESC ASC, CLASSRIR415_TPSUBATIV_DESC ASC;", $db);
				$arquivo='REL_RIR415_LISTA_ATIV.xls';
			}
			if($filter == 21) {
				$DATA_INI = reverse_date($_POST['DATA_INI_21']);
				$DATA_FIM = reverse_date($_POST['DATA_FIM_21']);
				$sql = mysql_query("SELECT EVENTOS_DATA, FAMILIA_NUMERO, FAMILIA_BENEFICIO_DESC, FAMILIA_LOTE, FAMILIA_BENEFICIARIO, FAMILIA_MUNICIPIODESTINO_DESC, FAMILIA_SETORDESTINO_DESC, FAMILIA_LOCALDESTINO, FAMILIA_TECNICO_DESC, EVENTOS_TIPO_DESC, EVENTOS_TECNICOS_DESC, CLASSRIR421_TPATIV_DESC AS CLASS_TPATIV_DESC, CLASSRIR421_TPSUBATIV_DESC AS CLASS_TPSUBATIV_DESC, CLASSRIR421_DESCRICAO AS CLASS_DESCRICAO FROM VIEW_RIR421_VISITAS WHERE EVENTOS_DATA BETWEEN '$DATA_INI' AND '$DATA_FIM' ORDER BY FAMILIA_BENEFICIO_DESC ASC, FAMILIA_BENEFICIARIO ASC, EVENTOS_DATA ASC, CLASSRIR421_TPATIV_DESC ASC, CLASSRIR421_TPSUBATIV_DESC ASC;", $db);
				$arquivo='REL_RIR421_LISTA_ATIV.xls';
			}
			$tabela .= '<tbody>';
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['EVENTOS_DATA'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_NUMERO'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_BENEFICIO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_LOTE'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_BENEFICIARIO'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_MUNICIPIODESTINO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_SETORDESTINO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_LOCALDESTINO'].'</td>';
				$tabela .= '<td>'.$vetor['FAMILIA_TECNICO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['EVENTOS_TIPO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['EVENTOS_TECNICOS_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['CLASS_TPATIV_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['CLASS_TPSUBATIV_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['CLASS_DESCRICAO'].'</td>';
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