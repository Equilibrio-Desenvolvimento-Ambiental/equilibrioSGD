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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id = $_GET['id'];
			$sql_FICHA_MATRICULA = mysql_query("SELECT TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_FOTOPESSOAL, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ATES_NUMEROCOOPP, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME, TAB_APOIO_GENERO.DESCRICAO AS FISH_FCOMP_GENERO_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_IDADE, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_DTNASC, TAB_APOIO_ESTADOCIVIL.DESCRICAO AS FISH_FCOMP_ESTADOCIVIL_DESC, TAB_APOIO_NACIONALIDADES.DESCRICAO AS FISH_FCOMP_NACIONALIDADE_DESC, TAB_APOIO_MUNICIPIOS_NATURALIDADE.DESCRICAO AS FISH_FCOMP_NATURALIDADE_MUNIC_DESC, TAB_APOIO_UF_NATURALIDADE.SIGLA AS FISH_FCOMP_NATURALIDADE_UF_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_CPF_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_ORGAO, TAB_APOIO_UF_RG.SIGLA AS FISH_FCOMP_RG_UF_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_DTREGISTRO, TAB_APOIO_OCUPACAO.DESCRICAO AS FISH_FCOMP_OCUPACAO_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_DTREGISTRO, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_LOGR, TAB_APOIO_BAIRROS.DESCRICAO AS FISH_FAM_ENDURB_LOCAL_DESC, TAB_APOIO_MUNICIPIOS_URBANO.DESCRICAO AS FISH_FAM_ENDURB_MUNIC_DESC, TAB_APOIO_UF_URBANO.SIGLA AS FISH_FAM_ENDURB_UF_DESC, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOGR, TAB_APOIO_LOCALIDADES.DESCRICAO AS FISH_FAM_ENDRUR_LOCAL_DESC, TAB_APOIO_MUNICIPIOS_RURAL.DESCRICAO AS FISH_FAM_ENDRUR_MUNIC_DESC, TAB_APOIO_UF_RURAL.SIGLA AS FISH_FAM_ENDURB_UF_DESC, TAB_FISH_FAMILIAS.FISH_FAM_TELEFONES FROM TAB_FISH_FAMILIAS_COMPOSICAO LEFT OUTER JOIN TAB_APOIO_GENERO ON TAB_APOIO_GENERO.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_GENERO LEFT OUTER JOIN TAB_APOIO_ESTADOCIVIL ON TAB_APOIO_ESTADOCIVIL.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ESTADOCIVIL LEFT OUTER JOIN TAB_APOIO_NACIONALIDADES ON TAB_APOIO_NACIONALIDADES.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NACIONALIDADE LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_NATURALIDADE ON TAB_APOIO_MUNICIPIOS_NATURALIDADE.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NATURALIDADE LEFT OUTER JOIN TAB_APOIO_UF AS TAB_APOIO_UF_NATURALIDADE ON TAB_APOIO_UF_NATURALIDADE.ID = TAB_APOIO_MUNICIPIOS_NATURALIDADE.UF LEFT OUTER JOIN TAB_APOIO_UF AS TAB_APOIO_UF_RG ON TAB_APOIO_UF_RG.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_UF LEFT OUTER JOIN TAB_APOIO_OCUPACAO ON TAB_APOIO_OCUPACAO.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_OCUPACAO LEFT OUTER JOIN TAB_FISH_FAMILIAS ON TAB_FISH_FAMILIAS.FISH_FAM_ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_BAIRROS ON TAB_APOIO_BAIRROS.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_BAIRRO LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_URBANO ON TAB_APOIO_MUNICIPIOS_URBANO.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_MUNIC LEFT OUTER JOIN TAB_APOIO_UF AS TAB_APOIO_UF_URBANO ON TAB_APOIO_UF_URBANO.ID = TAB_APOIO_MUNICIPIOS_URBANO.UF LEFT OUTER JOIN TAB_APOIO_LOCALIDADES ON TAB_APOIO_LOCALIDADES.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOCAL LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_RURAL ON TAB_APOIO_MUNICIPIOS_RURAL.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_MUNIC LEFT OUTER JOIN TAB_APOIO_UF AS TAB_APOIO_UF_RURAL ON TAB_APOIO_UF_RURAL.ID = TAB_APOIO_MUNICIPIOS_RURAL.UF WHERE TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ID = '$id';", $db) or die(mysql_error());
			$vetor_FICHA_MATRICULA = mysql_fetch_array($sql_FICHA_MATRICULA);
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
.quebrapagina {
   page-break-before: always;
   page-break-inside: avoid;
}
</style>
</head>
<body>
<center>
<p><strong>FICHA DE MATRÍCULA</strong></p><br/>
<p><strong>COOPERATIVA DOS PESCADORES DE BELO MONTE</strong></p>
<p>Fundada em 22/06/2018, inscrita no CNPJ/MF Nº 33.989.440/0001-72, em 25/06/19.</p><br/>
</center>
<table width="100%" height="165px">
	<tbody>
		<tr>
			<td align="center" width="125px">
				<img src="fotospessoais/<?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_FOTOPESSOAL']; ?>" width="120px" height="160px">
			</td>
			<td align="center">
				<p><strong>MATRÍCULA DE COOPERADO</strong></p>
				<p><strong><?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_ATES_NUMEROCOOPP']; ?></strong></p>
				<p><strong><?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_NOME']; ?></strong></p>
			</td>
		</tr>
	</tbody>
