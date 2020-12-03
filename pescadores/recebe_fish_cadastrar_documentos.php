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
			$var_FISH_DOC_DATA = $_POST['FISH_DOC_DATA'];
			$var_FISH_DOC_DESCRICAO = $_POST['FISH_DOC_DESCRICAO'];
			$var_FISH_DOC_TIPO = $_POST['FISH_DOC_TIPO'];

			$diretorio = "docs/";

			$cont_DOC = 0;
			foreach((array)$var_FISH_DOC_DATA as $var_FISH_DOC_DATAkey){
				$FISH_DOC_DATA = reverse_date($_POST['FISH_DOC_DATA'][$cont_DOC]);
				$FISH_DOC_DESCRICAO = mb_convert_case($_POST['FISH_DOC_DESCRICAO'][$cont_DOC], MB_CASE_UPPER, 'UTF-8');
				$FISH_DOC_TIPO = $_POST['FISH_DOC_TIPO'][$cont_DOC];
				$nome_original = $_FILES['FISH_DOC_ARQUIVO']['name'][$cont_DOC];
				$nome_temp = $_FILES['FISH_DOC_ARQUIVO']['tmp_name'][$cont_DOC];
				$nome_extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
				$nome_no_acentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim(pathinfo($nome_original, PATHINFO_FILENAME))));
				$nome_final = $nome_no_acentos.' - '.date("Ymdhis").'.'.$nome_extensao;
				move_uploaded_file($nome_temp, "$diretorio"."$nome_final");
				$FISH_DOC_ARQUIVO = $nome_final;
				$sql = mysql_query("INSERT INTO TAB_FISH_DOCUMENTOS (FISH_FAM_ID, FISH_DOC_DATA, FISH_DOC_TIPO, FISH_DOC_DESCRICAO, FISH_DOC_ARQUIVO) values ('$id_familia', '$FISH_DOC_DATA', '$FISH_DOC_TIPO', '$FISH_DOC_DESCRICAO', '$FISH_DOC_ARQUIVO')", $db) or die(mysql_error());
				$cont_DOC++;
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