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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db) or die(mysql_error());
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
			$tabela .= '<th align="center"><b>Código - Família</b></th>';
			$tabela .= '<th align="center"><b>Partic. - Diagnóstico?</b></th>';
			$tabela .= '<th align="center"><b>Partic. - Emergencial?</b></th>';
			$tabela .= '<th align="center"><b>Partic. - Porto?</b></th>';
			$tabela .= '<th align="center"><b>Partic. - Reuniões Regionais?</b></th>';
			$tabela .= '<th align="center"><b>Nome - Chefe da Família</b></th>';
			$tabela .= '<th align="center"><b>Quest. - Transição</b></th>';
			$tabela .= '<th align="center"><b>Dt. Entrev. - Transição</b></th>';
			$tabela .= '<th align="center"><b>Quest. - Cooperativa</b></th>';
			$tabela .= '<th align="center"><b>Dt. Entrev. - Cooperativa</b></th>';
			$tabela .= '<th align="center"><b>Código - Comp.</b></th>';
			$tabela .= '<th align="center"><b>Nome - Comp.</b></th>';
			$tabela .= '<th align="center"><b>Apelido - Comp.</b></th>';
			$tabela .= '<th align="center"><b>Gênero - Comp.</b></th>';
			$tabela .= '<th align="center"><b>Parentesco - Comp.</b></th>';
			$tabela .= '<th align="center"><b>Dt. Nasc. - Comp.</b></th>';
			$tabela .= '<th align="center"><b>Idade - Comp.</b></th>';
			$tabela .= '<th align="center"><b>Ocupação - Comp.</b></th>';
			$tabela .= '<th align="center"><b>Sabe Ler? - Comp.</b></th>';
			$tabela .= '<th align="center"><b>Sabe Escrever? - Comp.</b></th>';
			$tabela .= '<th align="center"><b>Possuí R.G.P.?</b></th>';
			$tabela .= '<th align="center"><b>Número - R.G.P.</b></th>';
			$tabela .= '<th align="center"><b>Dt. Registro - R.G.P.</b></th>';
			$tabela .= '<th align="center"><b>Possuí R.G.?</b></th>';
			$tabela .= '<th align="center"><b>Número - R.G.</b></th>';
			$tabela .= '<th align="center"><b>Dt. Registro - R.G.</b></th>';
			$tabela .= '<th align="center"><b>Possuí C.P.F.?</b></th>';
			$tabela .= '<th align="center"><b>Número - C.P.F.</b></th>';
			$tabela .= '<th align="center"><b>Residente? - Comp.</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_APOIO_BOOLEANO_SST_OFIC.DESCRICAO AS FISH_FAM_SST_OFIC_DESC, TAB_APOIO_BOOLEANO_SST_EMER.DESCRICAO AS FISH_FAM_SST_EMER_DESC, TAB_APOIO_BOOLEANO_SST_PORT.DESCRICAO AS FISH_FAM_SST_PORT_DESC, TAB_APOIO_BOOLEANO_SST_COOP.DESCRICAO AS FISH_FAM_SST_COOP_DESC, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_PERFILENT.FISH_PERFIL_QUEST, TAB_FISH_PERFILENT.FISH_PERFIL_DTAPLIC, TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST, TAB_APOIO_TECNICOS.DESCRICAO AS FISH_COOP_ENTREVISTA_DESC, TAB_FISH_COOP_ENTREVISTA.FISH_COOP_DTENTREVISTA, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ID, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_APELIDO, TAB_APOIO_GENERO.DESCRICAO AS FISH_FCOMP_GENERO_DESC, TAB_APOIO_PARENTESCO.DESCRICAO AS FISH_FCOMP_PARENTESCO_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_DTNASC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_IDADE, TAB_APOIO_OCUPACAO.DESCRICAO AS FISH_FCOMP_OCUPACAO_DESC, TAB_APOIO_BOOLEANO_ALFAB_LER.DESCRICAO AS FISH_FCOMP_ALFAB_LER_DESC, TAB_APOIO_BOOLEANO_ALFAB_ESCREVER.DESCRICAO AS FISH_FCOMP_ALFAB_ESCREVER_DESC, TAB_APOIO_BOOLEANO_RGP_POSSUI.DESCRICAO AS FISH_FCOMP_RGP_POSSUI_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_DTREGISTRO, TAB_APOIO_BOOLEANO_RG_POSSUI.DESCRICAO AS FISH_FCOMP_RG_POSSUI_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_DTREGISTRO, TAB_APOIO_BOOLEANO_CPF_POSSUI.DESCRICAO AS FISH_FCOMP_CPF_POSSUI_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_CPF_NUMERO, TAB_APOIO_BOOLEANO_RESIDENTE.DESCRICAO AS FISH_FCOMP_RESIDENTE_DESC FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_COOP_ENTREVISTA ON TAB_FISH_COOP_ENTREVISTA.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ENTREVISTA = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_GENERO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_GENERO = TAB_APOIO_GENERO.ID LEFT OUTER JOIN TAB_APOIO_PARENTESCO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_PARENTESCO = TAB_APOIO_PARENTESCO.ID LEFT OUTER JOIN TAB_APOIO_OCUPACAO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_OCUPACAO = TAB_APOIO_OCUPACAO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ALFAB_LER ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ALFAB_LER = TAB_APOIO_BOOLEANO_ALFAB_LER.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ALFAB_ESCREVER ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ALFAB_ESCREVER = TAB_APOIO_BOOLEANO_ALFAB_ESCREVER.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_RGP_POSSUI ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_POSSUI = TAB_APOIO_BOOLEANO_RGP_POSSUI.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_RG_POSSUI ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_POSSUI = TAB_APOIO_BOOLEANO_RG_POSSUI.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_CPF_POSSUI ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_CPF_POSSUI = TAB_APOIO_BOOLEANO_CPF_POSSUI.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_RESIDENTE ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RESIDENTE = TAB_APOIO_BOOLEANO_RESIDENTE.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_SST_OFIC ON TAB_FISH_FAMILIAS.FISH_FAM_STT_OFIC = TAB_APOIO_BOOLEANO_SST_OFIC.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_SST_EMER ON TAB_FISH_FAMILIAS.FISH_FAM_STT_EMER = TAB_APOIO_BOOLEANO_SST_EMER.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_SST_PORT ON TAB_FISH_FAMILIAS.FISH_FAM_STT_PORT = TAB_APOIO_BOOLEANO_SST_PORT.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_SST_COOP ON TAB_FISH_FAMILIAS.FISH_FAM_STT_COOP = TAB_APOIO_BOOLEANO_SST_COOP.ID LEFT OUTER JOIN TAB_FISH_PERFILENT ON TAB_FISH_PERFILENT.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID WHERE TAB_FISH_FAMILIAS.FISH_FAM_STT_COOP = 1 AND TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ID IS NOT NULL ORDER BY TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST ASC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_PARENTESCO ASC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_DTNASC DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_IDADE DESC;", $db) or die(mysql_error()); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FISH_FAM_ID'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_SST_OFIC_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_SST_EMER_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_SST_PORT_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_SST_COOP_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FAM_CHEFE_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_PERFIL_QUEST'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['FISH_PERFIL_DTAPLIC'])).'</td>';
				$tabela .= '<td>'.$vetor['FISH_COOP_QUEST'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['FISH_COOP_DTENTREVISTA'])).'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_ID'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_APELIDO'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_GENERO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_PARENTESCO_DESC'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['FISH_FCOMP_DTNASC'])).'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_IDADE'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_OCUPACAO_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_ALFAB_LER_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_ALFAB_ESCREVER_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_RGP_POSSUI_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_RGP_NUMERO'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['FISH_FCOMP_RGP_DTREGISTRO'])).'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_RG_POSSUI_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_RG_NUMERO'].'</td>';
				$tabela .= '<td>'.date('d/m/Y', strtotime($vetor['FISH_FCOMP_RG_DTREGISTRO'])).'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_CPF_POSSUI_DESC'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_CPF_NUMERO'].'</td>';
				$tabela .= '<td>'.$vetor['FISH_FCOMP_RESIDENTE_DESC'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_fish_composicaofamiliar_completo.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>