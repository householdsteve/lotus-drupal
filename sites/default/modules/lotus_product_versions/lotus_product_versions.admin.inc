<?php
// $Id: uc_stock.admin.inc,v 1.1.2.6 2009/07/21 14:37:17 islandusurper Exp $

/**
 * @file
 * Stock administration menu items.
 *
 */
/**
 * Form builder for product stock edit form.
 *
 * @ingroup forms
 * @see
 *   theme_lotus_product_versions_edit_form()
 *   lotus_product_versions_edit_form_submit()
 */
function lotus_product_versions_edit_form($form_state, $node) {
  drupal_set_title(check_plain($node->title));

  $form = array();
  $form['versions'] = array('#tree' => TRUE);

  $skus = uc_product_get_models($node);

  // Remove 'Any'.
  unset($skus[NULL]);

  if (!$skus) {
    drupal_set_message(t('No SKU found.'), 'error');
  }
  else {
    foreach (array_values($skus) as $id => $sku) {
      $versions = db_fetch_array(db_query("SELECT * FROM {product_versions} WHERE sku = '%s'", $sku));

      $form['versions'][$id]['sku'] = array(
        '#type' => 'value',
        '#value' => $sku,
      );

      // Sanitized version of the SKU for display.
      $form['versions'][$id]['display_sku'] = array(
        '#value' => check_plain($sku),
      );

      // Textfield for entering the stock level.
      $form['versions'][$id]['imballo'] = array(
        '#type' => 'textfield',
        '#default_value' => !empty($versions['imballo']) ? $versions['imballo'] : 0,
        '#maxlength' => 9,
        '#size' => 9,
      );

      // Textfield for entering the threshold level.
      $form['versions'][$id]['dimensions'] = array(
        '#type' => 'textfield',
        '#default_value' => !empty($versions['dimensions']) ? $versions['dimensions'] : 0,
        '#size' => 15,
      );
      
      $form['versions'][$id]['arrivo_1'] = array(
        '#type' => 'textfield',
        '#default_value' => !empty($versions['arrivo_1']) ? $versions['arrivo_1'] : 0,
        '#size' => 5,
      );
      
      $form['versions'][$id]['data_arrivo_1'] = array(
        '#type' => 'textfield',
        '#default_value' => !empty($versions['data_arrivo_1']) ? $versions['data_arrivo_1'] : 0,
        '#size' => 10,
      );
      
      $form['versions'][$id]['arrivo_2'] = array(
        '#type' => 'textfield',
        '#default_value' => !empty($versions['arrivo_2']) ? $versions['arrivo_2'] : 0,
        '#size' => 5,
      );
      
      $form['versions'][$id]['data_arrivo_2'] = array(
        '#type' => 'textfield',
        '#default_value' => !empty($versions['data_arrivo_2']) ? $versions['data_arrivo_2'] : 0,
        '#size' => 10,
      );
      
      $form['versions'][$id]['disponibile_descr'] = array(
        '#type' => 'textfield',
        '#default_value' => !empty($versions['disponibile_descr']) ? $versions['disponibile_descr'] : 0,
        '#size' => 12,
      );
      
       // Checkbox to mark this as active.
        $form['versions'][$id]['novita'] = array(
          '#type' => 'checkbox',
          '#default_value' => !empty($versions['novita']) ? $versions['novita'] : 0,
        );
        
        // Checkbox to mark this as active.
        $form['versions'][$id]['offerta'] = array(
          '#type' => 'checkbox',
          '#default_value' => !empty($versions['offerta']) ? $versions['offerta'] : 0,
        );
          
       // Checkbox to mark this as active.
        $form['versions'][$id]['esclusiva'] = array(
          '#type' => 'checkbox',
          '#default_value' => !empty($versions['esclusiva']) ? $versions['esclusiva'] : 0,
        );
    }
  }

  $form['nid'] = array(
    '#type' => 'value',
    '#value' => $node->nid,
  );

  $form['save'] = array(
    '#type' => 'submit',
    '#value' => t('Save changes'),
  );

  return $form;
}

/**
 * @ingroup themeable
 * @see lotus_product_versions_edit_form()
 */
