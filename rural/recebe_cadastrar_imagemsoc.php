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
			$id_familia = $_GET['id_familia'];
			$diretorio = "imagens/";

			$vet_IMAGEMSOC_DATA = $_POST['IMAGEMSOC_DATA'];
			$vet_IMAGEMSOC_LEGENDA = $_POST['IMAGEMSOC_LEGENDA'];
			$vet_IMAGEMSOC_NOME = $_POST['IMAGEMSOC_NOME'];
			$cont_IMAGEMSOC = 0;
			foreach((array)$vet_IMAGEMSOC_DATA as $vet_IMAGEMSOC_DATAkey){
				$IMAGEMSOC_DATA = reverse_date($_POST['IMAGEMSOC_DATA'][$cont_IMAGEMSOC]);
				$IMAGEMSOC_LEGENDA = $_POST['IMAGEMSOC_LEGENDA'][$cont_IMAGEMSOC];
				$nome = $_FILES['IMAGEMSOC_NOME']['name'][$cont_IMAGEMSOC];
				$tmp = $_FILES['IMAGEMSOC_NOME']['tmp_name'][$cont_IMAGEMSOC];
				$ext = substr($nome, -4, 4);
				$newnome = date("Ymdhis");
				$extensao = explode(".",$nome);
				$fotonome = $extensao[0].$newnome;
				$retiraacentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($fotonome)));
				$nomefoto = $retiraacentos.$ext;
				$upload = $diretorio.$retiraacentos.$ext;		
				move_uploaded_file($tmp, "$diretorio"."$nomefoto");
				$sql_imagens = mysql_query("INSERT INTO TAB_415421_IMAGENSSOC (FAMILIA_CODIGO, IMAGEMSOC_NOME, IMAGEMSOC_DATA, IMAGEMSOC_LEGENDA) VALUES ('$id_familia', '$nomefoto', '$IMAGEMSOC_DATA', '$IMAGEMSOC_LEGENDA');", $db);
				$cont_IMAGEMSOC++;
			}
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