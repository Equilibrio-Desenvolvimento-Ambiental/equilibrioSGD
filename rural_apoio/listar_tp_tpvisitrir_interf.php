<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 4;
	session_start();
	if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
		echo "Esta área é restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		$sql_permissao = mysql_query("SELECT * FROM TAB_MAIN_USERS_PROJECTS WHERE ID_PROJETO = '$projeto' AND ID_USER = '$_SESSION[user]';", $db) or die(mysql_error());
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			if(isset($_POST["filter"])){
				$filter = $_POST["filter"];
				if($filter == 1) { $_SESSION["lastfilter"] = $_POST["DESCRICAO"]; }
				if($filter == 2) { $_SESSION["lastfilter"] = $_POST["ATIVO"]; }
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
				$sqlTotalRecords = mysql_query("SELECT ID FROM TAB_APOIO_TPVISITRIR_INTERF;", $db) or die(mysql_error());
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage);
				$sql = mysql_query("SELECT * FROM TAB_APOIO_TPVISITRIR_INTERF ORDER BY DESCRICAO ASC LIMIT $startAt, $byPage;", $db) or die(mysql_error());
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$DESCRICAO = $_POST['DESCRICAO'];
				else:
					$DESCRICAO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT ID FROM TAB_APOIO_TPVISITRIR_INTERF WHERE DESCRICAO LIKE '%".$DESCRICAO."%';", $db) or die(mysql_error());
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT * FROM TAB_APOIO_TPVISITRIR_INTERF WHERE DESCRICAO LIKE '%".$DESCRICAO."%' ORDER BY DESCRICAO ASC LIMIT $startAt, $byPage;", $db) or die(mysql_error());
			}
			if($filter == 2) {
				if(isset($_POST["filter"])):
					$ATIVO = $_POST['ATIVO'];
				else:
					$ATIVO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT ID FROM TAB_APOIO_TPVISITRIR_INTERF WHERE ATIVO = ".$ATIVO.";", $db) or die(mysql_error());
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT * FROM TAB_APOIO_TPVISITRIR_INTERF WHERE ATIVO = ".$ATIVO." ORDER BY DESCRICAO ASC LIMIT $startAt, $byPage;", $db) or die(mysql_error());
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
							<h3>Gestão de Dados dos Projetos 4.1.5, 4.2.1 e Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Listagem de Tipos de Atividades do Projeto Ribeirinho (Interfaces) - v 1.1.0.0</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_tp_tpvisitrir_interf.php" method="post" name="listar_tp_tpvisitrir_interf" onSubmit="return validaForm()" id="listar_tp_tpvisitrir_interf">
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
                                    <option value="1">Filtrar por Descrição</option>
                                    <option value="2">Filtrar Por Status</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
										<input type="text" name="DESCRICAO" class="form-control" id="exampleInput" placeholder="Digite a descrição...">
                                    </div>
                                    <div id="2">
                                        <select name="ATIVO" id="ATIVO" class="form-control">
                                            <option value="1">ATIVO</option><option value="2">INATIVO</option>
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
            <div><a href="cadastrar_tp_tpvisitrir_interf.php"><img src="imgs/adicionar.png" border="0"></a><br/><br/></div>
            <table id="table-sm" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th width="1">Cod.</th>
                        <th>Descrição</th>
                        <th>Ativo?</th>
                        <th width="100" valign="center"><a class="fancybox fancybox.ajax" href="excel_tp_tpvisitrir_interf.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['ID']; ?></td>
                        <td><?php echo $vetor['DESCRICAO']; ?></td>
                        <td><?php if (strcasecmp($vetor['ATIVO'],'1') == 0) { echo "SIM"; } else { echo "NÃO"; } ?></td>
                        <td><a class="fancybox fancybox.ajax" href="alterar_tp_tpvisitrir_interf.php?id=<?php echo $vetor['ID']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a> <a class="fancybox fancybox.ajax" href="recebe_excluir_tp_tpvisitrir_interf.php?id=<?php echo $vetor['ID']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_tp_tpvisitrir_interf.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_tp_tpvisitrir_interf.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_tp_tpvisitrir_interf.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_tp_tpvisitrir_interf.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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