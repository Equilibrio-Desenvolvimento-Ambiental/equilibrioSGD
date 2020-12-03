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
			$var_DOC_DATA = $_POST['DOC_DATA'];
			$var_DOC_DESCRICAO = $_POST['DOC_DESCRICAO'];

			$diretorio = "imagens/";

			$cont_DOC = 0;
			foreach((array)$var_DOC_DATA as $var_DOC_DATAkey){
				$DOC_DATA = reverse_date($_POST['DOC_DATA'][$cont_DOC]);
				$DOC_DESCRICAO = $_POST['DOC_DESCRICAO'][$cont_DOC];
				$nome_original = $_FILES['DOC_ARQUIVO']['name'][$cont_DOC];
				$nome_temp = $_FILES['DOC_ARQUIVO']['tmp_name'][$cont_DOC];
				$nome_extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
				$nome_no_acentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim(pathinfo($nome_original, PATHINFO_FILENAME))));
				$nome_final = $nome_no_acentos.' - '.date("Ymdhis").'.'.$nome_extensao;
				move_uploaded_file($nome_temp, "$diretorio"."$nome_final");
				$DOC_ARQUIVO = $nome_final;
				$sql = mysql_query("insert into TAB_415421_DOCUMENTOS (FAMILIA_CODIGO, DOC_DATA, DOC_DESCRICAO, DOC_ARQUIVO) values ('$id_familia', '$DOC_DATA', '$DOC_DESCRICAO', '$DOC_ARQUIVO')", $db);
				$cont_DOC++;
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