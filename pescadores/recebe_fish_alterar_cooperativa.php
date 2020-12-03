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
			function moeda($get_valor) { 
                $source = array('.', ',');  
                $replace = array('', '.'); 
                $valor = str_replace($source, $replace, $get_valor);
                return $valor;
			}

			$id_familia = $_GET['id_familia'];
			$FISH_COOP_ID = $_GET['FISH_COOP_ID'];

			$FISH_COOP_QUEST = mb_convert_case($_POST['FISH_COOP_QUEST'], MB_CASE_UPPER, 'UTF-8');
			$FISH_COOP_NUMNESA = mb_convert_case($_POST['FISH_COOP_NUMNESA'], MB_CASE_UPPER, 'UTF-8');
			$FISH_COOP_NUMFAMSIS = mb_convert_case($_POST['FISH_COOP_NUMFAMSIS'], MB_CASE_UPPER, 'UTF-8');
			$FISH_COOP_ENTREVISTA = $_POST['FISH_COOP_ENTREVISTA'];
			$FISH_COOP_LOCENTREVISTA = mb_convert_case($_POST['FISH_COOP_LOCENTREVISTA'], MB_CASE_UPPER, 'UTF-8');
			$FISH_COOP_ATIVPRINCIPAL = $_POST['FISH_COOP_ATIVPRINCIPAL'];
			$FISH_COOP_ATIVSECUNDARIA = $_POST['FISH_COOP_ATIVSECUNDARIA'];
			$FISH_COOP_ATIVPESCA = $_POST['FISH_COOP_ATIVPESCA'];
			$FISH_COOP_ATIVPESCATEMPO = $_POST['FISH_COOP_ATIVPESCATEMPO'];
			$FISH_COOP_ATIVPESCAUNIT = $_POST['FISH_COOP_ATIVPESCAUNIT'];
			$FISH_COOP_ATIVPESCATIPO = $_POST['FISH_COOP_ATIVPESCATIPO'];
			$FISH_COOP_PROJETONESA = $_POST['FISH_COOP_PROJETONESA'];
			$FISH_COOP_OUTRASRENDAS = $_POST['FISH_COOP_OUTRASRENDAS'];
			$FISH_COOP_BENEFSOCIAIS = $_POST['FISH_COOP_BENEFSOCIAIS'];
			$FISH_COOP_AGRICULTURA = $_POST['FISH_COOP_AGRICULTURA'];
			$FISH_COOP_AGRICCOMERCIO = $_POST['FISH_COOP_AGRICCOMERCIO'];
			$FISH_COOP_AGRICPESSOAS = $_POST['FISH_COOP_AGRICPESSOAS'];
			$FISH_COOP_AGRICAREA = moeda($_POST['FISH_COOP_AGRICAREA']);
			$FISH_COOP_AGRICUNIT = $_POST['FISH_COOP_AGRICUNIT'];
			$FISH_COOP_AGRICDESCRICAO = mb_convert_case($_POST['FISH_COOP_AGRICDESCRICAO'], MB_CASE_UPPER, 'UTF-8');
			$FISH_COOP_CONSUMOPEIXE = $_POST['FISH_COOP_CONSUMOPEIXE'];
			$FISH_COOP_OBSERVACOES = mb_convert_case($_POST['FISH_COOP_OBSERVACOES'], MB_CASE_UPPER, 'UTF-8');			

			$comandoSql = "UPDATE TAB_FISH_COOP_ENTREVISTA SET FISH_COOP_QUEST = '$FISH_COOP_QUEST', FISH_COOP_ENTREVISTA = '$FISH_COOP_ENTREVISTA', FISH_COOP_LOCENTREVISTA = '$FISH_COOP_LOCENTREVISTA', FISH_COOP_NUMNESA = '$FISH_COOP_NUMNESA', FISH_COOP_NUMFAMSIS = '$FISH_COOP_NUMFAMSIS', FISH_COOP_ATIVPRINCIPAL = '$FISH_COOP_ATIVPRINCIPAL', FISH_COOP_ATIVSECUNDARIA = '$FISH_COOP_ATIVSECUNDARIA', FISH_COOP_ATIVPESCA = '$FISH_COOP_ATIVPESCA', FISH_COOP_ATIVPESCATEMPO = '$FISH_COOP_ATIVPESCATEMPO', FISH_COOP_ATIVPESCAUNIT = '$FISH_COOP_ATIVPESCAUNIT', FISH_COOP_ATIVPESCATIPO = '$FISH_COOP_ATIVPESCATIPO', FISH_COOP_PROJETONESA = '$FISH_COOP_PROJETONESA', FISH_COOP_OUTRASRENDAS = '$FISH_COOP_OUTRASRENDAS', FISH_COOP_BENEFSOCIAIS = '$FISH_COOP_BENEFSOCIAIS', FISH_COOP_AGRICULTURA = '$FISH_COOP_AGRICULTURA', FISH_COOP_AGRICCOMERCIO = '$FISH_COOP_AGRICCOMERCIO', FISH_COOP_AGRICAREA = '$FISH_COOP_AGRICAREA', FISH_COOP_AGRICUNIT = '$FISH_COOP_AGRICUNIT', FISH_COOP_AGRICPESSOAS = '$FISH_COOP_AGRICPESSOAS', FISH_COOP_AGRICDESCRICAO = '$FISH_COOP_AGRICDESCRICAO', FISH_COOP_CONSUMOPEIXE = '$FISH_COOP_CONSUMOPEIXE', FISH_COOP_OBSERVACOES = '$FISH_COOP_OBSERVACOES', ";

			if(!empty($_POST['FISH_COOP_DTENTREVISTA'])){
				$FISH_COOP_DTENTREVISTA = reverse_date($_POST['FISH_COOP_DTENTREVISTA']);
				$comandoSql = $comandoSql." FISH_COOP_DTENTREVISTA = '$FISH_COOP_DTENTREVISTA' ";
			} else {
				$comandoSql = $comandoSql." FISH_COOP_DTENTREVISTA = NULL ";
			}			

			$comandoSql = $comandoSql." WHERE FISH_COOP_ID = '$FISH_COOP_ID' AND FISH_FAM_ID = '$id_familia';";
