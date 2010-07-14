<?php
// $Id: uc_advanced_catalog.admin.inc,v 1.1 2009/12/17 14:17:40 mogtofu33 Exp $

/**
 * @file
 * Advanced catalog administration menu items.
 */

/**
 * Settings forms for using a product grid instead of a table in the catalog.
 *
 * @ingroup forms
 */
function uc_advanced_catalog_settings_form() {
  $form = array();

  $view_url = 'admin/build/views/edit/advanced_catalog';
  $form['uc_advanced_catalog'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display products in the catalog using advanced catalog.'),
    '#summary callback' => 'summarize_checkbox',
    '#summary arguments' => array(
      t('Products are displayed using advanced catalog.'),
      t('Products are not displayed using advanced catalog.'),
    ),
    '#default_value' => variable_get('uc_advanced_catalog', FALSE),
    '#description' => t('If unchecked, the default table or grid display will be used and the settings on this form will be ignored.'),
  );
  if (variable_get('uc_catalog_grid_display', FALSE)) {
    drupal_set_message(t('You cannot use advanced catalog display if grid is enabled.'), 'warning' );
    $form['uc_advanced_catalog']['#disabled'] = TRUE;
  }
  $form['uc_advanced_catalog_pager'] = array(
    '#type' => 'select',
    '#title' => t('Pager and filter position'),
    '#options' => array(
      'top' => t('Top'),
      'bottom' => t('Bottom'),
      'top-bottom' => t('Top and Bottom'),
    ),
    '#description' => t('Select where the pager and filter will be display on catalog.'),
    '#default_value' => variable_get('uc_advanced_catalog_pager', 'top-bottom'),
  );
  $form['uc_advanced_catalog_sticky'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display 2 last sticky products in the catalog heading.'),
    '#summary callback' => 'summarize_checkbox',
    '#summary arguments' => array(
      t('2 sticky products are displayed in the catalog heading.'),
      t('Sticky products are not displayed in the catalog heading.'),
    ),
    '#default_value' => variable_get('uc_advanced_catalog_sticky', FALSE),
    '#description' => t('If checked, 2 last (published date) sticky products of current taxonomy will be shown before the catalog list.') .'<br/>'.
      t('You can manually add sticky bloc on catalog page you want by using block admin with page limit feature.') .'<br/>'.
      t('<a href="!url">You can edit this view here</a>.', array('!url' => url($view_url .'_sticky', array('fragment' => 'views-tab-block_1')))),
  );
  $form['displayed_filters'] = array(
    '#type' => 'fieldset',
    '#title' => t('Displayed filters'),
    '#description' => t('The checked fields will be included in your catalog filter area.') .'<br/>'.
    t('Select wich default view will be used when available, even if filter is not allowed.') .'<br/>'.
    t('You can reorder filter, first one will be on the left side.'),
  );

  // sortable table
  $form['displayed_filters']['list']['#tree'] = TRUE;
  $form['displayed_filters']['list']['#theme'] = 'uc_advanced_catalog_settings_list_form';
  $delta = 4;

  $key = variable_get('uc_advanced_catalog_extra_weight', 0);
  $form['displayed_filters']['list'][$key]['title']['uc_advanced_catalog_extra'] = array(
    '#type' => 'checkbox',
    '#title' => t('Extra pager information.'),
    '#summary callback' => 'summarize_checkbox',
    '#summary arguments' => array(
      t('Extra pager text is shown.'),
      t('Extra pager text is hidding.'),
    ),
    '#default_value' => variable_get('uc_advanced_catalog_extra', TRUE),
    '#description' => t('Items !start to !end of !total total.'),
  );
  $form['displayed_filters']['list'][$key]['default'] = array('#value' => t('n/a'));
  $form['displayed_filters']['list'][$key]['options'] = array('#value' => t('n/a'));
  $form['displayed_filters']['list'][$key]['sort'] = array('#type' => 'weight', '#delta' => $delta, '#default_value' => $key);

  $key = variable_get('uc_advanced_catalog_limit_weight', 1);
  $form['displayed_filters']['list'][$key]['title']['uc_advanced_catalog_limit'] = array(
    '#type' => 'checkbox',
    '#title' => t('Limit'),
    '#default_value' => variable_get('uc_advanced_catalog_limit', TRUE),
    '#summary callback' => 'summarize_checkbox',
    '#summary arguments' => array(
      t('Limit filter is visible'),
      t('Limit filter is hidden'),
    ),
  );
  $form['displayed_filters']['list'][$key]['default']['uc_advanced_catalog_limit_default'] = array(
    '#type' => 'textfield',
    '#size' => 3,
    '#default_value' => variable_get('uc_advanced_catalog_limit_default', variable_get('uc_product_nodes_per_page', 12)),
  );
  $form['displayed_filters']['list'][$key]['options']['uc_advanced_catalog_limit_options']= array(
    '#type' => 'textfield',
    '#description' => t('Specify limit option values available. Separate each with comma. Notice that if you are using grid display all values must be multiple of the grid width value, otherwise the last row will not match.'),
    '#default_value' => variable_get('uc_advanced_catalog_limit_options', '12,20,28'),
    '#size' => 30,
  );
  $form['displayed_filters']['list'][$key]['sort'] = array('#type' => 'weight', '#delta' => $delta, '#default_value' => $key);

  $key = variable_get('uc_advanced_catalog_mode_weight', 2);
  $form['displayed_filters']['list'][$key]['title']['uc_advanced_catalog_mode'] = array(
    '#type' => 'checkbox',
    '#title' => t('View as'),
    '#default_value' => variable_get('uc_advanced_catalog_mode', TRUE),
    '#summary callback' => 'summarize_checkbox',
    '#summary arguments' => array(
      t('View filter is visible'),
      t('View filter is hidden'),
    ),
  );
  $form['displayed_filters']['list'][$key]['default']['uc_advanced_catalog_mode_default'] = array(
    '#type' => 'select',
    '#options' => array(
      'block_1' => t('Grid view'),
      'block_2' => t('Table view'),
      'block_3' => t('List view'),
    ),
    '#default_value' => variable_get('uc_advanced_catalog_mode_default', 'block_1'),
  );
  $form['displayed_filters']['list'][$key]['options']['uc_advanced_catalog_mode_option_grid'] = array(
    '#type' => 'checkbox',
    '#title' => t('Grid view') .'&nbsp;'. t('<a href="!url">You can edit this view here.</a>', array('!url' => url($view_url, array('fragment' => 'views-tab-block_1')))),
    '#default_value' => variable_get('uc_advanced_catalog_mode_option_grid', TRUE),
    '#summary callback' => 'summarize_checkbox',
    '#summary arguments' => array(
      t('Grid view enabled.'),
      ''
    ),
  );
  $form['displayed_filters']['list'][$key]['options']['uc_advanced_catalog_mode_option_table'] = array(
    '#type' => 'checkbox',
    '#title' => t('Table view') .'&nbsp;'. t('<a href="!url">You can edit this view here.</a>', array('!url' => url($view_url, array('fragment' => 'views-tab-block_2')))),
    '#default_value' => variable_get('uc_advanced_catalog_mode_option_table', TRUE),
    '#summary callback' => 'summarize_checkbox',
    '#summary arguments' => array(
      t('Table view enabled.'),
      ''
    ),
  );
  $form['displayed_filters']['list'][$key]['options']['uc_advanced_catalog_mode_option_list'] = array(
    '#type' => 'checkbox',
    '#title' => t('List view') .'&nbsp;'. t('<a href="!url">You can edit this view here.</a>', array('!url' => url($view_url, array('fragment' => 'views-tab-block_3')))),
    '#default_value' => variable_get('uc_advanced_catalog_mode_option_list', TRUE),
    '#summary callback' => 'summarize_checkbox',
    '#summary arguments' => array(
      t('List view enabled.'),
      ''
    ),
  );
  $form['displayed_filters']['list'][$key]['sort'] = array('#type' => 'weight', '#delta' => $delta, '#default_value' => $key);

  $key = variable_get('uc_advanced_catalog_ordering_weight', 3);
  $form['displayed_filters']['list'][$key]['title']['uc_advanced_catalog_ordering'] = array(
    '#type' => 'checkbox',
    '#title' => t('Ordering'),
    '#default_value' => variable_get('uc_advanced_catalog_ordering', TRUE),
    '#summary callback' => 'summarize_checkbox',
    '#summary arguments' => array(
      t('ordering / ordering filter is visible'),
      t('ordering / ordering filter is hidden'),
    ),
  );
  $form['displayed_filters']['list'][$key]['default']['uc_advanced_catalog_ordering_default'] = array(
    '#type' => 'select',
    '#options' => array(
      'ordering' => t('Position'),
      'title' => t('Name'),
      'sell_price' => t('Price'),
    ),
    '#default_value' => variable_get('uc_advanced_catalog_ordering_default', 'ordering'),
  );
  $form['displayed_filters']['list'][$key]['options']['uc_advanced_catalog_ordering_option_position'] = array(
    '#type' => 'checkbox',
    '#title' => t('Position'),
    '#default_value' => variable_get('uc_advanced_catalog_ordering_option_position', TRUE),
  );
  $form['displayed_filters']['list'][$key]['options']['uc_advanced_catalog_ordering_option_name'] = array(
    '#type' => 'checkbox',
    '#title' => t('Name'),
    '#default_value' => variable_get('uc_advanced_catalog_ordering_option_name', TRUE),
  );
  $form['displayed_filters']['list'][$key]['options']['uc_advanced_catalog_ordering_option_price'] = array(
    '#type' => 'checkbox',
    '#title' => t('Price'),
    '#default_value' => variable_get('uc_advanced_catalog_ordering_option_price', TRUE),
  );
  $form['displayed_filters']['list'][$key]['sort'] = array('#type' => 'weight', '#delta' => $delta, '#default_value' => $key);

  $key = variable_get('uc_advanced_catalog_sort_weight', 4);
  $form['displayed_filters']['list'][$key]['title']['uc_advanced_catalog_sort'] = array(
    '#type' => 'checkbox',
    '#title' => t('Sort'),
    '#default_value' => variable_get('uc_advanced_catalog_sort', TRUE),
  );
  $form['displayed_filters']['list'][$key]['default']['uc_advanced_catalog_sort_default'] = array(
    '#type' => 'select',
    '#options' => array(
      'ASC' => t('Ascending'),
      'DESC' => t('Descending'),
    ),
    '#default_value' => variable_get('uc_advanced_catalog_sort_default', 'DESC'),
  );
  $form['displayed_filters']['list'][$key]['options'] = array('#value' => t('n/a'));
  $form['displayed_filters']['list'][$key]['sort'] = array('#type' => 'weight', '#delta' => $delta, '#default_value' => $key);

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save configuration'),
  );
  $form['reset'] = array(
    '#type' => 'submit',
    '#value' => t('Reset to defaults'),
  );

  return $form;
}

