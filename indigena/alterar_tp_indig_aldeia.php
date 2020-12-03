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
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$id = $_GET['id'];
			$sql = mysql_query("SELECT * FROM TAB_APOIO_INDIG_ALDEIA WHERE ID = '$id';", $db);
			$sqlAldeiaDados = mysql_query("SELECT * FROM TAB_INDIG_ALDEIA_DADOS WHERE INDIG_ALDDAD_ALDEIA = '$id';", $db);
			$vetor = mysql_fetch_array($sql);
			$vetorAldeiaDados = mysql_fetch_array($sqlAldeiaDados);
			$sql_TECNICO = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC;", $db);
?>
<?php require_once("includes/header-completo.php");?>
<style type="text/css">
<!--
#scroll {
  width:100%;
  height:auto;
  overflow:auto;
}
-->
table {
  border-collapse: collapse;
  border: 0px;
}
thead {
  background-color:#090047;
  color:#FFFFFF;
  font-size:16px;
  text-align:left;
  font-weight:bold;
}
th, td {
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
<script src="tabs/tabcontent.js" type="text/javascript"></script>
<link href="tabs/template1/tabcontent.css" rel="stylesheet" type="text/css" />
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
							<h3>Projetos de Atividades Produtivas - PAP / Projeto de Pesca Para Comercialização</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Aldeias - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
	            <form action="recebe_alterar_tp_indig_aldeia.php?id=<?php echo $id; ?>" method="post" name="tp_indig_aldeia" id="tp_indig_aldeia">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="form-label semibold" for="exampleInput">Descrição:</label>
                            <input type="text" name="DESCRICAO" class="form-control" id="DESCRICAO" placeholder="Digite a descrição..." value="<?php echo $vetor['DESCRICAO']; ?>">
                        </div>
					</div>
  				    <div class="form-group row">
						<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_FAMILIAS">Número de Famílias:</label>
							<input type="text" name="INDIG_ALDDAD_FAMILIAS" class="form-control" id="INDIG_ALDDAD_FAMILIAS" placeholder="Famílias" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_FAMILIAS']; ?>">
					   	</div>
					   	<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_PESCADORES">Número de Pescadores:</label>
							<input type="text" name="INDIG_ALDDAD_PESCADORES" class="form-control" id="INDIG_ALDDAD_PESCADORES" placeholder="Pescadores" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_PESCADORES']; ?>">
					   	</div>
					</div><hr> <!-- Linha 01 -->
				    <div class="form-group row">
						<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_PESCA_CX120">Caixas de 120l:</label>
							<input type="text" name="INDIG_ALDDAD_PESCA_CX120" class="form-control" id="INDIG_ALDDAD_PESCA_CX120" placeholder="Caixas" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_PESCA_CX120']; ?>">
					   	</div>
					   	<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_PESCA_CX160">Caixas de 160l:</label>
							<input type="text" name="INDIG_ALDDAD_PESCA_CX160" class="form-control" id="INDIG_ALDDAD_PESCA_CX160" placeholder="Caixas" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_PESCA_CX160']; ?>">
					   	</div>
					   	<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_PESCA_GELO">Barras de Gelo:</label>
							<input type="text" name="INDIG_ALDDAD_PESCA_GELO" class="form-control" id="INDIG_ALDDAD_PESCA_GELO" placeholder="Barras" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_PESCA_GELO']; ?>">
					   	</div>
					</div> <!-- Linha 02 -->
				   	<div class="form-group row">
						<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_PESCA_GL20">Galões de 20l:</label>
							<input type="text" name="INDIG_ALDDAD_PESCA_GL20" class="form-control" id="INDIG_ALDDAD_PESCA_GL20" placeholder="Galões" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_PESCA_GL20']; ?>">
					   	</div>
						<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_PESCA_GL50">Galões de 50l:</label>
							<input type="text" name="INDIG_ALDDAD_PESCA_GL50" class="form-control" id="INDIG_ALDDAD_PESCA_GL50" placeholder="Galões" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_PESCA_GL50']; ?>">
					   	</div>
					   	<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_PESCA_COMB">Combustível:</label>
							<input type="text" name="INDIG_ALDDAD_PESCA_COMB" class="form-control" id="INDIG_ALDDAD_PESCA_COMB" placeholder="Litros" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_PESCA_COMB']; ?>">
					   	</div>
					</div><hr> <!-- Linha 03 -->
				   	<div class="form-group row">
						<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_TRANS_CX120">Caixas de 120l:</label>
							<input type="text" name="INDIG_ALDDAD_TRANS_CX120" class="form-control" id="INDIG_ALDDAD_TRANS_CX120" placeholder="Caixas" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_TRANS_CX120']; ?>">
					   	</div>
						<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_TRANS_CX160">Caixas de 160l:</label>
							<input type="text" name="INDIG_ALDDAD_TRANS_CX160" class="form-control" id="INDIG_ALDDAD_TRANS_CX160" placeholder="Caixas" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_TRANS_CX160']; ?>">
					   	</div>
					   	<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_TRANS_GELO">Barras de Gelo:</label>
							<input type="text" name="INDIG_ALDDAD_TRANS_GELO" class="form-control" id="INDIG_ALDDAD_TRANS_GELO" placeholder="Barras" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_TRANS_GELO']; ?>">
					   	</div>
					</div> <!-- Linha 04 -->
				   	<div class="form-group row">
						<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_TRANS_GL20">Galões de 20l:</label>
							<input type="text" name="INDIG_ALDDAD_TRANS_GL20" class="form-control" id="INDIG_ALDDAD_TRANS_GL20" placeholder="Galões" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_TRANS_GL20']; ?>">
					   	</div>
						<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_TRANS_GL50">Galões de 50l:</label>
							<input type="text" name="INDIG_ALDDAD_TRANS_GL50" class="form-control" id="INDIG_ALDDAD_TRANS_GL50" placeholder="Galões" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_TRANS_GL50']; ?>">
					   	</div>
					   	<div class="col-lg-3">
							<label class="form-label semibold" for="INDIG_ALDDAD_TRANS_COMB">Combustível:</label>
							<input type="text" name="INDIG_ALDDAD_TRANS_COMB" class="form-control" id="INDIG_ALDDAD_TRANS_COMB" placeholder="Litros" onKeyPress="mascara(this,minteiro)" maxlength="10" value="<?php echo $vetorAldeiaDados['INDIG_ALDDAD_TRANS_COMB']; ?>">
					   	</div>
					</div> <!-- Linha 05 -->
					<br/><input name="pesq" type="image" src="imgs/salvar.png" class="float" />
				</form>
			</div>
			<div class="box-typical box-typical-padding">
				<div style="width: 100%; margin: 0 auto;">
					<ul class="tabs" data-persist="true">
						<li><a href="#view1">Entregas Realizadas</a></li>
					</ul>
					<div class="tabcontents">
						<div id="view1">
							<h4>Entregas Realizadas</h4>
							<form action="recebe_indig_cadastrar_prod_entregas.php?idAldeia=<?php echo $id; ?>" method="post" name="recebe_indig_cadastrar_prod_entregas" id="recebe_indig_cadastrar_prod_entregas">
								<div class="form-group row">
									<div class="col-lg-3">
										<label class="form-label semibold" for="INDIG_MOVENT_DATA">Data da Entrega:</label>
										<input type="text" name="INDIG_MOVENT_DATA" class="form-control" id="INDIG_MOVENT_DATA" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10">
									</div>
									<div class="col-lg-7">
										<label class="form-label semibold" for="INDIG_MOVENT_TECNICO">Técnico:</label>
										<select name="INDIG_MOVENT_TECNICO" id="INDIG_MOVENT_TECNICO" class="form-control">
											<?php while ($vetor_TECNICO=mysql_fetch_array($sql_TECNICO)) { ?>
											<option value="<?php echo $vetor_TECNICO['ID']; ?>"><?php echo $vetor_TECNICO['DESCRICAO']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<br/><input name="pesq" type="image" src="imgs/salvar.png" class="float"/>
							</form></br></br>
							<table width="100%">
								<thead>
									<td width="23%">&nbsp;&nbsp;Data da Entrega</td>
									<td width="2%"></td>
									<td width="59%">Técnico</td>
									<td width="4%"></td>
									<td width="10%">Ações</td>
								</thead>
								<?php 
									$sql_MOVENT = mysql_query("SELECT TAB_INDIG_PROD_ENTREGAS.INDIG_MOVENT_ID, TAB_INDIG_PROD_ENTREGAS.INDIG_MOVENT_DATA, TAB_APOIO_TECNICOS.DESCRICAO AS INDIG_MOVENT_TECNICO FROM TAB_INDIG_PROD_ENTREGAS LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_APOIO_TECNICOS.ID = TAB_INDIG_PROD_ENTREGAS.INDIG_MOVENT_TECNICO WHERE TAB_INDIG_PROD_ENTREGAS.INDIG_MOVENT_ALDEIA = '$id' ORDER BY TAB_INDIG_PROD_ENTREGAS.INDIG_MOVENT_DATA DESC;", $db) or die(mysql_error());
									$cor = "#D8D8D8";
									while ($vetor_MOVENT=mysql_fetch_array($sql_MOVENT)) {
										if (strcasecmp($cor, "#FFFFFF") == 0){
											$cor = "#D8D8D8";
											} else {
											$cor = "#FFFFFF";
										}
								?>
								<tr bgcolor="<?php echo $cor; ?>">
									<td width="23%" align="center">&nbsp;&nbsp;<?php echo date('d/m/Y', strtotime($vetor_MOVENT['INDIG_MOVENT_DATA'])); ?></td>
									<td width="2%"></td>
									<td width="59%" align="center"><?php echo $vetor_MOVENT['INDIG_MOVENT_TECNICO']; ?></td>
									<td width="4%"></td>
									<td width="10%" align="center">
									<a class="fancybox fancybox.ajax" hef="#" onClick="window.open('cadastrar_indig_dados_prod_entregas.php?idEntrega=<?php echo $vetor_MOVENT['INDIG_MOVENT_ID'];?>&idAldeia=<?php echo $id;?>','Dados da Entrega', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a></td>
								</tr>
								<?php } ?>
							</table>
						</div> <!-- Entregas -->
					</div>
				</div>
				</br>
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