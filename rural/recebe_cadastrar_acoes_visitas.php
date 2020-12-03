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
			$id_visita = $_GET['id_visita'];
			$id_familia = $_GET['id_familia'];

			$PLAN415_SUBTIPO = $_POST['subtipo415'];
			if(isset($_POST['subtipo415'])) {
				if($PLAN415_SUBTIPO == 0){
				} else {
					$sql_plan415 = mysql_query("insert into TAB_415_PLANVISITAS (PLAN_VISIT_ID, PLAN415_TIPO) VALUES ('$id_visita', '$PLAN415_SUBTIPO');", $db);
				}
			} else { }

			$PLAN421_SUBTIPO = $_POST['subtipo421'];
			if(isset($_POST['subtipo421'])) {
				if($PLAN421_SUBTIPO == 0){
				} else {
					$sql_plan421 = mysql_query("insert into TAB_421_PLANVISITAS (PLAN_VISIT_ID, PLAN421_TIPO) VALUES ('$id_visita', '$PLAN421_SUBTIPO');", $db);
				}
			} else { }

			$PLANRIR_SUBTIPO = $_POST['subtiporir'];
			if(isset($_POST['subtiporir'])) {
				if($PLANRIR_SUBTIPO == 0){
				} else {
					$sql_planrir = mysql_query("insert into TAB_RIR_PLANVISITAS (PLAN_VISIT_ID, PLANRIR_TIPO) VALUES ('$id_visita', '$PLANRIR_SUBTIPO');", $db);
				}
			} else { }

			$vet_PLANTEC_TECNICO = $_POST['PLANTEC_TECNICO'];
			$cont_TECNICOS = 0;
			foreach((array)$vet_PLANTEC_TECNICO as $vet_PLANTEC_TECNICOkey){
				$PLANTEC_TECNICO = $_POST['PLANTEC_TECNICO'][$cont_TECNICOS];
				$sql_tecnicos = mysql_query("insert into TAB_415421_PLANTECNICOS (PLAN_VISIT_ID, PLANTEC_TECNICO) VALUES ('$id_visita', '$PLANTEC_TECNICO');", $db);
				$cont_TECNICOS++;
			}

			$vet_PLANMAT_CONSUMO = $_POST['PLANMATC_TIPO'];
			$cont_PLANMATC = 0;
			foreach((array)$vet_PLANMAT_CONSUMO as $vet_PLANMAT_CONSUMOkey){
				$PLANMATC_TIPO = $_POST['PLANMATC_TIPO'][$cont_PLANMATC];
				$PLANMATC_QTDE = $_POST['PLANMATC_QTDE'][$cont_PLANMATC];
				$PLANMATC_CCUSTO = $_POST['PLANMATC_CCUSTO'][$cont_PLANMATC];
				$sql = mysql_query("insert into TAB_415421_PLANMAT_CONSUMO (PLAN_VISIT_ID, PLANMATC_TIPO, PLANMATC_QTDE, PLANMATC_CCUSTO) VALUES ('$id_visita', '$PLANMATC_TIPO', '$PLANMATC_QTDE', '$PLANMATC_CCUSTO');", $db);
				$cont_PLANMATC++;
			}

			$vet_PLANMAT_KITS = $_POST['PLANMATK_TIPO'];
			$cont_PLANMATK = 0;
			foreach((array)$vet_PLANMAT_KITS as $vet_PLANMAT_KITSkey){
				$PLANMATK_TIPO = $_POST['PLANMATK_TIPO'][$cont_PLANMATK];
				$PLANMATK_QTDE = $_POST['PLANMATK_QTDE'][$cont_PLANMATK];
				$PLANMATK_CCUSTO = $_POST['PLANMATK_CCUSTO'][$cont_PLANMATK];
				$sql = mysql_query("insert into TAB_415421_PLANMAT_KITS (PLAN_VISIT_ID, PLANMATK_TIPO, PLANMATK_QTDE, PLANMATK_CCUSTO) VALUES ('$id_visita', '$PLANMATK_TIPO', '$PLANMATK_QTDE', '$PLANMATK_CCUSTO');", $db);
				$cont_PLANMATK++;
			}

			$vet_PLANMAT_USO = $_POST['PLANMATU_TIPO'];
			$cont_PLANMATU = 0;
			foreach((array)$vet_PLANMAT_USO as $vet_PLANMAT_USOkey){
				$PLANMATU_TIPO = $_POST['PLANMATU_TIPO'][$cont_PLANMATU];
				$PLANMATU_QTDE = $_POST['PLANMATU_QTDE'][$cont_PLANMATU];
				$PLANMATU_CCUSTO = $_POST['PLANMATU_CCUSTO'][$cont_PLANMATU];
				$sql = mysql_query("insert into TAB_415421_PLANMAT_USO (PLAN_VISIT_ID, PLANMATU_TIPO, PLANMATU_QTDE, PLANMATU_CCUSTO) VALUES ('$id_visita', '$PLANMATU_TIPO', '$PLANMATU_QTDE', '$PLANMATU_CCUSTO');", $db);
				$cont_PLANMATU++;
			}

		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/
			echo"<script language=\"JavaScript\">
				location.href=\"planejamento_incluir_acoes.php?id_visita=$id_visita&id_familia=$id_familia\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>