</table>
<p> </p>
<p><strong>Nome</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_NOME']; ?>, <strong>Gênero</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_GENERO_DESC']; ?>, <strong>Admissão na Cooperativa</strong>: ____/____/____, <strong>Idade</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_IDADE']; ?> anos, <strong>Data de Nascimento</strong>: <?php if(!empty($vetor_FICHA_MATRICULA['FISH_FCOMP_DTNASC'])) { echo date('d/m/Y', strtotime($vetor_FICHA_MATRICULA['FISH_FCOMP_DTNASC'])); } else { echo '___/___/_____';} ?>, <strong>Estado Civil</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_ESTADOCIVIL_DESC']; ?>, <strong>Nacionalidade</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_NACIONALIDADE_DESC']; ?>, <strong>Naturalidade</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_NATURALIDADE_MUNIC_DESC']; ?>/<?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_NATURALIDADE_UF_DESC']; ?>, <strong>C.P.F.</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_CPF_NUMERO']; ?>, <strong>R.G.:</strong> <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_RG_NUMERO']; ?>, <strong>expedido por</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_RG_ORGAO']; ?>/<?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_RG_UF_DESC']; ?>, <strong>em</strong>: <?php if(!empty($vetor_FICHA_MATRICULA['FISH_FCOMP_RG_DTREGISTRO'])) { echo date('d/m/Y', strtotime($vetor_FICHA_MATRICULA['FISH_FCOMP_RG_DTREGISTRO'])); } else { echo '___/___/_____';} ?>, <strong>Profissão</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_OCUPACAO_DESC']; ?>, <strong>Registro Profissional de Pesca</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FCOMP_RGP_NUMERO']; ?>, <strong>emitido em</strong>: <?php if(!empty($vetor_FICHA_MATRICULA['FISH_FCOMP_RGP_DTREGISTRO'])) { echo date('d/m/Y', strtotime($vetor_FICHA_MATRICULA['FISH_FCOMP_RGP_DTREGISTRO'])); } else { echo '___/___/_____';} ?>, <?php if($vetor_FICHA_MATRICULA['FISH_FAM_ENDURB']==1){?> <strong>Endereço</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FAM_ENDURB_LOGR']; ?>, <strong>Bairro</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FAM_ENDURB_LOCAL_DESC']; ?>, <strong>Município</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FAM_ENDURB_MUNIC_DESC']; ?>, <strong>U.F.</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FAM_ENDURB_UF_DESC']; ?>, <strong>C.E.P.</strong>:____________,<?php }?><?php if($vetor_FICHA_MATRICULA['FISH_FAM_ENDRUR']==1){?> <strong>Endereço Rural</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FAM_ENDRUR_LOGR']; ?>, <strong>Localidade</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FAM_ENDRUR_LOCAL_DESC']; ?>, <strong>Município</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FAM_ENDRUR_MUNIC_DESC']; ?>, <strong>U.F.</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FAM_ENDURB_UF_DESC']; ?>, <strong>C.E.P.</strong>:____________,<?php } ?> <strong>Telefones</strong>: <?php echo $vetor_FICHA_MATRICULA['FISH_FAM_TELEFONES']; ?>, <strong>E-mail</strong>: ______________________________________.</p>
<p> </p>
<p><strong>Conta/Operação</strong>: _____________, <strong>Agência</strong>: __________, <strong>Banco</strong>: ________________, <strong>Município</strong>: ___________________ – ___</p>
<p><strong>Número do Título Eleitoral</strong>: ______________________________________________, <strong>Município</strong>: ___________________ – ___.</p>
<p> </p>
<table style="width: 100%;">
	<tbody>
		<tr>
			<td style="width: 50%; text-align: center;">
				<p> ____________________________________</p>
				<p><strong>Assinatura do Cooperado</strong></p>
			</td>
			<td style="width: 50%; text-align: center;">
				<p> ____________________________________</p>
				<p><strong>Assinatura do Diretor Presidente</strong></p>
			</td>
		</tr>
		<tr>
			<td style="width: 100%;" colspan="2">
				<p style="text-align: center;"><strong> </strong></p>
				<p style="text-align: center;"><strong>Testemunhas:  1)</strong> CPF:____________________ Assinatura: ______________________  </p>
				<p style="text-align: center;"><strong>                          2)</strong> CPF:____________________ Assinatura: ______________________   </p>
				<p style="text-align: center;"> </p>
			</td>
		</tr>
		<tr>
			<td style="width: 100%;" colspan="2">
				<p><font color="#FF0004"><strong>TERMO DE:</strong>  [    ]  Demissão    [    ]    Eliminação    [    ]    Exclusão       –     Data:  ____/____/____</p>
<p>Motivos:__________________________________________________________________________________________________</p>			<p>_________________________________________________________________________________________________________</p>
<p>Observações:______________________________________________________________________________________________</p>			<p>_________________________________________________________________________________________________________</font></p>
			</td>
		</tr>
		<tr>
			<td style="width: 50%; text-align: center;">
				<p><font color="#FF0004">___________________________________</font></p>
				<p><font color="#FF0004"><strong>Assinatura do Cooperado Desligado</strong></font></p>
			</td>
			<td style="width: 50%; text-align: center;">
				<p><font color="#FF0004">____________________________________</font></p>
				<p><font color="#FF0004"><strong>Assinatura do Diretor Presidente</strong></font></p>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>
<?php
}
}
?>