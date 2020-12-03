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
			$id_evento = $_GET['id_evento'];
			$sql = mysql_query("SELECT TAB_FISH_EVENTOS.FISH_EVE_CODIGO, TAB_FISH_EVENTOS.FISH_EVE_DATA, TAB_APOIO_EVENTOS.DESCRICAO AS FISH_EVE_TIPO_DESC, TAB_FISH_EVENTOS.FISH_EVE_OBSERVACOES, TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_APELIDO, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_APELIDO, TAB_APOIO_BAIRROS.DESCRICAO AS FISH_FAM_ENDURB_LOCAL_DESC, TAB_APOIO_MUNICIPIOS_URBANO.DESCRICAO AS FISH_FAM_ENDURB_MUNIC_DESC, TAB_APOIO_LOCALIDADES.DESCRICAO AS FISH_FAM_ENDRUR_LOCAL_DESC, TAB_APOIO_MUNICIPIOS_RURAL.DESCRICAO AS FISH_FAM_ENDRUR_MUNIC_DESC FROM TAB_FISH_EVENTOS LEFT OUTER JOIN TAB_APOIO_EVENTOS ON TAB_APOIO_EVENTOS.ID = TAB_FISH_EVENTOS.FISH_EVE_TIPO LEFT OUTER JOIN TAB_FISH_FAMILIAS ON TAB_FISH_FAMILIAS.FISH_FAM_ID = TAB_FISH_EVENTOS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_LOCALIDADES ON TAB_APOIO_LOCALIDADES.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOCAL LEFT OUTER JOIN TAB_APOIO_BAIRROS ON TAB_APOIO_BAIRROS.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_BAIRRO LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_URBANO ON TAB_APOIO_MUNICIPIOS_URBANO.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_MUNIC LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_RURAL ON TAB_APOIO_MUNICIPIOS_RURAL.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_MUNIC WHERE TAB_FISH_EVENTOS.FISH_EVE_CODIGO = '$id_evento';", $db);
			$vetor = mysql_fetch_array($sql);
			$sql_VISITAS = mysql_query("SELECT TAB_APOIO_TPSUBVISITFISH.DESCRICAO AS PRI_ATIV, TAB_APOIO_TPVISITFISH.DESCRICAO AS SUB_ATIV, TAB_FISH_CLASSIFICACAO.FISH_CLASS_DESCRICAO FROM TAB_FISH_CLASSIFICACAO LEFT OUTER JOIN TAB_APOIO_TPSUBVISITFISH ON TAB_APOIO_TPSUBVISITFISH.ID = TAB_FISH_CLASSIFICACAO.FISH_CLASS_TIPO LEFT OUTER JOIN TAB_APOIO_TPVISITFISH ON TAB_APOIO_TPVISITFISH.ID = TAB_APOIO_TPSUBVISITFISH.ID_PRINCIPAL WHERE TAB_FISH_CLASSIFICACAO.FISH_CLASS_CODIGO IS NOT NULL AND TAB_FISH_CLASSIFICACAO.FISH_EVE_CODIGO = '$id_evento' ORDER BY PRI_ATIV ASC, SUB_ATIV ASC;", $db);
			$sql_TECNICOS = mysql_query("SELECT TAB_APOIO_TECNICOS.DESCRICAO FROM TAB_FISH_TECNICOS LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_APOIO_TECNICOS.ID = TAB_FISH_TECNICOS.FISH_TEC_TECNICO WHERE TAB_FISH_TECNICOS.FISH_TEC_CODIGO IS NOT NULL AND TAB_FISH_TECNICOS.FISH_EVE_CODIGO = '$id_evento' ORDER BY TAB_APOIO_TECNICOS.DESCRICAO ASC;", $db);
			$sql_IMAGENS = mysql_query("SELECT TAB_FISH_IMAGENS.FISH_IMG_NOME, TAB_FISH_IMAGENS.FISH_IMG_LEGENDA FROM TAB_FISH_IMAGENS WHERE TAB_FISH_IMAGENS.FISH_IMG_CODIGO IS NOT NULL AND TAB_FISH_IMAGENS.FISH_EVE_CODIGO = '$id_evento' ORDER BY TAB_FISH_IMAGENS.FISH_IMG_LEGENDA ASC;", $db);
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
    <td width="25%"><?php echo date('d/m/Y', strtotime($vetor['FISH_EVE_DATA'])); ?></td>
    <td width="25%"><strong>Tipo do Evento:</strong></td>
    <td width="25%"><?php echo $vetor['FISH_EVE_TIPO_DESC']; ?></td>
    </tr>
    <tr align="left">
    <td width="15%"><strong>Observações:</strong></td>
    <td width="85%" colspan="3"><?php echo $vetor['FISH_EVE_OBSERVACOES']; ?></td>
    </tr>
    </table><br/>
    <table>
    <tr align="left">
        <td width="25%"><strong>Beneficiário:</strong></td>
        <td colspan="2"><?php echo $vetor['FISH_FAM_CHEFE_NOME']; ?></td>
        <td width="25%"><?php echo $vetor['FISH_FAM_CHEFE_APELIDO']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Conjugê:</strong></td>
        <td colspan="2"><?php echo $vetor['FISH_FAM_CONJ_NOME']; ?></td>
        <td width="25%"><?php echo $vetor['FISH_FAM_CONJ_APELIDO']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Bairro:</strong></td>
        <td width="25%"><?php echo $vetor['FISH_FAM_ENDURB_LOCAL_DESC']; ?></td>
        <td width="25%"><strong>Município Urbano:</strong></td>
        <td width="25%"><?php echo $vetor['FISH_FAM_ENDURB_MUNIC_DESC']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Localidade:</strong></td>
        <td width="25%"><?php echo $vetor['FISH_FAM_ENDRUR_LOCAL_DESC']; ?></td>
        <td width="25%"><strong>Município Rural:</strong></td>
        <td width="25%"><?php echo $vetor['FISH_FAM_ENDRUR_MUNIC_DESC']; ?></td>
    </tr>
    </table><br/><br/>
	<table>
		<tr><td colspan="3" bgcolor="#D9D9D9"><strong>1. INFORMAÇÕES DO ACOMPANHAMENTO TÉCNICO</strong></td></tr>
        <tr align="center"><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
		<?php while ($vetor_VISITAS = mysql_fetch_array($sql_VISITAS)) { ?>
        	<tr>
            	<td colspan="3" bgcolor="#E7E7E7"><strong><?php echo $vetor_VISITAS['PRI_ATIV'] ?></strong></td>
            </tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
			<tr>
            	<td width="30%">Atividade: <?php echo $vetor_VISITAS['SUB_ATIV'] ?></td>
                <td width="5%">&nbsp;</td>
                <td><?php echo $vetor_VISITAS['FISH_CLASS_DESCRICAO'] ?></td>
			</tr>
            <tr><td width="30%">&nbsp;</td><td width="5%">&nbsp;</td><td>&nbsp;</td></tr>
        <?php } ?>        
	</table><br/>
	<table>
		<tr><td colspan="2" bgcolor="#D9D9D9"><strong>2. TÉCNICOS/RESPOSÁVEIS</strong></td></tr>
			<?php while ($vetor_TECNICOS = mysql_fetch_array($sql_TECNICOS)) { ?>
				<tr><td width="20"></td><td><?php echo $vetor_TECNICOS['DESCRICAO'] ?></td></tr>
            <?php } ?>        
	</table><br/>
	<table>
		<tr><td colspan="3" bgcolor="#D9D9D9"><strong>3. REGISTRO FOTOGRÁFICO</strong></td></tr>
			<?php while ($vetor_IMAGENS = mysql_fetch_array($sql_IMAGENS)) { ?>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td width="50"></td><td width="410"><img src="imagens/<?php echo $vetor_IMAGENS['FISH_IMG_NOME'] ?>" width="400" alt=""/></td><td valign="top"><?php echo $vetor_IMAGENS['FISH_IMG_LEGENDA'] ?></td></tr>
            <?php } ?>        
	</table><br/>
</body>
</html>
<?php
}
}
?>