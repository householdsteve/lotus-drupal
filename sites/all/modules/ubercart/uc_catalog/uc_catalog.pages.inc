<?php
// $Id: uc_catalog.pages.inc,v 1.1.2.12 2009/07/21 14:37:21 islandusurper Exp $

/**
 * @file
 * Catalog menu items.
 */

/**
 * Display a formatted catalog page.
 *
 * If the category has products in it, display them in a TAPIr table. Subcategories
 *   are linked along the top of the page. If it does not have products, display
 *   subcategories in a grid with their images and subcategories.
 *
 * @param $tid
 *   Catalog term id from URL.
 * @return
 *   Formatted HTML of the catalog page.
 * @ingroup themeable
 */
function theme_uc_catalog_browse($tid = 0) {
  global $user;
  drupal_add_css(drupal_get_path('module', 'uc_catalog') .'/uc_catalog.css');

  $output = '';
  $catalog = uc_catalog_get_page((int)$tid);
  drupal_set_title(check_plain($catalog->name));
  drupal_set_breadcrumb(uc_catalog_set_breadcrumb($catalog->tid));
  $types = uc_product_types();
  $links = array();
  $child_list = array();
	// get rid of last two items in array (novita') if its the main gallery page //
	if($catalog->name == 'Catalog'){
		array_pop($catalog->children);
		array_pop($catalog->children);
	}
	
	// check if use has permission to access this part of the catalog
	if(!term_permissions_allowed($catalog->tid,$user)){
	  // send them to main catalog page
	  drupal_goto('catalog');
	}
	//echo "<pre>";
	//print_r($catalog);
	//echo "</pre>";
  foreach ($catalog->children as $child) {
    if (!empty($child->nodes)) {
      $links[] = array('title' => $child->name . (variable_get('uc_catalog_breadcrumb_nodecount', FALSE) ? ' ('. $child->nodes .')' : ''), 'href' => uc_catalog_path($child),
        'attributes' => array('rel' => 'tag'),
      );
    }
    if (!empty($child->image)) {
      $image = '<div>';
      if (module_exists('imagecache')) {
        	if($catalog->name == 'Catalog'){
			$image .= l(theme('imagecache', 'uc_category_large', $child->image['filepath']), uc_catalog_path($child), array('html' => TRUE));
			}else{
			$image .= l(theme('imagecache', 'uc_category', $child->image['filepath']), uc_catalog_path($child), array('html' => TRUE));
		}
      }
      else {
        $image .= l(theme('image', $child->image['filepath']), uc_catalog_path($child), array('html' => TRUE));
      }
      $image .= '</div>';
    }
    else {
      $image = '<div></div>';
    }
    $grandchildren = array();
    $j = 0;
    $max_gc_display = 3;
    foreach ($child->children as $i => $grandchild) {
      if ($j > $max_gc_display) {
        break;
      }
      $g_child_nodes = 0;
      foreach ($types as $type) {
        $g_child_nodes += taxonomy_term_count_nodes($grandchild->tid, $type);
      }
      if ($g_child_nodes) {
        $grandchildren[$i] = l($grandchild->name, uc_catalog_path($grandchild), array('class' => 'subcategory'));
        $j++;
      }
    }
    //$grandchildren = array_slice($grandchildren, 0, intval(count($grandchildren) / 2) + 1, TRUE);
    if ($j > $max_gc_display) {
      array_push($grandchildren, l(t('More...'), uc_catalog_path($child), array('class' => 'subcategory')));
    }
    if ($child->nodes) {
      $cell_link = $image .'<strong>'. l($child->name, uc_catalog_path($child)) .'</strong>';
      if (variable_get('uc_catalog_show_subcategories', TRUE)) {
        $cell_link .= "<br/><span>". implode(', ', $grandchildren) ."</span>\n";
      }
      $child_list[$child->tid]['image'] = $image;
      $child_list[$child->tid]['text'] = l($child->name, uc_catalog_path($child));
      $child_list[$child->tid]['hex'] = $child->image['hex'];
    }
  }
  if (!empty($catalog->image)) {
    if (module_exists('imagecache')) {
      //$output .= theme('imagecache', 'uc_thumbnail', $catalog->image['filepath'], $catalog->name, $catalog->name, array('class' => 'category'));
    }
    else {
     // $output .= theme('image', $catalog->image['filepath'], $catalog->name, $catalog->name, array('class' => 'category'));
    }
  }

  // Build an ORDER BY clause for the SELECT query based on table sort info.
  if (empty($_REQUEST['order'])) {
    $order = 'ORDER BY p.ordering, n.title, n.nid';
  }
  else {
    $order = tapirsort_sql(uc_output_header());
  }
  
  ////// !!!!!! ---- WE NEED TO RE-WRITE THE SQL QUERY TO NOT LOAD INDIVIDUAL PRODUCTS THAT ARE PRESENT IN A PRODUCT KIT.

  $sql = "SELECT DISTINCT(n.nid), n.sticky, n.title, n.created, p.model, p.sell_price, p.ordering
    FROM {node} n
      INNER JOIN {term_node} tn ON n.vid = tn.vid
      INNER JOIN {uc_products} AS p ON n.vid = p.vid
    WHERE tn.tid = %d AND n.status = 1
      AND n.type IN (". db_placeholders($types, 'varchar') .") ". $order;

  $sql_count = "SELECT COUNT(DISTINCT(n.nid))
    FROM {node} n
      INNER JOIN {term_node} tn ON n.vid = tn.vid
      INNER JOIN {uc_products} AS p ON n.vid = p.vid
    WHERE tn.tid = %d
      AND n.status = 1
      AND n.type IN (". db_placeholders($types, 'varchar') .")";
      
      
    /*$sql = "SELECT DISTINCT(n.nid), n.sticky, n.title, n.created, p.model, p.sell_price, p.ordering
       FROM {node} n
         INNER JOIN {term_node} tn ON n.vid = tn.vid
         INNER JOIN {uc_products} AS p ON n.vid = p.vid
       WHERE tn.tid = %d AND n.status = 1 AND p.list_in_catalog = '1'
         AND n.type IN (". db_placeholders($types, 'varchar') .") ". $order;

     $sql_count = "SELECT COUNT(DISTINCT(n.nid))
       FROM {node} n
         INNER JOIN {term_node} tn ON n.vid = tn.vid
         INNER JOIN {uc_products} AS p ON n.vid = p.vid
       WHERE tn.tid = %d AND n.status = 1 AND p.list_in_catalog = '1'
         AND n.status = 1
         AND n.type IN (". db_placeholders($types, 'varchar') .")";*/

  $sql = db_rewrite_sql($sql);
  $sql_count = db_rewrite_sql($sql_count);
  $sql_args = array($catalog->tid);
  foreach ($types as $type) {
    $sql_args[] = $type;
  }
  $catalog->products = array();
  $result = pager_query($sql, variable_get('uc_product_nodes_per_page', 12), 0, $sql_count, $sql_args);
  while ($node = db_fetch_object($result)) {
    $catalog->products[] = $node->nid;
  }
  if (count($catalog->products)) {
    if (count($links)) {
      $output .= theme('links', $links, array('class' => 'links inline uc-categories')) ."<br />\n";
    }
    //$output .= $catalog->description;
    $pager = theme('pager');
    $output .= theme('uc_catalog_products',array("products" => $catalog->products, "catalog" => $catalog, "pager" => $pager));
    
  }
  else {
    // Display table of child categories similar to an osCommerce site's front page.
    $columns = variable_get('uc_catalog_category_columns', 3);
    $cat_rows = array();
    $row = array();
    $i = 1;
    /*foreach ($child_list as $cell) {
      $row[] = array('data' => $cell, 'class' => 'category');
      if ($i % $columns == 0) {
        $cat_rows[] = $row;
        $row = array();
      }
      $i++;
    }
    if (count($row) > 0 && count($row) < $columns) {
      if (count($cat_rows) >= 1) {
        $row = array_merge($row, array_fill(count($row), $columns - count($row), array('data' => '&nbsp;', 'class' => 'category')));
      }
      $cat_rows[] = $row;
    }*/
    //$output .= $catalog->description;
    //$output .= theme('table', array(), $cat_rows, array('class' => 'category'));
    
    // make new look for making our sweet looking html grid
    $output .= '<div class="full-content clearfix">';
    
    
    $output .= '<div class="column left">';
    if($catalog->name != 'Catalog'){
      $output .= ' <div class="column-header light">';
      $output .= '   <span class="colorblock" style="background:#'.$catalog->image['hex'].';">&nbsp;</span><span class="title">'.$catalog->name.'</span>';
      $output .= ' </div>';
    }

    $output .= '</div>';

if($catalog->name == 'Catalog'){
     $output .= '<div class="column full">';
  }else{
    $output .= '<div class="column middle-right">';
  }
if($catalog->name != 'Catalog'){
    $output .= '  <div class="spacer clearfix">';
    
    $output .= '  <div class="filter right">';
      $output .= $pager;
    $output .= ' </div>';
    $output .= '</div>';
  }


    $output .= '<div class="category-grid-products">';
    $count = 0;
    
    //echo "<pre>";
  	//print_r($child_list);
  	//echo "</pre>";
    
    foreach ($child_list as $product) {
    //$p = (object) $product;
     

      if ($count == 0) {
        $output .= "<div class='product-row clearfix'>";
      }
      elseif ($count % variable_get('uc_catalog_category_columns', 3) == 0) {
        $output .= "</div><div class='product-row clearfix'>";
      }

      $output .= '<div class="product-column category">';
      $output .= $product['image'];
           $output .= '<div class="category-label">';
            $output .= '<span class="colorblock" style="background:#'.$product['hex'].';">&nbsp;</span><span class="title">'.$product['text'].'</span>';
           $output .= '</div>';
      $output .= '</div>';

      $count++;
    }

   $output .= ' </div>';

        $output .= '<div class="column middle-right">';
            $output .= '  <div class="filter right">';
            $output .= $pager;
            $output .= ' </div>';
        $output .= '</div>';

    $output .= "</div></div></div>";
  }
  
  //echo "<pre>";
	//print_r($catalog);
	//echo "</pre>";

  return $output;
}

