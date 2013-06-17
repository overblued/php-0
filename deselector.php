<?php
	require_once("common.php");
	if (! isset($_GET)){
		goBack();
	}
	foreach ($names as $n){
		if (isset($_GET[$n])){
			if ($_GET[$n] > $max[$n] || $_GET[$n] < 1){
				goBack();
			}
			unset($_SESSION["select"][$n][$_GET[$n]]);
			switch ($n) {
					case "i":
						if (! $_SESSION["allow"]["o"] ){
							$_SESSION["allow"]["i"] = 1;
						}
						break;
					case "o":
						$_SESSION["combo"] = 1;
						$_SESSION["allow"]["o"] = 1;
						$_SESSION["allow"]["i"] = 1;
						$_SESSION["select"]["i"] = array();
						break;
					case "p":
						$_SESSION["allow"]["p"] = 1;
						break;
					default:
						break;
			}
			header("Location: category.php");
		}
	}
?>

<?php
	function goBack(){
		header("Location: category.php");
		exit();
	}
?>