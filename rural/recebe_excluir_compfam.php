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
			$id_compfam = $_GET['id_compfam'];
			$id_familia = $_GET['id_familia'];
			$sql_TRABALHO = mysql_query("delete from TAB_415421_CF_TRABALHO where COMPFAM_CODIGO = '$id_compfam';", $db);
			$sql_DOC = mysql_query("delete from TAB_415421_CF_DOC where COMPFAM_CODIGO = '$id_compfam';", $db);
			$sql_DADOS = mysql_query("delete from TAB_415421_CF_DADOS where COMPFAM_CODIGO = '$id_compfam';", $db);

			$sql_exclui = mysql_query("delete from TAB_415421_COMPFAMILIAR where COMPFAM_CODIGO = '$id_compfam' and FAMILIA_CODIGO = '$id_familia';", $db);
	/*
			echo"<script language=\"JavaScript\">
				alert('Excluido com sucesso!');
				</script>";
	*/		
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_familias.php?id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>