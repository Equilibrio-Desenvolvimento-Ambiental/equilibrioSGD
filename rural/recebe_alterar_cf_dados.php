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
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			$id_compfam = $_GET['id_compfam'];
			$id_familia = $_GET['id_familia'];
			$CFDADOS_IDADE = $_POST['CFDADOS_IDADE'];
			$CFDADOS_DATANASC = reverse_date($_POST['CFDADOS_DATANASC']);
			$CFDADOS_NATURALIDADE = $_POST['CFDADOS_NATURALIDADE'];
			$CFDADOS_NATURALIDADE_UF = $_POST['CFDADOS_NATURALIDADE_UF'];
			$CFDADOS_NACIONALIDADE = $_POST['CFDADOS_NACIONALIDADE'];
			$CFDADOS_NOMEPAI = $_POST['CFDADOS_NOMEPAI'];
			$CFDADOS_NOMEMAE = $_POST['CFDADOS_NOMEMAE'];
			$CFDADOS_APELIDO = $_POST['CFDADOS_APELIDO'];
			$sql = mysql_query("update TAB_415421_CF_DADOS set CFDADOS_IDADE = '$CFDADOS_IDADE', CFDADOS_DATANASC = '$CFDADOS_DATANASC', CFDADOS_NATURALIDADE = '$CFDADOS_NATURALIDADE', CFDADOS_NATURALIDADE_UF = '$CFDADOS_NATURALIDADE_UF', CFDADOS_NACIONALIDADE = '$CFDADOS_NACIONALIDADE', CFDADOS_NOMEPAI = '$CFDADOS_NOMEPAI', CFDADOS_NOMEMAE = '$CFDADOS_NOMEMAE', CFDADOS_APELIDO = '$CFDADOS_APELIDO' where COMPFAM_CODIGO = '$id_compfam';", $db);			
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_dados_compfam.php?id_compfam=$id_compfam&id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>