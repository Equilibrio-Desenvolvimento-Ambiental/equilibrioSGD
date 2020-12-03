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
			$sql_MUNICIPIOS = mysql_query("SELECT TAB_APOIO_MUNICIPIOS.DESCRICAO, TAB_APOIO_UF.SIGLA FROM TAB_APOIO_MUNICIPIOS LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_APOIO_MUNICIPIOS.DESCRICAO ASC;", $db);
			if(isset($_POST["filter"])){
				$filter = $_POST["filter"];
				if($filter == 1) { $_SESSION["lastfilter"] = $_POST["FORNEC_NOME"]; }
				if($filter == 2) { $_SESSION["lastfilter"] = $_POST["FORNEC_NOMEFANT"]; }
				if($filter == 3) { $_SESSION["lastfilter"] = $_POST["FORNEC_NOMERESP"]; }
				if($filter == 4) { $_SESSION["lastfilter"] = $_POST["FORNEC_MUNICIPIO"]; }
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
				$sqlTotalRecords = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID FROM TAB_ADM_FORNECEDOR;", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_FORNECEDOR.FORNEC_CPFCNPJ, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FORNEC_MUNICIPIO_DESC, TAB_APOIO_UF.SIGLA AS FORNEC_MUNICIPIO_DESC_UF FROM TAB_ADM_FORNECEDOR LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_ADM_FORNECEDOR.FORNEC_MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID ORDER BY TAB_ADM_FORNECEDOR.FORNEC_NOME ASC limit $startAt, $byPage;", $db);
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$FORNEC_NOME = $_POST['FORNEC_NOME'];
				else:
					$FORNEC_NOME = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID FROM TAB_ADM_FORNECEDOR WHERE TAB_ADM_FORNECEDOR.FORNEC_NOME LIKE '%".$FORNEC_NOME."%';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_FORNECEDOR.FORNEC_CPFCNPJ, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FORNEC_MUNICIPIO_DESC, TAB_APOIO_UF.SIGLA AS FORNEC_MUNICIPIO_DESC_UF FROM TAB_ADM_FORNECEDOR LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_ADM_FORNECEDOR.FORNEC_MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID WHERE TAB_ADM_FORNECEDOR.FORNEC_NOME LIKE '%".$FORNEC_NOME."%' ORDER BY TAB_ADM_FORNECEDOR.FORNEC_NOME ASC limit $startAt, $byPage;", $db);
			}
			if($filter == 2) {
				if(isset($_POST["filter"])):
					$FORNEC_NOMEFANT = $_POST['FORNEC_NOMEFANT'];
				else:
					$FORNEC_NOMEFANT = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID FROM TAB_ADM_FORNECEDOR WHERE TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT LIKE '%".$FORNEC_NOMEFANT."%';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_FORNECEDOR.FORNEC_CPFCNPJ, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FORNEC_MUNICIPIO_DESC, TAB_APOIO_UF.SIGLA AS FORNEC_MUNICIPIO_DESC_UF FROM TAB_ADM_FORNECEDOR LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_ADM_FORNECEDOR.FORNEC_MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID WHERE TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT LIKE '%".$FORNEC_NOMEFANT."%' ORDER BY TAB_ADM_FORNECEDOR.FORNEC_NOME ASC limit $startAt, $byPage;", $db);
			}
			if($filter == 3) {
				if(isset($_POST["filter"])):
					$FORNEC_NOMERESP = $_POST['FORNEC_NOMERESP'];
				else:
					$FORNEC_NOMERESP = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID FROM TAB_ADM_FORNECEDOR WHERE TAB_ADM_FORNECEDOR.FORNEC_NOMERESP LIKE '%".$FORNEC_NOMERESP."%';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_FORNECEDOR.FORNEC_CPFCNPJ, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FORNEC_MUNICIPIO_DESC, TAB_APOIO_UF.SIGLA AS FORNEC_MUNICIPIO_DESC_UF FROM TAB_ADM_FORNECEDOR LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_ADM_FORNECEDOR.FORNEC_MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID WHERE TAB_ADM_FORNECEDOR.FORNEC_NOMERESP LIKE '%".$FORNEC_NOMERESP."%' ORDER BY TAB_ADM_FORNECEDOR.FORNEC_NOME ASC limit $startAt, $byPage;", $db);
			}
			if($filter == 4) {
				if(isset($_POST["filter"])):
					$FORNEC_MUNICIPIO = $_POST['FORNEC_MUNICIPIO'];
				else:
					$FORNEC_MUNICIPIO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID FROM TAB_ADM_FORNECEDOR WHERE TAB_ADM_FORNECEDOR.FORNEC_MUNICIPIO = '$FORNEC_MUNICIPIO';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_ADM_FORNECEDOR.FORNEC_ID, TAB_ADM_FORNECEDOR.FORNEC_NOME, TAB_ADM_FORNECEDOR.FORNEC_NOMEFANT, TAB_ADM_FORNECEDOR.FORNEC_CPFCNPJ, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FORNEC_MUNICIPIO_DESC, TAB_APOIO_UF.SIGLA AS FORNEC_MUNICIPIO_DESC_UF FROM TAB_ADM_FORNECEDOR LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_ADM_FORNECEDOR.FORNEC_MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID LEFT OUTER JOIN TAB_APOIO_UF ON TAB_APOIO_MUNICIPIOS.UF = TAB_APOIO_UF.ID WHERE TAB_ADM_FORNECEDOR.FORNEC_MUNICIPIO = '$FORNEC_MUNICIPIO' ORDER BY TAB_ADM_FORNECEDOR.FORNEC_NOME ASC limit $startAt, $byPage;", $db);
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
								<li><a href="#">Listagem de Fornecedores</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_fornecedor.php" method="post" name="filtro_fornecedor" onSubmit="return validaForm()">
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
                                    <option value="1">Filtrar Por Razão Social/Nome</option>
                                    <option value="2">Filtrar Por Nome Fantasia</option>
                                    <option value="3">Filtrar Por Nome do Responsável</option>
                                    <option value="4">Filtrar Por Município</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
										<input type="text" name="FORNEC_NOME" class="form-control" id="exampleInput" placeholder="Digite a razão social...">
                                    </div>
                                    <div id="2">
										<input type="text" name="FORNEC_NOMEFANT" class="form-control" id="exampleInput" placeholder="Digite o nome fantasia...">
                                    </div>
                                    <div id="3">
										<input type="text" name="FORNEC_NOMERESP" class="form-control" id="exampleInput" placeholder="Digite o nome do responsável...">
                                    </div>
                                    <div id="4">
                                        <select name="FORNEC_MUNICIPIO" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_MUNICIPIOS=mysql_fetch_array($sql_MUNICIPIOS)) { ?>
                                            <option value="<?php echo $vetor_MUNICIPIOS['ID'] ?>"><?php echo $vetor_MUNICIPIOS['DESCRICAO'].'/'.$vetor_MUNICIPIOS['SIGLA']; ?></option><?php } ?>
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
            <div><a href="cadastrar_fornecedor.php"><img src="imgs/adicionar.png" border="0"></a><br/><br/></div>            <table id="table-sm" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th width="1">Cod.</th>
                        <th>Razão Social/Nome</th>
                        <th>Nome Fantasia</th>
                        <th>C.P.F./C.N.P.J.</th>
                        <th>Município</th>
                        <th width="75" valign="center"><a class="fancybox fancybox.ajax" href="excel_fornecedor.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['FORNEC_ID']; ?></td>
                        <td><?php echo $vetor['FORNEC_NOME']; ?></td>
                        <td><?php echo $vetor['FORNEC_NOMEFANT']; ?></td>
                        <td><?php echo $vetor['FORNEC_CPFCNPJ']; ?></td>
                        <td><?php echo $vetor['FORNEC_MUNICIPIO_DESC'].'/'.$vetor['FORNEC_MUNICIPIO_DESC_UF']; ?></td>
                        <td><a class="fancybox fancybox.ajax" href="alterar_fornecedor.php?id=<?php echo $vetor['FORNEC_ID']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a> <a class="fancybox fancybox.ajax" href="recebe_excluir_fornecedor.php?id=<?php echo $vetor['FORNEC_ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_fornecedor.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_fornecedor.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_fornecedor.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_fornecedor.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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