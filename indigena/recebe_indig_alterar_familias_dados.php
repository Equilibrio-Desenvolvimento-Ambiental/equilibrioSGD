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
			
			$INDIG_FAMDAD_PESSOA = $_GET['idPessoa'];
			$INDIG_FAMDAD_PES_IDADE = $_POST['INDIG_FAMDAD_PES_IDADE'];
			$INDIG_FAMDAD_PES_DATANASC = reverse_date($_POST['INDIG_FAMDAD_PES_DATANASC']);
			$INDIG_FAMDAD_PES_APELIDO = mb_convert_case($_POST['INDIG_FAMDAD_PES_APELIDO'], MB_CASE_UPPER, 'UTF-8');
			$INDIG_FAMDAD_PROJ_PESCACOMERC = $_POST['INDIG_FAMDAD_PROJ_PESCACOMERC'];

			$sqlCheck = mysql_query("SELECT TAB_INDIG_FAMILIAS_DADOS.INDIG_FAMDAD_ID FROM TAB_INDIG_FAMILIAS_DADOS WHERE TAB_INDIG_FAMILIAS_DADOS.INDIG_FAMDAD_PESSOA = '$idPessoa';", $db) or die(mysql_error());
			$numCheck = mysql_num_rows($sqlCheck);
			
			if($numCheck > 0) {
				$sql = mysql_query("UPDATE TAB_INDIG_FAMILIAS_DADOS SET INDIG_FAMDAD_PES_IDADE = '$INDIG_FAMDAD_PES_IDADE', INDIG_FAMDAD_PES_DATANASC = NULL, INDIG_FAMDAD_PES_APELIDO = '$INDIG_FAMDAD_PES_APELIDO', INDIG_FAMDAD_PROJ_PESCACOMERC = '$INDIG_FAMDAD_PROJ_PESCACOMERC' WHERE INDIG_FAMDAD_PESSOA = '$idPessoa';", $db) or die(mysql_error());
			} else {
				$sql = mysql_query("INSERT INTO TAB_INDIG_FAMILIAS_DADOS (INDIG_FAMDAD_PESSOA, INDIG_FAMDAD_PES_IDADE, INDIG_FAMDAD_PES_DATANASC, INDIG_FAMDAD_PES_APELIDO, INDIG_FAMDAD_PROJ_PESCACOMERC) VALUES ('$INDIG_FAMDAD_PESSOA', '$INDIG_FAMDAD_PES_IDADE', NULL, '$INDIG_FAMDAD_PES_APELIDO', '$INDIG_FAMDAD_PROJ_PESCACOMERC');", $db) or die(mysql_error());
			}
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