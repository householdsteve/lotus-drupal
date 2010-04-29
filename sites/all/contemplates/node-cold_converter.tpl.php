<div class="cck-holder clearfix">
	<div class="cck-left">
		<h2 class="art-PostHeaderIcon-wrapper"><?php echo $title; ?></h2>
		<div class="row first"><?php print $node->content['field_capacity']['#children'] ?></div>
		<div class="row"><?php print $node->content['field_pressure']['#children'] ?></div>
		<div class="row"><?php print $node->content['field_diameter']['#children'] ?></div>
		<div class="row"><?php print $node->content['field_gas_application']['#children'] ?></div>
		<div class="row last"><?php print $node->content['field_gas']['#children'] ?></div>
	</div>
	
	<div class="cck-right clearfix">
		<div class="thumbs">
			<img src="<?php print base_path().path_to_theme(); ?>/images/cck/thumb/foto-erogatori.jpg" width="120" height="120" alt="Foto Erogatori" />
			<img src="<?php print base_path().path_to_theme(); ?>/images/cck/thumb/foto-erogatori-2.jpg" width="120" height="120" alt="Foto Erogatori 2" />
			
		</div>
		
		<div class="large">
			<img src="<?php print base_path().path_to_theme(); ?>/images/cck/full/foto-erogatori.jpg" width="298" height="298" alt="Foto Erogatori" />
		</div>
	</div>
</div>