function theme_lotus_product_versions_edit_form($form) {
  $header = array(
    array('data' => t('SKU')),
    array('data' => t('Imballo')),
    array('data' => t('Dimensions')),
    array('data' => t('Arrivo 1')),
    array('data' => t('Data arrivo 1')),
    array('data' => t('Arrivo 2')),
    array('data' => t('Data arrivo 2')),
    array('data' => t('Disponibile Descr')),
    array('data' => '&nbsp;&nbsp;'. t('Novita')) + theme('table_select_header_cell'),
    array('data' => '&nbsp;&nbsp;'. t('Offerta')) + theme('table_select_header_cell'),
    array('data' => '&nbsp;&nbsp;'. t('Esclusiva')) + theme('table_select_header_cell'),
  );

  foreach (element_children($form['versions']) as $id) {
    $rows[] = array(
      array('data' => drupal_render($form['versions'][$id]['display_sku'])),
      array('data' => drupal_render($form['versions'][$id]['imballo'])),
      array('data' => drupal_render($form['versions'][$id]['dimensions'])),
      array('data' => drupal_render($form['versions'][$id]['arrivo_1'])),
      array('data' => drupal_render($form['versions'][$id]['data_arrivo_1'])),
      array('data' => drupal_render($form['versions'][$id]['arrivo_2'])),
      array('data' => drupal_render($form['versions'][$id]['data_arrivo_2'])),
      array('data' => drupal_render($form['versions'][$id]['disponibile_descr'])),
      array('data' => drupal_render($form['versions'][$id]['novita'])),
      array('data' => drupal_render($form['versions'][$id]['offerta'])),
      array('data' => drupal_render($form['versions'][$id]['esclusiva'])),
    );
  }

  return theme('table', $header, $rows) . drupal_render($form);
}

/**
 * @see lotus_product_versions_edit_form()
 */
function lotus_product_versions_edit_form_submit($form, &$form_state) {
  foreach (element_children($form_state['values']['versions']) as $id) {
    db_query("UPDATE {product_versions} SET 
      imballo = '%s', 
      dimensions = '%s', 
      arrivo_1 = %d,
      arrivo_2 = %d,
      data_arrivo_1 = '%s',
      data_arrivo_2 = '%s', 
      disponibile_descr = '%s',
      novita = %d,
      offerta = %d,
      esclusiva = %d      
      WHERE sku = '%s'",
      $form_state['values']['versions'][$id]['imballo'],
      $form_state['values']['versions'][$id]['dimensions'],
      intval($form_state['values']['versions'][$id]['arrivo_1']),
      intval($form_state['values']['versions'][$id]['arrivo_2']),
      $form_state['values']['versions'][$id]['data_arrivo_1'],
      $form_state['values']['versions'][$id]['data_arrivo_2'],
      $form_state['values']['versions'][$id]['disponibile_descr'],
      $form_state['values']['versions'][$id]['novita'] ? 1 : 0,
      $form_state['values']['versions'][$id]['offerta'] ? 1 : 0,
      $form_state['values']['versions'][$id]['esclusiva'] ? 1 : 0,
      $form_state['values']['versions'][$id]['sku']);
    if (!db_affected_rows()) {
      db_query("INSERT INTO {product_versions} (sku, nid, imballo, dimensions, arrivo_1, arrivo_2, data_arrivo_1, data_arrivo_2, disponibile_descr, novita, offerta, esclusiva) VALUES ('%s',%d,'%s','%s', %d, %d,'%s','%s','%s',%d,%d,%d)",
        $form_state['values']['versions'][$id]['sku'],
        $form_state['values']['nid'],
        $form_state['values']['versions'][$id]['imballo'],
        $form_state['values']['versions'][$id]['dimensions'],
        intval($form_state['values']['versions'][$id]['arrivo_1']),
        intval($form_state['values']['versions'][$id]['arrivo_2']),
        $form_state['values']['versions'][$id]['data_arrivo_1'],
        $form_state['values']['versions'][$id]['data_arrivo_2'],
        $form_state['values']['versions'][$id]['disponibile_descr'],
        $form_state['values']['versions'][$id]['novita'] ? 1 : 0,
        $form_state['values']['versions'][$id]['offerta'] ? 1 : 0,
        $form_state['values']['versions'][$id]['esclusiva'] ? 1 : 0
        );
    }
  }

  drupal_set_message(t('version settings saved.'));
}


