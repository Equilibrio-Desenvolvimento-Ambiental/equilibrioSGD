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
			function moeda($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor);
                return $valor;
			}
			$id_familia = $_GET['id_familia'];
			
			$FISH_AA_BOO_PESCAVA = $_POST['FISH_AA_BOO_PESCAVA'];
			$FISH_AA_QT_PESCA_QTMES = $_POST['FISH_AA_QT_PESCA_QTMES'];
			$FISH_AA_QT_PESCA_QTINT = $_POST['FISH_AA_QT_PESCA_QTINT'];
			$FISH_AA_QT_PESCA_QTDIAS = $_POST['FISH_AA_QT_PESCA_QTDIAS'];
			$FISH_AA_QT_PESCA_QTPESSOAS = $_POST['FISH_AA_QT_PESCA_QTPESSOAS'];
			$FISH_AA_QT_PESCA_PRODTEMP = moeda($_POST['FISH_AA_QT_PESCA_PRODTEMP']);
			$FISH_AA_QT_PESCA_PRODFTEMP = moeda($_POST['FISH_AA_QT_PESCA_PRODFTEMP']);
			$FISH_AA_BOO_PESCA_VENDIA = $_POST['FISH_AA_BOO_PESCA_VENDIA'];
			$FISH_AA_QT_PESCA_PRODVENDA = moeda($_POST['FISH_AA_QT_PESCA_PRODVENDA']);
			$FISH_AA_QT_PESCA_PRODCOSUMO = moeda($_POST['FISH_AA_QT_PESCA_PRODCOSUMO']);
			$FISH_AA_VL_PESCA_PRODMEDIA = moeda($_POST['FISH_AA_VL_PESCA_PRODMEDIA']);
			
			$comandoSql = "UPDATE TAB_FISH_ACOMP_ANTESTRANS SET FISH_AA_BOO_PESCAVA = '$FISH_AA_BOO_PESCAVA', FISH_AA_QT_PESCA_QTMES = '$FISH_AA_QT_PESCA_QTMES', FISH_AA_QT_PESCA_QTINT = '$FISH_AA_QT_PESCA_QTINT', FISH_AA_QT_PESCA_QTDIAS = '$FISH_AA_QT_PESCA_QTDIAS', FISH_AA_QT_PESCA_QTPESSOAS = '$FISH_AA_QT_PESCA_QTPESSOAS', FISH_AA_QT_PESCA_PRODTEMP = '$FISH_AA_QT_PESCA_PRODTEMP', FISH_AA_QT_PESCA_PRODFTEMP = '$FISH_AA_QT_PESCA_PRODFTEMP', FISH_AA_BOO_PESCA_VENDIA = '$FISH_AA_BOO_PESCA_VENDIA', FISH_AA_QT_PESCA_PRODVENDA = '$FISH_AA_QT_PESCA_PRODVENDA', FISH_AA_QT_PESCA_PRODCOSUMO = '$FISH_AA_QT_PESCA_PRODCOSUMO', FISH_AA_VL_PESCA_PRODMEDIA = '$FISH_AA_VL_PESCA_PRODMEDIA' WHERE FISH_FAM_ID = '$id_familia';";

			$sql = mysql_query($comandoSql, $db) or die(mysql_error());			
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