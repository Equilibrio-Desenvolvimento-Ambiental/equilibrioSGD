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
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			$id = $_GET['id'];
			$id_familia = $_GET['id_familia'];
			$FISH_DOC_DATA = reverse_date($_POST['FISH_DOC_DATA']);
			$FISH_DOC_DESCRICAO = mb_convert_case($_POST['FISH_DOC_DESCRICAO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_DOC_TIPO = $_POST['FISH_DOC_TIPO'];
			$sql = mysql_query("UPDATE TAB_FISH_DOCUMENTOS SET FISH_DOC_DATA = '$FISH_DOC_DATA', FISH_DOC_TIPO = '$FISH_DOC_TIPO', FISH_DOC_DESCRICAO = '$FISH_DOC_DESCRICAO' WHERE FISH_DOC_ID = '$id' AND FISH_FAM_ID = '$id_familia';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_fish_familias.php?id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>