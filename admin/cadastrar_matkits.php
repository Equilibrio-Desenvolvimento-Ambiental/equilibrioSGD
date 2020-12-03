<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 6;
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
			$sql_MATCONSUMOS = mysql_query("select * from TAB_ADM_MATCONSUMO order by MATCONS_NOME ASC", $db);
			$sql_MATUSO = mysql_query("select * from TAB_ADM_MATUSO order by MATUSO_NOME ASC", $db);
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
var qtdeCamposA = 0;
function addCamposA() {
	var objPaiA = document.getElementById("campoPaiA");
	var objFilhoA = document.createElement("div");
	objFilhoA.setAttribute("id","filhoA"+qtdeCamposA);
	objPaiA.appendChild(objFilhoA);
	document.getElementById("filhoA"+qtdeCamposA).innerHTML = "<table width='100%' border='0'><tr><td width='60%' class='style12' align='center'><select name='MATKITC_ITEM[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um item...</option><?php while ($vetor_MATCONSUMOS=mysql_fetch_array($sql_MATCONSUMOS)){ ?><option value='<?php echo $vetor_MATCONSUMOS[MATCONS_ID]; ?>'><?php echo $vetor_MATCONSUMOS[MATCONS_NOME]; ?></option><?php } ?></select></td><td width='1%' class='style12'></td><td width='10%' align='center'><input type='text' class='form-control' name='MATKITC_QTDE[]'></td><td width='1%' class='style12'></td><td width='18%' class='style12'><input type='button' onclick='removerCampoA("+qtdeCamposA+")' value='Apagar' class='btn btn-inline'></td></tr></table>";
	qtdeCamposA++;
}
function removerCampoA(id) {
var objPaiA = document.getElementById("campoPaiA");
var objFilhoA = document.getElementById("filhoA"+id);
console.log(objPaiA);
var removido = objPaiA.removeChild(objFilhoA);
}

var qtdeCamposB = 0;
function addCamposB() {
	var objPaiB = document.getElementById("campoPaiB");
	var objFilhoB = document.createElement("div");
	objFilhoB.setAttribute("id","filhoB"+qtdeCamposB);
	objPaiB.appendChild(objFilhoB);
	document.getElementById("filhoB"+qtdeCamposB).innerHTML = "<table width='100%' border='0'><tr><td width='60%' class='style12' align='center'><select name='MATKITU_ITEM[]' id='exampleSelect' class='form-control'><option value='0' selected='selected'>Selecione um item...</option><?php while ($vetor_MATUSO=mysql_fetch_array($sql_MATUSO)){ ?><option value='<?php echo $vetor_MATUSO[MATUSO_ID]; ?>'><?php echo $vetor_MATUSO[MATUSO_NOME]; ?></option><?php } ?></select></td><td width='1%' class='style12'></td><td width='10%' align='center'><input type='text' class='form-control' name='MATKITU_QTDE[]'></td><td width='1%' class='style12'></td><td width='18%' class='style12'><input type='button' onclick='removerCampoB("+qtdeCamposB+")' value='Apagar' class='btn btn-inline'></td></tr></table>";
	qtdeCamposB++;
}
function removerCampoB(id) {
var objPaiB = document.getElementById("campoPaiB");
var objFilhoB = document.getElementById("filhoB"+id);
console.log(objPaiB);
var removido = objPaiB.removeChild(objFilhoB);
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
							<h3>Tabelas de Apoio - Gestão de Suprimentos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Cadastro de Kits</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="recebe_cadastrar_matkits.php" method="post" name="matkits" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInput">Nome do Kit:</label>
                            <input type="text" name="MATKIT_NOME" class="form-control" id="exampleInput" placeholder="Digite o nome do kit..." >
                        </div>
                    </div> <!-- Número C/C/Processo Fundiário/Tipo de Benefício/Grupo -->
                    <div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">Materiais de Consumo</a></li>
<!--                        <li><a href="#view2">Materiais de Uso Compartilhado</a></li> -->
                        </ul>
                        <div class="tabcontents">
                            <div id="view1">
                                <table width="100%" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="60%" align="center"><strong>Tipo do Material</strong></td>
                                    <td width="1%">&nbsp;</td>
                                    <td width="10%" align="center"><strong>Quantidade</strong></td>
                                    <td width="1%">&nbsp;</td>
                                    <td width="18%">&nbsp;</td>
                                  </tr>
                                </table>
                                <div id="campoPaiA"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                                <br>
                                <input type="button" value="Adicionar" onClick="addCamposA()" class="btn btn-inline">
                            </div>
<!--                        <div id="view2">
                                <table width="100%" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="60%" align="center"><strong>Tipo do Material</strong></td>
                                    <td width="1%">&nbsp;</td>
                                    <td width="10%" align="center"><strong>Quantidade</strong></td>
                                    <td width="1%">&nbsp;</td>
                                    <td width="18%">&nbsp;</td>
                                  </tr>
                                </table>
                                <div id="campoPaiB"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div>
                                <br>
                                <input type="button" value="Adicionar" onClick="addCamposB()" class="btn btn-inline">
                            </div> -->
                        </div>
                    </div>
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