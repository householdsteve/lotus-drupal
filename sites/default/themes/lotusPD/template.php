<?php
// $Id

/* Common methods */

function get_drupal_version() {	
	$tok = strtok(VERSION, '.');
	//return first part of version number
	return (int)$tok[0];
}

function get_page_language($language) {
  if (get_drupal_version() >= 6) return $language->language;
  return $language;
}

function get_full_path_to_theme() {
  return base_path().path_to_theme();
}

/**
 * Allow themable wrapping of all breadcrumbs.
 */
function lotusPD_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode(' | ', $breadcrumb) .'</div>';
  }
}

function lotusPD_form_alter($form_id, &$form) {
  if ('menu_edit_item_form' == $form_id) {
    $form['path']['#description'] .= ' ' . t('Enter %none to have a menu item that generates no link.', array('%none' => '<none>'));
  }
}



/**
 * Image assist module support.
 */
function lotusPD_img_assist_page($content, $attributes = NULL) {
  $title = drupal_get_title();
  $output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
  $output .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">'."\n";
  $output .= "<head>\n";
  $output .= '<title>'. $title ."</title>\n";
  
  // Note on CSS files from Benjamin Shell:
  // Stylesheets are a problem with image assist. Image assist works great as a
  // TinyMCE plugin, so I want it to LOOK like a TinyMCE plugin. However, it's
  // not always a TinyMCE plugin, so then it should like a themed Drupal page.
  // Advanced users will be able to customize everything, even TinyMCE, so I'm
  // more concerned about everyone else. TinyMCE looks great out-of-the-box so I
  // want image assist to look great as well. My solution to this problem is as
  // follows:
  // If this image assist window was loaded from TinyMCE, then include the
  // TinyMCE popups_css file (configurable with the initialization string on the
  // page that loaded TinyMCE). Otherwise, load drupal.css and the theme's
  // styles. This still leaves out sites that allow users to use the TinyMCE
  // plugin AND the Add Image link (visibility of this link is now a setting).
  // However, on my site I turned off the text link since I use TinyMCE. I think
  // it would confuse users to have an Add Images link AND a button on the
  // TinyMCE toolbar.
  // 
  // Note that in both cases the img_assist.css file is loaded last. This
  // provides a way to make style changes to img_assist independently of how it
  // was loaded.
  $output .= drupal_get_html_head();
  $output .= drupal_get_js();
  $output .= "\n<script type=\"text/javascript\"><!-- \n";
  $output .= "  if (parent.tinyMCE && parent.tinyMCEPopup && parent.tinyMCEPopup.getParam('popups_css')) {\n";
  $output .= "    document.write('<link href=\"' + parent.tinyMCEPopup.getParam('popups_css') + '\" rel=\"stylesheet\" type=\"text/css\">');\n";
  $output .= "  } else {\n";
  foreach (drupal_add_css() as $media => $type) {
    $paths = array_merge($type['module'], $type['theme']);
    foreach (array_keys($paths) as $path) {
      // Don't import img_assist.css twice.
      if (!strstr($path, 'img_assist.css')) {
        $output .= "  document.write('<style type=\"text/css\" media=\"{$media}\">@import \"". base_path() . $path ."\";<\/style>');\n";
      }
    }
  }
  $output .= "  }\n";
  $output .= "--></script>\n";
  // Ensure that img_assist.js is imported last.
  $path = drupal_get_path('module', 'img_assist') .'/img_assist_popup.css';
  $output .= "<style type=\"text/css\" media=\"all\">@import \"". base_path() . $path ."\";</style>\n";
  
  $output .= '<!--[if IE 6]><link rel="stylesheet" href="'.get_full_path_to_theme().'/style.ie6.css" type="text/css" /><![endif]-->'."\n";
  $output .= '<!--[if IE 7]><link rel="stylesheet" href="'.get_full_path_to_theme().'/style.ie7.css" type="text/css" /><![endif]-->'."\n";
  
  $output .= "</head>\n";
  $output .= '<body'. drupal_attributes($attributes) .">\n";
  
  $output .= theme_status_messages();
  
  $output .= "\n";
  $output .= $content;
  $output .= "\n";
  $output .= '</body>';
  $output .= '</html>';
  return $output;
}

