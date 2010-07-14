<?php
//echo "<pre>";
//var_dump($node);
//echo "</pre>";
$category_key = array_shift(array_keys($node->taxonomy));
$category = $node->taxonomy[$category_key]->name;
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
  	         <span class="colorblock" style="background:#<?php print random_hex_color(); ?>">&nbsp;</span><span class="title"><?php print $category; ?></span>
  	       </div>
              <h2 class="product-title"><?php print $node->title;?></h2>
  	      </div>
  	      
  	      <div class="column middle-right space">
  	        
  	        <?php print $content; ?>
  	       
  	      </div>
  	    </div>
  	    
  	    