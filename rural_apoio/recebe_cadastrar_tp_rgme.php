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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]';", $db);
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
			$DESCRICAO = $_POST['DESCRICAO'];
			$DATA_INICIAL = reverse_date($_POST['DATA_INICIAL']);
			$DATA_FINAL = reverse_date($_POST['DATA_FINAL']);
			$ANO = $_POST['ANO'];
			$MES = $_POST['MES'];
			$sql = mysql_query("insert into TAB_APOIO_RGME (DESCRICAO, DATA_INICIAL, DATA_FINAL, ANO, MES) values ('$DESCRICAO', '$DATA_INICIAL', '$DATA_FINAL', '$ANO', '$MES');", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_tp_rgme.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>