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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id_familia = $_GET['id_familia'];
			$sql = mysql_query("SELECT TAB_415421_FAMILIAS.FAMILIA_NUMERO, TAB_415421_FAMILIAS.FAMILIA_FUNDIARIO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIO, TAB_APOIO_BENEFICIOS.DESCRICAO AS FAMILIA_BENEFICIO_DESC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_415421_FAMILIAS.FAMILIA_LOCALDESTINO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_SETORATEND.DESCRICAO AS FAMILIA_SETORATEND_DESC, TAB_415421_FAMILIAS.FAMILIA_TELEFONES, TAB_415421_DADOSGERAIS.DADOS_LOTERRC, TAB_415421_DADOSGERAIS.DADOS_ATEND415, TAB_APOIO_TPATENDIMENTO_415.DESCRICAO AS DADOS_ATEND415_DESC, TAB_APOIO_MTATENDIMENTO_415.DESCRICAO AS DADOS_MOTIVO415_DESC, TAB_415421_DADOSGERAIS.DADOS_ATEND421, TAB_APOIO_TPATENDIMENTO_421.DESCRICAO AS DADOS_ATEND421_DESC, TAB_APOIO_MTATENDIMENTO_421.DESCRICAO AS DADOS_MOTIVO421_DESC, TAB_415421_DADOSGERAIS.DADOS_ATENDRIR, TAB_APOIO_TPATENDIMENTO_RIR.DESCRICAO AS DADOS_ATENDRIR_DESC, TAB_APOIO_MTATENDIMENTO_RIR.DESCRICAO AS DADOS_MOTIVORIR_DESC FROM TAB_415421_FAMILIAS LEFT OUTER JOIN TAB_APOIO_BENEFICIOS ON TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_SETORATEND ON TAB_415421_FAMILIAS.FAMILIA_SETORATEND = TAB_APOIO_SETORATEND.ID LEFT OUTER JOIN TAB_415421_DADOSGERAIS ON TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO LEFT OUTER JOIN TAB_APOIO_TPATENDIMENTO AS TAB_APOIO_TPATENDIMENTO_415 ON TAB_415421_DADOSGERAIS.DADOS_ATEND415 = TAB_APOIO_TPATENDIMENTO_415.ID LEFT OUTER JOIN TAB_APOIO_TPATENDIMENTO AS TAB_APOIO_TPATENDIMENTO_421 ON TAB_415421_DADOSGERAIS.DADOS_ATEND421 = TAB_APOIO_TPATENDIMENTO_421.ID LEFT OUTER JOIN TAB_APOIO_TPATENDIMENTO AS TAB_APOIO_TPATENDIMENTO_RIR ON TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = TAB_APOIO_TPATENDIMENTO_RIR.ID LEFT OUTER JOIN TAB_APOIO_MTATENDIMENTO AS TAB_APOIO_MTATENDIMENTO_415 ON TAB_415421_DADOSGERAIS.DADOS_MOTIVO415 = TAB_APOIO_MTATENDIMENTO_415.ID LEFT OUTER JOIN TAB_APOIO_MTATENDIMENTO AS TAB_APOIO_MTATENDIMENTO_421 ON TAB_415421_DADOSGERAIS.DADOS_MOTIVO421 = TAB_APOIO_MTATENDIMENTO_421.ID LEFT OUTER JOIN TAB_APOIO_MTATENDIMENTO AS TAB_APOIO_MTATENDIMENTO_RIR ON TAB_415421_DADOSGERAIS.DADOS_MOTIVORIR = TAB_APOIO_MTATENDIMENTO_RIR.ID WHERE TAB_415421_FAMILIAS.FAMILIA_CODIGO = '$id_familia';", $db) or die(mysql_error());
			$vetor = mysql_fetch_array($sql);
			$sql_EVENTOS = mysql_query("SELECT TAB_415421_EVENTOS.EVENTOS_CODIGO, TAB_415421_EVENTOS.FAMILIA_CODIGO, TAB_415421_EVENTOS.EVENTOS_DATA, TAB_APOIO_EVENTOS.DESCRICAO AS EVENTOS_TIPO_DESC, TAB_415421_EVENTOS.EVENTOS_OBSERVACOES FROM TAB_415421_EVENTOS LEFT OUTER JOIN TAB_APOIO_EVENTOS ON TAB_415421_EVENTOS.EVENTOS_TIPO = TAB_APOIO_EVENTOS.ID WHERE TAB_415421_EVENTOS.FAMILIA_CODIGO = '$id_familia' ORDER BY TAB_415421_EVENTOS.EVENTOS_DATA DESC, TAB_415421_EVENTOS.EVENTOS_CODIGO ASC;", $db) or die(mysql_error());
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
table { border:0 px solid #000000; border-collapse:collapse; width:100%;
	background-color:#FFFFFF;
	font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
}
table tr td { border:0; }
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
            <tr><td align="center" valign="middle"><h1>RELATÓRIO COMPLETO DE ATENDIMENTO</h1></td></tr>
            <tr><td align="center" valign="middle"><h1>ATES / REPARAÇÃO RURAL / RIBEIRINHOS</h1></td></tr>
	    </tbody>	
    </table><br/>
    <table>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr><td colspan="4"><strong>Dados Principais</strong></td></tr>
	<tr><td colspan="4">&nbsp;</td></tr>
    <tr align="left">
        <td width="25%"><strong>Beneficiário:</strong></td>
        <td colspan="3"><?php echo $vetor['FAMILIA_BENEFICIARIO']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Opção do Benefício:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_BENEFICIO_DESC']; ?></td>
        <td width="25%"><strong>ID Fundiário:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_FUNDIARIO']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Número da C/C:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_NUMERO']; ?></td>
        <td width="25%"><strong>Lote:</strong></td>
        <td width="25%"><?php echo $vetor['DADOS_LOTERRC']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Telefone(s) de Contato:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_TELEFONES']; ?></td>
        <td width="25%"><strong>Localidade:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_LOCALDESTINO']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Setor de Atendimento:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_SETORATEND_DESC']; ?></td>
        <td width="25%"><strong>Município:</strong></td>
        <td width="25%"><?php echo $vetor['FAMILIA_MUNICIPIODESTINO_DESC']; ?></td>
    </tr>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr><td colspan="4"><strong>Informações sobre Atendimento</strong></td></tr>
	<tr><td colspan="4">&nbsp;</td></tr>
    <tr align="left">
        <td width="25%"><strong>Atendido pelo 4.1.5?</strong></td>
        <td width="25%"><?php echo $vetor['DADOS_ATEND415_DESC']; ?></td>
        <td colspan="2"><?php echo $vetor['DADOS_MOTIVO415_DESC']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Atendido pelo 4.2.1?</strong></td>
        <td width="25%"><?php echo $vetor['DADOS_ATEND421_DESC']; ?></td>
        <td colspan="2"><?php echo $vetor['DADOS_MOTIVO421_DESC']; ?></td>
    </tr>
    <tr align="left">
        <td width="25%"><strong>Atendido pelo RIR?</strong></td>
        <td width="25%"><?php echo $vetor['DADOS_ATENDRIR_DESC']; ?></td>
        <td colspan="2"><?php echo $vetor['DADOS_MOTIVORIR_DESC']; ?></td>
    </tr>
	<tr><td colspan="4">&nbsp;</td></tr>
    </table><br/>
	<?php while ($vetor_EVENTOS = mysql_fetch_array($sql_EVENTOS)) { ?>
	<table width="100%"><tr><td bgcolor="#878787">&nbsp;</td></tr><tr><td bgcolor="#878787"><strong>Data do Atendimento: <?php echo date('d/m/Y', strtotime($vetor_EVENTOS['EVENTOS_DATA']));?></strong></td></tr><tr><td bgcolor="#878787">&nbsp;</td></tr></table>

	<!-- ATENDIMENTOS DE ATES - RURAL -->
	<?php
		$id_evento = $vetor_EVENTOS['EVENTOS_CODIGO'];
		$sql_VISITAS421 = mysql_query("SELECT VIEW_421_VISITAS.CLASS421_TPATIV_DESC, VIEW_421_VISITAS.CLASS421_TPSUBATIV_DESC, VIEW_421_VISITAS.CLASS421_DESCRICAO FROM VIEW_421_VISITAS WHERE VIEW_421_VISITAS.EVENTOS_CODIGO = '$id_evento' ORDER BY VIEW_421_VISITAS.CLASS421_TPATIV_DESC ASC, VIEW_421_VISITAS.CLASS421_TPSUBATIV_DESC ASC;", $db) or die(mysql_error());
		$num_busca_VISITAS421 = mysql_num_rows($sql_VISITAS421);
		if ($num_busca_VISITAS421 == 0) { } else {
	?>
		<table>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
			<tr bgcolor="#B3B3B3"><td colspan="5" align="center" valign="middle"><strong>Atividade(S) de ATES - 4.2.1</strong></td></tr>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
			<tr bgcolor="#B3B3B3">
				<td width="23%" align="center" valign="middle"><strong>Atividade Principal</strong></td><td width="2%">&nbsp;</td>
				<td width="23%" align="center" valign="middle"><strong>Sub-Atividade</strong></td><td width="2%">&nbsp;</td>
				<td width="50%" align="center" valign="middle"><strong>Descrição</strong></td>
			</tr>
			<?php
				$cor = "#D8D8D8";
				while ($vetor_VISITAS421=mysql_fetch_array($sql_VISITAS421)) {
					if (strcasecmp($cor, "#FFFFFF") == 0){
						$cor = "#D8D8D8";
					} else {
						$cor = "#FFFFFF";
					}
			?>
			<tr bgcolor="<?php echo $cor; ?>">
				<td width="23%" align="left" valign="top"><?php echo $vetor_VISITAS421['CLASS421_TPATIV_DESC'];?></td><td width="2%"></td>
				<td width="23%" align="left" valign="top"><?php echo $vetor_VISITAS421['CLASS421_TPSUBATIV_DESC'];?></td><td width="2%"></td>
				<td width="50%" align="left" valign="top"><?php echo $vetor_VISITAS421['CLASS421_DESCRICAO'];?></td>
			</tr>
			<?php } }?>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
		</table>

	<!-- ATENDIMENTOS DE REPARAÇÃO - RURAL -->
	<?php
		$sql_VISITAS415 = mysql_query("SELECT VIEW_415_VISITAS.CLASS415_TPATIV_DESC, VIEW_415_VISITAS.CLASS415_TPSUBATIV_DESC, VIEW_415_VISITAS.CLASS415_DESCRICAO FROM VIEW_415_VISITAS WHERE VIEW_415_VISITAS.EVENTOS_CODIGO = '$id_evento' ORDER BY VIEW_415_VISITAS.CLASS415_TPATIV ASC, VIEW_415_VISITAS.CLASS415_TPSUBATIV_DESC ASC;", $db) or die(mysql_error());
		$num_busca_VISITAS415 = mysql_num_rows($sql_VISITAS415);
		if ($num_busca_VISITAS415 == 0) { } else {
	?>
		<table>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
			<tr bgcolor="#B3B3B3"><td colspan="5" align="center" valign="middle"><strong>Atividade(S) de REPARAÇÃO RURAL - 4.1.5</strong></td></tr>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
			<tr bgcolor="#B3B3B3">
				<td width="23%" align="center" valign="middle"><strong>Atividade Principal</strong></td><td width="2%">&nbsp;</td>
				<td width="23%" align="center" valign="middle"><strong>Sub-Atividade</strong></td><td width="2%">&nbsp;</td>
				<td width="50%" align="center" valign="middle"><strong>Descrição</strong></td>
			</tr>
			<?php
				$cor = "#D8D8D8";
				while ($vetor_VISITAS415=mysql_fetch_array($sql_VISITAS415)) {
					if (strcasecmp($cor, "#FFFFFF") == 0){
						$cor = "#D8D8D8";
					} else {
						$cor = "#FFFFFF";
					}
			?>
			<tr bgcolor="<?php echo $cor; ?>">
				<td width="23%" align="left" valign="top"><?php echo $vetor_VISITAS415['CLASS415_TPATIV_DESC'];?></td><td width="2%"></td>
				<td width="23%" align="left" valign="top"><?php echo $vetor_VISITAS415['CLASS415_TPSUBATIV_DESC'];?></td><td width="2%"></td>
				<td width="50%" align="left" valign="top"><?php echo $vetor_VISITAS415['CLASS415_DESCRICAO'];?></td>
			</tr>
			<?php } }?>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
		</table>
	
	<!-- ATENDIMENTOS DE ATES - RIR -->
	<?php
		$sql_VISITASRIR421 = mysql_query("SELECT VIEW_RIR421_VISITAS.CLASSRIR421_TPATIV_DESC, VIEW_RIR421_VISITAS.CLASSRIR421_TPSUBATIV_DESC, VIEW_RIR421_VISITAS.CLASSRIR421_DESCRICAO FROM VIEW_RIR421_VISITAS WHERE VIEW_RIR421_VISITAS.EVENTOS_CODIGO = '$id_evento' ORDER BY VIEW_RIR421_VISITAS.CLASSRIR421_TPATIV_DESC ASC, VIEW_RIR421_VISITAS.CLASSRIR421_TPSUBATIV_DESC ASC;", $db) or die(mysql_error());
		$num_busca_VISITASRIR421 = mysql_num_rows($sql_VISITASRIR421);
		if ($num_busca_VISITASRIR421 == 0) { } else {
	?>
		<table>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
			<tr bgcolor="#B3B3B3"><td colspan="5" align="center" valign="middle"><strong>Atividade(S) de ATES - RIBEIRINHOS</strong></td></tr>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
			<tr bgcolor="#B3B3B3">
				<td width="23%" align="center" valign="middle"><strong>Atividade Principal</strong></td><td width="2%">&nbsp;</td>
				<td width="23%" align="center" valign="middle"><strong>Sub-Atividade</strong></td><td width="2%">&nbsp;</td>
				<td width="50%" align="center" valign="middle"><strong>Descrição</strong></td>
			</tr>
			<?php
				$cor = "#D8D8D8";
				while ($vetor_VISITASRIR421=mysql_fetch_array($sql_VISITASRIR421)) {
					if (strcasecmp($cor, "#FFFFFF") == 0){
						$cor = "#D8D8D8";
					} else {
						$cor = "#FFFFFF";
					}
			?>
			<tr bgcolor="<?php echo $cor; ?>">
				<td width="23%" align="left" valign="top"><?php echo $vetor_VISITASRIR421['CLASSRIR421_TPATIV_DESC'];?></td><td width="2%"></td>
				<td width="23%" align="left" valign="top"><?php echo $vetor_VISITASRIR421['CLASSRIR421_TPSUBATIV_DESC'];?></td><td width="2%"></td>
				<td width="50%" align="left" valign="top"><?php echo $vetor_VISITASRIR421['CLASSRIR421_DESCRICAO'];?></td>
			</tr>
			<?php } }?>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
		</table>

	<!-- ATENDIMENTOS DE REPARAÇÃO - RIR -->
	<?php
		$sql_VISITASRIR415 = mysql_query("SELECT VIEW_RIR415_VISITAS.CLASSRIR415_TPATIV_DESC, VIEW_RIR415_VISITAS.CLASSRIR415_TPSUBATIV_DESC, VIEW_RIR415_VISITAS.CLASSRIR415_DESCRICAO FROM VIEW_RIR415_VISITAS WHERE VIEW_RIR415_VISITAS.EVENTOS_CODIGO = '$id_evento' ORDER BY VIEW_RIR415_VISITAS.CLASSRIR415_TPATIV ASC, VIEW_RIR415_VISITAS.CLASSRIR415_TPSUBATIV_DESC ASC;", $db) or die(mysql_error());
		$num_busca_VISITASRIR415 = mysql_num_rows($sql_VISITASRIR415);
		if ($num_busca_VISITASRIR415 == 0) { } else {
	?>
		<table>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
			<tr bgcolor="#B3B3B3"><td colspan="5" align="center" valign="middle"><strong>Atividade(S) de REPARAÇÃO RURAL - RIBEIRINHOS</strong></td></tr>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
			<tr bgcolor="#B3B3B3">
				<td width="23%" align="center" valign="middle"><strong>Atividade Principal</strong></td><td width="2%">&nbsp;</td>
				<td width="23%" align="center" valign="middle"><strong>Sub-Atividade</strong></td><td width="2%">&nbsp;</td>
				<td width="50%" align="center" valign="middle"><strong>Descrição</strong></td>
			</tr>
			<?php
				$cor = "#D8D8D8";
				while ($vetor_VISITASRIR415=mysql_fetch_array($sql_VISITASRIR415)) {
					if (strcasecmp($cor, "#FFFFFF") == 0){
						$cor = "#D8D8D8";
					} else {
						$cor = "#FFFFFF";
					}
			?>
			<tr bgcolor="<?php echo $cor; ?>">
				<td width="23%" align="left" valign="top"><?php echo $vetor_VISITASRIR415['CLASSRIR415_TPATIV_DESC'];?></td><td width="2%"></td>
				<td width="23%" align="left" valign="top"><?php echo $vetor_VISITASRIR415['CLASSRIR415_TPSUBATIV_DESC'];?></td><td width="2%"></td>
				<td width="50%" align="left" valign="top"><?php echo $vetor_VISITASRIR415['CLASSRIR415_DESCRICAO'];?></td>
			</tr>
			<?php } }?>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
		</table>
	
	<!-- ATENDIMENTOS DE RIBEIRINHOS -->
	<?php
		$sql_VISITASRIR = mysql_query("SELECT VIEW_RIR_VISITAS.CLASSRIR_TPATIV_DESC, VIEW_RIR_VISITAS.CLASSRIR_TPSUBATIV_DESC, VIEW_RIR_VISITAS.CLASSRIR_DESCRICAO FROM VIEW_RIR_VISITAS WHERE VIEW_RIR_VISITAS.EVENTOS_CODIGO = '$id_evento' ORDER BY VIEW_RIR_VISITAS.CLASSRIR_TPATIV_DESC ASC, VIEW_RIR_VISITAS.CLASSRIR_TPSUBATIV_DESC ASC;", $db) or die(mysql_error());
		$num_busca_VISITASRIR = mysql_num_rows($sql_VISITASRIR);
		if ($num_busca_VISITASRIR == 0) { } else {
	?>
		<table>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
			<tr bgcolor="#B3B3B3"><td colspan="5" align="center" valign="middle"><strong>Atividade(S) do Projeto RIBEIRINHOS</strong></td></tr>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
			<tr bgcolor="#B3B3B3">
				<td width="23%" align="center" valign="middle"><strong>Atividade Principal</strong></td><td width="2%">&nbsp;</td>
				<td width="23%" align="center" valign="middle"><strong>Sub-Atividade</strong></td><td width="2%">&nbsp;</td>
				<td width="50%" align="center" valign="middle"><strong>Descrição</strong></td>
			</tr>
			<?php
				$cor = "#D8D8D8";
				while ($vetor_VISITASRIR=mysql_fetch_array($sql_VISITASRIR)) {
					if (strcasecmp($cor, "#FFFFFF") == 0){
						$cor = "#D8D8D8";
					} else {
						$cor = "#FFFFFF";
					}
			?>
			<tr bgcolor="<?php echo $cor; ?>">
				<td width="23%" align="left" valign="top"><?php echo $vetor_VISITASRIR['CLASSRIR_TPATIV_DESC'];?></td><td width="2%"></td>
				<td width="23%" align="left" valign="top"><?php echo $vetor_VISITASRIR['CLASSRIR_TPSUBATIV_DESC'];?></td><td width="2%"></td>
				<td width="50%" align="left" valign="top"><?php echo $vetor_VISITASRIR['CLASSRIR_DESCRICAO'];?></td>
			</tr>
			<?php } }?>
			<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
		</table>

	<!-- TECNICOS -->
	<?php
		$sql_TECNICOS = mysql_query("SELECT DISTINCT TAB_APOIO_TECNICOS.DESCRICAO AS TECNICOS_TECNICO_DESC FROM TAB_415421_TECNICOS LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_415421_TECNICOS.TECNICOS_TECNICO = TAB_APOIO_TECNICOS.ID WHERE TAB_415421_TECNICOS.EVENTOS_CODIGO = '$id_evento' ORDER BY TECNICOS_TECNICO_DESC ASC;", $db) or die(mysql_error());
	?>
	<table>
		<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
		<tr bgcolor="#B3B3B3"><td colspan="5" align="center" valign="middle"><strong>Técnico(s) Responsável(is)</strong></td></tr>
		<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
		<?php
			$cor = "#D8D8D8";
			while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) {
				if (strcasecmp($cor, "#FFFFFF") == 0){
					$cor = "#D8D8D8";
				} else {
					$cor = "#FFFFFF";
				}
		?>
		<tr bgcolor="<?php echo $cor; ?>">
			<td align="left" valign="top"><?php echo $vetor_TECNICOS['TECNICOS_TECNICO_DESC'];?></td>
		</tr>
		<?php }?>
		<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
	</table>
	<!-- REGISTRO FOTOGRÁFICO -->
	<?php
		$sql_IMAGENS = mysql_query("SELECT TAB_415421_IMAGENS.IMAGEM_NOME, TAB_415421_IMAGENS.IMAGEM_LEGENDA FROM TAB_415421_IMAGENS WHERE TAB_415421_IMAGENS.EVENTOS_CODIGO = '$id_evento' ORDER BY TAB_415421_IMAGENS.IMAGEM_LEGENDA ASC;", $db) or die(mysql_error());
	?>
	<table>
		<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
		<tr bgcolor="#B3B3B3"><td colspan="5" align="center" valign="middle"><strong>Registro Fotográfico</strong></td></tr>
		<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
		<tr bgcolor="#B3B3B3">
			<td width="50%" align="center" valign="middle">Imagem</td><td width="2%">&nbsp;</td>
			<td width="48%" align="center" valign="middle">Legenda</td>
		</tr>
		<?php
			$cor = "#D8D8D8";
			while ($vetor_IMAGENS=mysql_fetch_array($sql_IMAGENS)) {
				if (strcasecmp($cor, "#FFFFFF") == 0){
					$cor = "#D8D8D8";
				} else {
					$cor = "#FFFFFF";
				}
		?>
		<tr bgcolor="<?php echo $cor; ?>">
			<td width="50%" align="left" valign="top"><img src="imagens/<?php echo $vetor_IMAGENS['IMAGEM_NOME']; ?>" width="400"></td><td width="2%"></td>
			<td width="48%" align="left" valign="top"><?php echo $vetor_IMAGENS['IMAGEM_LEGENDA'];?></td>
		</tr>
		<?php }?>
		<tr bgcolor="#B3B3B3"><td colspan="5">&nbsp;</td></tr>
	</table><hr>
    <?php } ?>        
</body>
</html>
<?php
}
}
?>