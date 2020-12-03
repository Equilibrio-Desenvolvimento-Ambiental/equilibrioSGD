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
			$rgme = $_GET['rgme'];
			$sql_TECNICOS = mysql_query("SELECT DISTINCT TAB_APOIO_TECNICOS.ID AS TECNICO_ID, TAB_APOIO_TECNICOS.DESCRICAO AS TECNICO_NOME FROM TAB_APOIO_TECNICOS LEFT  OUTER JOIN TAB_415421_FAMILIAS ON TAB_415421_FAMILIAS.FAMILIA_TECNICO = TAB_APOIO_TECNICOS.ID LEFT OUTER JOIN TAB_415421_DADOSGERAIS ON  TAB_415421_DADOSGERAIS.FAMILIA_CODIGO = TAB_415421_FAMILIAS.FAMILIA_CODIGO WHERE (TAB_415421_DADOSGERAIS.DADOS_ATEND421 = 1 OR TAB_415421_DADOSGERAIS.DADOS_ATEND415 = 1 OR TAB_415421_DADOSGERAIS.DADOS_ATENDRIR = 1) ORDER BY TAB_APOIO_TECNICOS.ID ASC;", $db);
			$contador = 0;
        	while ($vetor_TECNICOS=mysql_fetch_array($sql_TECNICOS)) {
				$tectemp = $vetor_TECNICOS['TECNICO_ID'];
				$tecnicos['ID'][$contador] = $vetor_TECNICOS['TECNICO_ID'];
				$tecnicos['NOME'][$contador] = $vetor_TECNICOS['TECNICO_NOME'];
				$sqlVisit01 = mysql_query("select count(TAB_415421_PLANVISITAS.PLAN_VISIT_ID) as REALIZADAS from TAB_415421_PLANVISITAS where TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tectemp' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' and TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA = '1';", $db);
				$sqlVisit02 = mysql_query("select count(TAB_415421_PLANVISITAS.PLAN_VISIT_ID) as NAOREALIZADAS from TAB_415421_PLANVISITAS where TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tectemp' and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' and TAB_415421_PLANVISITAS.PLAN_VISIT_CONCLUIDA = '2';", $db);
				$vetorVisit01=mysql_fetch_array($sqlVisit01);
				$vetorVisit02=mysql_fetch_array($sqlVisit02);
				$vetorValores['REALIZADAS'][$contador] = $vetorVisit01['REALIZADAS'];
				$vetorValores['NAOREALIZADAS'][$contador] = $vetorVisit02['NAOREALIZADAS'];
				$vetorValores['TOTAIS'][$contador] = $vetorVisit01['REALIZADAS'] + $vetorVisit02['NAOREALIZADAS'];
				$sqlPlanejado = mysql_query("select count(distinct TAB_415421_PLANVISITAS.PLAN_VISIT_ID) as SEM_PLANEJAMENTO from TAB_415421_PLANVISITAS where (TAB_415421_PLANVISITAS.PLAN_VISIT_ID not in (select distinct TAB_415_PLANVISITAS.PLAN_VISIT_ID from TAB_415_PLANVISITAS) and TAB_415421_PLANVISITAS.PLAN_VISIT_ID not in (select distinct TAB_421_PLANVISITAS.PLAN_VISIT_ID from TAB_421_PLANVISITAS) and TAB_415421_PLANVISITAS.PLAN_VISIT_ID not in (select distinct TAB_RIR_PLANVISITAS.PLAN_VISIT_ID from TAB_RIR_PLANVISITAS)) and TAB_415421_PLANVISITAS.PLAN_VISIT_RGME = '$rgme' AND TAB_415421_PLANVISITAS.PLAN_VISIT_TECNICO = '$tectemp';", $db);
				$vetorPlanejado=mysql_fetch_array($sqlPlanejado);
				$vetorValores['SEM_PLANEJAMENTO'][$contador] = $vetorPlanejado['SEM_PLANEJAMENTO'];
				$vetorValores['CALCULO'][$contador] = -90+((($vetorValores['REALIZADAS'][$contador]*100)/($vetorValores['REALIZADAS'][$contador]+$vetorValores['NAOREALIZADAS'][$contador]))*1.8);
				$tecnicos['PONTEIRO'][$contador] = 'transform: rotate('.$vetorValores['CALCULO'][$contador].'deg);';
				$contador++;
			}
			$sql_RGME = mysql_query("select * from TAB_APOIO_RGME order by ANO, MES asc;", $db);
