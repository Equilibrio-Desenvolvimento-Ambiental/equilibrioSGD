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
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      ); }
			$PLAN_VISIT_FAMILIA = $_POST['PLAN_VISIT_FAMILIA'];
			$PLAN_VISIT_TECNICO = $_POST['PLAN_VISIT_TECNICO'];
			$PLAN_VISIT_RGME = $_POST['PLAN_VISIT_RGME'];
			$PLAN_VISIT_PREVISAO = reverse_date($_POST['PLAN_VISIT_PREVISAO']);
			$sql = mysql_query("INSERT INTO TAB_415421_PLANVISITAS (PLAN_VISIT_FAMILIA, PLAN_VISIT_TECNICO, PLAN_VISIT_GRUPO, PLAN_VISIT_RGME, PLAN_VISIT_PREVISAO, PLAN_VISIT_CONCLUIDA) values ('$PLAN_VISIT_FAMILIA', '$PLAN_VISIT_TECNICO', '5', '$PLAN_VISIT_RGME', '$PLAN_VISIT_PREVISAO', '2');",$db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"planejamento_listar_familias.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>