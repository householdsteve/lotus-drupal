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
  	       
  	          <span class="input_wrapper text">
  	              <span class="lead">PREZZO</span>
  	              <span>DA:</span>
  	              <input type="text" name="from" value="" id="from" style="width:25px;" />
  	              <span>A</span>
  	              <input type="text" name="to" value="" id="to" style="width:25px;" />
  	          </span>
  	          <input class="submit-icon" type="submit" name="submit" value="submit" id="submit" />
  	          
  	         
  	          <span class="input_wrapper text">
  	              <span class="lead">CODICE:</span>
  	              <input type="text" name="cerca" value="" id="cerca" style="width:60px;" />
  	          </span>
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
