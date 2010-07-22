<?php if($node->nid == 4){?>
    <div class="map-holder">
      <?php print simpleGmap()?>
      <div id="lotus-map-expand">
        <img src="<?php print get_full_path_to_theme()?>/images/large-down-arrow.gif" width="28" height="28" alt="Large Down Arrow"/>
        <span><?php print t('Espandi Mappa')?></span>
      </div>
    </div>
    <?php print $node->content['body']['#value']; ?>
    <?php
    return;
    } 
?>

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

$nodeImgs = $node->content['field_page_images']['field']['items'][0]["#node"]->field_page_images;

  if($nodeImgs){	
	  foreach($nodeImgs as $item){
		  //$imgs[] = $item['view'];
		  	  
	  }
	  for($x=0; $x < 3; $x++){
	    
	    print $nodeImgs[$x]['view'];
	    
	  }
  }

//$p = drupal_get_path('module', 'jcarousel')."/jcarousel/skins/lotus/skin.css";

if(count($nodeImgs) > 0){
	//print theme('jcarousel', $imgs, $options, "lotus", $p);
}

?>
</div>
<?php print $node->content['body']['#value']; ?>

