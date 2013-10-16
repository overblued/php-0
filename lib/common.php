<?php
	session_start();
	if (!isset($_SESSION["cid"])){
		$_SESSION["cid"] = 0;
		$_SESSION["combo"] = 1;
		$_SESSION["select"] = array(
			"item" => array (),
			"extra" => array (),
			"combo" => array (),
			"price" => array(),
			"count" => 1
		);
		$_SESSION["cart"] = array();
	}
	$s = &$_SESSION["select"];
	$cb = &$_SESSION["combo"];
	$cid = &$_SESSION["cid"];
	$p = &$s["price"];
	$menu = new SimpleXMLElement(file_get_contents("../etc/menu.xml"));

	$cCategory = $menu->xpath("//category[$cid+1]")[0];
	$cItems = $cCategory->items;
	$cPrices = $cCategory->price;
	$cNote = $cCategory->note;
	$NAMES = array("combo", "item", "extra");
	//used for sanity check
	$max = array(
		"item" => count($cItems->item),
		"extra" => count($cItems->extra),
		"combo" => count($cItems->combo),
		"count" => 99,
		"c" => $menu->category->count(),
		"d" =>1,
	);
?>
<?php
	function goBack(){
		header("Location: ../0/");
		exit();
	}
	//safely delete the content of an array
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
	//clear current selected item; happens after u change category or add something to the cart
	function clearSelect(){
		$_SESSION["combo"] = 1;
		purge($_SESSION["select"]);
		$_SESSION["select"]["count"]=1;
	}
?>