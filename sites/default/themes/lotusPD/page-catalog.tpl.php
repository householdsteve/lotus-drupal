<?php include("includes/header.inc"); ?>
			
				<?php if (!empty($tabs)) { echo $tabs; }; ?>
				<?php if (!empty($tabs2)) { echo $tabs2; } ?>
				<?php if (!empty($help)) { echo $help; } ?>
				<?php if (!empty($messages)) { echo $messages; } ?>
				
			<div class="content-body clearfix">
			  <div class="content-filters clearfix">
  	     
  	       
  	      <div class="filter left">
  	        <img src="<?php print $base_path . $directory ?>/images/select-categoy.gif" width="209" height="29" alt="Select Categoy" />
  	      </div>
  	      <div class="filter middle">
  	          <span class="input_wrapper"><?php print learn_taxonomy_ancestry(10); ?></span>
  	      </div>
  	      <div class="filter right">
  	        <?php if(user_access('view product version')):?>
  	        <form id="page-catalog_submit_prices" action="<?php print base_path().drupal_get_path_alias("catalog/ricerca");?>" method="post" accept-charset="utf-8">
  	           <fieldset class="">
  	          <span class="input_wrapper text">
  	              <span class="lead">PREZZO</span>
  	              <span>DA:</span>
  	              <input type="text" name="from" value="" id="from" style="width:35px;" />
  	              <span>A</span>
  	              <input type="text" name="to" value="" id="to" style="width:35px;" />
  	          </span>
  	          <input class="submit-icon" type="submit" name="submit" value="submit" id="submit-prices" />
  	          </fieldset>
	         </form>
	         <?php endif ?>
  	         <form id="page-catalog_submit_code" action="<?php print base_path().drupal_get_path_alias("catalog/ricerca");?>" method="post" accept-charset="utf-8">
  	           <fieldset class="">
  	              <span class="input_wrapper text">
  	              <span class="lead">CODICE:</span>
  	              <input type="text" name="cerca" value="" id="cerca-codce" style="width:60px;" />
  	            </span>
  	            <input class="submit-icon" type="submit" name="submit" value="submit" id="submit-code" />
  	            </fieldset>
  	         </form>
  	      </div>
  	       
     	 
     	  
     	    <div id="shopping-links">
     	      <?php print lotus_shopping_links(); ?>
     	    </div>
     	  
  	    </div>

				<?php print $content; ?>
								
			</div>
<?php include("includes/footer.inc"); ?>
