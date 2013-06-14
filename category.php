<?php
	session_start();
	$menu = new SimpleXMLElement(file_get_contents("menu.xml"));
//	avoid invalid category
//	remember current category, so we can get back to it;
	if (isset($_GET["c"]) && $_GET["c"] <= $menu->category->count() && $_GET["c"] > 0){
		$cid = $_GET["c"];
		$_SESSION["cid"]=$cid;
	}else{
		if ( ! isset($_SESSION["cid"])){
			$_SESSION["cid"]=1;
		}
		header("Location: category.php?c=".$_SESSION["cid"]);
	}
	$items = $menu->xpath("//category[$cid]/item");
	if (isset($_GET["i"])){
		if ($_GET["i"] > count($items) || $_GET["i"] < 1){
			header("Location: category.php?c=".$_SESSION["cid"]);
		}else{
			$iid = $_GET["i"];
			$item = $menu->xpath("//category[$cid]/item[$iid]")[0];
			$prices = $menu->xpath("//category[$cid]/item[$iid]/price");
			if (!count($prices)){
				$prices = $menu->xpath("//category[$cid]/price");
			}
		}
	}
	$additions = $menu->xpath("//category[$cid]/addition");

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
					<a margin="1.3em 0" href="category.php?c=<?php echo $index;?>">
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
		<div>
		<?php
			$index = 1;
			foreach ($items as $i){
		?>
			<a class="item" href="category.php?c=<?php echo $cid;?>&amp;i=<?php echo $index;?>">
					<?php echo $i["name"];?>
			</a>
		<?php
				$index += 1;
			}
		?>
		</div>
		<?php if (isset($_GET["i"])) { ?>
		<hr />
		<table>
			<tr>
				<th>Your Choice</th>
			<?php foreach ($prices as $p){ ?>
				<th><?php echo $p["name"];?></th>
			<?php } ?>
			<?php if (count($additions)){ ?>
				<th>Extra</th>
			<?php }?>
			</tr>
			<tr>
				<form action="add2cart.php" method="post">
					<td><?php echo $item["name"];?></td>
					<?php
						$index = 1;
						foreach ($prices as $price){
					?>
					<td class="choosing">
						<?php echo $price; ?>
						<input type="radio" name="size" value="<?php echo $price["name"]; ?>"
								 <?php $index == 1 ? print("checked") : print(""); ?>
						/>
					</td>
					<?php 
							$index += 1;
						}
					?>
					
				</form>
			</tr>
			<?php } ?>
		</table>
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


		print_r($item[0]);
		if ($item["price"]){
			echo "yes";
		}else{
			echo "no";
		}
	?>
</pre>
<?php require_once("tail.php"); ?>
