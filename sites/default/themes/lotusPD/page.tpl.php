<?php include("includes/header.inc"); ?>
			
				<?php if (!empty($tabs)) { echo $tabs; }; ?>
				<?php if (!empty($tabs2)) { echo $tabs2; } ?>
				<?php if (!empty($help)) { echo $help; } ?>
				<?php if (!empty($messages) && $node->type != "product") { echo $messages; } ?>
				<?php //passMessages($messages);?>
			<div class="content-body clearfix">
			
				<?php print $content; ?>
								
			</div>
<?php include("includes/footer.inc"); ?>
