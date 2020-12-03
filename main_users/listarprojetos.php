<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 1;
	session_start();
	if($_SESSION['nivel'] != 1) {
		echo"Você não tem permissão para ficar nesta area ".$_SESSION['nome'];
		echo ". Esta é uma área restrita. Clique ";
		echo "<a href=\"../index.html\">aqui</a>";
		echo " para fazer o LOGIN.";
		exit;
	} else {
		if(!isset($_SESSION['user']) || !isset($_SESSION['login']) || !isset($_SESSION['senha']) || !isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]'", $db);
			$num_permissao = mysql_num_rows($sql_permissao);
			if ($num_permissao == 0) {
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
				$byPage = 5;
				$startAt = ($page*$byPage)-$byPage;
				$sqlTotalRecords = mysql_query("select * from TAB_MAIN_PROJECTS", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
 				$sql = mysql_query("select * from TAB_MAIN_PROJECTS order by NOME asc", $db);
?>
<?php require_once("includes/header-completo.php");?>
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
							<h3>Controle de Projetos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Listagem de Projetos</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
            <div><a href="cadastrarprojeto.php"><img src="imgs/adicionar.png" border="0"></a><br/><br/></div>
            <table id="table-sm" class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th width="1">Cod.</th>
                        <th>Nome</th>
                        <th>Ordenação</th>
                        <th width="120"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['ID_PROJETO']; ?></td>
                        <td><?php echo $vetor['NOME']; ?></td>
                        <td><?php echo $vetor['ORDEM']; ?></td>
                        <td><a class="fancybox fancybox.ajax" href="alterarprojeto.php?id=<?php echo $vetor['ID_PROJETO']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a> <a class="fancybox fancybox.ajax" href="recebe_excluirprojeto.php?id=<?php echo $vetor['ID_PROJETO']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listarprojetos.php?page=1"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listarprojetos.php?page='.$pagePrevious.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listarprojetos.php?page='.$pageNext.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listarprojetos.php?page='.$totalPages.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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
}
?>