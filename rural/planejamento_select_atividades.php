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
		$sql_permissao = mysql_query("select * from TAB_MAIN_USERS_PROJECTS where ID_PROJETO = '$projeto' and ID_USER = '$_SESSION[user]';", $db);
		$num_busca = mysql_num_rows($sql_permissao);
		if ($num_busca == 0) {
			echo "Esta área é restrita. Clique ";
			echo "<a href=\"../index.html\">aqui</a>";
			echo " para fazer o LOGIN.";
			exit;
		} else {
			$sql_RGME = mysql_query("select * from TAB_APOIO_RGME order by ANO, MES asc;", $db);
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
							<h3>Gestão dos Projetos 4.1.5 / 4.2.1 / Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Geração de Visitas Mensais - RGM-E - v.1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="planejamento_generate_atividades.php" method="post" name="planejamento_generate_atividades">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Selecione o Mês para Gerar a relação de Visitas:</th>
                        </tr>
                    </thead>
                	<tbody>
                    	<tr>
                            <td>
                                <select name="rgme" id="rgme" class="form-control" required>
                                    <option value="0" selected>Selecione o Relatório desejado...</option>
                              		<?php while ($vetor_RGME=mysql_fetch_array($sql_RGME)) { ?>
                              			<option value="<?php echo $vetor_RGME['ID'] ?>"><?php echo $vetor_RGME['DESCRICAO']." - Período: ".date('d/m/Y', strtotime($vetor_RGME['DATA_INICIAL']))." até ".date('d/m/Y', strtotime($vetor_RGME['DATA_FINAL'])); ?></option>
                              <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </tbody>
				</table><br>
				<input name="gerar" class="float" type="image" src="imgs/gerar.png" value="Gerar" /></th>
            </form>
            </br>
		</div>
	</div>
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>