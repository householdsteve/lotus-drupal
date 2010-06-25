<?php 
$imgs = array();
$options = array(
    //'buttonNextEvent' => 'mouseover',
    //'buttonPrevEvent' => 'mouseover',
	'wrap' => 'both',
  );

$nodeImgs = $node->content['field_page_images']['field']['items'][0]["#node"]->field_page_images;

  if($nodeImgs){	
	foreach($nodeImgs as $item){
		$imgs[] = $item['view'];
	}
  }

$p = drupal_get_path('module', 'jcarousel')."/jcarousel/skins/lotus/skin.css";

if(count($nodeImgs) > 0){
	print theme('jcarousel', $imgs, $options, "lotus", $p);
}

?>
<?php print $node->content['body']['#value']; ?>

