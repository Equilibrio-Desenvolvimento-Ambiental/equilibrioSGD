﻿<?php 
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
			$INDIG_FAM_ID = $_GET['INDIG_FAM_ID'];
			$INDIG_FAM_NOME = mb_convert_case($_POST['INDIG_FAM_NOME'], MB_CASE_UPPER, 'UTF-8');
			$INDIG_FAM_ALDEIA = $_POST['INDIG_FAM_ALDEIA'];
			$sql = mysql_query("UPDATE TAB_INDIG_FAMILIAS SET INDIG_FAM_NOME = '$INDIG_FAM_NOME', INDIG_FAM_ALDEIA = '$INDIG_FAM_ALDEIA' WHERE INDIG_FAM_ID = '$INDIG_FAM_ID';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Alterado com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_indig_pessoas.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>