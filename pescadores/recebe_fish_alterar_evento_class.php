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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id = $_GET['id'];
			$id_evento = $_GET['id_evento'];
			$id_familia = $_GET['id_familia'];
			$FISH_CLASS_TIPO = $_POST['subtipoFish'];
			$FISH_CLASS_DESCRICAO = $_POST['FISH_CLASS_DESCRICAO'];
			$sql = mysql_query("UPDATE TAB_FISH_CLASSIFICACAO SET FISH_CLASS_TIPO = '$FISH_CLASS_TIPO', FISH_CLASS_DESCRICAO = '$FISH_CLASS_DESCRICAO' WHERE FISH_CLASS_CODIGO = '$id' AND FISH_EVE_CODIGO = '$id_evento';", $db);
			$sqlEvento = mysql_query("UPDATE TAB_FISH_EVENTOS SET FISH_EVE_CHECKED = '2' WHERE FISH_EVE_CODIGO = '$id_evento';", $db);
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_fish_dados_eventos.php?id_evento=$id_evento&id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>