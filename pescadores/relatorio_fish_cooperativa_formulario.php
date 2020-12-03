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
			$id_familia = $_GET['id_familia'];
			$sql_FORMULARIO = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ATES_NUMEROCOOPP, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_ORGAO, TAB_APOIO_UF.SIGLA AS FISH_FCOMP_RG_UF_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_CPF_NUMERO, TAB_APOIO_PARENTESCO.DESCRICAO AS FISH_FCOMP_PARENTESCO_DESC, TAB_APOIO_ATIVECONOMICA_PRINC.DESCRICAO AS FISH_COOP_ATIVECON_PRINC_DESC, TAB_APOIO_ATIVECONOMICA_SECOND.DESCRICAO AS FISH_COOP_ATIVECON_SECOND_DESC, TAB_APOIO_BOOLEANO_ATIVPESCA.DESCRICAO AS FISH_COOP_ATIVPESCA_DESC, TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ATIVPESCATEMPO, TAB_APOIO_UNIDMED_TEMPO.DESCRICAO AS FISH_COOP_ATIVPESCAUNIT_DESC, TAB_APOIO_ATIVPESCA.DESCRICAO AS FISH_COOP_ATIVPESCATIPO_DESC, TAB_FISH_FAMILIAS.FISH_FAM_TELEFONES, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_LOGR, TAB_APOIO_BAIRROS.DESCRICAO AS FISH_FAM_ENDURB_LOCAL_DESC, TAB_APOIO_MUNICIPIOS_URBANO.DESCRICAO AS FISH_FAM_ENDURB_MUNIC_DESC, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_COMPL, TAB_APOIO_USOIMOVEL_URBANO.DESCRICAO AS FISH_FAM_ENDURB_USO_DESC, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOGR, TAB_APOIO_LOCALIDADES.DESCRICAO AS FISH_FAM_ENDRUR_LOCAL_DESC, TAB_APOIO_MUNICIPIOS_RURAL.DESCRICAO AS FISH_FAM_ENDRUR_MUNIC_DESC, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_COMPL, TAB_APOIO_USOIMOVEL_RURAL.DESCRICAO AS FISH_FAM_ENDRUR_USO_DESC, TAB_APOIO_BOOLEANO_PESCANDO.DESCRICAO AS FISH_COOCAR_PESCANDO_DESC, TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_MOTIVO, TAB_APOIO_BOOLEANO_SOZINHO.DESCRICAO AS FISH_COOCAR_SOZINHO_DESC, TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_QTS_PESSOAS, TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_QTS_FAMILIA, TAB_APOIO_BOOLEANO_ORNAMENTAL.DESCRICAO AS FISH_COOCAR_ORNAMENTAL_DESC, TAB_APOIO_BOOLEANO_CONSUMO.DESCRICAO AS FISH_COOCAR_CONSUMO_DESC, TAB_APOIO_PESCA_TIPO.DESCRICAO AS FISH_COOCAR_DESTINO_DESC, TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_DIAS, TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_VEZES, VIEW_FISH_COOCAR_LOCAIS.FISH_COOCAR_LOCAIS, VIEW_FISH_COOCAR_COMERCIO.FISH_COOCAR_COMERCIO, TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_DESP_COMBS, TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_DESP_GELO, TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_DESP_RANCHO, TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_DESP_OUTROS FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_PARENTESCO ON TAB_APOIO_PARENTESCO.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_PARENTESCO LEFT OUTER JOIN TAB_FISH_COOP_ENTREVISTA ON TAB_FISH_COOP_ENTREVISTA.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_ATIVECONOMICA AS TAB_APOIO_ATIVECONOMICA_PRINC ON TAB_APOIO_ATIVECONOMICA_PRINC.ID = TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ATIVPRINCIPAL LEFT OUTER JOIN TAB_APOIO_ATIVECONOMICA AS TAB_APOIO_ATIVECONOMICA_SECOND ON TAB_APOIO_ATIVECONOMICA_SECOND.ID = TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ATIVSECUNDARIA LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ATIVPESCA ON TAB_APOIO_BOOLEANO_ATIVPESCA.ID = TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ATIVPESCA LEFT OUTER JOIN TAB_APOIO_UNIDMED_TEMPO ON TAB_APOIO_UNIDMED_TEMPO.ID = TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ATIVPESCAUNIT LEFT OUTER JOIN TAB_APOIO_ATIVPESCA ON TAB_APOIO_ATIVPESCA.ID = TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ATIVPESCATIPO LEFT OUTER JOIN TAB_APOIO_BAIRROS ON TAB_APOIO_BAIRROS.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_BAIRRO LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_URBANO ON TAB_APOIO_MUNICIPIOS_URBANO.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_MUNIC LEFT OUTER JOIN TAB_APOIO_USOIMOVEL AS TAB_APOIO_USOIMOVEL_URBANO ON TAB_APOIO_USOIMOVEL_URBANO.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_USO LEFT OUTER JOIN TAB_APOIO_LOCALIDADES ON TAB_APOIO_LOCALIDADES.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOCAL LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_RURAL ON TAB_APOIO_MUNICIPIOS_RURAL.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_MUNIC LEFT OUTER JOIN TAB_APOIO_USOIMOVEL AS TAB_APOIO_USOIMOVEL_RURAL ON TAB_APOIO_USOIMOVEL_RURAL.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_USO LEFT OUTER JOIN TAB_FISH_COOP_CARACTERIZACAO ON TAB_FISH_COOP_CARACTERIZACAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_PESCANDO ON TAB_APOIO_BOOLEANO_PESCANDO.ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_PESCANDO LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_SOZINHO ON TAB_APOIO_BOOLEANO_SOZINHO.ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_SOZINHO LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ORNAMENTAL ON TAB_APOIO_BOOLEANO_ORNAMENTAL.ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_ORNAMENTAL LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_CONSUMO ON TAB_APOIO_BOOLEANO_CONSUMO.ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_CONSUMO LEFT OUTER JOIN TAB_APOIO_PESCA_TIPO ON TAB_APOIO_PESCA_TIPO.ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_DESTINO LEFT OUTER JOIN VIEW_FISH_COOCAR_COMERCIO ON VIEW_FISH_COOCAR_COMERCIO.FISH_COOCAR_ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_ID LEFT OUTER JOIN VIEW_FISH_COOCAR_LOCAIS ON VIEW_FISH_COOCAR_LOCAIS.FISH_COOCAR_ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_UF.ID =  TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_UF WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia' AND TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ID IS NOT NULL AND TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_PARENTESCO = 1;", $db) or die(mysql_error());
			$vetor_FORMULARIO = mysql_fetch_array($sql_FORMULARIO);
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
   color: #FFFFFF;
   page-break-before: always;
   page-break-inside: avoid;
}
</style>
</head>
<body>
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td style="width: 50%; text-align: left;"><img src="imgs/Logo NE.png" width="200px"></td>
				<td style="width: 50%; text-align: right;"><img src="imgs/Logo Equilibrio.jpg" width="200px"></td>
			</tr>
		</tbody>
	</table>
	<h4 style="text-align: left;">Formulário: LEVANTAMENTO DE DADOS DE CAMPO DOS COOPERADOS</h4>
	<table style="width: 100%;" border="1">
		<tbody>
			<tr>
				<td style="text-align: left;"><strong>Formulário n<u><sup>o</sup></u>: [__________]</strong></td>
				<td style="text-align: left;"><strong>Código NESA n<u><sup>o:</sup></u> [__________]</strong></td>
				<td style="text-align: left;"><strong>N_FAM_SIS Família: [__________]</strong></td>
			</tr>
			<tr>
				<td style="text-align: left;" colspan="2"><strong>Pesquisadores: [__________________________________________]</strong></td>
				<td style="text-align: left;"><strong>Data : ____/___/____</strong></td>
			</tr>
			<tr>
				<td style="text-align: left;" colspan="2"><strong>Localidade: [_____________________________________________]</strong></td>
				<td style="text-align: left;"><strong>Nº Matrícula COOPPBM: [__________]</strong></td>
			</tr>
		</tbody>
	</table><br>
	<strong>1. IDENTIFICAÇÃO</strong>
	<table border="1" bordercolor="#000000" width="100%">
		<tbody>
			<tr>
				<td colspan="3" width="21%">
					<p><strong> Nome do Chefe da Família:</strong></p>
				</td>
				<td colspan="6" width="78%">
					<p> <?php echo $vetor_FORMULARIO['FISH_FCOMP_NOME']; ?></p>
				</td>
			</tr>
			<tr>
				<td width="8%">
					<p><strong> RG:</strong></p>
				</td>
				<td colspan="4" width="40%">
					<p> <?php echo $vetor_FORMULARIO['FISH_FCOMP_RG_NUMERO'].' '.$vetor_FORMULARIO['FISH_FCOMP_RG_ORGAO'].'/'.$vetor_FORMULARIO['FISH_FCOMP_RG_UF_DESC']; ?></p>
				</td>
				<td width="6%">
					<p><strong> CPF:</strong></p>
				</td>
				<td colspan="3" width="44%">
					<p> <?php echo $vetor_FORMULARIO['FISH_FCOMP_CPF_NUMERO']; ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="5" width="48%">
					<p><strong> Qual a atividade econômica principal da família?</strong></p>
				</td>
				<td colspan="4" width="51%">
					<p> <?php echo $vetor_FORMULARIO['FISH_COOP_ATIVECON_PRINC_DESC']; ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="5" width="48%">
					<p><strong> Qual a atividade econômica secundária da família?</strong></p>
				</td>
				<td colspan="4" width="51%">
					<p> <?php echo $vetor_FORMULARIO['FISH_COOP_ATIVECON_SECOND_DESC']; ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="5" width="48%">
					<p><strong> Pratica a atividade de pesca?</strong><br> <?php echo $vetor_FORMULARIO['FISH_COOP_ATIVPESCA_DESC'].', '.$vetor_FORMULARIO['FISH_COOP_ATIVPESCATEMPO'].' '.$vetor_FORMULARIO['FISH_COOP_ATIVPESCAUNIT_DESC']; ?></p>
				</td>
				<td colspan="4" width="51%">
					<p> Sim [__]   Não [__]   Desde quando?___________ </p>
				</td>
			</tr>
			<tr>
				<td colspan="4" width="41%">
					<p><strong> Se pratica, que tipo de pesca?</strong><br>
					<?php echo $vetor_FORMULARIO['FISH_COOP_ATIVPESCATIPO_DESC']; ?></p>
				</td>
				<td colspan="5" width="58%">
					<p> [__] Subsistência              [__] Complementação da renda<br> [__] Comercial                  [__] Lazer</p>
				</td>
			</tr>
			<tr>
				<td colspan="9" width="100%">
					<p><strong> A família é, ou já foi, atendida por algum projeto?</strong>                Sim [__]   Não [__]<br> Se sim, Qual?</p>
				</td>
			</tr>
			<tr>
				<td colspan="9" width="100%">
					<p><strong> Telefone(s) de contato:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_TELEFONES']; ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="9" width="100%">
					<p><strong> Energia elétrica: </strong> [__] Rede elétrica   [__] Solar   [__] Gerador   [__] Outro:</p>
				</td>
			</tr>
			<tr>
				<td colspan="2" rowspan="3" width="17%">
					<p><strong>Endereço Urbano</strong></p>
				</td>
				<td colspan="6" width="52%">
					<p><strong> Rua:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDURB_LOGR']; ?></p>
				</td>
				<td width="29%">
					<p><strong> Bairro:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDURB_LOCAL_DESC']; ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="6" width="52%">
					<p><strong> Ponto de referência:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDURB_COMPL']; ?></p><br>
				</td>
				<td width="29%">
					<p><strong> Município:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDURB_MUNIC_DESC']; ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="7" width="82%">
					<p><strong> Qual o uso principal do imóvel?</strong>  [__] Residência   [__] Produção/Comercial   [__] Lazer</p>
				</td>
			</tr>
			<tr>
				<td colspan="2" rowspan="3" width="17%">
					<p><strong> Endereço Rural</strong></p>
				</td>
				<td colspan="6" width="52%">
					<p><strong> Estrada:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDRUR_LOGR']; ?></p>
				</td>
				<td width="29%">
					<p><strong> Setor/Região:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDRUR_LOCAL_DESC']; ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="6" width="52%">
					<p><strong> Ponto de referência:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDRUR_COMPL']; ?></p><br>
				</td>
				<td width="29%">
					<p><strong> Município:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDRUR_MUNIC_DESC']; ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="7" width="82%">
					<p><strong> Qual o uso principal do imóvel?</strong>  [__] Residência   [__] Produção/Comercial   [__] Lazer</p>
					<p><strong> Coordenada geográfica:</strong> Padronizar forma de coleta de informação.</p>
				</td>
			</tr>
			<tr>
				<td colspan="2" rowspan="2" width="17%">
					<p><strong>Acesso Rural</strong><br>Distância do centro comercial, tempo e forma de deslocamento</p>
				</td>
				<td colspan="7" width="82%">
					<strong> Por terra [__] - Descrever:</strong>
					<p>________________________________________________________________________________________________________</p><p>________________________________________________________________________________________________________</p><p>________________________________________________________________________________________________________</p>
				</td>
			</tr>
			<tr>
				<td colspan="7" width="82%">
					<strong>Por água [__] - Descrever:</strong><p>________________________________________________________________________________________________________</p><p>________________________________________________________________________________________________________</p><p>________________________________________________________________________________________________________</p>
				</td>
			</tr>
		</tbody>
	</table>
	<p>No caso de haver mais endereços, anotar - <strong>incluir no banco de dados</strong></p>
    <hr class="quebrapagina">
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td style="width: 50%; text-align: left;"><img src="imgs/Logo NE.png" width="175px"></td>
				<td style="width: 50%; text-align: right;"><img src="imgs/Logo Equilibrio.jpg" width="175px"></td>
			</tr>
		</tbody>
	</table>

	<?php
		$sql_COMPOSICAO = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_APELIDO, TAB_APOIO_GENERO.DESCRICAO AS FISH_FCOMP_GENERO_DESC, TAB_APOIO_PARENTESCO.DESCRICAO AS FISH_FCOMP_PARENTESCO_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_DTNASC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_IDADE, TAB_APOIO_ESTADOCIVIL.DESCRICAO AS FISH_FCOMP_ESTADOCIVIL_DESC, TAB_APOIO_NACIONALIDADES.DESCRICAO AS FISH_FCOMP_NACIONALIDADE_DESC, TAB_APOIO_MUNICIPIOS_NATURAL.DESCRICAO AS FISH_FCOMP_NATURAL_MUNIC_DESC, TAB_APOIO_UFS_NATURAL.SIGLA AS FISH_FCOMP_NATURAL_UF_DESC, TAB_APOIO_OCUPACAO.DESCRICAO AS FISH_FCOMP_OCUPACAO_DESC, TAB_APOIO_BOOLEANO_ALFAB_LER.DESCRICAO AS FISH_FCOMP_ALFAB_LER_DESC, TAB_APOIO_BOOLEANO_ALFAB_ESCREVER.DESCRICAO AS FISH_FCOMP_ALFAB_ESCREVER_DESC, TAB_APOIO_BOOLEANO_RGP_POSSUI.DESCRICAO AS FISH_FCOMP_RGP_POSSUI_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_DTREGISTRO, TAB_APOIO_BOOLEANO_RG_POSSUI.DESCRICAO AS FISH_FCOMP_RG_POSSUI_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_DTREGISTRO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_ORGAO, TAB_APOIO_UFS_RG.SIGLA AS FISH_FCOMP_RG_POSSUI_UF, TAB_APOIO_BOOLEANO_CPF_POSSUI.DESCRICAO AS FISH_FCOMP_CPF_POSSUI_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_CPF_NUMERO, TAB_APOIO_BOOLEANO_RESIDENTE.DESCRICAO AS FISH_FCOMP_RESIDENTE_DESC FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_GENERO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_GENERO = TAB_APOIO_GENERO.ID LEFT OUTER JOIN TAB_APOIO_PARENTESCO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_PARENTESCO = TAB_APOIO_PARENTESCO.ID LEFT OUTER JOIN TAB_APOIO_OCUPACAO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_OCUPACAO = TAB_APOIO_OCUPACAO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ALFAB_LER ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ALFAB_LER = TAB_APOIO_BOOLEANO_ALFAB_LER.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ALFAB_ESCREVER ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ALFAB_ESCREVER = TAB_APOIO_BOOLEANO_ALFAB_ESCREVER.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_RGP_POSSUI ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_POSSUI = TAB_APOIO_BOOLEANO_RGP_POSSUI.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_RG_POSSUI ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_POSSUI = TAB_APOIO_BOOLEANO_RG_POSSUI.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_CPF_POSSUI ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_CPF_POSSUI = TAB_APOIO_BOOLEANO_CPF_POSSUI.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_RESIDENTE ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RESIDENTE = TAB_APOIO_BOOLEANO_RESIDENTE.ID LEFT OUTER JOIN TAB_APOIO_ESTADOCIVIL ON TAB_APOIO_ESTADOCIVIL.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ESTADOCIVIL LEFT OUTER JOIN TAB_APOIO_NACIONALIDADES ON TAB_APOIO_NACIONALIDADES.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NACIONALIDADE LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_NATURAL ON TAB_APOIO_MUNICIPIOS_NATURAL.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NATURALIDADE LEFT OUTER JOIN TAB_APOIO_UF AS TAB_APOIO_UFS_NATURAL ON TAB_APOIO_UFS_NATURAL.ID = TAB_APOIO_MUNICIPIOS_NATURAL.UF LEFT OUTER JOIN TAB_APOIO_UF AS TAB_APOIO_UFS_RG ON TAB_APOIO_UFS_RG.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_UF WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia' ORDER BY TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_PARENTESCO ASC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_DTNASC DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_IDADE DESC;", $db) or die( mysql_error());
		$cor = "#D8D8D8";
		$contComponente = 1;
		while ($vetor_COMPOSICAO = mysql_fetch_array($sql_COMPOSICAO)) {
			if (strcasecmp($cor, "#FFFFFF") == 0){
				$cor = "#D8D8D8";
			} else {
				$cor = "#FFFFFF";
			}
	?>
			<table border="1" width="100%">
				<tbody>
					<tr style="height: 35px;">
						<td style="height: 35px;" width="113">
							<p><strong>Nome Completo</strong></p>
							<p><strong>e por Extenso:</strong></p>
						</td>
						<td style="height: 35px;" colspan="5" width="605">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_NOME'];?></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><strong>Apelido:</strong></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_APELIDO'];?></p>
						</td>
						<td style="text-align: center;" rowspan="2" width="76">
							<p><strong>Reside?</strong></p>
						</td>
					</tr>
					<tr style="height: 3px;">
						<td style="height: 3px;" width="113">
							<p><strong>G&ecirc;nero:</strong></p>
						</td>
						<td style="height: 3px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_GENERO_DESC'];?></p>
						</td>
						<td style="height: 3px;" width="113">
							<p><strong>Parentesco:</strong></p>
						</td>
						<td style="height: 3px;" width="151">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_PARENTESCO_DESC'];?></p>
						</td>
						<td style="height: 3px;" width="113">
							<p><strong>Data de Nasc.:</strong></p>
						</td>
						<td style="height: 3px;" width="113">
							<p><?php if(!empty($vetor_COMPOSICAO['FISH_FCOMP_DTNASC'])) { echo date('d/m/Y', strtotime($vetor_COMPOSICAO['FISH_FCOMP_DTNASC'])); } else { echo '___/___/_____';} ?></p>
						</td>
						<td style="height: 3px;" width="113">
							<p><strong>Idade:</strong></p>
						</td>
						<td style="height: 3px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_IDADE'];?></p>
						</td>
					</tr>
					<tr style="height: 35px;">
						<td style="height: 35px;" width="113">
							<p><strong>Estado Civil:</strong></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_ESTADOCIVIL_DESC'];?></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><strong>Nacionalidade:</strong></p>
						</td>
						<td style="height: 35px;" width="151">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_NACIONALIDADE_DESC'];?></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><strong>Natulaidade:</strong></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_NATURAL_MUNIC_DESC'].'/'.$vetor_COMPOSICAO['FISH_FCOMP_NATURAL_UF_DESC'];?></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><strong>Ocupa&ccedil;&atilde;o:</strong></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_OCUPACAO_DESC'];?></p>
						</td>
						<td style="text-align: center; height: 70px;" rowspan="2" width="76">
							<p><strong><?php echo $vetor_COMPOSICAO['FISH_FCOMP_RESIDENTE_DESC'];?></strong></p>
						</td>
					</tr>
					<tr style="height: 35px;">
						<td style="height: 35px;" width="113">
							<p><strong>Sabe ler?</strong></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_ALFAB_LER_DESC'];?></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><strong>Sabe escrever?</strong></p>
						</td>
						<td style="height: 35px;" width="151">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_ALFAB_ESCREVER_DESC'];?></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><strong>Possu&iacute; CPF?</strong></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_CPF_POSSUI_DESC'];?></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><strong>N&uacute;mero:</strong></p>
						</td>
						<td style="height: 35px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_CPF_NUMERO'];?></p>
						</td>
					</tr>
					<tr style="height: 48px;">
						<td style="height: 48px;" width="113">
							<p><strong>Possu&iacute; RG?</strong></p>
						</td>
						<td style="height: 48px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_RG_POSSUI_DESC'];?></p>
						</td>
						<td style="height: 48px;" width="113">
							<p><strong>N&uacute;mero:</strong></p>
						</td>
						<td style="height: 48px;" width="151">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_RG_NUMERO'];?></p>
						</td>
						<td style="height: 48px;" width="113">
							<p><strong>&Oacute;rg&atilde;o Expedidor:</strong></p>
						</td>
						<td style="height: 48px;" width="113">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_RG_ORGAO'].'/'.$vetor_COMPOSICAO['FISH_FCOMP_RG_POSSUI_UF'];?></p>
						</td>
						<td style="height: 48px;" width="113">
							<p><strong>Data de Expedi&ccedil;&atilde;o:</strong></p>
						</td>
						<td style="height: 48px;" width="113">
							<p><?php if(!empty($vetor_COMPOSICAO['FISH_FCOMP_RG_DTREGISTRO'])) { echo date('d/m/Y', strtotime($vetor_COMPOSICAO['FISH_FCOMP_RG_DTREGISTRO'])); } else { echo '___/___/_____';} ?></p>
						</td>
						<td style="text-align: center; height: 107px;" rowspan="2" width="76">
							<p>[_______]</p>
						</td>
					</tr>
					<tr style="height: 59px;">
						<td style="height: 59px;" width="113">
							<p><strong>Possu&iacute; Registro</strong></p>
							<p><strong>Geral de Pesca:</strong></p>
						</td>
						<td style="height: 59px;" width="113"><?php echo $vetor_COMPOSICAO['FISH_FCOMP_RGP_POSSUI_DESC'];?></td>
						<td style="height: 59px;" width="113">
							<p><strong>N&uacute;mero:</strong></p>
						</td>
						<td style="height: 59px;" width="151">
							<p><?php echo $vetor_COMPOSICAO['FISH_FCOMP_RGP_NUMERO'];?></p>
						</td>
						<td style="height: 59px;" width="113">
							<p><strong>Data de Expedi&ccedil;&atilde;o:</strong></p>
						</td>
						<td style="height: 59px;" width="113">
							<p><?php if(!empty($vetor_COMPOSICAO['FISH_FCOMP_RGP_DTREGISTRO'])) { echo date('d/m/Y', strtotime($vetor_COMPOSICAO['FISH_FCOMP_RGP_DTREGISTRO'])); } else { echo '___/___/_____';} ?></p>
						</td>
						<td style="height: 59px;" width="113">
							<p>&nbsp;</p>
						</td>
						<td style="height: 59px;" width="113">&nbsp;</td>
					</tr>
				</tbody>
			</table><br>
	
	<?php 
			$contComponente++;
			if($contComponente>3){ ?>
    			<hr class="quebrapagina">
	<?php
				$contComponente=1;
			}
			} ?>
	
	
    <hr class="quebrapagina">
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td style="width: 50%; text-align: left;"><img src="imgs/Logo NE.png" width="175px"></td>
				<td style="width: 50%; text-align: right;"><img src="imgs/Logo Equilibrio.jpg" width="175px"></td>
			</tr>
		</tbody>
	</table>
	<h3><strong>PESCA</strong></h3>
	<table border="1" bordercolor="#000000" width="100%">
		<tbody>
			<tr>
				<td width="100%">
					<strong> FREQUENCIA DE CONSUMO DE CARNE DE PEIXE DA FAMÍLIA: </strong>(DIAS NA SEMANA)
				</td>
			</tr>
			<tr>
				<td width="100%">
					 [___] 1 dia    [___] 2 dias    [___] 3 dias    [___] 4 dias    [___] 5 dias    [___] 6 dias    [___] Todos os dias
				</td>
			</tr>
		</tbody>
	</table>
	<p><strong> </strong></p>
	<table border="1" bordercolor="#000000" width="100%">
	<tbody>
		<tr>
			<td colspan="2" width="36%">
				</p><strong>Atualmente, você está pescando?</strong></p>
				<p><?php echo $vetor_FORMULARIO['FISH_COOCAR_PESCANDO_DESC']; ?></p>
				<p>1) Sim [__]       2) Não [__]</p>
			</td>
			<td colspan="3" width="63%">
				<p><strong> Se não, por quê? </strong></p>
				______________________________________________________________________________</br>
				______________________________________________________________________________</br>
			</td>
		</tr>
		<tr>
			<td width="30%">
				<p><strong> Você pesca sozinho? </strong><?php echo $vetor_FORMULARIO['FISH_COOCAR_SOZINHO_DESC']; ?></p>
				<p> 1) Sim [__]       2) Não [__]</p>
			</td>
			<td colspan="3" width="28%">
				<p><strong> Com quantas pessoas? </strong><?php echo $vetor_FORMULARIO['FISH_COOCAR_QTS_PESSOAS']; ?></p>
				<p> [______] pessoas</p>
			</td>
			<td width="40%">
				<p><strong> Quantas são da sua família? </strong><?php echo $vetor_FORMULARIO['FISH_COOCAR_QTS_FAMILIA']; ?></p>
				<p> [_____] pessoas da família</p>
			</td>
		</tr>
		<tr>
			<td colspan="3" width="47%">
				<p><strong> Você faz pesca de peixes ornamentais?</strong></p>
				<p> <?php echo $vetor_FORMULARIO['FISH_COOCAR_ORNAMENTAL_DESC']; ?>               1) Sim [__] (2) Não [__]</p>
			</td>
			<td colspan="2" width="52%">
				<p><strong> Você faz pesca de peixes de consumo?</strong></p>
				<p> <?php echo $vetor_FORMULARIO['FISH_COOCAR_CONSUMO_DESC']; ?>              1) Sim [__] (2) Não [__]</p>
			</td>
		</tr>
		<tr>
			<td colspan="5" width="99%">
				<p><strong> O peixe de consumo, você pesca principalmente para: </strong><?php echo $vetor_FORMULARIO['FISH_COOCAR_DESTINO_DESC']; ?>     [__] Vender  [__] Comer</p>
			</td>
		</tr>
		<tr>
			<td colspan="5" width="99%">
				<p><strong> Quantos dias você pesca, em média, por pescaria?</strong> (Fica no Rio)  <?php echo $vetor_FORMULARIO['FISH_COOCAR_DIAS']; ?> dias     [_____] dias</p>
			</td>
		</tr>
		<tr>
			<td colspan="5" width="99%">
				<p><strong> Quantas vezes você vai para o rio pescar por mês?  </strong><?php echo $vetor_FORMULARIO['FISH_COOCAR_VEZES']; ?> vezes     [_____] vezes</p>
			</td>
		</tr>
		<tr>
			<td colspan="5" width="100%">
				<p><strong>Quais os principais locais de pesca? </strong></p>
				<p><?php echo $vetor_FORMULARIO['FISH_COOCAR_LOCAIS']; ?></p>
				________________________________________________________________________________________________________________________________________<br>
				________________________________________________________________________________________________________________________________________<br>
			</td>
		</tr>
		<tr>
			<td colspan="5" width="100%">
				<p><strong>Quais os principais locais em que você vende o peixe?</strong></p>
				<p><?php echo $vetor_FORMULARIO['FISH_COOCAR_COMERCIO']; ?></p>
				_________________________________________________________________________________________________________________________________________<br>
				nos seguintes Municípios:______________________________________________________________________________________________________________<br>
			</td>
		</tr>
	</tbody>
	</table>	
	<p> </p>   
	<hr class="quebrapagina">
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td style="width: 50%; text-align: left;"><img src="imgs/Logo NE.png" width="175px"></td>
				<td style="width: 50%; text-align: right;"><img src="imgs/Logo Equilibrio.jpg" width="175px"></td>
			</tr>
		</tbody>
	</table>
	<table border="1" bordercolor="#000000" width="100%">
		<tbody>
			<tr>
				<td colspan="4" width="100%">
					<strong>Qual o seu gasto por pescaria?</strong>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;" width="24%">
					<strong>Combustível</strong><br>[<?php echo 'R$'.number_format($vetor_FORMULARIO['FISH_COOCAR_DESP_COMBS'],2,',','.'); ?>]
				</td>
				<td style="text-align: center;" width="25%">
					<strong>Gelo (R$)</strong><br>[<?php echo 'R$'.number_format($vetor_FORMULARIO['FISH_COOCAR_DESP_GELO'],2,',','.'); ?>]
				</td>
				<td style="text-align: center;" width="26%">
					<strong>Rencho (R$)</strong><br>[<?php echo 'R$'.number_format($vetor_FORMULARIO['FISH_COOCAR_DESP_RANCHO'],2,',','.'); ?>]
				</td>
				<td style="text-align: center;" width="24%">
					<strong>Outros (R$)</strong><br>[<?php echo 'R$'.number_format($vetor_FORMULARIO['FISH_COOCAR_DESP_OUTROS'],2,',','.'); ?>]
				</td>
			</tr>
			<tr>
				<td colspan="4" width="100%">
					<strong>Qual o seu gasto com aquisição e manutenção dos apetrechos de pesca por ano?</strong>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;" width="24%">
					<strong>Tralhas de pesca (R$)</strong><br>[________________]
				</td>
				<td style="text-align: center;" width="25%">
					<strong>Manutenção de barco (R$)</strong><br>[________________]
				</td>
				<td style="text-align: center;" width="26%">
					<strong>Manutenção de motor (R$)</strong><br>[________________]
				</td>
				<td style="text-align: center;" width="24%">
					<strong>Outros (R$)</strong><br>[________________]
				</td>
			</tr>
			<tr>
				<td colspan="4" width="100%">
					<p><strong>Origem do recurso para aquisição e manutenção dos apetrechos de pesca?</strong></p>
				</td>
			</tr>
			<tr>
				<td colspan="4" width="100%">
					<strong>Pesca com Canoa?          </strong>1) Sim [__]     2) Não [__]     <strong>Quantas? </strong>[____]
				</td>
			</tr>
			<tr>
				<td colspan="4" width="100%">
					<strong>Descrever as Canoas Próprias que utiliza para pescar por tipo e estado de conservação:</strong><br>
					[___] Própria ou [___] Alugada? de [____] metros, de estado de conservação [__] Bom [__] Ruim<br>
					[___] Própria ou [___] Alugada? de [____] metros, de estado de conservação [__] Bom [__] Ruim<br>
					[___] Própria ou [___] Alugada? de [____] metros, de estado de conservação [__] Bom [__] Ruim<br>
					[___] Própria ou [___] Alugada? de [____] metros, de estado de conservação [__] Bom [__] Ruim
				</td>
			</tr>
			<tr>
				<td colspan="4" width="100%">
					<strong>Pesca com Barco?</strong>          1) Sim [__]     2) Não [__]     <strong>Quantos?</strong> [____]
				</td>
			</tr>
			<tr>
				<td colspan="4" width="100%">
					<strong>Descrever os Barcos Próprios que utiliza para pescar por tipo, tamanho e estado de conservação:</strong><br>
					[___] Próprio ou [___] Alugado? de [____] metros de [<em>alumínio</em> (   ), <em>madeira</em> (   )] conservação [__] Bom [__] Ruim<br>
					[___] Próprio ou [___] Alugado? de [____] metros de [<em>alumínio</em> (   ), <em>madeira</em> (   )] conservação [__] Bom [__] Ruim<br>
					[___] Próprio ou [___] Alugado? de [____] metros de [<em>alumínio</em> (   ), <em>madeira</em> (   )] conservação [__] Bom [__] Ruim<br>
					[___] Próprio ou [___] Alugado? de [____] metros de [<em>alumínio</em> (   ), <em>madeira</em> (   )] conservação [__] Bom [__] Ruim
				</td>
			</tr>
			<tr>
				<td colspan="4" width="100%">
					<strong>Pesca com Motor?</strong>          1) Sim [__]     2) Não [__]     <strong>Quantos?</strong> [____]
				</td>
			</tr>
			<tr>
				<td colspan="4" width="100%">
					<strong>Descrever os Motores Próprios que utiliza para pescar por tipo, potência e estado de conservação:</strong><br>
					[___] Próprio ou [___] Alugado? [<em>rabeta</em> (   ), <em>popa</em> (   ), <em>centro </em>(   )] potência [___] HP conservação [__] Boa [__] Ruim<br>
					[___] Próprio ou [___] Alugado? [<em>rabeta</em> (   ), <em>popa</em> (   ), <em>centro </em>(   )] potência [___] HP conservação [__] Boa [__] Ruim<br>
					[___] Próprio ou [___] Alugado? [<em>rabeta</em> (   ), <em>popa</em> (   ), <em>centro </em>(   )] potência [___] HP conservação [__] Boa [__] Ruim<br>
					[___] Próprio ou [___] Alugado? [<em>rabeta</em> (   ), <em>popa</em> (   ), <em>centro </em>(   )] potência [___] HP conservação [__] Boa [__] Ruim
				</td>
			</tr>
		</tbody>
	</table><br>
	<table width="100%">
		<thead align="center">
			<td width="15%"><strong>Tipo</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="15%"><strong>Própria</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="15%"><strong>Material</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="15%"><strong>Tamanho</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="15%"><strong>Conservação</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="15%"><strong>Possui?</strong></td>
		</thead>
		<?php
			$sql_COOP_CARACT_EMBARC = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_APOIO_EMBARC_TIPO.DESCRICAO AS FISH_CPCEMB_TIPO_DESC, TAB_APOIO_BOOLEANO_EMB_PROPRIA.DESCRICAO AS FISH_CPCEMB_PROPRIA_DESC, TAB_APOIO_EMBARC_MATERIAL.DESCRICAO AS FISH_CPCEMB_MATERIAL_DESC, TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_TAMANHO, TAB_APOIO_ESTADOCONSERV.DESCRICAO AS FISH_CPCEMB_CONSERV_DESC FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_COOP_CARACTERIZACAO ON TAB_FISH_COOP_CARACTERIZACAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_FISH_COOCAR_EMBARC ON TAB_FISH_COOCAR_EMBARC.FISH_COOCAR_ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_ID LEFT OUTER JOIN TAB_APOIO_EMBARC_TIPO ON TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_TIPO = TAB_APOIO_EMBARC_TIPO.ID LEFT OUTER JOIN TAB_APOIO_EMBARC_MATERIAL ON TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_MATERIAL = TAB_APOIO_EMBARC_MATERIAL.ID LEFT OUTER JOIN TAB_APOIO_ESTADOCONSERV ON TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_CONSERV = TAB_APOIO_ESTADOCONSERV.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_EMB_PROPRIA ON TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_PROPRIA = TAB_APOIO_BOOLEANO_EMB_PROPRIA.ID WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia' ORDER BY FISH_CPCEMB_TIPO_DESC ASC, FISH_CPCEMB_PROPRIA_DESC DESC, FISH_CPCEMB_MATERIAL_DESC ASC, TAB_FISH_COOCAR_EMBARC.FISH_CPCEMB_TAMANHO DESC, FISH_CPCEMB_CONSERV_DESC ASC;", $db) or die( mysql_error());
			$cor = "#D8D8D8";
			while ($vetor_COOP_CARACT_EMBARC = mysql_fetch_array($sql_COOP_CARACT_EMBARC)) {
				if (strcasecmp($cor, "#FFFFFF") == 0){
					$cor = "#D8D8D8";
				} else {
					$cor = "#FFFFFF";
				}
		?>
		<tr align="center" bgcolor="<?php echo $cor; ?>">
			<td width="15%"><?php echo $vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_TIPO_DESC']; ?></td><td width="1%">&nbsp;</td>
			<td width="15%"><?php echo $vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_PROPRIA_DESC']; ?></td><td width="1%">&nbsp;</td>
			<td width="15%"><?php echo $vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_MATERIAL_DESC']; ?></td><td width="1%">&nbsp;</td>
			<td width="15%"><?php echo number_format($vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_TAMANHO'],2,',','.'); ?></td><td width="1%">&nbsp;</td>
			<td width="15%"><?php echo $vetor_COOP_CARACT_EMBARC['FISH_CPCEMB_CONSERV_DESC']; ?></td><td width="1%">&nbsp;</td>
			<td width="15%">[___]</td>
		</tr>
		<?php } ?>
	</table><hr>
	<table width="100%">
		<thead align="center">
			<td width="15%"><strong>Tipo</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="15%"><strong>Próprio</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="15%">&nbsp;</td>
			<td width="1%">&nbsp;</td>
			<td width="15%"><strong>Potência (HP)</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="15%"><strong>Conservação</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="15%"><strong>Possui?</strong></td>
		</thead>
		<?php
			$sql_COOP_CARACT_MOTOR = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_APOIO_EMBARC_MOTOR.DESCRICAO AS FISH_CPCMTR_TIPO_DESC, TAB_APOIO_BOOLEANO_CPCMTR_PROPRIO.DESCRICAO AS FISH_CPCMTR_PROPRIO_DESC, TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_POTENCIA, TAB_APOIO_ESTADOCONSERV.DESCRICAO AS FISH_CPCMTR_CONSERV_DESC FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_COOP_CARACTERIZACAO ON TAB_FISH_COOP_CARACTERIZACAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_FISH_COOCAR_MOTORES ON TAB_FISH_COOCAR_MOTORES.FISH_COOCAR_ID = TAB_FISH_COOP_CARACTERIZACAO.FISH_COOCAR_ID LEFT OUTER JOIN TAB_APOIO_EMBARC_MOTOR ON TAB_APOIO_EMBARC_MOTOR.ID = TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_TIPO LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_CPCMTR_PROPRIO ON TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_PROPRIO = TAB_APOIO_BOOLEANO_CPCMTR_PROPRIO.ID LEFT OUTER JOIN TAB_APOIO_ESTADOCONSERV ON TAB_APOIO_ESTADOCONSERV.ID = TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_CONSERV WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia' ORDER BY FISH_CPCMTR_TIPO_DESC ASC, FISH_CPCMTR_PROPRIO_DESC DESC, TAB_FISH_COOCAR_MOTORES.FISH_CPCMTR_POTENCIA DESC, FISH_CPCMTR_CONSERV_DESC ASC;", $db) or die( mysql_error());
			$cor = "#D8D8D8";
			while ($vetor_COOP_CARACT_MOTOR = mysql_fetch_array($sql_COOP_CARACT_MOTOR)) {
				if (strcasecmp($cor, "#FFFFFF") == 0){
					$cor = "#D8D8D8";
				} else {
					$cor = "#FFFFFF";
				}
		?>
		<tr align="center" bgcolor="<?php echo $cor; ?>">
			<td width="15"><?php echo $vetor_COOP_CARACT_MOTOR['FISH_CPCMTR_TIPO_DESC']; ?></td><td width="1%">&nbsp;</td>
			<td width="15%"><?php echo $vetor_COOP_CARACT_MOTOR['FISH_CPCMTR_PROPRIO_DESC']; ?></td><td width="1%">&nbsp;</td>
			<td width="15%">&nbsp;</td>
			<td width="1%">&nbsp;</td>
			<td width="15%"><?php echo number_format($vetor_COOP_CARACT_MOTOR['FISH_CPCMTR_POTENCIA'],2,',','.'); ?></td><td width="1%">&nbsp;</td>
			<td width="15%"><?php echo $vetor_COOP_CARACT_MOTOR['FISH_CPCMTR_CONSERV_DESC']; ?></td><td width="1%">&nbsp;</td>
			<td width="15%" align="center">[___]</td>
		</tr>
		<?php } ?>
	</table><hr>
	<hr class="quebrapagina">
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td style="width: 50%; text-align: left;"><img src="imgs/Logo NE.png" width="175px"></td>
				<td style="width: 50%; text-align: right;"><img src="imgs/Logo Equilibrio.jpg" width="175px"></td>
			</tr>
		</tbody>
	</table>
	<p><strong>BLOCO 04 –</strong><strong> Origem do trabalho fora da pesca</strong></p>
	<table width="100%">
		<thead>
			<td width="30%"><strong>Componente</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="30%"><strong>Tipo da Atividade</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="20%"><strong>Renda Mensal (R$)</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="10%"><strong>Possui?</strong></td>
		</thead>
		<?php
			$sql_COOP_OUTRASRENDAS = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME AS FISH_COOREN_COMPONENTE_DESC, TAB_APOIO_OCUPACAO.DESCRICAO AS FISH_COOREN_OCUPACAO_DESC, TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_RENDA FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_COOP_ENTREVISTA ON TAB_FISH_COOP_ENTREVISTA.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_FISH_COOP_OUTRASRENDAS ON TAB_FISH_COOP_OUTRASRENDAS.FISH_COOP_ID = TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ID LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_COMPONENTE = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ID LEFT OUTER JOIN TAB_APOIO_OCUPACAO ON TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_OCUPACAO = TAB_APOIO_OCUPACAO.ID WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia' AND TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_ID IS NOT NULL ORDER BY TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST ASC, FISH_COOREN_COMPONENTE_DESC ASC, FISH_COOREN_OCUPACAO_DESC ASC, TAB_FISH_COOP_OUTRASRENDAS.FISH_COOREN_RENDA DESC;", $db) or die( mysql_error());
			$cor = "#D8D8D8";
			while ($vetor_COOP_OUTRASRENDAS = mysql_fetch_array($sql_COOP_OUTRASRENDAS)) {
				if (strcasecmp($cor, "#FFFFFF") == 0){
					$cor = "#D8D8D8";
				} else {
					$cor = "#FFFFFF";
				}
		?>
		<tr bgcolor="<?php echo $cor; ?>">
			<td width="30%"><?php echo $vetor_COOP_OUTRASRENDAS['FISH_COOREN_COMPONENTE_DESC']; ?></td>
			<td width="2%">&nbsp;</td>
			<td width="30%"><?php echo $vetor_COOP_OUTRASRENDAS['FISH_COOREN_OCUPACAO_DESC']; ?></td>
			<td width="2%">&nbsp;</td>
			<td width="20%"><?php echo 'R$ '.number_format($vetor_COOP_OUTRASRENDAS['FISH_COOREN_RENDA'],2,',','.'); ?></td>
			<td width="2%">&nbsp;</td>
			<td width="10%" align="center">[___]</td>
		</tr>
		<?php } ?>
	</table><br>
	<table border="1" bordercolor="#000000" width="100%">
		<tbody>
			<tr>
				<td colspan="2" width="79%">
					<strong>Além da pesca alguém da família tem outra atividade remunerada?</strong>
				</td>
				<td width="20%" align="center">
					Sim [__]     Não [__]
				</td>
			</tr>
			<tr>
				<td width="42%">
					<strong>Componente</strong>
				</td>
				<td width="36%">
					<strong>Tipo da Atividade</strong>
				</td>
				<td width="20%">
					<strong>Renda Mensal (R$)</strong>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
		</tbody>
	</table>
	<p><strong>EXEMPLOS: Empreitas, diárias (serviços gerais), piloto, comerciante, costureira, manicure, etc.</strong></p>
	
	<p><strong>BLOCO 05 – </strong><strong>Dinheiro recebido do governo</strong></p>
	<table width="100%">
		<thead>
			<td width="30%"><strong>Componente</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="30%"><strong>Tipo do Benefício</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="20%"><strong>Renda Mensal (R$)</strong></td>
			<td width="1%">&nbsp;</td>
			<td width="10%"><strong>Possui?</strong></td>
		</thead>
		<?php
			$sql_COOP_BENEFICIOS = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME AS FISH_COOBEN_COMPONENTE_DESC, TAB_APOIO_BENEFSOCIAIS.DESCRICAO AS FISH_COOBEN_BENEFICIO_DESC, TAB_FISH_COOP_BENEFICIOS.FISH_COOBEN_RENDA FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_COOP_ENTREVISTA ON TAB_FISH_COOP_ENTREVISTA.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_FISH_COOP_BENEFICIOS ON TAB_FISH_COOP_BENEFICIOS.FISH_COOP_ID = TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ID LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_COOP_BENEFICIOS.FISH_COOBEN_COMPONENTE = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ID LEFT OUTER JOIN TAB_APOIO_BENEFSOCIAIS ON TAB_FISH_COOP_BENEFICIOS.FISH_COOBEN_BENEFICIO = TAB_APOIO_BENEFSOCIAIS.ID WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia' AND TAB_FISH_COOP_BENEFICIOS.FISH_COOBEN_ID IS NOT NULL ORDER BY TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST ASC, FISH_COOBEN_COMPONENTE_DESC ASC, FISH_COOBEN_BENEFICIO_DESC ASC, TAB_FISH_COOP_BENEFICIOS.FISH_COOBEN_RENDA ASC;", $db) or die( mysql_error());
			$cor = "#D8D8D8";
			while ($vetor_COOP_BENEFICIOS = mysql_fetch_array($sql_COOP_BENEFICIOS)) {
				if (strcasecmp($cor, "#FFFFFF") == 0){
					$cor = "#D8D8D8";
				} else {
					$cor = "#FFFFFF";
				}
		?>
		<tr bgcolor="<?php echo $cor; ?>">
			<td width="30%"><?php echo $vetor_COOP_BENEFICIOS['FISH_COOBEN_COMPONENTE_DESC']; ?></td>
			<td width="1%">&nbsp;</td>
			<td width="30%"><?php echo $vetor_COOP_BENEFICIOS['FISH_COOBEN_BENEFICIO_DESC']; ?></td>
			<td width="1%">&nbsp;</td>
			<td width="20%"><?php echo 'R$'.number_format($vetor_COOP_BENEFICIOS['FISH_COOBEN_RENDA'],2,',','.'); ?></td>
			<td width="1%">&nbsp;</td>
			<td width="10%" align="center">[___]</td>
		</tr>
		<?php } ?>
	</table><br>
	<table border="1" bordercolor="#000000" bordercolor="#000000">
		<tbody>
			<tr>
				<td colspan="2" width="79%">
					<strong>Existem pessoas da família que recebem algum tipo de benefício social ou aposentadoria?</strong>
				</td>
				<td width="20%" align="center">
					Sim [__]     2) Não [__]
				</td>
			</tr>
			<tr>
				<td width="42%">
					<strong>Componente</strong>
				</td>
				<td width="36%">
					<strong>Tipo de Benefício</strong>
				</td>
				<td width="20%">
					<strong>Renda Mensal (R$)</strong>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
			<tr>
				<td width="42%">
					<p><strong> </strong></p>
				</td>
				<td width="36%">
					<p><strong> </strong></p>
				</td>
				<td width="20%">
					<p><strong> </strong></p>
				</td>
			</tr>
		</tbody>
	</table>
	<p><strong>EXEMPLOS: Bolsa família, aposentadoria por invalidez, aposentadoria por tempo de serviço, auxílio doença, qulaquer tipo de pensão.</strong></p>
    <hr class="quebrapagina">
	<table style="width: 100%;">
		<tbody>
			<tr>
				<td style="width: 50%; text-align: left;"><img src="imgs/Logo NE.png" width="175px"></td>
				<td style="width: 50%; text-align: right;"><img src="imgs/Logo Equilibrio.jpg" width="175px"></td>
			</tr>
		</tbody>
	</table>
	<p><strong>BLOCO 06 – PROJETO PRODUTIVO DESEJADO</strong></p>
	<p><strong>1. FINALIDADE E LOCAL DO PROJETO A SER FINANCIADO POR MEIO DA COOPPBM</strong></p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p><strong>Projetos Citados Espontâneamente</strong></p>
	<ul>
	<?php
		$sql_PROJETOS_EXP = mysql_query("SELECT TAB_APOIO_CONTRIBUICOESCOOP.DESCRICAO FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_FISH_COOPINT_PROJETO ON TAB_FISH_COOPINT_PROJETO.FISH_FCOMP_ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ID LEFT OUTER JOIN TAB_APOIO_CONTRIBUICOESCOOP ON TAB_APOIO_CONTRIBUICOESCOOP.ID = TAB_FISH_COOPINT_PROJETO.FISH_FIPROJ_PROJETO WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia' ORDER BY TAB_FISH_COOPINT_PROJETO.FISH_FIPROJ_ORDEM ASC, TAB_APOIO_CONTRIBUICOESCOOP.DESCRICAO ASC;", $db) or die( mysql_error());
		while ($vetor_PROJETOS_EXP = mysql_fetch_array($sql_PROJETOS_EXP)) {
	?>
		<li><?php echo $vetor_PROJETOS_EXP['DESCRICAO']; ?></li>
	<?php } ?></ul><br>
	<p><strong>2. JUSTIFICATIVA APRESENTADA PELO PROPONENTE PARA A IMPLANTAÇÃO DO PROJETO</strong></p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
	<p>____________________________________________________________________________________________________________</p>
</body>
</html>
<?php
}
}
?>