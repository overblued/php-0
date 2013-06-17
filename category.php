<?php
	require_once("common.php");
	$bgColors = array(
		"item" => "#E6E6FF",
		"combo" => "#FFE6E6",
		"extra" => "#E6FFE6" );
?>
<?php require_once("head.php"); ?>
<!-----------------------------------------------category -------------------------------------------------------------->
<fieldset id="category">
	<legend>Category</legend>
	<table>
	<?php
		$index = 1;
		foreach ($menu->category as $c){
	?>
		<tr>
			<td>
				<a href="selector.php?c=<?php echo $index;?>">
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
<!-----------------------------------------------item selector-------------------------------------------------------------->
<fieldset>
	<legend>
		<?php echo $menu->xpath("//category[$cid]")[0]["name"];?>
	</legend>
<!-------------------------------------show NOTE under category if it has one--------------------------------------------->
	<?php if ($cNote){?>
	<p class="note"><?php echo "--- $cNote ---";?></p>
	<?php }?>
<!-------------------------------------------display items--------------------------------------------->
	<div>
	<?php
		foreach($names as $full=>$short){
			$index = 0;
			foreach ($cItems->$full as $i){
				$index += 1;
	?>

			<<?php (!$_SESSION["allow"][$short] || isset($_SESSION["select"][$short][$index])) ? print("div") :print("a");?>
				class="item"
				style="background-color:<?php echo $bgColors[$full];?><?php if (!$_SESSION["allow"][$short] || isset($_SESSION["select"][$short][$index])) echo ";color:lightgrey";?>"
				href="selector.php?<?php echo $short."=".$index;?>"
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
			</<?php (!$_SESSION["allow"][$short] || isset($_SESSION["select"][$short][$index])) ? print("div") :print("a");?>>
	<?php
			}
		}
	?>
	</div>
<!------------------------------show selected item----------------------------------->
	<hr />
	<div>
	<?php
		foreach ($names as $full=>$short){
			$index = 0;
			foreach ($cItems->$full as $i){
				$index += 1;
				if (! isset($_SESSION["select"][$short][$index])){
					continue;
				}
	?>
			<a class="item"
			   style="background-color:<?php echo $bgColors[$full];?>"
			   href="deselector.php?<?php echo $short."=".$index;?>">
				<?php echo $i["name"];?>
			</a>
	<?php
			}
		}
	?>
	</div>
<!-------------show tooltip if the item has a note------------------>
<?php ?>
	<div>

	</div>
<?php ?>
</fieldset>
<?php require_once("tail.php"); ?>
