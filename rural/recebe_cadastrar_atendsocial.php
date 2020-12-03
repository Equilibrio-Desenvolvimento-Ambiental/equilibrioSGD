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
			$var_SOCIAL_DATA = $_POST['SOCIAL_DATA'];
			$var_SOCIAL_DESCRICAO = $_POST['SOCIAL_DESCRICAO'];
			$var_SOCIAL_ENCAMINHAMENTO = $_POST['SOCIAL_ENCAMINHAMENTO'];
			$var_SOCIAL_RETORNO = $_POST['SOCIAL_RETORNO'];
			$var_SOCIAL_CONCLUIDA = $_POST['SOCIAL_CONCLUIDA'];

			$cont_SOCIAL = 0;
			foreach((array)$var_SOCIAL_DATA as $var_SOCIAL_DATAkey){
				$SOCIAL_DATA = reverse_date($_POST['SOCIAL_DATA'][$cont_SOCIAL]);
				$SOCIAL_DESCRICAO = $_POST['SOCIAL_DESCRICAO'][$cont_SOCIAL];
				$SOCIAL_ENCAMINHAMENTO = $_POST['SOCIAL_ENCAMINHAMENTO'][$cont_SOCIAL];
				$SOCIAL_RETORNO = $_POST['SOCIAL_RETORNO'][$cont_SOCIAL];
				$SOCIAL_CONCLUIDA = $_POST['SOCIAL_CONCLUIDA'][$cont_SOCIAL];
				$sql = mysql_query("INSERT INTO TAB_415421_SOCIAIS (FAMILIA_CODIGO, SOCIAL_DATA, SOCIAL_DESCRICAO, SOCIAL_ENCAMINHAMENTO, SOCIAL_RETORNO, SOCIAL_CONCLUIDA) VALUES ('$id_familia', '$SOCIAL_DATA', '$SOCIAL_DESCRICAO', '$SOCIAL_ENCAMINHAMENTO', '$SOCIAL_RETORNO', '$SOCIAL_CONCLUIDA');", $db);
				$cont_SOCIAL++;
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