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
			$FAMESP_FAMILIA = $_POST['FAMESP_FAMILIA'];
			$FAMESP_TECNICO = $_POST['FAMESP_TECNICO'];
			$FAMESP_GRUPO = $_POST['FAMESP_GRUPO'];
			$sql = mysql_query("insert into TAB_415421_FAMESPECIAIS (FAMESP_FAMILIA, FAMESP_TECNICO, FAMESP_GRUPO) values ('$FAMESP_FAMILIA', '$FAMESP_TECNICO', '$FAMESP_GRUPO');", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_familias_especiais.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>