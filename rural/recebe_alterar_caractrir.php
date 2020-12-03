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
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			$id_familia = $_GET['id_familia'];
			$CARACTRIR_FUNDIARIO = $_POST['CARACTRIR_FUNDIARIO'];
			$CARACTRIR_PONTOOCUP = $_POST['CARACTRIR_PONTOOCUP'];
			$CARACTRIR_BENEFORIGINAL = $_POST['CARACTRIR_BENEFORIGINAL'];
			$CARACTRIR_BENEFOFERTADO = $_POST['CARACTRIR_BENEFOFERTADO'];
			$CARACTRIR_DOMICILIO = $_POST['CARACTRIR_DOMICILIO'];
			$CARACTRIR_MUNICIPIO = $_POST['CARACTRIR_MUNICIPIO'];
			$sql = mysql_query("update TAB_415421_PONTOOCUP set CARACTRIR_FUNDIARIO = '$CARACTRIR_FUNDIARIO', CARACTRIR_PONTOOCUP = '$CARACTRIR_PONTOOCUP', CARACTRIR_BENEFORIGINAL = '$CARACTRIR_BENEFORIGINAL', CARACTRIR_BENEFOFERTADO = '$CARACTRIR_BENEFOFERTADO', CARACTRIR_DOMICILIO = '$CARACTRIR_DOMICILIO', CARACTRIR_MUNICIPIO = '$CARACTRIR_MUNICIPIO' where FAMILIA_CODIGO = '$id_familia';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_familias.php?id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>