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
			$id_evento = $_GET['id_evento'];
			$id_familia = $_GET['id_familia'];

			$CLASS_SUBTIPO = $_POST['subtipoFish'];
			$CLASS_DESCRICAO = mb_convert_case($_POST['CLASS_DESCRICAO'], MB_CASE_UPPER, 'UTF-8');
			if(isset($_POST['subtipoFish']) || isset($_POST['CLASS_DESCRICAO'])) {
				if($CLASS_SUBTIPO == 0){
				} else {
					$sql_class = mysql_query("INSERT INTO TAB_FISH_CLASSIFICACAO (FISH_EVE_CODIGO, FISH_CLASS_TIPO, FISH_CLASS_DESCRICAO) VALUES ('$id_evento', '$CLASS_SUBTIPO', '$CLASS_DESCRICAO');", $db) or die(mysql_error());
				}
			} else { }

			$vet_FISH_TEC_TECNICO = $_POST['FISH_TEC_TECNICO'];
			$cont_TECNICOS = 0;
			foreach((array)$vet_FISH_TEC_TECNICO as $vet_FISH_TEC_TECNICOkey){
				$FISH_TEC_TECNICO = $_POST['FISH_TEC_TECNICO'][$cont_TECNICOS];
				if($FISH_TEC_TECNICO == 0){ } else {
					$sql_tecnicos = mysql_query("INSERT INTO TAB_FISH_TECNICOS (FISH_EVE_CODIGO, FISH_TEC_TECNICO) VALUES ('$id_evento', '$FISH_TEC_TECNICO')", $db) or die(mysql_error());
				}
				$cont_TECNICOS++;
			}

			$diretorio = "imagens/";
			$vet_FISH_IMG_LEGENDA = $_POST['FISH_IMG_LEGENDA'];
			$vet_FISH_IMG_NOME = $_POST['FISH_IMG_NOME'];
			$cont_IMAGENS = 0;
			foreach((array)$vet_FISH_IMG_LEGENDA as $vet_FISH_IMG_LEGENDAkey){
				$FISH_IMG_LEGENDA = mb_convert_case($_POST['FISH_IMG_LEGENDA'][$cont_IMAGENS], MB_CASE_UPPER, 'UTF-8');
				$nome = $_FILES['FISH_IMG_NOME']['name'][$cont_IMAGENS];
				$tmp = $_FILES['FISH_IMG_NOME']['tmp_name'][$cont_IMAGENS];
				$ext = substr($nome, -4, 4);
				$newnome = date("Ymdhis");
				$extensao = explode(".",$nome);
				$fotonome = $extensao[0].$newnome;
				$retiraacentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($fotonome)));
				$nomefoto = $retiraacentos.$ext;
				$upload = $diretorio.$retiraacentos.$ext;		
				move_uploaded_file($tmp, "$diretorio"."$nomefoto");
				$sql_imagens = mysql_query("INSERT INTO TAB_FISH_IMAGENS (FISH_EVE_CODIGO, FISH_IMG_NOME, FISH_IMG_LEGENDA) VALUES ('$id_evento', '$nomefoto', '$FISH_IMG_LEGENDA')", $db);
				$cont_IMAGENS++;
			}
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_fish_dados_eventos.php?id_evento=$id_evento&id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>