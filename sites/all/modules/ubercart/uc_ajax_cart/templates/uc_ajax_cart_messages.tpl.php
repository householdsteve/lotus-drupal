<?php foreach ( $messages as $type => $typeMessages ):?>
	<?php foreach($typeMessages as $message): ?>
		<div class="messages ajax-cart-message <?php print $typeMessage ?>"><?php print $message ?></div>
	<?php endforeach; ?>	
<?php endforeach; ?>
<a href="#" onclick="jQuery.unblockUI();return false;">Close</a>