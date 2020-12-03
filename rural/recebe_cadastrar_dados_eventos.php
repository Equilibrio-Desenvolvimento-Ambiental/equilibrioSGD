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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
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
			
			$id_evento = $_GET['id_evento'];
			$id_familia = $_GET['id_familia'];

			$CLASS415_SUBTIPO = $_POST['subtipo415'];
			$CLASS415_DESCRICAO = $_POST['CLASS415_DESCRICAO'];
			if(isset($_POST['subtipo415']) || isset($_POST['CLASS415_DESCRICAO'])) {
				if($CLASS415_SUBTIPO == 0){
				} else {
					$sql_class415 = mysql_query("INSERT INTO TAB_415_CLASSIFICACAO (EVENTOS_CODIGO, CLASS415_TIPO, CLASS415_DESCRICAO) VALUES ('$id_evento', '$CLASS415_SUBTIPO', '$CLASS415_DESCRICAO');", $db) or die(mysql_error());
					$sql_evento = mysql_query("UPDATE TAB_415421_EVENTOS SET EVENTOS_CHECKED = '2' WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
				}
			} else { }

			$CLASS421_SUBTIPO = $_POST['subtipo421'];
			$CLASS421_DESCRICAO = $_POST['CLASS421_DESCRICAO'];
			if(isset($_POST['subtipo421']) || isset($_POST['CLASS421_DESCRICAO'])) {
				if($CLASS421_SUBTIPO == 0){
				} else {
					$sql_class421 = mysql_query("insert into TAB_421_CLASSIFICACAO (EVENTOS_CODIGO, CLASS421_TIPO, CLASS421_DESCRICAO) VALUES ('$id_evento', '$CLASS421_SUBTIPO', '$CLASS421_DESCRICAO')", $db) or die(mysql_error());
					$sql_evento = mysql_query("UPDATE TAB_415421_EVENTOS SET EVENTOS_CHECKED = '2' WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
				}
			} else { }

			$CLASS415421_SUBTIPO = $_POST['subtipo415421_interf'];
			$CLASS415421_DESCRICAO = $_POST['CLASS415421_DESCRICAO'];
			if(isset($_POST['subtipo415421_interf']) || isset($_POST['CLASS415421_DESCRICAO'])) {
				if($CLASS415421_SUBTIPO == 0){
				} else {
					$sql_class415421_interf = mysql_query("INSERT INTO TAB_415421_CLASSIFICACAO (EVENTOS_CODIGO, CLASS415421_TIPO, CLASS415421_DESCRICAO) VALUES ('$id_evento', '$CLASS415421_SUBTIPO', '$CLASS415421_DESCRICAO');", $db) or die(mysql_error());
					$sql_evento = mysql_query("UPDATE TAB_415421_EVENTOS SET EVENTOS_CHECKED = '2' WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
				}
			} else { }
			
			$CLASSRIR415_SUBTIPO = $_POST['subtiporir415'];
			$CLASSRIR415_DESCRICAO = $_POST['CLASSRIR415_DESCRICAO'];
			if(isset($_POST['subtiporir415']) || isset($_POST['CLASSRIR415_DESCRICAO'])) {
				if($CLASSRIR415_SUBTIPO == 0){
				} else {
					$sql_classrir415 = mysql_query("INSERT INTO TAB_RIR415_CLASSIFICACAO (EVENTOS_CODIGO, CLASSRIR415_TIPO, CLASSRIR415_DESCRICAO) VALUES ('$id_evento', '$CLASSRIR415_SUBTIPO', '$CLASSRIR415_DESCRICAO');", $db) or die(mysql_error());
					$sql_evento = mysql_query("UPDATE TAB_415421_EVENTOS SET EVENTOS_CHECKED = '2' WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
				}
			} else { }

			$CLASSRIR421_SUBTIPO = $_POST['subtiporir421'];
			$CLASSRIR421_DESCRICAO = $_POST['CLASSRIR421_DESCRICAO'];
			if(isset($_POST['subtiporir421']) || isset($_POST['CLASSRIR421_DESCRICAO'])) {
				if($CLASSRIR421_SUBTIPO == 0){
				} else {
					$sql_classrir421 = mysql_query("INSERT INTO TAB_RIR421_CLASSIFICACAO (EVENTOS_CODIGO, CLASSRIR421_TIPO, CLASSRIR421_DESCRICAO) VALUES ('$id_evento', '$CLASSRIR421_SUBTIPO', '$CLASSRIR421_DESCRICAO');", $db) or die(mysql_error());
					$sql_evento = mysql_query("UPDATE TAB_415421_EVENTOS SET EVENTOS_CHECKED = '2' WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
				}
			} else { }
			
			$CLASSRIRINT_SUBTIPO = $_POST['subtiporir_interf'];
			$CLASSRIRINT_DESCRICAO = $_POST['CLASSRIRINT_DESCRICAO'];
			if(isset($_POST['subtiporir_interf']) || isset($_POST['CLASSRIRINT_DESCRICAO'])) {
				if($CLASSRIRINT_SUBTIPO == 0){
				} else {
					$sql_classrir_interf = mysql_query("INSERT INTO TAB_RIRINT_CLASSIFICACAO (EVENTOS_CODIGO, CLASSRIRINT_TIPO, CLASSRIRINT_DESCRICAO) VALUES ('$id_evento', '$CLASSRIRINT_SUBTIPO', '$CLASSRIRINT_DESCRICAO');", $db) or die(mysql_error());
					$sql_evento = mysql_query("UPDATE TAB_415421_EVENTOS SET EVENTOS_CHECKED = '2' WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
				}
			} else { }

			$vet_TECNICOS_TECNICO = $_POST['TECNICOS_TECNICO'];
			$cont_TECNICOS = 0;
			foreach((array)$vet_TECNICOS_TECNICO as $vet_TECNICOS_TECNICOkey){
				$TECNICOS_TECNICO = $_POST['TECNICOS_TECNICO'][$cont_TECNICOS];
				if($TECNICOS_TECNICO >0){
					$sql_tecnicos = mysql_query("INSERT INTO TAB_415421_TECNICOS (EVENTOS_CODIGO, TECNICOS_TECNICO) VALUES ('$id_evento', '$TECNICOS_TECNICO');", $db) or die(mysql_error());
				}
				$cont_TECNICOS++;
			}

			$dirimagens = "imagens/";
			$vet_IMAGEM_LEGENDA = $_POST['IMAGEM_LEGENDA'];
			$vet_IMAGEM_NOME = $_POST['IMAGEM_NOME'];
			$cont_IMAGENS = 0;
			foreach((array)$vet_IMAGEM_LEGENDA as $vet_IMAGEM_LEGENDAkey){
				$IMAGEM_LEGENDA = mb_convert_case($_POST['IMAGEM_LEGENDA'][$cont_IMAGENS], MB_CASE_UPPER, 'UTF-8');
				$nome = $_FILES['IMAGEM_NOME']['name'][$cont_IMAGENS];
				$tmp = $_FILES['IMAGEM_NOME']['tmp_name'][$cont_IMAGENS];
				$ext = substr($nome, -4, 4);
				$newnome = date("Ymdhis");
				$extensao = explode(".",$nome);
				$fotonome = $extensao[0].$newnome;
				$retiraacentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($fotonome)));
				$nomefoto = $retiraacentos.$ext;
				$upload = $dirimagens.$retiraacentos.$ext;		
				move_uploaded_file($tmp, "$dirimagens"."$nomefoto");
				$sql_imagens = mysql_query("INSERT INTO TAB_415421_IMAGENS (EVENTOS_CODIGO, IMAGEM_NOME, IMAGEM_LEGENDA) VALUES ('$id_evento', '$nomefoto', '$IMAGEM_LEGENDA');", $db) or die(mysql_error());
				$sql_evento = mysql_query("UPDATE TAB_415421_EVENTOS SET EVENTOS_CHECKED = '2' WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
				$cont_IMAGENS++;
			}
			
			$dirdocs = "docs/";
			$vet_EVEDOC_DATA = $_POST['EVEDOC_DATA'];
			$vet_EVEDOC_TIPO = $_POST['EVEDOC_TIPO'];
			$vet_EVEDOC_DESCRICAo = $_POST['EVEDOC_DESCRICAO'];
			$vet_EVEDOC_ARQUIVO = $_POST['EVEDOC_ARQUIVO'];
			$cont_EVEDOCS = 0;
			foreach((array)$vet_EVEDOC_DATA as $vet_EVEDOC_DATAkey){
				$EVEDOC_DATA = reverse_date($_POST['EVEDOC_DATA'][$cont_EVEDOCS]);
				$EVEDOC_TIPO = $_POST['EVEDOC_TIPO'][$cont_EVEDOCS];
				$EVEDOC_DESCRICAO = mb_convert_case($_POST['EVEDOC_DESCRICAO'][$cont_EVEDOCS], MB_CASE_UPPER, 'UTF-8');
				$nome = $_FILES['EVEDOC_ARQUIVO']['name'][$cont_EVEDOCS];
				$tmp = $_FILES['EVEDOC_ARQUIVO']['tmp_name'][$cont_EVEDOCS];
				$ext = substr($nome, -4, 4);
				$newnome = date("Ymdhis");
				$extensao = explode(".",$nome);
				$docnome = $extensao[0].$newnome;
				$retiraacentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($docnome)));
				$nomedoc = $retiraacentos.$ext;
				$upload = $dirdocs.$retiraacentos.$ext;		
				move_uploaded_file($tmp, "$dirdocs"."$nomedoc");
				$sql_documentos = mysql_query("INSERT INTO TAB_415421_EVENTOS_DOCS (EVENTOS_CODIGO, EVEDOC_DATA, EVEDOC_TIPO, EVEDOC_DESCRICAO, EVEDOC_ARQUIVO) VALUES ('$id_evento', '$EVEDOC_DATA', '$EVEDOC_TIPO', '$EVEDOC_DESCRICAO', '$nomedoc');", $db) or die(mysql_error());
				$cont_EVEDOCS++;
			}
			
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_dados_eventos.php?id_evento=$id_evento&id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>