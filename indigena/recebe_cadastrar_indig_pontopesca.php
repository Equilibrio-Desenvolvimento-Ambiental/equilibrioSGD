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
			function moeda($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor);
                return $valor;
			}

			$INDIG_PP_NOME = mb_convert_case($_POST['INDIG_PP_NOME'], MB_CASE_UPPER, 'UTF-8');
			$INDIG_PP_COORD_FUSO = $_POST['INDIG_PP_COORD_FUSO'];
			$INDIG_PP_COORD_ESTE = moeda($_POST['INDIG_PP_COORD_ESTE']);
			$INDIG_PP_COORD_NORTE = moeda($_POST['INDIG_PP_COORD_NORTE']);
			$INDIG_PP_COORD_ALT = moeda($_POST['INDIG_PP_COORD_ALT']);
			$sql = mysql_query("INSERT INTO TAB_INDIG_PONTOPESCA (INDIG_PP_NOME, INDIG_PP_COORD_FUSO, INDIG_PP_COORD_ESTE, INDIG_PP_COORD_NORTE, INDIG_PP_COORD_ALT) VALUE ('$INDIG_PP_NOME', '$INDIG_PP_COORD_FUSO', '$INDIG_PP_COORD_ESTE', '$INDIG_PP_COORD_NORTE', '$INDIG_PP_COORD_ALT');", $db) or die(mysql_error());
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