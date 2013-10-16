<?php
// this handles the main logic while selecting
	require_once("../lib/common.php");

	if (! isset($_GET)){ goBack(); }

	foreach ($_GET as $n => $value) {
		//sanity check
		if (!isset($max[$n]) || !is_numeric($value) || $value >= $max[$n] || $value < 0){
			goBack();
		}
		//for deselection
		if (isset($_GET["d"]) && $n != "d"){
			unset($s[$n][$value]);
			//handle differently if it's a combo that you removed,
			if ($n == "combo"){
				$cb = 1;
				if (count($s["item"]) > 1){
					purge($s["item"],1);
				}
			}
			if (count($s["item"]) + count($s["extra"]) + count($s["combo"])){
				$s["count"]=1;
			}
			break;
		}
		switch ($n) {
			case "c":
				if ($value != $cid){
					clearSelect();
					$cid = $_GET["c"];
				}
				goBack();
			case "item":
				if ($cb == 1){
					purge($s[$n]);
				}else if (count($s[$n]) + 1 > $cb){
					array_pop($s[$n]);
				}
				$s[$n][$value] = (string)$cItems->item[+$value]["name"];
				break;
			case "extra":
				$s[$n][$value] = (string)$cItems->extra[+$value]["name"];
				break;
			case "combo":
				purge($s[$n]);
				$cb = (int)$cItems->combo[+$value]["max"];
				if (count($s["item"]) > $cb){
					purge($s["item"], $cb);
				}
				$s[$n][$value] = (string)$cItems->combo[+$value]["name"];
				break;
			case "count":
				$s[$n] = $value;
				break 2;
			default:
				break;
		}
	}
	require_once("../lib/getPrice.php");
	goBack();
?>

