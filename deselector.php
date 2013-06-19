<?php
	require_once("common.php");
	if (! isset($_GET)){
		goBack();
	}
	foreach ($NAMES as $n){
		if (isset($_GET[$n])){
			if ($_GET[$n] > $max[$n] || $_GET[$n] < 1){
				goBack();
			}
			unset($s[$n][$_GET[$n]]);
			switch ($n) {
					case "item":
						break;
					case "combo":
						$cb = 1;
						if (count($s["item"]) > 1){
							purge($s["item"],1);
						}
						break;
					case "price":
						break;
					default:
						break;
			}
		}
	}
	require_once("getPrice.php");
	goBack();
?>