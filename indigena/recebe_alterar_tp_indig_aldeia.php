<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 8;
	session_start();
	if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
		echo "Esta área é restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id = $_GET['id'];
			$DESCRICAO = mb_convert_case($_POST['DESCRICAO'], MB_CASE_UPPER, 'UTF-8');
			$INDIG_ALDDAD_FAMILIAS = $_POST['INDIG_ALDDAD_FAMILIAS'];
			$INDIG_ALDDAD_PESCADORES = $_POST['INDIG_ALDDAD_PESCADORES'];
			$INDIG_ALDDAD_PESCA_CX120 = $_POST['INDIG_ALDDAD_PESCA_CX120'];
			$INDIG_ALDDAD_PESCA_CX160 = $_POST['INDIG_ALDDAD_PESCA_CX160'];
			$INDIG_ALDDAD_PESCA_GL20 = $_POST['INDIG_ALDDAD_PESCA_GL20'];
			$INDIG_ALDDAD_PESCA_GL50 = $_POST['INDIG_ALDDAD_PESCA_GL50'];
			$INDIG_ALDDAD_PESCA_GELO = $_POST['INDIG_ALDDAD_PESCA_GELO'];
			$INDIG_ALDDAD_PESCA_COMB = $_POST['INDIG_ALDDAD_PESCA_COMB'];
			$INDIG_ALDDAD_TRANS_CX120 = $_POST['INDIG_ALDDAD_TRANS_CX120'];
			$INDIG_ALDDAD_TRANS_CX160 = $_POST['INDIG_ALDDAD_TRANS_CX160'];
			$INDIG_ALDDAD_TRANS_GL20 = $_POST['INDIG_ALDDAD_TRANS_GL20'];
			$INDIG_ALDDAD_TRANS_GL50 = $_POST['INDIG_ALDDAD_TRANS_GL50'];
			$INDIG_ALDDAD_TRANS_GELO = $_POST['INDIG_ALDDAD_TRANS_GELO'];
			$INDIG_ALDDAD_TRANS_COMB = $_POST['INDIG_ALDDAD_TRANS_COMB'];
			
			$sql = mysql_query("UPDATE TAB_APOIO_INDIG_ALDEIA SET DESCRICAO = '$DESCRICAO' WHERE ID = '$id';", $db) or die(mysql_error());
			$sqlAldeiaDados = mysql_query("UPDATE TAB_INDIG_ALDEIA_DADOS SET INDIG_ALDDAD_FAMILIAS = '$INDIG_ALDDAD_FAMILIAS', INDIG_ALDDAD_PESCADORES = '$INDIG_ALDDAD_PESCADORES', INDIG_ALDDAD_PESCA_CX120 = '$INDIG_ALDDAD_PESCA_CX120', INDIG_ALDDAD_PESCA_CX160 = '$INDIG_ALDDAD_PESCA_CX160', INDIG_ALDDAD_PESCA_GL20 = '$INDIG_ALDDAD_PESCA_GL20', INDIG_ALDDAD_PESCA_GL50 = '$INDIG_ALDDAD_PESCA_GL50', INDIG_ALDDAD_PESCA_GELO = '$INDIG_ALDDAD_PESCA_GELO', INDIG_ALDDAD_PESCA_COMB = '$INDIG_ALDDAD_PESCA_COMB', INDIG_ALDDAD_TRANS_CX120 = '$INDIG_ALDDAD_TRANS_CX120', INDIG_ALDDAD_TRANS_CX160 = '$INDIG_ALDDAD_TRANS_CX160', INDIG_ALDDAD_TRANS_GL20 = '$INDIG_ALDDAD_TRANS_GL20', INDIG_ALDDAD_TRANS_GL50 = '$INDIG_ALDDAD_TRANS_GL50', INDIG_ALDDAD_TRANS_GELO = '$INDIG_ALDDAD_TRANS_GELO', INDIG_ALDDAD_TRANS_COMB = '$INDIG_ALDDAD_TRANS_COMB' WHERE INDIG_ALDDAD_ALDEIA = '$id';", $db) or die(mysql_error());
		
		/*
			echo"<script language=\"JavaScript\">
				alert('Alterado com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_tp_indig_aldeia.php?id=".$id."\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>