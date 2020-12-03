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
			$id_compfam = $_GET['id_compfam'];
			$id_familia = $_GET['id_familia'];
			
			$sql_COMPFAM = mysql_query("select * from TAB_415421_COMPFAMILIAR where COMPFAM_CODIGO = '$id_compfam';", $db);
			$vetor_COMPFAM = mysql_fetch_array($sql_COMPFAM);

			$sql_DADOS = mysql_query("select * from TAB_415421_CF_DADOS where COMPFAM_CODIGO = '$id_compfam';", $db);
			$vetor_DADOS = mysql_fetch_array($sql_DADOS);
			$sql_DOC = mysql_query("select * from TAB_415421_CF_DOC where COMPFAM_CODIGO = '$id_compfam';", $db);
			$vetor_DOC = mysql_fetch_array($sql_DOC);
			$sql_TRABALHO = mysql_query("select * from TAB_415421_CF_TRABALHO where COMPFAM_CODIGO = '$id_compfam';", $db);
			$vetor_TRABALHO = mysql_fetch_array($sql_TRABALHO);

			$sql_UF_NAT = mysql_query("select * from TAB_APOIO_UF order by DESCRICAO ASC", $db);			
			$sql_UF_RG = mysql_query("select * from TAB_APOIO_UF order by DESCRICAO ASC", $db);			
			$sql_OCUPACOES = mysql_query("select * from TAB_APOIO_OCUPACAO order by DESCRICAO ASC", $db);
			$sql_PARENTESCOS = mysql_query("select * from TAB_APOIO_PARENTESCO order by DESCRICAO ASC;", $db);			
			$sql_BOOLEANOS = mysql_query("select * from TAB_APOIO_BOOLEANO order by DESCRICAO ASC;", $db);			
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
<body>
<?php require_once("includes/site-header.php");?>
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Gestão do Projetos 4.1.5 e 4.2.1 - Reparação Rural e ATES</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Dados do Componente Familiar</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_alterar_compfam.php?id_compfam=<?php echo $id_compfam; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="compfamiliar" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInputEmail1">Nome:</label>
                            <input type="text" name="COMPFAM_NOME" class="form-control" id="exampleInput" placeholder="Digite o nome do componente..." value="<?php echo $vetor_COMPFAM['COMPFAM_NOME']; ?>">
                         </div>
                    </div> <!-- Nome -->
                    <div class="form-group row">
                        <div class="col-lg-8">
                        	<label class="form-label semibold" for="exampleInputEmail1">Grau de Parentesco:</label>
                            <select name="COMPFAM_PARENTESCO" id="exampleSelect" class="form-control">
								<?php while ($vetor_PARENTESCOS=mysql_fetch_array($sql_PARENTESCOS)) { ?>
                                <option label="<?php echo $vetor_PARENTESCOS['DESCRICAO']; ?>" value="<?php echo $vetor_PARENTESCOS['ID']; ?>" <?php if (strcasecmp($vetor_COMPFAM['COMPFAM_PARENTESCO'], $vetor_PARENTESCOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_PARENTESCOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
						<div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Residente?</label>
                            <select name="COMPFAM_RESIDENTE" id="exampleSelect" class="form-control">
								<?php while ($vetor_BOOLEANOS=mysql_fetch_array($sql_BOOLEANOS)) { ?>
                                <option label="<?php echo $vetor_BOOLEANOS['DESCRICAO']; ?>" value="<?php echo $vetor_BOOLEANOS['ID']; ?>" <?php if (strcasecmp($vetor_COMPFAM['COMPFAM_RESIDENTE'], $vetor_BOOLEANOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_BOOLEANOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Grau de Parentesco / Residente -->
                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
				</form>
			</div><!--.box-typical-->
			<div class="box-typical box-typical-padding">
                <div style="width: 100%; margin: 0 auto;">
                    <ul class="tabs" data-persist="true">
                        <li><a href="#view1">Dados Pessoais</a></li>
                        <li><a href="#view2">Documentação</a></li>
                        <li><a href="#view3">Trabalho/Renda</a></li>
                    </ul>

 		            <div class="tabcontents">

                    <div id="view1">
                    	<form action="recebe_alterar_cf_dados.php?id_compfam=<?php echo $id_compfam; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="dados" enctype="multipart/form-data" id="formID">
                        	<div class="form-group row">
                                <div class="col-lg-4">
                                    <label class="form-label semibold" for="exampleInput">Idade:</label>
                                    <input type="text" name="CFDADOS_IDADE" class="form-control" id="exampleInput" placeholder="Digite a idade..." value="<?php echo $vetor_DADOS['CFDADOS_IDADE']; ?>">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label semibold" for="exampleInput">Data de Nascimento:</label>
                                    <input type="text" name="CFDADOS_DATANASC" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_DADOS['CFDADOS_DATANASC'])); ?>">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label semibold" for="exampleInput">Apelido:</label>
                                    <input type="text" name="CFDADOS_APELIDO" class="form-control" id="exampleInput" placeholder="Digite o apelido..." value="<?php echo $vetor_DADOS['CFDADOS_APELIDO']; ?>">
                                </div>
                            </div> <!-- Idade / Data de Nascimento / Apelido -->
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label class="form-label semibold" for="exampleInputEmail1">Naturalidade:</label>
                                    <input type="text" name="CFDADOS_NATURALIDADE" class="form-control" id="exampleInput" placeholder="Digite a naturalidade..." value="<?php echo $vetor_DADOS['CFDADOS_NATURALIDADE']; ?>">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label semibold" for="exampleInputEmail1">Naturalidade/U.F.:</label>
                                    <select name="CFDADOS_NATURALIDADE_UF" id="exampleSelect" class="form-control">
										<?php while ($vetor_UF_NAT=mysql_fetch_array($sql_UF_NAT)) { ?>
                                        <option label="<?php echo $vetor_UF_NAT['DESCRICAO']; ?>" value="<?php echo $vetor_UF_NAT['ID']; ?>" <?php if (strcasecmp($vetor_DADOS['CFDADOS_NATURALIDADE_UF'], $vetor_UF_NAT['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_UF_NAT['DESCRICAO']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label semibold" for="exampleInputEmail1">Nacionalidade:</label>
                                    <input type="text" name="CFDADOS_NACIONALIDADE" class="form-control" id="exampleInput" placeholder="Digite a nacionalidade..." value="<?php echo $vetor_DADOS['CFDADOS_NACIONALIDADE']; ?>">
                                </div>
                            </div> <!-- Naturalidade / Nacionalidade -->
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="form-label semibold" for="exampleInputEmail1">Nome do Pai:</label>
                                    <input type="text" name="CFDADOS_NOMEPAI" class="form-control" id="exampleInput" placeholder="Digite o nome do pai..." value="<?php echo $vetor_DADOS['CFDADOS_NOMEPAI']; ?>">
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label semibold" for="exampleInputEmail1">Nome da Mãe:</label>
                                    <input type="text" name="CFDADOS_NOMEMAE" class="form-control" id="exampleInput" placeholder="Digite o nome da mae..." value="<?php echo $vetor_DADOS['CFDADOS_NOMEMAE']; ?>">
                                </div>
                            </div> <!-- Nome do Pai / Nome da Mãe -->
                            </br>
                            <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
                        </form>
                    </div> <!-- Dados Gerais -->
                    
                    <div id="view2">
                    	<form action="recebe_alterar_cf_doc.php?id_compfam=<?php echo $id_compfam; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="dados" enctype="multipart/form-data" id="formID">
                        	<div class="form-group row">
                                <div class="col-lg-6">
                                    <label class="form-label semibold" for="exampleInput">C.P.F.:</label>
                                    <input type="text" name="CFDOC_CPF" class="form-control" id="exampleInput" placeholder="Digite o C.P.F...." value="<?php echo $vetor_DOC['CFDOC_CPF']; ?>">
                                </div>
                            </div> <!-- C.P.F. -->
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label class="form-label semibold" for="exampleInputEmail1">R.G.:</label>
                                    <input type="text" name="CFDOC_RG" class="form-control" id="exampleInput" placeholder="Digite o R.G...." value="<?php echo $vetor_DOC['CFDOC_RG']; ?>">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label semibold" for="exampleInputEmail1">Complemento:</label>
                                    <input type="text" name="CFDOC_RG_COMPL" class="form-control" id="exampleInput" placeholder="Digite o complemento do R.G...." value="<?php echo $vetor_DOC['CFDOC_RG_COMPL']; ?>">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label semibold" for="exampleInputEmail1">Órgão Expedidor:</label>
                                    <input type="text" name="CFDOC_RG_ORGAO" class="form-control" id="exampleInput" placeholder="Digite o órgão expedidor do R.G...." value="<?php echo $vetor_DOC['CFDOC_RG_ORGAO']; ?>">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label semibold" for="exampleInputEmail1">U.F.:</label>
                                    <select name="CFDOC_RG_UF" id="exampleSelect" class="form-control">
										<?php while ($vetor_UF_RG=mysql_fetch_array($sql_UF_RG)) { ?>
                                        <option label="<?php echo $vetor_UF_RG['DESCRICAO']; ?>" value="<?php echo $vetor_UF_RG['ID']; ?>" <?php if (strcasecmp($vetor_DOC['CFDOC_RG_UF'], $vetor_UF_RG['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_UF_RG['DESCRICAO']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div> <!-- R.G. -->
                            </br>
                            <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
                        </form>
                    </div>
                    
	              	<div id="view3">
                    	<form action="recebe_alterar_cf_trabalho.php?id_compfam=<?php echo $id_compfam; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="trabalho" enctype="multipart/form-data" id="formID">
                            <div class="form-group row">
                                <div class="col-lg-8">
                                    <label class="form-label semibold" for="exampleInputEmail1">Ocupação Principal:</label>
                                    <select name="CFTRAB_OCUPACAO" id="exampleSelect" class="form-control">
										<?php while ($vetor_OCUPACOES=mysql_fetch_array($sql_OCUPACOES)) { ?>
                                        <option label="<?php echo $vetor_OCUPACOES['DESCRICAO']; ?>" value="<?php echo $vetor_OCUPACOES['ID']; ?>" <?php if (strcasecmp($vetor_TRABALHO['CFTRAB_OCUPACAO'], $vetor_OCUPACOES['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_OCUPACOES['DESCRICAO']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label semibold" for="exampleInput">Salário atual (R$):</label>
                                    <input type="text" name="CFTRAB_RENDA" class="form-control" id="exampleInput" placeholder="Digite o valor..." onKeyPress="mascara(this,mvalor)" value="<?php echo $vetor_TRABALHO['CFTRAB_RENDA']; ?>">
                                </div>
                            </div> <!-- R.G. -->
                            </br>
                            <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
                        </form>
                    </div>
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