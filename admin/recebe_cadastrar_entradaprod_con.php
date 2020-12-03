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
			$PRODENTC_DATA = reverse_date($_POST['PRODENTC_DATA']);
			$PRODENTC_PRODUTO = $_POST['PRODENTC_PRODUTO'];
			$PRODENTC_FORNEC = $_POST['PRODENTC_FORNEC'];
			$PRODENTC_VALOR = moeda($_POST['PRODENTC_VALOR']);
			$PRODENTC_QTDE = $_POST['PRODENTC_QTDE'];
			$sql = mysql_query("insert into TAB_ADM_ENTRADAS_CON (PRODENTC_DATA, PRODENTC_PRODUTO, PRODENTC_FORNEC, PRODENTC_VALOR, PRODENTC_QTDE) values ('$PRODENTC_DATA', '$PRODENTC_PRODUTO', '$PRODENTC_FORNEC', '$PRODENTC_VALOR', '$PRODENTC_QTDE');", $db) or die(mysql_error());
			$sqlConsultEstoque = mysql_query("select MATCONS_ESTOQUE_ATUAL from TAB_ADM_MATCONSUMO where MATCONS_ID = '$PRODENTC_PRODUTO';", $db);
			$vetorConsultEstoque=mysql_fetch_array($sqlConsultEstoque);
			$MATCONS_ESTOQUE_ATUAL = $vetorConsultEstoque['MATCONS_ESTOQUE_ATUAL'] + $PRODENTC_QTDE;
			$sql = mysql_query("update TAB_ADM_MATCONSUMO set MATCONS_ESTOQUE_ATUAL = '$MATCONS_ESTOQUE_ATUAL' where MATCONS_ID = '$PRODENTC_PRODUTO';", $db) or die(mysql_error());
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_entradaprod_con.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>