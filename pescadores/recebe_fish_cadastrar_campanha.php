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
			if(!empty($_POST['FISH_CAMPANHA_DATA'])){
				$FISH_CAMPANHA_DATA = reverse_date($_POST['FISH_CAMPANHA_DATA']);
			} else {
				$FISH_CAMPANHA_DATA = date('Y-m-d');
			}
			$FISH_CAMPANHA_CAMPANHA = $_POST['FISH_CAMPANHA_CAMPANHA'];
			$FISH_CAMPANHA_TECNICO = $_POST['FISH_CAMPANHA_TECNICO'];
			if(!empty($_POST['FISH_CAMPANHA_FICHAS'])){
				$FISH_CAMPANHA_FICHAS = $_POST['FISH_CAMPANHA_FICHAS'];
			} else {
				$FISH_CAMPANHA_FICHAS = 0;
			}
			
			$sql = mysql_query("INSERT INTO TAB_FISH_ACOMP_ENTREVISTA (FISH_FAM_ID, FISH_AE_CAMPANHA, FISH_AE_TECNICO, FISH_AE_DT_ENTR_ATUAL) VALUES ('$id_familia', '$FISH_CAMPANHA_CAMPANHA', '$FISH_CAMPANHA_TECNICO', '$FISH_CAMPANHA_DATA');", $db) or die(mysql_error());

			$id_Entrevista = mysql_insert_id();			
			$sql_Entrevista = mysql_query("INSERT INTO TAB_FISH_ACOMP_PERCEPCAO (FISH_AEP_AE) VALUES ('$id_Entrevista');", $db) or die(mysql_error());
			for( $cont=1; $cont<=$FISH_CAMPANHA_FICHAS; $cont++){
				$sql_Ficha = mysql_query("INSERT INTO TAB_FISH_ACOMP_FICHA (FISH_AEF_AE) VALUES ('$id_Entrevista');", $db) or die(mysql_error());
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