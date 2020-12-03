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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$INDIG_NUC_NOME = mb_convert_case($_POST['INDIG_NUC_NOME'], MB_CASE_UPPER, 'UTF-8');
			$INDIG_NUC_ALDEIA = $_POST['INDIG_NUC_ALDEIA'];
			$sql = mysql_query("INSERT INTO TAB_INDIG_NUCLEOS (INDIG_NUC_NOME, INDIG_NUC_ALDEIA) VALUE ('$INDIG_NUC_NOME', '$INDIG_NUC_ALDEIA');", $db) or die(mysql_error());
			$INDIG_NUC_ID = mysql_insert_id();
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_indig_nucleos.php?INDIG_NUC_ID=$INDIG_NUC_ID\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>