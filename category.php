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
?>
<?php require_once("head.php"); ?>
<!--category-->
<div>
	<fieldset id="category">
		<legend>Category</legend>
		<table>
		<?php
			$index = 1;
			foreach ($menu->children() as $c){
				echo "<tr><td><a margin='1.3em 0' href='category.php?c=".strval($index)."'>".$c["name"]."</a></td><td>";
				if ($cid == $index){
					echo "---";
				}else{
					echo ">>";
				}
				echo "</td></tr>";
				$index += 1;
			};
		?>
		</table>
	</fieldset>
	<!--show items in category-->
	<fieldset>
		<legend>
			<?php
				echo $menu->xpath("//category[$cid]")[0]["name"];
			?>
		</legend>
		<div>
			<form action="category.php" method="get">
				<input type="hidden" name="c" value="<?php echo $cid;?>" />
			<?php
				$items = $menu->xpath("//category[$cid]/item");
				$additions = $menu->xpath("//category[$cid]/addition");
				$index=1;
				foreach ($items as $item){
					echo "<button class='item' type='submit' name='i' value='".$index."'>".$item["name"]."</button>";
					$index += 1;
				}
			?>
			</form>
			<?php if (isset($_GET["i"])) { ?>
			<hr />
			<form >
				<tr>
					<th>Your Choice</th>
				</tr>

			</form>



			<?php } ?>
		</div>
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
	?>
</pre>
<?php require_once("tail.php"); ?>
