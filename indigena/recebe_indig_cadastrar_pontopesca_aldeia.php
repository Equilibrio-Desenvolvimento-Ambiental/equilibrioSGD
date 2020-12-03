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
			$INDIG_PP_ID = $_GET['INDIG_PP_ID'];

			$vetINDIG_PPA_ALDEIA = $_POST['INDIG_PPA_ALDEIA'];
			$contINDIG_PPA_ALDEIA = 0;
			foreach((array)$vetINDIG_PPA_ALDEIA as $vetINDIG_PPA_ALDEIAkey){
				$INDIG_PPA_ALDEIA = $_POST['INDIG_PPA_ALDEIA'][$contINDIG_PPA_ALDEIA];
				$sqlConsulta = mysql_query("SELECT INDIG_PPA_ID FROM TAB_INDIG_PONTOPESCA_ALDEIA WHERE INDIG_PPA_PONTO = '$INDIG_PP_ID' AND INDIG_PPA_ALDEIA = '$INDIG_PPA_ALDEIA';", $db) or die(mysql_error());
				if(mysql_num_rows($sqlConsulta) == 0){
					if(strcasecmp($INDIG_PPA_ALDEIA, '0') != 0) {
						$sqlInsert = mysql_query("INSERT INTO TAB_INDIG_PONTOPESCA_ALDEIA (INDIG_PPA_PONTO, INDIG_PPA_ALDEIA) VALUES ('$INDIG_PP_ID', '$INDIG_PPA_ALDEIA');", $db) or die(mysql_error());	
					}
				}
				$contINDIG_PPA_ALDEIA++;
			}
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_indig_pontopesca.php?INDIG_PP_ID=$INDIG_PP_ID\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>