function lotusPD_menu_tree($tree) {
  return '<ul class="menu clearfix">'. $tree .'</ul>';
}


function lotusPD_preprocess_page(&$vars, $hook) {
  $menu_l = menu_tree_all_data("primary-links");
  //$tree = menu_tree_all_data($menu_l);
  $tO = menu_tree_output($menu_l);
  $vars['primary_links'] = $tO;
  
  $theme_settings = array('themePath' => get_full_path_to_theme());
	drupal_add_js(array('theme' => $theme_settings), "setting");
	
	
}

function phptemplate_preprocess(&$variables, $hook) {
  if($hook == 'page') {
    if(!user_access('administer product versions')){
      lotusPD_removetab('Anagrafico', $variables);
      lotusPD_removetab('Profilo', $variables);
      lotusPD_removetab('Modifica', $variables);
    }
    lotusPD_removetab('Orders', $variables);
    
    lotusPD_removetab('Richiedi una nuova password', $variables);
    lotusPD_removetab('Crea nuovo profilo', $variables);
    lotusPD_removetab('Accedi', $variables);
    
  }
  return $variables;
}

function lotusPD_removetab($label, &$vars) {
  $tabs = explode("\n", $vars['tabs']);
  $vars['tabs'] = '';

  foreach($tabs as $tab) {
    if(strpos($tab, '>' . $label . '<') === FALSE) {
      $vars['tabs'] .= $tab . "\n";
    }
  }
}

function get_category_data($tax){
  
  $key = array_shift(array_keys($tax));
  
  return uc_catalog_image_load($tax[$key]->tid);
  
}


function learn_taxonomy_ancestry($tid){
  
  $p = taxonomy_get_parents($tid);
  
  $key = array_shift(array_keys($p));
  
  $c = taxonomy_get_tree($p[$key]->vid);
  
  $t_p = array();
    
  // sort the objects into families
  foreach($c as $parents){
    if($parents->parents[0] == 0){
      $t_p[$parents->tid] = (array) $parents;
    }else{
      $t_p[$parents->parents[0]]['children'][] = (array) $parents;
    }
  }
  /*
  $output = '<select id="fast-cat-change">';
  $output .= '<option value="null" selected="selected">---------------</option>';
  foreach($t_p as $item){
    if(isset($item['children'])){
      $output .= '<optgroup label="'.$item['name'].'">';
        foreach($item['children'] as $child){
          $link = base_path().drupal_get_path_alias("catalog/".$child['tid']);
          $output .= '<option value="'.$link.'">'.$child['name'].'</option>';
        }
      $output .= '</optgroup>';
    }else{
      $link = base_path().drupal_get_path_alias("catalog/".$item['tid']);
      $output .= '<option value="'.$link.'">'.$item['name'].'</option>';
    }
  }
  $output .= "</select>";
  */
  

  $output = '<select id="fast-cat-change">';
  $output .= '<option value="null" selected="selected">-- Categoria --</option>';
  foreach($t_p as $item){
    $act_cat = uc_catalog_get_page((int)$item['tid']);
    //echo "<pre>";
   	//print_r($act_cat);
   	//echo "</pre>";
      if(count($act_cat->children) > 0){
        $output .= '<optgroup label="'.$act_cat->name.'">';
          foreach($act_cat->children as $child){
           if (!empty($child->nodes)) {
            $link = base_path().drupal_get_path_alias("catalog/".$child->tid);
            $output .= '<option value="'.$link.'">'.$child->name.'</option>';
           }
          }
        $output .= '</optgroup>';
      }else{
        $link = base_path().drupal_get_path_alias("catalog/".$act_cat->tid);
        
        if($act_cat->tid != 38){$output .= '<option value="'.$link.'">'.$act_cat->name.'</option>';}
      }
    }
    $output .= "</select>";
    
    
    
 
  
  // this should be replaced by calling all categories that belong to the cart
  //uc_catalog_get_page((int)$tid);
  
  
  return $output;
  
}

