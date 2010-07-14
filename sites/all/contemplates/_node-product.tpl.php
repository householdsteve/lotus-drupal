<?php 
echo "<pre>";
//print_r($node->content["group_lotus_specific"]);
echo "</pre>";
?>
<?php print $node->content['body']['#value']; ?>
<?php print $node->content["display_price"]['#value']; ?>
<?php print $node->content["dimensions"]['#value']; ?>
<?php print $node->content['group_lotus_specific']['#children'] ?>

