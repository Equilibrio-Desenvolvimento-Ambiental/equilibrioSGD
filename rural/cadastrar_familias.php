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
			$sql_BENEFICIOS = mysql_query("select * from TAB_APOIO_BENEFICIOS order by DESCRICAO ASC", $db);
			$sql_MUNICIPIOS = mysql_query("select * from TAB_APOIO_MUNICIPIOS order by DESCRICAO ASC", $db);
			$sql_SETETORATEND = mysql_query("select * from TAB_APOIO_SETORATEND order by DESCRICAO ASC", $db);
			$sql_FUSOS = mysql_query("select * from TAB_APOIO_FUSOS order by DESCRICAO ASC", $db);
			$sql_TECNICOS = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC", $db);
			$sql_GRUPOS = mysql_query("select * from TAB_APOIO_PLAN_GRUPOS order by DESCRICAO ASC", $db);
?>
<?php require_once("includes/header-completo.php");?>
<style type="text/css">
<!--
#scroll {
  width:100%;
  height:400px;
  overflow:auto;
}
-->
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
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que nÃ£o Ã© dÃ­gito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parÃªnteses em volta dos dois primeiros dÃ­gitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hÃ­fen entre o quarto e o quinto dÃ­gitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
window.onload = function(){  
    id('telefone').onkeypress = function(){  
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
							<h3>Gestão do Projetos 4.1.5 e 4.2.1 - Reparação Rural e ATES</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Cadastro de Famílias de ATES e Reparação Rural - v.1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_cadastrar_familias.php" method="post" name="familias" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Número C/C:</label>
                            <input type="text" name="FAMILIA_NUMERO" class="form-control" id="exampleInput" placeholder="Digite o número da C/C..." >
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInputEmail1">Processo Fundiário:</label>
                            <input type="text" name="FAMILIA_FUNDIARIO" class="form-control" id="exampleInput" placeholder="Digite o processo fundiário...">
                        </div>
                        <div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInputEmail1">Tipo de Benefício/Grupo:</label>
                            <select name="FAMILIA_BENEFICIO" id="exampleSelect" class="form-control">
                                <option value="0" selected="selected">Selecione a opção de Benefício...</option>
                                <?php while ($vetor_BENEFICIOS=mysql_fetch_array($sql_BENEFICIOS)) { ?>
                                <option value="<?php echo $vetor_BENEFICIOS['ID'] ?>"><?php echo $vetor_BENEFICIOS['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Número C/C/Processo Fundiário/Tipo de Benefício/Grupo -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInputEmail1">Benefíciario:</label>
                            <input type="text" name="FAMILIA_BENEFICIARIO" class="form-control" id="exampleInput" placeholder="Digite o nome do benefíciario...">
                         </div>	
                    </div> <!-- Benefíciario -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Local de Origem:</label>
                            <input type="text" name="FAMILIA_LOCALORIGEM" class="form-control" id="exampleInput" placeholder="Digite a localidade de origem...">
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Local de Destino:</label>
                            <input type="text" name="FAMILIA_LOCALDESTINO" class="form-control" id="exampleInput" placeholder="Digite a localidade de destino...">
                        </div>
                    </div> <!-- Local de Origem/Local de Destino -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Município de Destino:</label>
                            <select name="FAMILIA_MUNICIPIODESTINO" id="exampleSelect" class="form-control">
                                <option value="0" selected="selected">Selecione o município de destino...</option>
                                <?php while ($vetor_MUNICIPIOS=mysql_fetch_array($sql_MUNICIPIOS)) { ?>
                                <option value="<?php echo $vetor_MUNICIPIOS['ID'] ?>"><?php echo $vetor_MUNICIPIOS['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Setor de Atendimento:</label>
                            <select name="FAMILIA_SETORATEND" id="exampleSelect" class="form-control">
                                <option value="0" selected="selected">Selecione o setor de atendimento...</option>
                                <?php while ($vetor_SETETORATEND=mysql_fetch_array($sql_SETETORATEND)) { ?>
                                <option value="<?php echo $vetor_SETETORATEND['ID'] ?>"><?php echo $vetor_SETETORATEND['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Município de Destino/Setor de Atendimento -->
                    <div class="form-group row">
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInput">Telefones:</label>
                            <input type="text" name="FAMILIA_TELEFONES" class="form-control" id="exampleInput" placeholder="Digite os telefones de contato..." >
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Coordenadas UTM E:</label>
                            <input type="text" name="FAMILIA_UTME" class="form-control" id="exampleInput" placeholder="Digite as coordenadas UTM E...">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Coordenadas UTM N:</label>
                            <input type="text" name="FAMILIA_UTMN" class="form-control" id="exampleInput" placeholder="Digite as coordenadas UTM N...">
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Fuso das Coordenadas:</label>
                            <select name="FAMILIA_FUSOGEO" id="exampleSelect" class="form-control">
                            	<option value="0" selected="selected">Selecione o fuso...</option>
                                <?php while ($vetor_FUSOS=mysql_fetch_array($sql_FUSOS)) { ?>
                                <option value="<?php echo $vetor_FUSOS['ID'] ?>"><?php echo $vetor_FUSOS['DESCRICAO'] ?></option>
                                <?php } ?>
							</select>
                        </div>
                    </div> <!-- Telefones/Coordenadas UTM E/Coordenadas UTM N/Fuso das Coordenadas -->
                    <div class="form-group row">
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Familia Residente?</label>
                            <select name="FAMILIAS_RESIDENTE" id="exampleSelect" class="form-control">
                            	<option value="0" selected="selected">Selecione a opção...</option>
                                <option value="1">SIM</option>
                                <option value="2">NÃO</option>
                                <option value="0">NÃO INFORMADO (N/I)</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                        	<label class="form-label semibold" for="exampleInputEmail1">Técnico Responsável:</label>
                            <select name="FAMILIAS_TECNICO" id="exampleSelect" class="form-control">
                            	<option value="0" selected="selected">Selecione o técnico responsável...</option>
                                <?php while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) { ?>
                                <option value="<?php echo $vetor_TECNICOS['ID'] ?>"><?php echo $vetor_TECNICOS['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                        	<label class="form-label semibold" for="exampleInputEmail1">Grupo Semanal:</label>
                            <select name="FAMILIAS_GRUPO" id="exampleSelect" class="form-control">
                            	<option value="7" selected="selected">Selecione o grupo...</option>
                                <?php while ($vetor_GRUPOS=mysql_fetch_array($sql_GRUPOS)) { ?>
                                <option value="<?php echo $vetor_GRUPOS['ID'] ?>"><?php echo $vetor_GRUPOS['DESCRICAO'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Familia Residente?/Técnico Responsável/Grupo Semanal -->
                    </br>
                    <input name="pesq" type="image" src="imgs/salvar.png" class="float" />
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