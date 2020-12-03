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
			$sql_MATCONSUMO = mysql_query("select TAB_ADM_MATCONSUMO.MATCONS_ID, TAB_ADM_MATCONSUMO.MATCONS_NOME, TAB_APOIO_PROD_UNIT.DESCRICAO as MATCONS_UNIDADE_DESC from TAB_ADM_MATCONSUMO left outer join TAB_APOIO_PROD_UNIT on TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID order by TAB_ADM_MATCONSUMO.MATCONS_NOME asc;", $db);
			$sql_FORNECEDOR = mysql_query("SELECT FORNEC_ID, FORNEC_NOME, FORNEC_NOMEFANT FROM TAB_ADM_FORNECEDOR ORDER BY FORNEC_NOME ASC, FORNEC_NOMEFANT ASC;", $db);

			if(isset($_POST["filter"])){
				$filter = $_POST["filter"];
				if($filter == 1) { $_SESSION["lastfilter"] = $_POST["PRODENTC_DATA"]; }
				if($filter == 2) { $_SESSION["lastfilter_ini"] = $_POST["PRODENTC_DATA_INI"];
								   $_SESSION["lastfilter_fim"] = $_POST["PRODENTC_DATA_FIM"]; }
				if($filter == 3) { $_SESSION["lastfilter"] = $_POST["PRODENTC_PRODUTO"]; }
				if($filter == 4) { $_SESSION["lastfilter"] = $_POST["PRODENTC_FORNEC"]; }
			} else {
				if(isset($_GET["filter"])):
					$filter = $_GET["filter"];
				else:
					$filter = 0;
				endif;
			}
			if(isset($_GET["page"])):
				$page = $_GET["page"];
			else:
				$page = 1;
			endif;
			$byPage = 10;
			$startAt = ($page*$byPage)-$byPage;
			if($filter == 0){
				$sqlTotalRecords = mysql_query("SELECT TAB_ADM_ENTRADAS_CON.PRODENTC_ID FROM TAB_ADM_ENTRADAS_CON;", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_ADM_ENTRADAS_CON.PRODENTC_ID, TAB_ADM_ENTRADAS_CON.PRODENTC_DATA, TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO, TAB_ADM_MATCONSUMO.MATCONS_NOME AS PRODENTC_PRODUTO_DESCRICAO, TAB_APOIO_PROD_UNIT.DESCRICAO AS PRODENTC_PRODUTO_UNIDADE, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_ENTRADAS_CON.PRODENTC_VALOR, TAB_ADM_ENTRADAS_CON.PRODENTC_QTDE FROM TAB_ADM_ENTRADAS_CON LEFT OUTER JOIN TAB_ADM_MATCONSUMO ON TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO = TAB_ADM_MATCONSUMO.MATCONS_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID LEFT OUTER JOIN TAB_ADM_FORNECEDOR ON TAB_ADM_ENTRADAS_CON.PRODENTC_FORNEC = TAB_ADM_FORNECEDOR.FORNEC_ID ORDER BY TAB_ADM_ENTRADAS_CON.PRODENTC_DATA DESC, TAB_ADM_MATCONSUMO.MATCONS_NOME ASC LIMIT $startAt, $byPage;", $db);
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$PRODENTC_DATA = implode('-',array_reverse(explode('/',$_POST['PRODENTC_DATA'])));
				else:
					$PRODENTC_DATA = implode('-',array_reverse(explode('/',$_SESSION['lastfilter'])));
				endif;				
				$sqlTotalRecords = mysql_query("SELECT TAB_ADM_ENTRADAS_CON.PRODENTC_ID FROM TAB_ADM_ENTRADAS_CON WHERE TAB_ADM_ENTRADAS_CON.PRODENTC_DATA = '$PRODENTC_DATA';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_ADM_ENTRADAS_CON.PRODENTC_ID, TAB_ADM_ENTRADAS_CON.PRODENTC_DATA, TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO, TAB_ADM_MATCONSUMO.MATCONS_NOME AS PRODENTC_PRODUTO_DESCRICAO, TAB_APOIO_PROD_UNIT.DESCRICAO AS PRODENTC_PRODUTO_UNIDADE, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_ENTRADAS_CON.PRODENTC_VALOR, TAB_ADM_ENTRADAS_CON.PRODENTC_QTDE FROM TAB_ADM_ENTRADAS_CON LEFT OUTER JOIN TAB_ADM_MATCONSUMO ON TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO = TAB_ADM_MATCONSUMO.MATCONS_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID LEFT OUTER JOIN TAB_ADM_FORNECEDOR ON TAB_ADM_ENTRADAS_CON.PRODENTC_FORNEC = TAB_ADM_FORNECEDOR.FORNEC_ID WHERE TAB_ADM_ENTRADAS_CON.PRODENTC_DATA = '$PRODENTC_DATA' ORDER BY TAB_ADM_ENTRADAS_CON.PRODENTC_DATA DESC, TAB_ADM_MATCONSUMO.MATCONS_NOME ASC LIMIT $startAt, $byPage;", $db);
			}
			if($filter == 2) {
				if(isset($_POST["filter"])):
					$PRODENTC_DATA_INI = implode('-',array_reverse(explode('/',$_POST['PRODENTC_DATA_INI'])));
					$PRODENTC_DATA_FIM = implode('-',array_reverse(explode('/',$_POST['PRODENTC_DATA_FIM'])));
				else:
					$PRODENTC_DATA_INI = implode('-',array_reverse(explode('/',$_SESSION['lastfilter_ini'])));
					$PRODENTC_DATA_FIM = implode('-',array_reverse(explode('/',$_SESSION['lastfilter_fim'])));
				endif;				
				$sqlTotalRecords = mysql_query("SELECT TAB_ADM_ENTRADAS_CON.PRODENTC_ID FROM TAB_ADM_ENTRADAS_CON WHERE TAB_ADM_ENTRADAS_CON.PRODENTC_DATA BETWEEN '$PRODENTC_DATA_INI' AND '$PRODENTC_DATA_FIM';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_ADM_ENTRADAS_CON.PRODENTC_ID, TAB_ADM_ENTRADAS_CON.PRODENTC_DATA, TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO, TAB_ADM_MATCONSUMO.MATCONS_NOME AS PRODENTC_PRODUTO_DESCRICAO, TAB_APOIO_PROD_UNIT.DESCRICAO AS PRODENTC_PRODUTO_UNIDADE, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_ENTRADAS_CON.PRODENTC_VALOR, TAB_ADM_ENTRADAS_CON.PRODENTC_QTDE FROM TAB_ADM_ENTRADAS_CON LEFT OUTER JOIN TAB_ADM_MATCONSUMO ON TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO = TAB_ADM_MATCONSUMO.MATCONS_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID LEFT OUTER JOIN TAB_ADM_FORNECEDOR ON TAB_ADM_ENTRADAS_CON.PRODENTC_FORNEC = TAB_ADM_FORNECEDOR.FORNEC_ID WHERE TAB_ADM_ENTRADAS_CON.PRODENTC_DATA BETWEEN '$PRODENTC_DATA_INI' AND '$PRODENTC_DATA_FIM' ORDER BY TAB_ADM_ENTRADAS_CON.PRODENTC_DATA DESC, TAB_ADM_MATCONSUMO.MATCONS_NOME ASC LIMIT $startAt, $byPage;", $db);
			}
			if($filter == 3) {
				if(isset($_POST["filter"])):
					$PRODENTC_PRODUTO = $_POST['PRODENTC_PRODUTO'];
				else:
					$PRODENTC_PRODUTO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT TAB_ADM_ENTRADAS_CON.PRODENTC_ID FROM TAB_ADM_ENTRADAS_CON WHERE TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO = '$PRODENTC_PRODUTO';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_ADM_ENTRADAS_CON.PRODENTC_ID, TAB_ADM_ENTRADAS_CON.PRODENTC_DATA, TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO, TAB_ADM_MATCONSUMO.MATCONS_NOME AS PRODENTC_PRODUTO_DESCRICAO, TAB_APOIO_PROD_UNIT.DESCRICAO AS PRODENTC_PRODUTO_UNIDADE, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_ENTRADAS_CON.PRODENTC_VALOR, TAB_ADM_ENTRADAS_CON.PRODENTC_QTDE FROM TAB_ADM_ENTRADAS_CON LEFT OUTER JOIN TAB_ADM_MATCONSUMO ON TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO = TAB_ADM_MATCONSUMO.MATCONS_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID LEFT OUTER JOIN TAB_ADM_FORNECEDOR ON TAB_ADM_ENTRADAS_CON.PRODENTC_FORNEC = TAB_ADM_FORNECEDOR.FORNEC_ID WHERE TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO = '$PRODENTC_PRODUTO' ORDER BY TAB_ADM_ENTRADAS_CON.PRODENTC_DATA DESC, TAB_ADM_MATCONSUMO.MATCONS_NOME ASC LIMIT $startAt, $byPage;", $db);
			}
			if($filter == 4) {
				if(isset($_POST["filter"])):
					$PRODENTC_FORNEC = $_POST['PRODENTC_FORNEC'];
				else:
					$PRODENTC_FORNEC = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT TAB_ADM_ENTRADAS_CON.PRODENTC_ID FROM TAB_ADM_ENTRADAS_CON WHERE TAB_ADM_ENTRADAS_CON.PRODENTC_FORNEC = '$PRODENTC_FORNEC';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_ADM_ENTRADAS_CON.PRODENTC_ID, TAB_ADM_ENTRADAS_CON.PRODENTC_DATA, TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO, TAB_ADM_MATCONSUMO.MATCONS_NOME AS PRODENTC_PRODUTO_DESCRICAO, TAB_APOIO_PROD_UNIT.DESCRICAO AS PRODENTC_PRODUTO_UNIDADE, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_ENTRADAS_CON.PRODENTC_VALOR, TAB_ADM_ENTRADAS_CON.PRODENTC_QTDE FROM TAB_ADM_ENTRADAS_CON LEFT OUTER JOIN TAB_ADM_MATCONSUMO ON TAB_ADM_ENTRADAS_CON.PRODENTC_PRODUTO = TAB_ADM_MATCONSUMO.MATCONS_ID LEFT OUTER JOIN TAB_APOIO_PROD_UNIT ON TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID LEFT OUTER JOIN TAB_ADM_FORNECEDOR ON TAB_ADM_ENTRADAS_CON.PRODENTC_FORNEC = TAB_ADM_FORNECEDOR.FORNEC_ID WHERE TAB_ADM_ENTRADAS_CON.PRODENTC_FORNEC = '$PRODENTC_FORNEC' ORDER BY TAB_ADM_ENTRADAS_CON.PRODENTC_DATA DESC, TAB_ADM_MATCONSUMO.MATCONS_NOME ASC LIMIT $startAt, $byPage;", $db);
			}
?>
<?php require_once("includes/header-completo.php");?>
<script type="text/javascript">  
$(document).ready(function(){  
        $("#palco > div").hide();  
		$("#filter").change(function(){  
                $("#palco > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
});  
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
							<h3>Gestão de Suprimentos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Listagem de Entradas de Materiais de Produtos</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_entradaprod_con.php" method="post" name="filtro_entradaprod_con" onSubmit="return validaForm()">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th width="25%">Filtro de Busca</th>
                            <th width="75%"></th>
                        </tr>
                    </thead>
                	<tbody>
                    	<tr>
                            <td>
                                <select name="filter" id="filter" class="form-control" required>
                                    <option value="0" selected>Limpar Filtros</option>
                                    <option value="1">Filtrar Por Data</option>
                                    <option value="2">Filtrar Por Intervalo de Datas</option>
                                    <option value="3">Filtrar Por Produto</option>
                                    <option value="4">Filtrar Por Fornecedor</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
										<input type="text" name="PRODENTC_DATA" class="form-control" id="exampleInput" placeholder="Digite a data da entrada..." onKeyPress="mascara(this,mdata)">
                                    </div>
                                    <div id="2">
										<input type="text" name="PRODENTC_DATA_INI" class="form-control" id="exampleInput" placeholder="Digite a data incial..." onKeyPress="mascara(this,mdata)"><br/>
										<input type="text" name="PRODENTC_DATA_FIM" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)">
                                    </div>
                                    <div id="3">
                                        <select name="PRODENTC_PRODUTO" id="exampleSelect" class="form-control">
											<?php while($vetor_MATCONSUMO=mysql_fetch_array($sql_MATCONSUMO)){?>
                                            <option value="<?php echo $vetor_MATCONSUMO['MATCONS_ID']; ?>"><?php echo $vetor_MATCONSUMO['MATCONS_NOME'].' ('.$vetor_MATCONSUMO['MATCONS_UNIDADE_DESC'].')'; ?></option><?php } ?>
                                        </select>
                                    </div>
                                    <div id="4">
                                        <select name="PRODENTC_FORNEC" id="exampleSelect" class="form-control">
											<?php while($vetor_FORNECEDOR=mysql_fetch_array($sql_FORNECEDOR)){?>
                                            <option value="<?php echo $vetor_FORNECEDOR['FORNEC_ID']; ?>"><?php echo $vetor_FORNECEDOR['FORNEC_NOME'].' // '.$vetor_FORNECEDOR['FORNEC_NOMEFANT']; ?></option><?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
				</table>
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                    <tr>
                        <th><input name="buscar" class="float" type="image" src="imgs/buscar.png" value="Buscar" /></th>
                    </tr>
                    </thead>
                </table>
            </form>
            </br>
            <div><a href="cadastrar_entradaprod_con.php"><img src="imgs/adicionar.png" border="0"></a><br/><br/></div>            <table id="table-sm" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Produto</th>
                        <th>Centro de Custo</th>
                        <th width="10%">Valor (R$)</th>
                        <th>Qtde.</th>
                        <th valign="center"><a class="fancybox fancybox.ajax" href="excel_entradaprod_con.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($vetor['PRODENTC_DATA'])); ?></td>
                        <td><?php echo $vetor['PRODENTC_PRODUTO_DESCRICAO'].' ('.$vetor['PRODENTC_PRODUTO_UNIDADE'].')'; ?></td>
                        <td><?php echo $vetor['FORNEC_NOME'].' // '.$vetor['FORNEC_NOMEFANT']; ?></td>
                        <td align="right" width="10%"><?php echo 'R$ '.number_format($vetor['PRODENTC_VALOR'],2,',','.'); ?></td>
                        <td align="right"><?php echo $vetor['PRODENTC_QTDE']; ?></td>
                        <td>&nbsp;</td>
<!--                        <td><a class="fancybox fancybox.ajax" href="alterar_matuso.php?id=<?php echo $vetor['MATUSO_ID']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a> <a class="fancybox fancybox.ajax" href="recebe_excluir_matuso.php?id=<?php echo $vetor['MATUSO_ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td> -->
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_entradaprod_con.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_entradaprod_con.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_entradaprod_con.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_entradaprod_con.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
                    else:
                        echo '<img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página">';
                        echo '<img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página">';
                    endif;
                ?>
            </div>    
		</div>
	</div>
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>