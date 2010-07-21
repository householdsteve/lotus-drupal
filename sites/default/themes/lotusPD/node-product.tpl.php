<?php
$base_category = get_category_data($node->taxonomy);
$category_key = array_shift(array_keys($node->taxonomy));
$category = $node->taxonomy[$category_key]->name;

//echo "<pre>";
//print_r($node->content['group_arrivals']['group']['field_arrivo_1']);
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
  	    </div>
  	    
  	    
  	    
  	    <div class="full-content clearfix">
  	      <div class="column left">
  	       <div class="column-header dark">
  	         <span class="colorblock" style="background:#<?php print $base_category->hexcolor; ?>">&nbsp;</span>
  	         <span class="title"><?php print l($category,"catalog/".$node->taxonomy[$category_key]->tid); ?></span>
  	       </div>
              <h2 class="product-title"><?php print $node->title;?></h2>
  	      </div>
  	      
  	      <div class="column middle-right space clearfix">
  	          
  	          <?php // here we will render the contact form
  	           if(user_access('administer product versions')){
                   print drupal_get_form('lotus_product_versions_cart_form'); 
                }
                
                $default_id = $node->attributes[array_shift(array_keys($node->attributes))]->default_option;
                
                $default_product = $node->product_versions[$node->model.".".$default_id]; // this is an object, treat it like one.
                
                
             
              ?>
  	          
  	        <?php //print $content; ?>
  	        
  	        <div class="column middle">
  	            <?php
      	          $nodeImgs = $node->content['field_image_cache']['field']['items'][0]["#node"]->field_image_cache;

                    if($nodeImgs){	
                  	  foreach($nodeImgs as $item){
                    		print $item['view'];
                    	}
                    }
      	        ?>
      	    </div>
  	        
  	        <div class="column product right">
  	            <h3 class="dettagli"><?php print t('Dettagli')?>:</h3>
  	            <h1 class="product-name"><?php print $node->title?></h1>
  	            
  	            <div class="product-detail-holder clearfix">
  	              <div class="product-detail-left">
  	               <div class="dimensions"><?php print t('Dimensioni');?>: <span><?php print $default_product->dimensions; ?></span> </div>
  	               
  	                 <div class="available-colors">
    	                 <div class="available-title"><?php print t('Colori Disponibili');?>:</div>
    	                  <?php
               	        if(count($node->attributes)){
                          foreach ($node->attributes as $attribute) {
                            foreach ($attribute->options as $option) { ?>
                              <div class="color-row<?php if($option->oid == $default_id){ print ' selected';}?>">
                                <span class="color-swatch" style="background:#<?php print $node->attribute_option_hex_colors[$option->oid];?>;">&nbsp;</span>
                                <span class="color-name"><?php print $option->name?></span>
                              </div>

                         <?php } } } ?>
    	               </div>
  	              </div>
  	              
  	              <div class="product-detail-right">
  	                <?php print $node->content["display_price"]['#value']; ?>
  	              </div>
  	            
  	            </div>
  	            
  	            <div class="additional-info">
  	             <h3 class="dettagli"><?php print t('Informazione Aggiuntive')?>:</h3>
  	             
  	                 <?php print $node->content['body']['#value']; ?>

           	        <div class="generic-row">imballo: <?php print $default_product->imballo; ?> </div>

           	        <div class="generic-row">arrivo: <?php print $default_product->arrivo_1; ?> </div>
           	        <div class="generic-row">data_arrivo_1: <?php print $default_product->data_arrivo_1; ?> </div>
           	        <div class="generic-row">arrivo: <?php print $default_product->arrivo_2; ?> </div>
           	        <div class="generic-row">data_arrivo_2: <?php print $default_product->data_arrivo_2; ?> </div>
           	        <div class="generic-row"><?php print $default_product->disponibile_descr; ?> </div>
  	            </div>
  	            
  	            <?php //print $node->content["add_to_cart"]['#value']; ?>
      	        
      	    </div>
  	      </div>
  	    </div>
  	    
  	    