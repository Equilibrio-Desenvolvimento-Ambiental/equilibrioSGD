<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 1;
	session_start();
	if($_SESSION['nivel'] != 1) {
		echo"Você não tem permissão para ficar nesta area ".$_SESSION['nome'];
		echo ". Esta é uma área restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
			$num_permissao = mysql_num_rows($sql_permissao);
				if ($num_permissao == 0) {
					echo "Esta área é restrita. Clique ";
					echo "<a href=\"../index.html\">aqui</a>";
					echo " para fazer o LOGIN.";
					exit;
				} else {
					$id = $_GET['id'];
					$sql_exclui = mysql_query("delete from TAB_MAIN_PROJECTS where ID_PROJETO = '$id'", $db);
		/*
					echo"<script language=\"JavaScript\">
						alert('Excluido com sucesso!');
						</script>";
		*/		
					echo"<script language=\"JavaScript\">
						location.href=\"listarprojetos.php\";
						</script>";
				}
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>