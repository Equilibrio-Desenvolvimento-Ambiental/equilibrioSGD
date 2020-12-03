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
			$id_familia = $_GET['id_familia'];
			$var_COMPFAM_NOME = $_POST['COMPFAM_NOME'];
			$var_COMPFAM_PARENTESCO = $_POST['COMPFAM_PARENTESCO'];
			$var_COMPFAM_RESIDENTE = $_POST['COMPFAM_RESIDENTE'];

			$cont_COMPFAM = 0;
			foreach((array)$var_COMPFAM_NOME as $var_COMPFAM_NOMEkey){
				$COMPFAM_NOME = $_POST['COMPFAM_NOME'][$cont_COMPFAM];
				$COMPFAM_PARENTESCO = $_POST['COMPFAM_PARENTESCO'][$cont_COMPFAM];
				$COMPFAM_RESIDENTE = $_POST['COMPFAM_RESIDENTE'][$cont_COMPFAM];
				$sql = mysql_query("insert into TAB_415421_COMPFAMILIAR (FAMILIA_CODIGO, COMPFAM_NOME, COMPFAM_PARENTESCO, COMPFAM_RESIDENTE) values ('$id_familia', '$COMPFAM_NOME', '$COMPFAM_PARENTESCO', '$COMPFAM_RESIDENTE')", $db);
				$cont_COMPFAM++;
				$id_compfam = mysql_insert_id();
				$sql_DADOS = mysql_query("insert into TAB_415421_CF_DADOS (COMPFAM_CODIGO, CFDADOS_IDADE, CFDADOS_DATANASC, CFDADOS_NATURALIDADE, CFDADOS_NATURALIDADE_UF, CFDADOS_NACIONALIDADE, CFDADOS_NOMEPAI, CFDADOS_NOMEMAE) values ('$id_compfam','0',null,null,null,null,null,null);", $db);
				$sql_DOC = mysql_query("insert into TAB_415421_CF_DOC (COMPFAM_CODIGO, CFDOC_CPF, CFDOC_RG, CFDOC_RG_COMPL, CFDOC_RG_ORGAO, CFDOC_RG_UF) values ('$id_compfam',null,null,null,null,2);", $db);
				$sql_TRABALHO = mysql_query("insert into TAB_415421_CF_TRABALHO (COMPFAM_CODIGO, CFTRAB_OCUPACAO, CFTRAB_RENDA) values ('$id_compfam',0,0)", $db);
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