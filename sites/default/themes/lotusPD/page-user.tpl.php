<?php include("includes/header.inc"); ?>
			
				<?php if (!empty($help)) { echo $help; } ?>
				<?php if (!empty($messages)) { echo $messages; } ?>
				
			<div class="content-body clearfix">
				<?php print $content; ?>
								
			</div>
<?php include("includes/footer.inc"); ?>
