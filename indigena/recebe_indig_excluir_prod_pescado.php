<?php 
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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$idPescado = $_GET['idPescado'];
			$idEntrega = $_GET['idEntrega'];
			$idAldeia = $_GET['idAldeia'];
			$sql = mysql_query("DELETE FROM TAB_INDIG_PROD_PESCADO WHERE INDIG_MOVPES_ID = '$idPescado';", $db);
		/*
				echo"<script language=\"JavaScript\">
					alert('Excluido com sucesso!');
					</script>";
		*/		
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_indig_dados_prod_entregas.php?idEntrega=$idEntrega&idAldeia=$idAldeia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>