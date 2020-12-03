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
			$id_familia = $_GET['id_familia'];
			$sql = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_LOGR, TAB_APOIO_BAIRROS.DESCRICAO AS FISH_FAM_ENDURB_BAIRRO_DESC, TAB_APOIO_MUNICIPIOS_URB.DESCRICAO AS FISH_FAM_ENDURB_MUNIC_DESC, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_COMPL, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOGR, TAB_APOIO_LOCALIDADES.DESCRICAO AS FISH_FAM_ENDRUR_LOCAL_DESC, TAB_APOIO_MUNICIPIOS_RUR.DESCRICAO AS FISH_FAM_ENDRUR_MUNIC_DESC, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_COMPL, TAB_FISH_FAMILIAS.FISH_FAM_TELEFONES, TAB_FISH_PERFILENT.FISH_PERFIL_DTAPLIC, TAB_FISH_PERFILENT.FISH_PERFIL_TRAN_RELATO, TAB_FISH_PERFILENT.FISH_PERFIL_TRAN_ATEND, TAB_FISH_PERFILENT.FISH_PERFIL_E_BARCO, TAB_FISH_PERFILENT.FISH_PERFIL_E_MOTOR, TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_APOIO_BAIRROS ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_BAIRRO = TAB_APOIO_BAIRROS.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_URB ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_MUNIC = TAB_APOIO_MUNICIPIOS_URB.ID LEFT OUTER JOIN TAB_APOIO_LOCALIDADES ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOCAL = TAB_APOIO_LOCALIDADES.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_RUR ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_MUNIC = TAB_APOIO_MUNICIPIOS_RUR.ID LEFT OUTER JOIN TAB_FISH_PERFILENT ON TAB_FISH_PERFILENT.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia';", $db);
			$vetor = mysql_fetch_array($sql);
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Equilíbrio Desenvolvimento Ambiental</title>
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
body {
	font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
}
table {
	border:0; border-collapse:collapse; width:100%;
	background-color:#FFFFFF;
}
h1 {
	font-size:24px;
}
p, tr, td {
}
</style>
</head>
<body>
    <table>
      <tbody>
        <tr>
          <td align="left" valign="middle"><img src="imgs/Logo NE.png" width="171" height="54" alt=""/></td>
          <td align="right" valign="middle"><img src="imgs/Logo Equilibrio.jpg" width="139" height="67" alt=""/></td>
        </tr>
      </tbody>
    </table><br/>
    <table>
        <tbody>
            <tr><td align="center"><strong><p>PLANO DE TRANSIÇÃO PARA O PÚBLICO PESCADORES</p></strong></td></tr>
	    </tbody>	
    </table><br/>
    <table>
    <tr><td width="25%"><strong>1. Identificação</strong></td><td width="75%">&nbsp;</td></tr>
    <tr><td width="25%">&nbsp;</td><td width="75%">&nbsp;</td></tr>
    <tr>
    	<td width="25%"><strong>Nome do Chefe:</strong></td>
        <td width="75%"><?php echo $vetor['FISH_FAM_CHEFE_NOME']; ?></td>
    </tr>
    <tr>
    	<td width="25%"><strong>Cônjuge/Companheiro(a):</strong></td>
        <td width="75%"><?php echo $vetor['FISH_FAM_CONJ_NOME']; ?></td>
    </tr>
    <tr><td width="25%">&nbsp;</td><td width="75%">&nbsp;</td></tr>
	<?php if (strcasecmp($vetor['FISH_FAM_ENDURB'],'1')==0) {?>
    <tr>
    	<td width="25%"><strong>Endereço Urbano:</strong></td>
        <td width="75%"><?php echo $vetor['FISH_FAM_ENDURB_LOGR'].', '.$vetor['FISH_FAM_ENDURB_BAIRRO_DESC'].', '.$vetor['FISH_FAM_ENDURB_MUNIC_DESC'].' ('.$vetor['FISH_FAM_ENDURB_COMPL'].')'; ?></td>
    </tr>
    <?php }; ?>
	<?php if (strcasecmp($vetor['FISH_FAM_ENDRUR'],'1')==0) {?>
    <tr>
    	<td width="25%"><strong>Endereço Rural:</strong></td>
        <td width="75%"><?php echo $vetor['FISH_FAM_ENDRUR_LOGR'].', '.$vetor['FISH_FAM_ENDRUR_LOCAL_DESC'].', '.$vetor['FISH_FAM_ENDRUR_MUNIC_DESC'].' ('.$vetor['FISH_FAM_ENDRUR_COMPL'].')'; ?></td>
    </tr>
    <?php }; ?>
    <tr>
    	<td width="25%"><strong>Telefone(s):</strong></td>
        <td width="75%"><?php echo $vetor['FISH_FAM_TELEFONES']; ?></td>
    </tr>
    </table>
	<table>
    <tr><td colspan="2"><strong>2. Situação relatada na entrevista de aplicação do questionário em <?php echo date('d/m/Y', strtotime($vetor['FISH_PERFIL_DTAPLIC'])); ?>:</strong></td></tr>
    <tr><td colspan="2"><p><?php echo $vetor['FISH_PERFIL_TRAN_RELATO']; ?></p></td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
    <td colspan="2"><strong>3. Plano de Atendimento:</strong></td></tr>
    <tr><td colspan="2"><p><?php echo $vetor['FISH_PERFIL_TRAN_ATEND']; ?></p></td></tr></br>
