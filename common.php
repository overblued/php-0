<?php
	session_start();
	if (!isset($_SESSION["cid"])){
		$_SESSION["cid"] = 1;
		$_SESSION["combo"] = 1;
		$_SESSION["price"] = array();
		$_SESSION["select"] = array(
			"item" => array (),
			"extra" => array (),
			"combo" => array (),
			"price" => array (),
		);
	}
	$s = &$_SESSION["select"];
	$cb = &$_SESSION["combo"];
	$cid = &$_SESSION["cid"];
	$p = &$_SESSION["price"];
	$menu = new SimpleXMLElement(file_get_contents("store.xml"));

	$cCategory = $menu->xpath("//category[$cid]")[0];
	$cItems = $cCategory->items;//$menu->xpath("//category[$cid]/items")[0];
	$cPrices = $cCategory->price;
	$cNote = $cCategory->note;
	$NAMES = array("combo", "item", "extra", "price");
	$max = array(
		"item" => count($cItems->item),
		"extra" => count($cItems->extra),
		"combo" => count($cItems->combo),
		"price" => count($cItems->item->price),
	);
?>
<?php
	function goBack(){
		header("Location: menu.php");
		exit();
	}
	function purge(&$array, $index = 0){
		if (is_array($array)){
			$max = count($array);
			foreach ($array as $key=>$value){
				$index += 1;
				if (is_array($array[$key])){
					purge($array[$key]);
				}else{
					unset($array[$key]);
					if ($max == $index){
						break;
					}
				}
			}
		}
	}
?>