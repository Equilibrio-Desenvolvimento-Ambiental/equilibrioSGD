<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 3;
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
			$id = $_GET['id'];
			$sql = mysql_query("select A.*, B.DESCRICAO as DESC_ATIVMA_RUC, C.DESCRICAO as DESC_ATIVMA_PERIODO,  D.DESCRICAO as DESC_ATIVMA_EVENTO, E.DESCRICAO as DESC_ATIVMA_ATIVIDADE from TAB_444_ATIV_MA A, TAB_APOIO_RUC B, TAB_APOIO_PERIODO C, TAB_APOIO_EVENUC_MA D, TAB_APOIO_ATIVNUC_MA E where A.ATIVMA_RUC = B.ID and A.ATIVMA_PERIODO = C.ID and A.ATIVMA_EVENTO = D.ID and A.ATIVMA_ATIVIDADE = E.ID and A.ATIVMA_CODIGO = '$id'", $db);
			$vetor = mysql_fetch_array($sql);
		
			$sql_ENTIDADES = mysql_query("select B.DESCRICAO from TAB_444_ATIV_MA_PART A, TAB_APOIO_ENTIDINST B where A.PARTATIVMA_PARTICIPANTE = B.ID and A.ATIVMA_CODIGO = '$id'", $db);
			$sql_TECNICOS = mysql_query("select B.DESCRICAO from TAB_444_ATIV_MA_TEC A, TAB_APOIO_TECNICOS B where A.TECATIVMA_TECNICO = B.ID and A.ATIVMA_CODIGO = '$id'", $db);
			$sql_PERCEPCOES = mysql_query("select B.DESCRICAO from TAB_444_ATIV_MA_PERCEP A, TAB_APOIO_PERCEPCOES B where A.PERCEPATIVMA_PERCEP = B.ID and A.ATIVMA_CODIGO = '$id'", $db);
			$sql_IMAGENS = mysql_query("select * from TAB_444_ATIV_MA_IMAGENS where ATIVMA_CODIGO = '$id'", $db);
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
            <tr><td align="center"><h1>NÚCLEO DE MEIO AMBIENTE</h1></td></tr>
	    </tbody>	
    </table><br/>
    <table>
    <tr align="left">
    <td width="12,5%"><strong>Data:</strong></td>
    <td width="12,5%"><?php echo date('d/m/Y', strtotime($vetor['ATIVMA_DATA'])); ?></td>
    <td width="12,5%"><strong>Participantes:</strong></td>
    <td width="12,5%"><?php echo $vetor['ATIVMA_PARTICIPANTES']; ?></td>
    <td width="12,5%"><strong>Bairro/RUC:</strong></td>
    <td width="12,5%"><?php echo $vetor['DESC_ATIVMA_RUC']; ?></td>
    <td width="12,5%"><strong>Período:</strong></td>
    <td width="12,5%"><?php echo $vetor['DESC_ATIVMA_PERIODO']; ?></td>
    </tr>
    </table><br/>
    <table>
    <tr align="left">
        <td width="15%"><strong>Tipo de Evento:</strong></td>
        <td><?php echo $vetor['DESC_ATIVMA_EVENTO']; ?></td>
    </tr>
    </table><br>
    <table>
    <tr align="left">
        <td width="15%"><strong>Tipo de Atividade:</strong></td>
        <td><?php echo $vetor['DESC_ATIVMA_ATIVIDADE']; ?></td>
    </tr>
    </table><br>
    <table>
    <tr align="left">
        <td width="15%"><strong>Descrição:</strong></td>
        <td><?php echo $vetor['ATIVMA_DESCRICAO']; ?></td>
    </tr>
    </table><br/>
    <table>
    <tr align="left">
        <td width="15%"><strong>Percepções Descritivas:</strong></td>
        <td><?php echo $vetor['ATIVMA_PERCEPCOES']; ?></td>
    </tr>
    </table><br/>
	<table>
		<tr><td colspan="2" bgcolor="#D9D9D9"><strong>1. ENVOLVIDOS NA ATIVIDADE</strong></td></tr>
			<?php while ($vetor_ENTIDADES = mysql_fetch_array($sql_ENTIDADES)) { ?>
				<tr><td width="20"></td><td><?php echo $vetor_ENTIDADES['DESCRICAO'] ?></td></tr>
            <?php } ?>        
	</table><br/>
	<table>
		<tr><td colspan="2" bgcolor="#D9D9D9"><strong>2. TÉCNICOS RESPONSÁVEIS</strong></td></tr>
			<?php while ($vetor_TECNICOS = mysql_fetch_array($sql_TECNICOS)) { ?>
				<tr><td width="20"></td><td><?php echo $vetor_TECNICOS['DESCRICAO'] ?></td></tr>
            <?php } ?>        
	</table><br/>
	<table>
		<tr><td colspan="2" bgcolor="#D9D9D9"><strong>3. PERCEPÇES IDENTIFICADAS</strong></td></tr>
			<?php while ($vetor_PERCEPCOES = mysql_fetch_array($sql_PERCEPCOES)) { ?>
				<tr><td width="20"></td><td><?php echo $vetor_PERCEPCOES['DESCRICAO'] ?></td></tr>
            <?php } ?>        
	</table><br/>
	<table>
		<tr><td colspan="3" bgcolor="#D9D9D9"><strong>4. REGISTRO FOTOGRÁFICO</strong></td></tr>
			<?php while ($vetor_IMAGENS = mysql_fetch_array($sql_IMAGENS)) { ?>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr><td width="50"></td><td width="410"><img src="imagens/<?php echo $vetor_IMAGENS['IMGATIVMA_NOME'] ?>" width="400" alt=""/></td><td valign="top"><?php echo $vetor_IMAGENS['IMGATIVMA_LEGENDA'] ?></td></tr>
            <?php } ?>        
	</table><br/>
</body>
</html>
<?php
}
}
?>