<?php
		if((strcasecmp($vetor['FISH_PERFIL_E_BARCO'], '2')==0) && (strcasecmp($vetor['FISH_PERFIL_E_MOTOR'], '2')==0) && (strcasecmp($vetor['FISH_PERFIL_E_TRALHA'], '2')==0) && (strcasecmp($vetor['FISH_PERFIL_E_CESTA'], '2')==0)){
?>
        <tr><td colspan="2">&nbsp;</td></tr>
<?php	
		} else {
?>
	    <tr><td colspan="2"><strong>4. Contrapartida para a Família:</strong></td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Quanto à produção de pesca (______) retomar ; (______) incrementar/aumentar</td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Preencher a ficha de produção de pesca</td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Integrar a Cooperativa</td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Zelar pelo equipamento recebido (não vender, alugar, ceder)</td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Manter o equipamento em bom estado de conservação </td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Comunicar/documentar acontecimentos (quebra, roubo, avaria)</td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Outros: ____________________________________________________________________________________________________</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2"><strong>5. Plano de Acompanhamento:</strong></td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Realizado mensalmente</td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Entrega do Rancho pelo período acordado</td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Recolhimento da ficha de produção de pesca</td></tr>
		<tr><td align="center" width="10%">•</td><td align="left">Avaliação participativa da situação</td></tr>
<?php	
		};
?>
	<tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><strong>Observações:</strong></td></tr>
    <tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    <tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    <tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><strong>Local:</strong> ______________________________________________ <strong>Data:</strong> ____/____/____ <strong>Técnico:</strong> ______________________________________</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    </table><br/>
    <table>
    <tr><td colspan="2"><strong>Assinaturas:</strong></td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td width="50%">_________________________________________________________</td><td width="50%">_________________________________________________________</td></tr>
    <tr><td><strong>R.G./C.P.F.:</strong></td><td><strong>R.G./C.P.F.:</strong></td></tr>
    </table><br/>
    <table><tr align="center" valign="middle"><td><strong><p>Equilíbrio Desenvolvimento Ambiental Ltda. - Alameda Barros, 436 - Conj. 436 - São Paulo/SP</br>CEP 01232-000 - Fones: (11) 3667-2360/(11) 99958-1046</p></strong></td></tr></table>
</body>
</html>
<?php
}
}
?>