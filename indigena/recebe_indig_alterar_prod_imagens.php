<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 8;
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
			$idImagem = $_GET['idImagem'];
			$idEntrega = $_GET['idEntrega'];
			$idAldeia = $_GET['idAldeia'];

			$diretorio = "imagens/";
			$vet_INDIG_MOVIMG_LEGENDA = $_POST['INDIG_MOVIMG_LEGENDA'];
			$vet_INDIG_MOVIMG_NOME = $_POST['INDIG_MOVIMG_NOME'];
			$cont_IMAGENS = 0;
			foreach((array)$vet_INDIG_MOVIMG_LEGENDA as $vet_INDIG_MOVIMG_LEGENDAkey){
				$INDIG_MOVIMG_LEGENDA = mb_convert_case($_POST['INDIG_MOVIMG_LEGENDA'][$cont_IMAGENS], MB_CASE_UPPER, 'UTF-8');
				$nome = $_FILES['INDIG_MOVIMG_NOME']['name'][$cont_IMAGENS];
				$tmp = $_FILES['INDIG_MOVIMG_NOME']['tmp_name'][$cont_IMAGENS];
				$ext = substr($nome, -4, 4);
				$newnome = date("Ymdhis");
				$extensao = explode(".",$nome);
				$fotonome = $extensao[0].$newnome;
				$retiraacentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($fotonome)));
				$nomefoto = $retiraacentos.$ext;
				$upload = $diretorio.$retiraacentos.$ext;		
				move_uploaded_file($tmp, "$diretorio"."$nomefoto");
				$sql_imagens = mysql_query("INSERT INTO TAB_INDIG_PROD_IMAGENS (INDIG_MOVIMG_ENTREGA, INDIG_MOVIMG_NOME, INDIG_MOVIMG_LEGENDA) VALUES ('$idEntrega', '$nomefoto', '$INDIG_MOVIMG_LEGENDA')", $db);
				$cont_IMAGENS++;
			}
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_indig_dados_prod_entregas.php?idEntrega=$idEntrega&idAldeia=$idAldeia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>