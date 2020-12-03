<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 2;
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
<script type="text/javascript">
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mdata(v){  
    v=v.replace(/\D/g,"");                    //Remove tudo o que não é dígito  
    v=v.replace(/(\d{2})(\d)/,"$1/$2");  
    v=v.replace(/(\d{2})(\d)/,"$1/$2");  
    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");  
    return v;  
}  
function mtel(v){
    v=v.replace(/\D/g,"");
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2");
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");
    return v;
}
function id( el ){
	return document.getElementById( el );
}
window.onload = function(){  
    id('telefone').onkeypress = function(){  
        mascara( this, mtel);  
    }
    id('telefone2').onkeypress = function(){  
        mascara( this, mtel);  
    }
}
</script>
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
	<header class="site-header">
	    <div class="container-fluid">
	        <a href="#" class="site-logo">
	            <img class="hidden-md-down" src="../img/logo.png" alt="">
	            <img class="hidden-lg-up" src="../plugin/layout/img/logo-2-mob.png" alt="">
	        </a>
	    </div><!--.container-fluid-->
	</header><!--.site-header-->
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
								<li><a href="#">Geração de Dados - RGM-E</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
			<form action="excel_444_rgme_quadro.php" method="post" name="form_gera_lista" onSubmit="return validaForm()">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th colspan="2">Quadro de Atividades no Período</th>
                        </tr>
                    </thead>
                	<tbody>
                    	<tr>
                            <td width="50%">
                                <select name="filter01" id="filter01" class="form-control" required>
                                    <option value="1" selected>Selecione o Tipo de Atividade</option>
                                    <option value="2">Geração de Renda</option>
                                    <option value="3">Sóciocultural</option>
                                    <option value="4">Meio Ambiente</option>
                                    <option value="5">Institucional</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco01">
                                    <div id="1">&nbsp;</div>
                                    <div id="2">
										Data Inicio: <input type="text" name="ATIV_DATA_INI_02" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="ATIV_DATA_FIM_02" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="3">
										Data Inicio: <input type="text" name="ATIV_DATA_INI_03" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="ATIV_DATA_FIM_03" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="4">
										Data Inicio: <input type="text" name="ATIV_DATA_INI_04" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="ATIV_DATA_FIM_04" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="5">
										Data Inicio: <input type="text" name="ATIV_DATA_INI_05" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="ATIV_DATA_FIM_05" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
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
			<form action="excel_444_rgme_lista.php" method="post" name="form_gera_lista" onSubmit="return validaForm()">
                <table id="table-sm" class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th colspan="2">Relação de Atividades no Período</th>
                        </tr>
                    </thead>
                	<tbody>
                    	<tr>
                            <td width="50%">
                                <select name="filter02" id="filter02" class="form-control" required>
                                    <option value="6" selected>Selecione o Tipo de Atividade</option>
                                    <option value="7">Geração de Renda</option>
                                    <option value="8">Sóciocultural</option>
                                    <option value="9">Meio Ambiente</option>
                                    <option value="10">Institucional</option>
                                </select>
                            </td>
                            <td>
                                <div id="palco02">
                                    <div id="6">&nbsp;</div>
                                    <div id="7">
										Data Inicio: <input type="text" name="ATIV_DATA_INI_07" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="ATIV_DATA_FIM_07" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="8">
										Data Inicio: <input type="text" name="ATIV_DATA_INI_08" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="ATIV_DATA_FIM_08" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="9">
										Data Inicio: <input type="text" name="ATIV_DATA_INI_09" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="ATIV_DATA_FIM_09" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
                                    </div>
                                    <div id="10">
										Data Inicio: <input type="text" name="ATIV_DATA_INI_10" class="form-control" id="exampleInput" placeholder="Digite a data inicial..." onKeyPress="mascara(this,mdata)" maxlength="10"> Data Fim: <input type="text" name="ATIV_DATA_FIM_10" class="form-control" id="exampleInput" placeholder="Digite a data final..." onKeyPress="mascara(this,mdata)" maxlength="10">                                        
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
		</div>
	</div>
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>