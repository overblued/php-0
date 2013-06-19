<?php
	require_once("common.php");
	require_once("head.php");
 ?>
<!-----------------------------------------------category -------------------------------------------------------------->
<fieldset id="category">
	<legend>Category</legend>
	<table>
	<?php
		$index = 1;
		foreach ($menu->category as $ctgr){
	?>
		<tr>
			<td>
				<a  class="category" href="selector.php?c=<?php echo $index;?>">
					<?php echo $ctgr["name"];?>
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
	<legend><?php echo $cCategory["name"];?></legend>
<!-------------------------------------show NOTE under category if it has one--------------------------------------------->
	<?php if ($cNote){?>
	<p class="note"><?php echo "--- $cNote ---";?></p>
	<?php }?>
<!-------------------------------------------display items--------------------------------------------->
	<div>
	<?php
		foreach($NAMES as $name){
			$index = 0;
			foreach ($cItems->$name as $itm){
				$index += 1;
	?>

		<<?php (isset($s[$name][$index])) ? print("div") :print("a");?>
			class="items <?php echo $name;?><?php if (isset($s[$name][$index])) echo " fade";?>"
			href="selector.php?<?php echo $name."=".$index;?>"
			<?php if ($itm->note) echo 'title="* '.$itm->note.'"';?>>
<!-------------the line above is for those who have a note------------------>
	<?php
				echo $itm["name"];
				if ($itm->note) echo " *";
	?>
<!----------------show price--------------------->
			<div class="prices<?php if (isset($s[$name][$index])) echo " fade";?>">
	<?php
				$j = 1;
				foreach ($itm->price as $prc){
					echo $prc;
					if (count($itm->price) > $j){
						echo "/";
					}
					$j += 1;
				}
	?>
			</div>
		</<?php (isset($s[$name][$index])) ? print("div") :print("a");?>>
	<?php
			}
		}
	?>
	</div>
<!-----------------------------------------show selected item---------------------------------------------->
	<?php if (count($s["item"]) + count($s["extra"]) + count($s["combo"])){ ?>
	<fieldset>
		<legend>Your choice</legend>
		<div>
	<?php
			foreach ($NAMES as $name){
				$index = 0;
				foreach ($cItems->$name as $itm){
					$index += 1;
					if (! isset($s[$name][$index])){
						continue;
					}
	?>
			<a class="items <?php echo $name;?>"
			   href="deselector.php?<?php echo $name."=".$index;?>">
				<?php echo $itm["name"];?>
			</a>
	<?php
				}
			}
	?>
		</div>
	<!------------------------------show add2cart button----------------------------------->
			<hr />
		<div>
	<?php
			foreach ($p as $key=>$value){
	?>
			<<?php $cb != count($s["item"]) ? print("div") :print("a");?>
				class="items price<?php if ($cb != count($s["item"])) print(" fade");?>"
				href="add2cart.php?p=<?php echo $key;?>">
				<?php printf("%s %.2f$", $key, $value);?>
			<div class="prices">Add to Cart</div>
			</<?php $cb != count($s["item"]) ? print("div") :print("a");?>>
	<?php
		
			}
		}
	?>
		</div>
	</fieldset>
</fieldset>
<pre><?php //print_r($_SESSION);?></pre>
<?php require_once("tail.php"); ?>