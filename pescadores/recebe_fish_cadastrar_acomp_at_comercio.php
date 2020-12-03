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
				$id_familia = $_GET['id_familia'];
				$vet_FISH_AAC_TIPO = $_POST['FISH_AAC_TIPO'];
				$cont_FISH_AAC_TIPO = 0;
				foreach((array)$vet_FISH_AAC_TIPO as $vet_FISH_AAC_TIPOkey){
					$ID = $_POST['FISH_AAC_TIPO'][$cont_FISH_AAC_TIPO];
					if($ID == 0){ } else {
						$sql_AcompAtComercio = mysql_query("INSERT INTO TAB_FISH_ACOMP_AT_COMERCIO (FISH_AAC_FAM, FISH_AAC_TIPO) VALUES ('$id_familia', '$ID');", $db) or die(mysql_error());
					}
					$cont_FISH_AAC_TIPO++;
				}
		/*
				echo"<script language=\"JavaScript\">
					alert('Excluido com sucesso!');
					</script>";
		*/		
				echo"<script language=\"JavaScript\">
					location.href=\"alterar_fish_familias.php?id_familia=$id_familia\";
					</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>