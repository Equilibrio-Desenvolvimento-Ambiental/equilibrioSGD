	<li class="brown with-sub">
    	<a href="../main/index.php">
        	<i class="fa fa-home" aria-hidden="true"></i>
            	<span class="lbl">Inicio</span>
		</a>
	</li>
    <li class="brown with-sub">
        <span>
	        <i class="font-icon font-icon-user"></i>
    	    <span class="lbl">Famílias</span>
        </span>
        <ul>
            <li><a href="cadastrar_familias.php"><span class="lbl">Nova Família</span></a></li>
            <li><a href="listar_familias.php"><span class="lbl">Listagem</span></a></li>
        </ul>
    </li>
    <li class="brown with-sub">
        <span>
	        <i class="fa fa-globe" aria-hidden="true"></i>
    	    <span class="lbl">Pontos de Ocupação</span>
        </span>
        <ul>
            <li><a href="cadastrar_pontoocup.php"><span class="lbl">Novo Ponto de Ocupação</span></a></li>
            <li><a href="listar_pontoocup.php"><span class="lbl">Listagem</span></a></li>
        </ul>
    </li>
    <li class="brown with-sub">
        <span>
	        <i class="fa fa-globe" aria-hidden="true"></i>
    	    <span class="lbl">Planejamento</span>
        </span>
        <ul>
        	<?php
			if(strcasecmp($_SESSION['nivel'],'1') == 0):?>
                <li><a href="planejamento_select_atividades.php"><span class="lbl">Gerar Visitas</span></a></li>
                <li><a href="listar_familias_especiais.php"><span class="lbl">Famílias em Duplicidade</span></a></li>
                <li><a href="planejamento_painel_adm.php"><span class="lbl">Painel de Admin</span></a></li>
			<?php endif; ?>
            <li><a href="planejamento_listar_familias.php"><span class="lbl">Organizar Visitas</span></a></li>
            <li><a href="planejamento_exportar_agenda.php"><span class="lbl">Exportar Agenda</span></a></li>
        </ul>
    </li>
    <li class="brown with-sub">
        <span>
	        <i class="glyphicon glyphicon-print" aria-hidden="true"></i>
    	    <span class="lbl">Relatórios</span>
        </span>
        <ul>
            <li><a href="listar_familias_relatorio.php"><span class="lbl">Correções</span></a></li>
            <li><a href="rel_export_415421.php"><span class="lbl">Exportações</span></a></li>
        </ul>
    </li>
	<li class="brown with-sub">
		<span>
			<i class="fa fa-calendar" aria-hidden="true"></i>
			<span class="lbl">Apoio - Eventos</span>
		</span>
		<ul>
            <li><a href="listar_tp_eventos.php"><span class="lbl">Eventos</span></a></li>
		</ul>
	</li>