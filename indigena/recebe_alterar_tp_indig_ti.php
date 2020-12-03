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
			$sql = mysql_query("UPDATE TAB_APOIO_INDIG_TI SET DESCRICAO = '$DESCRICAO' WHERE ID = '$id';", $db) or die(mysql_error());
			$vetorAldeia = $_POST['ALDEIA_ID'];
			$contAldeia = 0;
			foreach((array)$vetorAldeia as $vetorAldeiakey){
				$idAldeia = $_POST['ALDEIA_ID'][$contAldeia];
				$sql_REL_TIAldeia = mysql_query("SELECT * FROM TAB_INDIG_REL_TI_ALDEIA WHERE TI_ID = '$id' AND ALDEIA_ID = '$idAldeia';", $db) or die(mysql_error());
				if(mysql_num_rows($sql_REL_TIAldeia) == 0){
					$sql_ADD_TIAldeia = mysql_query("INSERT INTO TAB_INDIG_REL_TI_ALDEIA (TI_ID, ALDEIA_ID) VALUES ('$id', '$idAldeia');", $db) or die(mysql_error());
				}
				$contAldeia++;
			}
			
		/*
			echo"<script language=\"JavaScript\">
				alert('Alterado com sucesso!');
				</script>";
		*/				
				echo"<script language=\"JavaScript\">
					location.href=\"alterar_tp_indig_ti.php?id=".$id."\";
					</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>