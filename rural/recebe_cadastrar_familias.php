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
			function moeda($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto 
                return $valor; //retorna o valor formatado para gravar no banco 
			}
			$FAMILIA_NUMERO = $_POST['FAMILIA_NUMERO'];
			$FAMILIA_FUNDIARIO = $_POST['FAMILIA_FUNDIARIO'];
			$FAMILIA_BENEFICIO = $_POST['FAMILIA_BENEFICIO'];
			$FAMILIA_BENEFICIARIO = $_POST['FAMILIA_BENEFICIARIO'];
			$FAMILIA_LOCALORIGEM = $_POST['FAMILIA_LOCALORIGEM'];
			$FAMILIA_MUNICIPIODESTINO = $_POST['FAMILIA_MUNICIPIODESTINO'];
			$FAMILIA_SETORATEND = $_POST['FAMILIA_SETORATEND'];
			$FAMILIA_LOCALDESTINO = $_POST['FAMILIA_LOCALDESTINO'];
			$FAMILIA_TELEFONES = $_POST['FAMILIA_TELEFONES'];
			$FAMILIA_UTME = $_POST['FAMILIA_UTME'];
			$FAMILIA_UTMN = $_POST['FAMILIA_UTMN'];
			$FAMILIA_FUSOGEO = $_POST['FAMILIA_FUSOGEO'];
			$FAMILIAS_RESIDENTE = $_POST['FAMILIAS_RESIDENTE'];
			$FAMILIAS_TECNICO = $_POST['FAMILIAS_TECNICO'];
			$FAMILIAS_GRUPO = $_POST['FAMILIAS_GRUPO'];
			
			$sql = mysql_query("insert into TAB_415421_FAMILIAS (FAMILIA_NUMERO, FAMILIA_FUNDIARIO, FAMILIA_BENEFICIO, FAMILIA_BENEFICIARIO, FAMILIA_LOCALORIGEM, FAMILIA_MUNICIPIODESTINO, FAMILIA_SETORATEND, FAMILIA_LOCALDESTINO, FAMILIA_TELEFONES, FAMILIA_UTME, FAMILIA_UTMN, FAMILIA_FUSOGEO, FAMILIA_RESIDENTE, FAMILIA_TECNICO, FAMILIA_GRUPO) values ('$FAMILIA_NUMERO', '$FAMILIA_FUNDIARIO', '$FAMILIA_BENEFICIO', '$FAMILIA_BENEFICIARIO', '$FAMILIA_LOCALORIGEM', '$FAMILIA_MUNICIPIODESTINO', '$FAMILIA_SETORATEND', '$FAMILIA_LOCALDESTINO', '$FAMILIA_TELEFONES', '$FAMILIA_UTME', '$FAMILIA_UTMN', '$FAMILIA_FUSOGEO', '$FAMILIAS_RESIDENTE', '$FAMILIAS_TECNICO', '$FAMILIAS_GRUPO')", $db) or die(mysql_error());
			
			$id_familia = mysql_insert_id();

			$sql_DADOSGERAIS = mysql_query("insert into TAB_415421_DADOSGERAIS (FAMILIA_CODIGO, DADOS_ATEND421, DADOS_MOTIVO421, DADOS_OBS421, DADOS_DTENTRADA_421, DADOS_DTSAIDA_421, DADOS_PEADS, DADOS_ATEND415, DADOS_MOTIVO415, DADOS_OBS415, DADOS_TPPROJ415, DADOS_SITPROJ415, DADOS_DTENTRADA_415, DADOS_DTSAIDA_415, DADOS_CAR, DADOS_CAR_STATUS, DADOS_DAP, DADOS_DAP_STATUS, DADOS_DLA, DADOS_DLA_STATUS, DADOS_VULNERAVEL, DADOS_INDIGENA, DADOS_LOTERRC, DADOS_ATENDRIR, DADOS_MOTIVORIR, DADOS_OBSRIR, DADOS_TPPROJRIR, DADOS_SITPROJRIR, DADOS_RIR_AVIARIO, DADOS_RIR_VIVEIRO, DADOS_RIR_ROCA, DADOS_RIR_FOSSA, DADOS_RIR_FILTRO) VALUES ('$id_familia',0,0,null,null,null,0,0,0,null,0,0,null,null,0,0,0,0,0,0,0,0,0,0,0,null,0,0,0,0,0,0,0)", $db);
			$sql_DADOSSALDO = mysql_query("insert into TAB_415421_DADOSSALDO (FAMILIA_CODIGO, SALDO_DATAAQUISICAO, SALDO_POSSUISALDO, SALDO_VALOR, SALDO_DTPARC_01, SALDO_DTPARC_02, SALDO_DTPARC_03, SALDO_DATAPLAPLIC, SALDO_STATUS) VALUES ('$id_familia',null,0,0,null,null,null,null,0)", $db);
			$sql_CARACTRIR = mysql_query("insert into TAB_415421_PONTOOCUP (FAMILIA_CODIGO, CARACTRIR_FUNDIARIO, CARACTRIR_BENEFORIGINAL, CARACTRIR_BENEFOFERTADO, CARACTRIR_PONTOOCUP, CARACTRIR_DOMICILIO, CARACTRIR_MUNICIPIO) VALUES ('$id_familia',null,0,0,null,null,0)", $db);
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