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
			$var_FISH_EVE_DATA = $_POST['FISH_EVE_DATA'];
			$var_FISH_EVE_TIPO = $_POST['FISH_EVE_TIPO'];
			$var_FISH_EVE_OBSERVACOES = $_POST['FISH_EVE_OBSERVACOES'];

			$cont_EVENTOS = 0;
			foreach((array)$var_FISH_EVE_DATA as $var_FISH_EVE_DATAkey){
				$FISH_EVE_DATA = reverse_date($_POST['FISH_EVE_DATA'][$cont_EVENTOS]);
				$FISH_EVE_TIPO = $_POST['FISH_EVE_TIPO'][$cont_EVENTOS];
				$FISH_EVE_OBSERVACOES = mb_convert_case($_POST['FISH_EVE_OBSERVACOES'][$cont_EVENTOS], MB_CASE_UPPER, 'UTF-8');
				$sql = mysql_query("INSERT INTO TAB_FISH_EVENTOS (FISH_FAM_ID, FISH_EVE_DATA, FISH_EVE_TIPO, FISH_EVE_OBSERVACOES, FISH_EVE_CHECKED) VALUES ('$id_familia', '$FISH_EVE_DATA', '$FISH_EVE_TIPO', '$FISH_EVE_OBSERVACOES', '2')", $db) or die(mysql_error());
				$cont_EVENTOS++;
			}
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