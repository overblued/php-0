<?php
	require_once("../lib/common.php");
	if (isset($_GET["p"]) && isset($p[$_GET["p"]]) && $cb == count($s["item"])){
		$name="";
		foreach ($NAMES as $n){
			foreach ($s[$n] as $value){
				$name .= $value.".";
			}
		}
		//$name.= $_GET["p"];
		foreach ($_SESSION["cart"] as &$item){
			if (($name == $item[0]) && $_GET["p"]==$item[1]){
				$item[2]+= $s["count"];
				$item[3]+= $p[$_GET["p"]];
				$_SESSION["note"] = "New item has been added to your cart";
				clearSelect();
				goBack();
				//once an exits item is found then exit
			}
		}
		$_SESSION["cart"][]=array($name,$_GET["p"],$s["count"],$p[$_GET["p"]]);
		$_SESSION["note"] = "New item has been added to your cart";
		clearSelect();
	}
	goBack();
?>
