﻿<?php
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
			$id = $_GET['id'];
			$id_evento = $_GET['id_evento'];
			$id_familia = $_GET['id_familia'];
			$sql_EVENTO = mysql_query("SELECT * FROM TAB_415421_EVENTOS WHERE EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
			$vetor_EVENTO = mysql_fetch_array($sql_EVENTO);
			$sql_TPEVENTOS = mysql_query("SELECT * FROM TAB_APOIO_EVENTOS ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_TECNICOS = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());

			$sql_CLASSRIR415 = mysql_query("SELECT * FROM TAB_RIR415_CLASSIFICACAO WHERE CLASSRIR415_CODIGO = '$id' AND EVENTOS_CODIGO = '$id_evento';", $db) or die(mysql_error());
			$vetor_CLASSRIR415 = mysql_fetch_array($sql_CLASSRIR415);
?>
<?php require_once("includes/header-completo.php");?>
<style>
table {
  border-collapse: collapse;
  border: 0px;
}
thead {
  background-color:#090047;
  color:#FFFFFF;
  font-size:16px;
  text-align:center;
  font-weight:bold;
}
th {
  font-weight: normal;
  text-align: left;
}
</style>
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript">

function habilitarSelect() {
	$("#tiporir415").prop("disabled", false);
	$("#subtiporir415").prop("disabled", false);
}

$(document).ready(function(){
	var cat = $('#tiporir415').val();
	var subcat = $('#subtiporir415').val();
	
	$('#tiporir415').change(function(){
		$('#subtiporir415').load('buscarir415_completo.php?id='+$('#tiporir415').val());
	});

	$("#enable").click(function (){
		$("#tiporir415").prop("disabled", false);
		$("#subtiporir415").prop("disabled", false);
		$('#subtiporir415').load('buscarir415_completo.php?id='+$('#tiporir415').val());
	});

    $("#disable").click(function (){
		if ($('#subtiporir415').val() == 0) {
			alert("SubAtividade é Inválida");
		} else {
			$("#tiporir415").prop("disabled", true);
			$("#subtiporir415").prop("disabled", true);
		}
	});
});
</script>
<body>
<?php require_once("includes/site-header.php");?>
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Gestão do Projetos 4.1.5 e 4.2.1 e Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Dados de Atividade - RIR Reparação</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="#" method="post" name="#" enctype="multipart/form-data" id="#">
                    <div class="form-group row">
						<div class="col-lg-4">
                        	<label class="form-label semibold" for="EVENTOS_DATA">Data do Evento:</label>
                            <input type="text" name="EVENTOS_DATA" class="form-control" id="EVENTOS_DATA" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_EVENTO['EVENTOS_DATA'])); ?>">
                        </div>
                        <div class="col-lg-8">
                        	<label class="form-label semibold" for="EVENTOS_TIPO">Tipo do Evento:</label>
                            <select name="EVENTOS_TIPO" id="EVENTOS_TIPO" class="form-control">
								<?php while ($vetor_TPEVENTOS=mysql_fetch_array($sql_TPEVENTOS)) { ?>
                                <option label="<?php echo $vetor_TPEVENTOS['DESCRICAO']; ?>" value="<?php echo $vetor_TPEVENTOS['ID']; ?>" <?php if (strcasecmp($vetor_EVENTO['EVENTOS_TIPO'], $vetor_TPEVENTOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPEVENTOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Data do Evento / Tipo do Evento -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="EVENTOS_OBSERVACOES">Observações:</label>
                            <input type="text" name="EVENTOS_OBSERVACOES" class="form-control" id="EVENTOS_OBSERVACOES" placeholder="Digite observações..." value="<?php echo $vetor_EVENTO['EVENTOS_OBSERVACOES']; ?>">
                         </div>	
                    </div> <!-- Observações -->
				</form>
			</div><!--.box-typical-->
			<center>
            	<button type="button" class="btn btn-success" href="#" id="enable">Habilita Edição</button>
            	<button type="button" class="btn btn-warning" href="#" id="disable">Desabilita Edição</button><br/><br/>
			</center>
			<div class="box-typical box-typical-padding">
            	<form action="recebe_alterar_evento_classrir415.php?id=<?php echo $id; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="recebe_alterar_evento_classrir415" enctype="multipart/form-data" id="recebe_alterar_evento_classrir415">
                    <div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">RIR Reparação</a></li>
                        </ul>

	                    <div class="tabcontents">
                    
                        <div id="view1">
                        <table width="100%">
                          <thead>
                            <td width="28%">Atividade de Reparação</td>
                            <td width="2%"></td>
                            <td width="28%">Sub-Atividade de Reparação</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição Detalhada</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
						  <tr>
                          	<td width='28%' class='style12'>
                            <select name="tiporir415" id="tiporir415" class="form-control" disabled/>
                                <?php
									$subvisitrir415 = $vetor_CLASSRIR415['CLASSRIR415_TIPO'];
									$result01 = mysql_query("SELECT ID_PRINCIPAL FROM TAB_APOIO_TPSUBVISITRIR415 WHERE ID = '$subvisitrir415';", $db) or die(mysql_error());
									$row01 = mysql_fetch_array($result01);
									$result02 = mysql_query("SELECT * FROM TAB_APOIO_TPVISITRIR415 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
									while($row02 = mysql_fetch_array($result02)){
										echo "<option ";
										if (strcasecmp($row01['ID_PRINCIPAL'], $row02['ID']) == 0){
											echo 'selected="selected"';
										} 
                                        echo " value='".$row02['ID']."'>".$row02['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'></td>
							<td width='28%' class='style12'>
                           	<select name="subtiporir415" id="subtiporir415" class="form-control" disabled/>
                                <?php
									$subresult = mysql_query("SELECT * FROM TAB_APOIO_TPSUBVISITRIR415 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
									while($subrow = mysql_fetch_array($subresult)){
										echo "<option ";
										if (strcasecmp($vetor_CLASSRIR415['CLASSRIR415_TIPO'], $subrow['ID']) == 0){
											echo 'selected="selected"';
										} 
                                        echo " value='".$subrow['ID']."'>".$subrow['DESCRICAO']."</option>";
									}
								?>
                            </select>
                            </td>
                            <td width='2%' class='style12'>
								<img src="imgs/if_system.png" name="btnPadraoRIR415" class="float" width="20" height="20" border="0" />
							</td>
                            <td width='30%'><textarea rows='4' class='form-control' name='CLASSRIR415_DESCRICAO'><?php echo $vetor_CLASSRIR415['CLASSRIR415_DESCRICAO']; ?></textarea></td>
                            <td width='10%' class='style12'></td>
                          </tr>
                        </table>                       
                        </div>
                    	</div>
                    </div>
                    </br>
                    <input name="salvar" type="image" src="imgs/salvar.png" class="float" onClick="habilitarSelect()" />
                </form>
			</div><!--.box-typical-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->
<?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>