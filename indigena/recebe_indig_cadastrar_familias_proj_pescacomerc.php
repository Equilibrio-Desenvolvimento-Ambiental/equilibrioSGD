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
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			$idPessoa = $_GET['idPessoa'];

			$INDIG_FAMPPC_DATAREG = reverse_date($_POST['INDIG_FAMPPC_DATAREG']);
			$INDIG_FAMPPC_STATUS = $_POST['INDIG_FAMPPC_STATUS'];
			$INDIG_FAMPPC_SATISFACAO = $_POST['INDIG_FAMPPC_SATISFACAO'];
			$INDIG_FAMPPC_COMERCIO = $_POST['INDIG_FAMPPC_COMERCIO'];
			$INDIG_FAMPPC_TERCEIRO = mb_convert_case($_POST['INDIG_FAMPPC_TERCEIRO'], MB_CASE_UPPER, 'UTF-8');
			$INDIG_FAMPPC_PPARTESANAL = $_POST['INDIG_FAMPPC_PPARTESANAL'];
	
			$sql = mysql_query("INSERT INTO TAB_INDIG_FAMILIAS_PESCACOMERC (INDIG_FAMPPC_PESSOA, INDIG_FAMPPC_DATAREG, INDIG_FAMPPC_STATUS, INDIG_FAMPPC_SATISFACAO, INDIG_FAMPPC_COMERCIO, INDIG_FAMPPC_TERCEIRO, INDIG_FAMPPC_PPARTESANAL) VALUES ('$idPessoa', '$INDIG_FAMPPC_DATAREG', '$INDIG_FAMPPC_STATUS', '$INDIG_FAMPPC_SATISFACAO', '$INDIG_FAMPPC_COMERCIO', '$INDIG_FAMPPC_TERCEIRO', '$INDIG_FAMPPC_PPARTESANAL');", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_indig_familias_dados.php?idPessoa=$idPessoa\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>