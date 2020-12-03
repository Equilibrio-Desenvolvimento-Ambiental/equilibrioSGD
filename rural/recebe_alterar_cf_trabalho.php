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
			function moeda($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor);
                return $valor;
			}
			$id_compfam = $_GET['id_compfam'];
			$id_familia = $_GET['id_familia'];
			$CFTRAB_OCUPACAO = $_POST['CFTRAB_OCUPACAO'];
			$CFTRAB_RENDA = moeda($_POST['CFTRAB_RENDA']);
			$sql = mysql_query("update TAB_415421_CF_TRABALHO set CFTRAB_OCUPACAO = '$CFTRAB_OCUPACAO', CFTRAB_RENDA = '$CFTRAB_RENDA' where COMPFAM_CODIGO = '$id_compfam';", $db);			
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