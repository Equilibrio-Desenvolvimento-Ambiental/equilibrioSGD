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
			$sql_TECNICOS = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC", $db);
			$sql_GRUPOS = mysql_query("select * from TAB_APOIO_PLAN_GRUPOS order by DESCRICAO ASC", $db);
			$sql_FAMILIAS = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_APOIO_BENEFICIOS.DESCRICAO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO from TAB_415421_FAMILIAS left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID order by TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc;", $db);
			if(isset($_POST["filter"])){
				$filter = $_POST["filter"];
				if($filter == 1) { $_SESSION["lastfilter"] = $_POST["FAMESP_FAMILIA"]; }
				if($filter == 2) { $_SESSION["lastfilter"] = $_POST["FAMESP_TECNICO"]; }
				if($filter == 3) { $_SESSION["lastfilter"] = $_POST["FAMESP_GRUPO"]; }
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
			$byPage = 15;
			$startAt = ($page*$byPage)-$byPage;
			if($filter == 0){
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMESPECIAIS.FAMESP_CODIGO from TAB_415421_FAMESPECIAIS;", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMESPECIAIS.FAMESP_CODIGO, TAB_APOIO_TECNICOS.DESCRICAO as FAMESP_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO as FAMESP_GRUPO_DESC, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMESP_BENEFICIO_DESC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO from TAB_415421_FAMESPECIAIS left outer join TAB_415421_FAMILIAS on TAB_415421_FAMESPECIAIS.FAMESP_FAMILIA = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_TECNICOS on TAB_415421_FAMESPECIAIS.FAMESP_TECNICO = TAB_APOIO_TECNICOS.ID left outer join TAB_APOIO_PLAN_GRUPOS on TAB_415421_FAMESPECIAIS.FAMESP_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID order by TAB_APOIO_TECNICOS.DESCRICAO asc, TAB_APOIO_PLAN_GRUPOS.DESCRICAO asc, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$FAMESP_FAMILIA = $_POST['FAMESP_FAMILIA'];
				else:
					$FAMESP_FAMILIA = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMESPECIAIS.FAMESP_CODIGO from TAB_415421_FAMESPECIAIS where TAB_415421_FAMESPECIAIS.FAMESP_FAMILIA = '$FAMESP_FAMILIA';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMESPECIAIS.FAMESP_CODIGO, TAB_APOIO_TECNICOS.DESCRICAO as FAMESP_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO as FAMESP_GRUPO_DESC, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMESP_BENEFICIO_DESC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO from TAB_415421_FAMESPECIAIS left outer join TAB_415421_FAMILIAS on TAB_415421_FAMESPECIAIS.FAMESP_FAMILIA = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_TECNICOS on TAB_415421_FAMESPECIAIS.FAMESP_TECNICO = TAB_APOIO_TECNICOS.ID left outer join TAB_APOIO_PLAN_GRUPOS on TAB_415421_FAMESPECIAIS.FAMESP_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID where TAB_415421_FAMESPECIAIS.FAMESP_FAMILIA = '$FAMESP_FAMILIA' order by TAB_APOIO_TECNICOS.DESCRICAO asc, TAB_APOIO_PLAN_GRUPOS.DESCRICAO asc, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 2) {
				if(isset($_POST["filter"])):
					$FAMESP_TECNICO = $_POST['FAMESP_TECNICO'];
				else:
					$FAMESP_TECNICO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMESPECIAIS.FAMESP_CODIGO from TAB_415421_FAMESPECIAIS where TAB_415421_FAMESPECIAIS.FAMESP_TECNICO = '$FAMESP_TECNICO';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMESPECIAIS.FAMESP_CODIGO, TAB_APOIO_TECNICOS.DESCRICAO as FAMESP_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO as FAMESP_GRUPO_DESC, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMESP_BENEFICIO_DESC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO from TAB_415421_FAMESPECIAIS left outer join TAB_415421_FAMILIAS on TAB_415421_FAMESPECIAIS.FAMESP_FAMILIA = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_TECNICOS on TAB_415421_FAMESPECIAIS.FAMESP_TECNICO = TAB_APOIO_TECNICOS.ID left outer join TAB_APOIO_PLAN_GRUPOS on TAB_415421_FAMESPECIAIS.FAMESP_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID where TAB_415421_FAMESPECIAIS.FAMESP_TECNICO = '$FAMESP_TECNICO' order by TAB_APOIO_TECNICOS.DESCRICAO asc, TAB_APOIO_PLAN_GRUPOS.DESCRICAO asc, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 3) {
				if(isset($_POST["filter"])):
					$FAMESP_GRUPO = $_POST['FAMESP_GRUPO'];
				else:
					$FAMESP_GRUPO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMESPECIAIS.FAMESP_CODIGO from TAB_415421_FAMESPECIAIS where TAB_415421_FAMESPECIAIS.FAMESP_GRUPO = '$FAMESP_GRUPO';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMESPECIAIS.FAMESP_CODIGO, TAB_APOIO_TECNICOS.DESCRICAO as FAMESP_TECNICO_DESC, TAB_APOIO_PLAN_GRUPOS.DESCRICAO as FAMESP_GRUPO_DESC, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMESP_BENEFICIO_DESC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO from TAB_415421_FAMESPECIAIS left outer join TAB_415421_FAMILIAS on TAB_415421_FAMESPECIAIS.FAMESP_FAMILIA = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_TECNICOS on TAB_415421_FAMESPECIAIS.FAMESP_TECNICO = TAB_APOIO_TECNICOS.ID left outer join TAB_APOIO_PLAN_GRUPOS on TAB_415421_FAMESPECIAIS.FAMESP_GRUPO = TAB_APOIO_PLAN_GRUPOS.ID where TAB_415421_FAMESPECIAIS.FAMESP_GRUPO = '$FAMESP_GRUPO' order by TAB_APOIO_TECNICOS.DESCRICAO asc, TAB_APOIO_PLAN_GRUPOS.DESCRICAO asc, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
			}
?>
<?php require_once("includes/header-completo.php");?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
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
							<h3>Gestão do Projetos 4.1.5 - Reparação Rural / 4.2.1 - ATES / Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio <?php echo $filter; ?></a></li>
								<li><a href="#">Listagem de Familias Espciais (Agenda) - v.1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_familias_especiais.php" method="post" name="form_consulta" onSubmit="return validaForm()">
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
                                    <option value="1">Filtrar Por Família</option>
                                    <option value="2">Filtrar Por Técnico</option>
                                    <option value="3">Filtrar Por Grupo</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
                                        <select name="FAMESP_FAMILIA" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_FAMILIAS=mysql_fetch_array($sql_FAMILIAS)) { ?>
                                            <option value="<?php echo $vetor_FAMILIAS['FAMILIA_CODIGO']; ?>"><?php echo $vetor_FAMILIAS['FAMILIA_BENEFICIARIO'].' ('.$vetor_FAMILIAS['DESCRICAO'].')'; ?></option><?php } ?>
                                        </select>
                                    </div>
                                    <div id="2">
                                        <select name="FAMESP_TECNICO" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) { ?>
                                            <option value="<?php echo $vetor_TECNICOS['ID'] ?>"><?php echo $vetor_TECNICOS['DESCRICAO'] ?></option><?php } ?>
                                        </select>
                                    </div>
                                    <div id="3">
                                        <select name="FAMESP_GRUPO" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_GRUPOS=mysql_fetch_array($sql_GRUPOS)) { ?>
                                            <option value="<?php echo $vetor_GRUPOS['ID'] ?>"><?php echo $vetor_GRUPOS['DESCRICAO'] ?></option><?php } ?>
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
			<div><a href="cadastrar_familias_especiais.php"><img src="imgs/adicionar.png" border="0"></a><br/><br/></div>
            <table id="table-sm" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th width="1">Cod.</th>
                        <th>Beneficiário/Produtor</th>
                        <th>Benefício</th>
                        <th>Técnico</th>
                        <th>Grupo</th>
                        <th width="75" valign="center"><a class="fancybox fancybox.ajax" href="excel_familias_especiais.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['FAMESP_CODIGO']; ?></td>
                        <td><?php echo $vetor['FAMILIA_BENEFICIARIO']; ?></td>
                        <td><?php echo $vetor['FAMESP_BENEFICIO_DESC']; ?></td>
                        <td><?php echo $vetor['FAMESP_TECNICO_DESC']; ?></td>
                        <td><?php echo $vetor['FAMESP_GRUPO_DESC']; ?></td>
                        <td><a class="fancybox fancybox.ajax" href="alterar_familias_especiais.php?id=<?php echo $vetor['FAMESP_CODIGO']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a> <a class="fancybox fancybox.ajax" href="recebe_excluir_familias_especiais.php?id=<?php echo $vetor['FAMESP_CODIGO']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_familias_especiais.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_familias_especiais.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_familias_especiais.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_familias_especiais.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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