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
			function reverse_date( $date ){
				return (strstr($date,'-')) ? implode('/', array_reverse(explode('-', $date))) : implode('-', array_reverse(explode('/', $date))); }
			$sql_projeto = mysql_query("select B.NOME, B.LINKPASTA from TAB_MAIN_USERS_PROJECTS A, TAB_MAIN_PROJECTS B where A.ID_PROJETO = B.ID_PROJETO and A.ID_USER = '$_SESSION[user]' order by B.ORDEM", $db);
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
							<h3>Seja bem vindo <?php echo $_SESSION['nome']; ?></h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li><li><a href="#">Inicio</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
 			<div class="row">
	            <div class="col-xl-6 dahsboard-column">
	                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
						<header class="widget-header-dark">Projetos</header>
	                    <div class="box-typical-body panel-body">
                            <table id="table-sm" class="table table-bordered table-hover table-sm">
                                <thead><tr><th></th></tr></thead>
                                <tbody>
                                <tr><td>Abaixo listamos seus projetos:</td></tr>
                                <tr><td></td></tr>
                                <?php 
                                    while ($vetor_projeto=mysql_fetch_array($sql_projeto)) { 
                                ?>
                                <tr>
                                    <td><a href="<?php echo $vetor_projeto['LINKPASTA']; ?>"><?php echo $vetor_projeto['NOME']; ?></a></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
	                    </div><!--.box-typical-body-->
	                </section><!--.box-typical-dashboard-->
	            </div><!--.col-->
	            <div class="col-xl-6 dahsboard-column">&nbsp;</div><!--.col-->
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