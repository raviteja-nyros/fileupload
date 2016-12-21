<?php
require 'database.php';

		    $pdo = Database::connect();
			$sql="DELETE FROM customers WHERE id = '".$_POST['id']."'";
			$q = $pdo->prepare($sql);
		    $q->execute(array('id'));
            Database::disconnect();


?>



