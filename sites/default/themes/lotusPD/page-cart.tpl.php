<?php include("includes/header.inc"); ?>
			
				<?php if (!empty($tabs)) { echo $tabs; }; ?>
				<?php if (!empty($tabs2)) { echo $tabs2; } ?>
				<?php if (!empty($help)) { echo $help; } ?>
				<?php if (!empty($messages) && $node->type != "product") { echo $messages; } ?>
				<?php //passMessages($messages);?>
			<div class="content-body clearfix">
			
				<?php print $content; ?>
								<div class="shipping-info">
								  <?php print t('*spese di trasporto escluse'); ?><br/>
								  <?php print t('*per ordini inferiori a €150,00 addebito per spese fisse di gestione di € 7,00*'); ?>
								</div>
			</div>
<?php include("includes/footer.inc"); ?>
