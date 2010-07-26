<div class="page-top-images">
<?php 
loadPrettyPhotoHelpers();
$imgs = array();
$options = array(
    //'buttonNextEvent' => 'mouseover',
    //'buttonPrevEvent' => 'mouseover',
    //'itemLoadCallback' => '{onBeforeAnimation: mycarousel_itemLoadCallback}',
	'wrap' => 'both',
  );

$nodeImgs = $node->field_page_images_form;
  if($nodeImgs){	
	  foreach($nodeImgs as $item){
		  //$imgs[] = $item['view'];
		  	  
	  }
	  for($x=0; $x < 3; $x++){
	    
	    //print $nodeImgs[$x]['view'];
	    print l(theme('imagecache', 'page_image', $nodeImgs[$x]['filepath']), $nodeImgs[$x]['filepath'], array('html' => TRUE,'attributes' => array('class' => "imagecache-page_image")));
	    
	  }
  }

//$p = drupal_get_path('module', 'jcarousel')."/jcarousel/skins/lotus/skin.css";

if(count($nodeImgs) > 0){
	//print theme('jcarousel', $imgs, $options, "lotus", $p);
}
echo '<pre>';
//print_r($node);
echo'</pre>';
?>
</div>
<?php print $node->body; ?>

