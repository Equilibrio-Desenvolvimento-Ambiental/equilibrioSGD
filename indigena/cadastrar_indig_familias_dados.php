<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 8;
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
			$idPessoa = $_GET['idPessoa'];

			$sql_INDIG_FAMILIAS = mysql_query("SELECT TAB_INDIG_FAMILIAS.INDIG_FAM_ID, TAB_INDIG_FAMILIAS.INDIG_FAM_NOME, TAB_APOIO_INDIG_ALDEIA.DESCRICAO AS INDIG_FAM_ALDEIA, TAB_APOIO_INDIG_TI.DESCRICAO AS INDIG_FAM_TI FROM TAB_INDIG_FAMILIAS LEFT OUTER JOIN TAB_APOIO_INDIG_ALDEIA ON TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA = TAB_APOIO_INDIG_ALDEIA.ID LEFT OUTER JOIN TAB_INDIG_REL_TI_ALDEIA ON TAB_INDIG_REL_TI_ALDEIA.ALDEIA_ID = TAB_APOIO_INDIG_ALDEIA.ID LEFT OUTER JOIN TAB_APOIO_INDIG_TI ON TAB_INDIG_REL_TI_ALDEIA.TI_ID = TAB_APOIO_INDIG_TI.ID WHERE TAB_INDIG_FAMILIAS.INDIG_FAM_ID = '$idPessoa';", $db) or die(mysql_error());
			$vetor_INDIG_FAMILIAS = mysql_fetch_array($sql_INDIG_FAMILIAS);
			
			$sql_INDIG_FAMILIAS_DADOS = mysql_query("SELECT TAB_INDIG_FAMILIAS_DADOS.INDIG_FAMDAD_ID, TAB_INDIG_FAMILIAS_DADOS.INDIG_FAMDAD_PESSOA, TAB_INDIG_FAMILIAS_DADOS.INDIG_FAMDAD_PES_IDADE, TAB_INDIG_FAMILIAS_DADOS.INDIG_FAMDAD_PES_DATANASC, TAB_INDIG_FAMILIAS_DADOS.INDIG_FAMDAD_PES_APELIDO, TAB_INDIG_FAMILIAS_DADOS.INDIG_FAMDAD_PROJ_PESCACOMERC, TAB_APOIO_BOOLEANO.DESCRICAO AS INDIG_FAMDAD_PROJ_PESCACOMERC_DESC FROM TAB_INDIG_FAMILIAS_DADOS LEFT OUTER JOIN TAB_APOIO_BOOLEANO ON TAB_INDIG_FAMILIAS_DADOS.INDIG_FAMDAD_PROJ_PESCACOMERC = TAB_APOIO_BOOLEANO.ID WHERE TAB_INDIG_FAMILIAS_DADOS.INDIG_FAMDAD_PESSOA = '$idPessoa';", $db) or die(mysql_error());
			$num_INDIG_FAMILIAS_DADOS = mysql_num_rows($sql_INDIG_FAMILIAS_DADOS);
			$vetor_INDIG_FAMILIAS_DADOS = mysql_fetch_array($sql_INDIG_FAMILIAS_DADOS);

			$sql_BOOLEANO_PESCACOMERC = mysql_query("SELECT * FROM TAB_APOIO_BOOLEANO ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());

			$sql_INDIG_FAMILIAS_PESCACOMERC = mysql_query("SELECT TAB_INDIG_FAMILIAS_PESCACOMERC.INDIG_FAMPPC_ID, TAB_INDIG_FAMILIAS_PESCACOMERC.INDIG_FAMPPC_PESSOA, TAB_INDIG_FAMILIAS_PESCACOMERC.INDIG_FAMPPC_DATAREG, TAB_APOIO_BOOLEANO_STATUS.DESCRICAO AS INDIG_FAMPPC_STATUS_DESC, TAB_APOIO_GRAUSATISFACAO.DESCRICAO AS INDIG_FAMPPC_SATISFACAO_DESC, TAB_APOIO_FORMACOMERC.DESCRICAO AS INDIG_FAMPPC_COMERCIO_DESC, TAB_INDIG_FAMILIAS_PESCACOMERC.INDIG_FAMPPC_TERCEIRO, TAB_APOIO_BOOLEANO_PPARTESANAL.DESCRICAO AS INDIG_FAMPPC_PPARTESANAL_DESC FROM TAB_INDIG_FAMILIAS_PESCACOMERC LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_STATUS ON TAB_APOIO_BOOLEANO_STATUS.ID = TAB_INDIG_FAMILIAS_PESCACOMERC.INDIG_FAMPPC_STATUS LEFT OUTER JOIN TAB_APOIO_GRAUSATISFACAO ON TAB_APOIO_GRAUSATISFACAO.ID = TAB_INDIG_FAMILIAS_PESCACOMERC.INDIG_FAMPPC_SATISFACAO LEFT OUTER JOIN TAB_APOIO_FORMACOMERC ON TAB_APOIO_FORMACOMERC.ID = TAB_INDIG_FAMILIAS_PESCACOMERC.INDIG_FAMPPC_COMERCIO LEFT OUTER JOIN TAB_APOIO_BOOLEANO AS TAB_APOIO_BOOLEANO_PPARTESANAL ON TAB_APOIO_BOOLEANO_PPARTESANAL.ID = TAB_INDIG_FAMILIAS_PESCACOMERC.INDIG_FAMPPC_PPARTESANAL WHERE TAB_INDIG_FAMILIAS_PESCACOMERC.INDIG_FAMPPC_PESSOA = '$idPessoa' ORDER BY TAB_INDIG_FAMILIAS_PESCACOMERC.INDIG_FAMPPC_DATAREG DESC;", $db) or die(mysql_error());
			$num_INDIG_FAMILIAS_PESCACOMERC = mysql_num_rows($sql_INDIG_FAMILIAS_PESCACOMERC);
//			$vetor_INDIG_FAMILIAS_PESCACOMERC = mysql_fetch_array($sql_INDIG_FAMILIAS_PESCACOMERC);
			
			$sql_BOOLEANO_PPARTESANAL = mysql_query("SELECT * FROM TAB_APOIO_BOOLEANO WHERE ID > 0 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_GRAUSATISFACAO = mysql_query("SELECT * FROM TAB_APOIO_GRAUSATISFACAO WHERE ID > 0 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
			$sql_FORMACOMERC = mysql_query("SELECT * FROM TAB_APOIO_FORMACOMERC WHERE ID > 0 ORDER BY DESCRICAO ASC;", $db) or die(mysql_error());
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
function mdata(v){  
    v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito  
    v=v.replace(/(\d{2})(\d)/,"$1/$2");  
    v=v.replace(/(\d{2})(\d)/,"$1/$2");  
    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");  
    return v;  
}  
function mvalor(v){
	v=v.replace(/\D/g,"");//Remove tudo o que não é dígito  
	v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões  
	v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares
	v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos  
	return v;  
}  
function minteiro(v){
	v=v.replace(/\D/g,"");//Remove tudo o que não é dígito  
	return v;  
}  
function id(el){
	return document.getElementById( el );
}
window.onload = function(){  
    id('telefone').onkeypress = function(){  
        mascara( this, mtel);  
    }
    id('telefone2').onkeypress = function(){  
        mascara( this, mtel);  
    }
}
</script>
<script src="jquery-1.3.2.min.js" type="text/javascript"></script>

<body>
<?php require_once("includes/site-header.php");?>
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Projetos de Atividades Produtivas - PAP / Projeto de Pesca Para Comercialização</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Dados dO Componente Familiar Indígena - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_indig_alterar_familias_dados.php?idPessoa=<?php echo $idPessoa; ?>" method="post" name="familias_dados" enctype="multipart/form-data" id="familias_dados">
                    <div class="form-group row">
                        <div class="col-lg-3"><strong>Terra Indígena: </strong><?php echo $vetor_INDIG_FAMILIAS['INDIG_FAM_TI']; ?>
                        </div>
                        <div class="col-lg-3"><strong>Aldeia: </strong><?php echo $vetor_INDIG_FAMILIAS['INDIG_FAM_ALDEIA']; ?>
                        </div>
                        <div class="col-lg-6"><strong>Nome do Componente: </strong><?php echo $vetor_INDIG_FAMILIAS['INDIG_FAM_NOME']; ?>
                        </div>
                    </div> <!-- Dados Básicos -->
					<?php if ($num_INDIG_FAMILIAS_DADOS > 0) { ?>
						<div class="form-group row">
							<div class="col-lg-3">
								<label class="form-label semibold" for="INDIG_FAMDAD_PES_IDADE">Idade:</label>
								<input type="text" name="INDIG_FAMDAD_PES_IDADE" class="form-control" id="INDIG_FAMDAD_PES_IDADE" placeholder="Digite a idade..." onKeyPress="mascara(this,minteiro)" maxlength="3" value="<?php echo $vetor_INDIG_FAMILIAS_DADOS['INDIG_FAMDAD_PES_IDADE']; ?>">
							</div>
							<div class="col-lg-3">
								<label class="form-label semibold" for="INDIG_FAMDAD_PES_DATANASC">Data de Nascimento:</label>
								<input type="text" name="INDIG_FAMDAD_PES_DATANASC" class="form-control" id="INDIG_FAMDAD_PES_DATANASC" placeholder="Data de nascimento..." onKeyPress="mascara(this,mdata)" maxlength="10" <?php if(!empty($vetor_INDIG_FAMILIAS_DADOS['INDIG_FAMDAD_PES_DATANASC'])) { echo 'value="'.date('d/m/Y', strtotime($vetor_INDIG_FAMILIAS_DADOS['INDIG_FAMDAD_PES_DATANASC'])).'"'; } ?>>
							</div>
							<div class="col-lg-3">
								<label class="form-label semibold" for="INDIG_FAMDAD_PES_APELIDO">Apelido:</label>
								<input type="text" name="INDIG_FAMDAD_PES_APELIDO" class="form-control" id="INDIG_FAMDAD_PES_APELIDO" placeholder="Digite o apelido..." value="<?php echo $vetor_INDIG_FAMILIAS_DADOS['INDIG_FAMDAD_PES_APELIDO']; ?>">
							</div>
						</div> <!-- Dados Pessoais -->
						<div class="form-group row">
							<div class="col-lg-3">
								<label class="form-label semibold" for="INDIG_FAMDAD_PROJ_PESCACOMERC">Projeto de Pesca para Comerc.?</label>
								<select name="INDIG_FAMDAD_PROJ_PESCACOMERC" id="INDIG_FAMDAD_PROJ_PESCACOMERC" class="form-control">
									<option label="NI" value="0" <?php if (strcasecmp($vetor_INDIG_FAMILIAS_DADOS['INDIG_FAMDAD_PROJ_PESCACOMERC'], '0') == 0) : ?>selected="selected"<?php endif; ?>>N/I (NÃO INFORMADO)</option>
									<option label="SIM" value="1" <?php if (strcasecmp($vetor_INDIG_FAMILIAS_DADOS['INDIG_FAMDAD_PROJ_PESCACOMERC'], '1') == 0) : ?>selected="selected"<?php endif; ?>>SIM</option>
									<option label="NAO" value="2" <?php if (strcasecmp($vetor_INDIG_FAMILIAS_DADOS['INDIG_FAMDAD_PROJ_PESCACOMERC'], '2') == 0) : ?>selected="selected"<?php endif; ?>>NÃO</option>
								</select>
							</div>
						</div> <!-- Sim/Não, Projetos -->
					<?php } else { ?>
						<div class="form-group row">
							<div class="col-lg-3">
								<label class="form-label semibold" for="INDIG_FAMDAD_PES_IDADE">Idade:</label>
								<input type="text" name="INDIG_FAMDAD_PES_IDADE" class="form-control" id="INDIG_FAMDAD_PES_IDADE" placeholder="Digite a idade..." onKeyPress="mascara(this,minteiro)" maxlength="3" value="0">
							</div>
							<div class="col-lg-3">
								<label class="form-label semibold" for="INDIG_FAMDAD_PES_DATANASC">Data de Nascimento:</label>
								<input type="text" name="INDIG_FAMDAD_PES_DATANASC" class="form-control" id="INDIG_FAMDAD_PES_DATANASC" placeholder="Data de nascimento..." onKeyPress="mascara(this,mdata)" maxlength="10" value="">
							</div>
							<div class="col-lg-3">
								<label class="form-label semibold" for="INDIG_FAMDAD_PES_APELIDO">Apelido:</label>
								<input type="text" name="INDIG_FAMDAD_PES_APELIDO" class="form-control" id="INDIG_FAMDAD_PES_APELIDO" placeholder="Digite o apelido..." value="">
							</div>
						</div> <!-- Dados Pessoais -->
						<div class="form-group row">
							<div class="col-lg-3">
								<label class="form-label semibold" for="INDIG_FAMDAD_PROJ_PESCACOMERC">Projeto de Pesca para Comerc.?</label>
								<select name="INDIG_FAMDAD_PROJ_PESCACOMERC" id="INDIG_FAMDAD_PROJ_PESCACOMERC" class="form-control">
									<option label="NI" value="0" selected="selected">N/I (NÃO INFORMADO)</option>
									<option label="SIM" value="1">SIM</option>
									<option label="NAO" value="2">NÃO</option>
								</select>
							</div>
						</div> <!-- Sim/Não, Projetos -->
					<?php } ?>
                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
				</form>
			</div><!--.box-typical-->
			
			<div class="box-typical box-typical-padding">
				<div style="width: 100%; margin: 0 auto;">
					<ul class="tabs" data-persist="true">
						<li><a href="#view1">Doc. Pessoais</a></li>
						<?php 
							if((strcasecmp($vetor_INDIG_FAMILIAS_DADOS['INDIG_FAMDAD_PROJ_PESCACOMERC'], '1')==0)) { ?> <li><a href="#view2">Proj. Pesca p/ Comerc.</a></li>
						<?php } ?>
					</ul>

					<div class="tabcontents">
						<div id="view1">&nbsp;</div>
						<?php
							if((strcasecmp($vetor_INDIG_FAMILIAS_DADOS['INDIG_FAMDAD_PROJ_PESCACOMERC'], '1')==0)) { ?>
							<div id="view2">
								<form action="recebe_indig_cadastrar_familias_proj_pescacomerc.php?idPessoa=<?php echo $idPessoa; ?>" method="post" name="familias_proj_pescacomerc" enctype="multipart/form-data" id="familias_proj_pescacomerc">
									<div class="form-group row">
										<div class="col-lg-3">
											<label class="form-label semibold" for="INDIG_FAMPPC_DATAREG">Data do Registro:</label>
											<input type="text" name="INDIG_FAMPPC_DATAREG" class="form-control" id="INDIG_FAMPPC_DATAREG" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="">
										</div>
                                        <div class="col-lg-3">
                                            <label class="form-label semibold">Grau de Satisfação:</label>
											<select name="INDIG_FAMPPC_SATISFACAO" id="INDIG_FAMPPC_SATISFACAO" class="form-control">
											  <option value="0" selected="selected">Selecione a opção...</option>
											  <?php while ($vetor_GRAUSATISFACAO=mysql_fetch_array($sql_GRAUSATISFACAO)) { ?>
											  <option value="<?php echo $vetor_GRAUSATISFACAO['ID'] ?>"><?php echo $vetor_GRAUSATISFACAO['DESCRICAO']; ?></option>
											  <?php } ?>
											</select>
                                        </div>
									</div> <!-- Linha 01 -->
									<div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="form-label semibold">Tipo de Comercialização:</label>
											<select name="INDIG_FAMPPC_COMERCIO" id="INDIG_FAMPPC_COMERCIO" class="form-control">
											  <option value="0" selected="selected">Selecione a opção...</option>
											  <?php while ($vetor_FORMACOMERC=mysql_fetch_array($sql_FORMACOMERC)) { ?>
											  <option value="<?php echo $vetor_FORMACOMERC['ID'] ?>"><?php echo $vetor_FORMACOMERC['DESCRICAO']; ?></option>
											  <?php } ?>
											</select>
                                        </div>
										<div class="col-lg-3">
											<label class="form-label semibold" for="INDIG_FAMPPC_TERCEIRO">Nome do Terceiro:</label>
											<input type="text" name="INDIG_FAMPPC_TERCEIRO" class="form-control" id="INDIG_FAMPPC_TERCEIRO" placeholder="Digite o nome..." value="">
										</div>
                                        <div class="col-lg-6">
                                            <label class="form-label semibold" for="INDIG_FAMPPC_PPARTESANAL">Interesse Pescador Profissional Artesanal?</label>
											<select name="INDIG_FAMPPC_PPARTESANAL" id="INDIG_FAMPPC_PPARTESANAL" class="form-control">
											  <option value="0" selected="selected">Selecione a opção...</option>
											  <?php while ($vetor_BOOLEANO_PPARTESANAL=mysql_fetch_array($sql_BOOLEANO_PPARTESANAL)) { ?>
											  <option value="<?php echo $vetor_BOOLEANO_PPARTESANAL['ID'] ?>"><?php echo $vetor_BOOLEANO_PPARTESANAL['DESCRICAO']; ?></option>
											  <?php } ?>
											</select>
                                        </div>
									</div> <!-- Linha 02 -->    
									<input name="pesq" type="image" src="imgs/salvar.png" class="float" />
								</form>
								</br></br>
								<table width="100%">
									<thead>
										<td width="8%">Data do Registro</td>
										<td width="2%"></td>
										<td width="18%">Grau de Satisfação</td>
										<td width="2%"></td>
										<td width="18%">Comercialização</td>
										<td width="2%"></td>
										<td width="18%">Nome do Terceiro</td>
										<td width="2%"></td>
										<td width="18%">Interesse PPA?</td>
										<td width="2%"></td>
										<td width="10%">Ações</td>
									</thead>
									<?php 
										$cor = "#D8D8D8";
										while ($vetor_INDIG_FAMILIAS_PESCACOMERC = mysql_fetch_array($sql_INDIG_FAMILIAS_PESCACOMERC)) {
											if (strcasecmp($cor, "#FFFFFF") == 0){
												$cor = "#D8D8D8";
												} else {
												$cor = "#FFFFFF";
											}
									?>
									<tr bgcolor="<?php echo $cor; ?>">
										<td width="8%"><?php echo date('d/m/Y', strtotime($vetor_INDIG_FAMILIAS_PESCACOMERC['INDIG_FAMPPC_DATAREG'])); ?></td>
										<td width="2%"></td>
										<td width="18%"><?php echo $vetor_INDIG_FAMILIAS_PESCACOMERC['INDIG_FAMPPC_SATISFACAO_DESC'];?></td>
										<td width="2%"></td>
										<td width="18%"><?php echo $vetor_INDIG_FAMILIAS_PESCACOMERC['INDIG_FAMPPC_COMERCIO_DESC'];?></td>
										<td width="2%"></td>
										<td width="18%"><?php echo $vetor_INDIG_FAMILIAS_PESCACOMERC['INDIG_FAMPPC_TERCEIRO'];?></td>
										<td width="2%"></td>
										<td width="18%"><?php echo $vetor_INDIG_FAMILIAS_PESCACOMERC['INDIG_FAMPPC_PPARTESANAL_DESC'];?></td>
										<td width="2%"></td>
										<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_familias_proj_pescacomerc.php?idRegistro=<?php echo $vetor_INDIG_FAMILIAS_PESCACOMERC['INDIG_FAMPPC_ID']; ?>&idPessoa=<?php echo $idPessoa; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
									</tr>
									<?php } ?>
								</table>
							</div> <!-- Situação Gerais -->
						<?php } ?>
					</div>
                </div>
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