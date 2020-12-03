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
			$sql = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_PERFILENT.FISH_PERFIL_QUEST, TAB_FISH_PERFILENT.FISH_PERFIL_PESQUISADOR, TAB_APOIO_BOOLEANO_STT_EMERG.DESCRICAO AS FISH_FAM_STT_EMERG, TAB_APOIO_BOOLEANO_STT_PORTO.DESCRICAO AS FISH_FAM_STT_PORTO, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_APELIDO, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_APELIDO, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_COMPL, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_COMPL,  TAB_APOIO_BOOLEANO_ENDURB.DESCRICAO AS FISH_FAM_ENDURB, TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_LOGR, TAB_APOIO_BAIRROS.DESCRICAO AS FISH_FAM_ENDURB_LOCAL, TAB_APOIO_MUNICIPIOS_URB.DESCRICAO AS FISH_FAM_ENDURB_MUNIC, TAB_APOIO_BOOLEANO_ENDRUR.DESCRICAO AS FISH_FAM_ENDRUR, TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOGR, TAB_APOIO_LOCALIDADES.DESCRICAO AS FISH_FAM_ENDRUR_LOCAL, TAB_APOIO_MUNICIPIOS_RUR.DESCRICAO AS FISH_FAM_ENDRUR_MUNIC, TAB_FISH_FAMILIAS.FISH_FAM_TELEFONES, TAB_APOIO_BOOLEANO_415421.DESCRICAO AS FISH_FAM_ATES, TAB_APOIO_BOOLEANO_E_BARCO.DESCRICAO AS FISH_PERFIL_E_BARCO, TAB_APOIO_BOOLEANO_E_BARCO_ENT.DESCRICAO AS FISH_PERFIL_E_BARCO_ENT, TAB_FISH_PERFILENT.FISH_PERFIL_E_BARCO_ENTDT, TAB_APOIO_BOOLEANO_E_MOTOR.DESCRICAO AS FISH_PERFIL_E_MOTOR, TAB_APOIO_BOOLEANO_E_MOTOR_ENT.DESCRICAO AS FISH_PERFIL_E_MOTOR_ENT, TAB_FISH_PERFILENT.FISH_PERFIL_E_MOTOR_ENTDT, TAB_APOIO_BOOLEANO_E_TRALHA.DESCRICAO AS FISH_PERFIL_E_TRALHA, TAB_APOIO_BOOLEANO_E_TRALHA_ENT.DESCRICAO AS FISH_PERFIL_E_TRALHA_ENT, TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA_DESC, TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA_ENTDT, TAB_APOIO_BOOLEANO_E_RANCHO.DESCRICAO AS FISH_PERFIL_E_RANCHO, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENTQT AS FISH_PERFIL_E_RANCHO_QT, TAB_APOIO_BOOLEANO_E_RANCHO01.DESCRICAO AS FISH_PERFIL_E_RANCHO_ENT01, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT01DT AS FISH_PERFIL_E_RANCHO_ENT01DT, TAB_APOIO_BOOLEANO_E_RANCHO02.DESCRICAO AS FISH_PERFIL_E_RANCHO_ENT02, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT02DT AS FISH_PERFIL_E_RANCHO_ENT02DT, TAB_APOIO_BOOLEANO_E_RANCHO03.DESCRICAO AS FISH_PERFIL_E_RANCHO_ENT03, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT03DT AS FISH_PERFIL_E_RANCHO_ENT03DT, TAB_APOIO_BOOLEANO_E_RANCHO04.DESCRICAO AS FISH_PERFIL_E_RANCHO_ENT04, TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT04DT AS FISH_PERFIL_E_RANCHO_ENT04DT, TAB_FISH_PERFILENT.FISH_PERFIL_TRAN_RELATO, TAB_FISH_PERFILENT.FISH_PERFIL_TRAN_ATEND, TAB_APOIO_BOOLEANO_DEVOL.DESCRICAO AS FISH_PERFIL_DEVOLUT, TAB_FISH_PERFILENT.FISH_PERFIL_DTDEVOLUT AS FISH_PERFIL_DEVOLUT_DT, TAB_APOIO_BOOLEANO_DEVOL_OK.DESCRICAO AS FISH_PERFIL_DEVOLUT_ACEITE, TAB_APOIO_BOOLEANO_ACOMP_ANTES_01.DESCRICAO AS FISH_AA_BOO_PESCAVA_DESC, TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_QT_PESCA_QTMES, TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_QT_PESCA_QTINT, TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_QT_PESCA_QTDIAS, TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_QT_PESCA_QTPESSOAS, TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_QT_PESCA_PRODTEMP, TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_QT_PESCA_PRODFTEMP, TAB_APOIO_BOOLEANO_ACOMP_ANTES_02.DESCRICAO AS FISH_AA_BOO_PESCA_VENDIA_DESC, TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_QT_PESCA_PRODVENDA, TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_QT_PESCA_PRODCOSUMO, TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_VL_PESCA_PRODMEDIA, TAB_FISH_CAMPANHAS.FISH_CAMP_DESCRICAO AS FISH_AE_CAMPANHA_DESC, TAB_APOIO_TECNICOS.DESCRICAO AS FISH_AE_TECNICO_DESC, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_DT_ENTR_ATUAL, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_DT_ENTR_ANTERIOR, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_QT_ENTR_INTERVDIAS, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_01.DESCRICAO AS FISH_AE_BOO_PESCA_REALIZOU_DESC, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_QT_PESCA_QTDEPESCARIAS, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_QT_PESCA_MEDIADIASPESCARIAS, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_QT_PESCA_TOTALDIASPESCARIAS, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_QT_PESCA_MEDIAPESSOASPESCARIA, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_02.DESCRICAO AS FISH_AE_BOO_PESCA_USOUEQUIPS, TAB_APOIO_PESCA_EQUIPNUSO.DESCRICAO AS FISH_AE_FK_PESCA_NUSOUEQUIPS_DESC, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_03.DESCRICAO AS FISH_AE_BOO_PESCA_LOCALMUDOU_DESC, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_04.DESCRICAO AS FISH_AE_BOO_PESCA_LOCALMELHOR_DESC, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_05.DESCRICAO AS FISH_AE_BOO_PESCA_RESULTMELHOR_DESC, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_06.DESCRICAO AS FISH_AE_BOO_PESCA_ESPECIESMUDOU_DESC, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_07.DESCRICAO AS FISH_AE_BOO_PESCA_CONDVIDAMELHOR_DESC, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_QT_PESCA_MEDIAKQPESCARIA, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_08.DESCRICAO AS FISH_AE_BOO_PESCA_PRODVENDIDA_DESC, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_QT_PESCA_MEDIAKQVENDIDO, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_VL_PESCA_VALORKQVENDIDO, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_QT_PESCA_MEDIAKQCONSUMO, TAB_APOIO_PESCA_MOTIVO.DESCRICAO AS FISH_AE_FK_PESCA_NENHUMAPESCARIA_DESC, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_09.DESCRICAO AS FISH_AE_BOO_PESCA_SATISFACAO_DESC, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_TXT_PESCA_SATISFACAO, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_10.DESCRICAO AS FISH_AE_BOO_ATEND_SATISFACAO_DESC, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_TXT_ATEND_SATISFACAO, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_11.DESCRICAO AS FISH_AE_BOO_COOP_FILIACAO_DESC, TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_TXT_COOP_FILIACAO, TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_12.DESCRICAO AS FISH_AE_BOO_PESCA_FICHASOK_DESC, TAB_APOIO_PESCA_FICHASNPREENC.DESCRICAO AS FISH_AE_FK_PESCA_FICHASMOTIVO_DESC, TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_ID, TAB_APOIO_BOO_ACOMP_PERCEP_VIST_MOTOR.DESCRICAO AS FISH_AP_BOO_MOTOR_DESC, TAB_APOIO_FK_ACOMP_PERCEP_NVIST_MOTOR.DESCRICAO AS FISH_AP_FK_MOTORNVIST_DESC, TAB_APOIO_BOO_ACOMP_PERCEP_CONSERV_MOTOR.DESCRICAO AS FISH_AP_BOO_MOTORCONSERV_DESC, TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_TXT_MOTORCONSERV, TAB_APOIO_FK_ACOMP_PERCEP_POSSE_MOTOR.DESCRICAO AS FISH_AP_FK_MOTORPOSSE_DESC, TAB_APOIO_BOO_ACOMP_PERCEP_VIST_EMBARC.DESCRICAO AS FISH_AP_BOO_EMBARC_DESC, TAB_APOIO_FK_ACOMP_PERCEP_NVIST_EMBARC.DESCRICAO AS FISH_AP_FK_EMBARCNVIST_DESC, TAB_APOIO_BOO_ACOMP_PERCEP_CONSERV_EMBARC.DESCRICAO AS FISH_AP_BOO_EMBARCCONSERV_DESC, TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_TXT_EMBARCCONSERV, TAB_APOIO_FK_ACOMP_PERCEP_POSSE_EMBARC.DESCRICAO AS FISH_AP_FK_EMBARCPOSSE_DESC, TAB_APOIO_BOO_ACOMP_PERCEP_VIST_TRALHA.DESCRICAO AS FISH_AP_BOO_TRALHA_DESC, TAB_APOIO_FK_ACOMP_PERCEP_NVIST_TRALHA.DESCRICAO AS FISH_AP_FK_TRALHANVIST_DESC, TAB_APOIO_BOO_ACOMP_PERCEP_CONSERV_TRALHA.DESCRICAO AS FISH_AP_BOO_TRALHACONSERV_DESC, TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_TXT_TRALHACONSERV, TAB_APOIO_FK_ACOMP_PERCEP_POSSE_TRALHA.DESCRICAO AS FISH_AP_FK_TRALHAPOSSE_DESC, TAB_APOIO_BOO_ACOMP_PERCEP_EVID_PESCA.DESCRICAO AS FISH_AP_BOO_EVIDPESCANDO_DESC, TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_TXT_EVIDPESCANDO, TAB_APOIO_BOO_ACOMP_PERCEP_EVID_VENDA.DESCRICAO AS FISH_AP_BOO_EVIDVENDA_DESC, TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_TXT_EVIDVENDA, TAB_APOIO_BOO_ACOMP_PERCEP_EVID_FALSIDADE.DESCRICAO AS FISH_AP_BOO_EVIDFALSIDADE_DESC, TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_TXT_EVIDFALSIDADE, TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_TXT_PERCEPCOES, TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_TXT_OBSERVACOES FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_STT_PORTO ON TAB_FISH_FAMILIAS.FISH_FAM_STT_PORT = TAB_APOIO_BOOLEANO_STT_PORTO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_STT_EMERG ON TAB_FISH_FAMILIAS.FISH_FAM_STT_EMER = TAB_APOIO_BOOLEANO_STT_EMERG.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ENDURB ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB = TAB_APOIO_BOOLEANO_ENDURB.ID LEFT OUTER JOIN TAB_APOIO_BAIRROS ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_BAIRRO = TAB_APOIO_BAIRROS.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_URB ON TAB_FISH_FAMILIAS.FISH_FAM_ENDURB_MUNIC = TAB_APOIO_MUNICIPIOS_URB.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ENDRUR ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR = TAB_APOIO_BOOLEANO_ENDRUR.ID LEFT OUTER JOIN TAB_APOIO_LOCALIDADES ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_LOCAL = TAB_APOIO_LOCALIDADES.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS AS TAB_APOIO_MUNICIPIOS_RUR ON TAB_FISH_FAMILIAS.FISH_FAM_ENDRUR_MUNIC = TAB_APOIO_MUNICIPIOS_RUR.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_415421 ON TAB_FISH_FAMILIAS.FISH_FAM_LINK_STATUS = TAB_APOIO_BOOLEANO_415421.ID LEFT OUTER JOIN TAB_FISH_PERFILENT ON TAB_FISH_PERFILENT.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_BARCO ON TAB_FISH_PERFILENT.FISH_PERFIL_E_BARCO = TAB_APOIO_BOOLEANO_E_BARCO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_BARCO_ENT ON TAB_FISH_PERFILENT.FISH_PERFIL_E_BARCO_ENT = TAB_APOIO_BOOLEANO_E_BARCO_ENT.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_MOTOR ON TAB_FISH_PERFILENT.FISH_PERFIL_E_MOTOR = TAB_APOIO_BOOLEANO_E_MOTOR.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_MOTOR_ENT ON TAB_FISH_PERFILENT.FISH_PERFIL_E_MOTOR_ENT = TAB_APOIO_BOOLEANO_E_MOTOR_ENT.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_TRALHA ON TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA = TAB_APOIO_BOOLEANO_E_TRALHA.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_TRALHA_ENT ON TAB_FISH_PERFILENT.FISH_PERFIL_E_TRALHA_ENT = TAB_APOIO_BOOLEANO_E_TRALHA_ENT.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_RANCHO ON TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA = TAB_APOIO_BOOLEANO_E_RANCHO.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_RANCHO01 ON TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT01 = TAB_APOIO_BOOLEANO_E_RANCHO01.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_RANCHO02 ON TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT02 = TAB_APOIO_BOOLEANO_E_RANCHO02.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_RANCHO03 ON TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT03 = TAB_APOIO_BOOLEANO_E_RANCHO03.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_E_RANCHO04 ON TAB_FISH_PERFILENT.FISH_PERFIL_E_CESTA_ENT04 = TAB_APOIO_BOOLEANO_E_RANCHO04.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_DEVOL ON TAB_FISH_PERFILENT.FISH_PERFIL_DEVOLUT = TAB_APOIO_BOOLEANO_DEVOL.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_DEVOL_OK ON TAB_FISH_PERFILENT.FISH_PERFIL_DEVOLUT_ACEITE = TAB_APOIO_BOOLEANO_DEVOL_OK.ID LEFT OUTER JOIN TAB_FISH_ACOMP_ANTESTRANS ON TAB_FISH_ACOMP_ANTESTRANS.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ANTES_01 ON TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_BOO_PESCAVA = TAB_APOIO_BOOLEANO_ACOMP_ANTES_01.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ANTES_02 ON TAB_FISH_ACOMP_ANTESTRANS.FISH_AA_BOO_PESCA_VENDIA = TAB_APOIO_BOOLEANO_ACOMP_ANTES_02.ID LEFT OUTER JOIN TAB_FISH_ACOMP_ENTREVISTA ON TAB_FISH_ACOMP_ENTREVISTA.FISH_FAM_ID = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_FISH_CAMPANHAS ON TAB_FISH_CAMPANHAS.FISH_CAMP_ID = TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_CAMPANHA LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_APOIO_TECNICOS.ID = TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_TECNICO LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_01 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_PESCA_REALIZOU = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_01.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_02 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_PESCA_USOUEQUIPS = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_02.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_03 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_PESCA_LOCALMUDOU = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_03.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_04 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_PESCA_LOCALMELHOR = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_04.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_05 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_PESCA_RESULTMELHOR = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_05.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_06 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_PESCA_ESPECIESMUDOU = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_06.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_07 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_PESCA_CONDVIDAMELHOR = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_07.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_08 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_PESCA_PRODVENDIDA = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_08.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_09 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_PESCA_SATISFACAO = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_09.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_10 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_ATEND_SATISFACAO = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_10.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_11 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_COOP_FILIACAO = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_11.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_12 ON TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_BOO_PESCA_FICHASOK = TAB_APOIO_BOOLEANO_ACOMP_ENTREVISTA_12.ID LEFT OUTER JOIN TAB_APOIO_PESCA_EQUIPNUSO ON TAB_APOIO_PESCA_EQUIPNUSO.ID = TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_FK_PESCA_NUSOUEQUIPS LEFT OUTER JOIN TAB_APOIO_PESCA_MOTIVO ON TAB_APOIO_PESCA_MOTIVO.ID = TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_FK_PESCA_NENHUMAPESCARIA LEFT OUTER JOIN TAB_APOIO_PESCA_FICHASNPREENC ON TAB_APOIO_PESCA_FICHASNPREENC.ID = TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_FK_PESCA_FICHASMOTIVO LEFT OUTER JOIN TAB_FISH_ACOMP_PERCEPCAO ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AEP_AE = TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOO_ACOMP_PERCEP_VIST_MOTOR ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_BOO_MOTOR = TAB_APOIO_BOO_ACOMP_PERCEP_VIST_MOTOR.ID LEFT OUTER JOIN TAB_APOIO_PESCA_EQUIPNVIST AS TAB_APOIO_FK_ACOMP_PERCEP_NVIST_MOTOR ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_FK_MOTORNVIST = TAB_APOIO_FK_ACOMP_PERCEP_NVIST_MOTOR.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOO_ACOMP_PERCEP_CONSERV_MOTOR ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_BOO_MOTORCONSERV = TAB_APOIO_BOO_ACOMP_PERCEP_CONSERV_MOTOR.ID LEFT OUTER JOIN TAB_APOIO_PESCA_EQUIPPOSSE AS TAB_APOIO_FK_ACOMP_PERCEP_POSSE_MOTOR ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_FK_MOTORPOSSE = TAB_APOIO_FK_ACOMP_PERCEP_POSSE_MOTOR.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOO_ACOMP_PERCEP_VIST_EMBARC ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_BOO_EMBARC = TAB_APOIO_BOO_ACOMP_PERCEP_VIST_EMBARC.ID LEFT OUTER JOIN TAB_APOIO_PESCA_EQUIPNVIST AS TAB_APOIO_FK_ACOMP_PERCEP_NVIST_EMBARC ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_FK_EMBARCNVIST = TAB_APOIO_FK_ACOMP_PERCEP_NVIST_EMBARC.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOO_ACOMP_PERCEP_CONSERV_EMBARC ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_BOO_EMBARCCONSERV = TAB_APOIO_BOO_ACOMP_PERCEP_CONSERV_EMBARC.ID LEFT OUTER JOIN TAB_APOIO_PESCA_EQUIPPOSSE AS TAB_APOIO_FK_ACOMP_PERCEP_POSSE_EMBARC ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_FK_EMBARCPOSSE = TAB_APOIO_FK_ACOMP_PERCEP_POSSE_EMBARC.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOO_ACOMP_PERCEP_VIST_TRALHA ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_BOO_TRALHA = TAB_APOIO_BOO_ACOMP_PERCEP_VIST_TRALHA.ID LEFT OUTER JOIN TAB_APOIO_PESCA_EQUIPNVIST AS TAB_APOIO_FK_ACOMP_PERCEP_NVIST_TRALHA ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_FK_TRALHANVIST = TAB_APOIO_FK_ACOMP_PERCEP_NVIST_TRALHA.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOO_ACOMP_PERCEP_CONSERV_TRALHA ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_BOO_TRALHACONSERV = TAB_APOIO_BOO_ACOMP_PERCEP_CONSERV_TRALHA.ID LEFT OUTER JOIN TAB_APOIO_PESCA_EQUIPPOSSE AS TAB_APOIO_FK_ACOMP_PERCEP_POSSE_TRALHA ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_FK_TRALHAPOSSE = TAB_APOIO_FK_ACOMP_PERCEP_POSSE_TRALHA.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOO_ACOMP_PERCEP_EVID_PESCA ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_BOO_EVIDPESCANDO = TAB_APOIO_BOO_ACOMP_PERCEP_EVID_PESCA.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOO_ACOMP_PERCEP_EVID_VENDA ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_BOO_EVIDVENDA = TAB_APOIO_BOO_ACOMP_PERCEP_EVID_VENDA.ID LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOO_ACOMP_PERCEP_EVID_FALSIDADE ON TAB_FISH_ACOMP_PERCEPCAO.FISH_AP_BOO_EVIDFALSIDADE = TAB_APOIO_BOO_ACOMP_PERCEP_EVID_FALSIDADE.ID WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia';", $db);
			$vetor = mysql_fetch_array($sql);

			$sql_data = mysql_query("SELECT MAX(TAB_FISH_ACOMP_ENTREVISTA.FISH_AE_DT_ENTR_ATUAL) AS FISH_AE_DT_ENTR_ATUAL FROM TAB_FISH_ACOMP_ENTREVISTA WHERE TAB_FISH_ACOMP_ENTREVISTA.FISH_FAM_ID = '$id_familia';", $db);
			$vetor_data = mysql_fetch_array($sql_data);
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
            <tr><td align="center"><strong><p>PLANO DE ASSISTÊNCIA TÉCNICA AMBIENTAL E SOCIAL PARA PESCADORES</p></strong></td></tr>
            <tr><td align="center"><strong><p>PLANO DE ACOMPANHAMENTO DOS BENEFICIÁRIOS</p></strong></td></tr>
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
    <center><h3>BLOCO A - IDENTIFICAÇÃO DO PESCADOR E DOS ENCAMINHAMENTOS DO PLANO DE TRANSIÇÃO</h3></center>
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
    <tr><td colspan="4"><strong>Data do último acompanhamento técnico: </strong> <?php echo date('d/m/Y', strtotime($vetor_data['FISH_AE_DT_ENTR_ATUAL'])); ?></td></tr>
	</table>

    <hr class="quebrapagina">

    <center><h3>BLOCO B - CARACTERIZAÇÃO DA ATIVIDADE ANTES DAS AÇÕES DE TRANSIÇÃO</h3></center>
  	<table>   
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr><td colspan="3"><strong>01 - Quais os principais equipamentos de pesca que o pescador possuia antes das ações de transição?</strong></td></tr>
    	<tr>
			<td colspan="3">
				<?php
					$sql_equip = mysql_query("SELECT TAB_APOIO_PESCA_EQUIP.DESCRICAO FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_ACOMP_AT_EQUIP ON TAB_FISH_ACOMP_AT_EQUIP.FISH_AAE_FAM = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_PESCA_EQUIP ON TAB_APOIO_PESCA_EQUIP.ID = TAB_FISH_ACOMP_AT_EQUIP.FISH_AAE_TIPO WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia';", $db);
					while ($vetor_equip=mysql_fetch_array($sql_equip)) {
						echo $vetor_equip['DESCRICAO'].'<br/>';
					}
				?>
			</td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr>
			<td colspan="2"><strong>02 - Antes das ações de transição o pescadore estava pescando?</strong></td>
			<td align="right"><?php echo $vetor['FISH_AA_BOO_PESCAVA_DESC']; ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr>
			<td colspan="2"><strong>03 - Quantas pescarias eram realizadas por mês?</strong></td>
			<td align="right"><?php echo $vetor['FISH_AA_QT_PESCA_QTMES']; ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr>
			<td colspan="2"><strong>04 - Quantos dias, em média, durava cada pescaria?</strong></td>
			<td align="right"><?php echo $vetor['FISH_AA_QT_PESCA_QTINT']; ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr>
			<td colspan="2"><strong>05 - Qual o número de dias em que pescava no mês?</strong></td>
			<td align="right"><?php echo $vetor['FISH_AA_QT_PESCA_QTDIAS']; ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr>
			<td colspan="2"><strong>06 - Com quantas pessoas o pescador pescava, em média, em cada pescaria?</strong></td>
			<td align="right"><?php echo $vetor['FISH_AA_QT_PESCA_QTPESSOAS']; ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr>
			<td colspan="2"><strong>07 - Quantos quilos de peixe pescava, em média, em cada pescaria, na temporada?</strong></td>
			<td align="right"><?php echo number_format($vetor['FISH_AA_QT_PESCA_PRODTEMP'],2,',','.'); ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr>
			<td colspan="2"><strong>08 - Quantos quilos de peixe pescava, em média, em cada pescaria, fora da temporada?</strong></td>
			<td align="right"><?php echo number_format($vetor['FISH_AA_QT_PESCA_PRODFTEMP'],2,',','.'); ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr>
			<td colspan="2"><strong>09 - O todo ou parte do peixe pescado era vendido?</strong></td>
			<td align="right"><?php echo $vetor['FISH_AA_BOO_PESCA_VENDIA_DESC']; ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr>
			<td colspan="2"><strong>10 - Quantos quilos de peixe, vendia, em média, de cada pescaria?</strong></td>
			<td align="right"><?php echo number_format($vetor['FISH_AA_QT_PESCA_PRODVENDA'],2,',','.'); ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr>
			<td colspan="2"><strong>13 - Quantos quilos de peixe, consumia, em média, de cada pescaria?</strong></td>
			<td align="right"><?php echo number_format($vetor['FISH_AA_QT_PESCA_PRODCOSUMO'],2,',','.'); ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>
		
		<tr>
			<td colspan="2"><strong>11 - Quanto recebia, em média, por quilo de peixe vendido? R$ </strong></td>
			<td align="right"><?php echo number_format($vetor['FISH_AA_VL_PESCA_PRODMEDIA'],2,',','.'); ?></td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr><td colspan="3"><strong>12 - Quais os locais, ou para quem, vendia os peixes?</strong></td></tr>
    	<tr>
			<td colspan="3">
				<?php
					$sql_comercio = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_APOIO_PESCA_COMERCIO.DESCRICAO FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_ACOMP_AT_COMERCIO ON TAB_FISH_ACOMP_AT_COMERCIO.FISH_AAC_FAM = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_PESCA_COMERCIO ON TAB_APOIO_PESCA_COMERCIO.ID = TAB_FISH_ACOMP_AT_COMERCIO.FISH_AAC_TIPO WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia';", $db);
					while ($vetor_comercio=mysql_fetch_array($sql_comercio)) {
						echo $vetor_comercio['DESCRICAO'].'<br/>';
					}
				?>
			</td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>

		<tr><td colspan="3"><strong>14 - Se não estava pescando, quais os motivos?</strong></td></tr>
    	<tr>
			<td colspan="3">
				<?php
					$sql_motivo = mysql_query("SELECT TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_APOIO_PESCA_MOTIVO.DESCRICAO FROM TAB_FISH_FAMILIAS LEFT OUTER JOIN TAB_FISH_ACOMP_AT_MOTIVO ON TAB_FISH_ACOMP_AT_MOTIVO.FISH_AAM_FAM = TAB_FISH_FAMILIAS.FISH_FAM_ID LEFT OUTER JOIN TAB_APOIO_PESCA_MOTIVO ON TAB_APOIO_PESCA_MOTIVO.ID = TAB_FISH_ACOMP_AT_MOTIVO.FISH_AAM_TIPO WHERE TAB_FISH_FAMILIAS.FISH_FAM_ID = '$id_familia';", $db);
					while ($vetor_motivo = mysql_fetch_array($sql_motivo)) {
						echo $vetor_equip['DESCRICAO'];
					}
				?>
			</td>
		</tr>
   		<tr><td colspan="3">&nbsp;</td></tr>
		
    </table><br/> 

</body>
</html>
<?php
}
}
?>