?>
<?php require_once("includes/header-completo.php");?>
<body>
	<div class="page-content">
		<div class="container-fluid">
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Familias - Projetos 4.1.5 / 4.2.1 / Ribeirinhos</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Inicio</a></li>
								<li><a href="#">Quadro Geral da Situação das Visitas de Campo</a></li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<section class="card">
				<div class="card-block">
					<table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th align="center" valign="middle">Tecnico de Campo</th>
							<th align="center" valign="middle">Total de<br/>Visitas no Mês</th>
							<th align="center" valign="middle">Planejamentos<br/>Não Realizados</th>
							<th align="center" valign="middle">%</th>
							<th align="center" valign="middle">Visitas<br/>Realizadas</th>
							<th align="center" valign="middle">%</th>
							<th align="center" valign="middle">Visitas Não<br/>Realizadas</th>
							<th align="center" valign="middle">%</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td><?php echo $tecnicos['NOME'][0]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][0]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][0]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][0]/$vetorValores['TOTAIS'][0])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][0]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][0]/$vetorValores['TOTAIS'][0])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][0]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][0]/$vetorValores['TOTAIS'][0])*100,0);?>%</td>
						</tr>
						<tr>
							<td><?php echo $tecnicos['NOME'][1]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][1]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][1]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][1]/$vetorValores['TOTAIS'][1])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][1]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][1]/$vetorValores['TOTAIS'][1])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][1]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][1]/$vetorValores['TOTAIS'][1])*100,0);?>%</td>
						</tr>
						<tr>
							<td><?php echo $tecnicos['NOME'][2]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][2]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][2]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][2]/$vetorValores['TOTAIS'][2])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][2]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][2]/$vetorValores['TOTAIS'][2])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][2]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][2]/$vetorValores['TOTAIS'][2])*100,0);?>%</td>
						</tr>
						<tr>
							<td><?php echo $tecnicos['NOME'][5]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][5]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][5]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][5]/$vetorValores['TOTAIS'][5])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][5]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][5]/$vetorValores['TOTAIS'][5])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][5]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][5]/$vetorValores['TOTAIS'][5])*100,0);?>%</td>
						</tr>
						<tr>
							<td><?php echo $tecnicos['NOME'][4]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][4]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][4]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][4]/$vetorValores['TOTAIS'][4])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][4]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][4]/$vetorValores['TOTAIS'][4])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][4]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][4]/$vetorValores['TOTAIS'][4])*100,0);?>%</td>
						</tr>
						<tr>
							<td><?php echo $tecnicos['NOME'][6]; ?></td>
							<td><?php echo $vetorValores['TOTAIS'][6]; ?></td>
							<td><?php echo $vetorValores['SEM_PLANEJAMENTO'][6]; ?></td>
							<td><?php echo round(($vetorValores['SEM_PLANEJAMENTO'][6]/$vetorValores['TOTAIS'][6])*100,0);?>%</td>
							<td><?php echo $vetorValores['REALIZADAS'][6]; ?></td>
							<td><?php echo round(($vetorValores['REALIZADAS'][6]/$vetorValores['TOTAIS'][6])*100,0);?>%</td>
							<td><?php echo $vetorValores['NAOREALIZADAS'][6]; ?></td>
							<td><?php echo round(($vetorValores['NAOREALIZADAS'][6]/$vetorValores['TOTAIS'][6])*100,0);?>%</td>
						</tr>
						</tbody>
					</table>
				</div>
			</section>
		</div>
	</div>
    <?php require_once("includes/footer-bootstrap.php");?>
</body>
</html>
<?php
}
}
?>