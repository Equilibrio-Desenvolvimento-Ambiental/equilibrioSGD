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
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			$id_familia = $_GET['id_familia'];
			$FISH_DADOS_EMERG = $_POST['FISH_DADOS_EMERG'];
			$FISH_DADOS_VULNERAVEL = $_POST['FISH_DADOS_VULNERAVEL'];
			$FISH_DADOS_BARCO_NOVO = $_POST['FISH_DADOS_BARCO_NOVO'];
			$FISH_DADOS_BARCO_REPARO = $_POST['FISH_DADOS_BARCO_REPARO'];
			$FISH_DADOS_SINTESE = mb_convert_case($_POST['FISH_DADOS_SINTESE'], MB_CASE_UPPER, 'UTF-8');
			$FISH_DADOS_EMBARCACAO = mb_convert_case($_POST['FISH_DADOS_EMBARCACAO'], MB_CASE_UPPER, 'UTF-8');

			$sql = mysql_query("UPDATE TAB_FISH_DADOS SET FISH_DADOS_EMERG = '$FISH_DADOS_EMERG', FISH_DADOS_VULNERAVEL = '$FISH_DADOS_VULNERAVEL', FISH_DADOS_BARCO_NOVO = '$FISH_DADOS_BARCO_NOVO', FISH_DADOS_BARCO_REPARO = '$FISH_DADOS_BARCO_REPARO', FISH_DADOS_SINTESE = '$FISH_DADOS_SINTESE', FISH_DADOS_EMBARCACAO = '$FISH_DADOS_EMBARCACAO' WHERE FISH_FAM_ID = '$id_familia';", $db);			
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_fish_familias.php?id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>