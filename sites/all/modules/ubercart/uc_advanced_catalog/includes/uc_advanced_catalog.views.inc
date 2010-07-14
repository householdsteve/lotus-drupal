<?php
// $Id: uc_advanced_catalog.views.inc,v 1.3 2010/04/14 13:08:51 mogtofu33 Exp $

/**
 * @file
 * Advanced catalog query order alter on view.
 */

/**
 * Implementation hook_views_query_alter()
 */
function uc_advanced_catalog_views_query_alter(&$view, &$query) {
  if ($view->name == 'advanced_catalog' && arg(0) != 'admin') {
    $_SESSION['dir'] ? $dir = $_SESSION['dir'] : $dir = variable_get('uc_advanced_catalog_sort_default', 'ASC');
    $_SESSION['order'] ? $order = $_SESSION['order'] : $order = variable_get('uc_advanced_catalog_ordering_default', 'ordering');

    switch ($order) {
      case 'sell_price':
        $table = 'uc_products.sell_price ';
        break;
      case 'title':
        $table = 'node.title ';
        break;
      case 'ordering':
        $table = 'uc_products.ordering ';
        break;
    }
    $query->orderby[0] = $table . $dir;
  }
}