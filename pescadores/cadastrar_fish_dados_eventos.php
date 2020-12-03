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
			$id_evento = $_GET['id_evento'];
			$id_familia = $_GET['id_familia'];
			
			$sql_EVENTO = mysql_query("SELECT * FROM TAB_FISH_EVENTOS WHERE FISH_EVE_CODIGO = '$id_evento';", $db);
			$vetor_EVENTO = mysql_fetch_array($sql_EVENTO);
			$sql_TPEVENTOS = mysql_query("SELECT * FROM TAB_APOIO_EVENTOS ORDER BY DESCRICAO ASC;", $db);			
			$sql_TPVISIT = mysql_query("SELECT * FROM TAB_APOIO_TPVISITFISH ORDER BY DESCRICAO ASC;", $db);
			$sql_TECNICOS = mysql_query("SELECT * FROM TAB_APOIO_TECNICOS ORDER BY DESCRICAO ASC", $db);
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
var qtdeCamposC = 0;
function addCamposC() {
var objPaiC = document.getElementById("campoPaiC");
//Criando o elemento DIV;
var objFilhoC = document.createElement("div");
//Definindo atributos ao objFilho:
objFilhoC.setAttribute("id","filhoC"+qtdeCamposC);
//Inserindo o elemento no pai:
objPaiC.appendChild(objFilhoC);
//Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filhoC"+qtdeCamposC).innerHTML = "<table width='100%' border='0'><tr><td width='80%' class='style12'><select name='FISH_TEC_TECNICO[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um Técnico...</option><?php while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) { ?><option value='<?php echo $vetor_TECNICOS[ID]; ?>'><?php echo $vetor_TECNICOS[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%' class='style12'></td><td width='18%' class='style12'><input type='button' onclick='removerCampoC("+qtdeCamposC+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposC++;
}
function removerCampoC(id) {
var objPaiC = document.getElementById("campoPaiC");
var objFilhoC = document.getElementById("filhoC"+id);
console.log(objPaiC);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPaiC.removeChild(objFilhoC);
}

var qtdeCamposD = 0;
function addCamposD() {
var objPaiD = document.getElementById("campoPaiD");
//Criando o elemento DIV;
var objFilhoD = document.createElement("div");
//Definindo atributos ao objFilho:
objFilhoD.setAttribute("id","filhoD"+qtdeCamposD);
//Inserindo o elemento no pai:
objPaiD.appendChild(objFilhoD);
//Escrevendo algo no filho recÃ©m-criado:
document.getElementById("filhoD"+qtdeCamposD).innerHTML = "<table width='100%' border='0'><tr><td width='40%' class='style12'><input type='text' name='FISH_IMG_LEGENDA[]' class='form-control'></td><td width='2%' class='style12'></td><td width='40%'><input type='file' name='FISH_IMG_NOME[]' class='form-control'></td><td width='2%' class='style12'></td><td width='16%' class='style12'><input type='button' onclick='removerCampoD("+qtdeCamposD+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCamposD++;
}
function removerCampoD(id) {
var objPaiD = document.getElementById("campoPaiD");
var objFilhoD = document.getElementById("filhoD"+id);
console.log(objPaiD);
//Removendo o DIV com id especÃ­fico do nÃ³-pai:
var removido = objPaiD.removeChild(objFilhoD);
}

