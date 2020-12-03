<?php 
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
			$id = $_GET['id'];
			$sql_MATKIT_ITEMC = mysql_query("delete from TAB_ADM_MATKITS_CON where MATKITC_KIT = '$id';", $db);
//			$sql_MATKIT_ITEMU = mysql_query("delete from TAB_ADM_MATKITS_USO where MATKITU_KIT = '$id';", $db);
			$sql_MATKIT = mysql_query("delete from TAB_ADM_MATKITS where MATKIT_ID = '$id';", $db);
/*
			echo"<script language=\"JavaScript\">
				alert('Excluido com sucesso!');
				</script>";
*/		
			echo"<script language=\"JavaScript\">
				location.href=\"listar_matkits.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>