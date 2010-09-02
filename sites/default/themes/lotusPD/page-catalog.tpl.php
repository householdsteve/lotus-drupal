<?php include("includes/header.inc"); ?>
			
				<?php if (!empty($tabs)) { echo $tabs; }; ?>
				<?php if (!empty($tabs2)) { echo $tabs2; } ?>
				<?php if (!empty($help)) { echo $help; } ?>
				<?php if (!empty($messages)) { echo $messages; } ?>
				
			<div class="content-body clearfix">
			  <div class="content-filters clearfix">
  	     
  	       
  	      <div class="filter left">
  	        <span class="input_wrapper"><?php print learn_taxonomy_ancestry(10); ?></span>
  	      </div>
  	      
  	      <div class="filter middle-right">
  	        <?php if(user_access('view product version')):?>
  	        <form id="page-catalog_submit_quantity" action="<?php print base_path().drupal_get_path_alias("catalog/ricerca");?>" method="post" accept-charset="utf-8">
  	           <fieldset class="">
  	             <span class="input_wrapper text">
                     <span class="lead"><?php print t("Quantita'")?></span>
                     <span>DA:</span>
                     <input type="text" name="from_qty" value="" id="from_qty" style="width:35px;" />
                     <span>A</span>
                     <input type="text" name="to_qty" value="" id="to_qty" style="width:35px;" />
                 </span>
                 <input class="submit-icon" type="submit" name="submit" value="submit" id="submit-quantity" />
     	          </fieldset>
   	         </form>
   	         
                 <form id="page-catalog_submit_prices" action="<?php print base_path().drupal_get_path_alias("catalog/ricerca");?>" method="post" accept-charset="utf-8">
       	           <fieldset class="">     
  	          <span class="input_wrapper text">
  	              <span class="lead">PREZZO</span>
  	              <span>DA:</span>
  	              <select name="from" id="from" style="width:45px;">
  	               <option value="">--</option>
  	               <?php for($z = 0; $z < 101; $z++):?>
  	                  <option value="<?php print $z;?>"><?php print $z;?></option>
  	               <?php endfor ?>
  	              </select>
  	              <span>A</span>
  	              <select name="to" id="to" style="width:45px;">
  	               <option value="">--</option>
  	               <?php for($x = 0; $x < 101; $x++):?>
  	                  <option value="<?php print $x;?>"><?php print $x;?></option>
  	               <?php endfor ?>
  	              </select>
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
