<?php
	purge($p);
	if ($cb == 1){
		foreach ($s["item"] as $key=>$value){
			foreach ($cItems->item[$key-1]->price as $prc){
				$p[(string)$prc["size"]] = (float)$prc;
			}
		}
	}else{
		foreach ($s["combo"] as $key=>$value){
			foreach ($cItems->combo[$key-1]->price as $prc){
				$p[(string)$prc["size"]] = (float)$prc;
			}
		}
	}
	if (count($s["extra"])){
		foreach ($s["extra"] as $key=>$value){
			foreach ($cItems->extra[$key-1]->price as $prc){
				$p[(string)$prc["size"]] = (float)$prc + (float)$p[(string)$prc["size"]];
			}
		}
	}
?>
