<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	include"../includes/conecta.php";
	$projeto = 6;
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
			function reverse_date( $date ){
				return ( strstr( $date, '-' ) ) ? implode( '/', array_reverse( explode( '-', $date ) ) ) : implode( '-', array_reverse( explode(                '/', $date ) )      );
			}
			$data_atual = reverse_date(date("d/m/Y"));

			$sql_MATCONSUMO = mysql_query("select TAB_ADM_MATCONSUMO.MATCONS_ID, TAB_ADM_MATCONSUMO.MATCONS_NOME, TAB_APOIO_PROD_UNIT.DESCRICAO as MATCONS_UNIDADE_DESC from TAB_ADM_MATCONSUMO left outer join TAB_APOIO_PROD_UNIT on TAB_ADM_MATCONSUMO.MATCONS_UNIDADE = TAB_APOIO_PROD_UNIT.ID order by TAB_ADM_MATCONSUMO.MATCONS_NOME asc;", $db);
			$sql_CENTROCUSTO = mysql_query("select * from TAB_ADM_CENTROCUSTO order by CCUSTO_CODIGO asc, CCUSTO_DESCRICAO asc;", $db);

			$sql_Aba01 = mysql_query("SELECT TAB_ADM_PEDIDOS.PEDIDO_ID, TAB_ADM_PEDIDOS.PEDIDO_DTLIM_COMPRA, TAB_ADM_PEDIDOS.PEDIDO_DTLIM_PREP, TAB_ADM_PEDIDOS.PEDIDO_DTLIM_ENTR, TAB_ADM_PEDIDOS.PEDIDO_DTLIM_VISIT, TAB_APOIO_TECNICOS.DESCRICAO FROM TAB_ADM_PEDIDOS LEFT OUTER JOIN TAB_APOIO_TECNICOS ON TAB_ADM_PEDIDOS.PEDIDO_TECNICO = TAB_APOIO_TECNICOS.ID WHERE TAB_ADM_PEDIDOS.PEDIDO_STATUS = '1' ORDER BY TAB_ADM_PEDIDOS.PEDIDO_DTLIM_VISIT ASC, TAB_ADM_PEDIDOS.PEDIDO_TECNICO ASC;", $db);

?>
<?php require_once("includes/header-completo.php");?>
<style type="text/css">
<!--
#scroll {
  width:100%;
  height:400px;
  overflow:auto;
}
-->
</style>
<script type="text/javascript">
/* MÃ¡scaras ER */
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
function mvalor(v){
	v=v.replace(/\D/g,"");//Remove tudo o que não é dígito  
	v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões  
	v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares
	v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos  
	return v;  
}  
function id(el){
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
<script src="tabs/tabcontent.js" type="text/javascript"></script>
<link href="tabs/template1/tabcontent.css" rel="stylesheet" type="text/css" />
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
							<h3>Gestão de Suprimentos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Gestão de Saída de Produtos</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>
            <form action="gestao_pass00_ler_novos_pedidos.php" method="post" name="teste">
            <div class="row">
            	<div class="col-md-12 progress-demo">
                	<div class="form-group">
                    	<button class="btn btn-inline btn-danger ladda-button" data-style="expand-left"><span class="ladda-label">Atualizar os Pedidos</span></button>
                    </div>
				</div>
			</div>
            </form>
            <section class="tabs-section">
				<div class="tabs-section-nav tabs-section-nav-inline">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" href="#tabs-4-tab-1" role="tab" data-toggle="tab">
                            	Novos
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-4-tab-2" role="tab" data-toggle="tab">
								Para aquisição
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-4-tab-3" role="tab" data-toggle="tab">
								Para entrega
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-4-tab-4" role="tab" data-toggle="tab">
								Aguarda devolução
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#tabs-4-tab-5" role="tab" data-toggle="tab">
								Finalizados
							</a>
						</li>
					</ul>
				</div><!--.tabs-section-nav-->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="tabs-4-tab-1">
                        <div class="box-typical box-typical-padding">
                            <h4 class="with-border">Novos Pedidos</h4>
                            <div class="row" align="center">
                                <table width="95%">
                                    <tr align="center" bgcolor="#0D0C9B">
                                        <td><strong><font color="#FFFFFF">Prazo Aquisição</font></strong></td>
                                        <td width="1%"></td>
                                        <td><strong><font color="#FFFFFF">Prazo Montagem</font></strong></td>
                                        <td width="1%"></td>
                                        <td><strong><font color="#FFFFFF">Prazo Entrega</font></strong></td>
                                        <td width="1%"></td>
                                        <td><strong><font color="#FFFFFF">Visita</font></strong></td>
                                        <td width="1%"></td>
                                        <td><strong><font color="#FFFFFF">Técnico</font></strong></td>
                                        <td width="1%"></td>
                                        <td width="10%"><strong><font color="#FFFFFF">Ações</font></strong></td>
                                    </tr>
                                    <?php 
                                        $cor = "#D8D8D8";
                                        $corFonte = "000000";
                                        while ($vetor_Aba01=mysql_fetch_array($sql_Aba01)) {
                                            if (strcasecmp($cor, "#FFFFFF") == 0){
                                                $cor = "#D8D8D8";
                                            } else {
                                                $cor = "#FFFFFF";
                                            }
                                            if ($data_atual > $vetor_Aba01['PEDIDO_DTLIM_COMPRA']){
                                                $corFonte = "#FF0004";
                                            } else {
                                                $corFonte = "#000000";
                                            }
                                    ?>
                                    <tr bgcolor="<?php echo $cor; ?>">
                                        <td align="center"><font color="<?php echo $corFonte; ?>"><?php echo date('d/m/Y', strtotime($vetor_Aba01['PEDIDO_DTLIM_COMPRA'])); ?></font></td>
                                        <td width="1%"></td>
                                        <td align="center"><font color="<?php echo $corFonte; ?>"><?php echo date('d/m/Y', strtotime($vetor_Aba01['PEDIDO_DTLIM_PREP'])); ?></font></td>
                                        <td width="1%"></td>
                                        <td align="center"><font color="<?php echo $corFonte; ?>"><?php echo date('d/m/Y', strtotime($vetor_Aba01['PEDIDO_DTLIM_ENTR'])); ?></font></td>
                                        <td width="1%"></td>
                                        <td align="center"><font color="<?php echo $corFonte; ?>"><?php echo date('d/m/Y', strtotime($vetor_Aba01['PEDIDO_DTLIM_VISIT'])); ?></font></td>
                                        <td width="1%"></td>
                                        <td align="center"><font color="<?php echo $corFonte; ?>"><?php echo $vetor_Aba01['DESCRICAO']; ?></font></td>
                                        <td width="1%"></td>
                                        <td width="10%" align="center"><a class="fancybox fancybox.ajax" href="gestao_pass01_avaliar_pedido.php?idPedido=<?php echo $vetor_Aba01['PEDIDO_ID']; ?>"><img src="imgs/checklist.png" width="25" height="25" border="0"></a></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div><!--.box-typical-->                        
                    </div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-2">
                    	Aba 02
					</div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-3">
                    	Aba 03
                    </div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-4">
                    	Aba 04
                    </div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-5">
                    	Aba 05
                    </div><!--.tab-pane-->
				</div><!--.tab-content-->
			</section><!--.tabs-section-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>