<?php
	require_once("../lib/common.php");
	require_once("../lib/head.php");
 ?>
<fieldset  id="cart">
	<legend>Shopping Cart</legend>
	<?php if (count($_SESSION["cart"])) { ?>
	<table>
		<tr>
			<th>Item</th>
			<th>Size</th>
			<th>Count</th>
			<th>Price</th>
		</tr>
		<?php foreach ($_SESSION["cart"] as $item) { ?>
		<tr>
			<?php foreach ($item as $value){ ?>
			<td><?php echo $value?></td>
			<?php }?>
		</tr>
		<?php }?>
	</table>
	<?php }else{ ?>
	<p class="note">Your cart is empty.</p>
	<?php }?>
</fieldset>
	
<?php require_once("../lib/tail.php"); ?>