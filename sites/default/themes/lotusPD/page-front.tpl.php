<?php include("includes/header.inc"); ?>
			
				<?php if (!empty($help)) { echo $help; } ?>
				<?php if (!empty($messages)) { echo $messages; } ?>
				
			<div class="content-body clearfix">
			  <div id="intro">
			   
			  </div>
				<?php print $content; ?>
								
			</div>
			<script type="text/javascript" charset="utf-8">
			  loadHome();
			</script>
<?php include("includes/footer.inc"); ?>
