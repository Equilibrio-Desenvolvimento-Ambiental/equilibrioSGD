﻿<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 6;
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
			$idPedido = $_GET['idPedido'];
			$PEDIDO_OBS = $_POST['PEDIDO_OBS'];
			$sql = mysql_query("UPDATE TAB_ADM_PEDIDOS SET PEDIDO_STATUS = '7', PEDIDO_OBS = '$PEDIDO_OBS' WHERE PEDIDO_ID = '$idPedido';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Alterado com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"gestao_saidaprod.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>