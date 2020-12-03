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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id_evento = $_GET['id_evento'];
			$sql = mysql_query("select TAB_415421_EVENTOS.EVENTOS_CODIGO, TAB_415421_EVENTOS.EVENTOS_DATA, TAB_APOIO_EVENTOS.DESCRICAO as EVENTOS_TIPO_DESC, TAB_415421_EVENTOS.EVENTOS_OBSERVACOES, TAB_415421_FAMILIAS.FAMILIA_NUMERO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_415421_FAMILIAS.FAMILIA_LOCALDESTINO, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_SETORATEND.DESCRICAO as FAMILIA_SETORATEND_DESC, TAB_415421_DADOSGERAIS.DADOS_LOTERRC from TAB_415421_EVENTOS left outer join TAB_APOIO_EVENTOS ON TAB_415421_EVENTOS.EVENTOS_TIPO = TAB_APOIO_EVENTOS.ID left outer join TAB_415421_FAMILIAS ON TAB_415421_EVENTOS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_BENEFICIOS ON TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS ON TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_APOIO_SETORATEND ON TAB_415421_FAMILIAS.FAMILIA_SETORATEND = TAB_APOIO_SETORATEND.ID left outer join TAB_415421_DADOSGERAIS ON TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO where TAB_415421_EVENTOS.EVENTOS_CODIGO = '$id_evento';", $db);
			$vetor = mysql_fetch_array($sql);
			$sql_VISITAS415 = mysql_query("select TAB_415_CLASSIFICACAO.EVENTOS_CODIGO, TAB_415_CLASSIFICACAO.CLASS415_CODIGO, TAB_APOIO_TPVISIT415.DESCRICAO AS PRI_ATIV, TAB_APOIO_TPSUBVISIT415.DESCRICAO AS SUB_ATIV, TAB_415_CLASSIFICACAO.CLASS415_DESCRICAO from TAB_415421_EVENTOS left outer join TAB_415_CLASSIFICACAO on TAB_415_CLASSIFICACAO.EVENTOS_CODIGO = TAB_415421_EVENTOS.EVENTOS_CODIGO left outer join TAB_APOIO_TPSUBVISIT415 on TAB_415_CLASSIFICACAO.CLASS415_TIPO = TAB_APOIO_TPSUBVISIT415.ID left outer join TAB_APOIO_TPVISIT415 on TAB_APOIO_TPVISIT415.ID = TAB_APOIO_TPSUBVISIT415.ID_PRINCIPAL where TAB_415_CLASSIFICACAO.CLASS415_CODIGO is not null and TAB_415_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento' order by TAB_415421_EVENTOS.EVENTOS_CODIGO asc, PRI_ATIV asc, SUB_ATIV asc;", $db);
			$sql_VISITAS421 = mysql_query("select TAB_421_CLASSIFICACAO.EVENTOS_CODIGO, TAB_421_CLASSIFICACAO.CLASS421_CODIGO, TAB_APOIO_TPVISIT421.DESCRICAO AS PRI_ATIV, TAB_APOIO_TPSUBVISIT421.DESCRICAO AS SUB_ATIV, TAB_421_CLASSIFICACAO.CLASS421_DESCRICAO from TAB_415421_EVENTOS left outer join TAB_421_CLASSIFICACAO on TAB_421_CLASSIFICACAO.EVENTOS_CODIGO = TAB_415421_EVENTOS.EVENTOS_CODIGO left outer join TAB_APOIO_TPSUBVISIT421 on TAB_421_CLASSIFICACAO.CLASS421_TIPO = TAB_APOIO_TPSUBVISIT421.ID left outer join TAB_APOIO_TPVISIT421 on TAB_APOIO_TPVISIT421.ID = TAB_APOIO_TPSUBVISIT421.ID_PRINCIPAL where TAB_421_CLASSIFICACAO.CLASS421_CODIGO is not null and TAB_421_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento' order by TAB_415421_EVENTOS.EVENTOS_CODIGO asc, PRI_ATIV asc, SUB_ATIV asc;", $db);
			$sql_VISITASRIR = mysql_query("select TAB_RIR_CLASSIFICACAO.EVENTOS_CODIGO, TAB_RIR_CLASSIFICACAO.CLASSRIR_CODIGO, TAB_APOIO_TPVISITRIR.DESCRICAO AS PRI_ATIV, TAB_APOIO_TPSUBVISITRIR.DESCRICAO AS SUB_ATIV, TAB_RIR_CLASSIFICACAO.CLASSRIR_DESCRICAO from TAB_415421_EVENTOS left outer join TAB_RIR_CLASSIFICACAO on TAB_RIR_CLASSIFICACAO.EVENTOS_CODIGO = TAB_415421_EVENTOS.EVENTOS_CODIGO left outer join TAB_APOIO_TPSUBVISITRIR on TAB_RIR_CLASSIFICACAO.CLASSRIR_TIPO = TAB_APOIO_TPSUBVISITRIR.ID left outer join TAB_APOIO_TPVISITRIR on TAB_APOIO_TPVISITRIR.ID = TAB_APOIO_TPSUBVISITRIR.ID_PRINCIPAL where TAB_RIR_CLASSIFICACAO.CLASSRIR_CODIGO is not null and TAB_RIR_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento' order by TAB_415421_EVENTOS.EVENTOS_CODIGO asc, PRI_ATIV asc, SUB_ATIV asc;", $db);
			$sql_VISITASRIR415 = mysql_query("SELECT TAB_RIR415_CLASSIFICACAO.EVENTOS_CODIGO, TAB_RIR415_CLASSIFICACAO.CLASSRIR415_CODIGO, TAB_APOIO_TPVISITRIR415.DESCRICAO AS PRI_ATIV, TAB_APOIO_TPSUBVISITRIR415.DESCRICAO AS SUB_ATIV, TAB_RIR415_CLASSIFICACAO.CLASSRIR415_DESCRICAO FROM TAB_415421_EVENTOS LEFT OUTER JOIN TAB_RIR415_CLASSIFICACAO ON TAB_RIR415_CLASSIFICACAO.EVENTOS_CODIGO = TAB_415421_EVENTOS.EVENTOS_CODIGO LEFT OUTER JOIN TAB_APOIO_TPSUBVISITRIR415 ON TAB_RIR415_CLASSIFICACAO.CLASSRIR415_TIPO = TAB_APOIO_TPSUBVISITRIR415.ID LEFT OUTER JOIN TAB_APOIO_TPVISITRIR415 ON TAB_APOIO_TPSUBVISITRIR415.ID_PRINCIPAL = TAB_APOIO_TPVISITRIR415.ID WHERE TAB_RIR415_CLASSIFICACAO.CLASSRIR415_CODIGO IS NOT NULL AND TAB_RIR415_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento' ORDER BY TAB_415421_EVENTOS.EVENTOS_CODIGO ASC, PRI_ATIV ASC, SUB_ATIV ASC;", $db);
			$sql_VISITASRIR421 = mysql_query("SELECT TAB_RIR421_CLASSIFICACAO.EVENTOS_CODIGO, TAB_RIR421_CLASSIFICACAO.CLASSRIR421_CODIGO, TAB_APOIO_TPVISITRIR421.DESCRICAO AS PRI_ATIV, TAB_APOIO_TPSUBVISITRIR421.DESCRICAO AS SUB_ATIV, TAB_RIR421_CLASSIFICACAO.CLASSRIR421_DESCRICAO FROM TAB_415421_EVENTOS LEFT OUTER JOIN TAB_RIR421_CLASSIFICACAO ON TAB_RIR421_CLASSIFICACAO.EVENTOS_CODIGO = TAB_415421_EVENTOS.EVENTOS_CODIGO LEFT OUTER JOIN TAB_APOIO_TPSUBVISITRIR421 ON TAB_RIR421_CLASSIFICACAO.CLASSRIR421_TIPO = TAB_APOIO_TPSUBVISITRIR421.ID LEFT OUTER JOIN TAB_APOIO_TPVISITRIR421 ON TAB_APOIO_TPSUBVISITRIR421.ID_PRINCIPAL = TAB_APOIO_TPVISITRIR421.ID WHERE TAB_RIR421_CLASSIFICACAO.CLASSRIR421_CODIGO IS NOT NULL AND TAB_RIR421_CLASSIFICACAO.EVENTOS_CODIGO = '$id_evento' ORDER BY TAB_415421_EVENTOS.EVENTOS_CODIGO ASC, PRI_ATIV ASC, SUB_ATIV ASC;", $db);
			$sql_TECNICOS = mysql_query("select TAB_415421_TECNICOS.TECNICOS_CODIGO, TAB_415421_TECNICOS.EVENTOS_CODIGO, TAB_APOIO_TECNICOS.DESCRICAO from TAB_415421_EVENTOS left outer join TAB_415421_TECNICOS ON TAB_415421_TECNICOS.EVENTOS_CODIGO = TAB_415421_EVENTOS.EVENTOS_CODIGO left outer join TAB_APOIO_TECNICOS ON TAB_415421_TECNICOS.TECNICOS_TECNICO = TAB_APOIO_TECNICOS.ID where TAB_415421_TECNICOS.EVENTOS_CODIGO = '$id_evento';", $db);
			$sql_IMAGENS = mysql_query("select TAB_415421_IMAGENS.IMAGEM_CODIGO, TAB_415421_IMAGENS.EVENTOS_CODIGO, TAB_415421_IMAGENS.IMAGEM_NOME, TAB_415421_IMAGENS.IMAGEM_LEGENDA from TAB_415421_IMAGENS where TAB_415421_IMAGENS.EVENTOS_CODIGO = '$id_evento';", $db);
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Equilíbrio Desenvolvimento Ambiental - Relatório de Evento - v.1.00</title>
	<link href="../plugin/layout/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="../plugin/layout/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="../plugin/layout/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="../plugin/layout/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="../plugin/layout/img/favicon.png" rel="icon" type="image/png">
	<link href="../plugin/layout/img/favicon.ico" rel="shortcut icon">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
   	<link rel="stylesheet" href="../plugin/layout/css/separate/vendor/select2.min.css">
	<link rel="stylesheet" href="../plugin/layout/css/lib/font-awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../plugin/layout/css/separate/vendor/bootstrap-touchspin.min.css">
	<link rel="stylesheet" href="../plugin/layout/css/lib/font-awesome/font-awesome.min.css">
	<link rel="stylesheet" href="../plugin/layout/css/lib/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../plugin/layout/css/main.css">
