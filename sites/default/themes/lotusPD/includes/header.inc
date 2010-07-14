<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo get_page_language($language); ?>" xml:lang="<?php echo get_page_language($language); ?>">

<head>
  <title><?php if (isset($head_title )) { echo $head_title; } ?></title>
  <?php echo $head; ?>  
  <?php echo $styles ?>
  <?php echo $scripts ?>

  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
</head>

<body>
	
	<div id="container">
		
		<div id="header">
			<div id="primary">
				<a id="site_logo" href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><img src="<?php print $base_path . $directory ?>/images/louts-logo.png" width="264" height="50" alt="Louts Logo" /></a>
				
				<div id="social">
						<span>FOLLOW US ON</span>
						<a href="#"><img src="<?php print $base_path . $directory ?>/images/fb.png" width="41" height="41" alt="Fb" /></a>
						<a href="#"><img src="<?php print $base_path . $directory ?>/images/t.png" width="41" height="41" alt="T" /></a>
						<a href="#"><img src="<?php print $base_path . $directory ?>/images/x.png" width="41" height="41" alt="X" /></a>
				</div>
				<div id="area-riservata">
				  <?php print lotus_user_link(); ?>
				</div>
			</div>
			
			
		</div>
		
		<div id="content" class="wrapper">
			<div id="navigation-holder" class="">
			<div id="navigation" class="clearfix">
				<?php print $primary_links; ?>
				
			</div>
			</div>