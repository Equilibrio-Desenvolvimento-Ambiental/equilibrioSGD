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
			$MATUSO_NOME = strtoupper($_POST['MATUSO_NOME']);
			$MATUSO_CATEGORIA = $_POST['MATUSO_CATEGORIA'];
			$MATUSO_UNIDADE = $_POST['MATUSO_UNIDADE'];
			$MATUSO_ESTOQUE_ATUAL = $_POST['MATUSO_ESTOQUE_ATUAL'];
			$MATUSO_ESTOQUE_MINIMO = $_POST['MATUSO_ESTOQUE_MINIMO'];
			$sql = mysql_query("insert into TAB_ADM_MATUSO (MATUSO_NOME, MATUSO_CATEGORIA, MATUSO_UNIDADE, MATUSO_ESTOQUE_ATUAL, MATUSO_ESTOQUE_MINIMO) values ('$MATUSO_NOME', '$MATUSO_CATEGORIA', '$MATUSO_UNIDADE', '$MATUSO_ESTOQUE_ATUAL', '$MATUSO_ESTOQUE_MINIMO');", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_matuso.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>