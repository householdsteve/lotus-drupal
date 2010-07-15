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
}


function get_category_data($tax){
  
  $key = array_shift(array_keys($tax));
  
  return uc_catalog_image_load($tax[$key]->tid);
  
}


function learn_taxonomy_ancestry($tid){
  
  $p = taxonomy_get_parents($tid);
  
  $key = array_shift(array_keys($p));
  
  $c = taxonomy_get_tree($p[$key]->vid,$p[$key]->tid);
  
  $output = '<select id="fast-cat-change">';
  foreach($c as $item){
    $link = base_path().drupal_get_path_alias("catalog/".$item->tid);
    $output .= '<option value="'.$link.'">'.$item->name.'</option>';
  }
  $output .= "</select>";
  
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
    
  $product_table .= '  <div class="clearfix">';
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
  $context = array(
    'revision' => 'themed',
    'type' => 'product',
  );
  foreach ($products as $nid) {
    $product = node_load($nid);
    $context['subject'] = array('node' => $product);

    if ($count == 0) {
      $product_table .= "<div class='product-row clearfix'>";
    }
    elseif ($count % variable_get('uc_catalog_grid_display_width', 3) == 0) {
      $product_table .= "</div><div class='product-row clearfix'>";
    }

    $titlelink = l($product->model, "node/$nid", array('html' => TRUE));
    if (module_exists('imagecache') && ($field = variable_get('uc_image_'. $product->type, '')) && isset($product->$field) && file_exists($product->{$field}[0]['filepath'])) {
      $imagelink = l(theme('imagecache', 'product_list', $product->{$field}[0]['filepath'], $product->title, $product->title), "node/$nid", array('html' => TRUE));
    }
    else {
      $imagelink = '';
    }

    $product_table .= '<div class="product-column">';
    if (variable_get('uc_catalog_grid_display_title', TRUE)) {
      $product_table .= '<span class="catalog-grid-title">'. $titlelink .'</span>';
    }
    if (variable_get('uc_catalog_grid_display_model', TRUE)) {
      $product_table .= '<span class="catalog-grid-ref">'. $product->model .'</span>';
    }
    $product_table .= '<span class="catalog-grid-image">'. $imagelink .'</span>';
    if (variable_get('uc_catalog_grid_display_sell_price', TRUE)) {
      $product_table .= '<span class="catalog-grid-sell-price">'. uc_price($product->sell_price, $context) .'</span>';
    }
    if (module_exists('uc_cart') && variable_get('uc_catalog_grid_display_add_to_cart', TRUE)) {
      if (variable_get('uc_catalog_grid_display_attributes', TRUE)) {
        $product_table .= theme('uc_product_add_to_cart', $product);
      }
      else {
        $product_table .= drupal_get_form('uc_catalog_buy_it_now_form_'. $product->nid, $product);
      }
    }
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
  if(user_is_logged_in()){
    return l("My Account","user")." / ".l("Logout","logout");
  }else{
    return l("Area Riservata","user/login");
  }
}