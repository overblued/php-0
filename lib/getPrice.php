<?php
	purge($p);
	if ($cb == 1){
		foreach ($s["item"] as $key=>$value){
			foreach ($cItems->item[$key]->price as $prc){
				$p[(string)$prc["size"]] = (float)$prc * $s["count"];
			}
		}
	}else{
		foreach ($s["combo"] as $key=>$value){
			foreach ($cItems->combo[$key]->price as $prc){
				$p[(string)$prc["size"]] = (float)$prc * $s["count"];
			}
		}
	}
	if (count($s["extra"])){
		foreach ($s["extra"] as $key=>$value){
			foreach ($cItems->extra[$key]->price as $prc){
				$p[(string)$prc["size"]] += (float)$prc * $s["count"];
			}
		}
	}
?>
