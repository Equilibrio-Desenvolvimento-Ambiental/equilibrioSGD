﻿<?php
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
			$tabela .= '<th align="center"><b>Número Questionário</b></th>';
			$tabela .= '<th align="center"><b>Nome do Chefe da Família</b></th>';
			$tabela .= '<th align="center"><b>Apelido do Chefe da Família</b></th>';
			$tabela .= '<th align="center"><b>Status do Acompanhamento</b></th>';
			$tabela .= '<th align="center"><b>Campanha</b></th>';			
			$tabela .= '<th align="center"><b>Data da Entrevista</b></th>';			
			$tabela .= '<th align="center"><b>B02 - Estava Pescando?</b></th>';
			$tabela .= '<th align="center"><b>B09 - Vendia Parte ou Toda Produção?</b></th>';			
			$tabela .= '<th align="center"><b>B14 - Motivo de Não Estar Pescando</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_PERFILENT.FISH_PERFIL_QUEST, TAB_APOIO_BOOLEANO_STT_EMERG.DESCRICAO AS FISH_FAM_STT_EMERG, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_APELIDO, TAB_APOIO_STATUSATENDFISH.DESCRICAO AS FISH_PERFIL_STATUSATEND_DESC, TAB_FISH_CAMPANHAS.FISH_CAMP_DESCRICAO, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_DT_ENTR_ATUAL, TAB_APOIO_BOOLEANO_ANTES_PESCAVA.DESCRICAO AS PESCAVA, TAB_APOIO_BOOLEANO_ANTES_VENDIA.DESCRICAO AS VENDIA, TAB_APOIO_PESCA_MOTIVO.DESCRICAO AS MOTIVO_DE_NAO_PESCAR FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_STT_EMERG ON TAB_FISH_FAMILIAS.FISH_FAM_STT_EMER = TAB_APOIO_BOOLEANO_STT_EMERG.ID LEFT OUTER JOIN TAB_FISH_PERFILENT ON TAB_FISH_PERFILENT.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_FISH_ACOMP_ENTREVISTA ON TAB_FISH_ACOMP_ENTREVISTA.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_FISH_CAMPANHAS ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_CAMPANHA = TAB_FISH_CAMPANHAS.FISH_CAMP_ID LEFT OUTER JOIN TAB_FISH_ACOMP_ANTESTRANS ON TAB_FISH_ACOMP_ANTESTRANS.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ANTES_PESCAVA ON TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_BOO_PESCAVA = TAB_APOIO_BOOLEANO_ANTES_PESCAVA.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ANTES_VENDIA ON TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_BOO_PESCA_VENDIA = TAB_APOIO_BOOLEANO_ANTES_VENDIA.ID LEFT OUTER JOIN TAB_FISH_ACOMP_AT_MOTIVO ON TAB_FISH_ACOMP_AT_MOTIVO.FISH_AAM_FAM = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_PESCA_MOTIVO ON TAB_FISH_ACOMP_AT_MOTIVO.FISH_AAM_TIPO = TAB_APOIO_PESCA_MOTIVO.ID LEFT OUTER JOIN TAB_APOIO_STATUSATENDFISH ON TAB_FISH_PERFILENT.FISH_PERFIL_STATUSATEND = TAB_APOIO_STATUSATENDFISH.ID WHERE TAB_FISH_FAMILIAS.FISH_FAM_STT_EMER = 1 AND TAB_FISH_PERFILENT.FISH_PERFIL_QUEST IS NOT NULL ORDER BY TAB_FISH_PERFILENT.FISH_PERFIL_QUEST ASC, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_DT_ENTR_ATUAL DESC;", $db); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ID'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_PERFIL_QUEST'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CHEFE_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CHEFE_APELIDO'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_PERFIL_STATUSATEND_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_CAMP_DESCRICAO'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['FISH_AE_DT_ENTR_ATUAL'])).'</td>';
				$tabela .= '<td>'.$vetor['PESCAVA'].'</td>';
				$tabela .= '<td>'.$vetor['VENDIA'].'</td>';
				$tabela .= '<td>'.$vetor['MOTIVO_DE_NAO_PESCAR'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_fish_acomp_quest_b14.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>