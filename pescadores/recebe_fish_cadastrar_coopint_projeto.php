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
			$id = $_GET['id'];
			$id_familia = $_GET['id_familia'];
			
			$vet_PROJETOS = $_POST['FISH_FIPROJ_PROJETO'];
			$cont_PROJETOS = 0;
			foreach((array)$vet_PROJETOS as $vet_PROJETOSkey){
				$FISH_FIPROJ_PROJETO = $_POST['FISH_FIPROJ_PROJETO'][$cont_PROJETOS];
				$FISH_FIPROJ_ORDEM = $_POST['FISH_FIPROJ_ORDEM'][$cont_PROJETOS];
				if(!$FISH_FIPROJ_PROJETO == 0){
					$sql_consulta_PROJETO = mysql_query("SELECT FISH_FIPROJ_ID FROM TAB_FISH_COOPINT_PROJETO WHERE FISH_FCOMP_ID = '$id' AND FISH_FIPROJ_PROJETO = '$FISH_FIPROJ_PROJETO';", $db) or die(mysql_error());
					$num_PROJETO = mysql_num_rows($sql_consulta_PROJETO);
					if($num_PROJETO == 0) {
						$sql_insert_PROJETO = mysql_query("INSERT INTO TAB_FISH_COOPINT_PROJETO (FISH_FCOMP_ID, FISH_FIPROJ_PROJETO, FISH_FIPROJ_ORDEM) VALUES ('$id', '$FISH_FIPROJ_PROJETO', '$FISH_FIPROJ_ORDEM')", $db) or die(mysql_error());
					}
				}
				$cont_PROJETOS++;
			}

		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_fish_familias_componente.php?id=$id&id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>