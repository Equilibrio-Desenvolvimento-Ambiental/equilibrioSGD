<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 4;
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
			$id = $_GET['id'];
			$DESCRICAO = mb_convert_case($_POST['DESCRICAO'], MB_CASE_UPPER, 'UTF-8');
			$ATIVO = $_POST['ATIVO'];
			$sql = mysql_query("UPDATE TAB_APOIO_TPVISITRIR421 SET DESCRICAO = '$DESCRICAO', ATIVO = '$ATIVO' WHERE ID = '$id';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Alterado com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_tp_tpvisitrir421.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>