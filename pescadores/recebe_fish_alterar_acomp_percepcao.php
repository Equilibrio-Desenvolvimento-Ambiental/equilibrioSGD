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
			
			$id_camp = $_GET['id_camp'];
			$id_familia = $_GET['id_familia'];

			$FISH_AP_BOO_MOTOR = $_POST['FISH_AP_BOO_MOTOR'];
			$FISH_AP_FK_MOTORNVIST = $_POST['FISH_AP_FK_MOTORNVIST'];
			$FISH_AP_BOO_MOTORCONSERV = $_POST['FISH_AP_BOO_MOTORCONSERV'];
			$FISH_AP_TXT_MOTORCONSERV = mb_convert_case($_POST['FISH_AP_TXT_MOTORCONSERV'], $MB_CASE_UPPER, 'UTF-8');
			$FISH_AP_FK_MOTORPOSSE = $_POST['FISH_AP_FK_MOTORPOSSE'];
			$FISH_AP_BOO_EMBARC = $_POST['FISH_AP_BOO_EMBARC'];
			$FISH_AP_FK_EMBARCNVIST = $_POST['FISH_AP_FK_EMBARCNVIST'];
			$FISH_AP_BOO_EMBARCCONSERV = $_POST['FISH_AP_BOO_EMBARCCONSERV'];
			$FISH_AP_TXT_EMBARCCONSERV = mb_convert_case($_POST['FISH_AP_TXT_EMBARCCONSERV'], MB_CASE_UPPER, 'UTF-8');
			$FISH_AP_FK_EMBARCPOSSE = $_POST['FISH_AP_FK_EMBARCPOSSE'];
			$FISH_AP_BOO_TRALHA = $_POST['FISH_AP_BOO_TRALHA'];
			$FISH_AP_FK_TRALHANVIST = $_POST['FISH_AP_FK_TRALHANVIST'];
			$FISH_AP_BOO_TRALHACONSERV = $_POST['FISH_AP_BOO_TRALHACONSERV'];
			$FISH_AP_TXT_TRALHACONSERV = mb_convert_case($_POST['FISH_AP_TXT_TRALHACONSERV'], MB_CASE_UPPER, 'UTF-8');
			$FISH_AP_FK_TRALHAPOSSE = $_POST['FISH_AP_FK_TRALHAPOSSE'];
			$FISH_AP_BOO_EVIDPESCANDO = $_POST['FISH_AP_BOO_EVIDPESCANDO'];
			$FISH_AP_TXT_EVIDPESCANDO = mb_convert_case($_POST['FISH_AP_TXT_EVIDPESCANDO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_AP_BOO_EVIDVENDA = $_POST['FISH_AP_BOO_EVIDVENDA'];
			$FISH_AP_TXT_EVIDVENDA = mb_convert_case($_POST['FISH_AP_TXT_EVIDVENDA'], MB_CASE_UPPER, 'UTF-8');
			$FISH_AP_BOO_EVIDFALSIDADE = $_POST['FISH_AP_BOO_EVIDFALSIDADE'];
			$FISH_AP_TXT_EVIDFALSIDADE = mb_convert_case($_POST['FISH_AP_TXT_EVIDFALSIDADE'], MB_CASE_UPPER, 'UTF-8');
			$FISH_AP_TXT_OBSERVACOES = mb_convert_case($_POST['FISH_AP_TXT_OBSERVACOES'], MB_CASE_UPPER, 'UTF-8');
			$FISH_AP_TXT_PERCEPCOES = mb_convert_case($_POST['FISH_AP_TXT_PERCEPCOES'], MB_CASE_UPPER, 'UTF-8');
			
			$comandosql = "UPDATE TAB_FISH_ACOMP_PERCEPCAO SET FISH_AP_BOO_MOTOR = '$FISH_AP_BOO_MOTOR', FISH_AP_FK_MOTORNVIST = '$FISH_AP_FK_MOTORNVIST', FISH_AP_BOO_MOTORCONSERV = '$FISH_AP_BOO_MOTORCONSERV', FISH_AP_TXT_MOTORCONSERV = '$FISH_AP_TXT_MOTORCONSERV', FISH_AP_FK_MOTORPOSSE = '$FISH_AP_FK_MOTORPOSSE', FISH_AP_BOO_EMBARC = '$FISH_AP_BOO_EMBARC', FISH_AP_FK_EMBARCNVIST = '$FISH_AP_FK_EMBARCNVIST', FISH_AP_BOO_EMBARCCONSERV = '$FISH_AP_BOO_EMBARCCONSERV', FISH_AP_TXT_EMBARCCONSERV = '$FISH_AP_TXT_EMBARCCONSERV', FISH_AP_FK_EMBARCPOSSE = '$FISH_AP_FK_EMBARCPOSSE', FISH_AP_BOO_TRALHA = '$FISH_AP_BOO_TRALHA', FISH_AP_FK_TRALHANVIST = '$FISH_AP_FK_TRALHANVIST', FISH_AP_BOO_TRALHACONSERV = '$FISH_AP_BOO_TRALHACONSERV', FISH_AP_TXT_TRALHACONSERV = '$FISH_AP_TXT_TRALHACONSERV', FISH_AP_FK_TRALHAPOSSE = '$FISH_AP_FK_TRALHAPOSSE', FISH_AP_BOO_EVIDPESCANDO = '$FISH_AP_BOO_EVIDPESCANDO', FISH_AP_TXT_EVIDPESCANDO = '$FISH_AP_TXT_EVIDPESCANDO', FISH_AP_BOO_EVIDVENDA = '$FISH_AP_BOO_EVIDVENDA', FISH_AP_TXT_EVIDVENDA = '$FISH_AP_TXT_EVIDVENDA', FISH_AP_BOO_EVIDFALSIDADE = '$FISH_AP_BOO_EVIDFALSIDADE', FISH_AP_TXT_EVIDFALSIDADE = '$FISH_AP_TXT_EVIDFALSIDADE', FISH_AP_TXT_OBSERVACOES = '$FISH_AP_TXT_OBSERVACOES', FISH_AP_TXT_PERCEPCOES = '$FISH_AP_TXT_PERCEPCOES' WHERE FISH_AEP_AE = '$id_camp';";

			$sql = mysql_query($comandosql, $db);			
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_fish_dados_campanha.php?id_camp=$id_camp&id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>