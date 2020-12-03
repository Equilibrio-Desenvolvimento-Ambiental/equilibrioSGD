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
			$MATKIT_NOME = strtoupper($_POST['MATKIT_NOME']);
			$sql = mysql_query("insert into TAB_ADM_MATKITS (MATKIT_NOME) VALUES ('$MATKIT_NOME')", $db) or die(mysql_error());
			$id_gerado = mysql_insert_id();
			$vetor_MATCONSUMOS = $_POST['MATKITC_ITEM'];
			$cont_MATCONSUMOS = 0;
			foreach((array)$vetor_MATCONSUMOS as $vetor_MATCONSUMOSkey){
				$ITEM = $_POST['MATKITC_ITEM'][$cont_MATCONSUMOS];
				$QTDE = $_POST['MATKITC_QTDE'][$cont_MATCONSUMOS];
				if($ITEM=='0'){
					$cont_MATCONSUMOS++;
				} else {
				$sql_MATKITC = mysql_query("insert into TAB_ADM_MATKITS_CON (MATKITC_KIT, MATKITC_ITEM, MATKITC_QTDE) values ('$id_gerado', '$ITEM', '$QTDE')", $db);
				$cont_MATCONSUMOS++;
				}
			}
/*			
			$vetor_MATUSO = $_POST['MATKITU_ITEM'];
			$cont_MATUSO = 0;
			foreach((array)$vetor_MATUSO as $vetor_MATUSOkey){
				$ITEM = $_POST['MATKITU_ITEM'][$cont_MATUSO];
				$QTDE = $_POST['MATKITU_QTDE'][$cont_MATUSO];
				if($ITEM=='0'){
					$cont_MATUSO++;
				} else {
				$sql_MATKITU = mysql_query("insert into TAB_ADM_MATKITS_USO (MATKITU_KIT, MATKITU_ITEM, MATKITU_QTDE) values ('$id_gerado', '$ITEM', '$QTDE');", $db);
				$cont_MATUSO++;
				}
			}
*/			
/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_matkits.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>