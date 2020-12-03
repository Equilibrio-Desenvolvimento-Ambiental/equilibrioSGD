<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 7;
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
			if(isset($_POST["filter"])){
				$filter = $_POST["filter"];
				if($filter == 1) { $_SESSION["lastfilter"] = mb_convert_case($_POST["FISH_FAM_CHEFE_NOME"], MB_CASE_UPPER, 'UTF-8'); }
				if($filter == 2) { $_SESSION["lastfilter"] = mb_convert_case($_POST["FISH_FAM_CONJ_NOME"], MB_CASE_UPPER, 'UTF-8'); }
				if($filter == 3) { $_SESSION["lastfilter"] = mb_convert_case($_POST["FISH_FAM_QUALQUER_NOME"], MB_CASE_UPPER, 'UTF-8'); }
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
			$byPage = 20;
			$startAt = ($page*$byPage)-$byPage;
			if($filter == 0){
				$sqlTotalRecords = mysql_query("select TAB_FISH_FAMILIAS.FISH_FAM_ID from TAB_FISH_FAMILIAS;", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME from TAB_FISH_FAMILIAS order by TAB_FISH_FAMILIAS.FISH_FAM_ID asc limit $startAt, $byPage;", $db);
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$FISH_FAM_CHEFE_NOME = mb_convert_case($_POST["FISH_FAM_CHEFE_NOME"], MB_CASE_UPPER, 'UTF-8');
				else:
					$FISH_FAM_CHEFE_NOME = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_FISH_FAMILIAS.FISH_FAM_ID from TAB_FISH_FAMILIAS where TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME like '%".$FISH_FAM_CHEFE_NOME."%';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME from TAB_FISH_FAMILIAS where TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME like '%".$FISH_FAM_CHEFE_NOME."%' order by TAB_FISH_FAMILIAS.FISH_FAM_ID asc limit $startAt, $byPage;", $db);
			}
			if($filter == 2) {
				if(isset($_POST["filter"])):
					$FISH_FAM_CONJ_NOME = mb_convert_case($_POST["FISH_FAM_CONJ_NOME"], MB_CASE_UPPER, 'UTF-8');
				else:
					$FISH_FAM_CONJ_NOME = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_FISH_FAMILIAS.FISH_FAM_ID from TAB_FISH_FAMILIAS where TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME like '%".$FISH_FAM_CONJ_NOME."%';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME from TAB_FISH_FAMILIAS where TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME like '%".$FISH_FAM_CONJ_NOME."%' order by TAB_FISH_FAMILIAS.FISH_FAM_ID asc limit $startAt, $byPage;", $db);
			}
			if($filter == 3) {
				if(isset($_POST["filter"])):
					$FISH_FAM_QUALQUER_NOME = mb_convert_case($_POST["FISH_FAM_QUALQUER_NOME"], MB_CASE_UPPER, 'UTF-8');
				else:
					$FISH_FAM_QUALQUER_NOME = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_FISH_FAMILIAS.FISH_FAM_ID from TAB_FISH_FAMILIAS where (TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME like '%".$FISH_FAM_QUALQUER_NOME."%') OR (TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME like '%".$FISH_FAM_QUALQUER_NOME."%');", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_FISH_FAMILIAS.FISH_FAM_ID, TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME, TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME from TAB_FISH_FAMILIAS where (TAB_FISH_FAMILIAS.FISH_FAM_CHEFE_NOME like '%".$FISH_FAM_QUALQUER_NOME."%') OR (TAB_FISH_FAMILIAS.FISH_FAM_CONJ_NOME like '%".$FISH_FAM_QUALQUER_NOME."%') order by TAB_FISH_FAMILIAS.FISH_FAM_ID asc limit $startAt, $byPage;", $db);
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
							<h3>Familias - Projetos de Atendimento dos Pescadores</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Listagem de Familias - v.1.0.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_fish_familias.php" method="post" name="form_consulta" onSubmit="return validaForm()">
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
                                    <option value="1">Filtrar Por Nome do Chefe</option>
                                    <option value="2">Filtrar Por Nome do Cônjuge</option>
                                    <option value="3">Filtrar Por Qualquer Nome</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
										<input type="text" name="FISH_FAM_CHEFE_NOME" class="form-control" id="FISH_FAM_CHEFE_NOME" placeholder="Digite o nome do Chefe da Família...">
                                    </div>
                                    <div id="2">
										<input type="text" name="FISH_FAM_CONJ_NOME" class="form-control" id="FISH_FAM_CONJ_NOME" placeholder="Digite o nome do Chefe da Família...">
                                    </div>
                                    <div id="3">
										<input type="text" name="FISH_FAM_QUALQUER_NOME" class="form-control" id="FISH_FAM_QUALQUER_NOME" placeholder="Digite o nome do Chefe da Família...">
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
                        <th>Beneficiário/Pescador</th>
                        <th>Cônjuge</th>
                        <th width="50" valign="center">A.R.</th>
                        <th width="75" valign="center"><a class="fancybox fancybox.ajax" href="excel_fish_familias.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['FISH_FAM_ID']; ?></td>
                        <?php
							if($filter == 1) {
								if(isset($_POST["filter"])):
									$search_filter = mb_convert_case($_POST["FISH_FAM_CHEFE_NOME"], MB_CASE_UPPER, 'UTF-8');
								else:
									$search_filter = $_SESSION['lastfilter'];
								endif;				
							}
							if($filter == 2) {
								if(isset($_POST["filter"])):
									$search_filter = mb_convert_case($_POST["FISH_FAM_CONJ_NOME"], MB_CASE_UPPER, 'UTF-8');
								else:
									$search_filter = $_SESSION['lastfilter'];
								endif;				
							}
							if($filter == 3) {
								if(isset($_POST["filter"])):
									$search_filter = mb_convert_case($_POST["FISH_FAM_QUALQUER_NOME"], MB_CASE_UPPER, 'UTF-8');
								else:
									$search_filter = $_SESSION['lastfilter'];
								endif;				
							}
						?>
                        <td><?php echo str_replace(mb_convert_case($search_filter, MB_CASE_UPPER, 'UTF-8'), '<font color=#FF0004><strong>'.mb_convert_case($search_filter, MB_CASE_UPPER, 'UTF-8').'</strong></font>', $vetor['FISH_FAM_CHEFE_NOME']); ?></td>
                        <td><?php echo str_replace(mb_convert_case($search_filter, MB_CASE_UPPER, 'UTF-8'), '<font color=#FF0004><strong>'.mb_convert_case($search_filter, MB_CASE_UPPER, 'UTF-8').'</strong></font>', $vetor['FISH_FAM_CONJ_NOME']); ?></td>
                        <td><a class="fancybox fancybox.ajax" href="relatorio_fish_remoto_formulario.php?id_familia=<?php echo $vetor['FISH_FAM_ID']; ?>"><img src="imgs/imprimir.png" width="25" height="25" border="0"></a></td>
						<td><a class="fancybox fancybox.ajax" href="alterar_fish_familias.php?id_familia=<?php echo $vetor['FISH_FAM_ID']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a> <a class="fancybox fancybox.ajax" href="recebe_fish_excluir_familias.php?id_familia=<?php echo $vetor['FISH_FAM_ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_fish_familias.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_fish_familias.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_fish_familias.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_fish_familias.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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