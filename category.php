<?php
	session_start();
	$menu = new SimpleXMLElement(file_get_contents("menu.xml"));
//------------sanity check--------------------
	if ( ! isset($_GET["c"]) || ($_GET["c"] > $menu->category->count() || $_GET["c"] < 1)){
		if ( ! isset($_SESSION["cid"])){
			$_SESSION["cid"]=1;
		}
		header("Location: category.php?c=".$_SESSION["cid"]);
	}
	$cid = $_GET["c"];
	$_SESSION["cid"] = $cid;
	$cPrices = $menu->xpath("//category[$cid]/price");
	$cItems = $menu->xpath("//category[$cid]/item");
	$cNote = $menu->xpath("//category[$cid]/note");
	$cExtras = $menu->xpath("//category[$cid]/extra");
	$cCombo = $menu->xpath("//category[$cid]/combo");
	if (isset($_GET["i"])){
		if ($_GET["i"] > count($cItems) || $_GET["i"] < 1){
			if ( ! isset($_SESSION["iid"])){
				$_SESSION["iid"]=1;
			}
			header("Location: category.php?c=".$_SESSION["cid"]."&i=".$_SESSION["iid"]);
		}
		$iid = $_GET["i"];
		$_SESSION["iid"] = $iid;
		$iItem = $cItems[$iid-1];
		$iPrices = $iItem->price;
		if (!count($iPrices)){
			$iPrices = $cPrices;
		}
	}
	$extras = $menu->xpath("//category[$cid]/extra");

?>
<?php require_once("head.php"); ?>
<!--category-->
<div>
	<fieldset id="category">
		<legend>Category</legend>
		<table>
		<?php
			$index = 1;
			foreach ($menu->category as $c){
		?>
			<tr>
				<td>
					<a href="category.php?c=<?php echo $index;?>">
						<?php echo $c["name"];?>
					</a>
				</td>
				<td>
					<?php $cid == $index ? print("---") : print(">>");?>
				</td>
			</tr>
		<?php
				$index += 1;
			};
		?>
		</table>
	</fieldset>
	<!--show items in category-->
	<fieldset>
		<legend>
			<?php echo $menu->xpath("//category[$cid]")[0]["name"];?>
		</legend>
<!-------------------------------------show NOTE under category if it has one--------------------------------------------->
		<?php if (count($cNote)){?>
		<p class="note"><?php echo "--- $cNote[0] ---";?></p>
		<?php }?>
<!-------------------------------------------display items--------------------------------------------->
		<div>
		<?php
			$index = 1;
			foreach ($cItems as $i){
		?>

			<a class="item" href="category.php?c=<?php echo $cid;?>&amp;i=<?php echo $index;?>"
			<?php if ($i->note) echo 'title="* '.$i->note.'"';?>>
	<!-------------show tooltip if the item has a note------------------>
			<?php
				echo $i["name"];
				if ($i->note) echo " *";
			?>
	<!----------------show price--------------------->
			<?php  ($i->price[0])? $prices = $i->price : $prices = $cPrices;?>
				<div class="price">
				<?php
					$j = 1;
					foreach ($prices as $p){
						echo $p;
						if (count($prices) > $j){
							echo "/";
						}
						$j += 1;
					}
				?>
				</div>
			</a>
		<?php
				$index += 1;
			}
		?>
		</div>
<!-------------------------------------show combo------------------------------------------>
		<?php if ($cCombo) { ?>
		<hr />
			<?php
				$index = 1;
				foreach ($cCombo as $c){
			?>
			<a class="item" href="category.php?c=<?php echo $cid;?>&amp;o=<?php echo $index;?>">
				<?php echo $c["name"];?>
			</a>
			<?php
					$index += 1;
				}
			}
		?>
<!------------------------------show only after selected one item----------------------------------->
		<?php if (isset($iItem)) { ?>
		<hr />
		
	<!----------------1st row title--------------------->
		<table>
			<tr>
				<th><?php echo $iItem["name"];?></th>
				<?php if ($iItem->note) { ?>
				<td class="note"><?php echo ": ".$iItem->note;?></td>
				<?php } ?>
			</tr>
		</table>
	<!----------------2nd row --------------------->
		<table>
			<form action="add2cart.php" method="post">
				<tr>
		<!-------------- size  ------------->
					<?php
						$index = 1;
						foreach ($iPrices as $p){
					?>
					<td class="choosing">
						<?php echo $p["name"]; ?>
						<input type="radio" name="price" value="<?php echo $index; ?>"
								 <?php $index == 1 ? print("checked") : print(""); ?>
						/>
					</td>
					<?php 
							$index += 1;
						}
					?>
		<!-------------- extra------------->
					<?php
						if ($cExtras){
							$index = 1;
							foreach ($cExtras as $e){
					?>
					<td class="choosing">
						<?php echo $e["name"]; ?>
						<input type="checkbox" name="extra" value="<?php echo $index; ?>" />
					</td>
					<?php
								$index += 1;
							}
						}
					?>
				</tr>
			</form>
	<!----------------3rd row note--------------------->

		</table>
		<?php } ?>
	</fieldset>
</div>
<pre>
	<?php
		echo "session:<br />";
		print_r($_SESSION);
		echo "post:<br />";
		print_r($_POST);
		echo "get:<br />";
		print_r($_GET);
		echo "<br />";


		print_r($cNote);
		if ($iItem["price"]){
			echo "yes";
		}else{
			echo "no";
		}
	?>
</pre>
<?php require_once("tail.php"); ?>
