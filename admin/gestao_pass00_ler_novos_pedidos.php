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
			//Lê todos os Itens Planejados
			$sqlPlanMatCon = mysql_query("SELECT DISTINCT PLAN_VISIT_ID FROM TAB_415421_PLANMAT_CONSUMO ORDER BY PLAN_VISIT_ID;", $db);
			$sqlPlanMatKit = mysql_query("SELECT DISTINCT PLAN_VISIT_ID FROM TAB_415421_PLANMAT_KITS ORDER BY PLAN_VISIT_ID;", $db);
			$sqlPlanMatUso = mysql_query("SELECT DISTINCT PLAN_VISIT_ID FROM TAB_415421_PLANMAT_USO ORDER BY PLAN_VISIT_ID;", $db);
			//Vai correr todos os Itens Planejados...
			while ($vetorPlanMatCon=mysql_fetch_array($sqlPlanMatCon)) {
				$idVisitaCon = $vetorPlanMatCon['PLAN_VISIT_ID'];
				//Lê a tabela dos Pedidos para ver se o Item Planejado já foi inserido...
				$sqlCheckNewCon = mysql_query("SELECT PEDIDO_ID FROM TAB_ADM_PEDIDOS WHERE PEDIDO_VISITA = '$idVisitaCon';", $db);
				$qtdeCheckNewCon = mysql_num_rows($sqlCheckNewCon);
				//Não encontrou nenhum, necessário incluir...
				if ($qtdeCheckNewCon == 0) {
					//Ler dados da Visita/Planejamento, para inserir como PEDIDO...
					$sqlReadPlanDataCon = mysql_query("SELECT * FROM TAB_415421_PLANVISITAS WHERE PLAN_VISIT_ID = '$idVisitaCon';", $db);
					$vetorReadPlanDataCon = mysql_fetch_array($sqlReadPlanDataCon);
					$PEDIDO_VISITA = $vetorReadPlanDataCon['PLAN_VISIT_ID'];
					$PEDIDO_TECNICO = $vetorReadPlanDataCon['PLAN_VISIT_TECNICO'];
					$PEDIDO_DTLIM_COMPRA = reverse_date(date('d/m/Y', strtotime($vetorReadPlanDataCon['PLAN_VISIT_PREVISAO'].'-3 days')));
					$PEDIDO_DTLIM_PREP = reverse_date(date('d/m/Y', strtotime($vetorReadPlanDataCon['PLAN_VISIT_PREVISAO'].'-2 days')));
					$PEDIDO_DTLIM_ENTR = reverse_date(date('d/m/Y', strtotime($vetorReadPlanDataCon['PLAN_VISIT_PREVISAO'].'-1 days')));
					$PEDIDO_DTLIM_VISIT = $vetorReadPlanDataCon['PLAN_VISIT_PREVISAO'];
					$sqlInsertNewCon = mysql_query("INSERT INTO TAB_ADM_PEDIDOS(PEDIDO_VISITA, PEDIDO_STATUS, PEDIDO_TECNICO, PEDIDO_DTLIM_COMPRA, PEDIDO_DTLIM_PREP, PEDIDO_DTLIM_ENTR, PEDIDO_DTLIM_VISIT) VALUES ('$PEDIDO_VISITA', '1', '$PEDIDO_TECNICO', '$PEDIDO_DTLIM_COMPRA', '$PEDIDO_DTLIM_PREP', '$PEDIDO_DTLIM_ENTR', '$PEDIDO_DTLIM_VISIT');", $db) or die(mysql_error());
				//Encontrou, não é necessário incluir...
				} else { }			
			}
			while ($vetorPlanMatKit=mysql_fetch_array($sqlPlanMatKit)) {
				$idVisitaKit = $vetorPlanMatKit['PLAN_VISIT_ID'];
				//Lê a tabela dos Pedidos para ver se o Item Planejado já foi inserido...
				$sqlCheckNewKit = mysql_query("SELECT PEDIDO_ID FROM TAB_ADM_PEDIDOS WHERE PEDIDO_VISITA = '$idVisitaKit';", $db);
				$qtdeCheckNewKit = mysql_num_rows($sqlCheckNewKit);
				//Não encontrou nenhum, necessário incluir...
				if ($qtdeCheckNewKit == 0) {
					//Ler dados da Visita/Planejamento, para inserir como PEDIDO...
					$sqlReadPlanDataKit = mysql_query("SELECT * FROM TAB_415421_PLANVISITAS WHERE PLAN_VISIT_ID = '$idVisitaKit';", $db);
					$vetorReadPlanDataKit = mysql_fetch_array($sqlReadPlanDataKit);
					$PEDIDO_VISITA = $vetorReadPlanDataKit['PLAN_VISIT_ID'];
					$PEDIDO_TECNICO = $vetorReadPlanDataKit['PLAN_VISIT_TECNICO'];
					$PEDIDO_DTLIM_COMPRA = reverse_date(date('d/m/Y', strtotime($vetorReadPlanDataKit['PLAN_VISIT_PREVISAO'].'-3 days')));
					$PEDIDO_DTLIM_PREP = reverse_date(date('d/m/Y', strtotime($vetorReadPlanDataKit['PLAN_VISIT_PREVISAO'].'-2 days')));
					$PEDIDO_DTLIM_ENTR = reverse_date(date('d/m/Y', strtotime($vetorReadPlanDataKit['PLAN_VISIT_PREVISAO'].'-1 days')));
					$PEDIDO_DTLIM_VISIT = $vetorReadPlanDataKit['PLAN_VISIT_PREVISAO'];
					$sqlInsertNewKit = mysql_query("INSERT INTO TAB_ADM_PEDIDOS(PEDIDO_VISITA, PEDIDO_STATUS, PEDIDO_TECNICO, PEDIDO_DTLIM_COMPRA, PEDIDO_DTLIM_PREP, PEDIDO_DTLIM_ENTR, PEDIDO_DTLIM_VISIT) VALUES ('$PEDIDO_VISITA', '1', '$PEDIDO_TECNICO', '$PEDIDO_DTLIM_COMPRA', '$PEDIDO_DTLIM_PREP', '$PEDIDO_DTLIM_ENTR', '$PEDIDO_DTLIM_VISIT');", $db) or die(mysql_error());
				//Encontrou, não é necessário incluir...
				} else { }			
			}			
			while ($vetorPlanMatUso=mysql_fetch_array($sqlPlanMatUso)) {
				$idVisitaUso = $vetorPlanMatUso['PLAN_VISIT_ID'];
				//Lê a tabela dos Pedidos para ver se o Item Planejado já foi inserido...
				$sqlCheckNewUso = mysql_query("SELECT PEDIDO_ID FROM TAB_ADM_PEDIDOS WHERE PEDIDO_VISITA = '$idVisitaUso';", $db);
				$qtdeCheckNewUso = mysql_num_rows($sqlCheckNewUso);
				//Não encontrou nenhum, necessário incluir...
				if ($qtdeCheckNewUso == 0) {
					//Ler dados da Visita/Planejamento, para inserir como PEDIDO...
					$sqlReadPlanDataUso = mysql_query("SELECT * FROM TAB_415421_PLANVISITAS WHERE PLAN_VISIT_ID = '$idVisitaUso';", $db);
					$vetorReadPlanDataUso = mysql_fetch_array($sqlReadPlanDataUso);
					$PEDIDO_VISITA = $vetorReadPlanDataUso['PLAN_VISIT_ID'];
					$PEDIDO_TECNICO = $vetorReadPlanDataUso['PLAN_VISIT_TECNICO'];
					$PEDIDO_DTLIM_COMPRA = reverse_date(date('d/m/Y', strtotime($vetorReadPlanDataUso['PLAN_VISIT_PREVISAO'].'-3 days')));
					$PEDIDO_DTLIM_PREP = reverse_date(date('d/m/Y', strtotime($vetorReadPlanDataUso['PLAN_VISIT_PREVISAO'].'-2 days')));
					$PEDIDO_DTLIM_ENTR = reverse_date(date('d/m/Y', strtotime($vetorReadPlanDataUso['PLAN_VISIT_PREVISAO'].'-1 days')));
					$PEDIDO_DTLIM_VISIT = $vetorReadPlanDataUso['PLAN_VISIT_PREVISAO'];
					$sqlInsertNewUso = mysql_query("INSERT INTO TAB_ADM_PEDIDOS(PEDIDO_VISITA, PEDIDO_STATUS, PEDIDO_TECNICO, PEDIDO_DTLIM_COMPRA, PEDIDO_DTLIM_PREP, PEDIDO_DTLIM_ENTR, PEDIDO_DTLIM_VISIT) VALUES ('$PEDIDO_VISITA', '1', '$PEDIDO_TECNICO', '$PEDIDO_DTLIM_COMPRA', '$PEDIDO_DTLIM_PREP', '$PEDIDO_DTLIM_ENTR', '$PEDIDO_DTLIM_VISIT');", $db) or die(mysql_error());
				//Encontrou, não é necessário incluir...
				} else { }			
			}			
		/*
				echo"<script language=\"JavaScript\">
					alert('Excluido com sucesso!');
					</script>";
		*/		
				echo"<script language=\"JavaScript\">
					location.href=\"gestao_saidaprod.php\";
					</script>";
		}
	}
?>
<?php require_once("includes/header-recebe.php");?>