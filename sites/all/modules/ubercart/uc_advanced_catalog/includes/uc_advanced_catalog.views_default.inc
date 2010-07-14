<?php
// $Id: uc_advanced_catalog.views_default.inc,v 1.1 2009/12/17 14:17:41 mogtofu33 Exp $

/**
 * @file
 * Default views for uc_advanced_catalog.module.
 */

/**
 * Implementation of hook_views_default_views().
 */
function uc_advanced_catalog_views_default_views() {
  $view = new view;
  $view->name = 'advanced_catalog';
  $view->description = 'Product listing used by Ubercart advanced catalog';
  $view->tag = 'product';
  $view->view_php = '';
  $view->base_table = 'node';
  $view->is_cacheable = FALSE;
  $view->api_version = 2;
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
  $handler = $view->new_display('default', 'Defaults', 'default');
  $handler->override_option('fields', array(
    'field_image_cache_fid' => array(
      'label' => '',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'link_class' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'strip_tags' => 0,
        'html' => 0,
      ),
      'link_to_node' => 0,
      'label_type' => 'none',
      'format' => 'product_linked',
      'multiple' => array(
        'group' => 1,
        'multiple_number' => '1',
        'multiple_from' => '0',
        'multiple_reversed' => 0,
      ),
      'exclude' => 0,
      'id' => 'field_image_cache_fid',
      'table' => 'node_data_field_image_cache',
      'field' => 'field_image_cache_fid',
      'relationship' => 'none',
      'override' => array(
        'button' => 'Override',
      ),
    ),
    'title' => array(
      'label' => '',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
      ),
      'link_to_node' => 1,
      'exclude' => 0,
      'id' => 'title',
      'table' => 'node',
      'field' => 'title',
      'relationship' => 'none',
    ),
    'list_price' => array(
      'label' => '',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'link_class' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'strip_tags' => 0,
        'html' => 0,
      ),
      'empty' => '',
      'hide_empty' => 1,
      'empty_zero' => 1,
      'set_precision' => 0,
      'precision' => '0',
      'decimal' => '.',
      'separator' => ',',
      'prefix' => '',
      'suffix' => '',
      'format' => 'uc_price',
      'exclude' => 0,
      'id' => 'list_price',
      'table' => 'uc_products',
      'field' => 'list_price',
      'relationship' => 'none',
      'override' => array(
        'button' => 'Override',
      ),
    ),
    'sell_price' => array(
      'label' => '',
      'alter' => array(
        'alter_text' => 0,
        'text' => '<span class="uc-price-product uc-price-display uc-price">[sell_price]</span>',
        'make_link' => 0,
        'path' => '',
        'link_class' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'strip_tags' => 0,
        'html' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'set_precision' => 0,
      'precision' => '0',
      'decimal' => '.',
      'separator' => ',',
      'prefix' => '',
      'suffix' => '',
      'format' => 'uc_price',
      'exclude' => 0,
      'id' => 'sell_price',
      'table' => 'uc_products',
      'field' => 'sell_price',
      'relationship' => 'none',
      'override' => array(
        'button' => 'Override',
      ),
    ),
    'buyitnowbutton' => array(
      'label' => '',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
      ),
      'exclude' => 0,
      'id' => 'buyitnowbutton',
      'table' => 'uc_products',
      'field' => 'buyitnowbutton',
      'override' => array(
        'button' => 'Override',
      ),
      'relationship' => 'none',
    ),
  ));
  $handler->override_option('sorts', array(
    'sticky' => array(
      'order' => 'DESC',
      'id' => 'sticky',
      'table' => 'node',
      'field' => 'sticky',
      'override' => array(
        'button' => 'Override',
      ),
      'relationship' => 'none',
    ),
    'created' => array(
      'order' => 'DESC',
      'granularity' => 'second',
      'id' => 'created',
      'table' => 'node',
      'field' => 'created',
      'relationship' => 'none',
    ),
  ));
  $handler->override_option('arguments', array(
    'tid' => array(
      'default_action' => 'default',
      'style_plugin' => 'default_summary',
      'style_options' => array(),
      'wildcard' => 'all',
      'wildcard_substitution' => 'Tous / Toutes',
      'title' => '',
      'breadcrumb' => '',
      'default_argument_type' => 'php',
      'default_argument' => '',
      'validate_type' => 'none',
      'validate_fail' => 'not found',
      'break_phrase' => 0,
      'add_table' => 0,
      'require_value' => 0,
      'reduce_duplicates' => 0,
      'set_breadcrumb' => 0,
      'id' => 'tid',
      'table' => 'term_node',
      'field' => 'tid',
      'validate_user_argument_type' => 'uid',
      'validate_user_roles' => array(
        '2' => 0,
      ),
      'override' => array(
        'button' => 'Remplacer',
      ),
      'relationship' => 'none',
      'default_options_div_prefix' => '',
      'default_argument_user' => 0,
      'default_argument_fixed' => '',
      'default_argument_php' => 'if (arg(1) && is_numeric(arg(1))) {
    return arg(1);
  }',
      'validate_argument_node_type' => array(
        'product' => 0,
        'page' => 0,
        'story' => 0,
      ),
      'validate_argument_node_access' => 0,
      'validate_argument_nid_type' => 'nid',
      'validate_argument_vocabulary' => array(
        '1' => 0,
      ),
      'validate_argument_type' => 'tid',
      'validate_argument_transform' => 0,
      'validate_user_restrict_roles' => 0,
      'validate_argument_php' => '',
    ),
  ));
  $handler->override_option('filters', array(
    'status' => array(
      'operator' => '=',
      'value' => '1',
      'group' => '0',
      'exposed' => FALSE,
      'expose' => array(
        'operator' => FALSE,
        'label' => '',
      ),
      'id' => 'status',
      'table' => 'node',
      'field' => 'status',
      'relationship' => 'none',
    ),
    'is_product' => array(
      'operator' => '=',
      'value' => '1',
      'group' => '0',
      'exposed' => FALSE,
      'expose' => array(
        'operator' => FALSE,
        'label' => '',
      ),
      'id' => 'is_product',
      'table' => 'uc_products',
      'field' => 'is_product',
      'override' => array(
        'button' => 'Override',
      ),
      'relationship' => 'none',
    ),
  ));
  $handler->override_option('access', array(
    'type' => 'perm',
    'perm' => 'view catalog',
  ));
  $handler->override_option('cache', array(
    'type' => 'none',
  ));
  $handler->override_option('header_format', '3');
  $handler->override_option('header_empty', 0);
  $handler->override_option('empty_format', '1');
  $handler->override_option('items_per_page', 12);
  $handler->override_option('use_pager', '1');
  $handler->override_option('use_more', 0);
  $handler->override_option('use_more_always', 0);
  $handler->override_option('use_more_text', 'Voir plus');
  $handler->override_option('link_display', 'page_1');
  $handler->override_option('style_plugin', 'grid');
  $handler->override_option('style_options', array(
    'grouping' => '',
    'columns' => '4',
    'alignment' => 'horizontal',
  ));
  $handler->override_option('row_options', array(
    'inline' => array(
      'field_prix_promo_value' => 'field_prix_promo_value',
      'sell_price' => 'sell_price',
    ),
    'separator' => ' ',
    'hide_empty' => 1,
  ));
  $handler = $view->new_display('block', 'Grid', 'block_1');
  $handler->override_option('block_description', '');
  $handler->override_option('block_caching', -1);
  $handler = $view->new_display('block', 'Table', 'block_2');
  $handler->override_option('style_plugin', 'table');
  $handler->override_option('style_options', array(
    'grouping' => '',
    'override' => 1,
    'sticky' => 0,
    'order' => 'asc',
    'columns' => array(
      'field_image_cache_fid' => 'field_image_cache_fid',
      'title' => 'title',
      'list_price' => 'list_price',
      'sell_price' => 'sell_price',
      'buyitnowbutton' => 'buyitnowbutton',
    ),
    'info' => array(
      'field_image_cache_fid' => array(
        'separator' => '',
      ),
      'title' => array(
        'sortable' => 0,
        'separator' => '',
      ),
      'list_price' => array(
        'sortable' => 0,
        'separator' => '',
      ),
      'sell_price' => array(
        'sortable' => 0,
        'separator' => '',
      ),
      'buyitnowbutton' => array(
        'separator' => '',
      ),
    ),
    'default' => '-1',
  ));
  $handler->override_option('block_description', '');
  $handler->override_option('block_caching', -1);
  $handler = $view->new_display('block', 'List', 'block_3');
  $handler->override_option('style_plugin', 'list');
  $handler->override_option('style_options', array(
    'grouping' => '',
    'type' => 'ul',
  ));
  $handler->override_option('row_options', array(
    'inline' => array(),
    'separator' => '',
    'hide_empty' => 1,
  ));
  $handler->override_option('block_description', '');
  $handler->override_option('block_caching', -1);
  $handler = $view->new_display('block', 'Sticky', 'block_4');
  $handler->override_option('items_per_page', 2);
  $handler->override_option('use_pager', '0');
  $handler->override_option('block_description', '');
  $handler->override_option('block_caching', -1);
  $views[$view->name] = $view;

  return $views;
}