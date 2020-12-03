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
/*			if(isset($_GET["page"])):
				$page = $_GET["page"];
			else:
				$page = 1;
			endif;
			$byPage = 10;
			$startAt = ($page*$byPage)-$byPage;*/
			if($filter == 0){
//				$sqlTotalRecords = mysql_query("SELECT VIEW_CHECKPEND_FISH_0005.FISH_FAM_ID FROM VIEW_CHECKPEND_FISH_0005;", $db) or die(mysql_error());
//				$totalRecords=mysql_num_rows($sqlTotalRecords);
//				$totalPages = ceil($totalRecords/$byPage); 
				$sql01 = mysql_query("SELECT * FROM VIEW_CHECKPEND_FISH_0006A ORDER BY VIEW_CHECKPEND_FISH_0006A.FISH_FAM_QUEST ASC;", $db) or die(mysql_error());
				$sql02 = mysql_query("SELECT * FROM VIEW_CHECKPEND_FISH_0006B ORDER BY VIEW_CHECKPEND_FISH_0006B.FISH_FAM_QUEST ASC;", $db) or die(mysql_error());
				$sql03 = mysql_query("SELECT * FROM VIEW_CHECKPEND_FISH_0006C ORDER BY VIEW_CHECKPEND_FISH_0006C.FISH_FAM_QUEST ASC;", $db) or die(mysql_error());
				$sql04 = mysql_query("SELECT * FROM VIEW_CHECKPEND_FISH_0006D ORDER BY VIEW_CHECKPEND_FISH_0006D.FISH_FAM_QUEST ASC;", $db) or die(mysql_error());
			}
			if($filter == 1) {
				if(isset($_POST["filter"])):
					$FISH_FAM_CHEFE_NOME = $_POST['FISH_FAM_CHEFE_NOME'];
				else:
					$FISH_FAM_CHEFE_NOME = $_SESSION['lastfilter'];
				endif;				
//				$sqlTotalRecords = mysql_query("SELECT VIEW_CHECKPEND_FISH_0005.FISH_FAM_ID FROM VIEW_CHECKPEND_FISH_0005 WHERE VIEW_CHECKPEND_FISH_0005.FISH_FAM_CHEFE_NOME LIKE '%".$FISH_FAM_CHEFE_NOME."%';", $db) or die(mysql_error());
//				$totalRecords=mysql_num_rows($sqlTotalRecords);
//				$totalPages = ceil($totalRecords/$byPage); 
//				$totalPages = ceil($totalRecords/$byPage); 
				$sql01 = mysql_query("SELECT * FROM VIEW_CHECKPEND_FISH_0006A WHERE VIEW_CHECKPEND_FISH_0006A.FISH_FAM_CHEFE_NOME LIKE '%".$FISH_FAM_CHEFE_NOME."%' ORDER BY VIEW_CHECKPEND_FISH_0006A.FISH_FAM_QUEST ASC;", $db) or die(mysql_error());
				$sql02 = mysql_query("SELECT * FROM VIEW_CHECKPEND_FISH_0006B WHERE VIEW_CHECKPEND_FISH_0006B.FISH_FAM_CHEFE_NOME LIKE '%".$FISH_FAM_CHEFE_NOME."%' ORDER BY VIEW_CHECKPEND_FISH_0006B.FISH_FAM_QUEST ASC;", $db) or die(mysql_error());
				$sql03 = mysql_query("SELECT * FROM VIEW_CHECKPEND_FISH_0006C WHERE VIEW_CHECKPEND_FISH_0006C.FISH_FAM_CHEFE_NOME LIKE '%".$FISH_FAM_CHEFE_NOME."%' ORDER BY VIEW_CHECKPEND_FISH_0006C.FISH_FAM_QUEST ASC;", $db) or die(mysql_error());
				$sql04 = mysql_query("SELECT * FROM VIEW_CHECKPEND_FISH_0006D WHERE VIEW_CHECKPEND_FISH_0006D.FISH_FAM_CHEFE_NOME LIKE '%".$FISH_FAM_CHEFE_NOME."%' ORDER BY VIEW_CHECKPEND_FISH_0006D.FISH_FAM_QUEST ASC;", $db) or die(mysql_error());
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
								<li><a href="#">View 0006 - Verificação das Famílias que tiveram rancho(s) entregue(s) e não possuem o(s) recibo(s) assinado(s), digitalizado(s) e anexado(s)</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="listar_view_checkpend_fish_0006.php" method="post" name="listar_view_checkpend_fish_0006" onSubmit="return validaForm()" id="listar_view_checkpend_fish_0006">
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
		
   			<div class="box-typical box-typical-padding">
                	<div style="width: 100%; margin: 0 auto;">
                        <ul class="tabs" data-persist="true">
                           	<li><a href="#view1">1º Rancho</a></li>
                           	<li><a href="#view2">2º Rancho</a></li>
                            <li><a href="#view3">3º Rancho</a></li>
                            <li><a href="#view4">4º Rancho</a></li>
                        </ul>
                        <div class="tabcontents">
							
							<div id="view1">
								<table id="table-sm" class="table table-bordered table-hover table-sm">
									<thead>
										<tr>
											<th>Questionário</th>
											<th>Beneficiário/Pescador</th>
											<th width="30px" valign="center"><a class="fancybox fancybox.ajax" href="excel_view_checkpend_fish_0006a.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
										</tr>
									</thead>
									<tbody>
										<?php while ($vetor01=mysql_fetch_array($sql01)) { ?>
										<tr>
											<td><?php echo $vetor01['FISH_FAM_QUEST']; ?></td>
											<td><?php echo $vetor01['FISH_FAM_CHEFE_NOME']; ?></td>
											<td width="30px" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('../pescadores/alterar_fish_familias.php?id_familia=<?php echo $vetor01['FISH_FAM_ID'];?>','Dados da Família', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div> <!-- 1º Rancho -->
							<div id="view2">
								<table id="table-sm" class="table table-bordered table-hover table-sm">
									<thead>
										<tr>
											<th>Questionário</th>
											<th>Beneficiário/Pescador</th>
											<th width="30px" valign="center"><a class="fancybox fancybox.ajax" href="excel_view_checkpend_fish_0006b.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
										</tr>
									</thead>
									<tbody>
										<?php while ($vetor02=mysql_fetch_array($sql02)) { ?>
										<tr>
											<td><?php echo $vetor02['FISH_FAM_QUEST']; ?></td>
											<td><?php echo $vetor02['FISH_FAM_CHEFE_NOME']; ?></td>
											<td width="30px" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('../pescadores/alterar_fish_familias.php?id_familia=<?php echo $vetor02['FISH_FAM_ID'];?>','Dados da Família', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div> <!-- 2º Rancho -->
							<div id="view3">
								<table id="table-sm" class="table table-bordered table-hover table-sm">
									<thead>
										<tr>
											<th>Questionário</th>
											<th>Beneficiário/Pescador</th>
											<th width="30px" valign="center"><a class="fancybox fancybox.ajax" href="excel_view_checkpend_fish_0006c.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
										</tr>
									</thead>
									<tbody>
										<?php while ($vetor03=mysql_fetch_array($sql03)) { ?>
										<tr>
											<td><?php echo $vetor03['FISH_FAM_QUEST']; ?></td>
											<td><?php echo $vetor03['FISH_FAM_CHEFE_NOME']; ?></td>
											<td width="30px" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('../pescadores/alterar_fish_familias.php?id_familia=<?php echo $vetor03['FISH_FAM_ID'];?>','Dados da Família', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div> <!-- 3º Rancho -->
							<div id="view4">
								<table id="table-sm" class="table table-bordered table-hover table-sm">
									<thead>
										<tr>
											<th>Questionário</th>
											<th>Beneficiário/Pescador</th>
											<th width="30px" valign="center"><a class="fancybox fancybox.ajax" href="excel_view_checkpend_fish_0006d.php"><img src="imgs/excel.png" width="25" height="25" border="0"></a></th>
										</tr>
									</thead>
									<tbody>
										<?php while ($vetor04=mysql_fetch_array($sql04)) { ?>
										<tr>
											<td><?php echo $vetor04['FISH_FAM_QUEST']; ?></td>
											<td><?php echo $vetor04['FISH_FAM_CHEFE_NOME']; ?></td>
											<td width="30px" align="center"><a class="fancybox fancybox.ajax" hef="#" onClick="window.open('../pescadores/alterar_fish_familias.php?id_familia=<?php echo $vetor04['FISH_FAM_ID'];?>','Dados da Família', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=600');"><img src="imgs/alterar.png" width="25" height="25" border="0"></a></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div> <!-- 4º Rancho -->

						</div>
					</div>
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