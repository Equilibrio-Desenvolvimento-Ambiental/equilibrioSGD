    <?php
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        include"../includes/conecta.php";
        $id = $_GET['id'];

       	$result = mysql_query("select TEXTO_PADRAO from TAB_APOIO_TPSUBVISIT415 where ID = ".$id);

		while($row = mysql_fetch_array($result) ){
        	echo $row['TEXTO_PADRAO'];
		}
	?>