function uc_advanced_catalog_settings_form_submit($form, &$form_state) {
  if ($form_state['values']['op'] == t('Save configuration')) {
    foreach (element_children($form_state['values']) as $key) {
      if (drupal_substr($key, 0, 11) == 'uc_advanced') {
        variable_set($key, $form_state['values'][$key]);
      }
    }
    foreach (element_children($form_state['values']['list']) as $key) {
      // weight
      variable_set(key($form_state['values']['list'][$key]['title']) .'_weight', $form_state['values']['list'][$key]['sort']);
      // other values
      foreach ($form_state['values']['list'][$key] AS $v) {
        if (is_array($v)) {
          foreach ($v as $variable => $value) {
            variable_set($variable, $value);
          }
        }
      }
    }
    drupal_set_message(t('Advanced catalog settings saved.'));
  }
  if ($form_state['values']['op'] == t('Reset to defaults')) {
    if (db_query("DELETE FROM {variable} WHERE name LIKE 'uc_advanced_catalog%'")) {
      drupal_set_message(t('Advanced catalog values back to default.'));
      unset($_SESSION['limit']);
      unset($_SESSION['mode']);
      unset($_SESSION['order']);
      unset($_SESSION['dir']);
      // not sure but don't find delete variable cache function...
      drupal_flush_all_caches();
    }
  }
}
/**
  * Theme the re-ordering form
  */
function theme_uc_advanced_catalog_settings_list_form($form) {
  drupal_add_tabledrag('advanced-catalog-sort', 'order', 'sibling', 'sort');
  $header = array('', 'Enable filter', 'Default value', 'Options', 'Sort');
  foreach (element_children($form) as $key) {
    // Add class to group weight fields for drag and drop.
    $form[$key]['sort']['#attributes']['class'] = 'sort';
    $row = array('');
    $row[] = drupal_render($form[$key]['title']);
    $row[] = drupal_render($form[$key]['default']);
    $row[] = drupal_render($form[$key]['options']);
    $row[] = drupal_render($form[$key]['sort']);
    $rows[$key] = array('data' => $row, 'class' => 'draggable');
  }
  ksort($rows);
  $output = theme('table', $header, $rows, array('id' => 'advanced-catalog-sort'));
  $output .= drupal_render($form);
  return $output;
}
