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
			$id_familia = $_GET['id_familia'];
			$DADOS_ATEND421 = $_POST['DADOS_ATEND421'];
			$DADOS_MOTIVO421 = $_POST['DADOS_MOTIVO421'];
			$DADOS_OBS421 = $_POST['DADOS_OBS421'];
			$DADOS_DTENTRADA_421 = reverse_date($_POST['DADOS_DTENTRADA_421']);
			$DADOS_DTSAIDA_421 = reverse_date($_POST['DADOS_DTSAIDA_421']);
			$DADOS_PEADS = $_POST['DADOS_PEADS'];
			$DADOS_ATEND415 = $_POST['DADOS_ATEND415'];
			$DADOS_MOTIVO415 = $_POST['DADOS_MOTIVO415'];
			$DADOS_OBS415 = $_POST['DADOS_OBS415'];
			$DADOS_TPPROJ415 = $_POST['DADOS_TPPROJ415'];
			$DADOS_SITPROJ415 = $_POST['DADOS_SITPROJ415'];
			$DADOS_DTENTRADA_415 = reverse_date($_POST['DADOS_DTENTRADA_415']);
			$DADOS_DTSAIDA_415 = reverse_date($_POST['DADOS_DTSAIDA_415']);
			$DADOS_CAR = $_POST['DADOS_CAR'];
			$DADOS_CAR_STATUS = $_POST['DADOS_CAR_STATUS'];
			$DADOS_DAP = $_POST['DADOS_DAP'];
			$DADOS_DAP_STATUS = $_POST['DADOS_DAP_STATUS'];
			$DADOS_DLA = $_POST['DADOS_DLA'];
			$DADOS_DLA_STATUS = $_POST['DADOS_DLA_STATUS'];
			$DADOS_VULNERAVEL = $_POST['DADOS_VULNERAVEL'];
			$DADOS_INDIGENA = $_POST['DADOS_INDIGENA'];
			$DADOS_LOTERRC = $_POST['DADOS_LOTERRC'];
			$DADOS_ATENDRIR = $_POST['DADOS_ATENDRIR'];
			$DADOS_MOTIVORIR = $_POST['DADOS_MOTIVORIR'];
			$DADOS_OBSRIR = $_POST['DADOS_OBSRIR'];
			$DADOS_TPPROJRIR = $_POST['DADOS_TPPROJRIR'];
			$DADOS_SITPROJRIR = $_POST['DADOS_SITPROJRIR'];
			$DADOS_RIR_AVIARIO = $_POST['DADOS_RIR_AVIARIO'];
			$DADOS_RIR_VIVEIRO = $_POST['DADOS_RIR_VIVEIRO'];
			$DADOS_RIR_ROCA = $_POST['DADOS_RIR_ROCA'];
			$DADOS_RIR_FOSSA = $_POST['DADOS_RIR_FOSSA'];
			$DADOS_RIR_FILTRO = $_POST['DADOS_RIR_FILTRO'];
			$DADOS_RIR_CASAFARINHA = $_POST['DADOS_RIR_CASAFARINHA'];
			$DADOS_RIR_BARCACA = $_POST['DADOS_RIR_BARCACA'];
			$DADOS_RIR_GALPAO = $_POST['DADOS_RIR_GALPAO'];
			$DADOS_RIR_AVIARIO2CICLO = $_POST['DADOS_RIR_AVIARIO2CICLO'];

			$sql = mysql_query("update TAB_415421_DADOSGERAIS set DADOS_ATEND421 = '$DADOS_ATEND421', DADOS_MOTIVO421 = '$DADOS_MOTIVO421', DADOS_OBS421 = '$DADOS_OBS421', DADOS_DTENTRADA_421 = '$DADOS_DTENTRADA_421', DADOS_DTSAIDA_421 = '$DADOS_DTSAIDA_421', DADOS_PEADS = '$DADOS_PEADS', DADOS_ATEND415 =  '$DADOS_ATEND415', DADOS_MOTIVO415 = '$DADOS_MOTIVO415', DADOS_OBS415 = '$DADOS_OBS415', DADOS_TPPROJ415 =  '$DADOS_TPPROJ415', DADOS_SITPROJ415 = '$DADOS_SITPROJ415', DADOS_DTENTRADA_415 = '$DADOS_DTENTRADA_415', DADOS_DTSAIDA_415 = '$DADOS_DTSAIDA_415', DADOS_CAR = '$DADOS_CAR', DADOS_CAR_STATUS = '$DADOS_CAR_STATUS', DADOS_DAP = '$DADOS_DAP', DADOS_DAP_STATUS = '$DADOS_DAP_STATUS', DADOS_DLA = '$DADOS_DLA', DADOS_DLA_STATUS =  '$DADOS_DLA_STATUS', DADOS_VULNERAVEL = '$DADOS_VULNERAVEL', DADOS_INDIGENA = '$DADOS_INDIGENA', DADOS_LOTERRC = '$DADOS_LOTERRC', DADOS_ATENDRIR =  '$DADOS_ATENDRIR', DADOS_MOTIVORIR = '$DADOS_MOTIVORIR', DADOS_OBSRIR = '$DADOS_OBSRIR', DADOS_TPPROJRIR = '$DADOS_TPPROJRIR', DADOS_SITPROJRIR = '$DADOS_SITPROJRIR', DADOS_RIR_AVIARIO = '$DADOS_RIR_AVIARIO', DADOS_RIR_VIVEIRO = '$DADOS_RIR_VIVEIRO', DADOS_RIR_ROCA = '$DADOS_RIR_ROCA', DADOS_RIR_FOSSA = '$DADOS_RIR_FOSSA', DADOS_RIR_FILTRO = '$DADOS_RIR_FILTRO', DADOS_RIR_CASAFARINHA = '$DADOS_RIR_CASAFARINHA', DADOS_RIR_BARCACA = '$DADOS_RIR_BARCACA', DADOS_RIR_GALPAO = '$DADOS_RIR_GALPAO', DADOS_RIR_AVIARIO2CICLO = '$DADOS_RIR_AVIARIO2CICLO' WHERE FAMILIA_CODIGO = '$id_familia';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_familias.php?id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>