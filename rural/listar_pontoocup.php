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
			$sql_MUNICIPIOS = mysql_query("select * from TAB_APOIO_MUNICIPIOS order by DESCRICAO ASC", $db);
			if(isset($_POST["filter"])){
				$filter = $_POST["filter"];
				if($filter == 1) { $_SESSION["lastfilter"] = $_POST["POCUP_PROCESSO"]; }
				if($filter == 2) { $_SESSION["lastfilter"] = $_POST["POCUP_MUNICIPIO"]; }
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
				$sqlTotalRecords = mysql_query("select TAB_RIR_PONTOOCUP.POCUP_CODIGO from TAB_RIR_PONTOOCUP;", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_RIR_PONTOOCUP.POCUP_CODIGO, TAB_RIR_PONTOOCUP.POCUP_PROCESSO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS POCUP_MUNICIPIO_DESC, TAB_APOIO_SETORATEND.DESCRICAO AS POCUP_SETOR_DESC from TAB_RIR_PONTOOCUP left outer join TAB_APOIO_MUNICIPIOS on TAB_RIR_PONTOOCUP.POCUP_MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_APOIO_SETORATEND on TAB_RIR_PONTOOCUP.POCUP_SETOR = TAB_APOIO_SETORATEND.ID order by TAB_RIR_PONTOOCUP.POCUP_PROCESSO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$POCUP_PROCESSO = $_POST['POCUP_PROCESSO'];
				else:
					$POCUP_PROCESSO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_RIR_PONTOOCUP.POCUP_CODIGO from TAB_RIR_PONTOOCUP where TAB_RIR_PONTOOCUP.POCUP_PROCESSO like '%".$POCUP_PROCESSO."%';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_RIR_PONTOOCUP.POCUP_CODIGO, TAB_RIR_PONTOOCUP.POCUP_PROCESSO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS POCUP_MUNICIPIO_DESC, TAB_APOIO_SETORATEND.DESCRICAO AS POCUP_SETOR_DESC from TAB_RIR_PONTOOCUP left outer join TAB_APOIO_MUNICIPIOS on TAB_RIR_PONTOOCUP.POCUP_MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_APOIO_SETORATEND on TAB_RIR_PONTOOCUP.POCUP_SETOR = TAB_APOIO_SETORATEND.ID where TAB_RIR_PONTOOCUP.POCUP_PROCESSO like '%".$POCUP_PROCESSO."%' order by TAB_RIR_PONTOOCUP.POCUP_PROCESSO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 2) {
				if(isset($_POST["filter"])):
					$POCUP_MUNICIPIO = $_POST['POCUP_MUNICIPIO'];
				else:
					$POCUP_MUNICIPIO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_RIR_PONTOOCUP.POCUP_CODIGO from TAB_RIR_PONTOOCUP where TAB_RIR_PONTOOCUP.POCUP_MUNICIPIO = '$POCUP_MUNICIPIO';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_RIR_PONTOOCUP.POCUP_CODIGO, TAB_RIR_PONTOOCUP.POCUP_PROCESSO, TAB_APOIO_MUNICIPIOS.DESCRICAO AS POCUP_MUNICIPIO_DESC, TAB_APOIO_SETORATEND.DESCRICAO AS POCUP_SETOR_DESC from TAB_RIR_PONTOOCUP left outer join TAB_APOIO_MUNICIPIOS on TAB_RIR_PONTOOCUP.POCUP_MUNICIPIO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_APOIO_SETORATEND on TAB_RIR_PONTOOCUP.POCUP_SETOR = TAB_APOIO_SETORATEND.ID where TAB_RIR_PONTOOCUP.POCUP_MUNICIPIO = '$POCUP_MUNICIPIO' order by TAB_RIR_PONTOOCUP.POCUP_PROCESSO asc limit $startAt, $byPage;", $db);
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
							<h3>Gestão dos Projetos 4.1.5 e 4.2.1 - Reparação Rural e ATES</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Listagem de Pontos de Ocupação - v.1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_pontoocup.php" method="post" name="form_consulta" onSubmit="return validaForm()">
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
                                    <option value="1">Filtrar Por Número do Processo</option>
                                    <option value="2">Filtrar Por Município</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
										<input type="text" name="POCUP_PROCESSO" class="form-control" id="exampleInput" placeholder="Digite o número do processo...">
                                    </div>
                                    <div id="2">
                                        <select name="POCUP_MUNICIPIO" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_MUNICIPIOS=mysql_fetch_array($sql_MUNICIPIOS)) { ?>
                                            <option value="<?php echo $vetor_MUNICIPIOS['ID'] ?>"><?php echo $vetor_MUNICIPIOS['DESCRICAO'] ?></option><?php } ?>
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
            
            <table id="table-sm" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th width="1">Cod.</th>
                        <th>Número Processo Ponto de Ocupação</th>
                        <th>Município</th>
                        <th>Setor</th>
                        <th width="120" valign="center"><a class="fancybox fancybox.ajax" href="excel_pontoocup.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['POCUP_CODIGO']; ?></td>
                        <td><?php echo $vetor['POCUP_PROCESSO']; ?></td>
                        <td><?php echo $vetor['POCUP_MUNICIPIO_DESC']; ?></td>
                        <td><?php echo $vetor['POCUP_SETOR_DESC']; ?></td>
                        <td><a class="fancybox fancybox.ajax" href="alterar_pontoocup.php?id_ponto=<?php echo $vetor['POCUP_CODIGO']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a> <a class="fancybox fancybox.ajax" href="recebe_excluir_pontoocup.php?id_ponto=<?php echo $vetor['POCUP_CODIGO']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_pontoocup.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_pontoocup.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_pontoocup.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_pontoocup.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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