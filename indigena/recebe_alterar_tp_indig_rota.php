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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id = $_GET['id'];
			$DESCRICAO = mb_convert_case($_POST['DESCRICAO'], MB_CASE_UPPER, 'UTF-8');
			$sql = mysql_query("UPDATE TAB_APOIO_INDIG_ROTA SET DESCRICAO = '$DESCRICAO' WHERE ID = '$id';", $db) or die(mysql_error());
			$vetorTI = $_POST['TI_ID'];
			$contTI = 0;
			foreach((array)$vetorTI as $vetorTIkey){
				$idTI = $_POST['TI_ID'][$contTI];
				$sql_REL_RotaTI = mysql_query("SELECT * FROM TAB_INDIG_REL_ROTA_TI WHERE ROTA_ID = '$id' AND TI_ID = '$idTI'", $db) or die(mysql_error());
				if(mysql_num_rows($sql_REL_RotaTI) == 0){
					$sql_ADD_RotaTI = mysql_query("INSERT INTO TAB_INDIG_REL_ROTA_TI (ROTA_ID, TI_ID) VALUES ('$id', '$idTI');", $db) or die(mysql_error());
				}
				$contTI++;
			}
		/*
			echo"<script language=\"JavaScript\">
				alert('Alterado com sucesso!');
				</script>";
		*/				
				echo"<script language=\"JavaScript\">
					location.href=\"alterar_tp_indig_rota.php?id=".$id."\";
					</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>