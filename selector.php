<?php
// this handles the logic while selecting
	require_once("common.php");

	if (isset($_GET["c"])){
		if ($_GET["c"] > $menu->category->count() || $_GET["c"] < 1) {
			goBack();
		}
		if ($_GET["c"] != $cid){
			$cb = 1;
			purge($_SESSION["price"]);
			purge($s);
			purge($p);
			$cid = $_GET["c"];
		}
		goBack();
	}

	if (! isset($_GET)){
		goBack();
	}
	foreach ($NAMES as $n){
		if (isset($_GET[$n])){
			if ($_GET[$n] > $max[$n] || $_GET[$n] < 1){
				goBack();
			}
			switch ($n) {
				case "item":
					if ($cb == 1){
						purge($s[$n]);
					}else if (count($s[$n]) + 1 > $cb){
						array_pop($s[$n]);
					}
					break;
				case "extra":
					
					break;
				case "combo":
					purge($s[$n]);
					$cb = (int)$cItems->combo[$_GET[$n]-1]["max"];
					if (count($s["item"]) > $cb){
						purge($s["item"], $cb);
					}
					break;
				case "price":
					break;
				default:
					break;
			}
			$s[$n][$_GET[$n]] = 1;
		}
	}
	require_once("getPrice.php");
	goBack();
?>

