﻿<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 3;
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

			function reverse_date( $date )
					{
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
					}
 		
			$ATIV_DATA = reverse_date($_POST['ATIV_DATA']);
			$ATIV_PARTICIPANTES = $_POST['ATIV_PARTICIPANTES'];
			$ATIV_RUC = $_POST['ATIV_RUC'];
			$ATIV_PERIODO = $_POST['ATIV_PERIODO'];
			$ATIV_EVENTO = $_POST['ATIV_EVENTO'];
			$ATIV_ATIVIDADE = $_POST['ATIV_ATIVIDADE'];
			$ATIV_DESCRICAO = $_POST['ATIV_DESCRICAO'];
			$ATIV_PERCEPCAO = $_POST['ATIV_PERCEPCAO'];
			
			$diretorio = "imagens/";
					
			$sql = mysql_query("insert into TAB_444_ATIV_SC (ATIVSC_DATA, ATIVSC_PARTICIPANTES, ATIVSC_RUC, ATIVSC_PERIODO, ATIVSC_EVENTO, ATIVSC_ATIVIDADE, ATIVSC_DESCRICAO, ATIVSC_PERCEPCOES) VALUES ('$ATIV_DATA', '$ATIV_PARTICIPANTES', '$ATIV_RUC', '$ATIV_PERIODO', '$ATIV_EVENTO', '$ATIV_ATIVIDADE', '$ATIV_DESCRICAO', '$ATIV_PERCEPCAO')", $db) or die(mysql_error());
			
			$id_gerado = mysql_insert_id();
			
			$vet_TECNICOS = $_POST['ATIV_TECNICOS'];
			$cont_TECNICOS = 0;
			foreach((array)$vet_TECNICOS as $vet_TECNICOSkey){
				$tecnico = $_POST['ATIV_TECNICOS'][$cont_TECNICOS];
				$sql_TECNICOS = mysql_query("insert into TAB_444_ATIV_SC_TEC (ATIVSC_CODIGO, TECATIVSC_TECNICO) values ('$id_gerado', '$tecnico')", $db);
				$cont_TECNICOS++;
			}
			
			$vet_ENTIDINST = $_POST['ATIV_ENTIDINST'];
			$cont_ENTIDINST = 0;
			foreach((array)$vet_ENTIDINST as $vet_ENTIDINSTkey){
				$entidade = $_POST['ATIV_ENTIDINST'][$cont_ENTIDINST];
				$sql_ENTIDINST = mysql_query("insert into TAB_444_ATIV_SC_PART (ATIVSC_CODIGO, PARTATIVSC_PARTICIPANTE) values ('$id_gerado', '$entidade')", $db);
				$cont_ENTIDINST++;
			}
			
			$vet_PERCEPCOES = $_POST['ATIV_PERCEPCOES'];
			$cont_PERCEPCOES = 0;
			foreach((array)$vet_PERCEPCOES as $vet_PERCEPCOESkey){
				$percepcao = $_POST['ATIV_PERCEPCOES'][$cont_PERCEPCOES];
				$sql_PERCEPCOES = mysql_query("insert into TAB_444_ATIV_SC_PERCEP (ATIVSC_CODIGO, PERCEPATIVSC_PERCEP) values ('$id_gerado', '$percepcao')", $db);
				$cont_PERCEPCOES++;
			}
			
			$vet_LEGENDAS = $_POST['ATIV_LEGENDAS'];
			$cont_LEGENDAS = 0;
			foreach((array)$vet_LEGENDAS as $vet_LEGENDASkey){
				$legenda = $_POST['ATIV_LEGENDAS'][$cont_LEGENDAS];
				$nome = $_FILES['ATIV_IMAGENS']['name'][$cont_LEGENDAS];
				$tmp = $_FILES['ATIV_IMAGENS']['tmp_name'][$cont_LEGENDAS];
				$ext = substr($nome, -4, 4); // vai retornar a extensão final do arquivo ex: ".png"
				$newnome = date("Ymdhis");
				$extensao = explode(".",$nome);
				$fotonome = $extensao[0].$newnome;
				$retiraacentos = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($fotonome)));
				$nomefoto = $retiraacentos.$ext;
				$upload = $diretorio.$retiraacentos.$ext;		
				move_uploaded_file($tmp, "$diretorio"."$nomefoto");
				$sql_IMAGENS = mysql_query("insert into TAB_444_ATIV_SC_IMAGENS (ATIVSC_CODIGO, IMGATIVSC_NOME, IMGATIVSC_LEGENDA) values ('$id_gerado', '$nomefoto', '$legenda')", $db);
				$cont_LEGENDAS++;
			}
		/*
			echo"<script language=\"JavaScript\">
				alert('Inserido com sucesso!');
				</script>";
		*/				
			echo"<script language=\"JavaScript\">
				location.href=\"listar_ativ_sc.php\";
				</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>