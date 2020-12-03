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
			$id_familia = $_GET['id_familia'];
			$FAMILIA_NUMERO = $_POST['FAMILIA_NUMERO'];
			$FAMILIA_FUNDIARIO = $_POST['FAMILIA_FUNDIARIO'];
			$FAMILIA_BENEFICIO = $_POST['FAMILIA_BENEFICIO'];
			$FAMILIA_BENEFICIARIO = $_POST['FAMILIA_BENEFICIARIO'];
			$FAMILIA_LOCALORIGEM = $_POST['FAMILIA_LOCALORIGEM'];
			$FAMILIA_MUNICIPIODESTINO = $_POST['FAMILIA_MUNICIPIODESTINO'];
			$FAMILIA_SETORATEND = $_POST['FAMILIA_SETORATEND'];
			$FAMILIA_LOCALDESTINO = $_POST['FAMILIA_LOCALDESTINO'];
			$FAMILIA_TELEFONES = $_POST['FAMILIA_TELEFONES'];
			$FAMILIA_UTME = $_POST['FAMILIA_UTME'];
			$FAMILIA_UTMN = $_POST['FAMILIA_UTMN'];
			$FAMILIA_FUSOGEO = $_POST['FAMILIA_FUSOGEO'];
			$FAMILIA_RESIDENTE = $_POST['FAMILIA_RESIDENTE'];
			$FAMILIA_TECNICO = $_POST['FAMILIA_TECNICO'];
			$FAMILIA_GRUPO = $_POST['FAMILIA_GRUPO'];
			$sql = mysql_query("update TAB_415421_FAMILIAS set FAMILIA_NUMERO = '$FAMILIA_NUMERO', FAMILIA_FUNDIARIO = '$FAMILIA_FUNDIARIO', FAMILIA_BENEFICIO = '$FAMILIA_BENEFICIO', FAMILIA_BENEFICIARIO = '$FAMILIA_BENEFICIARIO', FAMILIA_LOCALORIGEM = '$FAMILIA_LOCALORIGEM', FAMILIA_MUNICIPIODESTINO = '$FAMILIA_MUNICIPIODESTINO', FAMILIA_SETORATEND = '$FAMILIA_SETORATEND', FAMILIA_LOCALDESTINO = '$FAMILIA_LOCALDESTINO', FAMILIA_TELEFONES = '$FAMILIA_TELEFONES', FAMILIA_UTME = '$FAMILIA_UTME', FAMILIA_UTMN = '$FAMILIA_UTMN', FAMILIA_FUSOGEO = '$FAMILIA_FUSOGEO', FAMILIA_RESIDENTE = '$FAMILIA_RESIDENTE', FAMILIA_TECNICO = '$FAMILIA_TECNICO', FAMILIA_GRUPO = '$FAMILIA_GRUPO' where FAMILIA_CODIGO = '$id_familia';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_familias.php?id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>