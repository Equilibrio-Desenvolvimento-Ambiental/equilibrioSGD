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
			
			$var_FISH_FCOMP_NOME = $_POST['FISH_FCOMP_NOME'];
			$cont_COMPONENTE = 0;
			foreach((array)$var_FISH_FCOMP_NOME as $var_FISH_FCOMP_NOMEkey){
				$FISH_FCOMP_NOME = mb_convert_case($_POST['FISH_FCOMP_NOME'][$cont_COMPONENTE], MB_CASE_UPPER, 'UTF-8');
				$FISH_FCOMP_APELIDO = mb_convert_case($_POST['FISH_FCOMP_APELIDO'][$cont_COMPONENTE], MB_CASE_UPPER, 'UTF-8');
				$FISH_FCOMP_GENERO = $_POST['FISH_FCOMP_GENERO'][$cont_COMPONENTE];
				$FISH_FCOMP_PARENTESCO = $_POST['FISH_FCOMP_PARENTESCO'][$cont_COMPONENTE];
				$FISH_FCOMP_IDADE = $_POST['FISH_FCOMP_IDADE'][$cont_COMPONENTE];
				$FISH_FCOMP_OCUPACAO = $_POST['FISH_FCOMP_OCUPACAO'][$cont_COMPONENTE];
				$FISH_FCOMP_ALFAB_LER = $_POST['FISH_FCOMP_ALFAB_LER'][$cont_COMPONENTE];
				$FISH_FCOMP_ALFAB_ESCREVER = $_POST['FISH_FCOMP_ALFAB_ESCREVER'][$cont_COMPONENTE];
				$FISH_FCOMP_RGP_POSSUI = $_POST['FISH_FCOMP_RGP_POSSUI'][$cont_COMPONENTE];
				$FISH_FCOMP_RGP_NUMERO = mb_convert_case($_POST['FISH_FCOMP_RGP_NUMERO'][$cont_COMPONENTE], MB_CASE_UPPER, 'UTF-8');
				$FISH_FCOMP_RG_POSSUI = $_POST['FISH_FCOMP_RG_POSSUI'][$cont_COMPONENTE];
				$FISH_FCOMP_RG_NUMERO = mb_convert_case($_POST['FISH_FCOMP_RG_NUMERO'][$cont_COMPONENTE], MB_CASE_UPPER, 'UTF-8');
				$FISH_FCOMP_CPF_POSSUI = $_POST['FISH_FCOMP_CPF_POSSUI'][$cont_COMPONENTE];
				$FISH_FCOMP_CPF_NUMERO = mb_convert_case($_POST['FISH_FCOMP_CPF_NUMERO'][$cont_COMPONENTE], MB_CASE_UPPER, 'UTF-8');
				$FISH_FCOMP_RESIDENTE = $_POST['FISH_FCOMP_RESIDENTE'][$cont_COMPONENTE];
				if((!$FISH_FCOMP_NOME == '') && !is_null($FISH_FCOMP_NOME) && (!$FISH_FCOMP_GENERO == 0) && (!$FISH_FCOMP_PARENTESCO == 0)){
					$comandoSql = "INSERT INTO TAB_FISH_FAMILIAS_COMPOSICAO (FISH_FAM_ID, FISH_FCOMP_NOME, FISH_FCOMP_APELIDO, FISH_FCOMP_GENERO, FISH_FCOMP_PARENTESCO, FISH_FCOMP_IDADE, FISH_FCOMP_OCUPACAO, FISH_FCOMP_ALFAB_LER, FISH_FCOMP_ALFAB_ESCREVER, FISH_FCOMP_RGP_POSSUI, FISH_FCOMP_RGP_NUMERO, FISH_FCOMP_RG_POSSUI, FISH_FCOMP_RG_NUMERO, FISH_FCOMP_CPF_POSSUI, FISH_FCOMP_CPF_NUMERO, FISH_FCOMP_RESIDENTE, FISH_FCOMP_DTNASC, FISH_FCOMP_RGP_DTREGISTRO, FISH_FCOMP_RG_DTREGISTRO) VALUES ('$id_familia', '$FISH_FCOMP_NOME', '$FISH_FCOMP_APELIDO', '$FISH_FCOMP_GENERO', '$FISH_FCOMP_PARENTESCO', '$FISH_FCOMP_IDADE', '$FISH_FCOMP_OCUPACAO', '$FISH_FCOMP_ALFAB_LER', '$FISH_FCOMP_ALFAB_ESCREVER', '$FISH_FCOMP_RGP_POSSUI', '$FISH_FCOMP_RGP_NUMERO', '$FISH_FCOMP_RG_POSSUI', '$FISH_FCOMP_RG_NUMERO', '$FISH_FCOMP_CPF_POSSUI', '$FISH_FCOMP_CPF_NUMERO', '$FISH_FCOMP_RESIDENTE', ";
					if(!empty($_POST['FISH_FCOMP_DTNASC'][$cont_COMPONENTE])){
						$FISH_FCOMP_DTNASC = reverse_date($_POST['FISH_FCOMP_DTNASC'][$cont_COMPONENTE]);
						$comandoSql = $comandoSql." '$FISH_FCOMP_DTNASC', ";
					} else {
						$comandoSql = $comandoSql." NULL, ";
					}
					if(!empty($_POST['FISH_FCOMP_RGP_DTREGISTRO'][$cont_COMPONENTE])){
						$FISH_FCOMP_RGP_DTREGISTRO = reverse_date($_POST['FISH_FCOMP_RGP_DTREGISTRO'][$cont_COMPONENTE]);
						$comandoSql = $comandoSql." '$FISH_FCOMP_RGP_DTREGISTRO', ";
					} else {
						$comandoSql = $comandoSql." NULL, ";
					}
					if(!empty($_POST['FISH_FCOMP_RG_DTREGISTRO'][$cont_COMPONENTE])){
						$FISH_FCOMP_RG_DTREGISTRO = reverse_date($_POST['FISH_FCOMP_RG_DTREGISTRO'][$cont_COMPONENTE]);
						$comandoSql = $comandoSql." '$FISH_FCOMP_RG_DTREGISTRO')";
					} else {
						$comandoSql = $comandoSql." NULL)";
					}
					$sql = mysql_query($comandoSql, $db) or die(mysql_error());
				}
				$cont_COMPONENTE++;
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