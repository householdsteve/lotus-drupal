<?php include("includes/header.inc"); ?>
			
				<?php if (!empty($tabs)) { echo $tabs; }; ?>
				<?php if (!empty($tabs2)) { echo $tabs2; } ?>
				<?php if (!empty($help)) { echo $help; } ?>
				<?php if (!empty($messages)) { echo $messages; } ?>
				
			<div class="content-body clearfix">
			  <div class="content-filters clearfix">
  	      <form>
  	         <fieldset class="clearfix">
  	      <div class="filter left">
  	        <img src="<?php print $base_path . $directory ?>/images/select-categoy.gif" width="209" height="29" alt="Select Categoy" />
  	      </div>
  	      <div class="filter middle">
  	          <span class="input_wrapper"><?php print learn_taxonomy_ancestry(10); ?></span>
  	      </div>
  	      <div class="filter right">
  	        <img class="imageblock" src="<?php print $base_path . $directory ?>/images/cerca-label.gif" width="180" height="29" alt="Cerca Label" />
  	          <span class="input_wrapper"><input type="text" name="cerca" value="" id="cerca" /></span>
  	        <input class="submit-icon" type="submit" name="submit" value="submit" id="submit" />
  	      </div>
  	      </fieldset> 
     	  </form>
     	  
     	    <div id="shopping-links">
     	      <?php print lotus_shopping_links(); ?>
     	    </div>
     	  
  	    </div>

				<?php print $content; ?>
								
			</div>
<?php include("includes/footer.inc"); ?>
