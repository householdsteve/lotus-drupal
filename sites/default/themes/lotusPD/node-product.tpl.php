<?php
  loadProductUiHelpers();
  $base_category = get_category_data($node->taxonomy);
  $category_key = array_shift(array_keys($node->taxonomy));
  $category = $node->taxonomy[$category_key]->name;

  // find out images for this node.
  $nodeImgs = $node->content['field_image_cache']['field']['items'][0]["#node"]->field_image_cache;

    if($nodeImgs){
      $main_img = $nodeImgs[0]['view'];	
      $thumbs = "";
      $fulls = "";
  	  foreach($nodeImgs as $item){
  	    // loop through all images and generate thumbs for the left column
    		//print $item['view'];
    		$patterns = array("/\.jpg$/","/\./");
    		$replace = array('','-');
    		$className = preg_replace($patterns, $replace, $item['filename']);
	
    		$thumbs .= l(theme('imagecache', 'page_thumb', $item['filepath']), $item['filepath'], array('html' => TRUE, 'attributes' => array('class' => $className)));
    		
    		$fulls .= l(theme('imagecache', 'product_full', $item['filepath']), $item['filepath'], array('html' => TRUE, 'attributes' => array('class' => "prettyPhoto", "id" => $className)));
    	}
    }
//echo "<pre>";
//print_r($node);
//echo "</pre>";

