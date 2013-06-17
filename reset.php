<?php
	session_start();

	$_SESSION["cid"] = 1;
	$_SESSION["combo"] = 1;
	$_SESSION["select"] = array(
			"i" => array (),
			"e" => array (),
			"o" => array (),
			"p" => array (),
	);
	$_SESSION["allow"] = array(
			"i" => 1,
			"e" => 1,
			"o" => 1,
			"p" => 0,
	);

?>
