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
				$id_camp = $_GET['id_camp'];
				$id_familia = $_GET['id_familia'];
			
				$vet_FISH_ACOMP_ENTR_EQUIPNUSO = $_POST['FISH_ACOMP_ENTR_EQUIPBENEF'];
				$cont_EQUIPNUSO = 0;
				foreach((array)$vet_FISH_ACOMP_ENTR_EQUIPNUSO as $vet_FISH_ACOMP_ENTR_EQUIPNUSOkey){
					$FISH_ACOMP_ENTR_EQUIPNUSO = $_POST['FISH_ACOMP_ENTR_EQUIPBENEF'][$cont_EQUIPNUSO];
					if($FISH_ACOMP_ENTR_EQUIPNUSO == 0){ } else {
						$sql_AcompEntrBenef = mysql_query("INSERT INTO TAB_FISH_ACOMP_ENTR_EQUIPNUSO (FISH_AEE_AE, FISH_AEE_TIPO) VALUES ('$id_camp', '$FISH_ACOMP_ENTR_EQUIPNUSO')", $db) or die(mysql_error());
					}
					$cont_EQUIPNUSO++;
				}
			
		/*
				echo"<script language=\"JavaScript\">
					alert('Excluido com sucesso!');
					</script>";
		*/		
				echo"<script language=\"JavaScript\">
					location.href=\"cadastrar_fish_dados_campanha.php?id_camp=$id_camp&id_familia=$id_familia\";
					</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>