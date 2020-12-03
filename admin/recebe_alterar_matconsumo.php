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
			$MATCONS_NOME = strtoupper($_POST['MATCONS_NOME']);
			$MATCONS_CATEGORIA = $_POST['MATCONS_CATEGORIA'];
			$MATCONS_UNIDADE = $_POST['MATCONS_UNIDADE'];
			$MATCONS_ESTOQUE_ATUAL = $_POST['MATCONS_ESTOQUE_ATUAL'];
			$MATCONS_ESTOQUE_MINIMO = $_POST['MATCONS_ESTOQUE_MINIMO'];
			$sql = mysql_query("update TAB_ADM_MATCONSUMO set MATCONS_NOME = '$MATCONS_NOME', MATCONS_CATEGORIA = '$MATCONS_CATEGORIA', MATCONS_UNIDADE = '$MATCONS_UNIDADE', MATCONS_ESTOQUE_ATUAL = '$MATCONS_ESTOQUE_ATUAL', MATCONS_ESTOQUE_MINIMO = '$MATCONS_ESTOQUE_MINIMO' where MATCONS_ID = '$id';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_matconsumo.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>