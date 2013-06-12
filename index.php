<?php $menu = new SimpleXMLElement(file_get_contents("menu.xml")); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=GBK">
		<style>
			a {text-decoration: none;}
			header {text-align: center;}
			h1 {font-family:Cambria}
			nav {padding:0 0 1em 0;}
			.category {background: white;
						border:0;}
		</style>
        <title></title>
    </head>
    <body>
		<header>
			<h1>Three Aces</h1>
			<nav>
				<a href="index.php?c=1">MENU</a></td> |
				<a href="index.php">SHOPPING CART</a> |
				<a href="index.php">CONTACT US</a>
			</nav>
		</header>
		
		<div style="overflow: auto;">
			<fieldset style="float:left">
				<legend>Category</legend>
				<table>
				<?php
					$index = 1;
					foreach ($menu->children() as $c){
					//	echo "<button class='category' type='submit' name='c' value='".strval($index)."'>".$c["name"]."</button><br />";
						echo "<tr><td><a margin='1.3em 0' href='index.php?c=".strval($index)."'>".$c["name"]."</a></td><td>";
						if (isset($_GET["c"]) && $_GET["c"]==$index){
							echo "--</td>";
						}else{
							echo ">></td>";
						}
						echo "</tr>";
						$index += 1;
					};
				?>
				</table>
			</fieldset>
			<?php if (isset($_GET["c"])){ ?>
			<fieldset>
				<legend>
					<?php
						$cid = $_GET["c"];
						if ($cid > $menu->category->count() || $cid < 1){
							echo "<script>alert('invalid input');</script>";
							header("Location: index.php?c=1");
						}
						echo $menu->xpath("//category[$cid]")[0]["name"];
					?>
				</legend>
				<table border="1">
					<?php
						$prices = $menu->xpath("//category[$cid]/price");
						$numPrices = count($prices);
						echo "<tr><th rowspan=".$numPrices." colspan=2>Variety</th><th colspan=".$numPrices.">Price($)</th></tr><tr>";
						foreach ($prices as $price){
							if (isset($price["name"])){
								echo "<th>".$price["name"]."</th>";
							}
						}
						echo "</tr>";
						$items = $menu->xpath("//category[$cid]/item");
						$additions = $menu->xpath("//category[$cid]/addition");
						foreach ($items as $item){
							echo "<tr><td>".$item["name"]."</td><td><form><input type='checkbox' name='Car'></form></td>";
							foreach ($prices as $price){
								echo "<td>".$price."</td>";
							}
							echo "</tr>";
						}
						foreach ($additions as $add){
							echo "<tr><td colspan=2>".$add["name"]."</td></tr>";
						}
					?>
				</table>
			</fieldset>
			<?php } ?>
		</div>
		<div>
		<pre>
			<?php
				print_r($numPrices);
			?>
		</pre>
		</div>		
		<div>

		</div>
    </body>
</html>
