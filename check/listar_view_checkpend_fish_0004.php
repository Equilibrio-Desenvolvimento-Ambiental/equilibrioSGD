<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 9;
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
				if($filter == 1) { $_SESSION["lastfilter"] = $_POST["FISH_FAM_CHEFE_NOME"]; }
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
				$sqlTotalRecords = mysql_query("SELECT VIEW_CHECKPEND_FISH_0004.FISH_FAM_ID FROM VIEW_CHECKPEND_FISH_0004;", $db) or die(mysql_error());
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT * FROM VIEW_CHECKPEND_FISH_0004 ORDER BY VIEW_CHECKPEND_FISH_0004.FISH_FAM_QUEST ASC LIMIT $startAt, $byPage;", $db) or die(mysql_error());
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$FISH_FAM_CHEFE_NOME = $_POST['FISH_FAM_CHEFE_NOME'];
				else:
					$FISH_FAM_CHEFE_NOME = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("SELECT VIEW_CHECKPEND_FISH_0004.FISH_FAM_ID FROM VIEW_CHECKPEND_FISH_0004 WHERE VIEW_CHECKPEND_FISH_0004.FISH_FAM_CHEFE_NOME LIKE '%".$FISH_FAM_CHEFE_NOME."%';", $db) or die(mysql_error());
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("SELECT * FROM VIEW_CHECKPEND_FISH_0004 WHERE VIEW_CHECKPEND_FISH_0004.FISH_FAM_CHEFE_NOME LIKE '%".$FISH_FAM_CHEFE_NOME."%' ORDER BY VIEW_CHECKPEND_FISH_0004.FISH_FAM_QUEST ASC LIMIT $startAt, $byPage;", $db) or die(mysql_error());
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
							<h3>Verificação de Pendência de Dados</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">ATES Pescadores</a></li>
								<li><a href="#">View 0004 - Verificação das Famílias que tiveram o motor e/ou a rabeta entregues e não possuem o recibo assinado, digitalizado e anexado</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_view_checkpend_fish_0004.php" method="post" name="listar_view_checkpend_fish_0004" onSubmit="return validaForm()" id="listar_view_checkpend_fish_0004">
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
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
										<input type="text" name="FISH_FAM_CHEFE_NOME" class="form-control" id="FISH_FAM_CHEFE_NOME" placeholder="Digite o nome do Beneficiário...">
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
                        <th>Questionário</th>
                        <th>Beneficiário/Pescador</th>
                        <th width="30px" valign="center"><a class="fancybox fancybox.ajax" href="excel_view_checkpend_fish_0004.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['FISH_FAM_QUEST']; ?></td>
                        <td><?php echo $vetor['FISH_FAM_CHEFE_NOME']; ?></td>
                        <td width="30px" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('../pescadores/alterar_fish_familias.php?id_familia=<?php echo $vetor['FISH_FAM_ID'];?>','Dados da Família', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_view_checkpend_fish_0004.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_view_checkpend_fish_0004.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_view_checkpend_fish_0004.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_view_checkpend_fish_0004.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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