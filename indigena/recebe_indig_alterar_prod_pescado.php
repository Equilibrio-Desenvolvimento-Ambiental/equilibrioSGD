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
			function moeda($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor);
                return $valor;
			}

			$idEntrega = $_GET['idEntrega'];
			$idAldeia = $_GET['idAldeia'];
				
			$vet_INDIG_MOVPES_PESCADOR = $_POST['INDIG_MOVPES_PESCADOR'];
			$vet_INDIG_MOVPES_ESPECIE = $_POST['INDIG_MOVPES_ESPECIE'];
			$vet_INDIG_MOVPES_QTDE = $_POST['INDIG_MOVPES_QTDE'];
			$vet_INDIG_MOVPES_VALOR = $_POST['INDIG_MOVPES_VALOR'];
			$vet_INDIG_MOVPES_TT_DEVIDO = $_POST['INDIG_MOVPES_TT_DEVIDO'];
			$vet_INDIG_MOVPES_TT_PAGO = $_POST['INDIG_MOVPES_TT_PAGO'];
			$cont_PESCADO = 0;

			foreach((array)$vet_INDIG_MOVPES_PESCADOR as $vet_INDIG_MOVPES_PESCADORkey){
				$INDIG_MOVPES_PESCADOR = $_POST['INDIG_MOVPES_PESCADOR'][$cont_PESCADO];
				$INDIG_MOVPES_ESPECIE = $_POST['INDIG_MOVPES_ESPECIE'][$cont_PESCADO];
				$INDIG_MOVPES_QTDE = moeda($_POST['INDIG_MOVPES_QTDE'][$cont_PESCADO]);
				$INDIG_MOVPES_VALOR = moeda($_POST['INDIG_MOVPES_VALOR'][$cont_PESCADO]);
				$INDIG_MOVPES_TT_DEVIDO = moeda($_POST['INDIG_MOVPES_TT_DEVIDO'][$cont_PESCADO]);
				$INDIG_MOVPES_TT_PAGO = moeda($_POST['INDIG_MOVPES_TT_PAGO'][$cont_PESCADO]);
				
				$sql = mysql_query("INSERT INTO TAB_INDIG_PROD_PESCADO (INDIG_MOVPES_ENTREGA, INDIG_MOVPES_PESCADOR, INDIG_MOVPES_ESPECIE, INDIG_MOVPES_QTDE, INDIG_MOVPES_VALOR, INDIG_MOVPES_TT_DEVIDO, INDIG_MOVPES_TT_PAGO) VALUES ('$idEntrega', '$INDIG_MOVPES_PESCADOR', '$INDIG_MOVPES_ESPECIE', '$INDIG_MOVPES_QTDE', '$INDIG_MOVPES_VALOR', '$INDIG_MOVPES_TT_DEVIDO', '$INDIG_MOVPES_TT_PAGO');", $db) or die(mysql_error());
				$cont_PESCADO++;
			}
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/
			echo"<script language=\"JavaScript\">
				location.href=\"cadastrar_indig_dados_prod_entregas.php?idEntrega=$idEntrega&idAldeia=$idAldeia\";
				</script>"; 
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>