$(document).ready(function(){
	$('#tipoFish').change(function(){
		$('#subtipoFish').load('buscaFish.php?id='+$('#tipoFish').val());
    })
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
								<li><a href="#">Dados do Evento - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_fish_alterar_eventos.php?id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="eventos" enctype="multipart/form-data" id="formEventos">
                    <div class="form-group row">
						<div class="col-lg-4">
                        	<label class="form-label semibold" for="FISH_EVE_DATA">Data do Evento:</label>
                            <input type="text" name="FISH_EVE_DATA" id="FISH_EVE_DATA" class="form-control" onKeyPress="mascara(this,mdata)" maxlength="10" placeholder="Digite a data..." value="<?php echo date('d/m/Y', strtotime($vetor_EVENTO['FISH_EVE_DATA'])); ?>">
                        </div>
                        <div class="col-lg-8">
                        	<label class="form-label semibold" for="FISH_EVE_TIPO">Tipo do Evento:</label>
                            <select name="FISH_EVE_TIPO" id="FISH_EVE_TIPO" class="form-control">
								<?php while ($vetor_TPEVENTOS=mysql_fetch_array($sql_TPEVENTOS)) { ?>
                                <option value="<?php echo $vetor_TPEVENTOS['ID']; ?>" <?php if (strcasecmp($vetor_EVENTO['FISH_EVE_TIPO'], $vetor_TPEVENTOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPEVENTOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Data do Evento / Tipo do Evento -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="FISH_EVE_OBSERVACOES">Observações/Breve Descrição:</label>
                            <input type="text" name="FISH_EVE_OBSERVACOES" id="FISH_EVE_OBSERVACOES" class="form-control" placeholder="Digite as observações..." value="<?php echo $vetor_EVENTO['FISH_EVE_OBSERVACOES']; ?>">
                         </div>	
                    </div> <!-- Observações -->
					</br>
                    <input name="updateEventos" type="image" src="imgs/salvar.png" class="float" />
				</form>
			</div><!--.box-typical-->
			<div class="box-typical box-typical-padding">
                <form action="recebe_fish_cadastrar_dados_eventos.php?id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="dadosEventos" enctype="multipart/form-data" id="dadosEventos">
                    <div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">Ações Realizadas</a></li>
                            <li><a href="#view2">Técnicos Responsáveis</a></li>
                            <li><a href="#view3">Registro Fotográfico</a></li>
                        </ul>

	                    <div class="tabcontents">
                    
                        <div id="view1">
                        <table width="100%">
                          <thead>
                            <td width="28%">Tipo de Atividade</td>
                            <td width="2%"></td>
                            <td width="28%">SubTipo de Atividade</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição</td>
                            <td width="10%"></td>
                          </thead>
                          <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                          <tr>
                          	<td width='28%' class='style12'>
                            <select name="tipoFish" id="tipoFish" class="form-control">
                            	<option value="">Escolha um tipo...</option>
                                <?php
									$result = mysql_query("SELECT * FROM TAB_APOIO_TPVISITFISH WHERE ATIVO = 1 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
									}
								?>
							</select>
                            </td>
                            <td width='2%' class='style12'></td>
							<td width='28%' class='style12'>
                            	<select name="subtipoFish" id="subtipoFish" class="form-control">
                                	<option value="0">Escolha um subtipo...</option>
                                </select>
                            </td>
                            <td width='2%' class='style12'>
                            	<img src="imgs/if_system.png" name="btnPadraoFish" class="float" width="20" height="20" border="0" />
                            </td>
                            <td width='30%'><textarea rows='4' class='form-control' name='CLASS_DESCRICAO'></textarea></td>
                            <td width='10%' class='style12'></td>
                          </tr>
                        </table>
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="28%">Tipo de Atividade</td>
                            <td width="2%"></td>
                            <td width="28%">SubTipo de Atividade</td>
                            <td width="2%"></td>
                            <td width="30%">Descrição</td>
                            <td width="2%"></td>
                            <td width="8%">Ações</td>
                          </thead>
                          <?php 
                                $sql_projeto = mysql_query("SELECT TAB_FISH_CLASSIFICACAO.FISH_CLASS_CODIGO, TAB_APOIO_TPVISITFISH.DESCRICAO AS TIPO, TAB_APOIO_TPSUBVISITFISH.DESCRICAO AS SUBTIPO, TAB_FISH_CLASSIFICACAO.FISH_CLASS_DESCRICAO FROM TAB_FISH_CLASSIFICACAO LEFT OUTER JOIN TAB_APOIO_TPSUBVISITFISH ON TAB_FISH_CLASSIFICACAO.FISH_CLASS_TIPO = TAB_APOIO_TPSUBVISITFISH.ID LEFT OUTER JOIN TAB_APOIO_TPVISITFISH ON TAB_APOIO_TPSUBVISITFISH.ID_PRINCIPAL = TAB_APOIO_TPVISITFISH.ID WHERE TAB_FISH_CLASSIFICACAO.FISH_EVE_CODIGO = '$id_evento';", $db);
								$cor = "#D8D8D8";
                                while ($vetor_projeto=mysql_fetch_array($sql_projeto)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                          ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="28%"><?php echo $vetor_projeto['TIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="28%"><?php echo $vetor_projeto['SUBTIPO']; ?></td>
                            <td width="2%"></td>
                            <td width="30%"><?php echo $vetor_projeto['FISH_CLASS_DESCRICAO']; ?></td>
                            <td width="2%"></td>
                            <td width="8%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_fish_evento_class.php?id=<?php echo $vetor_projeto['FISH_CLASS_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_evento_class.php?id=<?php echo $vetor_projeto['FISH_CLASS_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                        </div>

	                    <div id="view2">
                        <table width="100%">
                          <thead>
                            <td width="80%">Técnicos Responsáveis</td>
                            <td width="2%"></td>
                            <td width="18%">&nbsp;</td>
                          </thead>
                        </table>
                        <div id="campoPaiC"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                        <br/>
                        <input type="button" value="Adicionar" onClick="addCamposC()" class="btn btn-inline">
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="80%">Técnicos Responsáveis</td>
                            <td width="2%"></td>
                            <td width="18%">Ações</td>
                          </thead>
                            <?php
                                $sql_tecnicosev = mysql_query("SELECT TAB_FISH_TECNICOS.FISH_TEC_CODIGO, TAB_FISH_TECNICOS.FISH_EVE_CODIGO, TAB_FISH_TECNICOS.FISH_TEC_TECNICO, TAB_APOIO_TECNICOS.DESCRICAO AS FISH_TEC_TECNICO_DESC FROM TAB_FISH_TECNICOS LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_FISH_TECNICOS.FISH_TEC_TECNICO = TAB_APOIO_TECNICOS.ID WHERE TAB_FISH_TECNICOS.FISH_EVE_CODIGO = '$id_evento'", $db) or die(mysql_error());
								$cor = "#D8D8D8";
                                while ($vetor_tecnicosev=mysql_fetch_array($sql_tecnicosev)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                            ?>
                          <tr bgcolor="<?php echo $cor; ?>">
                            <td width="80%"><?php echo $vetor_tecnicosev['FISH_TEC_TECNICO_DESC']; ?></td>
                            <td width="2%"></td>
                            <td width="18%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_evento_tecnico.php?id=<?php echo $vetor_tecnicosev['FISH_TEC_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
	                    </div>
                    
                    	<div id="view3">
                        <table width="100%">
                          <thead>
                            <td width="40%">Legenda</td>
                            <td width="2%"></td>
                            <td width="40%">Imagem</td>
                            <td width="2%"></td>
                            <td width="16%">&nbsp;</td>
                          </thead>
                        </table>
                        <div id="campoPaiD"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                        <br/>
                        <input type="button" value="Adicionar" onClick="addCamposD()" class="btn btn-inline">
                        <br/>
                        <br/>
                        <table width="100%">
                          <thead>
                            <td width="40%">Legenda</td>
                            <td width="2%"></td>
                            <td width="40%">Imagem</td>
                            <td width="2%"></td>
                            <td width="16%">Ações</td>
                          </thead>
                           <?php 
                                $sql_imagem = mysql_query("SELECT * FROM TAB_FISH_IMAGENS WHERE FISH_EVE_CODIGO = '$id_evento'", $db);
								$cor = "#D8D8D8";
                                while ($vetor_imagem=mysql_fetch_array($sql_imagem)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                            ?>
                            <tr bgcolor="<?php echo $cor; ?>">
                                <td width="40%"><?php echo $vetor_imagem['FISH_IMG_LEGENDA']; ?></td>
                                <td width="2%"></td>
                                <td width="40%" align="center" valign="middle"><img src="imagens/<?php echo $vetor_imagem['FISH_IMG_NOME']; ?>" width="150"></td>
                                <td width="2%"></td>
                                <td width="16%" align="center" valign="middle"><a class="fancybox fancybox.ajax" href="alterar_fish_evento_imagem.php?id=<?php echo $vetor_imagem['FISH_IMG_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="recebe_fish_excluir_evento_imagem.php?id=<?php echo $vetor_imagem['FISH_IMG_CODIGO']; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                          </tr>
                          <?php } ?>
                        </table>
                    	</div>
                    
                    	</div>

                    </div>
                    </br>
                    <input name="salvar" type="image" src="imgs/salvar.png" class="float" />
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