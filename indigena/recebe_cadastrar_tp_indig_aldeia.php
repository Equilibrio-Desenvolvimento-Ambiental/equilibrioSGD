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
			$DESCRICAO = mb_convert_case($_POST['DESCRICAO'], MB_CASE_UPPER, 'UTF-8');
			$sql = mysql_query("INSERT INTO TAB_APOIO_INDIG_ALDEIA (DESCRICAO) VALUE ('$DESCRICAO');", $db) or die(mysql_error());
			$idAldeia = mysql_insert_id();
			$sqlAldeiaDados = mysql_query("INSERT INTO TAB_INDIG_ALDEIA_DADOS (INDIG_ALDDAD_ID, INDIG_ALDDAD_ALDEIA) VALUES (NULL, '$idAldeia');", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_tp_indig_aldeia.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>