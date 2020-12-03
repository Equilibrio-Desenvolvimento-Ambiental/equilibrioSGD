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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db) or die(mysql_error());
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
			$id = $_GET['id'];
			$id_familia = $_GET['id_familia'];
			$FISH_FCOMP_NOME = mb_convert_case($_POST['FISH_FCOMP_NOME'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FCOMP_APELIDO = mb_convert_case($_POST['FISH_FCOMP_APELIDO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FCOMP_GENERO = $_POST['FISH_FCOMP_GENERO'];
			$FISH_FCOMP_PARENTESCO = $_POST['FISH_FCOMP_PARENTESCO'];
			$FISH_FCOMP_IDADE = $_POST['FISH_FCOMP_IDADE'];
			$FISH_FCOMP_OCUPACAO = $_POST['FISH_FCOMP_OCUPACAO'];
			$FISH_FCOMP_ALFAB_LER = $_POST['FISH_FCOMP_ALFAB_LER'];
			$FISH_FCOMP_ALFAB_ESCREVER = $_POST['FISH_FCOMP_ALFAB_ESCREVER'];
			$FISH_FCOMP_RGP_POSSUI = $_POST['FISH_FCOMP_RGP_POSSUI'];
			$FISH_FCOMP_RGP_NUMERO = mb_convert_case($_POST['FISH_FCOMP_RGP_NUMERO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FCOMP_RG_POSSUI = $_POST['FISH_FCOMP_RG_POSSUI'];
			$FISH_FCOMP_RG_NUMERO = mb_convert_case($_POST['FISH_FCOMP_RG_NUMERO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FCOMP_CPF_POSSUI = $_POST['FISH_FCOMP_CPF_POSSUI'];
			$FISH_FCOMP_CPF_NUMERO = mb_convert_case($_POST['FISH_FCOMP_CPF_NUMERO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FCOMP_RESIDENTE = $_POST['FISH_FCOMP_RESIDENTE'];

			$FISH_FCOMP_ESTADOCIVIL = $_POST['FISH_FCOMP_ESTADOCIVIL'];
			$FISH_FCOMP_NACIONALIDADE = $_POST['FISH_FCOMP_NACIONALIDADE'];
			$FISH_FCOMP_NATURALIDADE = $_POST['FISH_FCOMP_NATURALIDADE'];
			$FISH_FCOMP_RG_ORGAO = mb_convert_case($_POST['FISH_FCOMP_RG_ORGAO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_FCOMP_RG_UF = $_POST['FISH_FCOMP_RG_UF'];
			$FISH_FCOMP_ATES_FICHAPROPOSTA = $_POST['FISH_FCOMP_ATES_FICHAPROPOSTA'];
			$FISH_FCOMP_ATES_DELEGADO = $_POST['FISH_FCOMP_ATES_DELEGADO'];
			$FISH_FCOMP_ATES_NUMEROCOOPP = $_POST['FISH_FCOMP_ATES_NUMEROCOOPP'];
			
			if($_FILES['FISH_FCOMP_FOTOPESSOAL']['tmp_name']!=''){
				$diretorio = "fotospessoais/";
				$nome = $_FILES['FISH_FCOMP_FOTOPESSOAL']['name'];
				$tmp = $_FILES['FISH_FCOMP_FOTOPESSOAL']['tmp_name'];
				$ext = substr($nome, -4, 4);
				$newnome = date("Ymdhis");
				$extensao = explode(".",$nome);
				$fotonome = $extensao[0].$newnome;
				$retiraacentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($fotonome)));
				$nomefoto = $retiraacentos.$ext;
				$upload = $diretorio.$retiraacentos.$ext;		
				move_uploaded_file($tmp, "$diretorio"."$nomefoto");
				$FISH_FCOMP_FOTOPESSOAL = $nomefoto;
			}
			
			$comandoSql = "UPDATE TAB_FISH_FAMILIAS_COMPOSICAO SET FISH_FCOMP_NOME = '$FISH_FCOMP_NOME', FISH_FCOMP_APELIDO = '$FISH_FCOMP_APELIDO', FISH_FCOMP_GENERO = '$FISH_FCOMP_GENERO', FISH_FCOMP_PARENTESCO = '$FISH_FCOMP_PARENTESCO', FISH_FCOMP_IDADE = '$FISH_FCOMP_IDADE', FISH_FCOMP_OCUPACAO = '$FISH_FCOMP_OCUPACAO', FISH_FCOMP_ALFAB_LER = '$FISH_FCOMP_ALFAB_LER', FISH_FCOMP_ALFAB_ESCREVER = '$FISH_FCOMP_ALFAB_ESCREVER', FISH_FCOMP_RGP_POSSUI = '$FISH_FCOMP_RGP_POSSUI', FISH_FCOMP_RGP_NUMERO = '$FISH_FCOMP_RGP_NUMERO', FISH_FCOMP_RG_POSSUI = '$FISH_FCOMP_RG_POSSUI', FISH_FCOMP_RG_NUMERO = '$FISH_FCOMP_RG_NUMERO', FISH_FCOMP_CPF_POSSUI = '$FISH_FCOMP_CPF_POSSUI', FISH_FCOMP_CPF_NUMERO = '$FISH_FCOMP_CPF_NUMERO', FISH_FCOMP_RESIDENTE = '$FISH_FCOMP_RESIDENTE', FISH_FCOMP_ESTADOCIVIL = '$FISH_FCOMP_ESTADOCIVIL', FISH_FCOMP_NACIONALIDADE = '$FISH_FCOMP_NACIONALIDADE', FISH_FCOMP_NATURALIDADE = '$FISH_FCOMP_NATURALIDADE', FISH_FCOMP_RG_ORGAO = '$FISH_FCOMP_RG_ORGAO', FISH_FCOMP_RG_UF = '$FISH_FCOMP_RG_UF', FISH_FCOMP_ATES_FICHAPROPOSTA = '$FISH_FCOMP_ATES_FICHAPROPOSTA', FISH_FCOMP_ATES_DELEGADO = '$FISH_FCOMP_ATES_DELEGADO', FISH_FCOMP_ATES_NUMEROCOOPP = '$FISH_FCOMP_ATES_NUMEROCOOPP', ";
			
			if($_FILES['FISH_FCOMP_FOTOPESSOAL']['tmp_name']!=''){
				$comandoSql = $comandoSql." FISH_FCOMP_FOTOPESSOAL = '$FISH_FCOMP_FOTOPESSOAL', ";
			}
			
			if(!empty($_POST['FISH_FCOMP_DTNASC'])){
				$FISH_FCOMP_DTNASC = reverse_date($_POST['FISH_FCOMP_DTNASC']);
				$comandoSql = $comandoSql." FISH_FCOMP_DTNASC = '$FISH_FCOMP_DTNASC', ";
			} else {
				$comandoSql = $comandoSql." FISH_FCOMP_DTNASC = NULL, ";
			}
			if(!empty($_POST['FISH_FCOMP_RGP_DTREGISTRO'])){
				$FISH_FCOMP_RGP_DTREGISTRO = reverse_date($_POST['FISH_FCOMP_RGP_DTREGISTRO']);
				$comandoSql = $comandoSql." FISH_FCOMP_RGP_DTREGISTRO = '$FISH_FCOMP_RGP_DTREGISTRO', ";
			} else {
				$comandoSql = $comandoSql." FISH_FCOMP_RGP_DTREGISTRO = NULL, ";
			}
			if(!empty($_POST['FISH_FCOMP_RG_DTREGISTRO'])){
				$FISH_FCOMP_RG_DTREGISTRO = reverse_date($_POST['FISH_FCOMP_RG_DTREGISTRO']);
				$comandoSql = $comandoSql." FISH_FCOMP_RG_DTREGISTRO = '$FISH_FCOMP_RG_DTREGISTRO' ";
			} else {
				$comandoSql = $comandoSql." FISH_FCOMP_RG_DTREGISTRO = NULL ";
			}
			$comandoSql = $comandoSql." WHERE FISH_FCOMP_ID = '$id';";
//			echo $comandoSql;
			$sql = mysql_query($comandoSql, $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_fish_familias_componente.php?id=$id&id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>