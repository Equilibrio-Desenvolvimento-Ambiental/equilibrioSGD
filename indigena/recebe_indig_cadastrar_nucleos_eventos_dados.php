<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 8;
	session_start();
	if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
		echo "Esta área é restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		$sqlPermissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
		$numBusca = mysql_num_rows($sqlPermissao);
		if ($numBusca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$INDIG_NUC_ID = $_GET['INDIG_NUC_ID'];
			$INDIG_NUCEVE_ID = $_GET['INDIG_NUCEVE_ID'];
			
			$INDIG_NUCEVC_TIPO = $_POST['subtipo'];
			$INDIG_NUCEVC_DESCRICAO = $_POST['INDIG_NUCEVC_DESCRICAO'];
			if(isset($_POST['subtipo']) || isset($_POST['INDIG_NUCEVC_DESCRICAO'])) {
				if($INDIG_NUCEVC_TIPO == 0){
				} else {
					$sql_CLASSIFICACAO = mysql_query("INSERT INTO TAB_INDIG_NUCLEOS_EVENTOS_CLASSIFICACAO (INDIG_NUCEVC_EVENTO, INDIG_NUCEVC_TIPO, INDIG_NUCEVC_DESCRICAO) VALUES ('$INDIG_NUCEVE_ID', '$INDIG_NUCEVC_TIPO', '$INDIG_NUCEVC_DESCRICAO');", $db) or die(mysql_error());
					$sql_EVENTO = mysql_query("UPDATE TAB_INDIG_NUCLEOS_EVENTOS SET INDIG_NUCEVE_CHECKED = '2' WHERE INDIG_NUCEVE_ID = '$INDIG_NUC_ID';", $db) or die(mysql_error());
				}
			} else { }

			$vet_TECNICOS = $_POST['INDIG_NUCEVI_TECNICO'];
			$cont_TECNICOS = 0;
			foreach((array)$vet_TECNICOS as $vet_TECNICOSkey){
				$INDIG_NUCEVI_TECNICO = $_POST['INDIG_NUCEVI_TECNICO'][$cont_TECNICOS];
				if($INDIG_NUCEVI_TECNICO >0){
					$sql_TECNICO = mysql_query("INSERT INTO TAB_INDIG_NUCLEOS_EVENTOS_TECNICOS (INDIG_NUCEVI_EVENTO, INDIG_NUCEVI_TECNICO) VALUES ('$INDIG_NUCEVE_ID', '$INDIG_NUCEVI_TECNICO');", $db) or die(mysql_error());
				}
				$cont_TECNICOS++;
			}

			$diretorio = "imagens/";
			$vet_IMAGENS = $_POST['INDIG_NUCEVI_LEGENDA'];
			$cont_IMAGENS = 0;
			foreach((array)$vet_IMAGENS as $vet_IMAGENSkey){
				$INDIG_NUCEVI_LEGENDA = mb_convert_case($_POST['INDIG_NUCEVI_LEGENDA'][$cont_IMAGENS], MB_CASE_UPPER, 'UTF-8');
				$nome = $_FILES['INDIG_NUCEVI_ARQUIVO']['name'][$cont_IMAGENS];
				$tmp = $_FILES['INDIG_NUCEVI_ARQUIVO']['tmp_name'][$cont_IMAGENS];
				$ext = substr($nome, -4, 4);
				$newnome = date("Ymdhis");
				$extensao = explode(".",$nome);
				$fotonome = $extensao[0].$newnome;
				$retiraacentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($fotonome)));
				$nomefoto = $retiraacentos.$ext;
				$upload = $diretorio.$retiraacentos.$ext;		
				move_uploaded_file($tmp, "$diretorio"."$nomefoto");
				$sql_IMAGEM = mysql_query("INSERT INTO TAB_INDIG_NUCLEOS_EVENTOS_IMAGENS (INDIG_NUCEVI_EVENTO, INDIG_NUCEVI_ARQUIVO, INDIG_NUCEVI_LEGENDA) VALUES ('$INDIG_NUCEVE_ID', '$nomefoto', '$INDIG_NUCEVI_LEGENDA')", $db) or die(mysql_error());
				$cont_IMAGENS++;
			}
			
			$dirdocs = "docs/";
			$vet_DOCUMENTOS = $_POST['INDIG_NUCEVD_TIPO'];
			$cont_DOCUMENTOS = 0;
			foreach((array)$vet_DOCUMENTOS as $vet_DOCUMENTOSkey){
				$INDIG_NUCEVD_TIPO = $_POST['INDIG_NUCEVD_TIPO'][$cont_DOCUMENTOS];
				$INDIG_NUCEVD_DESCRICAO = mb_convert_case($_POST['INDIG_NUCEVD_DESCRICAO'][$cont_DOCUMENTOS], MB_CASE_UPPER, 'UTF-8');
				$nome = $_FILES['INDIG_NUCEVD_ARQUIVO']['name'][$cont_DOCUMENTOS];
				$tmp = $_FILES['INDIG_NUCEVD_ARQUIVO']['tmp_name'][$cont_DOCUMENTOS];
				$ext = substr($nome, -4, 4);
				$newnome = date("Ymdhis");
				$extensao = explode(".",$nome);
				$docnome = $extensao[0].$newnome;
				$retiraacentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($docnome)));
				$nomedoc = $retiraacentos.$ext;
				$upload = $dirdocs.$retiraacentos.$ext;		
				move_uploaded_file($tmp, "$dirdocs"."$nomedoc");
				$sql_DOCUMENTO = mysql_query("INSERT INTO TAB_INDIG_NUCLEOS_EVENTOS_DOCUMENTOS (INDIG_NUCEVD_EVENTO, INDIG_NUCEVD_TIPO, INDIG_NUCEVD_DESCRICAO, INDIG_NUCEVD_ARQUIVO) VALUES ('$INDIG_NUCEVE_ID', '$INDIG_NUCEVD_TIPO', '$INDIG_NUCEVD_DESCRICAO', '$nomedoc');", $db) or die(mysql_error());
				$cont_DOCUMENTOS++;
			}
			
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_indig_nucleos_eventos_dados.php?INDIG_NUCEVE_ID=$INDIG_NUCEVE_ID&INDIG_NUC_ID=$INDIG_NUC_ID\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>