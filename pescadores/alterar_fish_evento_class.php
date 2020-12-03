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
			$id = $_GET['id'];
			$id_evento = $_GET['id_evento'];
			$id_familia = $_GET['id_familia'];
			$sql_EVENTO = mysql_query("SELECT * FROM TAB_FISH_EVENTOS WHERE FISH_EVE_CODIGO = '$id_evento';", $db);
			$vetor_EVENTO = mysql_fetch_array($sql_EVENTO);
			$sql_TPEVENTOS = mysql_query("select * from TAB_APOIO_EVENTOS order by DESCRICAO ASC", $db);			
			$sql_TPVISITFISH = mysql_query("SELECT * FROM TAB_APOIO_TPVISIT415 ORDER BY DESCRICAO ASC", $db);
			$sql_TECNICOS = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC", $db);

			$sql_CLASS = mysql_query("select * from TAB_FISH_CLASSIFICACAO WHERE FISH_CLASS_CODIGO = '$id' and FISH_EVE_CODIGO = '$id_evento';", $db);
			$vetor_CLASS = mysql_fetch_array($sql_CLASS);
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
	$("#tipoFish").prop("disabled", false);
	$("#subtipoFish").prop("disabled", false);
}

$(document).ready(function(){
	var cat = $('#tipoFish').val();
	var subcat = $('#subtipoFish').val();
	
	$('#tipoFish').change(function(){
		$('#subtipoFish').load('buscaFish.php?id='+$('#tipoFish').val());
	});

	$("#enable").click(function (){
		$("#tipoFish").prop("disabled", false);
		$("#subtipoFish").prop("disabled", false);
		$('#subtipoFish').load('buscaFish.php?id='+$('#tipoFish').val());
	});

    $("#disable").click(function (){
		if ($('#subtipoFish').val() == 0) {
			alert("SubTipo da Atividade é Inválido");
		} else {
			$("#tipoFish").prop("disabled", true);
			$("#subtipoFish").prop("disabled", true);
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
							<h3>Familias - Projetos de Atendimento dos Pescadores</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Dados de Atividade - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="#" method="post" name="eventos" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
						<div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_EVE_DATA">Data do Evento:</label>
                            <input type="text" name="FISH_EVE_DATA" class="form-control" id="FISH_EVE_DATA" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_EVENTO['FISH_EVE_DATA'])); ?>">
                        </div>
                        <div class="col-lg-8">
                        	<label class="form-label semibold" for="exampleInputEmail1">Tipo do Evento:</label>
                            <select name="FISH_EVE_TIPO" id="FISH_EVE_TIPO" class="form-control">
								<?php while ($vetor_TPEVENTOS=mysql_fetch_array($sql_TPEVENTOS)) { ?>
                                <option label="<?php echo $vetor_TPEVENTOS['DESCRICAO']; ?>" value="<?php echo $vetor_TPEVENTOS['ID']; ?>" <?php if (strcasecmp($vetor_EVENTO['FISH_EVE_TIPO'], $vetor_TPEVENTOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPEVENTOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Data do Evento / Tipo do Evento -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="FISH_EVE_OBSERVACOES">Observações:</label>
                            <input type="text" name="FISH_EVE_OBSERVACOES" class="form-control" id="FISH_EVE_OBSERVACOES" placeholder="Digite observações..." value="<?php echo $vetor_EVENTO['FISH_EVE_OBSERVACOES']; ?>">
                         </div>	
                    </div> <!-- Observações -->
				</form>
			</div><!--.box-typical-->
            <button type="button" class="btn btn-success" href="#" id="enable">Habilita Edição</button>
            <button type="button" class="btn btn-warning" href="#" id="disable">Desabilita Edição</button><br/><br/>
			<div class="box-typical box-typical-padding">
            	<form action="recebe_fish_alterar_evento_class.php?id=<?php echo $id; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="class" enctype="multipart/form-data" id="formID">
                    <div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">Ações</a></li>
                        </ul>

	                    <div class="tabcontents">
                    
                        <div id="view1">
                        <table width="100%">
                          <thead>
                            <td width="28%">Tipo de Visita</td>
                            <td width="2%"></td>
                            <td width="28%">SubTipo de Visita</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição da Atividade</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
						  <tr>
                          	<td width='28%' class='style12'>
                            <select name="tipoFish" id="tipoFish" class="form-control" disabled/>
                                <?php
									$subvisitFish = $vetor_CLASS['FISH_CLASS_TIPO'];
									$result01 = mysql_query("select ID_PRINCIPAL from TAB_APOIO_TPSUBVISITFISH where ID = '$subvisitFish';", $db);
									$row01 = mysql_fetch_array($result01);
									$result02 = mysql_query("select * from TAB_APOIO_TPVISITFISH order by DESCRICAO ASC;", $db) or die(mysql_error());
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
                           	<select name="subtipoFish" id="subtipoFish" class="form-control" disabled/>
                                <?php
									$subresult = mysql_query("select * from TAB_APOIO_TPSUBVISITFISH order by DESCRICAO ASC;", $db) or die(mysql_error());
									while($subrow = mysql_fetch_array($subresult)){
										echo "<option ";
										if (strcasecmp($vetor_CLASS['FISH_CLASS_TIPO'], $subrow['ID']) == 0){
											echo 'selected="selected"';
										} 
                                        echo " value='".$subrow['ID']."'>".$subrow['DESCRICAO']."</option>";
									}
								?>
                            </select>
                            </td>
                            <td width='2%' class='style12'></td>
                            <td width='30%'><textarea rows='4' class='form-control' name='FISH_CLASS_DESCRICAO'><?php echo $vetor_CLASS['FISH_CLASS_DESCRICAO']; ?></textarea></td>
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