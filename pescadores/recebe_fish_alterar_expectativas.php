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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]'", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id_familia = $_GET['id_familia'];
			$FISH_COOEXP_ID = $_GET['FISH_COOEXP_ID'];
			
			$FISH_COOEXP_PART = $_POST['FISH_COOEXP_PART'];
			$FISH_COOEXP_PART_QUAL = mb_convert_case($_POST['FISH_COOEXP_PART_QUAL'], MB_CASE_UPPER, 'UTF-8');
			$FISH_COOEXP_DIFICULDADES = mb_convert_case($_POST['FISH_COOEXP_DIFICULDADES'], MB_CASE_UPPER, 'UTF-8');
			$FISH_COOEXP_CONTRIBUICAO = mb_convert_case($_POST['FISH_COOEXP_CONTRIBUICAO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_COOEXP_FILIACAO = $_POST['FISH_COOEXP_FILIACAO'];
			$FISH_COOEXP_FILI_SIM = mb_convert_case($_POST['FISH_COOEXP_FILI_SIM'], MB_CASE_UPPER, 'UTF-8');
			$FISH_COOEXP_FILI_NAO = mb_convert_case($_POST['FISH_COOEXP_FILI_NAO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_COOEXP_PERCEPCAO = mb_convert_case($_POST['FISH_COOEXP_PERCEPCAO'], MB_CASE_UPPER, 'UTF-8');
				
			$comandoSql = "UPDATE TAB_FISH_COOP_EXPECTATIVAS SET FISH_COOEXP_PART = '$FISH_COOEXP_PART', FISH_COOEXP_PART_QUAL = '$FISH_COOEXP_PART_QUAL', FISH_COOEXP_DIFICULDADES = '$FISH_COOEXP_DIFICULDADES', FISH_COOEXP_CONTRIBUICAO = '$FISH_COOEXP_CONTRIBUICAO', FISH_COOEXP_FILIACAO = '$FISH_COOEXP_FILIACAO', FISH_COOEXP_FILI_SIM = '$FISH_COOEXP_FILI_SIM', FISH_COOEXP_FILI_NAO = '$FISH_COOEXP_FILI_NAO', FISH_COOEXP_PERCEPCAO = '$FISH_COOEXP_PERCEPCAO' WHERE FISH_COOEXP_ID = '$FISH_COOEXP_ID' AND FISH_FAM_ID = '$id_familia';";
//  		echo $comandoSql;
			$sql = mysql_query($comandoSql, $db) or die(mysql_error());

			
			$vet_DIFICULDADESPRODUCAO = $_POST['FISH_CPXDIF_DIFICULDADE'];
			$cont_DIFICULDADESPRODUCAO = 0;
			foreach((array)$vet_DIFICULDADESPRODUCAO as $vet_DIFICULDADESPRODUCAOkey){
				$FISH_CPXDIF_DIFICULDADE = $_POST['FISH_CPXDIF_DIFICULDADE'][$cont_DIFICULDADESPRODUCAO];
				if(!$FISH_CPXDIF_DIFICULDADE == 0){
					$sql_consulta_DIFICULDADESPRODUCAO = mysql_query("SELECT FISH_CPXDIF_ID FROM TAB_FISH_COOEXP_DIFICULDADES WHERE FISH_COOEXP_ID = '$FISH_COOEXP_ID' AND FISH_CPXDIF_DIFICULDADE = '$FISH_CPXDIF_DIFICULDADE';", $db) or die(mysql_error());
					$num_DIFICULDADESPRODUCAO = mysql_num_rows($sql_consulta_DIFICULDADESPRODUCAO);
					if($num_DIFICULDADESPRODUCAO == 0) {
						$sql_insert_DIFICULDADESPRODUCAO = mysql_query("INSERT INTO TAB_FISH_COOEXP_DIFICULDADES (FISH_COOEXP_ID, FISH_CPXDIF_DIFICULDADE) VALUES ('$FISH_COOEXP_ID', '$FISH_CPXDIF_DIFICULDADE')", $db) or die(mysql_error());
					}
				}
				$cont_DIFICULDADESPRODUCAO++;
			}

			$vet_CONTRIBUICOESCOOP = $_POST['FISH_CPXCON_CONTRIBUICAO'];
			$cont_CONTRIBUICOESCOOP = 0;
			foreach((array)$vet_CONTRIBUICOESCOOP as $vet_CONTRIBUICOESCOOPkey){
				$FISH_CPXCON_CONTRIBUICAO = $_POST['FISH_CPXCON_CONTRIBUICAO'][$cont_CONTRIBUICOESCOOP];
				if(!$FISH_CPXCON_CONTRIBUICAO == 0){
					$sql_consulta_CONTRIBUICOESCOOP = mysql_query("SELECT FISH_CPXCON_ID FROM TAB_FISH_COOEXP_CONTRIBUICOES WHERE FISH_COOEXP_ID = '$FISH_COOEXP_ID' AND FISH_CPXCON_CONTRIBUICAO = '$FISH_CPXCON_CONTRIBUICAO';", $db) or die(mysql_error());
					$num_CONTRIBUICOESCOOP = mysql_num_rows($sql_consulta_CONTRIBUICOESCOOP);
					if($num_CONTRIBUICOESCOOP == 0) {
						$sql_insert_CONTRIBUICOESCOOP = mysql_query("INSERT INTO TAB_FISH_COOEXP_CONTRIBUICOES (FISH_COOEXP_ID, FISH_CPXCON_CONTRIBUICAO) VALUES ('$FISH_COOEXP_ID', '$FISH_CPXCON_CONTRIBUICAO')", $db) or die(mysql_error());
					}
				}
				$cont_CONTRIBUICOESCOOP++;
			}

			$vet_PARTICIPACAOCOOP = $_POST['FISH_CPXPAR_PARTICIPACAO'];
			$cont_PARTICIPACAOCOOP = 0;
			foreach((array)$vet_PARTICIPACAOCOOP as $vet_PARTICIPACAOCOOPkey){
				$FISH_CPXPAR_PARTICIPACAO = $_POST['FISH_CPXPAR_PARTICIPACAO'][$cont_PARTICIPACAOCOOP];
				if(!$FISH_CPXPAR_PARTICIPACAO == 0){
					$sql_consulta_PARTICIPACAOCOOP = mysql_query("SELECT FISH_CPXPAR_ID FROM TAB_FISH_COOEXP_PARTICIPACAO WHERE FISH_COOEXP_ID = '$FISH_COOEXP_ID' AND FISH_CPXPAR_PARTICIPACAO = '$FISH_CPXPAR_PARTICIPACAO';", $db) or die(mysql_error());
					$num_PARTICIPACAOCOOP = mysql_num_rows($sql_consulta_PARTICIPACAOCOOP);
					if($num_PARTICIPACAOCOOP == 0) {
						$sql_insert_PARTICIPACAOCOOP = mysql_query("INSERT INTO TAB_FISH_COOEXP_PARTICIPACAO (FISH_COOEXP_ID, FISH_CPXPAR_PARTICIPACAO) VALUES ('$FISH_COOEXP_ID', '$FISH_CPXPAR_PARTICIPACAO')", $db) or die(mysql_error());
					}
				}
				$cont_PARTICIPACAOCOOP++;
			}

			$vet_MOTIVONAOFILIACAO = $_POST['FISH_CPXNAO_MOTIVO'];
			$cont_MOTIVONAOFILIACAO = 0;
			foreach((array)$vet_MOTIVONAOFILIACAO as $vet_MOTIVONAOFILIACAOkey){
				$FISH_CPXNAO_MOTIVO = $_POST['FISH_CPXNAO_MOTIVO'][$cont_MOTIVONAOFILIACAO];
				if(!$FISH_CPXNAO_MOTIVO == 0){
					$sql_consulta_MOTIVONAOFILIACAO = mysql_query("SELECT FISH_CPXNAO_ID FROM TAB_FISH_COOEXP_NAOFILIACAO WHERE FISH_COOEXP_ID = '$FISH_COOEXP_ID' AND FISH_CPXNAO_MOTIVO = '$FISH_CPXNAO_MOTIVO';", $db) or die(mysql_error());
					$num_MOTIVONAOFILIACAO = mysql_num_rows($sql_consulta_MOTIVONAOFILIACAO);
					if($num_MOTIVONAOFILIACAO == 0) {
						$sql_insert_MOTIVONAOFILIACAO = mysql_query("INSERT INTO TAB_FISH_COOEXP_NAOFILIACAO (FISH_COOEXP_ID, FISH_CPXNAO_MOTIVO) VALUES ('$FISH_COOEXP_ID', '$FISH_CPXNAO_MOTIVO')", $db) or die(mysql_error());
					}
				}
				$cont_PARTICIPACAOCOOP++;
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