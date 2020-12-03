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
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			if(isset($_POST["rgme"])){
				$rgme = $_POST["rgme"];
			} else {
				$data_atual = reverse_date(date("d/m/Y"));
				$sql_RGME_DATA = mysql_query("select ID from TAB_APOIO_RGME where '$data_atual' between DATA_INICIAL and DATA_FINAL;", $db);
				$vetor_RGME_DATA=mysql_fetch_array($sql_RGME_DATA);
				$rgme = $vetor_RGME_DATA[ID];
			}
			$tecnico = $_SESSION['tecnico'];
			$contador=0;
			$sql_RGME = mysql_query("select * from TAB_APOIO_RGME order by ANO, MES asc;", $db);
			$sql_GRUPO01 = mysql_query("select TAB_415421_PLANVISITAS.PLAN_VISIT_ID, TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA, TAB_415421_PLANVISITAS.PLAN_VISIT_RGME, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TECNICOS.DESCRICAO as PLAN_VISIT_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO as PLAN_VISIT_GRUPO_DESC, TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO, TAB_415421_PLANVISITAS.PLAN_VISIT_EXECUCAO, TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA, TAB_APOIO_BOOLEANO.DESCRICAO as PLAN_VISIT_CONCLUIDA_DESC from TAB_415421_PLANVISITAS left outer join TAB_415421_FAMILIAS on TAB_415421_FAMILIAS.FAMILIA_CODIGO = TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_APOIO_TECNICOS on TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = TAB_APOIO_TECNICOS.ID left outer join TAB_APOIO_PLAN_GRUPOS on TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID left outer join TAB_APOIO_BOOLEANO on TAB_APOIO_BOOLEANO.ID = TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA where TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = 1 and TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tecnico' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' order by TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO asc, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc;", $db);
			$sql_GRUPO02 = mysql_query("select TAB_415421_PLANVISITAS.PLAN_VISIT_ID, TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA, TAB_415421_PLANVISITAS.PLAN_VISIT_RGME, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TECNICOS.DESCRICAO as PLAN_VISIT_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO as PLAN_VISIT_GRUPO_DESC, TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO, TAB_415421_PLANVISITAS.PLAN_VISIT_EXECUCAO, TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA, TAB_APOIO_BOOLEANO.DESCRICAO as PLAN_VISIT_CONCLUIDA_DESC from TAB_415421_PLANVISITAS left outer join TAB_415421_FAMILIAS on TAB_415421_FAMILIAS.FAMILIA_CODIGO = TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_APOIO_TECNICOS on TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = TAB_APOIO_TECNICOS.ID left outer join TAB_APOIO_PLAN_GRUPOS on TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID left outer join TAB_APOIO_BOOLEANO on TAB_APOIO_BOOLEANO.ID = TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA where TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = 2 and TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tecnico' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' order by TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO asc, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc;", $db);
			$sql_GRUPO03 = mysql_query("select TAB_415421_PLANVISITAS.PLAN_VISIT_ID, TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA, TAB_415421_PLANVISITAS.PLAN_VISIT_RGME, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TECNICOS.DESCRICAO as PLAN_VISIT_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO as PLAN_VISIT_GRUPO_DESC, TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO, TAB_415421_PLANVISITAS.PLAN_VISIT_EXECUCAO, TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA, TAB_APOIO_BOOLEANO.DESCRICAO as PLAN_VISIT_CONCLUIDA_DESC from TAB_415421_PLANVISITAS left outer join TAB_415421_FAMILIAS on TAB_415421_FAMILIAS.FAMILIA_CODIGO = TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_APOIO_TECNICOS on TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = TAB_APOIO_TECNICOS.ID left outer join TAB_APOIO_PLAN_GRUPOS on TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID left outer join TAB_APOIO_BOOLEANO on TAB_APOIO_BOOLEANO.ID = TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA where TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = 3 and TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tecnico' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' order by TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO asc, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc;", $db);
			$sql_GRUPO04 = mysql_query("select TAB_415421_PLANVISITAS.PLAN_VISIT_ID, TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA, TAB_415421_PLANVISITAS.PLAN_VISIT_RGME, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TECNICOS.DESCRICAO as PLAN_VISIT_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO as PLAN_VISIT_GRUPO_DESC, TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO, TAB_415421_PLANVISITAS.PLAN_VISIT_EXECUCAO, TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA, TAB_APOIO_BOOLEANO.DESCRICAO as PLAN_VISIT_CONCLUIDA_DESC from TAB_415421_PLANVISITAS left outer join TAB_415421_FAMILIAS on TAB_415421_FAMILIAS.FAMILIA_CODIGO = TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_APOIO_TECNICOS on TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = TAB_APOIO_TECNICOS.ID left outer join TAB_APOIO_PLAN_GRUPOS on TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID left outer join TAB_APOIO_BOOLEANO on TAB_APOIO_BOOLEANO.ID = TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA where TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = 4 and TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tecnico' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' order by TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO asc, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc;", $db);
			$sql_GRUPO_OUTROS = mysql_query("select TAB_415421_PLANVISITAS.PLAN_VISIT_ID, TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA, TAB_415421_PLANVISITAS.PLAN_VISIT_RGME, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TECNICOS.DESCRICAO as PLAN_VISIT_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO as PLAN_VISIT_GRUPO_DESC, TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO, TAB_415421_PLANVISITAS.PLAN_VISIT_EXECUCAO, TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA, TAB_APOIO_BOOLEANO.DESCRICAO as PLAN_VISIT_CONCLUIDA_DESC from TAB_415421_PLANVISITAS left outer join TAB_415421_FAMILIAS on TAB_415421_FAMILIAS.FAMILIA_CODIGO = TAB_415421_PLANVISITAS.PLAN_VISIT_FAMILIA left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_APOIO_TECNICOS on TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = TAB_APOIO_TECNICOS.ID left outer join TAB_APOIO_PLAN_GRUPOS on TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID left outer join TAB_APOIO_BOOLEANO on TAB_APOIO_BOOLEANO.ID = TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA where TAB_415421_PLANVISITAS.PLAN_VISIT_GRUPO not in (1,2,3,4) and TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tecnico' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' order by TAB_415421_PLANVISITAS.PLAN_VISIT_PREVISAO asc, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc;", $db);
