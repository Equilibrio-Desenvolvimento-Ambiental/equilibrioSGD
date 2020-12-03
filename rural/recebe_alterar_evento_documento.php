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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			$id = $_GET['id'];
			$id_evento = $_GET['id_evento'];
			$id_familia = $_GET['id_familia'];
			$EVEDOC_DATA = reverse_date($_POST['EVEDOC_DATA']);
			$EVEDOC_DESCRICAO = mb_convert_case($_POST['EVEDOC_DESCRICAO'], MB_CASE_UPPER, 'UTF-8');
			$EVEDOC_TIPO = $_POST['EVEDOC_TIPO'];
			$sql = mysql_query("UPDATE TAB_415421_EVENTOS_DOCS SET EVEDOC_DATA = '$EVEDOC_DATA', EVEDOC_TIPO = '$EVEDOC_TIPO', EVEDOC_DESCRICAO = '$EVEDOC_DESCRICAO' WHERE EVEDOC_CODIGO = '$id' AND EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_dados_eventos.php?id_evento=$id_evento&id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>