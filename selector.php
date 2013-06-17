<?php
// this handles the logic while selecting
	require_once("common.php");
	
	if (!isset($_SESSION["cid"]) || (isset($_GET["c"]) && $_GET["c"] != $_SESSION["cid"])){
		require_once("reset.php");
	}
	if (isset($_GET["c"])){
		if ($_GET["c"] > $menu->category->count() || $_GET["c"] < 1) {
			goBack();
		}
		$_SESSION["cid"] = $_GET["c"];
		goBack();
	}

	if (! isset($_GET)){
		goBack();
	}

	foreach ($names as $n){
		if (isset($_GET[$n])){
			if ($_GET[$n] > $max[$n] || $_GET[$n] < 1){
				goBack();
			}
			if ($n == "i" && $_SESSION["combo"] == 1){
				$_SESSION["select"]["i"] = array();
			}
			if ($_SESSION["allow"][$n]){
				$_SESSION["select"][$n][$_GET[$n]] = 1;
			}else{
				goBack();
			}
			switch ($n) {
				case "i":
					if (! $_SESSION["allow"]["o"] && count($_SESSION["select"]["i"]) >= $_SESSION["combo"]){
						$_SESSION["allow"]["i"] = 0;
					}
					break;
				case "o":
					$_SESSION["combo"] = (int)$cItems->combo[$_GET[$n]-1]["max"];
					$_SESSION["allow"]["o"] = 0;
					$_SESSION["allow"]["i"] = 1;
					break;
				case "p":
					$_SESSION["allow"]["p"] = 0;
					break;
				default:
					break;
			}
		}
	}
	goBack();
?>

<?php
	function goBack(){
		header("Location: category.php");
		exit();
	}
?>