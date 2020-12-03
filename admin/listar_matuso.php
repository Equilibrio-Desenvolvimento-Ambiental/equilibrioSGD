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
			$sql_CATEGORIAS = mysql_query("select * from TAB_APOIO_PROD_CATEG order by DESCRICAO ASC", $db);
			$sql_UNIDADES = mysql_query("select * from TAB_APOIO_PROD_UNIT order by DESCRICAO ASC", $db);
			if(isset($_POST["filter"])){
				$filter = $_POST["filter"];
				if($filter == 1) { $_SESSION["lastfilter"] = $_POST["MATUSO_NOME"]; }
				if($filter == 2) { $_SESSION["lastfilter"] = $_POST["MATUSO_CATEGORIA"]; }
				if($filter == 3) { $_SESSION["lastfilter"] = $_POST["MATUSO_UNIDADE"]; }
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
				$sqlTotalRecords = mysql_query("select TAB_ADM_MATUSO.MATUSO_ID from TAB_ADM_MATUSO;", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_ADM_MATUSO.MATUSO_ID, TAB_ADM_MATUSO.MATUSO_NOME, TAB_APOIO_PROD_CATEG.DESCRICAO as MATUSO_CATEGORIA_DESC, TAB_APOIO_PROD_UNIT.DESCRICAO as MATUSO_UNIDADE_DESC, TAB_ADM_MATUSO.MATUSO_ESTOQUE_ATUAL, TAB_ADM_MATUSO.MATUSO_ESTOQUE_USO from TAB_ADM_MATUSO left outer join TAB_APOIO_PROD_CATEG on TAB_APOIO_PROD_CATEG.ID = TAB_ADM_MATUSO.MATUSO_CATEGORIA left outer join TAB_APOIO_PROD_UNIT on TAB_APOIO_PROD_UNIT.ID = TAB_ADM_MATUSO.MATUSO_UNIDADE order by TAB_ADM_MATUSO.MATUSO_NOME asc limit $startAt, $byPage;", $db);
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$MATUSO_NOME = $_POST['MATUSO_NOME'];
				else:
					$MATUSO_NOME = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_ADM_MATUSO.MATUSO_ID from TAB_ADM_MATUSO where TAB_ADM_MATUSO.MATUSO_NOME like '%".$MATUSO_NOME."%';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_ADM_MATUSO.MATUSO_ID, TAB_ADM_MATUSO.MATUSO_NOME, TAB_APOIO_PROD_CATEG.DESCRICAO as MATUSO_CATEGORIA_DESC, TAB_APOIO_PROD_UNIT.DESCRICAO as MATUSO_UNIDADE_DESC, TAB_ADM_MATUSO.MATUSO_ESTOQUE_ATUAL, TAB_ADM_MATUSO.MATUSO_ESTOQUE_USO from TAB_ADM_MATUSO left outer join TAB_APOIO_PROD_CATEG on TAB_APOIO_PROD_CATEG.ID = TAB_ADM_MATUSO.MATUSO_CATEGORIA left outer join TAB_APOIO_PROD_UNIT on TAB_APOIO_PROD_UNIT.ID = TAB_ADM_MATUSO.MATUSO_UNIDADE where TAB_ADM_MATUSO.MATUSO_NOME like '%".$MATUSO_NOME."%' order by TAB_ADM_MATUSO.MATUSO_NOME asc limit $startAt, $byPage;", $db);
			}
			if($filter == 2) {
				if(isset($_POST["filter"])):
					$MATUSO_CATEGORIA = $_POST['MATUSO_CATEGORIA'];
				else:
					$MATUSO_CATEGORIA = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_ADM_MATUSO.MATUSO_ID from TAB_ADM_MATUSO where TAB_ADM_MATUSO.MATUSO_CATEGORIA = '$MATUSO_CATEGORIA';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_ADM_MATUSO.MATUSO_ID, TAB_ADM_MATUSO.MATUSO_NOME, TAB_APOIO_PROD_CATEG.DESCRICAO as MATUSO_CATEGORIA_DESC, TAB_APOIO_PROD_UNIT.DESCRICAO as MATUSO_UNIDADE_DESC, TAB_ADM_MATUSO.MATUSO_ESTOQUE_ATUAL, TAB_ADM_MATUSO.MATUSO_ESTOQUE_USO from TAB_ADM_MATUSO left outer join TAB_APOIO_PROD_CATEG on TAB_APOIO_PROD_CATEG.ID = TAB_ADM_MATUSO.MATUSO_CATEGORIA left outer join TAB_APOIO_PROD_UNIT on TAB_APOIO_PROD_UNIT.ID = TAB_ADM_MATUSO.MATUSO_UNIDADE where TAB_ADM_MATUSO.MATUSO_CATEGORIA = '$MATUSO_CATEGORIA' order by TAB_ADM_MATUSO.MATUSO_NOME asc limit $startAt, $byPage;", $db);
			}
			if($filter == 3) {
				if(isset($_POST["filter"])):
					$MATUSO_UNIDADE = $_POST['MATUSO_UNIDADE'];
				else:
					$MATUSO_UNIDADE = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_ADM_MATUSO.MATUSO_ID from TAB_ADM_MATUSO where TAB_ADM_MATUSO.MATUSO_UNIDADE = '$MATUSO_UNIDADE';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_ADM_MATUSO.MATUSO_ID, TAB_ADM_MATUSO.MATUSO_NOME, TAB_APOIO_PROD_CATEG.DESCRICAO as MATUSO_CATEGORIA_DESC, TAB_APOIO_PROD_UNIT.DESCRICAO as MATUSO_UNIDADE_DESC, TAB_ADM_MATUSO.MATUSO_ESTOQUE_ATUAL, TAB_ADM_MATUSO.MATUSO_ESTOQUE_USO from TAB_ADM_MATUSO left outer join TAB_APOIO_PROD_CATEG on TAB_APOIO_PROD_CATEG.ID = TAB_ADM_MATUSO.MATUSO_CATEGORIA left outer join TAB_APOIO_PROD_UNIT on TAB_APOIO_PROD_UNIT.ID = TAB_ADM_MATUSO.MATUSO_UNIDADE where TAB_ADM_MATUSO.MATUSO_UNIDADE = '$MATUSO_UNIDADE' order by TAB_ADM_MATUSO.MATUSO_NOME asc limit $startAt, $byPage;", $db);
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
							<h3>Tabelas de Apoio - Gestão de Suprimentos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Listagem de Ferramentas</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_matuso.php" method="post" name="filtro_matuso" onSubmit="return validaForm()">
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
                                    <option value="1">Filtrar Por Nome</option>
                                    <option value="2">Filtrar Por Categoria</option>
                                    <option value="3">Filtrar Por Unidade de Medida</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
										<input type="text" name="MATUSO_NOME" class="form-control" id="exampleInput" placeholder="Digite o nome do produto...">
                                    </div>
                                    <div id="2">
                                        <select name="MATUSO_CATEGORIA" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_CATEGORIAS=mysql_fetch_array($sql_CATEGORIAS)) { ?>
                                            <option value="<?php echo $vetor_CATEGORIAS['ID'] ?>"><?php echo $vetor_CATEGORIAS['DESCRICAO'] ?></option><?php } ?>
                                        </select>
                                    </div>
                                    <div id="3">
                                        <select name="MATUSO_UNIDADE" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_UNIDADES=mysql_fetch_array($sql_UNIDADES)) { ?>
                                            <option value="<?php echo $vetor_UNIDADES['ID'] ?>"><?php echo $vetor_UNIDADES['DESCRICAO'] ?></option><?php } ?>
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
            <div><a href="cadastrar_matuso.php"><img src="imgs/adicionar.png" border="0"></a><br/><br/></div>            <table id="table-sm" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th width="1">Cod.</th>
                        <th>Nome do Produto</th>
                        <th>Categoria</th>
                        <th>Unidade de Medida</th>
                        <th>Estoque Total</th>
                        <th>Em Uso</th>
                        <th width="75" valign="center"><a class="fancybox fancybox.ajax" href="excel_matuso.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['MATUSO_ID']; ?></td>
                        <td><?php echo $vetor['MATUSO_NOME']; ?></td>
                        <td><?php echo $vetor['MATUSO_CATEGORIA_DESC']; ?></td>
                        <td><?php echo $vetor['MATUSO_UNIDADE_DESC']; ?></td>
                        <td><?php echo $vetor['MATUSO_ESTOQUE_ATUAL']; ?></td>
                        <td><?php echo $vetor['MATUSO_ESTOQUE_USO']; ?></td>
                        <td><a class="fancybox fancybox.ajax" href="alterar_matuso.php?id=<?php echo $vetor['MATUSO_ID']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a> <a class="fancybox fancybox.ajax" href="recebe_excluir_matuso.php?id=<?php echo $vetor['MATUSO_ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_matuso.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_matuso.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_matuso.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_matuso.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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