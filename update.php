<?php
include("database.php");

$pdo = Database::connect();
			$q = $pdo->prepare("UPDATE customers SET name='".$_POST['data']."' WHERE id=".$_POST["id"]);
			$q->execute();
			Database::disconnect();

?>