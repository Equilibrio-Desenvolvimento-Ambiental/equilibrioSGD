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
			function to_float($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
                return $valor; //retorna o valor formatado para gravar no banco 
			}
			$POCUP_PROCESSO = $_POST['POCUP_PROCESSO'];
			$POCUP_AREAUSO = to_float($_POST['POCUP_AREAUSO']);
			$POCUP_AREACACAU = to_float($_POST['POCUP_AREACACAU']);
			$POCUP_AREAFLO_PRI = to_float($_POST['POCUP_AREAFLO_PRI']);
			$POCUP_AREAFLO_SEC = to_float($_POST['POCUP_AREAFLO_SEC']);
			$POCUP_AREAPASTAGEM = to_float($_POST['POCUP_AREAPASTAGEM']);
			$POCUP_AREAOUTRAS = to_float($_POST['POCUP_AREAOUTRAS']);
			$POCUP_AREAOUTRAS_TXT = $_POST['POCUP_AREAOUTRAS_TXT'];
			$POCUP_MUNICIPIO = $_POST['POCUP_MUNICIPIO'];
			$POCUP_SETOR = $_POST['POCUP_SETOR'];
			$POCUP_ACESSO_UTME = $_POST['POCUP_ACESSO_UTME'];
			$POCUP_ACESSO_UTMN = $_POST['POCUP_ACESSO_UTMN'];
			$POCUP_ACESSO_DESC = $_POST['POCUP_ACESSO_DESC'];
			$POCUP_PONTO_DATUM = $_POST['POCUP_PONTO_DATUM'];
			$POCUP_PONTO_HEMISFERIO = $_POST['POCUP_PONTO_HEMISFERIO'];
			$POCUP_PONTO_FUSO = $_POST['POCUP_PONTO_FUSO'];
			$POCUP_PONTO_UTME = $_POST['POCUP_PONTO_UTME'];
			$POCUP_PONTO_UTMN = $_POST['POCUP_PONTO_UTMN'];
			$POCUP_CONF_NORTE = $_POST['POCUP_CONF_NORTE'];
			$POCUP_CONF_SIL = $_POST['POCUP_CONF_SIL'];
			$POCUP_CONF_LESTE = $_POST['POCUP_CONF_LESTE'];
			$POCUP_CONF_OESTE = $_POST['POCUP_CONF_OESTE'];
			$diretorio = "imagens/";
			$nome_original = $_FILES['POCUP_MAPA']['name'];
			$nome_temp = $_FILES['POCUP_MAPA']['tmp_name'];
			$nome_extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
			$nome_no_acentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim(pathinfo($nome_original, PATHINFO_FILENAME))));
			$nome_final = $nome_no_acentos.' - '.date("Ymdhis").'.'.$nome_extensao;
			move_uploaded_file($nome_temp, "$diretorio"."$nome_final");
			$POCUP_MAPA = $nome_final;
			$POCUP_PLANEJAMENTO = $_POST['POCUP_PLANEJAMENTO'];
			$sql = mysql_query("insert into TAB_RIR_PONTOOCUP (POCUP_PROCESSO, POCUP_AREAUSO, POCUP_AREACACAU, POCUP_AREAFLO_PRI, POCUP_AREAFLO_SEC, POCUP_AREAPASTAGEM, POCUP_AREAOUTRAS, POCUP_AREAOUTRAS_TXT, POCUP_MUNICIPIO, POCUP_SETOR, POCUP_ACESSO_UTME, POCUP_ACESSO_UTMN, POCUP_ACESSO_DESC, POCUP_PONTO_DATUM, POCUP_PONTO_HEMISFERIO, POCUP_PONTO_FUSO, POCUP_PONTO_UTME, POCUP_PONTO_UTMN, POCUP_CONF_NORTE, POCUP_CONF_SIL, POCUP_CONF_LESTE, POCUP_CONF_OESTE, POCUP_MAPA, POCUP_PLANEJAMENTO) values ('$POCUP_PROCESSO', '$POCUP_AREAUSO', '$POCUP_AREACACAU', '$POCUP_AREAFLO_PRI', '$POCUP_AREAFLO_SEC', '$POCUP_AREAPASTAGEM', '$POCUP_AREAOUTRAS', '$POCUP_AREAOUTRAS_TXT', '$POCUP_MUNICIPIO', '$POCUP_SETOR', '$POCUP_ACESSO_UTME', '$POCUP_ACESSO_UTMN', '$POCUP_ACESSO_DESC', '$POCUP_PONTO_DATUM', '$POCUP_PONTO_HEMISFERIO', '$POCUP_PONTO_FUSO', '$POCUP_PONTO_UTME', '$POCUP_PONTO_UTMN', '$POCUP_CONF_NORTE', '$POCUP_CONF_SIL', '$POCUP_CONF_LESTE', '$POCUP_CONF_OESTE', '$POCUP_MAPA', '$POCUP_PLANEJAMENTO')", $db) or die(mysql_error());
			$id_ponto = mysql_insert_id();
			$vet_POTIPVEG_TIPO = $_POST['POTIPVEG_TIPO'];
			$cont_POTIPVEG_TIPO = 0;
			foreach((array)$vet_POTIPVEG_TIPO as $vet_POTIPVEG_TIPOkey){
				$POTIPVEG_TIPO = $_POST['POTIPVEG_TIPO'][$cont_POTIPVEG_TIPO];
				$sql_POTIPVEG = mysql_query("insert into TAB_RIR_PO_TIPVEG (POCUP_CODIGO, POTIPVEG_TIPO) values ('$id_ponto', '$POTIPVEG_TIPO')", $db);
				$cont_POTIPVEG_TIPO++;
			}
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_pontoocup.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>