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
?>
<?php require_once("includes/header-completo.php");?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript">  
$(document).ready(function(){  
		$("#palco01 > div").hide(); 
		$("#filter01").change(function(){  
                $("#palco01 > div").hide();  
                $( '#'+$( this ).val() ).show('fast');  
        }); 
});  
$(document).ready(function(){  
		$("#palco02 > div").hide(); 
		$("#filter02").change(function(){  
                $("#palco02 > div").hide();  
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
							<h3>Gestão dos Projetos 4.1.5 / 4.2.1 / Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Geração de Arquivo para Impressão da Agenda - Versão 1.00</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="planejamento_rel_agenda.php" method="post" name="planejamento_rel_agenda" onSubmit="return validaForm()" target="_blank">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead><tr><th colspan="2">Geração de Dados da Agenda</th></tr></thead>
                	<tbody>
                    	<tr>
                            <td width="50%">
								Data Inicio: <input type="text" name="DATA_INI_AGENDA" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10">
                            </td>
                            <td>
								Data Fim: <input type="text" name="DATA_FIM_AGENDA" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">
                            </td>
						</tr>                            
                    </tbody>
				</table>
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                    <tr>
                        <th><input name="buscar" class="float" type="image" src="imgs/gerar.png" value="Gerar Agenda" /></th>
                    </tr>
                    </thead>
                </table>
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