function random_hex_color(){
    return sprintf("%02X%02X%02X", mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
}

function lotusPD_uc_catalog_product_grid($array) {
  global $pager_total_items;
  
  
	
  $products = $array["products"];
  $catalog = $array["catalog"];
 
  //learn_taxonomy_ancestry($catalog->tid);
  $product_table = '<div class="full-content clearfix">';
  
  $product_table .= '<div class="column left">';
  $product_table .= ' <div class="column-header light">';
  $product_table .= '   <span class="colorblock" style="background:#'.$catalog->image['hex'].';">&nbsp;</span><span class="title">'.l($catalog->name,"catalog/".$catalog->tid).'</span>';
  $product_table .= ' </div>';

  $product_table .= '</div>';
  
  $product_table .= '<div class="column middle-right">';
    
  $product_table .= '  <div class="filter-holder clearfix">';
  $product_table .= '    <div class="filter middle">';
    $product_table .= ' <div class="column-header dark info">';
    $on_page = variable_get('uc_product_nodes_per_page', 12);
      $product_table .= "(<span>".($pager_total_items[0] > $on_page ? $on_page : $pager_total_items[0])."</span> prodotti di <span>".$pager_total_items[0]."</span> totale)";
    $product_table .= '  </div>';
  $product_table .= '  </div>';
  $product_table .= '  <div class="filter right">';
  $product_table .= $array["pager"];
  $product_table .= ' </div>';
  $product_table .= '</div>';
    
  
  $product_table .= '<div class="category-grid-products">';
  $count = 0;
  
  foreach ($products as $nid) {
    $product = node_load($nid);
    
    $context = array(
      'revision' => 'themed',
      'type' => 'product_version_all_imballo',
      'subject' => array('node' => $product,'sku' => $version_data->sku,'offer'=>$version_data->offerta),

    );
  
    
    if ($count == 0) {
      $product_table .= "<div class='product-row clearfix'>";
    }
    elseif ($count % variable_get('uc_catalog_grid_display_width', 3) == 0) {
      $product_table .= "</div><div class='product-row clearfix'>";
    }

    $titlelink = l($product->model, "node/$nid", array('html' => TRUE));
    if (module_exists('imagecache') && ($field = variable_get('uc_image_'. $product->type, '')) && isset($product->$field) && file_exists($product->{$field}[0]['filepath'])) {
      $imagelink = l(theme('imagecache', 'product_list', $product->{$field}[0]['filepath'], $product->title, $product->title), "node/$nid", array('html' => TRUE));
      //$minilink = l(theme('imagecache', 'product_list_mini', $product->{$field}[0]['filepath'], $product->title, $product->title), "node/$nid", array('html' => TRUE));
      $minilink = "";
      foreach($product->$field as $item){
  	    // loop through all images and generate thumbs for the left column
    		//print $item['view'];
    		$patterns = array("/\.jpg$/","/\./");
    		$replace = array('','-');
    		$className = preg_replace($patterns, $replace, $item['filename']);
	
    		$minilink .= l(theme('imagecache', 'product_list_mini', $item['filepath']), "node/$nid", array('html' => TRUE, 'attributes' => array('class' => $className)));
    		
    	}
    	
    }
    else {
      $imagelink = '';
    }
    

    $product_table .= '<div class="product-column">';
    
        $product_table .= '<div class="product-flags">';
    
        if(in_array(7,array_keys($product->taxonomy))){ // checks to see if item is novita by taxonomy
          $product_table .= '<div class="lotus_flags new">&nbsp;</div>';
        }
    
        if(in_array(29,array_keys($product->taxonomy))){ // checks to see if item is offerta by taxonomy
          $product_table .= '<div class="lotus_flags offer">&nbsp;</div>';
        }
    
        if($product->field_esclusiva[0]['value']){ // checks to see if item is exclusive by cck field
          $product_table .= '<div class="lotus_flags exclusive">&nbsp;</div>';
        }
        $product_table .= '</div>';
    
    if (variable_get('uc_catalog_grid_display_title', TRUE)) {
      $product_table .= '<span class="catalog-grid-title">'. $titlelink .'</span>';
    }
    $product_table .= '<span class="catalog-grid-image">'. $imagelink .'</span>';
    
    
    $product_table .= '<div class="details-holder">';
      $product_table .= '<div class="details-content">';
        $product_table .= '<h3>'.t('DETTAGLI').'</h3>';
        $product_table .= '<div>';

          if (variable_get('uc_catalog_grid_display_sell_price', TRUE) && user_access('view product version')) {
            $product_table .= '<span class="catalog-grid-sell-price">'. uc_price($product->sell_price, $context) .' <span class="small">– prezzo netto per imballo completo</span></span>';
          }
        $product_table .= '<span class="product-desc">'.$product->body.'</span>';
        $product_table .= '</div>';
      $product_table .= '</div>';
    $product_table .= '</div>';
    
    $product_table .= '<div class="mini-thumbs">';
         $product_table .= '<span class="catalog-grid-image-mini">'. $minilink .'</span>';
    $product_table .= '</div>';
    
    
    
    
    
    $product_table .= '</div>';

    $count++;
  }
    
 $product_table .= ' </div>';
 
      $product_table .= '<div class="column middle-right">';
          $product_table .= '  <div class="filter right">';
          $product_table .= $array["pager"];
          $product_table .= ' </div>';
      $product_table .= '</div>';
 
  $product_table .= "</div></div></div>";
  return $product_table;
}

function lotus_user_link(){
  /*if(user_is_logged_in()){
    return l("Downloads","downloads-browser")." / ".l("My Account","user")." / ".l("Logout","logout");
  }else{
    return l("Area Riservata","user/login");
  }*/

  return menu_tree('menu-area-riservata');
}

function lotus_shopping_links(){
  return menu_tree('menu-shopping-links');
}

// code added begin
  /**
   * Add uc_advanced_catalog override.
   */
   /*
  function phptemplate_uc_catalog_browse($tid = 0) {
    if (variable_get('uc_advanced_catalog', FALSE) && module_exists('uc_advanced_catalog')) {
      return uc_advanced_catalog_browse($tid);
    }
    // default is ubercart handler
    return theme_uc_catalog_browse($tid);
  }*/
  // end of the code
function loadProductUiHelpers(){
  drupal_add_js(path_to_theme().'/js/products_ui.js');
}  

function loadPrettyPhotoHelpers(){
  drupal_add_js(path_to_theme().'/js/pretty-photo-helper.js');
}
function simpleGmap(){
  drupal_add_js(path_to_theme().'/js/map-controls.js');
  return gmap_simple_map("45.3972948", "11.9538438","", "",'14', '930px', '210px');
}


function brghtdiff($R1,$G1,$B1,$R2,$G2,$B2){
    $BR1 = (299 * $R1 + 587 * $G1 + 114 * $B1) / 1000;
    $BR2 = (299 * $R2 + 587 * $G2 + 114 * $B2) / 1000;
 
    return abs($BR1-$BR2);
}

function coldiff($R1,$G1,$B1,$R2,$G2,$B2){
    return max($R1,$R2) - min($R1,$R2) +
           max($G1,$G2) - min($G1,$G2) +
           max($B1,$B2) - min($B1,$B2);
}

function html2rgb($color)
{
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
}

function rgb2html($r, $g=-1, $b=-1)
{
    if (is_array($r) && sizeof($r) == 3)
        list($r, $g, $b) = $r;

    $r = intval($r); $g = intval($g);
    $b = intval($b);

    $r = dechex($r<0?0:($r>255?255:$r));
    $g = dechex($g<0?0:($g>255?255:$g));
    $b = dechex($b<0?0:($b>255?255:$b));

    $color = (strlen($r) < 2?'0':'').$r;
    $color .= (strlen($g) < 2?'0':'').$g;
    $color .= (strlen($b) < 2?'0':'').$b;
    return '#'.$color;
}

function processColorSwatch($hex,$ratio=200){
  $tc = html2rgb($hex);
	$diff = coldiff($tc[0],$tc[1],$tc[2],255,255,255);
	if($diff < $ratio){
	  //use border
	  return true;
	}else{
	  return false;
	}
}