?>
<?php require_once("includes/header-completo.php");?>
<script type="text/javascript">  
$(document).ready(function(){  
        $("#palco > div").hide();  
		$("#filter").change(function(){  
                $("#palco > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
});  
</script>
<script type="text/javascript">
function editDataVisit(id,dataNova){
	var idNew = id;
	var dtNew = document.getElementById(dataNova).value;
//	alert('idVisit='+idNew+'&dtVisit'+dtNew);
    $.ajax({
        type: 'POST',
        url: 'planejamento_processar.php',
		data: { idVisit: idNew, dtVisit: dtNew},
		complete: function(data)
			{ window.location="planejamento_listar_familias.php"; }
    });
}
</script>
<script type="text/javascript">
/* MÃ¡scaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
</script>
<body class="with-side-menu">
<?php require_once("includes/site-header.php");?>
	<div class="mobile-menu-left-overlay"></div>
		<nav class="side-menu">
		    <ul class="side-menu-list">
	    	    <?php include"includes/menu.php"; ?>
	        </ul>
	    </section>
	</nav><!--.side-menu-->
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Familias - Projetos 4.1.5 / 4.2.1 / Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Planejamento de Visitas Mensais - RGM-E - v.1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
			<form action="planejamento_listar_familias.php" method="post" name="form_select_rgme" onSubmit="return validaForm()">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Selecione o mês para gerenciar as visitas:</th>
                        </tr>
                    </thead>
                	<tbody>
                    	<tr>
                            <td>
                                <select name="rgme" id="rgme" class="form-control" required>
                                    <option value="0" selected>Selecione o Relatório desejado...</option>
                              		<?php while ($vetor_RGME=mysql_fetch_array($sql_RGME)) { ?>
                              			<option label="<?php echo $vetor_RGME['DESCRICAO']; ?>" value="<?php echo $vetor_RGME['ID'] ?>" <?php if (strcasecmp($vetor_RGME['ID'], $rgme) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_RGME['DESCRICAO']." - Período: ".date('d/m/Y', strtotime($vetor_RGME['DATA_INICIAL']))." até ".date('d/m/Y', strtotime($vetor_RGME['DATA_FINAL'])); ?></option>
                              <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </tbody>
				</table>
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                    <tr>
                        <th><input name="buscar" class="float" type="image" src="imgs/buscar.png" value="Buscar" /></th>
                    </tr>
                    </thead>
                </table>
            </form>
			</div>
            <div>
            	<a href="planejamento_cadastrar_visita.php"><img src="imgs/adicionar.png" border="0"></a><br/><br/>
            </div>
   			<div class="box-typical box-typical-padding">
                	<div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">Grupo 01</a></li>
                            <li><a href="#view2">Grupo 02</a></li>
                            <li><a href="#view3">Grupo 03</a></li>
                            <li><a href="#view4">Grupo 04</a></li>
                            <li><a href="#view5">Demais Grupos</a></li>
                        </ul>
                        <div class="tabcontents">
                            <div id="view1">
                                <div id="scroll">
                                    <table width="100%">
                                        <tr align="center" bgcolor="#0D0C9B">
                                            <td width="29%"><strong><font color="#FFFFFF">Beneficiário</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="9%"><strong><font color="#FFFFFF">Benefício</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="19%"><strong><font color="#FFFFFF">Município</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Data Prevista</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Data Realizada</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="10%"><strong><font color="#FFFFFF">Ações</font></strong></td>
                                        </tr>
										<?php 
											$cor = "#D8D8D8";
											while ($vetor_GRUPO01=mysql_fetch_array($sql_GRUPO01)) {
												$contador++;
												if (strcasecmp($cor, "#FFFFFF") == 0){
													$cor = "#D8D8D8";
												} else {
													$cor = "#FFFFFF";
												}
												$nameForm='fData'.$contador;
												$idForm='id'.$contador;
												$dtForm='dtNew'.$contador;
										?>
                                        <tr bgcolor="<?php echo $cor; ?>">
                                        	<form method="POST" action="" id="<?php echo $nameForm; ?>" name="<?php echo $nameForm; ?>" onSubmit="">
                                            	<input type="hidden" id="<?php echo $idForm; ?>" name="<?php echo $idForm; ?>" value="<?php echo $vetor_GRUPO01['PLAN_VISIT_ID']; ?>">
                                                <td width="29%"><?php echo $vetor_GRUPO01['FAMILIA_BENEFICIARIO']; ?></td><td width="1%"></td>
                                                <td width="9%"><?php echo $vetor_GRUPO01['FAMILIA_BENEFICIO_DESC']; ?></td><td width="1%"></td>
                                                <td width="19%"><?php echo $vetor_GRUPO01['FAMILIA_MUNICIPIODESTINO_DESC']; ?></td><td width="1%"></td>
                                                <?php
                                                	if(strcasecmp($vetor_GRUPO01['PLAN_VISIT_CONCLUIDA'],'2')==0) {
												?>
                                                		<td width="14%" align="center"><input type="text" class="form-control" style="text-align:center" onKeyPress="mascara(this,mdata)" id="<?php echo $dtForm; ?>" name="<?php echo $dtForm; ?>" value="<?php echo date('d/m/Y', strtotime($vetor_GRUPO01['PLAN_VISIT_PREVISAO'])); ?>"></td><td width="1%"></td>
                                                        <?php
															if(!empty($vetor_GRUPO01['PLAN_VISIT_EXECUCAO'])){
														?>
																<td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO01['PLAN_VISIT_EXECUCAO'])); ?></td><td width="1%"></td>
                                                        <?php } else { ?>
                                                        		<td width="14%" align="center">&nbsp;</td><td width="1%"></td>
                                                        <?php } ?>
                                                    	<td width="10%" align="center">
                                                    		<a class="fancybox fancybox.ajax" href="javascript:void(0);" onClick="editDataVisit('<?php echo $vetor_GRUPO01['PLAN_VISIT_ID']; ?>','<?php echo $dtForm; ?>')"><img src="imgs/calendar.png" alt="Inserir Ações Planejadas" width="25" height="25" border="0"></a>
                                                			<a class="fancybox fancybox.ajax" hef="#" onClick="window.open('planejamento_incluir_acoes.php?id_visita=<?php echo $vetor_GRUPO01['PLAN_VISIT_ID']; ?>&id_familia=<?php echo $vetor_GRUPO01['PLAN_VISIT_FAMILIA']; ?>','Ações a Realizar na Visita', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/checklist.png" alt="Inserir Ações Planejadas" width="25" height="25" border="0"></a>
                                                    	</td>
                                                <?php } else { ?>
                                                	<td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO01['PLAN_VISIT_PREVISAO'])); ?></td><td width="1%"></td>
                                                    <td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO01['PLAN_VISIT_EXECUCAO'])); ?></td><td width="1%"></td>
                                                    <td width="10%" align="center">&nbsp;</td>
                                                <?php } ?>
											</form>
										</tr>
										<?php } ?>
                                    </table>
                                </div>                                
                            </div> <!-- View 01 -->

                            <div id="view2">
                                <div id="scroll">
                                    <table width="100%">
                                        <tr align="center" bgcolor="#0D0C9B">
                                            <td width="29%"><strong><font color="#FFFFFF">Beneficiário</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="9%"><strong><font color="#FFFFFF">Benefício</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="19%"><strong><font color="#FFFFFF">Município</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Data Prevista</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Data Realizada</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="10%"><strong><font color="#FFFFFF">Ações</font></strong></td>
                                        </tr>
										<?php 
											$cor = "#D8D8D8";
											while ($vetor_GRUPO02=mysql_fetch_array($sql_GRUPO02)) {
												$contador++;
												if (strcasecmp($cor, "#FFFFFF") == 0){
													$cor = "#D8D8D8";
												} else {
													$cor = "#FFFFFF";
												}
												$nameForm='fData'.$contador;
												$idForm='id'.$contador;
												$dtForm='dtNew'.$contador;
										?>
                                        <tr bgcolor="<?php echo $cor; ?>">
                                        	<form method="POST" action="" id="<?php echo $nameForm; ?>" name="<?php echo $nameForm; ?>" onSubmit="">
                                            	<input type="hidden" id="<?php echo $idForm; ?>" name="<?php echo $idForm; ?>" value="<?php echo $vetor_GRUPO02['PLAN_VISIT_ID']; ?>">
                                                <td width="29%"><?php echo $vetor_GRUPO02['FAMILIA_BENEFICIARIO']; ?></td><td width="1%"></td>
                                                <td width="9%"><?php echo $vetor_GRUPO02['FAMILIA_BENEFICIO_DESC']; ?></td><td width="1%"></td>
                                                <td width="19%"><?php echo $vetor_GRUPO02['FAMILIA_MUNICIPIODESTINO_DESC']; ?></td><td width="1%"></td>
                                                <?php
                                                	if(strcasecmp($vetor_GRUPO02['PLAN_VISIT_CONCLUIDA'],'2')==0) {
												?>
                                                		<td width="14%" align="center"><input type="text" class="form-control" style="text-align:center" onKeyPress="mascara(this,mdata)" id="<?php echo $dtForm; ?>" name="<?php echo $dtForm; ?>" value="<?php echo date('d/m/Y', strtotime($vetor_GRUPO02['PLAN_VISIT_PREVISAO'])); ?>"></td><td width="1%"></td>
                                                        <?php
															if(!empty($vetor_GRUPO02['PLAN_VISIT_EXECUCAO'])){
														?>
																<td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO02['PLAN_VISIT_EXECUCAO'])); ?></td><td width="1%"></td>
                                                        <?php } else { ?>
                                                        		<td width="14%" align="center">&nbsp;</td><td width="1%"></td>
                                                        <?php } ?>
                                                    	<td width="10%" align="center">
                                                    		<a class="fancybox fancybox.ajax" href="javascript:void(0);" onClick="editDataVisit('<?php echo $vetor_GRUPO02['PLAN_VISIT_ID']; ?>','<?php echo $dtForm; ?>')"><img src="imgs/calendar.png" alt="Inserir Ações Planejadas" width="25" height="25" border="0"></a>
                                                			<a class="fancybox fancybox.ajax" hef="#" onClick="window.open('planejamento_incluir_acoes.php?id_visita=<?php echo $vetor_GRUPO02['PLAN_VISIT_ID']; ?>&id_familia=<?php echo $vetor_GRUPO02['PLAN_VISIT_FAMILIA']; ?>','Ações a Realizar na Visita', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/checklist.png" alt="Inserir Ações Planejadas" width="25" height="25" border="0"></a>
                                                    	</td>
                                                <?php } else { ?>
                                                	<td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO02['PLAN_VISIT_PREVISAO'])); ?></td><td width="1%"></td>
                                                    <td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO02['PLAN_VISIT_EXECUCAO'])); ?></td><td width="1%"></td>
                                                    <td width="10%" align="center">&nbsp;</td>
                                                <?php } ?>
											</form>
										</tr>
										<?php } ?>
                                    </table>
                                </div>                                
                            </div> <!-- View 02 -->

                            <div id="view3">
                                <div id="scroll">
                                    <table width="100%">
                                        <tr align="center" bgcolor="#0D0C9B">
                                            <td width="29%"><strong><font color="#FFFFFF">Beneficiário</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="9%"><strong><font color="#FFFFFF">Benefício</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="19%"><strong><font color="#FFFFFF">Município</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Data Prevista</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Data Realizada</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="10%"><strong><font color="#FFFFFF">Ações</font></strong></td>
                                        </tr>
										<?php 
											$cor = "#D8D8D8";
											while ($vetor_GRUPO03=mysql_fetch_array($sql_GRUPO03)) {
												$contador++;
												if (strcasecmp($cor, "#FFFFFF") == 0){
													$cor = "#D8D8D8";
												} else {
													$cor = "#FFFFFF";
												}
												$nameForm='fData'.$contador;
												$idForm='id'.$contador;
												$dtForm='dtNew'.$contador;
										?>
                                        <tr bgcolor="<?php echo $cor; ?>">
                                        	<form method="POST" action="" id="<?php echo $nameForm; ?>" name="<?php echo $nameForm; ?>" onSubmit="">
                                            	<input type="hidden" id="<?php echo $idForm; ?>" name="<?php echo $idForm; ?>" value="<?php echo $vetor_GRUPO03['PLAN_VISIT_ID']; ?>">
                                                <td width="29%"><?php echo $vetor_GRUPO03['FAMILIA_BENEFICIARIO']; ?></td><td width="1%"></td>
                                                <td width="9%"><?php echo $vetor_GRUPO03['FAMILIA_BENEFICIO_DESC']; ?></td><td width="1%"></td>
                                                <td width="19%"><?php echo $vetor_GRUPO03['FAMILIA_MUNICIPIODESTINO_DESC']; ?></td><td width="1%"></td>
                                                <?php
                                                	if(strcasecmp($vetor_GRUPO03['PLAN_VISIT_CONCLUIDA'],'2')==0) {
												?>
                                                		<td width="14%" align="center"><input type="text" class="form-control" style="text-align:center" onKeyPress="mascara(this,mdata)" id="<?php echo $dtForm; ?>" name="<?php echo $dtForm; ?>" value="<?php echo date('d/m/Y', strtotime($vetor_GRUPO03['PLAN_VISIT_PREVISAO'])); ?>"></td><td width="1%"></td>
                                                        <?php
															if(!empty($vetor_GRUPO03['PLAN_VISIT_EXECUCAO'])){
														?>
																<td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO03['PLAN_VISIT_EXECUCAO'])); ?></td><td width="1%"></td>
                                                        <?php } else { ?>
                                                        		<td width="14%" align="center">&nbsp;</td><td width="1%"></td>
                                                        <?php } ?>
                                                    	<td width="10%" align="center">
                                                    		<a class="fancybox fancybox.ajax" href="javascript:void(0);" onClick="editDataVisit('<?php echo $vetor_GRUPO03['PLAN_VISIT_ID']; ?>','<?php echo $dtForm; ?>')"><img src="imgs/calendar.png" alt="Inserir Ações Planejadas" width="25" height="25" border="0"></a>
                                                			<a class="fancybox fancybox.ajax" hef="#" onClick="window.open('planejamento_incluir_acoes.php?id_visita=<?php echo $vetor_GRUPO03['PLAN_VISIT_ID']; ?>&id_familia=<?php echo $vetor_GRUPO03['PLAN_VISIT_FAMILIA']; ?>','Ações a Realizar na Visita', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/checklist.png" alt="Inserir Ações Planejadas" width="25" height="25" border="0"></a>
                                                    	</td>
                                                <?php } else { ?>
                                                	<td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO03['PLAN_VISIT_PREVISAO'])); ?></td><td width="1%"></td>
                                                    <td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO03['PLAN_VISIT_EXECUCAO'])); ?></td><td width="1%"></td>
                                                    <td width="10%" align="center">&nbsp;</td>
                                                <?php } ?>
											</form>
										</tr>
										<?php } ?>
                                    </table>
                                </div>                                
                            </div> <!-- View 03 -->
                            
                            <div id="view4">
                                <div id="scroll">
                                    <table width="100%">
                                        <tr align="center" bgcolor="#0D0C9B">
                                            <td width="29%"><strong><font color="#FFFFFF">Beneficiário</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="9%"><strong><font color="#FFFFFF">Benefício</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="19%"><strong><font color="#FFFFFF">Município</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Data Prevista</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Data Realizada</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="10%"><strong><font color="#FFFFFF">Ações</font></strong></td>
                                        </tr>
										<?php 
											$cor = "#D8D8D8";
											while ($vetor_GRUPO04=mysql_fetch_array($sql_GRUPO04)) {
												$contador++;
												if (strcasecmp($cor, "#FFFFFF") == 0){
													$cor = "#D8D8D8";
												} else {
													$cor = "#FFFFFF";
												}
												$nameForm='fData'.$contador;
												$idForm='id'.$contador;
												$dtForm='dtNew'.$contador;
										?>
                                        <tr bgcolor="<?php echo $cor; ?>">
                                        	<form method="POST" action="" id="<?php echo $nameForm; ?>" name="<?php echo $nameForm; ?>" onSubmit="">
                                            	<input type="hidden" id="<?php echo $idForm; ?>" name="<?php echo $idForm; ?>" value="<?php echo $vetor_GRUPO04['PLAN_VISIT_ID']; ?>">
                                                <td width="29%"><?php echo $vetor_GRUPO04['FAMILIA_BENEFICIARIO']; ?></td><td width="1%"></td>
                                                <td width="9%"><?php echo $vetor_GRUPO04['FAMILIA_BENEFICIO_DESC']; ?></td><td width="1%"></td>
                                                <td width="19%"><?php echo $vetor_GRUPO04['FAMILIA_MUNICIPIODESTINO_DESC']; ?></td><td width="1%"></td>
                                                <?php
                                                	if(strcasecmp($vetor_GRUPO04['PLAN_VISIT_CONCLUIDA'],'2')==0) {
												?>
                                                		<td width="14%" align="center"><input type="text" class="form-control" style="text-align:center" onKeyPress="mascara(this,mdata)" id="<?php echo $dtForm; ?>" name="<?php echo $dtForm; ?>" value="<?php echo date('d/m/Y', strtotime($vetor_GRUPO04['PLAN_VISIT_PREVISAO'])); ?>"></td><td width="1%"></td>
                                                        <?php
															if(!empty($vetor_GRUPO04['PLAN_VISIT_EXECUCAO'])){
														?>
																<td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO04['PLAN_VISIT_EXECUCAO'])); ?></td><td width="1%"></td>
                                                        <?php } else { ?>
                                                        		<td width="14%" align="center">&nbsp;</td><td width="1%"></td>
                                                        <?php } ?>
                                                    	<td width="10%" align="center">
                                                    		<a class="fancybox fancybox.ajax" href="javascript:void(0);" onClick="editDataVisit('<?php echo $vetor_GRUPO04['PLAN_VISIT_ID']; ?>','<?php echo $dtForm; ?>')"><img src="imgs/calendar.png" alt="Inserir Ações Planejadas" width="25" height="25" border="0"></a>
                                                			<a class="fancybox fancybox.ajax" hef="#" onClick="window.open('planejamento_incluir_acoes.php?id_visita=<?php echo $vetor_GRUPO04['PLAN_VISIT_ID']; ?>&id_familia=<?php echo $vetor_GRUPO04['PLAN_VISIT_FAMILIA']; ?>','Ações a Realizar na Visita', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/checklist.png" alt="Inserir Ações Planejadas" width="25" height="25" border="0"></a>
                                                    	</td>
                                                <?php } else { ?>
                                                	<td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO04['PLAN_VISIT_PREVISAO'])); ?></td><td width="1%"></td>
                                                    <td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO04['PLAN_VISIT_EXECUCAO'])); ?></td><td width="1%"></td>
                                                    <td width="10%" align="center">&nbsp;</td>
                                                <?php } ?>
											</form>
										</tr>
										<?php } ?>
                                    </table>
                                </div>                                
                            </div> <!-- View 04 -->
                            
                            <div id="view5">
                                <div id="scroll">
                                    <table width="100%">
                                        <tr align="center" bgcolor="#0D0C9B">
                                            <td width="29%"><strong><font color="#FFFFFF">Beneficiário</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="9%"><strong><font color="#FFFFFF">Benefício</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="19%"><strong><font color="#FFFFFF">Município</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Data Prevista</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="14%"><strong><font color="#FFFFFF">Data Realizada</font></strong></td>
                                            <td width="1%"></td>
                                            <td width="10%"><strong><font color="#FFFFFF">Ações</font></strong></td>
                                        </tr>
										<?php 
											$cor = "#D8D8D8";
											while ($vetor_GRUPO_OUTROS=mysql_fetch_array($sql_GRUPO_OUTROS)) {
												$contador++;
												if (strcasecmp($cor, "#FFFFFF") == 0){
													$cor = "#D8D8D8";
												} else {
													$cor = "#FFFFFF";
												}
												$nameForm='fData'.$contador;
												$idForm='id'.$contador;
												$dtForm='dtNew'.$contador;
										?>
                                        <tr bgcolor="<?php echo $cor; ?>">
                                        	<form method="POST" action="" id="<?php echo $nameForm; ?>" name="<?php echo $nameForm; ?>" onSubmit="">
                                            	<input type="hidden" id="<?php echo $idForm; ?>" name="<?php echo $idForm; ?>" value="<?php echo $vetor_GRUPO_OUTROS['PLAN_VISIT_ID']; ?>">
                                                <td width="29%"><?php echo $vetor_GRUPO_OUTROS['FAMILIA_BENEFICIARIO']; ?></td><td width="1%"></td>
                                                <td width="9%"><?php echo $vetor_GRUPO_OUTROS['FAMILIA_BENEFICIO_DESC']; ?></td><td width="1%"></td>
                                                <td width="19%"><?php echo $vetor_GRUPO_OUTROS['FAMILIA_MUNICIPIODESTINO_DESC']; ?></td><td width="1%"></td>
                                                <?php
                                                	if(strcasecmp($vetor_GRUPO_OUTROS['PLAN_VISIT_CONCLUIDA'],'2')==0) {
												?>
                                                		<td width="14%" align="center"><input type="text" class="form-control" style="text-align:center" onKeyPress="mascara(this,mdata)" id="<?php echo $dtForm; ?>" name="<?php echo $dtForm; ?>" value="<?php echo date('d/m/Y', strtotime($vetor_GRUPO_OUTROS['PLAN_VISIT_PREVISAO'])); ?>"></td><td width="1%"></td>
                                                        <?php
															if(!empty($vetor_GRUPO_OUTROS['PLAN_VISIT_EXECUCAO'])){
														?>
																<td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO_OUTROS['PLAN_VISIT_EXECUCAO'])); ?></td><td width="1%"></td>
                                                        <?php } else { ?>
                                                        		<td width="14%" align="center">&nbsp;</td><td width="1%"></td>
                                                        <?php } ?>
                                                    	<td width="10%" align="center">
                                                    		<a class="fancybox fancybox.ajax" href="javascript:void(0);" onClick="editDataVisit('<?php echo $vetor_GRUPO_OUTROS['PLAN_VISIT_ID']; ?>','<?php echo $dtForm; ?>')"><img src="imgs/calendar.png" alt="Inserir Ações Planejadas" width="25" height="25" border="0"></a>
                                                			<a class="fancybox fancybox.ajax" hef="#" onClick="window.open('planejamento_incluir_acoes.php?id_visita=<?php echo $vetor_GRUPO_OUTROS['PLAN_VISIT_ID']; ?>&id_familia=<?php echo $vetor_GRUPO_OUTROS['PLAN_VISIT_FAMILIA']; ?>','Ações a Realizar na Visita', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/checklist.png" alt="Inserir Ações Planejadas" width="25" height="25" border="0"></a>
                                                    	</td>
                                                <?php } else { ?>
                                                	<td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO_OUTROS['PLAN_VISIT_PREVISAO'])); ?></td><td width="1%"></td>
                                                    <td width="14%" align="center"><?php echo date('d/m/Y', strtotime($vetor_GRUPO_OUTROS['PLAN_VISIT_EXECUCAO'])); ?></td><td width="1%"></td>
                                                    <td width="10%" align="center">&nbsp;</td>
                                                <?php } ?>
											</form>
										</tr>
										<?php } ?>
                                    </table>
                                </div>                                
                            </div> <!-- View 05 -->
                    	</div>
                    </div>
					</br>
            </div><!--.box-typical-->            
		</div>
	</div>
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>