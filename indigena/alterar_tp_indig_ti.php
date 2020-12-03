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
			$sql = mysql_query("SELECT * FROM TAB_APOIO_INDIG_TI WHERE ID = '$id';", $db);
			$vetor = mysql_fetch_array($sql);
			$sql_TPALDEIA = mysql_query("select * from TAB_APOIO_INDIG_ALDEIA order by DESCRICAO ASC;", $db);
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
  text-align:center;
  font-weight:bold;
}
th {
  font-weight: normal;
  text-align: left;
}
</style>
<script type="text/javascript">
var qtdeCampos = 0;
function addCampos() {
var objPai = document.getElementById("campoPai");
var objFilho = document.createElement("div");
objFilho.setAttribute("id","filho"+qtdeCampos);
objPai.appendChild(objFilho);
document.getElementById("filho"+qtdeCampos).innerHTML = "<table width='100%'><tr><td width='88%'><select name='ALDEIA_ID[]' class='form-control'><option value='0' selected='selected'>Selecione uma Terra Indígena...</option><?php while ($vetor_TPALDEIA=mysql_fetch_array($sql_TPALDEIA)){ ?><option value='<?php echo $vetor_TPALDEIA[ID]; ?>'><?php echo $vetor_TPALDEIA[DESCRICAO]; ?></option><?php } ?></select></td><td width='2%'></td><td width='10%'><input type='button' onclick='removerCampo("+qtdeCampos+")' value='Remover' class='btn btn-inline'></td></tr></table>";
qtdeCampos++;
}
function removerCampo(id) {
var objPai = document.getElementById("campoPai");
var objFilho = document.getElementById("filho"+id);
console.log(objPai);
var removido = objPai.removeChild(objFilho);
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
							<h3>Projetos de Atividades Produtivas - PAP / Projeto de Pesca Para Comercialização</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Alteração de Terras Indígenas - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
                <form action="recebe_alterar_tp_indig_ti.php?id=<?php echo $id; ?>" method="post" name="tp_indigti" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="form-label semibold" for="exampleInput">Descrição:</label>
                            <input type="text" name="DESCRICAO" class="form-control" id="DESCRICAO" placeholder="Digite a descrição..." value="<?php echo $vetor['DESCRICAO']; ?>">
                        </div>
                    </div>
					<div style="width: 100%; margin: 0 auto;">
						<ul class="tabs" data-persist="true">
							<li><a href="#view1">Aldeias</a></li>
						</ul>
						<div class="tabcontents">
							<div id="view1">
								<div id="scroll">
									<table width="100%">
										<thead>
											<td width="88%">Aldeias</td>
											<td width="2%"></td>
											<td width="10%">&nbsp;</td>
										  </thead>
									</table>
									<div id="campoPai"><img src="imgs/separacao.png" alt="" width="10" height="10" /></div></br>
									<input type="button" value="Inserir" onClick="addCampos()" class="btn btn-inline">
									</br></br>
									<table width="100%">
										<thead>
											<td width="88%">Aldeias</td>
											<td width="2%"></td>
											<td width="10%">Ações</td>
										</thead>
										<?php 
											$sql_LIST_TPALDEIA = mysql_query("SELECT TAB_APOIO_INDIG_TI.ID AS TI_ID, TAB_APOIO_INDIG_ALDEIA.ID AS ALDEIA_ID, TAB_APOIO_INDIG_ALDEIA.DESCRICAO FROM TAB_APOIO_INDIG_TI INNER JOIN TAB_INDIG_REL_TI_ALDEIA ON TAB_INDIG_REL_TI_ALDEIA.TI_ID = TAB_APOIO_INDIG_TI.ID INNER JOIN TAB_APOIO_INDIG_ALDEIA ON TAB_APOIO_INDIG_ALDEIA.ID = TAB_INDIG_REL_TI_ALDEIA.ALDEIA_ID WHERE TAB_APOIO_INDIG_TI.ID = '$id' ORDER BY TAB_APOIO_INDIG_ALDEIA.DESCRICAO ASC;", $db) or die(mysql_error());
											$cor = "#D8D8D8";
											while ($vetor_LIST_TPALDEIA=mysql_fetch_array($sql_LIST_TPALDEIA)) {
												if (strcasecmp($cor, "#FFFFFF") == 0){
													$cor = "#D8D8D8";
													} else {
													$cor = "#FFFFFF";
												}
										?>
										<tr bgcolor="<?php echo $cor; ?>">
											<td width="88%"><?php echo $vetor_LIST_TPALDEIA['DESCRICAO'];?></td>
											<td width="2%"></td>
											<td width="10%" align="center"><a class="fancybox fancybox.ajax" href="recebe_indig_excluir_rel_ti_aldeia.php?id_ti=<?php echo $vetor_LIST_TPALDEIA['TI_ID']; ?>&id_aldeia=<?php echo $vetor_LIST_TPALDEIA['ALDEIA_ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
										</tr>
										<?php } ?>
									</table>
								</div>                                
							</div> <!-- Aba -->
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