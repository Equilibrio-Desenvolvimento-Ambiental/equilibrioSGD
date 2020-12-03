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
			$sql_BENEFICIOS = mysql_query("select * from TAB_APOIO_BENEFICIOS order by DESCRICAO ASC", $db);
			$sql_MUNICIPIOS = mysql_query("select * from TAB_APOIO_MUNICIPIOS order by DESCRICAO ASC", $db);
			$sql_TECNICOS = mysql_query("select * from TAB_APOIO_TECNICOS order by DESCRICAO ASC", $db);
			if(isset($_POST["filter"])){
				$filter = $_POST["filter"];
				if($filter == 1) { $_SESSION["lastfilter"] = $_POST["FAMILIA_BENEFICIO"]; }
				if($filter == 2) { $_SESSION["lastfilter"] = $_POST["FAMILIA_NUMERO"]; }
				if($filter == 3) { $_SESSION["lastfilter"] = $_POST["FAMILIA_FUNDIARIO"]; }
				if($filter == 4) { $_SESSION["lastfilter"] = $_POST["FAMILIA_BENEFICIARIO"]; }
				if($filter == 5) { $_SESSION["lastfilter"] = $_POST["FAMILIA_MUNICIPIODESTINO"]; }
				if($filter == 6) { $_SESSION["lastfilter"] = $_POST["FAMILIA_TECNICO"]; }
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
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO from TAB_415421_FAMILIAS;", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TPATENDIMENTO01.DESCRICAO as ATEND_421,
TAB_APOIO_TPATENDIMENTO02.DESCRICAO as ATEND_415, TAB_APOIO_TPATENDIMENTO03.DESCRICAO as ATEND_RIR from TAB_415421_FAMILIAS left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_415421_DADOSGERAIS on TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO01 on TAB_415421_DADOSGERAIS.DADOS_ATEND421 = TAB_APOIO_TPATENDIMENTO01.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO02 on TAB_415421_DADOSGERAIS.DADOS_ATEND415 = TAB_APOIO_TPATENDIMENTO02.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO03 on TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = TAB_APOIO_TPATENDIMENTO03.ID order by TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$FAMILIA_BENEFICIO = $_POST['FAMILIA_BENEFICIO'];
				else:
					$FAMILIA_BENEFICIO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO from TAB_415421_FAMILIAS where TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = '$FAMILIA_BENEFICIO';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TPATENDIMENTO01.DESCRICAO as ATEND_421,
TAB_APOIO_TPATENDIMENTO02.DESCRICAO as ATEND_415, TAB_APOIO_TPATENDIMENTO03.DESCRICAO as ATEND_RIR from TAB_415421_FAMILIAS left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_415421_DADOSGERAIS on TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO01 on TAB_415421_DADOSGERAIS.DADOS_ATEND421 = TAB_APOIO_TPATENDIMENTO01.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO02 on TAB_415421_DADOSGERAIS.DADOS_ATEND415 = TAB_APOIO_TPATENDIMENTO02.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO03 on TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = TAB_APOIO_TPATENDIMENTO03.ID where TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = '$FAMILIA_BENEFICIO' order by TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 2) {
				if(isset($_POST["filter"])):
					$FAMILIA_NUMERO = $_POST['FAMILIA_NUMERO'];
				else:
					$FAMILIA_NUMERO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO from TAB_415421_FAMILIAS where TAB_415421_FAMILIAS.FAMILIA_NUMERO = '$FAMILIA_NUMERO';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TPATENDIMENTO01.DESCRICAO as ATEND_421,
TAB_APOIO_TPATENDIMENTO02.DESCRICAO as ATEND_415, TAB_APOIO_TPATENDIMENTO03.DESCRICAO as ATEND_RIR from TAB_415421_FAMILIAS left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_415421_DADOSGERAIS on TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO01 on TAB_415421_DADOSGERAIS.DADOS_ATEND421 = TAB_APOIO_TPATENDIMENTO01.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO02 on TAB_415421_DADOSGERAIS.DADOS_ATEND415 = TAB_APOIO_TPATENDIMENTO02.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO03 on TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = TAB_APOIO_TPATENDIMENTO03.ID where TAB_415421_FAMILIAS.FAMILIA_NUMERO = '$FAMILIA_NUMERO' order by TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 3) {
				if(isset($_POST["filter"])):
					$FAMILIA_FUNDIARIO = $_POST['FAMILIA_FUNDIARIO'];
				else:
					$FAMILIA_FUNDIARIO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO from TAB_415421_FAMILIAS where TAB_415421_FAMILIAS.FAMILIA_FUNDIARIO like '%".$FAMILIA_FUNDIARIO."%';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TPATENDIMENTO01.DESCRICAO as ATEND_421,
TAB_APOIO_TPATENDIMENTO02.DESCRICAO as ATEND_415, TAB_APOIO_TPATENDIMENTO03.DESCRICAO as ATEND_RIR from TAB_415421_FAMILIAS left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_415421_DADOSGERAIS on TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO01 on TAB_415421_DADOSGERAIS.DADOS_ATEND421 = TAB_APOIO_TPATENDIMENTO01.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO02 on TAB_415421_DADOSGERAIS.DADOS_ATEND415 = TAB_APOIO_TPATENDIMENTO02.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO03 on TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = TAB_APOIO_TPATENDIMENTO03.ID where TAB_415421_FAMILIAS.FAMILIA_FUNDIARIO like '%".$FAMILIA_FUNDIARIO."%' order by TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 4) {
				if(isset($_POST["filter"])):
					$FAMILIA_BENEFICIARIO = $_POST['FAMILIA_BENEFICIARIO'];
				else:
					$FAMILIA_BENEFICIARIO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO from TAB_415421_FAMILIAS where TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO like '%".$FAMILIA_BENEFICIARIO."%';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TPATENDIMENTO01.DESCRICAO as ATEND_421,
TAB_APOIO_TPATENDIMENTO02.DESCRICAO as ATEND_415, TAB_APOIO_TPATENDIMENTO03.DESCRICAO as ATEND_RIR from TAB_415421_FAMILIAS left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_415421_DADOSGERAIS on TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO01 on TAB_415421_DADOSGERAIS.DADOS_ATEND421 = TAB_APOIO_TPATENDIMENTO01.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO02 on TAB_415421_DADOSGERAIS.DADOS_ATEND415 = TAB_APOIO_TPATENDIMENTO02.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO03 on TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = TAB_APOIO_TPATENDIMENTO03.ID where TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO like '%".$FAMILIA_BENEFICIARIO."%' order by TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 5) {
				if(isset($_POST["filter"])):
					$FAMILIA_MUNICIPIODESTINO = $_POST['FAMILIA_MUNICIPIODESTINO'];
				else:
					$FAMILIA_MUNICIPIODESTINO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO from TAB_415421_FAMILIAS where TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = '$FAMILIA_MUNICIPIODESTINO';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TPATENDIMENTO01.DESCRICAO as ATEND_421,
TAB_APOIO_TPATENDIMENTO02.DESCRICAO as ATEND_415, TAB_APOIO_TPATENDIMENTO03.DESCRICAO as ATEND_RIR from TAB_415421_FAMILIAS left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_415421_DADOSGERAIS on TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO01 on TAB_415421_DADOSGERAIS.DADOS_ATEND421 = TAB_APOIO_TPATENDIMENTO01.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO02 on TAB_415421_DADOSGERAIS.DADOS_ATEND415 = TAB_APOIO_TPATENDIMENTO02.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO03 on TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = TAB_APOIO_TPATENDIMENTO03.ID where TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = '$FAMILIA_MUNICIPIODESTINO' order by TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
			}
			if($filter == 6) {
				if(isset($_POST["filter"])):
					$FAMILIA_TECNICO = $_POST['FAMILIA_TECNICO'];
				else:
					$FAMILIA_TECNICO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO from TAB_415421_FAMILIAS where TAB_415421_FAMILIAS.FAMILIA_TECNICO = '$FAMILIA_TECNICO';", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select TAB_415421_FAMILIAS.FAMILIA_CODIGO, TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO, TAB_APOIO_BENEFICIOS.DESCRICAO as FAMILIA_BENEFICIO_DESC, TAB_APOIO_MUNICIPIOS.DESCRICAO as FAMILIA_MUNICIPIODESTINO_DESC, TAB_APOIO_TPATENDIMENTO01.DESCRICAO as ATEND_421,
TAB_APOIO_TPATENDIMENTO02.DESCRICAO as ATEND_415, TAB_APOIO_TPATENDIMENTO03.DESCRICAO as ATEND_RIR from TAB_415421_FAMILIAS left outer join TAB_APOIO_BENEFICIOS on TAB_415421_FAMILIAS.FAMILIA_BENEFICIO = TAB_APOIO_BENEFICIOS.ID left outer join TAB_APOIO_MUNICIPIOS on TAB_415421_FAMILIAS.FAMILIA_MUNICIPIODESTINO = TAB_APOIO_MUNICIPIOS.ID left outer join TAB_415421_DADOSGERAIS on TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO01 on TAB_415421_DADOSGERAIS.DADOS_ATEND421 = TAB_APOIO_TPATENDIMENTO01.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO02 on TAB_415421_DADOSGERAIS.DADOS_ATEND415 = TAB_APOIO_TPATENDIMENTO02.ID left outer join TAB_APOIO_TPATENDIMENTO as TAB_APOIO_TPATENDIMENTO03 on TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = TAB_APOIO_TPATENDIMENTO03.ID where TAB_415421_FAMILIAS.FAMILIA_TECNICO = '$FAMILIA_TECNICO' order by TAB_415421_FAMILIAS.FAMILIA_BENEFICIARIO asc limit $startAt, $byPage;", $db);
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
							<h3>Familias - Projetos 4.1.5 / 4.2.1</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Listagem de Familias - v.1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_familias.php" method="post" name="form_consulta" onSubmit="return validaForm()">
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
                                    <option value="1">Filtrar Por Opção de Benefício</option>
                                    <option value="2">Filtrar Por Número da C/C</option>
                                    <option value="3">Filtrar Por Processo Fundiário</option>
                                    <option value="4">Filtrar Por Nome</option>
                                    <option value="5">Filtrar Por Município</option>
                                    <option value="6">Filtrar Por Técnico Responsável</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
                                        <select name="FAMILIA_BENEFICIO" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_BENEFICIOS=mysql_fetch_array($sql_BENEFICIOS)) { ?>
                                            <option value="<?php echo $vetor_BENEFICIOS['ID'] ?>"><?php echo $vetor_BENEFICIOS['DESCRICAO'] ?></option><?php } ?>
                                        </select>
                                    </div>
                                    <div id="2">
										<input type="text" name="FAMILIA_NUMERO" class="form-control" id="exampleInput" placeholder="Digite o número da C/C...">
                                    </div>
                                    <div id="3">
										<input type="text" name="FAMILIA_FUNDIARIO" class="form-control" id="exampleInput" placeholder="Digite o número do Processo Fundiário...">
                                    </div>
                                    <div id="4">
										<input type="text" name="FAMILIA_BENEFICIARIO" class="form-control" id="exampleInput" placeholder="Digite o nome do Beneficiário...">
                                    </div>
                                    <div id="5">
                                        <select name="FAMILIA_MUNICIPIODESTINO" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_MUNICIPIOS=mysql_fetch_array($sql_MUNICIPIOS)) { ?>
                                            <option value="<?php echo $vetor_MUNICIPIOS['ID'] ?>"><?php echo $vetor_MUNICIPIOS['DESCRICAO'] ?></option><?php } ?>
                                        </select>
                                    </div>
                                    <div id="6">
                                        <select name="FAMILIA_TECNICO" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) { ?>
                                            <option value="<?php echo $vetor_TECNICOS['ID'] ?>"><?php echo $vetor_TECNICOS['DESCRICAO'] ?></option><?php } ?>
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
                        <th>Beneficiário/Produtor</th>
                        <th>Benefício</th>
                        <th>Município</th>
                        <th>Proj. 4.1.5?</th>
                        <th>Proj. 4.2.1?</th>
                        <th>Ribeirinho?</th>
                        <th width="75" valign="center"><a class="fancybox fancybox.ajax" href="excel_familias.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
                    </tr>
                </thead>
                <tbody>
					<?php while ($vetor=mysql_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $vetor['FAMILIA_CODIGO']; ?></td>
                        <td><?php echo $vetor['FAMILIA_BENEFICIARIO']; ?></td>
                        <td><?php echo $vetor['FAMILIA_BENEFICIO_DESC']; ?></td>
                        <td><?php echo $vetor['FAMILIA_MUNICIPIODESTINO_DESC']; ?></td>
                        <td><?php echo $vetor['ATEND_415']; ?></td>
                        <td><?php echo $vetor['ATEND_421']; ?></td>
                        <td><?php echo $vetor['ATEND_RIR']; ?></td>
                        <td><a class="fancybox fancybox.ajax" href="alterar_familias.php?id_familia=<?php echo $vetor['FAMILIA_CODIGO']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a> <a class="fancybox fancybox.ajax" href="recebe_excluir_familias.php?id_familia=<?php echo $vetor['FAMILIA_CODIGO']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a><a class="fancybox fancybox.ajax" href="relatorio_familia.php?id_familia=<?php echo $vetor['FAMILIA_CODIGO']; ?>" target="_blank"><img src="imgs/imprimir.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_familias.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_familias.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_familias.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_familias.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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