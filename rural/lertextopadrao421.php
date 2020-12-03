    <?php
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        include"../includes/conecta.php";
        $id = $_GET['id'];

       	$result = mysql_query("select * from TAB_APOIO_TPSUBVISIT421 where ATIVO = 1 and ID_PRINCIPAL = ".$id);

		echo "<option value=\"0\" selected=\"selected\">Escolha um subtipo...</option>";
		while($row = mysql_fetch_array($result) ){
        	echo "<option value='".$row['ID']."'>".$row['DESCRICAO']."</option>";
		}
	?>