<?php
	require_once("common.php");
	if (isset($_GET["p"]) && isset($p[$_GET["p"]]) && $cb == count($s["item"])){
		header("Location: cart.php");
	}else{
		goBack();
	}
?>
