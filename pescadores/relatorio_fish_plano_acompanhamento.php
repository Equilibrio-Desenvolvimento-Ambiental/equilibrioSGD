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
			$sql = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_PERFILENT.FISH_PERFIL_QUEST, TAB_FISH_PERFILENT.FISH_PERFIL_PESQUISADOR, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_APELIDO, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_APELIDO, TAB_APOIO_BOOLEANO_ENDURB.DESCRICAO AS FISH_FAM_ENDURB, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_LOGR, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_COMPL, TAB_APOIO_BAIRROS.DESCRICAO AS FISH_FAM_ENDURB_LOCAL, TAB_APOIO_MUNICIPIOS_URB.DESCRICAO AS FISH_FAM_ENDURB_MUNIC, TAB_APOIO_BOOLEANO_ENDRUR.DESCRICAO AS FISH_FAM_ENDRUR, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOGR, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_COMPL, TAB_APOIO_LOCALIDADES.DESCRICAO AS FISH_FAM_ENDRUR_LOCAL, TAB_APOIO_MUNICIPIOS_RUR.DESCRICAO AS FISH_FAM_ENDRUR_MUNIC, TAB_FISH_FAMILIAS.FISH_FAM_TELEFONES, TAB_APOIO_BOOLEANO_E_BARCO.DESCRICAO AS FISH_PERFIL_E_BARCO, TAB_APOIO_BOOLEANO_E_BARCO_ENT.DESCRICAO AS FISH_PERFIL_E_BARCO_ENT, TAB_FISH_PERFILENT.FISH_PERFIL_E_BARCO_ENTDT, TAB_APOIO_BOOLEANO_E_MOTOR.DESCRICAO AS FISH_PERFIL_E_MOTOR, TAB_APOIO_BOOLEANO_E_MOTOR_ENT.DESCRICAO AS FISH_PERFIL_E_MOTOR_ENT, TAB_FISH_PERFILENT.FISH_PERFIL_E_MOTOR_ENTDT, TAB_APOIO_BOOLEANO_E_TRALHA.DESCRICAO AS FISH_PERFIL_E_TRALHA, TAB_APOIO_BOOLEANO_E_TRALHA_ENT.DESCRICAO AS FISH_PERFIL_E_TRALHA_ENT, TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA_ENTDT, TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA_DESC, TAB_APOIO_BOOLEANO_E_RANCHO.DESCRICAO AS FISH_PERFIL_E_RANCHO, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENTQT AS FISH_PERFIL_E_RANCHO_QT, TAB_APOIO_BOOLEANO_E_RANCHO01.DESCRICAO AS FISH_PERFIL_E_RANCHO_ENT01, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT01DT AS FISH_PERFIL_E_RANCHO_ENT01DT, TAB_APOIO_BOOLEANO_E_RANCHO02.DESCRICAO AS FISH_PERFIL_E_RANCHO_ENT02, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT02DT AS FISH_PERFIL_E_RANCHO_ENT02DT, TAB_APOIO_BOOLEANO_E_RANCHO03.DESCRICAO AS FISH_PERFIL_E_RANCHO_ENT03, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT03DT AS FISH_PERFIL_E_RANCHO_ENT03DT, TAB_APOIO_BOOLEANO_E_RANCHO04.DESCRICAO AS FISH_PERFIL_E_RANCHO_ENT04, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT04DT AS FISH_PERFIL_E_RANCHO_ENT04DT, TAB_FISH_PERFILENT.FISH_PERFIL_TRAN_RELATO, TAB_FISH_PERFILENT.FISH_PERFIL_TRAN_ATEND, TAB_FISH_PERFILENT.FISH_PERFIL_DTDEVOLUT AS FISH_PERFIL_DEVOLUT_DT FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ENDURB ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB = TAB_APOIO_BOOLEANO_ENDURB.ID LEFT OUTER JOIN TAB_APOIO_BAIRROS ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_BAIRRO = TAB_APOIO_BAIRROS.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_URB ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_MUNIC = TAB_APOIO_MUNICIPIOS_URB.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ENDRUR ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR = TAB_APOIO_BOOLEANO_ENDRUR.ID LEFT OUTER JOIN TAB_APOIO_LOCALIDADES ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOCAL = TAB_APOIO_LOCALIDADES.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_RUR ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_MUNIC = TAB_APOIO_MUNICIPIOS_RUR.ID LEFT OUTER JOIN TAB_FISH_PERFILENT ON TAB_FISH_PERFILENT.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_BARCO ON TAB_FISH_PERFILENT.FISH_PERFIL_E_BARCO = TAB_APOIO_BOOLEANO_E_BARCO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_BARCO_ENT ON TAB_FISH_PERFILENT.FISH_PERFIL_E_BARCO_ENT = TAB_APOIO_BOOLEANO_E_BARCO_ENT.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_MOTOR ON TAB_FISH_PERFILENT.FISH_PERFIL_E_MOTOR = TAB_APOIO_BOOLEANO_E_MOTOR.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_MOTOR_ENT ON TAB_FISH_PERFILENT.FISH_PERFIL_E_MOTOR_ENT = TAB_APOIO_BOOLEANO_E_MOTOR_ENT.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_TRALHA ON TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA = TAB_APOIO_BOOLEANO_E_TRALHA.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_TRALHA_ENT ON TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA_ENT = TAB_APOIO_BOOLEANO_E_TRALHA_ENT.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_RANCHO ON TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA = TAB_APOIO_BOOLEANO_E_RANCHO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_RANCHO01 ON TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT01 = TAB_APOIO_BOOLEANO_E_RANCHO01.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_RANCHO02 ON TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT02 = TAB_APOIO_BOOLEANO_E_RANCHO02.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_RANCHO03 ON TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT03 = TAB_APOIO_BOOLEANO_E_RANCHO03.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_RANCHO04 ON TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT04 = TAB_APOIO_BOOLEANO_E_RANCHO04.ID WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia';", $db);
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
.quebrapagina {
   page-break-before: always;
   page-break-inside: avoid;
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
            <tr><td align="center"><strong><p>PLANO DE ASSISTÊNCIA TÉCNICA AOS PESCADORES</p></strong></td></tr>
            <tr><td align="center"><strong><p>FORMULÁRIO: PLANO DE ACOMPANHAMENTO DOS BENEFICIÁRIOS</p></strong></td></tr>
	    </tbody>	
    </table><br/>
    <table>
   	    <tr><td><strong>Local:</strong> ______________________________________________ <strong>Data:</strong> ____/____/____ <strong>Técnico:</strong> ______________________________________</td></tr>
    </table><br/>
    <center><h3>DADOS DO PESCADOR</h3></center>
   	<table>
    <tr>
    	<td width="25%"><strong>Beneficiários:</strong></td>
        <td width="75%"><?php echo $vetor['FISH_FAM_CHEFE_NOME'].' ('.$vetor['FISH_FAM_CHEFE_APELIDO'].')'; ?></td>
    </tr>
    <tr>
    	<td width="25%">&nbsp;</td>
        <td width="75%"><?php echo $vetor['FISH_FAM_CONJ_NOME'].' ('.$vetor['FISH_FAM_CONJ_APELIDO'].')'; ?></td>
    </tr>
    <?php if(strcasecmp($vetor['FISH_FAM_ENDURB'], 'SIM')==0){ ?>
    <tr>
    	<td width="25%"><strong>Endereço Urbano:</strong></td>
        <td width="75%"><?php echo $vetor['FISH_FAM_ENDURB_LOGR'].' - '.$vetor['FISH_FAM_ENDURB_LOCAL'].' - '.$vetor['FISH_FAM_ENDURB_MUNIC'].' ('.$vetor['FISH_FAM_ENDURB_COMPL'].')'; ?></td>
    </tr>
	<?php } ?>
    <?php if(strcasecmp($vetor['FISH_FAM_ENDRUR'], 'SIM')==0){ ?>
    <tr>
    	<td width="25%"><strong>Endereço Rural:</strong></td>
        <td width="75%"><?php echo $vetor['FISH_FAM_ENDRUR_LOGR'].' - '.$vetor['FISH_FAM_ENDRUR_LOCAL'].' - '.$vetor['FISH_FAM_ENDRUR_MUNIC'].' ('.$vetor['FISH_FAM_ENDRUR_COMPL'].')'; ?></td>
    </tr>
	<?php } ?>
    <tr>
    	<td width="25%"><strong>Telefones:</strong></td>
        <td width="75%"><?php echo $vetor['FISH_FAM_TELEFONES']; ?></td>
    </tr>
    <tr><td width="25%">&nbsp;</td><td width="75%">&nbsp;</td></tr>
    <tr>
    	<td width="25%"><strong>Endereço da visita (Se outro):</strong></td>
        <td width="75%">___________________________________________________________________________________</td>
    </tr>
    <tr>
    	<td width="25%">&nbsp;</td>
        <td width="75%">___________________________________________________________________________________</td>
    </tr>
    </table><br/>
    <center><h3>ENCAMINHAMENTOS</h3></center>
	<table>
    <?php if(strcasecmp($vetor['FISH_PERFIL_E_BARCO'], 'SIM')==0){ ?>
		<tr>
	    	<td width="25%"><strong>Embarcação: </strong><?php echo $vetor['FISH_PERFIL_E_BARCO']; ?></td>
	    	<td width="25%"><strong>Entregue: </strong><?php echo $vetor['FISH_PERFIL_E_BARCO_ENT']; ?></td>
	    	<td width="25%"><strong>Data: </strong>
				<?php if(!empty($vetor['FISH_PERFIL_E_BARCO_ENTDT'])) { echo date('d/m/Y', strtotime($vetor['FISH_PERFIL_E_BARCO_ENTDT'])); } ?>	    	
	    	</td>
	    	<td width="25%">&nbsp;</td>
		</tr>
   		<tr><td	colspan="4"><strong>Condições: </strong>__________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="4">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="4">&nbsp;</td></tr>
    <?php }; ?>
    <?php if(strcasecmp($vetor['FISH_PERFIL_E_MOTOR'], 'SIM')==0){ ?>
		<tr>
	    	<td width="25%"><strong>Motor: </strong><?php echo $vetor['FISH_PERFIL_E_MOTOR']; ?></td>
	    	<td width="25%"><strong>Entregue: </strong><?php echo $vetor['FISH_PERFIL_E_MOTOR_ENT']; ?></td>
	    	<td width="25%"><strong>Data: </strong>
				<?php if(!empty($vetor['FISH_PERFIL_E_MOTOR_ENTDT'])) { echo date('d/m/Y', strtotime($vetor['FISH_PERFIL_E_MOTOR_ENTDT'])); } ?>	    	
	    	</td>
	    	<td width="25%">&nbsp;</td>
		</tr>
   		<tr><td	colspan="4"><strong>Condições: </strong>__________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="4">______________________________________________________________________________________________________________________</td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
    <?php }; ?>
    <?php if(strcasecmp($vetor['FISH_PERFIL_E_TRALHA'], 'SIM')==0){ ?>
		<tr>
	    	<td width="25%"><strong>Tralha: </strong><?php echo $vetor['FISH_PERFIL_E_TRALHA']; ?></td>
	    	<td width="25%"><strong>Entregue: </strong><?php echo $vetor['FISH_PERFIL_E_TRALHA_ENT']; ?></td>
	    	<td width="25%"><strong>Data: </strong>
				<?php if(!empty($vetor['FISH_PERFIL_E_TRALHA_ENTDT'])) { echo date('d/m/Y', strtotime($vetor['FISH_PERFIL_E_TRALHA_ENTDT'])); } ?>	    	
	    	</td>
	    	<td width="25%">&nbsp;</td>
		</tr>
		<tr>
	    	<td width="25%"><strong>Relação de material:</strong></td>
	    	<td colspan="3"><?php echo $vetor['FISH_PERFIL_E_TRALHA_DESC']; ?></td>
		</tr>
   		<tr><td	colspan="4"><strong>Condições: </strong>__________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="4">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="4">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="4">______________________________________________________________________________________________________________________</td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
    <?php }; ?>
    <?php if(strcasecmp($vetor['FISH_PERFIL_E_RANCHO'], 'SIM')==0){ ?>
		<tr>
	    	<td width="25%"><strong>Rancho: </strong><?php echo $vetor['FISH_PERFIL_E_RANCHO']; ?></td>
	    	<td width="25%"><strong>Entregues: </strong><?php echo $vetor['FISH_PERFIL_E_RANCHO_QT']; ?></td>
	    	<td width="25%">&nbsp;</td><td width="25%">&nbsp;</td>
		</tr>
		<tr>
	    	<td width="25%"><strong>1ª Entrega: </strong>
	    		<?php if(!empty($vetor['FISH_PERFIL_E_RANCHO_ENT01DT'])) { echo date('d/m/Y', strtotime($vetor['FISH_PERFIL_E_RANCHO_ENT01DT'])); } ?>
			</td>
	    	<td width="25%"><strong>2ª Entrega: </strong>
	    		<?php if(!empty($vetor['FISH_PERFIL_E_RANCHO_ENT02DT'])) { echo date('d/m/Y', strtotime($vetor['FISH_PERFIL_E_RANCHO_ENT02DT'])); } ?>
			</td>
	    	<td width="25%"><strong>3ª Entrega: </strong>
	    		<?php if(!empty($vetor['FISH_PERFIL_E_RANCHO_ENT03DT'])) { echo date('d/m/Y', strtotime($vetor['FISH_PERFIL_E_RANCHO_ENT03DT'])); } ?>
			</td>
	    	<td width="25%"><strong>4ª Entrega: </strong>
	    		<?php if(!empty($vetor['FISH_PERFIL_E_RANCHO_ENT04DT'])) { echo date('d/m/Y', strtotime($vetor['FISH_PERFIL_E_RANCHO_ENT04DT'])); } ?>
			</td>
		</tr>
    <?php }; ?>
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr><td colspan="4"><strong>Situação relatada na entrevista:</strong></td></tr>
    <tr><td colspan="4"><p><?php echo $vetor['FISH_PERFIL_TRAN_RELATO']; ?></p></td></tr>
    <tr><td colspan="4"><strong>Plano de Atendimento:</strong></td></tr>
    <tr><td colspan="4"><p><?php echo $vetor['FISH_PERFIL_TRAN_ATEND']; ?></p></td></tr>
	</table>

    <hr class="quebrapagina">

    <center><h3>ROTEIRO DE PERGUNTAS PARA O ACOMPANHAMENTO</h3></center>
  	<table>   
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>01 - Está realizando as atividades de pesca (quantas vezes na semana, local, volume pescado)? Se não, porque?</strong></td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>02 - Como é comercializado o pescado?</strong></td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>03 - Está satisfeito com o equipamento recebido? Ajudou a melhorar a atividade?</strong></td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>04 - Houveram alterações quanto ao custo, tempo e segurança durante a pesca (principalmente caso tenha recebido embarcação ou motor)?</strong></td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>05 - Houve alguma alteração no tipo e quantidade do pescado?</strong></td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>06 - Houve alteração na renda ou fonte de renda da família? Isso teve algum reflexo nas condições de vida? Quais?</strong></td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>07 - Preencheu as fichas de acompanhamento da pesca? Se não, porque (descrever os dados da ficha de acompanhamento da pesca no bloco)?</strong></td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>08 - É associado ou pretende se associar a cooperativa de pesca?</strong></td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>09 - Houveram mudanças na composição familiar?</strong></td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>10 - Está satisfeito com o atendimento recebido?</strong></td></tr>
    	<tr><td colspan="2">______________________________________________________________________________________________________________________</td></tr>
   		<tr><td colspan="2">&nbsp;</td></tr>
    	<tr><td colspan="2"><strong>11 - Encaminhamentos para a próxima visita, percepção técnica e observações (no bloco).</strong></td></tr>
    </table><br/>
    <table>
    <tr><td colspan="2"><strong>Assinaturas:</strong></td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td width="50%">_________________________________________________________</td><td width="50%">_________________________________________________________</td></tr>
    <tr><td><strong>R.G./C.P.F.:</strong></td><td><strong>R.G./C.P.F.:</strong></td></tr>
    </table><br/>
</body>
</html>
<?php
}
}
?>