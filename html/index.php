<?php
	require_once("../lib/common.php");
	require_once("../lib/head.php");
 ?>

<!-----------------------------------------------category -------------------------------------------------------------->
<fieldset id="category">
	<legend>Category</legend>
	<?php
		$index = 0;
		foreach ($menu->category as $ctgr){
	?>
			<a  class="category<?php if ($cid==$index) echo ' bold'; else echo '"href="selector?c='.$index; ?>" >
				<?php echo $ctgr["name"];?>
			</a>
			<br />

	<?php
			$index += 1;
		};
	?>
</fieldset>
<!-----------------------------------------------item selector-------------------------------------------------------------->
<fieldset  id="showcase">
	<legend><?php echo $cCategory["name"];?></legend>
<!-------------------------------------------display items--------------------------------------------->

<?php//----------------show NOTE under category if it has one-----------------------------?>
<?php if ($cNote){?>
	<p class="note"><?php echo "&#8212; $cNote &#8212;";?></p>
<?php }?>
<?php//----------------show items-----------------------------?>
	<?php
		foreach($NAMES as $name){
			$index = 0;
			foreach ($cItems->$name as $itm){
	?>

		<a	class="items <?php echo $name;?><?php if (isset($s[$name][$index])) echo ' fade"';
				else echo '" href="selector?'.$name.'='.$index.'"';?>
			<?php if ($itm->note) echo 'title="* '.$itm->note.'"';?>>
	<?php
				echo $itm["name"];
				if ($itm->note) echo " *";
	?>
<?php//----------------show price---------------------?>
			<p class="prices<?php if (isset($s[$name][$index])) echo " fade";?>">
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
			</p>
		</a>
	<?php
				$index += 1;
			}
		}
	?>

<!-----------------------------------------show selected item---------------------------------------------->
	<?php if (isset($_SESSION["note"])) { ?>
	<hr />
	<p class="note"><?php echo $_SESSION["note"];?></p>
	<?php
			unset($_SESSION["note"]);
		}
	?>
	<?php if (count($s["item"]) + count($s["extra"]) + count($s["combo"])){ ?>

	<div id="choices">
		<hr />

	<?php
		foreach ($NAMES as $name){
			foreach ($s[$name] as $itemid=>$itemname){
	?>
		<a class="items <?php echo $name;?>"
		   href="selector?<?php echo $name."=".$itemid;?>&d=1">
			<?php echo $itemname;?>
		</a>
	<?php
			}
		}
	?>
		<?php // choice of amount ?>
		<form action="selector" method="get" >
			X&nbsp;
			<input type="number" min="1" max="<?php echo $max["count"]?>" name="count" value="<?php echo $s["count"];?>" onchange="document.forms[0].submit()"/>
		</form>
		<hr />
	<!------------------------------show add2cart button----------------------------------->


	<?php
		foreach ($p as $key=>$value){
	?>
		<a	class="items price<?php if ($cb != count($s["item"])) echo " fade";
			else echo '"href="add2cart?p='.$key;?>">
			<?php printf("%s %.2f$", $key, $value);?>
			<p class="prices">Add to Cart</p>
		</a>
	<?php
		}
	?>

	</div>
	<?php
		}
	?>
</fieldset>
<?php require_once("../lib/tail.php"); ?>