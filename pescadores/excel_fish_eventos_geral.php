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
			$tabela = '<table border=1>';
			$tabela .= '<thead>';
			$tabela .= '<tr>';
			$tabela .= '<th align="center"><b>Código</b></th>';
			$tabela .= '<th align="center"><b>Nome do Chefe da Família</b></th>';
			$tabela .= '<th align="center"><b>Nome do Cônjuge</b></th>';
			$tabela .= '<th align="center"><b>Possuí Endereço Urbano?</b></th>';
			$tabela .= '<th align="center"><b>Endereço Urbano</b></th>';
			$tabela .= '<th align="center"><b>Bairro</b></th>';
			$tabela .= '<th align="center"><b>Município</b></th>';
			$tabela .= '<th align="center"><b>Possuí Endereço Rural?</b></th>';
			$tabela .= '<th align="center"><b>Endereço Rural</b></th>';
			$tabela .= '<th align="center"><b>Localidade</b></th>';
			$tabela .= '<th align="center"><b>Município</b></th>';
			$tabela .= '<th align="center"><b>Evento - Data</b></th>';
			$tabela .= '<th align="center"><b>Evento - Tipo</b></th>';
			$tabela .= '<th align="center"><b>Evento - Resumo</b></th>';
			$tabela .= '<th align="center"><b>Evento - Técnico(s)</b></th>';
			$tabela .= '<th align="center"><b>Ação - Atividade</b></th>';
			$tabela .= '<th align="center"><b>Ação - Sub-Atividade</b></th>';
			$tabela .= '<th align="center"><b>Ação - Descrição</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME, TAB_APOIO_BOOLEANO_ENDURB.DESCRICAO AS FISH_FAM_ENDURB, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_LOGR, TAB_APOIO_BAIRROS.DESCRICAO AS  FISH_FAM_ENDURB_LOCAL, TAB_APOIO_MUNICIPIOS_URB.DESCRICAO AS FISH_FAM_ENDURB_MUNIC, TAB_APOIO_BOOLEANO_ENDRUR.DESCRICAO AS FISH_FAM_ENDRUR, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOGR, TAB_APOIO_LOCALIDADES.DESCRICAO AS FISH_FAM_ENDRUR_LOCAL, TAB_APOIO_MUNICIPIOS_RUR.DESCRICAO AS FISH_FAM_ENDRUR_MUNIC, TAB_FISH_EVENTOS.FISH_EVE_DATA, TAB_APOIO_EVENTOS.DESCRICAO AS FISH_EVE_TIPO_DESC, TAB_FISH_EVENTOS.FISH_EVE_OBSERVACOES, VIEW_FISH_EVE_TECNICOS.FISH_EVE_TECNICOS, TAB_APOIO_TPVISITFISH.DESCRICAO AS FISH_EVE_ATIV_PRINC, TAB_APOIO_TPSUBVISITFISH.DESCRICAO AS FISH_EVE_ATIV_SECUND, TAB_FISH_CLASSIFICACAO.FISH_CLASS_DESCRICAO AS FISH_EVE_ATIV_DESCRICAO FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ENDURB ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB = TAB_APOIO_BOOLEANO_ENDURB.ID LEFT OUTER JOIN TAB_APOIO_BAIRROS ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_BAIRRO = TAB_APOIO_BAIRROS.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_URB ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_MUNIC = TAB_APOIO_MUNICIPIOS_URB.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ENDRUR ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR = TAB_APOIO_BOOLEANO_ENDRUR.ID LEFT OUTER JOIN TAB_APOIO_LOCALIDADES ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOCAL = TAB_APOIO_LOCALIDADES.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_RUR ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_MUNIC = TAB_APOIO_MUNICIPIOS_RUR.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_415421 ON TAB_FISH_FAMILIAS.FISH_FAM_LINK_STATUS = TAB_APOIO_BOOLEANO_415421.ID LEFT OUTER JOIN TAB_415421_FAMILIAS ON TAB_415421_FAMILIAS.FAMILIA_CODIGO = TAB_FISH_FAMILIAS.FISH_FAM_LINK_CODIGO LEFT OUTER JOIN TAB_APOIO_BENEFICIOS ON TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID LEFT OUTER JOIN TAB_FISH_EVENTOS ON TAB_FISH_EVENTOS.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_EVENTOS ON TAB_APOIO_EVENTOS.ID = TAB_FISH_EVENTOS.FISH_EVE_TIPO LEFT OUTER JOIN VIEW_FISH_EVE_TECNICOS ON VIEW_FISH_EVE_TECNICOS.FISH_EVE_CODIGO = TAB_FISH_EVENTOS.FISH_EVE_CODIGO LEFT OUTER JOIN TAB_FISH_CLASSIFICACAO ON TAB_FISH_CLASSIFICACAO.FISH_EVE_CODIGO = TAB_FISH_EVENTOS.FISH_EVE_CODIGO LEFT OUTER JOIN TAB_APOIO_TPSUBVISITFISH ON TAB_APOIO_TPSUBVISITFISH.ID = TAB_FISH_CLASSIFICACAO.FISH_CLASS_TIPO LEFT OUTER JOIN TAB_APOIO_TPVISITFISH ON TAB_APOIO_TPVISITFISH.ID = TAB_APOIO_TPSUBVISITFISH.ID_PRINCIPAL ORDER BY TAB_FISH_FAMILIAS.FISH_FAM_ID ASC, TAB_FISH_EVENTOS.FISH_EVE_DATA ASC;", $db); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ID'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CHEFE_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CONJ_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ENDURB'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ENDURB_LOGR'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ENDURB_LOCAL'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ENDURB_MUNIC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ENDRUR'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ENDRUR_LOGR'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ENDRUR_LOCAL'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ENDRUR_MUNIC'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['FISH_EVE_DATA'])).'</td>';
				$tabela .= '<td>'.$vetor['FISH_EVE_TIPO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_EVE_OBSERVACOES'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_EVE_TECNICOS'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_EVE_ATIV_PRINC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_EVE_ATIV_SECUND'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_EVE_ATIV_DESCRICAO'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_fish_eventos_geral.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>