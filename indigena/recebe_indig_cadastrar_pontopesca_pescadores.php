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

			$INDIG_PP_ID = $_GET['INDIG_PP_ID'];

			$vetINDIG_PPE_DATAREG = $_POST['INDIG_PPE_DATAREG'];
			$vetINDIG_PPE_ESPECIE = $_POST['INDIG_PPE_ESPECIE'];
			$vetINDIG_PPE_EQUIP = $_POST['INDIG_PPE_EQUIP'];
			$contINDIG_PPE_DATAREG = 0;
			$contINDIG_PPE_ESPECIE = 0;
			$contINDIG_PPE_EQUIP = 0;
			foreach((array)$vetINDIG_PPE_DATAREG as $vetINDIG_PPE_DATAREGkey){
				$INDIG_PPE_DATAREG = reverse_date($_POST['INDIG_PPE_DATAREG'][$contINDIG_PPE_DATAREG]);
				$INDIG_PPE_ESPECIE = $_POST['INDIG_PPE_ESPECIE'][$contINDIG_PPE_ESPECIE];
				$INDIG_PPE_EQUIP = $_POST['INDIG_PPE_EQUIP'][$contINDIG_PPE_EQUIP];
				$sqlConsulta = mysql_query("SELECT INDIG_PPE_ID FROM TAB_INDIG_PONTOPESCA_EQUIP WHERE INDIG_PPE_PONTO = '$INDIG_PP_ID' AND INDIG_PPE_DATAREG = '$INDIG_PPE_ALDEIA' AND INDIG_PPE_ESPECIE = '$INDIG_PPE_ESPECIE' AND INDIG_PPE_EQUIP = '$INDIG_PPE_EQUIP';", $db) or die(mysql_error());
				if(mysql_num_rows($sqlConsulta) == 0){
					$sqlInsert = mysql_query("INSERT INTO TAB_INDIG_PONTOPESCA_EQUIP (INDIG_PPE_PONTO, INDIG_PPE_DATAREG, INDIG_PPE_ESPECIE, INDIG_PPE_EQUIP) VALUES ('$INDIG_PP_ID', '$INDIG_PPE_DATAREG', '$INDIG_PPE_ESPECIE', '$INDIG_PPE_EQUIP');", $db) or die(mysql_error());	
				}
				$contINDIG_PPE_DATAREG++;
				$contINDIG_PPE_ESPECIE++;
				$contINDIG_PPE_EQUIP++;
			}
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/
			echo"<script language=\"JavaScript\">
				location.href=\"alterar_indig_pontopesca.php?INDIG_PP_ID=$INDIG_PP_ID\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>