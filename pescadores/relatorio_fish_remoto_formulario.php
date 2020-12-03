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
			$sql_FORMULARIO = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_NOME, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_APELIDO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_POSSUI, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_ORGAO, TAB_APOIO_UF.SIGLA AS FISH_FCOMP_RG_UF_DESC, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_CPF_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_NUMERO, TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RGP_DTREGISTRO, TAB_APOIO_PARENTESCO.DESCRICAO AS FISH_FCOMP_PARENTESCO_DESC, TAB_FISH_FAMILIAS.FISH_FAM_TELEFONES, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_LOGR, TAB_APOIO_BAIRROS.DESCRICAO AS FISH_FAM_ENDURB_LOCAL_DESC, TAB_APOIO_MUNICIPIOS_URBANO.DESCRICAO AS FISH_FAM_ENDURB_MUNIC_DESC, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_COMPL, TAB_APOIO_USOIMOVEL_URBANO.DESCRICAO AS FISH_FAM_ENDURB_USO_DESC, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOGR, TAB_APOIO_LOCALIDADES.DESCRICAO AS FISH_FAM_ENDRUR_LOCAL_DESC, TAB_APOIO_MUNICIPIOS_RURAL.DESCRICAO AS FISH_FAM_ENDRUR_MUNIC_DESC, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_COMPL, TAB_APOIO_USOIMOVEL_RURAL.DESCRICAO AS FISH_FAM_ENDRUR_USO_DESC, TAB_APOIO_BOOLEANO.DESCRICAO AS FISH_FAM_STT_PORT_DESC FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_PARENTESCO ON TAB_APOIO_PARENTESCO.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_PARENTESCO LEFT OUTER JOIN TAB_APOIO_BAIRROS ON TAB_APOIO_BAIRROS.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_BAIRRO LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_URBANO ON TAB_APOIO_MUNICIPIOS_URBANO.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_MUNIC LEFT OUTER JOIN TAB_APOIO_USOIMOVEL AS TAB_APOIO_USOIMOVEL_URBANO ON TAB_APOIO_USOIMOVEL_URBANO.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_USO LEFT OUTER JOIN TAB_APOIO_LOCALIDADES ON TAB_APOIO_LOCALIDADES.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOCAL LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_RURAL ON TAB_APOIO_MUNICIPIOS_RURAL.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_MUNIC LEFT OUTER JOIN TAB_APOIO_USOIMOVEL AS TAB_APOIO_USOIMOVEL_RURAL ON TAB_APOIO_USOIMOVEL_RURAL.ID = TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_USO LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_UF.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_RG_UF LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_APOIO_BOOLEANO.ID = TAB_FISH_FAMILIAS.FISH_FAM_STT_PORT WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia' AND TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_PARENTESCO = 1;", $db) or die(mysql_error());
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
				<td style="width: 30%; text-align: left;"><img src="imgs/Logo NE.png" width="200px"></td>
				<td style="width: 30%; text-align: left;"><h4 style="text-align: center;">PROJETO ATES PARA PESCADORES</h4></td>
				<td style="width: 30%; text-align: right;"><img src="imgs/Logo Equilibrio.jpg" width="200px"></td>
			</tr>
		</tbody>
	</table>
	<h4 style="text-align: center;">ATENDIMENTO REMOTO 2º SEMESTRE DE 2020</h4><br>
	<p>Consiste em uma ‘conversa’ com o pescador para retomada do contato, suspenso em respeito à pandemia. Serão anotadas, além da percepção do técnico, as informações inseridas nesse formulário, possíveis de serem obtidas durante o contato realizado.</p>
	<p>Técnico: _______________________________________________________</p>
	
	<table>
		<tbody>
			<tr style="text-align: center;">
				<td width="33%"><strong>1&ordf; Tentativa de contato</strong></td>
				<td width="33%"><strong>2&ordf; Tentativa de contato</strong></td>
				<td width="33%"><strong>3&ordf; Tentativa de contato</strong></td>
			</tr>
		<tr style="text-align: center;">
			<td width="33%">
				<p><strong>Data da entrevista:</strong></p>
				<p><strong>____/___/_____</strong></p>
				<p><strong>Hor&aacute;rio: ___:___</strong></p>
			</td>
			<td width="33%">
				<p><strong>Data da entrevista:</strong></p>
				<p><strong>____/___/_____</strong></p>
				<p><strong>Hor&aacute;rio: ___:___</strong></p>
			</td>
			<td width="33%">
				<p><strong>Data da entrevista:</strong></p>
				<p><strong>____/___/_____</strong></p>
				<p><strong>Hor&aacute;rio: ___:___</strong></p>
			</td>
		</tr>
		</tbody>
	</table>
	<p>[<em>As tentativas de contato devem ser realizadas em dias diferentes da semana e, tamb&eacute;m, em &nbsp;per&iacute;odos diferentes do dia].</em></p>

	<?php
		$sql_PTF = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_PERFILENT.FISH_PERFIL_ID, TAB_APOIO_BOOLEANO_BARCO.DESCRICAO AS FISH_PERFIL_E_BARCO_DESC, TAB_APOIO_BOOLEANO_BARCO_ENT.DESCRICAO AS FISH_PERFIL_E_BARCO_ENT_DESC, TAB_FISH_PERFILENT.FISH_PERFIL_E_BARCO_ENTDT, TAB_APOIO_BOOLEANO_MOTOR.DESCRICAO AS FISH_PERFIL_E_MOTOR_DESC, TAB_APOIO_BOOLEANO_MOTOR_ENT.DESCRICAO AS FISH_PERFIL_E_MOTOR_ENT_DESC, TAB_FISH_PERFILENT.FISH_PERFIL_E_MOTOR_ENTDT, TAB_APOIO_BOOLEANO_TRALHA.DESCRICAO AS FISH_PERFIL_E_TRALHA_DESC, TAB_APOIO_BOOLEANO_TRALHA_ENT.DESCRICAO AS FISH_PERFIL_E_TRALHA_ENT_DESC, TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA_ENTDT, TAB_APOIO_BOOLEANO_RANCHO.DESCRICAO AS FISH_PERFIL_E_RANCHO_DESC, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENTQT, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT01DT, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT02DT, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT03DT, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT04DT, TAB_FISH_PERFILENT.FISH_PERFIL_TRAN_RESUMO FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_PERFILENT ON TAB_FISH_PERFILENT.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_BARCO ON TAB_APOIO_BOOLEANO_BARCO.ID = TAB_FISH_PERFILENT.FISH_PERFIL_E_BARCO LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_BARCO_ENT ON TAB_APOIO_BOOLEANO_BARCO_ENT.ID = TAB_FISH_PERFILENT.FISH_PERFIL_E_BARCO_ENT LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_MOTOR ON TAB_APOIO_BOOLEANO_MOTOR.ID = TAB_FISH_PERFILENT.FISH_PERFIL_E_MOTOR LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_MOTOR_ENT ON TAB_APOIO_BOOLEANO_MOTOR_ENT.ID = TAB_FISH_PERFILENT.FISH_PERFIL_E_MOTOR_ENT LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_TRALHA ON TAB_APOIO_BOOLEANO_TRALHA.ID = TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_TRALHA_ENT ON TAB_APOIO_BOOLEANO_TRALHA_ENT.ID = TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA_ENT LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_RANCHO ON TAB_APOIO_BOOLEANO_RANCHO.ID = TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia' AND TAB_FISH_PERFILENT.FISH_PERFIL_VISITA = 1 AND TAB_FISH_PERFILENT.FISH_PERFIL_APLIC = 1;", $db) or die( mysql_error());
		$vetor_PTF = mysql_fetch_array($sql_PTF);

		$sql_COOPPBM = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_FAMILIAS_COMPOSICAO ON TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_APOIO_BOOLEANO.ID = TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ATES_FICHAPROPOSTA WHERE TAB_FISH_FAMILIAS_COMPOSICAO.FISH_FCOMP_ATES_FICHAPROPOSTA = 1 AND TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia';", $db) or die( mysql_error());
		$vetor_COOPPBM = mysql_fetch_array($sql_COOPPBM);

		$sql_QUEST = mysql_query("SELECT TAB_FISH_COOP_ENTREVISTA.FISH_COOP_ID, TAB_FISH_COOP_ENTREVISTA.FISH_FAM_ID, TAB_FISH_COOP_ENTREVISTA.FISH_COOP_QUEST FROM TAB_FISH_COOP_ENTREVISTA WHERE TAB_FISH_COOP_ENTREVISTA.FISH_FAM_ID = '$id_familia';", $db) or die( mysql_error());
		$vetor_QUEST = mysql_fetch_array($sql_QUEST);
	?>
	<p><strong>1 - Resumo do hist&oacute;rico do PESCADOR </strong>[<em>entregar preenchido e fazer as corre&ccedil;&otilde;es no contato</em>]</p>

	<table style="width: 100%;">
		<tbody>
			<?php
				if(!empty($vetor_PTF['FISH_PERFIL_ID'])){
			?>
				<tr>
					<td style="width: 30%;" rowspan="6">
						<strong>Plano Familiar de Transi&ccedil;&atilde;o</strong>
					</td>
					<td style="width: 70%;">
						<p>Benefici&aacute;rio:&nbsp;<strong>SIM</strong></p>
					</td>
				</tr>
				<tr>
					<td style="width: 70%;">
						Encaminhamento&nbsp;<strong>Embarca&ccedil;&atilde;o: <?php echo $vetor_PTF['FISH_PERFIL_E_BARCO_DESC']; ?>.&nbsp;</strong>Entregue: <?php echo $vetor_PTF['FISH_PERFIL_E_BARCO_ENT_DESC']; ?>. Em <?php if(!empty($vetor_PTF['FISH_PERFIL_E_BARCO_ENTDT'])) { echo date('d/m/Y', strtotime($vetor_PTF['FISH_PERFIL_E_BARCO_ENTDT'])); } else { echo '___/___/_____';} ?>
					</td>
				</tr>
				<tr>
					<td style="width: 70%;">
						Encaminhamento&nbsp;<strong>Motor: <?php echo $vetor_PTF['FISH_PERFIL_E_MOTOR_DESC']; ?>.&nbsp;</strong>Entregue: <?php echo $vetor_PTF['FISH_PERFIL_E_MOTOR_ENT_DESC']; ?>. Em <?php if(!empty($vetor_PTF['FISH_PERFIL_E_MOTOR_ENTDT'])) { echo date('d/m/Y', strtotime($vetor_PTF['FISH_PERFIL_E_MOTOR_ENTDT'])); } else { echo '___/___/_____';} ?>
					</td>
				</tr>
				<tr>
					<td style="width: 70%;">
						Encaminhamento&nbsp;<strong>Tralha: <?php echo $vetor_PTF['FISH_PERFIL_E_TRALHA_DESC']; ?>.&nbsp;</strong>Entregue: <?php echo $vetor_PTF['FISH_PERFIL_E_TRALHA_ENT_DESC']; ?>. Em <?php if(!empty($vetor_PTF['FISH_PERFIL_E_TRALHA_ENTDT'])) { echo date('d/m/Y', strtotime($vetor_PTF['FISH_PERFIL_E_TRALHA_ENTDT'])); } else { echo '___/___/_____';} ?>
					</td>
				</tr>
				<tr>
					<td style="width: 70%;">
						Encaminhamento&nbsp;<strong>Rancho: <?php echo $vetor_PTF['FISH_PERFIL_E_RANCHO_DESC']; ?>.&nbsp;</strong>Quantidade entregue: <?php echo $vetor_PTF['FISH_PERFIL_E_CESTA_ENTQT']; ?>.<br>
						1&ordf;:&nbsp;<?php if(!empty($vetor_PTF['FISH_PERFIL_E_CESTA_ENT01DT'])) { echo date('d/m/Y', strtotime($vetor_PTF['FISH_PERFIL_E_CESTA_ENT01DT'])); } else { echo '___/___/_____';} ?>. 2&ordf;:&nbsp;<?php if(!empty($vetor_PTF['FISH_PERFIL_E_CESTA_ENT02DT'])) { echo date('d/m/Y', strtotime($vetor_PTF['FISH_PERFIL_E_CESTA_ENT02DT'])); } else { echo '___/___/_____';} ?>. 3&ordf;:&nbsp;<?php if(!empty($vetor_PTF['FISH_PERFIL_E_CESTA_ENT03DT'])) { echo date('d/m/Y', strtotime($vetor_PTF['FISH_PERFIL_E_CESTA_ENT03DT'])); } else { echo '___/___/_____';} ?>. 4&ordf;:&nbsp;<?php if(!empty($vetor_PTF['FISH_PERFIL_E_CESTA_ENT04DT'])) { echo date('d/m/Y', strtotime($vetor_PTF['FISH_PERFIL_E_CESTA_ENT04DT'])); } else { echo '___/___/_____';} ?>.
					</td>
				</tr>
				<tr>
					<td style="width: 70%;">
						<p>Resumo &ndash; <?php echo $vetor_PTF['FISH_PERFIL_TRAN_RESUMO']; ?></p>
					</td>
				</tr>
			<?php
				} else {
			?>
				<tr>
					<td style="width: 30%;">
						<strong>Plano Familiar de Transi&ccedil;&atilde;o</strong>
					</td>
					<td style="width: 70%;">
						<p>Benefici&aacute;rio:&nbsp;<strong>NÃO</strong></p>
					</td>
				</tr>
			<?php
				}
			?>
			<tr>
				<td style="width: 30%;">
					<strong>Porto das Carro&ccedil;as</strong>
				</td>
				<td style="width: 70%;">
					<p>Benefici&aacute;rio: <strong><?php echo $vetor_FORMULARIO['FISH_FAM_STT_PORT_DESC']?></strong></p>
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
					<strong>COOPPBM</strong>
				</td>
				<td style="width: 70%;">
					<p>Solicitou filiação?<strong>
						<?php if(!empty($vetor_COOPPBM['FISH_FAM_ID'])){ ?>
							SIM
						<?php } else { ?>
							NÃO
						<?php } ?>
					</strong></p>
				</td>
			</tr>
			<tr>
				<td style="width: 30%;" rowspan="2">
					<strong>Tem Question&aacute;rio Preenchido?</strong>
				</td>
				<td style="width: 70%;">
					<?php if(!empty($vetor_PTF['FISH_PERFIL_ID'])){ ?>
						PFT: <strong>SIM</strong>
					<?php } else { ?>
						PFT: <strong>NÃO</strong>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td style="width: 70%;">
					<?php if(!empty($vetor_QUEST['FISH_COOP_ID'])){ ?>
						Reuniões Regionais/Cooperativa: <strong>SIM</strong>
					<?php } else { ?>
						Reuniões Regionais/Cooperativa: <strong>NÃO</strong>
					<?php } ?>
				</td>
			</tr>
		</tbody>
	</table>	<br>
	
	<strong>1. IDENTIFICAÇÃO</strong>
	<table border="1" bordercolor="#000000" width="100%">
		<tbody>
			<tr>
				<td colspan="3" width="21%">
					<p><strong> Nome do Entrevistado:</strong></p>
				</td>
				<td colspan="6" width="78%">
					<p>&nbsp;</p>
				</td>
			</tr>
			<tr>
				<td colspan="3" width="21%">
					<strong> Nome do Chefe da Família:</strong>
				</td>
				<td colspan="6" width="78%">
					<?php echo $vetor_FORMULARIO['FISH_FCOMP_NOME'].' ('.$vetor_FORMULARIO['FISH_FCOMP_APELIDO'].')'; ?>
				</td>
			</tr>
			<tr>
				<td width="8%">
					<strong> RG:</strong>
				</td>
				<td colspan="4" width="40%">
					<?php echo $vetor_FORMULARIO['FISH_FCOMP_RG_NUMERO'].' '.$vetor_FORMULARIO['FISH_FCOMP_RG_ORGAO'].'/'.$vetor_FORMULARIO['FISH_FCOMP_RG_UF_DESC']; ?>
				</td>
				<td width="6%">
					<strong> CPF:</strong>
				</td>
				<td colspan="3" width="44%">
					<?php echo $vetor_FORMULARIO['FISH_FCOMP_CPF_NUMERO']; ?>
				</td>
			</tr>
			<tr>
				<td width="8%">
					<strong> Registro de Pesca:</strong>
				</td>
				<td colspan="4" width="40%">
					<?php
						echo $vetor_FORMULARIO['FISH_FCOMP_RGP_NUMERO'].' ';
						if(!empty($vetor_FORMULARIO['FISH_FCOMP_RGP_DTREGISTRO'])) {
							echo 'registrado em '.date('d/m/Y', strtotime($vetor_FORMULARIO['FISH_FCOMP_RGP_DTREGISTRO'])); 
						}
					?>
				</td>
				<td width="6%">
					<strong> Telefones:</strong>
				</td>
				<td colspan="3" width="44%">
					<?php echo $vetor_FORMULARIO['FISH_FAM_TELEFONES']; ?>
				</td>
			</tr>
			<tr>
				<td colspan="2" rowspan="3" width="17%">
					<strong>Endereço Urbano</strong>
				</td>
				<td colspan="6" width="52%">
					<strong> Rua:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDURB_LOGR']; ?>
				</td>
				<td width="29%">
					<strong> Bairro:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDURB_LOCAL_DESC']; ?>
				</td>
			</tr>
			<tr>
				<td colspan="6" width="52%">
					<strong> Ponto de referência:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDURB_COMPL']; ?>
				</td>
				<td width="29%">
					<strong> Município:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDURB_MUNIC_DESC']; ?>
				</td>
			</tr>
			<tr>
				<td colspan="7" width="82%">
					<strong> Qual o uso principal do imóvel?</strong>  [__] Residência   [__] Produção/Comercial   [__] Lazer</br>
					Resposta Atual: <strong><?php echo $vetor_FORMULARIO['FISH_FAM_ENDURB_USO_DESC']; ?></strong>
				</td>
			</tr>
			<tr>
				<td colspan="2" rowspan="3" width="17%">
					<strong> Endereço Rural</strong>
				</td>
				<td colspan="6" width="52%">
					<strong> Estrada:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDRUR_LOGR']; ?>
				</td>
				<td width="29%">
					<strong> Setor/Região:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDRUR_LOCAL_DESC']; ?>
				</td>
			</tr>
			<tr>
				<td colspan="6" width="52%">
					<strong> Ponto de referência:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDRUR_COMPL']; ?>
				</td>
				<td width="29%">
					<strong> Município:</strong> <?php echo $vetor_FORMULARIO['FISH_FAM_ENDRUR_MUNIC_DESC']; ?>
				</td>
			</tr>
			<tr>
				<td colspan="7" width="82%">
					<strong> Qual o uso principal do imóvel?</strong>  [__] Residência   [__] Produção/Comercial   [__] Lazer</br>
					Resposta Atual: <strong><?php echo $vetor_FORMULARIO['FISH_FAM_ENDRUR_USO_DESC']; ?></strong>
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
	</table><br>

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
			<table border="1" bordercolor="#A7A1A1" width="100%">
				<tbody>
					<tr style="height: 25px;">
						<td width="12.5%">
							<strong>Nome Completo e por Extenso:</strong>
						</td>
						<td colspan="5" width="67.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_NOME'];?>
						</td>
						<td width="12.5%">
							<strong>Apelido:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_APELIDO'];?>
						</td>
					</tr>
					<tr style="height: 25px;">
						<td width="12.5%">
							<strong>G&ecirc;nero:</strong>
						</td>
						<td>
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_GENERO_DESC'];?>
						</td>
						<td width="12.5%">
							<strong>Parentesco:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_PARENTESCO_DESC'];?>
						</td>
						<td width="12.5%">
							<strong>Data de Nasc.:</strong>
						</td>
						<td width="12.5%">
							<?php if(!empty($vetor_COMPOSICAO['FISH_FCOMP_DTNASC'])) { echo date('d/m/Y', strtotime($vetor_COMPOSICAO['FISH_FCOMP_DTNASC'])); } else { echo '___/___/_____';} ?>
						</td>
						<td width="12.5%">
							<strong>Idade:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_IDADE'];?>
						</td>
					</tr>
					<tr style="height: 25px;">
						<td width="12.5%">
							<strong>Estado Civil:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_ESTADOCIVIL_DESC'];?>
						</td>
						<td width="12.5%">
							<strong>Nacionalidade:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_NACIONALIDADE_DESC'];?>
						</td>
						<td width="12.5%">
							<strong>Natulaidade:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_NATURAL_MUNIC_DESC'].'/'.$vetor_COMPOSICAO['FISH_FCOMP_NATURAL_UF_DESC'];?>
						</td>
						<td width="12.5%">
							<strong>Ocupa&ccedil;&atilde;o:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_OCUPACAO_DESC'];?>
						</td>
					</tr>
					<tr style="height: 25px;">
						<td width="12.5%">
							<strong>Sabe ler?</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_ALFAB_LER_DESC'];?>
						</td>
						<td width="12.5%">
							<strong>Sabe escrever?</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_ALFAB_ESCREVER_DESC'];?>
						</td>
						<td width="12.5%">
							<strong>Possu&iacute; CPF?</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_CPF_POSSUI_DESC'];?>
						</td>
						<td width="12.5%">
							<strong>N&uacute;mero:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_CPF_NUMERO'];?>
						</td>
					</tr>
					<tr style="height: 25px;">
						<td width="12.5%">
							<strong>Possu&iacute; RG?</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_RG_POSSUI_DESC'];?>
						</td>
						<td width="12.5%">
							<strong>N&uacute;mero:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_RG_NUMERO'];?>
						</td>
						<td width="12.5%">
							<strong>&Oacute;rg&atilde;o Expedidor:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_RG_ORGAO'].'/'.$vetor_COMPOSICAO['FISH_FCOMP_RG_POSSUI_UF'];?>
						</td>
						<td width="12.5%">
							<strong>Data de Expedi&ccedil;&atilde;o:</strong>
						</td>
						<td width="12.5%">
							<?php if(!empty($vetor_COMPOSICAO['FISH_FCOMP_RG_DTREGISTRO'])) { echo date('d/m/Y', strtotime($vetor_COMPOSICAO['FISH_FCOMP_RG_DTREGISTRO'])); } else { echo '___/___/_____';} ?>
						</td>
					</tr>
					<tr style="height: 25px;">
						<td width="12.5%">
							<strong>Possu&iacute; Reg. de Pesca:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_RGP_POSSUI_DESC'];?></td>
						<td width="12.5%">
							<strong>N&uacute;mero:</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_RGP_NUMERO'];?>
						</td>
						<td width="12.5%">
							<strong>Data de Expedi&ccedil;&atilde;o:</strong>
						</td>
						<td width="12.5%">
							<?php if(!empty($vetor_COMPOSICAO['FISH_FCOMP_RGP_DTREGISTRO'])) { echo date('d/m/Y', strtotime($vetor_COMPOSICAO['FISH_FCOMP_RGP_DTREGISTRO'])); } else { echo '___/___/_____';} ?>
						</td>
						<td width="12.5%">
							<strong>Residente?</strong>
						</td>
						<td width="12.5%">
							<?php echo $vetor_COMPOSICAO['FISH_FCOMP_RESIDENTE_DESC'];?>
						</td>
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
	
</body>
</html>
<?php
}
}
?>