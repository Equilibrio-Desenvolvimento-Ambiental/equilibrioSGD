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
			$id = $_GET['id'];
			$id_evento = $_GET['id_evento'];
			$id_familia = $_GET['id_familia'];
			$sql_EVENTO = mysql_query("select * from TAB_415421_EVENTOS where EVENTOS_CODIGO = '$id_evento';", $db);
			$vetor_EVENTO = mysql_fetch_array($sql_EVENTO);
			$sql_TPEVENTOS = mysql_query("select * from TAB_APOIO_EVENTOS order by DESCRICAO ASC", $db);			
			$sql_TPVISIT415 = mysql_query("select * from TAB_APOIO_TPVISIT415 order by DESCRICAO ASC", $db);
			$sql_TPVISIT421 = mysql_query("select * from TAB_APOIO_TPVISIT421 order by DESCRICAO ASC", $db);
			$sql_TPVISITRIR = mysql_query("select * from TAB_APOIO_TPVISITRIR order by DESCRICAO ASC", $db);
			$sql_TECNICOS = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC", $db);
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
								<li><a href="#">Dados do Evento</a></li>
								<li><a href="#">Alteração de Dados da Imagem</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<div class="box-typical box-typical-padding">
				<form action="#" method="post" name="eventos" enctype="multipart/form-data" id="formID">
                    <div class="form-group row">
						<div class="col-lg-4">
                        	<label class="form-label semibold" for="exampleInput">Data do Evento:</label>
                            <input type="text" name="EVENTOS_DATA" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10" value="<?php echo date('d/m/Y', strtotime($vetor_EVENTO['EVENTOS_DATA'])); ?>">
                        </div>
                        <div class="col-lg-8">
                        	<label class="form-label semibold" for="exampleInputEmail1">Tipo do Evento:</label>
                            <select name="EVENTOS_TIPO" id="exampleSelect" class="form-control">
								<?php while ($vetor_TPEVENTOS=mysql_fetch_array($sql_TPEVENTOS)) { ?>
                                <option label="<?php echo $vetor_TPEVENTOS['DESCRICAO']; ?>" value="<?php echo $vetor_TPEVENTOS['ID']; ?>" <?php if (strcasecmp($vetor_EVENTO['EVENTOS_TIPO'], $vetor_TPEVENTOS['ID']) == 0) : ?>selected="selected"<?php endif; ?>><?php echo $vetor_TPEVENTOS['DESCRICAO']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> <!-- Data do Evento / Tipo do Evento -->
                    <div class="form-group row">
                        <div class="col-lg-12">
                        	<label class="form-label semibold" for="exampleInputEmail1">Observações:</label>
                            <input type="text" name="EVENTOS_OBSERVACOES" class="form-control" id="exampleInput" placeholder="Digite observações..." value="<?php echo $vetor_EVENTO['EVENTOS_OBSERVACOES']; ?>">
                         </div>	
                    </div> <!-- Observações -->
				</form>
			</div><!--.box-typical-->
			<div class="box-typical box-typical-padding">
                <form action="recebe_alterar_evento_imagem.php?id=<?php echo $id; ?>&id_evento=<?php echo $id_evento; ?>&id_familia=<?php echo $id_familia; ?>" method="post" name="imagem" enctype="multipart/form-data" id="formID">
                    <div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view4">Registro Fotográfico</a></li>
                        </ul>

	                    <div class="tabcontents">
                    
                    	<div id="view4">
                        <table width="100%">
                          <thead>
                            <td width="48%">Legenda</td>
                            <td width="4%"></td>
                            <td width="48%">Imagem</td>
                          </thead>
                           <?php 
                                $sql_imagem = mysql_query("select * from TAB_415421_IMAGENS where IMAGEM_CODIGO = '$id' and EVENTOS_CODIGO = '$id_evento';", $db);
								$vetor_imagem = mysql_fetch_array($sql_imagem);
                                $sql_imagemS = mysql_query("select * from TAB_415421_IMAGENS WHERE EVENTOS_CODIGO = '$id_evento'", $db);
								$cor = "#D8D8D8";
                                while ($vetor_imagemS=mysql_fetch_array($sql_imagemS)) {
									if (strcasecmp($cor, "#FFFFFF") == 0){
										$cor = "#D8D8D8";
									} else {
										$cor = "#FFFFFF";
									}
                            ?>
                            <tr bgcolor="<?php echo $cor; ?>">
                                <td width="48%" align="center" valign="middle"><img src="imagens/<?php echo $vetor_imagemS['IMAGEM_NOME']; ?>" width="150"></td>
                                <td width="4%"></td>
                                <td width="48%"><?php echo $vetor_imagemS['IMAGEM_LEGENDA']; ?></td>
                          </tr>
                          <?php } ?>
                        </table><br/><br/>
                    	</div>
                        <div id="campoPai">
                        	<table width='100%' border='0'>
                            	<tr>
                                <td width="48%" align="center" valign="middle"><img src="imagens/<?php echo $vetor_imagem['IMAGEM_NOME']; ?>" width="150"></td>
								<td width='4%'></td>
                               	<td width='48%'>
                                   	<textarea rows='6' class='form-control' name='IMAGEM_LEGENDA'><?php echo $vetor_imagem['IMAGEM_LEGENDA']; ?></textarea>
                                    </td>
                                </tr>
							</table>
                        </div>

                    	</div>

                    </div>
                    </br>
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