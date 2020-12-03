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
			if(isset($_GET["page"])):
				$page = $_GET["page"];
			else:
				$page = 1;
			endif;
			$byPage = 20;
			$startAt = ($page*$byPage)-$byPage;
			$sqlTotalRecords = mysql_query("SELECT TAB_415421_EVENTOS.EVENTOS_CODIGO FROM TAB_415421_EVENTOS WHERE TAB_415421_EVENTOS.EVENTOS_CHECKED = 2;", $db);
			$totalRecords=mysql_num_rows($sqlTotalRecords);
			$totalPages = ceil($totalRecords/$byPage); 
			$sql = mysql_query("SELECT TAB_415421_EVENTOS.EVENTOS_CODIGO, TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO AS FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO AS FAMILIA_MUNICIPIODESTINO_DESC, TAB_415421_EVENTOS.EVENTOS_DATA FROM TAB_415421_EVENTOS LEFT OUTER JOIN TAB_415421_FAMILIAS ON  TAB_415421_EVENTOS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO LEFT OUTER JOIN TAB_APOIO_BENEFICIOS ON TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID LEFT OUTER JOIN TAB_APOIO_MUNICIPIOS ON TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID WHERE TAB_415421_EVENTOS.EVENTOS_CHECKED = 2 ORDER BY TAB_415421_EVENTOS.EVENTOS_DATA DESC, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO ASC limit $startAt, $byPage;", $db);
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
							<h3>Familias - Projetos 4.1.5 / 4.2.1 / Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Listagem de Relatórios para Verificação - v.1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
            <table id="table-sm" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th width="1">Cod.</th>
                        <th>Beneficiário/Produtor</th>
                        <th>Benefício</th>
                        <th>Município</th>
                        <th>Último Evento</th>
                        <th width="100" valign="center">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['EVENTOS_CODIGO']; ?></td>
                        <td><?php echo $vetor['FAMILIA_BENEFICIARIO']; ?></td>
                        <td><?php echo $vetor['FAMILIA_BENEFICIO_DESC']; ?></td>
                        <td><?php echo $vetor['FAMILIA_MUNICIPIODESTINO_DESC']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($vetor['EVENTOS_DATA'])); ?></td>
                        <td><a class="fancybox fancybox.ajax" href="recebe_check_eventos.php?id_evento=<?php echo $vetor['EVENTOS_CODIGO']; ?>"><img src="imgs/okay.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('cadastrar_dados_eventos.php?id_evento=<?php echo $vetor["EVENTOS_CODIGO"];?>&id_familia=<?php echo $vetor["FAMILIA_CODIGO"];?>','Dados do Evento', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_familias_relatorio.php?page=1"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_familias_relatorio.php?page='.$pagePrevious.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_familias_relatorio.php?page='.$pageNext.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_familias_relatorio.php?page='.$totalPages.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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