﻿<?php
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
			$sqlALDEIAS = mysql_query("select * from TAB_APOIO_INDIG_ALDEIA order by DESCRICAO ASC", $db) or die(mysql_error());
			if(isset($_POST["filter"])){
				$filter = $_POST["filter"];
				if($filter == 1) { $_SESSION["lastfilter"] = mb_convert_case($_POST["INDIG_FAM_NOME"], MB_CASE_UPPER, 'UTF-8'); }
				if($filter == 2) { $_SESSION["lastfilter"] = $_POST["INDIG_FAM_ALDEIA"]; }
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
				$sqlTotalRecords = mysql_query("SELECT INDIG_FAM_ID FROM TAB_INDIG_FAMILIAS;", $db) or die(mysql_error());
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage);
				$sql = mysql_query("SELECT TAB_INDIG_FAMILIAS.INDIG_FAM_ID, TAB_INDIG_FAMILIAS.INDIG_FAM_NOME, TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA, TAB_APOIO_INDIG_ALDEIA.DESCRICAO AS INDIG_FAM_ALDEIA_DESC FROM TAB_INDIG_FAMILIAS LEFT OUTER JOIN TAB_APOIO_INDIG_ALDEIA ON TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA = TAB_APOIO_INDIG_ALDEIA.ID ORDER BY TAB_INDIG_FAMILIAS.INDIG_FAM_NOME ASC, TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA ASC LIMIT $startAt, $byPage;", $db) or die(mysql_error());
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$INDIG_FAM_NOME = $_POST['INDIG_FAM_NOME'];
				else:
					$INDIG_FAM_NOME = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT INDIG_FAM_ID FROM TAB_INDIG_FAMILIAS WHERE INDIG_FAM_NOME LIKE '%".$INDIG_FAM_NOME."%';", $db) or die(mysql_error());
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_INDIG_FAMILIAS.INDIG_FAM_ID, TAB_INDIG_FAMILIAS.INDIG_FAM_NOME, TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA, TAB_APOIO_INDIG_ALDEIA.DESCRICAO AS INDIG_FAM_ALDEIA_DESC FROM TAB_INDIG_FAMILIAS LEFT OUTER JOIN TAB_APOIO_INDIG_ALDEIA ON TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA = TAB_APOIO_INDIG_ALDEIA.ID WHERE INDIG_FAM_NOME LIKE '%".$INDIG_FAM_NOME."%' ORDER BY TAB_INDIG_FAMILIAS.INDIG_FAM_NOME ASC, TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA ASC LIMIT $startAt, $byPage;", $db) or die(mysql_error());
			}
			if($filter == 2) {
				if(isset($_POST["filter"])):
					$INDIG_FAM_ALDEIA = $_POST['INDIG_FAM_ALDEIA'];
				else:
					$INDIG_FAM_ALDEIA = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT INDIG_FAM_ID FROM TAB_INDIG_FAMILIAS WHERE INDIG_FAM_ALDEIA = '$INDIG_FAM_ALDEIA';", $db) or die(mysql_error());
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT TAB_INDIG_FAMILIAS.INDIG_FAM_ID, TAB_INDIG_FAMILIAS.INDIG_FAM_NOME, TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA, TAB_APOIO_INDIG_ALDEIA.DESCRICAO AS INDIG_FAM_ALDEIA_DESC FROM TAB_INDIG_FAMILIAS LEFT OUTER JOIN TAB_APOIO_INDIG_ALDEIA ON TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA = TAB_APOIO_INDIG_ALDEIA.ID WHERE INDIG_FAM_ALDEIA = '$INDIG_FAM_ALDEIA' ORDER BY TAB_INDIG_FAMILIAS.INDIG_FAM_NOME ASC, TAB_INDIG_FAMILIAS.INDIG_FAM_ALDEIA ASC LIMIT $startAt, $byPage;", $db) or die(mysql_error());
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
							<h3>Projetos de Atividades Produtivas - PAP / Projeto de Pesca Para Comercialização</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Listagem de Componentes Familiares Indígenas - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_indig_pessoas.php" method="post" name="form_consulta" onSubmit="return validaForm()">
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
                                    <option value="1">Filtrar por Nome</option>
                                    <option value="2">Filtrar por Aldeia</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
										<input type="text" name="INDIG_FAM_NOME" class="form-control" id="INDIG_FAM_NOME" placeholder="Digite o Nome...">
                                    </div>
                                    <div id="2">
                                        <select name="INDIG_FAM_ALDEIA" id="INDIG_FAM_ALDEIA" class="form-control">
                                            <?php while ($vetorALDEIAS=mysql_fetch_array($sqlALDEIAS)) { ?>
                                            <option value="<?php echo $vetorALDEIAS['ID'] ?>"><?php echo $vetorALDEIAS['DESCRICAO'] ?></option><?php } ?>
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
<!--            <div><a href="cadastrar_indig_pessoas.php"><img src="imgs/adicionar.png" border="0"></a><br/><br/></div> -->
            <table id="table-sm" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th width="1">Cod.</th>
                        <th>Nome</th>
                        <th>Aldeia</th>
                        <th width="100" valign="center"><a class="fancybox fancybox.ajax" href="excel_indig_pessoas.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['INDIG_FAM_ID']; ?></td>
                        <td><?php echo $vetor['INDIG_FAM_NOME']; ?></td>
                        <td><?php echo $vetor['INDIG_FAM_ALDEIA_DESC']; ?></td>
                        <td><a class="fancybox fancybox.ajax" href="alterar_indig_pessoas.php?INDIG_FAM_ID=<?php echo $vetor['INDIG_FAM_ID']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a> <a class="fancybox fancybox.ajax" href="recebe_excluir_indig_pessoas.php?INDIG_FAM_ID=<?php echo $vetor['INDIG_FAM_ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_indig_pessoas.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_indig_pessoas.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_indig_pessoas.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_indig_pessoas.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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