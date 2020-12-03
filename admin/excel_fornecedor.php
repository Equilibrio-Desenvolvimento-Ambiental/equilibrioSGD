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
			$tabela = '<table border=1>';
			$tabela .= '<thead>';
			$tabela .= '<tr>';
			$tabela .= '<th align="center"><b>Código</b></th>';
			$tabela .= '<th align="center"><b>Razão Social/Nome</b></th>';
			$tabela .= '<th align="center"><b>Nome Fantasia</b></th>';
			$tabela .= '<th align="center"><b>C.P.F./C.N.P.J.</b></th>';
			$tabela .= '<th align="center"><b>Nome do Responsável</b></th>';
			$tabela .= '<th align="center"><b>Inscrição Estadual</b></th>';
			$tabela .= '<th align="center"><b>Inscrição Municipal</b></th>';
			$tabela .= '<th align="center"><b>Endereço</b></th>';
			$tabela .= '<th align="center"><b>Número</b></th>';
			$tabela .= '<th align="center"><b>Complemento</b></th>';
			$tabela .= '<th align="center"><b>Bairro</b></th>';
			$tabela .= '<th align="center"><b>Município</b></th>';
			$tabela .= '<th align="center"><b>C.E.P.</b></th>';
			$tabela .= '<th align="center"><b>Telefone</b></th>';
			$tabela .= '<th align="center"><b>Celular</b></th>';
			$tabela .= '<th align="center"><b>E-mail</b></th>';
			$tabela .= '<th align="center"><b>Observações</b></th>';
			$tabela .= '</tr>';
			$tabela .= '</thead>';
			$tabela .= '<tbody>';
			$sql = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_FORNECEDOR.FORNEC_CPFCNPJ, TAB_ADM_FORNECEDOR.FORNEC_NOMERESP, TAB_ADM_FORNECEDOR.FORNEC_INSCEST, TAB_ADM_FORNECEDOR.FORNEC_INSCMUN, TAB_ADM_FORNECEDOR.FORNEC_ENDERECO, TAB_ADM_FORNECEDOR.FORNEC_NUMERO, TAB_ADM_FORNECEDOR.FORNEC_COMPL, TAB_ADM_FORNECEDOR.FORNEC_BAIRRO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FORNEC_MUNICIPIO_DESC, TAB_APOIO_UF.SIGLA AS FORNEC_MUNICIPIO_DESC_UF, TAB_ADM_FORNECEDOR.FORNEC_CEP, TAB_ADM_FORNECEDOR.FORNEC_FONE01, TAB_ADM_FORNECEDOR.FORNEC_FONE02, TAB_ADM_FORNECEDOR.FORNEC_EMAIL, TAB_ADM_FORNECEDOR.FORNEC_ANOTACOES FROM TAB_ADM_FORNECEDOR LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_ADM_FORNECEDOR.FORNEC_MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_ADM_FORNECEDOR.FORNEC_NOME ASC;", $db); 
			while ($vetor=mysql_fetch_array($sql)) {
				$tabela .= '<tr>';
				$tabela .= '<td>'.$vetor['FORNEC_ID'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_NOME'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_NOMEFANT'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_CPFCNPJ'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_NOMERESP'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_INSCEST'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_INSCMUN'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_ENDERECO'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_NUMERO'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_COMPL'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_BAIRRO'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_MUNICIPIO_DESC'].'/'.$vetor['FORNEC_MUNICIPIO_DESC_UF'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_CEP'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_FONE01'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_FONE02'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_EMAIL'].'</td>';
				$tabela .= '<td>'.$vetor['FORNEC_ANOTACOES'].'</td>';
				$tabela .= '</tr>';
			}
			$tabela .= '</tbody>';
			$tabela .= '</table>';
			header("Pragma: no-cache");
			header("Content-Type: application/msexcel; charset=utf-8");
			header("Content-Disposition: attachment; filename=excel_fornecedor.xls");
			header("Content-Description: PHP Generated Data" );			
			header("Cache-Control: no-cache, must-revalidate");
			header("Content-type: application/force-download");  
			echo $tabela;
		}
	}
?>