<style>
table {
	border:0; border-collapse:collapse; width:100%;
	background-color:#FFFFFF;
	font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
}
h1 {
	font-size:24px;
}
p {
	font-size:14px;
}
</style>
</head>
<body>
    <table>
      <tbody>
        <tr>
          <td align="left" valign="middle"><img src="imgs/Logo NE.png" width="300" height="96" alt=""/></td>
          <td align="right" valign="middle"><img src="imgs/Logo Equilibrio.jpg" width="250" height="124" alt=""/></td>
        </tr>
      </tbody>
    </table><br/>
    <table>
        <tbody>
            <tr><td align="center"><h1>RELATÓRIO DE ATIVIDADE</h1></td></tr>
            <tr><td align="center"><h1>ACOMPANHAMENTO TÉCNICO</h1></td></tr>
	    </tbody>	
    </table><br/>
    <table>
    <tr align="left">
    <td width="25%"><strong>Data:</strong></td>
    <td width="25%"><?php echo date('d/m/Y', strtotime($vetor['EVENTOS_DATA'])); ?></td>
    <td width="25%"><strong>Tipo do Evento:</strong></td>
    <td width="25%"><?php echo $vetor['EVENTOS_TIPO_DESC']; ?></td>
    </tr>
    <tr align="left">
    <td width="15%"><strong>Observações:</strong></td>
    <td width="85%" colspan="3"><?php echo $vetor['EVENTOS_OBSERVACOES']; ?></td>
    </tr>
    </table><br/>
    <table>
    <tr align="left">
        <td width="25%"><strong>Beneficiário:</strong></td>
        <td colspan="3"><?php echo $vetor['FAMILIA_BENEFICIARIO']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Número da C/C:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_NUMERO']; ?></td>
        <td width="25%"><strong>Opção do Benefício:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_BENEFICIO_DESC']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Lote:</strong></td>
        <td width="25%"><?php echo $vetor['DADOS_LOTERRC']; ?></td>
        <td width="25%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Município:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_MUNICIPIODESTINO_DESC']; ?></td>
        <td width="25%"><strong>Localidade:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_LOCALDESTINO']; ?></td>
    </tr>
    </table><br/><br/>
	<table>
		<tr><td colspan="3" bgcolor="#D9D9D9"><strong>1. INFORMAÇÕES E RECOMENDAÇÕES TÉCNICAS - PROJETO 4.1.5</strong></td></tr>
        <tr align="center"><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
		<?php while ($vetor_VISITAS415 = mysql_fetch_array($sql_VISITAS415)) { ?>
        	<tr>
            	<td colspan="3" bgcolor="#E7E7E7"><strong><?php echo $vetor_VISITAS415['PRI_ATIV'] ?></strong></td>
            </tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
			<tr>
            	<td width="30%">Atividade: <?php echo $vetor_VISITAS415['SUB_ATIV'] ?></td>
                <td width="5%">&nbsp;</td>
                <td><?php echo $vetor_VISITAS415['CLASS415_DESCRICAO'] ?></td>
			</tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
        <?php } ?>        
	</table><br/>
	<table>
		<tr><td colspan="3" bgcolor="#D9D9D9"><strong>2. INFORMAÇÕES E RECOMENDAÇÕES TÉCNICAS - PROJETO 4.2.1</strong></td></tr>
        <tr align="center"><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
		<?php while ($vetor_VISITAS421 = mysql_fetch_array($sql_VISITAS421)) { ?>
        	<tr>
            	<td colspan="3" bgcolor="#E7E7E7"><strong><?php echo $vetor_VISITAS421['PRI_ATIV'] ?></strong></td>
            </tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
			<tr>
            	<td width="30%">Atividade: <?php echo $vetor_VISITAS421['SUB_ATIV'] ?></td>
                <td width="5%">&nbsp;</td>
                <td><?php echo $vetor_VISITAS421['CLASS421_DESCRICAO'] ?></td>
			</tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
        <?php } ?>        
	</table><br/>
	<table>
		<tr><td colspan="3" bgcolor="#D9D9D9"><strong>3. INFORMAÇÕES E RECOMENDAÇÕES TÉCNICAS - RIBEIRINHOS</strong></td></tr>
        <tr align="center"><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
		<?php while ($vetor_VISITASRIR = mysql_fetch_array($sql_VISITASRIR)) { ?>
        	<tr>
            	<td colspan="3" bgcolor="#E7E7E7"><strong><?php echo $vetor_VISITASRIR['PRI_ATIV'] ?></strong></td>
            </tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
			<tr>
            	<td width="30%">Atividade: <?php echo $vetor_VISITASRIR['SUB_ATIV'] ?></td>
                <td width="5%">&nbsp;</td>
                <td><?php echo $vetor_VISITASRIR['CLASSRIR_DESCRICAO'] ?></td>
			</tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
        <?php } ?>
		<?php while ($vetor_VISITASRIR415 = mysql_fetch_array($sql_VISITASRIR415)) { ?>
        	<tr>
            	<td colspan="3" bgcolor="#E7E7E7"><strong><?php echo $vetor_VISITASRIR415['PRI_ATIV'] ?></strong></td>
            </tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
			<tr>
            	<td width="30%">Atividade: <?php echo $vetor_VISITASRIR415['SUB_ATIV'] ?></td>
                <td width="5%">&nbsp;</td>
                <td><?php echo $vetor_VISITASRIR415['CLASSRIR415_DESCRICAO'] ?></td>
			</tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
        <?php } ?>        
		<?php while ($vetor_VISITASRIR421 = mysql_fetch_array($sql_VISITASRIR421)) { ?>
        	<tr>
            	<td colspan="3" bgcolor="#E7E7E7"><strong><?php echo $vetor_VISITASRIR421['PRI_ATIV'] ?></strong></td>
            </tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
			<tr>
            	<td width="30%">Atividade: <?php echo $vetor_VISITASRIR421['SUB_ATIV'] ?></td>
                <td width="5%">&nbsp;</td>
                <td><?php echo $vetor_VISITASRIR421['CLASSRIR421_DESCRICAO'] ?></td>
			</tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
        <?php } ?>    		
	</table><br/>
	<table>
		<tr><td colspan="2" bgcolor="#D9D9D9"><strong>4. TÉCNICOS/RESPOSÁVEIS</strong></td></tr>
			<?php while ($vetor_TECNICOS = mysql_fetch_array($sql_TECNICOS)) { ?>
				<tr><td width="20"></td><td><?php echo $vetor_TECNICOS['DESCRICAO'] ?></td></tr>
            <?php } ?>        
	</table><br/>
	<table>
		<tr><td colspan="3" bgcolor="#D9D9D9"><strong>5. REGISTRO FOTOGRÁFICO</strong></td></tr>
			<?php while ($vetor_IMAGENS = mysql_fetch_array($sql_IMAGENS)) { ?>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td width="50"></td><td width="410"><img src="imagens/<?php echo $vetor_IMAGENS['IMAGEM_NOME'] ?>" width="400" alt=""/></td><td valign="top"><?php echo $vetor_IMAGENS['IMAGEM_LEGENDA'] ?></td></tr>
            <?php } ?>        
	</table><br/>
</body>
</html>
<?php
}
}
?>