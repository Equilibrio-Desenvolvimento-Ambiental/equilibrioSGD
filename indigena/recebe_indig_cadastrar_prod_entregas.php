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
			$idAldeia = $_GET['idAldeia'];
			if(!empty($_POST['INDIG_MOVENT_DATA'])){
				$INDIG_MOVENT_DATA = reverse_date($_POST['INDIG_MOVENT_DATA']);
			} else {
				$INDIG_MOVENT_DATA = date('Y-m-d');
			}
			$INDIG_MOVENT_TECNICO = $_POST['INDIG_MOVENT_TECNICO'];
			
			$sql = mysql_query("INSERT INTO TAB_INDIG_PROD_ENTREGAS (INDIG_MOVENT_ALDEIA, INDIG_MOVENT_DATA, INDIG_MOVENT_TECNICO) VALUES ('$idAldeia', '$INDIG_MOVENT_DATA', '$INDIG_MOVENT_TECNICO');", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_tp_indig_aldeia.php?id=$idAldeia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>