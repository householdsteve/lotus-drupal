<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo get_page_language($language); ?>" xml:lang="<?php echo get_page_language($language); ?>">
<head>

  	<title><?php if (isset($head_title )) { echo $head_title; } ?></title>
    <?php echo $head; ?>
		<!-- Meta Tags -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="it" />

        <meta name="copyright" content="Copyright 2008-2010  All Rights Reserved" />
        <meta name="keywords" content="  " />
		<meta name="description" content="   " />
		<meta name="robots" content="index,follow" />

    <style type="text/css" media="screen">
      body {
        background:#000 url('<?php print get_full_path_to_theme()?>/images/bg.jpg') top center no-repeat;
      }
      #lotus {
        width:424px;
        margin:95px auto 0 auto;
      }
      a img {
        border:none;
      }
    </style>


</head>

    <body>
      
      <div id="lotus">
        <a href="mailto:info@lotuspd.com"><img src="<?php print get_full_path_to_theme()?>/images/intro-text-chiuso.jpg" width="424" height="373" alt="LOUTS COMING SOON."/></a>
      </div>
  <?php print $closure; ?>
</body>
</html>