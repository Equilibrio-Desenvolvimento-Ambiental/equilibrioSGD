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
			$sql = mysql_query("INSERT INTO TAB_FISH_PERFILENT (FISH_FAM_ID, FISH_PERFIL_VISITA, FISH_PERFIL_DTVISITA, FISH_PERFIL_APLIC, FISH_PERFIL_DTAPLIC, FISH_PERFIL_QUEST, FISH_PERFIL_PESQUISADOR, FISH_PERFIL_TAB, FISH_PERFIL_DTTAB, FISH_PERFIL_RELAT, FISH_PERFIL_DTRELAT, FISH_PERFIL_OBS, FISH_PERFIL_QTDEV_LOCO, FISH_PERFIL_QTDEV_FONE, FISH_PERFIL_P_BARCO, FISH_PERFIL_P_MOTOR, FISH_PERFIL_P_REPAROS, FISH_PERFIL_P_TRALHA, FISH_PERFIL_P_CESTA, FISH_PERFIL_P_RENDA, FISH_PERFIL_P_PROJ, FISH_PERFIL_P_ATEND, FISH_PERFIL_P_OUTROS, FISH_PERFIL_E_COOP, FISH_PERFIL_E_BARCO, FISH_PERFIL_E_MOTOR, FISH_PERFIL_E_REPAROS, FISH_PERFIL_E_TRALHA, FISH_PERFIL_E_TRALHA_TP, FISH_PERFIL_E_CESTA, FISH_PERFIL_E_RENDA, FISH_PERFIL_E_PROJ, FISH_PERFIL_E_ATEND, FISH_PERFIL_E_OUTROS, FISH_PERFIL_TRAN_RELATO, FISH_PERFIL_TRAN_ATEND, FISH_PERFIL_DEVOLUT, FISH_PERFIL_DTDEVOLUT, FISH_PERFIL_E_CESTA_ENT01, FISH_PERFIL_E_CESTA_ENT01DT, FISH_PERFIL_E_CESTA_ENT02, FISH_PERFIL_E_CESTA_ENT02DT, FISH_PERFIL_E_CESTA_ENT03, FISH_PERFIL_E_CESTA_ENT03DT, FISH_PERFIL_E_CESTA_ENT04, FISH_PERFIL_E_CESTA_ENT04DT, FISH_PERFIL_E_CESTA_ENTQT, 
			FISH_PERFIL_E_BARCO_ENT, FISH_PERFIL_E_BARCO_ENTDT, FISH_PERFIL_E_MOTOR_ENT, FISH_PERFIL_E_MOTOR_ENTDT, FISH_PERFIL_E_TRALHA_ENT, FISH_PERFIL_E_TRALHA_ENTDT, FISH_PERFIL_E_TRALHA_DESC) VALUES ('$id_familia', '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NULL, NULL, NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', '0', NULL, '0', NULL, '0', NULL, NULL);", $db) or die(mysql_error());
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