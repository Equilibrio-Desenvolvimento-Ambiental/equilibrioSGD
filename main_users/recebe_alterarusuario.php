<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 1;
	session_start();
	if($_SESSION['nivel'] != 1) {
		echo"Você não tem permissão para ficar nesta area ".$_SESSION['nome'];
		echo ". Esta é uma área restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
			$num_permissao = mysql_num_rows($sql_permissao);
				if ($num_permissao == 0) {
					echo "Esta área é restrita. Clique ";
					echo "<a href=\"../index.html\">aqui</a>";
					echo " para fazer o LOGIN.";
					exit;
				} else {
					$id = $_GET['id'];
					$nomeUsuario = $_POST['nomeUsuario'];
					$loginUsuario = $_POST['loginUsuario'];
					$senhaUsuario = $_POST['senhaUsuario'];
					$nivelUsuario = $_POST['nivelUsuario'];
					$ativoUsuario = $_POST['ativoUsuario'];
					$sql = mysql_query("update TAB_MAIN_USERS set NOME='$nomeUsuario', USUARIO='$loginUsuario', SENHA='$senhaUsuario', NIVEL='$nivelUsuario', ATIVO='$ativoUsuario' where id_user = '$id';", $db) or die(mysql_error());
					$x = $_POST['permissoesUsuario'];
					$i = 0;
					foreach($x as &$key){
						$permissoes = $_POST['permissoesUsuario'][$i];
						$sql_permissoes_cad = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$permissoes' and ID_USER = '$id'", $db);
						if(mysql_num_rows($sql_permissoes_cad) == 1){
							//nao faz nada
						} else {
							$sql_permissoes = mysql_query("insert into TAB_MAIN_USERS_PROJECTS (ID_USER, ID_PROJETO) VALUES ('$id', '$permissoes')", $db);
						}
						$i++;
					}
		/*
					echo"<script language=\"JavaScript\">
						alert('Alterado com sucesso!');
						</script>";
		*/			
					echo"<script language=\"JavaScript\">
						location.href=\"listarusuarios.php\";
						</script>";
			}
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>