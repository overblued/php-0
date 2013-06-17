<?php
	session_start();
	$menu = new SimpleXMLElement(file_get_contents("menu.xml"));
	$cid = $_SESSION["cid"];
	$cItems = $menu->xpath("//category[$cid]/items")[0];
	$cCategory = $menu->xpath("//category[$cid]")[0];
	$cPrices = $cCategory->price;
	$cNote = $cCategory->note;
	$names = array(
		"item" => "i",
		"combo" => "o",
		"extra" => "e",
		"price" => "p"
		);
	$max = array(
		"i" => count($cItems->item),
		"e" => count($cItems->extra),
		"o" => count($cItems->combo),
		"p" => count($cItems->item->price),
	);
?>
