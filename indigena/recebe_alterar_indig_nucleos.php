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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			function reverse_date($date){
				return (strstr($date,'-')) ? implode('/',array_reverse(explode('-',$date))) : implode('-',array_reverse(explode('/',$date)));
			}
			function valid_date($date){
				if ( strlen($date) < 8){
					return false;
				}else{
					if(strpos($date, "/") !== FALSE){
						$partes = explode("/", $date);
						$dia = $partes[0];
						$mes = $partes[1];
						$ano = isset($partes[2]) ? $partes[2] : 0;
						if (strlen($ano) < 4) {
							return false;
						} else {
							if (checkdate($mes, $dia, $ano)) {
								 return true;
							} else {
								 return false;
							}
						}
					}else{
						return false;
					}
    			}
			}

			$INDIG_NUC_ID = $_GET['INDIG_NUC_ID'];
			$INDIG_NUC_NOME = mb_convert_case($_POST['INDIG_NUC_NOME'], MB_CASE_UPPER, 'UTF-8');
			$INDIG_NUC_ALDEIA = $_POST['INDIG_NUC_ALDEIA'];
			$sql = mysql_query("UPDATE TAB_INDIG_NUCLEOS SET INDIG_NUC_NOME = '$INDIG_NUC_NOME', INDIG_NUC_ALDEIA = '$INDIG_NUC_ALDEIA' WHERE INDIG_NUC_ID = '$INDIG_NUC_ID';", $db) or die(mysql_error());

			$vetorFAMILIA_ID = $_POST['FAMILIA_ID'];
			$contComponente = 0;
			foreach((array)$vetorFAMILIA_ID as $vetorFAMILIA_IDkey){
				$FAMILIA_ID = $_POST['FAMILIA_ID'][$contComponente];
				$INDIG_REL_NF_ORDEM = $_POST['INDIG_REL_NF_ORDEM'][$contComponente];
				$INDIG_REL_NF_PARENTESCO = $_POST['INDIG_REL_NF_PARENTESCO'][$contComponente];
				$sql_REL_NUCLEO_FAMILIA = mysql_query("SELECT * FROM TAB_INDIG_REL_NUCLEOS_FAMILIAS WHERE NUCLEO_ID = '$INDIG_NUC_ID' AND FAMILIA_ID = '$FAMILIA_ID';", $db) or die(mysql_error());
				if(mysql_num_rows($sql_REL_NUCLEO_FAMILIA) == 0){
					if($INDIG_REL_NF_ORDEM == 0){ $INDIG_REL_NF_ORDEM = 0; }
					if(!$FAMILIA_ID==0){
						$sql_ADD_NUCLEO_FAMILIA = mysql_query("INSERT INTO TAB_INDIG_REL_NUCLEOS_FAMILIAS (NUCLEO_ID, FAMILIA_ID, INDIG_REL_NF_ORDEM, INDIG_REL_NF_PARENTESCO) VALUES ('$INDIG_NUC_ID', '$FAMILIA_ID', '$INDIG_REL_NF_ORDEM', '$INDIG_REL_NF_PARENTESCO');", $db) or die(mysql_error());
					}
				}
				$contComponente++;
			}

			$vetorINDIG_NUCOBS_DATA = $_POST['INDIG_NUCOBS_DATA'];
			$contObservacoes = 0;
			foreach((array)$vetorINDIG_NUCOBS_DATA as $vetorINDIG_NUCOBS_DATAkey){
				$INDIG_NUCOBS_DATA = reverse_date($_POST['INDIG_NUCOBS_DATA'][$contObservacoes]);
				$INDIG_NUCOBS_TECNICO = $_POST['INDIG_NUCOBS_TECNICO'][$contObservacoes];
				$INDIG_NUCOBS_OBSERVACAO = mb_convert_case($_POST['INDIG_NUCOBS_OBSERVACAO'][$contObservacoes], MB_CASE_UPPER, 'UTF-8');
				if((valid_date($_POST['INDIG_NUCOBS_DATA'][$contObservacoes])) && !(($_POST['INDIG_NUCOBS_OBSERVACAO'][$contObservacoes]=='') || ($_POST['INDIG_NUCOBS_OBSERVACAO'][$contObservacoes]==NULL))){
					$sql_ADD_NUCOBS = mysql_query("INSERT INTO TAB_INDIG_NUCLEOS_OBSERVACOES (INDIG_NUCOBS_NUCLEO, INDIG_NUCOBS_DATA, INDIG_NUCOBS_TECNICO, INDIG_NUCOBS_OBSERVACAO) VALUES ('$INDIG_NUC_ID', '$INDIG_NUCOBS_DATA', '$INDIG_NUCOBS_TECNICO', '$INDIG_NUCOBS_OBSERVACAO');", $db) or die(mysql_error());
				}
				$contObservacoes++;
			}

			$vetorINDIG_NUCLOC_DATA = $_POST['INDIG_NUCLOC_DATA'];
			$contLocalizacoes = 0;
			foreach((array)$vetorINDIG_NUCLOC_DATA as $vetorINDIG_NUCLOC_DATAkey){
				$INDIG_NUCLOC_DATA = reverse_date($_POST['INDIG_NUCLOC_DATA'][$contLocalizacoes]);
				$INDIG_NUCLOC_TECNICO = $_POST['INDIG_NUCLOC_TECNICO'][$contLocalizacoes];
				$INDIG_NUCLOC_TELEFONES = mb_convert_case($_POST['INDIG_NUCLOC_TELEFONES'][$contLocalizacoes], MB_CASE_UPPER, 'UTF-8');
				$INDIG_NUCLOC_OUTROEND_CASAINDIO = $_POST['INDIG_NUCLOC_OUTROEND_CASAINDIO'][$contLocalizacoes];
				$INDIG_NUCLOC_OUTROEND_POSSUI = $_POST['INDIG_NUCLOC_OUTROEND_POSSUI'][$contLocalizacoes];
				$INDIG_NUCLOC_OUTROEND_DESCRICAO = mb_convert_case($_POST['INDIG_NUCLOC_OUTROEND_DESCRICAO'][$contLocalizacoes], MB_CASE_UPPER, 'UTF-8');
				$INDIG_NUCLOC_OUTROEND_MUNIC = $_POST['INDIG_NUCLOC_OUTROEND_MUNIC'][$contLocalizacoes];
				$INDIG_NUCLOC_COORDMOR_FUSO = $_POST['INDIG_NUCLOC_COORDMOR_FUSO'][$contLocalizacoes];
				$INDIG_NUCLOC_COORDMOR_UTME = mb_convert_case($_POST['INDIG_NUCLOC_COORDMOR_UTME'][$contLocalizacoes], MB_CASE_UPPER, 'UTF-8');
				$INDIG_NUCLOC_COORDMOR_UTMN = mb_convert_case($_POST['INDIG_NUCLOC_COORDMOR_UTMN'][$contLocalizacoes], MB_CASE_UPPER, 'UTF-8');
				if(valid_date($_POST['INDIG_NUCLOC_DATA'][$contLocalizacoes])){
					$sql_ADD_NUCLOC = mysql_query("INSERT INTO TAB_INDIG_NUCLEOS_LOCALIZACAO (INDIG_NUCLOC_NUCLEO, INDIG_NUCLOC_DATA, INDIG_NUCLOC_TECNICO, INDIG_NUCLOC_TELEFONES, INDIG_NUCLOC_OUTROEND_CASAINDIO, INDIG_NUCLOC_OUTROEND_POSSUI, INDIG_NUCLOC_OUTROEND_DESCRICAO, INDIG_NUCLOC_OUTROEND_MUNIC, INDIG_NUCLOC_COORDMOR_FUSO, INDIG_NUCLOC_COORDMOR_UTME, INDIG_NUCLOC_COORDMOR_UTMN) VALUES ('$INDIG_NUC_ID', '$INDIG_NUCLOC_DATA', '$INDIG_NUCLOC_TECNICO', '$INDIG_NUCLOC_TELEFONES', '$INDIG_NUCLOC_OUTROEND_CASAINDIO', '$INDIG_NUCLOC_OUTROEND_POSSUI', '$INDIG_NUCLOC_OUTROEND_DESCRICAO', '$INDIG_NUCLOC_OUTROEND_MUNIC', '$INDIG_NUCLOC_COORDMOR_FUSO', '$INDIG_NUCLOC_COORDMOR_UTME', '$INDIG_NUCLOC_COORDMOR_UTMN');", $db) or die(mysql_error());
				}
				$contLocalizacoes++;
			}

			$vetorINDIG_NUCEVE_DATA = $_POST['INDIG_NUCEVE_DATA'];
			$contEventos = 0;
			foreach((array)$vetorINDIG_NUCEVE_DATA as $vetorINDIG_NUCEVE_DATAkey){
				$INDIG_NUCEVE_DATA = reverse_date($_POST['INDIG_NUCEVE_DATA'][$contEventos]);
				$INDIG_NUCEVE_TECNICO = $_POST['INDIG_NUCEVE_TECNICO'][$contEventos];
				$INDIG_NUCEVE_TIPO = $_POST['INDIG_NUCEVE_TIPO'][$contEventos];
				$INDIG_NUCEVE_DESCRICAO = mb_convert_case($_POST['INDIG_NUCEVE_DESCRICAO'][$contEventos], MB_CASE_UPPER, 'UTF-8');
				if(valid_date($_POST['INDIG_NUCEVE_DATA'][$contEventos])){
					$sql_ADD_NUCEVE = mysql_query("INSERT INTO TAB_INDIG_NUCLEOS_EVENTOS (INDIG_NUCEVE_NUCLEO, INDIG_NUCEVE_DATA, INDIG_NUCEVE_TECNICO, INDIG_NUCEVE_TIPO, INDIG_NUCEVE_DESCRICAO, INDIG_NUCEVE_CHECKED) VALUES ('$INDIG_NUC_ID', '$INDIG_NUCEVE_DATA', '$INDIG_NUCEVE_TECNICO', '$INDIG_NUCEVE_TIPO', '$INDIG_NUCEVE_DESCRICAO', '2');", $db) or die(mysql_error());
				}
				$contEventos++;
			}
			
			$dirDocumentos = "docs/";
			$vetorINDIG_NUCDOC_DATA = $_POST['INDIG_NUCDOC_DATA'];
			$contDocumentos = 0;
			foreach((array)$vetorINDIG_NUCDOC_DATA as $vetorINDIG_NUCDOC_DATAkey){
				$INDIG_NUCDOC_DATA = reverse_date($_POST['INDIG_NUCDOC_DATA'][$contDocumentos]);
				$INDIG_NUCDOC_TECNICO = $_POST['INDIG_NUCDOC_TECNICO'][$contDocumentos];
				$INDIG_NUCDOC_TIPO = $_POST['INDIG_NUCDOC_TIPO'][$contDocumentos];
				$INDIG_NUCDOC_DESCRICAO = mb_convert_case($_POST['INDIG_NUCDOC_DESCRICAO'][$contDocumentos], MB_CASE_UPPER, 'UTF-8');
				$nome = $_FILES['INDIG_NUCDOC_ARQUIVO']['name'][$contDocumentos];
				$tmp = $_FILES['INDIG_NUCDOC_ARQUIVO']['tmp_name'][$contDocumentos];
				$ext = substr($nome, -4, 4);
				$newnome = date("Ymdhis");
				$extensao = explode(".",$nome);
				$fotonome = $extensao[0].$newnome;
				$retiraacentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($fotonome)));
				$nomefoto = $retiraacentos.$ext;
				$upload = $dirDocumentos.$retiraacentos.$ext;		
				if((valid_date($_POST['INDIG_NUCDOC_DATA'][$contDocumentos])) && !(($_FILES['INDIG_NUCDOC_ARQUIVO']['name'][$contDocumentos]=='') || ($_FILES['INDIG_NUCDOC_ARQUIVO']['name'][$contDocumentos]==NULL))){
					move_uploaded_file($tmp, "$dirDocumentos"."$nomefoto");
					$sql_ADD_NUCDOC = mysql_query("INSERT INTO TAB_INDIG_NUCLEOS_DOCUMENTOS (INDIG_NUCDOC_NUCLEO, INDIG_NUCDOC_DATA, INDIG_NUCDOC_TECNICO, INDIG_NUCDOC_TIPO, INDIG_NUCDOC_DESCRICAO, INDIG_NUCDOC_ARQUIVO) VALUES ('$INDIG_NUC_ID', '$INDIG_NUCDOC_DATA', '$INDIG_NUCDOC_TECNICO', '$INDIG_NUCDOC_TIPO', '$INDIG_NUCDOC_DESCRICAO', '$nomefoto');", $db) or die(mysql_error());
				}
				$contDocumentos++;
			}
		/*
			echo"<script language=\"JavaScript\">
				alert('Alterado com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_indig_nucleos.php?INDIG_NUC_ID=$INDIG_NUC_ID\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>