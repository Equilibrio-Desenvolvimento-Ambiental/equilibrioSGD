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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$NUCLEO_ID = $_GET['NUCLEO_ID'];
			$DOCUMENTO_ID = $_GET['DOCUMENTO_ID'];
			$sql = mysql_query("DELETE FROM TAB_INDIG_NUCLEOS_DOCUMENTOS WHERE INDIG_NUCDOC_ID = '$DOCUMENTO_ID' AND INDIG_NUCDOC_NUCLEO = '$NUCLEO_ID';", $db) or die(mysql_error());
		/*
				echo"<script language=\"JavaScript\">
					alert('Excluido com sucesso!');
					</script>";
		*/		
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_indig_nucleos.php?INDIG_NUC_ID=$NUCLEO_ID\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>