<?php
// this handles the logic while selecting
	session_start();
	$menu = new SimpleXMLElement(file_get_contents("menu.xml"));

	$cid = $_SESSION["cid"];
	$category = $menu->xpath("//category[$cid]")[0];

	if (! isset($_SESSION["select"])){
		$_SESSION["select"] = array(
			"i" => array (),
			"e" => array (),
			"p" => array (),
			"o" => array (),
		);
	}
	if (! isset($_SESSION["allow"])){
		$_SESSION["allow"] = array(
			"i" => 1,
			"p" => 1,
			"o" => 1,
			"e" => 1,
		);
	}
	$names = array("i", "e", "p", "o");
	$max = array(
		"i" => count($category->item),
		"e" => count($category->extra),
		"p" => count($category->item->price),
		"o" => count($category->combo)
	);
	foreach ($names as $n){
		if (isset($_GET[$n])){
			if ($_GET[$n] > $max[$n] || $_GET[$n] < 1 || ! $_SESSION["allow"][$n]){
				header("Location: category.php?c=".$cid);
			}
			$_SESSION["select"][$n][$_GET[$n]] = 1;
			switch ($n) {
				case "i":
					if (! $_SESSION["allow"]["o"] ||
							(count($_SESSION["select"]["i"]) >=  $category->combo[$_SESSION["select"]["o"][0]-1]->max)){
						$_SESSION["allow"]["i"] = 0;
					}
					break;
				case "p":
					$_SESSION["allow"]["p"] = 0;
					break;
				case "o":
					$_SESSION["allow"]["o"] = 0;
					$_SESSION["allow"]["i"] = 1;
					break;
				default:
					break;
			}
		}
	}

?>