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

<div id="art-main" class="wrapper">
	<div id="header">
		    <div id="navigation" class="clearfix">
		    	<div id="head-left-menu"> 		
		    		<?php print($left_head_links); ?>
				</div>
				<div id="head-middle-menu"> 
					<?php print($middle_head_links); ?>
				</div>
				<div id="head-right-menu"> 
					<?php print($right_head_links); ?>
				</div>
		    </div>
		
			<div id="head-sections"class="clearfix">
				<div class="section_float left">
				<?php if (!empty($breadcrumb)) { echo $breadcrumb; }else{echo "&nbsp;";} ?>
				</div>
				
				<div class="section_float middle">
					<h2><?php if (isset($title )) { echo $title; }else{echo "&nbsp;";} ?></h2>
				</div>
				
				<div class="section_float right clearfix">
					<div class="user_data">	
						<h3><?php print $user->name;?></h3>
					</div>
						<a id="site_logo" href="<?php print $base_path ?>" title="<?php print t('Home') ?>">
							<img src="<?php print $base_path . $directory ?>/images/quice_logo.jpg" width="91" height="71" alt="Quice Logo" />
						</a>
				</div>
			</div>
	</div>	      

		<?php echo art_placeholders_output($top1, $top2, $top3); ?>
<div class="art-contentLayout">
		
		<div class="<?php $l = null;
		if (!empty($left)) $l = left;
		else if (!empty($sidebar_left)) $l=sidebar_left;
		$r = null;
		if (!empty($right)) $r = right;
		else if (!empty($sidebar_right)) $r=sidebar_right;          
		echo artxGetContentCellStyle($l, $r, $content); ?>">
		<?php if (!empty($banner2)) { echo $banner2; } ?>
		<?php if ((!empty($user1)) && (!empty($user2))) : ?>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr valign="top"><td width="50%"><?php echo $user1; ?></td>
		<td><?php echo $user2; ?></td></tr>
		</table>
		<?php else: ?>
		<?php if (!empty($user1)) { echo '<div id="user1">'.$user1.'</div>'; }?>
		<?php if (!empty($user2)) { echo '<div id="user2">'.$user2.'</div>'; }?>
		<?php endif; ?>
		<?php if (!empty($banner3)) { echo $banner3; } ?>
		<div class="art-Post">
		    <div class="art-Post-body">
		<div class="art-Post-inner">
		<div class="art-PostContent">
		
		<?php if (!empty($tabs)) { echo $tabs.'<div class="cleared"></div>'; }; ?>
		<?php if (!empty($tabs2)) { echo $tabs2.'<div class="cleared"></div>'; } ?>
		<?php if (!empty($mission)) { echo '<div id="mission">'.$mission.'</div>'; }; ?>
		<?php if (!empty($help)) { echo $help; } ?>
		<?php if (!empty($messages)) { echo $messages; } ?>
		<?php echo art_content_replace($content); ?>

		</div>
		<div class="cleared"></div>

		</div>

		    </div>
		</div>
		<?php if (!empty($banner4)) { echo $banner4; } ?>
		<?php if (!empty($user3) && !empty($user4)) : ?>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr valign="top"><td width="50%"><?php echo $user3; ?></td>
		<td><?php echo $user4; ?></td></tr>
		</table>
		<?php else: ?>
		<?php if (!empty($user3)) { echo '<div id="user1">'.$user3.'</div>'; }?>
		<?php if (!empty($user4)) { echo '<div id="user2">'.$user4.'</div>'; }?>
		<?php endif; ?>
		<?php if (!empty($banner5)) { echo $banner5; } ?>
		</div>
		<?php if (!empty($right)) echo '<div class="art-sidebar2">' . $right . "</div>"; 
		else if (!empty($sidebar_right)) echo '<div class="art-sidebar2">' . $sidebar_right . "</div>";?>

		
	</div>
<div class="art-Sheet clearfix">

    <div class="art-Sheet-body">

<?php echo art_placeholders_output($bottom1, $bottom2, $bottom3); ?>
<?php if (!empty($banner6)) { echo $banner6; } ?>
<div class="art-Footer">
    <div class="art-Footer-inner">
        <?php echo theme('feed_icon', url('rss.xml'), ''); ?>
        <div class="art-Footer-text">
        <?php 
            if (!empty($footer_message) && (trim($footer_message) != '')) { 
                echo $footer_message;
            }
            else {
                echo '<p><a href="#">Contact Us</a>&nbsp;|&nbsp;<a href="#">Terms of Use</a>&nbsp;|&nbsp;<a href="#">Trademarks</a>&nbsp;|&nbsp;<a href="#">Privacy Statement</a>'.
                     ' Copyright &copy; 2010&nbsp;'.$site_name.'.&nbsp;All Rights Reserved.</p>';
            }
        ?>
        <?php if (!empty($copyright)) { echo $copyright; } ?>
        </div>        
    </div>
    <div class="art-Footer-background"></div>
</div>

    </div>
</div>

</div>


<?php print $closure; ?>

</body>
</html>