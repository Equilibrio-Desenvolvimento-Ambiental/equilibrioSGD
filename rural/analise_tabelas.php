<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	
	$sql_delete = mysql_query("delete from TAB_BASE_ANALISE;", $db);

	$sql01 = mysql_query("select * from TAB_BASE_01 order by NOME, ID;", $db); 

	while ($vetor01=mysql_fetch_array($sql01)) {
		$id01 = $vetor01['ID'];
		$nome01 = $vetor01['NOME'];
		$tabela01 = $vetor01['TABELA'];
		$sql02 = mysql_query("select * from TAB_BASE_02 where NOME like '%".$nome01."%';", $db);
		$cont02 = mysql_num_rows($sql02);
		if ($cont02 == 0) {
		} else {
			while ($vetor02=mysql_fetch_array($sql02)) {
				$id02 = $vetor02['ID'];
				$nome02 = $vetor02['NOME'];
				$tabela02 = $vetor02['TABELA'];
				$sql_insert = mysql_query("insert into TAB_BASE_ANALISE (ID_01, NOME_01, TABELA_01, ID_02, NOME_02, TABELA_02) VALUES ('$id01', '$nome01', '$tabela01', '$id02', '$nome02', '$tabela02')", $db);
			}
		}
	}

	echo"<script language=\"JavaScript\">
		alert('Inserido com sucesso!');
		</script>";

	require_once("includes/header-recebe.php");
?>