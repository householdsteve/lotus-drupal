<?php
// $Id: uc_ajax_cart_messages.tpl.php,v 1.1.2.4 2010/04/28 15:13:45 erikseifert Exp $
?>
<?php foreach ( $messages as $type => $typeMessages ):?>
	<?php foreach($typeMessages as $message): ?>
		<div class="messages ajax-cart-message <?php print $typeMessage ?>"><?php print $message ?></div>
	<?php endforeach; ?>	
<?php endforeach; ?>
<a href="#" onclick="jQuery.unblockUI();return false;">Close</a>