//			echo $comandoSql;
			$sql = mysql_query($comandoSql, $db) or die(mysql_error());
			
			$vet_COOP_PROJUHE = $_POST['FISH_COOUHE_PROJETO'];
			$cont_COOP_PROJUHE = 0;
			foreach((array)$vet_COOP_PROJUHE as $vet_COOP_PROJUHEkey){
				$FISH_COOUHE_PROJETO = $_POST['FISH_COOUHE_PROJETO'][$cont_COOP_PROJUHE];
				if(!$FISH_COOUHE_PROJETO == 0){
					$sql_consulta_COOP_PROJUHE = mysql_query("SELECT FISH_COOUHE_ID FROM TAB_FISH_COOP_PROJUHE WHERE FISH_COOP_ID = '$FISH_COOP_ID' AND FISH_COOUHE_PROJETO = '$FISH_COOUHE_PROJETO';", $db) or die(mysql_error());
					$num_COOP_PROJUHE = mysql_num_rows($sql_consulta_COOP_PROJUHE);
					if($num_COOP_PROJUHE == 0) {
						$sql_insert_COOP_PROJUHE = mysql_query("INSERT INTO TAB_FISH_COOP_PROJUHE (FISH_COOP_ID, FISH_COOUHE_PROJETO) VALUES ('$FISH_COOP_ID', '$FISH_COOUHE_PROJETO')", $db) or die(mysql_error());
					}
				}
				$cont_COOP_PROJUHE++;
			}

			$vet_COOP_DESPESAS = $_POST['FISH_COODES_DESPESA'];
			$cont_COOP_DESPESAS = 0;
			foreach((array)$vet_COOP_DESPESAS as $vet_COOP_DESPESASkey){
				$FISH_COODES_DESPESA = $_POST['FISH_COODES_DESPESA'][$cont_COOP_DESPESAS];
				$FISH_COODES_VALOR = moeda($_POST['FISH_COODES_VALOR'][$cont_COOP_DESPESAS]);
				if(!$FISH_COODES_DESPESA == 0){
					if($FISH_COODES_VALOR > 0) {
						$sql_consulta_COOP_DESPESAS = mysql_query("SELECT FISH_COODES_ID FROM TAB_FISH_COOP_DESPESAS WHERE FISH_COOP_ID = '$FISH_COOP_ID' AND FISH_COODES_DESPESA = '$FISH_COODES_DESPESA' AND FISH_COODES_VALOR = '$FISH_COODES_VALOR';", $db) or die(mysql_error());
						$num_COOP_DESPESAS = mysql_num_rows($sql_consulta_COOP_DESPESAS);
						if($num_COOP_DESPESAS == 0) {
							$sql_insert_COOP_DESPESAS = mysql_query("INSERT INTO TAB_FISH_COOP_DESPESAS (FISH_COOP_ID, FISH_COODES_DESPESA, FISH_COODES_VALOR) VALUES ('$FISH_COOP_ID', '$FISH_COODES_DESPESA', '$FISH_COODES_VALOR')", $db) or die(mysql_error());
						}
					}
				}
				$cont_COOP_DESPESAS++;
			}

			$vet_COOP_OUTRASRENDAS = $_POST['FISH_COOREN_COMPONENTE'];
			$cont_COOP_OUTRASRENDAS = 0;
			foreach((array)$vet_COOP_OUTRASRENDAS as $vet_COOP_OUTRASRENDASkey){
				$FISH_COOREN_COMPONENTE = $_POST['FISH_COOREN_COMPONENTE'][$cont_COOP_OUTRASRENDAS];
				$FISH_COOREN_OCUPACAO = $_POST['FISH_COOREN_OCUPACAO'][$cont_COOP_OUTRASRENDAS];
				$FISH_COOREN_RENDA = moeda($_POST['FISH_COOREN_RENDA'][$cont_COOP_OUTRASRENDAS]);
				if(!$FISH_COOREN_COMPONENTE == 0){
					if(!$FISH_COOREN_OCUPACAO == 0){
						$sql_consulta_COOP_OUTRASRENDAS = mysql_query("SELECT FISH_COOREN_ID FROM TAB_FISH_COOP_OUTRASRENDAS WHERE FISH_COOP_ID = '$FISH_COOP_ID' AND FISH_COOREN_COMPONENTE = '$FISH_COOREN_COMPONENTE' AND FISH_COOREN_OCUPACAO = '$FISH_COOREN_OCUPACAO' AND FISH_COOREN_RENDA = '$FISH_COOREN_RENDA';", $db) or die(mysql_error());
						$num_COOP_OUTRASRENDAS = mysql_num_rows($sql_consulta_COOP_OUTRASRENDAS);
						if($num_COOP_OUTRASRENDAS == 0) {
							$sql_insert_COOP_OUTRASRENDAS = mysql_query("INSERT INTO TAB_FISH_COOP_OUTRASRENDAS (FISH_COOP_ID, FISH_COOREN_COMPONENTE, FISH_COOREN_OCUPACAO, FISH_COOREN_RENDA) VALUES ('$FISH_COOP_ID', '$FISH_COOREN_COMPONENTE', '$FISH_COOREN_OCUPACAO', '$FISH_COOREN_RENDA')", $db) or die(mysql_error());
						}
					}
				}
				$cont_COOP_OUTRASRENDAS++;
			}

			$vet_COOP_BENEFICIOS = $_POST['FISH_COOBEN_COMPONENTE'];
			$cont_COOP_BENEFICIOS = 0;
			foreach((array)$vet_COOP_BENEFICIOS as $vet_COOP_BENEFICIOSkey){
				$FISH_COOBEN_COMPONENTE = $_POST['FISH_COOBEN_COMPONENTE'][$cont_COOP_BENEFICIOS];
				$FISH_COOBEN_BENEFICIO = $_POST['FISH_COOBEN_BENEFICIO'][$cont_COOP_BENEFICIOS];
				$FISH_COOBEN_RENDA = moeda($_POST['FISH_COOBEN_RENDA'][$cont_COOP_BENEFICIOS]);
				if(!$FISH_COOBEN_COMPONENTE == 0){
					if(!$FISH_COOBEN_BENEFICIO == 0){
						$sql_consulta_COOP_BENEFICIOS = mysql_query("SELECT FISH_COOBEN_ID FROM TAB_FISH_COOP_BENEFICIOS WHERE FISH_COOP_ID = '$FISH_COOP_ID' AND FISH_COOBEN_COMPONENTE = '$FISH_COOBEN_COMPONENTE' AND FISH_COOBEN_BENEFICIO = '$FISH_COOBEN_BENEFICIO' AND FISH_COOBEN_RENDA = '$FISH_COOBEN_RENDA';", $db) or die(mysql_error());
						$num_COOP_BENEFICIOS = mysql_num_rows($sql_consulta_COOP_BENEFICIOS);
						if($num_COOP_BENEFICIOS == 0) {
							$sql_insert_COOP_BENEFICIOS = mysql_query("INSERT INTO TAB_FISH_COOP_BENEFICIOS (FISH_COOP_ID, FISH_COOBEN_COMPONENTE, FISH_COOBEN_BENEFICIO, FISH_COOBEN_RENDA) VALUES ('$FISH_COOP_ID', '$FISH_COOBEN_COMPONENTE', '$FISH_COOBEN_BENEFICIO', '$FISH_COOBEN_RENDA')", $db) or die(mysql_error());
						}
					}
				}
				$cont_COOP_BENEFICIOS++;
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