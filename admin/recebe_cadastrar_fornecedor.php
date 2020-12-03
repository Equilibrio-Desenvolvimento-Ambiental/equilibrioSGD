<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 6;
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
			$FORNEC_NOME = strtoupper($_POST['FORNEC_NOME']);
			$FORNEC_NOMEFANT = strtoupper($_POST['FORNEC_NOMEFANT']);
			$FORNEC_CPFCNPJ = ($_POST['FORNEC_CPFCNPJ']);
			$FORNEC_NOMERESP = strtoupper($_POST['FORNEC_NOMERESP']);
			$FORNEC_INSCEST = ($_POST['FORNEC_INSCEST']);
			$FORNEC_INSCMUN = ($_POST['FORNEC_INSCMUN']);
			$FORNEC_ENDERECO = strtoupper($_POST['FORNEC_ENDERECO']);
			$FORNEC_NUMERO = ($_POST['FORNEC_NUMERO']);
			$FORNEC_COMPL = strtoupper($_POST['FORNEC_COMPL']);
			$FORNEC_BAIRRO = strtoupper($_POST['FORNEC_BAIRRO']);
			$FORNEC_MUNICIPIO = ($_POST['FORNEC_MUNICIPIO']);
			$FORNEC_CEP = ($_POST['FORNEC_CEP']);
			$FORNEC_FONE01 = ($_POST['FORNEC_FONE01']);
			$FORNEC_FONE02 = ($_POST['FORNEC_FONE02']);
			$FORNEC_EMAIL = strtolower($_POST['FORNEC_EMAIL']);
			$FORNEC_ANOTACOES = strtoupper($_POST['FORNEC_ANOTACOES']);
			$sql = mysql_query("INSERT INTO TAB_ADM_FORNECEDOR (FORNEC_NOME, FORNEC_NOMEFANT, FORNEC_CPFCNPJ, FORNEC_NOMERESP, FORNEC_INSCEST, FORNEC_INSCMUN, FORNEC_ENDERECO, FORNEC_NUMERO, FORNEC_COMPL, FORNEC_BAIRRO, FORNEC_MUNICIPIO, FORNEC_CEP, FORNEC_FONE01, FORNEC_FONE02, FORNEC_EMAIL, FORNEC_ANOTACOES) VALUES ('$FORNEC_NOME', '$FORNEC_NOMEFANT', '$FORNEC_CPFCNPJ', '$FORNEC_NOMERESP', '$FORNEC_INSCEST', '$FORNEC_INSCMUN', '$FORNEC_ENDERECO', '$FORNEC_NUMERO', '$FORNEC_COMPL', '$FORNEC_BAIRRO', '$FORNEC_MUNICIPIO', '$FORNEC_CEP', '$FORNEC_FONE01', '$FORNEC_FONE02', '$FORNEC_EMAIL', '$FORNEC_ANOTACOES');", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_fornecedor.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>