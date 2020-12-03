<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 3;
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
			$sql_RUC = mysql_query("select * from TAB_APOIO_RUC order by DESCRICAO ASC", $db);
			$sql_PERIODO = mysql_query("select * from TAB_APOIO_PERIODO order by DESCRICAO ASC", $db);
			$sql_TPEVENTO = mysql_query("select * from TAB_APOIO_EVENUC_IN order by DESCRICAO ASC", $db);
			$sql_TPATIVIDADE = mysql_query("select * from TAB_APOIO_ATIVNUC_IN order by DESCRICAO ASC", $db);
			if(isset($_POST["filter"])){
				$filter = $_POST["filter"];
				if($filter == 1) { $_SESSION["lastfilter"] = $_POST["ATIVIN_DATA"]; }
				if($filter == 2) { $_SESSION["lastfilter_ini"] = $_POST["ATIVIN_DATA_INI"]; $_SESSION["lastfilter_fim"] = $_POST["ATIVIN_DATA_FIM"];}
				if($filter == 3) { $_SESSION["lastfilter"] = $_POST["ATIVIN_RUC"]; }
				if($filter == 4) { $_SESSION["lastfilter"] = $_POST["ATIVIN_PERIODO"]; }
				if($filter == 5) { $_SESSION["lastfilter"] = $_POST["ATIVIN_TPEVENTO"]; }
				if($filter == 6) { $_SESSION["lastfilter"] = $_POST["ATIVIN_TPATIVIDADE"]; }
				if($filter == 7) { $_SESSION["lastfilter"] = $_POST["ATIVIN_DESCRICAO"]; }
				if($filter == 8) { $_SESSION["lastfilter"] = $_POST["ATIVIN_PERCEPCOES"]; }
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
				$sqlTotalRecords = mysql_query("select ATIVIN_CODIGO from TAB_444_ATIV_IN", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select A.ATIVIN_CODIGO, B.DESCRICAO as ATIVIN_RUC, C.DESCRICAO as ATIVIN_EVENTO, D.DESCRICAO as ATIVIN_ATIVIDADE, A.ATIVIN_DATA from TAB_444_ATIV_IN A, TAB_APOIO_RUC B, TAB_APOIO_EVENUC_IN C, TAB_APOIO_ATIVNUC_IN D where A.ATIVIN_RUC = B.ID and A.ATIVIN_EVENTO = C.ID and A.ATIVIN_ATIVIDADE = D.ID order by A.ATIVIN_DATA desc limit $startAt, $byPage", $db);
			}
			if($filter == 3) {
				if(isset($_POST["filter"])):
					$ATIVIN_RUC = $_POST['ATIVIN_RUC'];
				else:
					$ATIVIN_RUC = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select ATIVIN_CODIGO from TAB_444_ATIV_IN where ATIVIN_RUC = '$ATIVIN_RUC'", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select A.ATIVIN_CODIGO, B.DESCRICAO as ATIVIN_RUC, C.DESCRICAO as ATIVIN_EVENTO, D.DESCRICAO as ATIVIN_ATIVIDADE, A.ATIVIN_DATA from TAB_444_ATIV_IN A, TAB_APOIO_RUC B, TAB_APOIO_EVENUC_IN C, TAB_APOIO_ATIVNUC_IN D where A.ATIVIN_RUC = B.ID and A.ATIVIN_EVENTO = C.ID and A.ATIVIN_ATIVIDADE = D.ID and A.ATIVIN_RUC = '$ATIVIN_RUC' order by A.ATIVIN_DATA desc limit $startAt, $byPage", $db);
			}
			if($filter == 4) {
				if(isset($_POST["filter"])):
					$ATIVIN_PERIODO = $_POST['ATIVIN_PERIODO'];
				else:
					$ATIVIN_PERIODO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select ATIVIN_CODIGO from TAB_444_ATIV_IN where ATIVIN_PERIODO = '$ATIVIN_PERIODO'", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select A.ATIVIN_CODIGO, B.DESCRICAO as ATIVIN_RUC, C.DESCRICAO as ATIVIN_EVENTO, D.DESCRICAO as ATIVIN_ATIVIDADE, A.ATIVIN_DATA from TAB_444_ATIV_IN A, TAB_APOIO_RUC B, TAB_APOIO_EVENUC_IN C, TAB_APOIO_ATIVNUC_IN D where A.ATIVIN_RUC = B.ID and A.ATIVIN_EVENTO = C.ID and A.ATIVIN_ATIVIDADE = D.ID and A.ATIVIN_PERIODO = '$ATIVIN_PERIODO' order by A.ATIVIN_DATA desc limit $startAt, $byPage", $db);
			}
			if($filter == 5) {
				if(isset($_POST["filter"])):
					$ATIVIN_TPEVENTO = $_POST['ATIVIN_TPEVENTO'];
				else:
					$ATIVIN_TPEVENTO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select ATIVIN_CODIGO from TAB_444_ATIV_IN where ATIVIN_EVENTO = '$ATIVIN_TPEVENTO'", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select A.ATIVIN_CODIGO, B.DESCRICAO as ATIVIN_RUC, C.DESCRICAO as ATIVIN_EVENTO, D.DESCRICAO as ATIVIN_ATIVIDADE, A.ATIVIN_DATA from TAB_444_ATIV_IN A, TAB_APOIO_RUC B, TAB_APOIO_EVENUC_IN C, TAB_APOIO_ATIVNUC_IN D where A.ATIVIN_RUC = B.ID and A.ATIVIN_EVENTO = C.ID and A.ATIVIN_ATIVIDADE = D.ID and A.ATIVIN_EVENTO = '$ATIVIN_TPEVENTO' order by A.ATIVIN_DATA desc LIMIT $startAt, $byPage", $db);
			}
			if($filter == 6) {
				if(isset($_POST["filter"])):
					$ATIVIN_TPATIVIDADE = $_POST['ATIVIN_TPATIVIDADE'];
				else:
					$ATIVIN_TPATIVIDADE = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select ATIVIN_CODIGO from TAB_444_ATIV_IN where ATIVIN_ATIVIDADE = '$ATIVIN_TPATIVIDADE'", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select A.ATIVIN_CODIGO, B.DESCRICAO as ATIVIN_RUC, C.DESCRICAO as ATIVIN_EVENTO, D.DESCRICAO as ATIVIN_ATIVIDADE, A.ATIVIN_DATA from TAB_444_ATIV_IN A, TAB_APOIO_RUC B, TAB_APOIO_EVENUC_IN C, TAB_APOIO_ATIVNUC_IN D where A.ATIVIN_RUC = B.ID and A.ATIVIN_EVENTO = C.ID and A.ATIVIN_ATIVIDADE = D.ID and A.ATIVIN_ATIVIDADE = '$ATIVIN_TPATIVIDADE' order by A.ATIVIN_DATA desc LIMIT $startAt, $byPage", $db);
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$ATIVIN_DATA = implode('-',array_reverse(explode('/',$_POST['ATIVIN_DATA'])));
				else:
					$ATIVIN_DATA = implode('-',array_reverse(explode('/',$_SESSION['lastfilter'])));
				endif;				
				$sqlTotalRecords = mysql_query("select ATIVIN_CODIGO from TAB_444_ATIV_IN where ATIVIN_DATA = '$ATIVIN_DATA'", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select A.ATIVIN_CODIGO, B.DESCRICAO as ATIVIN_RUC, C.DESCRICAO as ATIVIN_EVENTO, D.DESCRICAO as ATIVIN_ATIVIDADE, A.ATIVIN_DATA from TAB_444_ATIV_IN A, TAB_APOIO_RUC B, TAB_APOIO_EVENUC_IN C, TAB_APOIO_ATIVNUC_IN D where A.ATIVIN_RUC = B.ID and A.ATIVIN_EVENTO = C.ID and A.ATIVIN_ATIVIDADE = D.ID and A.ATIVIN_DATA = '$ATIVIN_DATA' order by A.ATIVIN_DATA desc LIMIT $startAt, $byPage", $db);
			}
			if($filter == 2) {
				if(isset($_POST["filter"])):
					$ATIVIN_DATA_INI = implode('-',array_reverse(explode('/',$_POST['ATIVIN_DATA_INI'])));
					$ATIVIN_DATA_FIM = implode('-',array_reverse(explode('/',$_POST['ATIVIN_DATA_FIM'])));
				else:
					$ATIVIN_DATA_INI = implode('-',array_reverse(explode('/',$_SESSION['lastfilter_ini'])));
					$ATIVIN_DATA_FIM = implode('-',array_reverse(explode('/',$_SESSION['lastfilter_fim'])));
				endif;				
				$sqlTotalRecords = mysql_query("select ATIVIN_CODIGO from TAB_444_ATIV_IN where ATIVIN_DATA between '$ATIVIN_DATA_INI' and '$ATIVIN_DATA_FIM'", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select A.ATIVIN_CODIGO, B.DESCRICAO as ATIVIN_RUC, C.DESCRICAO as ATIVIN_EVENTO, D.DESCRICAO as ATIVIN_ATIVIDADE, A.ATIVIN_DATA from TAB_444_ATIV_IN A, TAB_APOIO_RUC B, TAB_APOIO_EVENUC_IN C, TAB_APOIO_ATIVNUC_IN D where A.ATIVIN_RUC = B.ID and A.ATIVIN_EVENTO = C.ID and A.ATIVIN_ATIVIDADE = D.ID and A.ATIVIN_DATA between '$ATIVIN_DATA_INI' and '$ATIVIN_DATA_FIM' order by A.ATIVIN_DATA desc LIMIT $startAt, $byPage", $db);
			}
			if($filter == 7) {
				if(isset($_POST["filter"])):
					$ATIVIN_DESCRICAO = $_POST['ATIVIN_DESCRICAO'];
				else:
					$ATIVIN_DESCRICAO = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select ATIVIN_CODIGO from TAB_444_ATIV_IN where ATIVIN_DESCRICAO like '%".$ATIVIN_DESCRICAO."%'", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select A.ATIVIN_CODIGO, B.DESCRICAO as ATIVIN_RUC, C.DESCRICAO as ATIVIN_EVENTO, D.DESCRICAO as ATIVIN_ATIVIDADE, A.ATIVIN_DATA from TAB_444_ATIV_IN A, TAB_APOIO_RUC B, TAB_APOIO_EVENUC_IN C, TAB_APOIO_ATIVNUC_IN D where A.ATIVIN_RUC = B.ID and A.ATIVIN_EVENTO = C.ID and A.ATIVIN_ATIVIDADE = D.ID and A.ATIVIN_DESCRICAO like '%".$ATIVIN_DESCRICAO."%' order by A.ATIVIN_DATA desc LIMIT $startAt, $byPage", $db);
			}
			if($filter == 8) {
				if(isset($_POST["filter"])):
					$ATIVIN_PERCEPCOES = $_POST['ATIVIN_PERCEPCOES'];
				else:
					$ATIVIN_PERCEPCOES = $_SESSION['lastfilter'];
				endif;				
				$sqlTotalRecords = mysql_query("select ATIVIN_CODIGO from TAB_444_ATIV_IN where ATIVIN_PERCEPCOES like '%".$ATIVIN_PERCEPCOES."%'", $db);
				$totalRecords=mysql_num_rows($sqlTotalRecords);
				$totalPages = ceil($totalRecords/$byPage); 
				$totalPages = ceil($totalRecords/$byPage); 
				$sql = mysql_query("select A.ATIVIN_CODIGO, B.DESCRICAO as ATIVIN_RUC, C.DESCRICAO as ATIVIN_EVENTO, D.DESCRICAO as ATIVIN_ATIVIDADE, A.ATIVIN_DATA from TAB_444_ATIV_IN A, TAB_APOIO_RUC B, TAB_APOIO_EVENUC_IN C, TAB_APOIO_ATIVNUC_IN D where A.ATIVIN_RUC = B.ID and A.ATIVIN_EVENTO = C.ID and A.ATIVIN_ATIVIDADE = D.ID and A.ATIVIN_PERCEPCOES like '%".$ATIVIN_PERCEPCOES."%' order by A.ATIVIN_DATA desc LIMIT $startAt, $byPage", $db);
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
							<h3>Gestão do Projeto 4.4.4</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Listagem de Atividade Institucionais</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_ativ_in.php" method="post" name="form_consulta" onSubmit="return validaForm()">
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
                                    <option value="1">Filtrar Por Data</option>
                                    <option value="2">Filtrar Por Intervalo de Datas</option>
                                    <option value="3">Filtrar Por Bairro/RUC</option>
                                    <option value="4">Filtrar Por Periodo</option>
                                    <option value="5">Filtrar Por Tipo de Evento</option>
                                    <option value="6">Filtrar Por Tipo de Atividade</option>
                                    <option value="7">Filtrar Por Descrição</option>
                                    <option value="8">Filtrar Por Percepções</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco">
                                    <div id="1">
										<input type="text" name="ATIVIN_DATA" class="form-control" id="exampleInput" placeholder="Digite a data..." onKeyPress="mascara(this,mdata)" maxlength="10">
                                    </div>
                                    <div id="2">
										Data Inicio: <input type="text" name="ATIVIN_DATA_INI" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="ATIVIN_DATA_FIM" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="3">
                                        <select name="ATIVIN_RUC" id="exampleSelect" class="form-control">
                                        	<?php while ($vetor_RUC=mysql_fetch_array($sql_RUC)) { ?>
                                        	<option value="<?php echo $vetor_RUC['ID'] ?>"><?php echo $vetor_RUC['DESCRICAO'] ?></option><?php } ?>
                                        </select>
									</div>
                                    <div id="4">
                                        <select name="ATIVIN_PERIODO" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_PERIODO=mysql_fetch_array($sql_PERIODO)) { ?>
                                            <option value="<?php echo $vetor_PERIODO['ID'] ?>"><?php echo $vetor_PERIODO['DESCRICAO'] ?></option><?php } ?>
                                        </select>
                                    </div>
                                    <div id="5">
                                        <select name="ATIVIN_TPEVENTO" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_TPEVENTO=mysql_fetch_array($sql_TPEVENTO)) { ?>
                                            <option value="<?php echo $vetor_TPEVENTO['ID'] ?>"><?php echo $vetor_TPEVENTO['DESCRICAO'] ?></option><?php } ?>
                                        </select>
                                    </div>
                                    <div id="6">
                                        <select name="ATIVIN_TPATIVIDADE" id="exampleSelect" class="form-control">
                                            <?php while ($vetor_TPATIVIDADE=mysql_fetch_array($sql_TPATIVIDADE)) { ?>
                                            <option value="<?php echo $vetor_TPATIVIDADE['ID'] ?>"><?php echo $vetor_TPATIVIDADE['DESCRICAO'] ?></option><?php } ?>
                                        </select>
                                    </div>
                                    <div id="7">
										<input type="text" name="ATIVIN_DESCRICAO" class="form-control" id="exampleInput" placeholder="Digite o texto...">
                                    </div>
                                    <div id="8">
										<input type="text" name="ATIVIN_PERCEPCOES" class="form-control" id="exampleInput" placeholder="Digite o texto...">
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
                        <th>Data</th>
                        <th>Bairro/RUC</th>
                        <th>Tipo do Evento</th>
                        <th>Tipo da Atividade</th>
                        <th width="120"></th>
                    </tr>
                </thead>
                <tbody>
					<?php 
                        function reverse_date($date)
                        {
                            return ( strstr( $date, '/' ) ) ? implode( '-', array_reverse( explode( '/', $date ) ) ) : implode( '/', array_reverse( explode(                '-', $date ) )      );
                        }
                        while ($vetor=mysql_fetch_array($sql)) { 
                    ?>
                    <tr>
                        <td><?php echo $vetor['ATIVIN_CODIGO']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($vetor['ATIVIN_DATA'])); ?></td>
                        <td><?php echo $vetor['ATIVIN_RUC']; ?></td>
                        <td><?php echo $vetor['ATIVIN_EVENTO']; ?></td>
                        <td><?php echo $vetor['ATIVIN_ATIVIDADE']; ?></td>
                        <td><a class="fancybox fancybox.ajax" href="alterar_ativ_in.php?id=<?php echo $vetor['ATIVIN_CODIGO']; ?>"><img src="imgs/alterar.png" width="25" height="25" border="0"></a>&nbsp;<a class="fancybox fancybox.ajax" href="recebe_excluir_ativ_in.php?id=<?php echo $vetor['ATIVIN_CODIGO']; ?>"><img src="imgs/excluir.png" width="25" height="25" border="0"></a>&nbsp;<a class="fancybox fancybox.ajax" href="rel_ativ_in.php?id=<?php echo $vetor['ATIVIN_CODIGO']; ?>" target="_blank"><img src="imgs/imprimir.png" width="25" height="25" border="0"></a></td>
                    </tr>
                    <?php } ?>
				</tbody>
			</table>
            </br>
            <div id="navigation" class="div_arrows">
                <?php
                    if($page>1):
                        $pagePrevious = $page-1;
                        echo '<a href="listar_ativ_in.php?page=1&filter='.$filter.'"><img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página"></a>';
                        echo '<a href="listar_ativ_in.php?page='.$pagePrevious.'&filter='.$filter.'"><img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior"></a>';
                    else:
                        echo '<img src="imgs/arrow_first.png" width="25" height="25" alt="Primeira Página">';
                        echo '<img src="imgs/arrow_previos.png" width="25" height="25" alt="Página Anterior">';
                    endif;
                    echo $page."/".$totalPages;
                    if($page<$totalPages):
                        $pageNext = $page+1;
                        echo '<a href="listar_ativ_in.php?page='.$pageNext.'&filter='.$filter.'"><img src="imgs/arrow_next.png" width="25" height="25" alt="Próxima Página"></a>';
                        echo '<a href="listar_ativ_in.php?page='.$totalPages.'&filter='.$filter.'"><img src="imgs/arrow_last.png" width="25" height="25" alt="Última Página"></a>';
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