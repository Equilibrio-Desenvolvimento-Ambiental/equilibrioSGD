    <?php
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        include"../includes/conecta.php";
        $id = $_GET['id'];

       	$result = mysql_query("SELECT * FROM TAB_APOIO_TPSUBVISITRIR_INTERF WHERE ID_PRINCIPAL = ".$id.";") or die(mysql_error());

		echo "<option value=\"0\" selected=\"selected\">Escolha um subtipo...</option>";
		while($row = mysql_fetch_array($result) ){
        	echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
		}
	?>