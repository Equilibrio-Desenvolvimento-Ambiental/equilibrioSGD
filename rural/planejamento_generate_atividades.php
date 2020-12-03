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
			$rgme = $_POST['rgme'];
			$sql_RGME = mysql_query("select ID from TAB_APOIO_RGME where ID = '$rgme' and VISITAS_GERADAS = '2';", $db);
			$qtde_busca_RGME = mysql_num_rows($sql_RGME);
			if ($qtde_busca_RGME == 0) {
				echo"<script language=\"JavaScript\">
						alert('O período do Relatório escolhido já teve suas visitas geradas neste sistema!');
					</script>";
				echo"<script language=\"JavaScript\">
						location.href=\"planejamento_select_atividades.php\";
					</script>";
			} else {
				$sql_RGME = mysql_query("select * from TAB_APOIO_RGME where ID = '$rgme';", $db);
				$vetor_RGME = mysql_fetch_array($sql_RGME);
				$data_prevista_inicial = $vetor_RGME['DATA_INICIAL'];
				$data_prevista_final = $vetor_RGME['DATA_FINAL'];
				$sql_TECNICOS = mysql_query("SELECT DISTINCT TAB_APOIO_TECNICOS.ID AS TECNICO_ID, TAB_APOIO_TECNICOS.DESCRICAO AS TECNICO_NOME FROM TAB_APOIO_TECNICOS LEFT  OUTER JOIN TAB_415421_FAMILIAS ON TAB_415421_FAMILIAS.FAMILIA_TECNICO = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_415421_DADOSGERAIS ON  TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO WHERE (TAB_415421_DADOSGERAIS.DADOS_ATEND421 = 1 OR TAB_415421_DADOSGERAIS.DADOS_ATEND415 = 1 OR TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = 1) ORDER BY TAB_APOIO_TECNICOS.ID ASC;", $db);
                while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) {
					$tecnico = $vetor_TECNICOS['TECNICO_ID'];
					$sql_FAMILIAS = mysql_query("SELECT DISTINCT TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_415421_FAMILIAS.FAMILIA_GRUPO FROM TAB_415421_FAMILIAS LEFT OUTER JOIN TAB_415421_DADOSGERAIS ON TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO WHERE (TAB_415421_DADOSGERAIS.DADOS_ATEND421 = 1 OR TAB_415421_DADOSGERAIS.DADOS_ATEND415 = 1 OR TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = 1) AND TAB_415421_FAMILIAS.FAMILIA_TECNICO = $tecnico ORDER BY TAB_415421_FAMILIAS.FAMILIA_GRUPO, TAB_415421_FAMILIAS.FAMILIA_CODIGO ASC;", $db);
					while ($vetor_FAMILIAS=mysql_fetch_array($sql_FAMILIAS)) {
						$familia = $vetor_FAMILIAS['FAMILIA_CODIGO'];
						$grupo = $vetor_FAMILIAS['FAMILIA_GRUPO'];
						if($grupo == 1){
							$data_prevista = $data_prevista_inicial;
						} elseif ($grupo == 2) {
							$data_prevista = reverse_date(date('d/m/Y', strtotime($data_prevista_inicial.'+7 days')));
						} elseif ($grupo == 3) {
							$data_prevista = reverse_date(date('d/m/Y', strtotime($data_prevista_inicial.'+14 days')));
						} elseif ($grupo == 4) {
							$data_prevista = reverse_date(date('d/m/Y', strtotime($data_prevista_inicial.'+21 days')));
						} else {
							$data_prevista = $data_prevista_inicial;
						}
						$insert_VISITAS = mysql_query("insert into TAB_415421_PLANVISITAS (PLAN_VISIT_FAMILIA, PLAN_VISIT_TECNICO, PLAN_VISIT_GRUPO, PLAN_VISIT_RGME, PLAN_VISIT_PREVISAO, PLAN_VISIT_CONCLUIDA) values ('$familia', '$tecnico', '$grupo', '$rgme', '$data_prevista', '2');", $db);
					}
				}
				$sql_ESPECIAIS = mysql_query("select * from TAB_415421_FAMESPECIAIS ORDER BY FAMESP_FAMILIA, FAMESP_GRUPO asc;", $db);
                while ($vetor_ESPECIAIS=mysql_fetch_array($sql_ESPECIAIS)) {
					$familia = $vetor_ESPECIAIS['FAMESP_FAMILIA'];
					$tecnico = $vetor_ESPECIAIS['FAMESP_TECNICO'];
					$grupo = $vetor_ESPECIAIS['FAMESP_GRUPO'];
					if($grupo == 1){
						$data_prevista = $data_prevista_inicial;
					} elseif ($grupo == 2) {
						$data_prevista = reverse_date(date('d/m/Y', strtotime($data_prevista_inicial.'+7 days')));
					} elseif ($grupo == 3) {
						$data_prevista = reverse_date(date('d/m/Y', strtotime($data_prevista_inicial.'+14 days')));
					} elseif ($grupo == 4) {
						$data_prevista = reverse_date(date('d/m/Y', strtotime($data_prevista_inicial.'+21 days')));
					} else {
						$data_prevista = $data_prevista_inicial;
					}
					$insert_VISITAS = mysql_query("insert into TAB_415421_PLANVISITAS (PLAN_VISIT_FAMILIA, PLAN_VISIT_TECNICO, PLAN_VISIT_GRUPO, PLAN_VISIT_RGME, PLAN_VISIT_PREVISAO, PLAN_VISIT_CONCLUIDA) values ('$familia', '$tecnico', '$grupo', '$rgme', '$data_prevista', '2');", $db);
				}
				$update_RGME = mysql_query("update TAB_APOIO_RGME set VISITAS_GERADAS=1 where ID = '$rgme';", $db);
				echo"<script language=\"JavaScript\">
					alert('Visitas geradas com sucesso!');
					</script>";
				echo"<script language=\"JavaScript\">
					location.href=\"planejamento_select_atividades.php\";
					</script>";
			}}}
?>
<?php require_once("includes/header-recebe.php");?>