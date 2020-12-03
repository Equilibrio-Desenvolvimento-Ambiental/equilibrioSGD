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
			$id_familia = $_GET['id_familia'];
			$var_EVENTOS_DATA = $_POST['EVENTOS_DATA'];
			$var_EVENTOS_TIPO = $_POST['EVENTOS_TIPO'];
			$var_EVENTOS_OBSERVACOES = $_POST['EVENTOS_OBSERVACOES'];

			$cont_EVENTOS = 0;
			foreach((array)$var_EVENTOS_DATA as $var_EVENTOS_DATAkey){
				$EVENTOS_DATA = reverse_date($_POST['EVENTOS_DATA'][$cont_EVENTOS]);
				$EVENTOS_TIPO = $_POST['EVENTOS_TIPO'][$cont_EVENTOS];
				$EVENTOS_OBSERVACOES = $_POST['EVENTOS_OBSERVACOES'][$cont_EVENTOS];
				$EVENTOS_INSERT = date('Y-m-d H:i');
				$EVENTOS_INSERT_USER = $_SESSION['user'];
				$sql = mysql_query("INSERT INTO TAB_415421_EVENTOS (FAMILIA_CODIGO, EVENTOS_DATA, EVENTOS_TIPO, EVENTOS_OBSERVACOES, EVENTOS_INSERT, EVENTOS_INSERT_USER) VALUES ('$id_familia', '$EVENTOS_DATA', '$EVENTOS_TIPO', '$EVENTOS_OBSERVACOES', '$EVENTOS_INSERT', '$EVENTOS_INSERT_USER');", $db) or die(mysql_error());
				$id_evento = mysql_insert_id();
				$sql_evento415 = mysql_query("INSERT INTO TAB_415_CLASSIFICACAO (EVENTOS_CODIGO, CLASS415_TIPO, CLASS415_DESCRICAO) VALUES ('$id_evento', 29, NULL);", $db) or die(mysql_error());
				$sql_eventoRIR415 = mysql_query("INSERT INTO TAB_RIR415_CLASSIFICACAO (EVENTOS_CODIGO, CLASSRIR415_TIPO, CLASSRIR415_DESCRICAO) VALUES ('$id_evento', 21, NULL);", $db) or die(mysql_error());
				$VISITA_BAIXA = $_POST['VISITA_BAIXA'][$cont_EVENTOS];
				if($VISITA_BAIXA == 0){
				} else {
					$sql_visita = mysql_query("UPDATE TAB_415421_PLANVISITAS SET PLAN_VISIT_EXECUCAO = '$EVENTOS_DATA', PLAN_VISIT_CONCLUIDA = '1' WHERE PLAN_VISIT_ID = '$VISITA_BAIXA';", $db) or die(mysql_error());
				}
				$cont_EVENTOS++;
			}
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