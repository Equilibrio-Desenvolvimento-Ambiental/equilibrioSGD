<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 7;
	session_start();
	if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
		echo "Esta área é restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]'", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
				$FISH_FIPROJ_ID = $_GET['FISH_FIPROJ_ID'];
				$id = $_GET['id'];
				$id_familia = $_GET['id_familia'];
				$sql = mysql_query("DELETE FROM TAB_FISH_COOPINT_PROJETO WHERE FISH_FIPROJ_ID = '$FISH_FIPROJ_ID' AND FISH_FCOMP_ID = '$id';", $db) or die(mysql_error());
		/*
				echo"<script language=\"JavaScript\">
					alert('Excluido com sucesso!');
					</script>";
		*/		
				echo"<script language=\"JavaScript\">
					location.href=\"alterar_fish_familias_componente.php?	id=$id&id_familia=$id_familia\";
					</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>