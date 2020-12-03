<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 6;
	session_start();
	if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
		echo "Esta área é restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]';", $db);
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
			function moeda($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor);
                return $valor;
			}
			$PRODENTU_DATA = reverse_date($_POST['PRODENTU_DATA']);
			$PRODENTU_PRODUTO = $_POST['PRODENTU_PRODUTO'];
			$PRODENTU_FORNEC = $_POST['PRODENTU_FORNEC'];
			$PRODENTU_VALOR = moeda($_POST['PRODENTU_VALOR']);
			$PRODENTU_QTDE = $_POST['PRODENTU_QTDE'];
			$sql = mysql_query("insert into TAB_ADM_ENTRADAS_USO (PRODENTU_DATA, PRODENTU_PRODUTO, PRODENTU_FORNEC, PRODENTU_VALOR, PRODENTU_QTDE) values ('$PRODENTU_DATA', '$PRODENTU_PRODUTO', '$PRODENTU_FORNEC', '$PRODENTU_VALOR', '$PRODENTU_QTDE');", $db) or die(mysql_error());
			$sqlConsultEstoque = mysql_query("select MATUSO_ESTOQUE_ATUAL from TAB_ADM_MATUSO where MATUSO_ID = '$PRODENTU_PRODUTO';", $db);
			$vetorConsultEstoque=mysql_fetch_array($sqlConsultEstoque);
			$MATUSO_ESTOQUE_ATUAL = $vetorConsultEstoque['MATUSO_ESTOQUE_ATUAL'] + $PRODENTU_QTDE;
			$sql = mysql_query("update TAB_ADM_MATUSO set MATUSO_ESTOQUE_ATUAL = '$MATUSO_ESTOQUE_ATUAL' where MATUSO_ID = '$PRODENTU_PRODUTO';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_entradaprod_uso.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>