?>
			  <div class="content-filters clearfix">
  	      <form>
  	         <fieldset class="clearfix">
  	      <div class="filter left">
  	        <img src="<?php print base_path() . path_to_theme(); ?>/images/select-categoy.gif" width="209" height="29" alt="Select Categoy" />
  	      </div>
  	      <div class="filter middle">
  	          <span class="input_wrapper"><?php print learn_taxonomy_ancestry(10); ?></span>
  	      </div>
  	      <div class="filter right">
  	        <img class="imageblock" src="<?php print base_path() . path_to_theme(); ?>/images/cerca-label.gif" width="180" height="29" alt="Cerca Label" />
  	          <span class="input_wrapper"><input type="text" name="cerca" value="" id="cerca" /></span>
  	        <input class="submit-icon" type="submit" name="submit" value="submit" id="submit" />
  	      </div>
  	      </fieldset> 
     	  </form>
     	  
     	    <div id="shopping-links">
     	      <?php print lotus_shopping_links(); ?>
     	    </div>
     	  
  	    </div>
  	    
  	    
  	    
  	    <div class="full-content clearfix">
  	      <div class="column product left">
  	       <div class="column-header dark">
  	         <span class="colorblock" style="background:#<?php print $base_category->hexcolor; ?>">&nbsp;</span>
  	         <span class="title"><?php print l($category,"catalog/".$node->taxonomy[$category_key]->tid); ?></span>	         
  	       </div>
              <h2 class="product-title"><?php print $node->title;?></h2>
              
              <div class="product-thumbs clearfix"><?php print $thumbs; ?></div>
              
  	      </div>
  	      
  	      <div class="column middle-right space clearfix">
  	          
  	          <?php
  	                          
                $default_id = $node->attributes[array_shift(array_keys($node->attributes))]->default_option;
                
                $default_product = $node->product_versions[$node->model.".".$default_id]; // this is an object, treat it like one.
              ?>
  	          
  	        <?php //print $content; ?>
  	        
  	        <div class="column product middle">
  	          <?php print $fulls; ?>
  	            <!-- image goes here. make some nice js thingy ;) //-->
      	    </div>
  	        
  	        <div class="column product right">
  	            <h3 class="dettagli"><?php print t('Dettagli')?>:</h3>
  	            <h1 class="product-name"><?php print $node->title?></h1>
  	            
  	            <div class="product-detail-holder clearfix">
  	              <div class="product-detail-left">
  	               <?php if($default_product->dimensions):?>
  	               <div class="dimensions"><?php print t('Dimensioni');?>: <span><?php print $default_product->dimensions; ?></span> </div>
  	               <?php endif?>
  	                 <div class="available-colors">
    	                 <div class="available-title"><?php print t('Colori Disponibili');?>:</div>
    	                  <?php
               	        if(count($node->attributes)){
                          foreach ($node->attributes as $attribute) {
                            foreach ($attribute->options as $option) { ?>
                              <div class="color-row<?php if($option->oid == $default_id){ print ' selected-old';}?>">
                                <span class="color-swatch<?php (!processColorSwatch($node->attribute_option_hex_colors[$option->oid][0])) ? print ' dark' : '' ?>" style="background:#<?php print $node->attribute_option_hex_colors[$option->oid][0];?>;">
                                  
                                  <?php
                                  // check if 2 colors are supplied. if so lets make a split color swatch, otherwise print out a space
                                  if($node->attribute_option_hex_colors[$option->oid][1]){
                                    print '<img class="split-color" src="'.get_full_path_to_theme().'/color-swatch.php?color1='.$node->attribute_option_hex_colors[$option->oid][0].'&amp;color2='.$node->attribute_option_hex_colors[$option->oid][1].'&amp;width=15&amp;height=15" />';        
                                
                                  }
                                  ?>
                                </span>
                                <span class="color-name"><?php print $option->name?></span>
                              </div>

                         <?php } } } ?>
    	               </div>
  	              </div>
  	              
  	              <div class="product-detail-right">
  	                <?php if(user_access('view product version')):?>
  	                  <div class="available-title"><?php print t('Prezzo');?>:</div>  
  	                  <?php print $node->content["display_price"]['#value']; ?>
  	                <?php endif ?>
  	                
  	                <div class="product-flags-page">
  	                <?php
  	                  if(in_array(7,array_keys($node->taxonomy))){ // checks to see if item is novita by taxonomy
                        print '<div class="lotus_flags new">&nbsp;</div>';
                      }
                      
                      if(in_array(29,array_keys($node->taxonomy))){ // checks to see if item is offerta by taxonomy
                        print '<div class="lotus_flags offer">&nbsp;</div>';
                      }
                      
                      if($node->field_esclusiva[0]['value']){ // checks to see if item is exclusive by cck field
                        print '<div class="lotus_flags exclusive">&nbsp;</div>';
                      }
  	                
  	                ?>
  	                </div>
  	              </div>
  	            
  	            </div>
  	            
  	            <div class="additional-info">
  	             <h3 class="dettagli"><?php print t('Informazione Aggiuntive')?>:</h3>
  	             
  	                 <?php print $node->content['body']['#value']; ?>
                    
                    <?php if(!user_access('view product version')):?>
           	          <div class="generic-row">imballo: <?php print $default_product->imballo; ?> </div>
           	        <?php elseif(1 == 2): ?>
           	          <div class="generic-row">arrivo: <?php print $default_product->arrivo_1; ?> </div>
             	        <div class="generic-row">data_arrivo_1: <?php print $default_product->data_arrivo_1; ?> </div>
             	        <div class="generic-row">arrivo: <?php print $default_product->arrivo_2; ?> </div>
             	        <div class="generic-row">data_arrivo_2: <?php print $default_product->data_arrivo_2; ?> </div>
             	        <div class="generic-row"><?php print $default_product->disponibile_descr; ?> </div>
           	        <?php endif ?>
           	        
           	        
  	            </div>
  	            
  	            <?php //print $node->content["add_to_cart"]['#value']; ?>
      	        
      	        <div id="add_to_cart_holder">
       	          
       	        </div>
      	    </div>
      	    
      	    <div class="column middle-right table clearfix">
      	    <?php
  	         if(user_access('view product version')){
                 print drupal_get_form('lotus_product_versions_cart_form',$node); 
              }
  	        ?>
  	        </div>
  	        <!-- end of middle right div holder -->
      	    
  	      </div>
  	    
  	    
  	    
  	  </div>
  	    
  	    