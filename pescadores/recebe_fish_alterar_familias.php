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
			$FISH_FAM_CHEFE_NOME = mb_convert_case($_POST['FISH_FAM_CHEFE_NOME'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FAM_CHEFE_APELIDO = mb_convert_case($_POST['FISH_FAM_CHEFE_APELIDO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FAM_CONJ_NOME = mb_convert_case($_POST['FISH_FAM_CONJ_NOME'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FAM_CONJ_APELIDO = mb_convert_case($_POST['FISH_FAM_CONJ_APELIDO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FAM_ENDURB = $_POST['FISH_FAM_ENDURB'];
			$FISH_FAM_ENDURB_LOGR = mb_convert_case($_POST['FISH_FAM_ENDURB_LOGR'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FAM_ENDURB_BAIRRO = $_POST['FISH_FAM_ENDURB_BAIRRO'];
			$FISH_FAM_ENDURB_MUNIC = $_POST['FISH_FAM_ENDURB_MUNIC'];
			$FISH_FAM_ENDURB_COMPL = mb_convert_case($_POST['FISH_FAM_ENDURB_COMPL'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FAM_ENDURB_USO = $_POST['FISH_FAM_ENDURB_USO'];
			$FISH_FAM_ENDRUR = $_POST['FISH_FAM_ENDRUR'];
			$FISH_FAM_ENDRUR_LOGR = mb_convert_case($_POST['FISH_FAM_ENDRUR_LOGR'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FAM_ENDRUR_LOCAL = $_POST['FISH_FAM_ENDRUR_LOCAL'];
			$FISH_FAM_ENDRUR_MUNIC = $_POST['FISH_FAM_ENDRUR_MUNIC'];
			$FISH_FAM_ENDRUR_COMPL = mb_convert_case($_POST['FISH_FAM_ENDRUR_COMPL'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FAM_ENDRUR_USO = $_POST['FISH_FAM_ENDRUR_USO'];
			$FISH_FAM_ENDRUR_ACESSO = mb_convert_case($_POST['FISH_FAM_ENDRUR_ACESSO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FAM_TELEFONES = mb_convert_case($_POST['FISH_FAM_TELEFONES'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FAM_UTME = $_POST['FISH_FAM_UTME'];
			$FISH_FAM_UTMN = $_POST['FISH_FAM_UTMN'];
			$FISH_FAM_FUSO = $_POST['FISH_FAM_FUSO'];
			$FISH_FAM_LINK_STATUS = $_POST['FISH_FAM_LINK_STATUS'];
			$FISH_FAM_LINK_CODIGO = $_POST['FISH_FAM_LINK_CODIGO'];
			$FISH_FAM_STT_EMER = $_POST['FISH_FAM_STT_EMER'];
			$FISH_FAM_STT_PORT = $_POST['FISH_FAM_STT_PORT'];
			$FISH_FAM_STT_OFIC = $_POST['FISH_FAM_STT_OFIC'];
			$FISH_FAM_STT_COOP = $_POST['FISH_FAM_STT_COOP'];
			
			$comandoSql = "UPDATE TAB_FISH_FAMILIAS SET FISH_FAM_CHEFE_NOME = '$FISH_FAM_CHEFE_NOME', FISH_FAM_CHEFE_APELIDO = '$FISH_FAM_CHEFE_APELIDO', FISH_FAM_CONJ_NOME = '$FISH_FAM_CONJ_NOME', FISH_FAM_CONJ_APELIDO = '$FISH_FAM_CONJ_APELIDO', FISH_FAM_ENDURB = '$FISH_FAM_ENDURB', FISH_FAM_ENDURB_LOGR = '$FISH_FAM_ENDURB_LOGR', FISH_FAM_ENDURB_BAIRRO = '$FISH_FAM_ENDURB_BAIRRO', FISH_FAM_ENDURB_MUNIC = '$FISH_FAM_ENDURB_MUNIC', FISH_FAM_ENDURB_COMPL = '$FISH_FAM_ENDURB_COMPL', FISH_FAM_ENDRUR = '$FISH_FAM_ENDRUR', FISH_FAM_ENDRUR_LOGR = '$FISH_FAM_ENDRUR_LOGR', FISH_FAM_ENDRUR_LOCAL = '$FISH_FAM_ENDRUR_LOCAL', FISH_FAM_ENDRUR_MUNIC = '$FISH_FAM_ENDRUR_MUNIC', FISH_FAM_ENDRUR_COMPL = '$FISH_FAM_ENDRUR_COMPL', FISH_FAM_TELEFONES = '$FISH_FAM_TELEFONES', FISH_FAM_UTME = '$FISH_FAM_UTME', FISH_FAM_UTMN = '$FISH_FAM_UTMN', FISH_FAM_FUSO = '$FISH_FAM_FUSO', FISH_FAM_LINK_STATUS = '$FISH_FAM_LINK_STATUS', FISH_FAM_LINK_CODIGO = '$FISH_FAM_LINK_CODIGO', FISH_FAM_STT_EMER = '$FISH_FAM_STT_EMER', FISH_FAM_STT_PORT = '$FISH_FAM_STT_PORT', FISH_FAM_STT_OFIC = '$FISH_FAM_STT_OFIC', FISH_FAM_STT_COOP = '$FISH_FAM_STT_COOP', FISH_FAM_ENDURB_USO = '$FISH_FAM_ENDURB_USO', FISH_FAM_ENDRUR_USO = '$FISH_FAM_ENDRUR_USO', FISH_FAM_ENDRUR_ACESSO = '$FISH_FAM_ENDRUR_ACESSO', ";
			if(!empty($_POST['FISH_FAM_DTREGISTRO'])){
				$FISH_FAM_DTREGISTRO = reverse_date($_POST['FISH_FAM_DTREGISTRO']);
				$comandoSql = $comandoSql." FISH_FAM_DTREGISTRO = '$FISH_FAM_DTREGISTRO' ";
			} else {
				$comandoSql = $comandoSql." FISH_FAM_DTREGISTRO = NULL ";
			}
			$comandoSql = $comandoSql." WHERE FISH_FAM_ID = '$id_familia';";
//			echo $comandoSql;
			$sql = mysql_query($comandoSql, $db) or die(mysql_error());
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