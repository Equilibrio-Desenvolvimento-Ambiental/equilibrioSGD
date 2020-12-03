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
			function moeda($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor);
                return $valor;
			}
			$id_familia = $_GET['id_familia'];
			$SALDO_DATAAQUISICAO = reverse_date($_POST['SALDO_DATAAQUISICAO']);
			$SALDO_POSSUISALDO = $_POST['SALDO_POSSUISALDO'];
			$SALDO_VALOR = moeda($_POST['SALDO_VALOR']);
			$SALDO_DTPARC_01 = reverse_date($_POST['SALDO_DTPARC_01']);
			$SALDO_DTPARC_02 = reverse_date($_POST['SALDO_DTPARC_02']);
			$SALDO_DTPARC_03 = reverse_date($_POST['SALDO_DTPARC_03']);
			$SALDO_DATAPLAPLIC = reverse_date($_POST['SALDO_DATAPLAPLIC']);
			$SALDO_STATUS = $_POST['SALDO_STATUS'];
			$sql = mysql_query("update TAB_415421_DADOSSALDO set SALDO_DATAAQUISICAO = '$SALDO_DATAAQUISICAO', SALDO_POSSUISALDO = '$SALDO_POSSUISALDO', SALDO_VALOR = '$SALDO_VALOR', SALDO_DTPARC_01 = '$SALDO_DTPARC_01', SALDO_DTPARC_02 = '$SALDO_DTPARC_02', SALDO_DTPARC_03 = '$SALDO_DTPARC_03', SALDO_DATAPLAPLIC = '$SALDO_DATAPLAPLIC', SALDO_STATUS = '$SALDO_STATUS' where FAMILIA_CODIGO = '$id_familia';", $db) or die(mysql_error());
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