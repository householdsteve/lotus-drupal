<?php
// $Id$
/* 
 * @file
 * This file contains Views hooks implementation for Extra Fields Ckeckout Pane module.
 * 
 */   
 
function uc_extra_fields_pane_views_views_data() {

  $data = array(); 
  
  $data['uc_extra_fields_values']['table']['group'] = t('Ubercart order');
 
  $data['uc_extra_fields_values']['table']['join']['uc_order_products'] = array(
    'left_field' => 'order_id',
    'field' => 'order_id',
  );
 
  $data['uc_extra_fields_values']['table']['join']['uc_orders'] = array(
    'left_field' => 'order_id',
    'field' => 'order_id',
  );     

  $fields=array();

  $results=db_query('select field_db_name as field,field_name as name,field_description as descr from {uc_extra_fields}');

  while ($result = db_fetch_array($results)) $fields[$result['field']] = array('name' => $result['name'], 'description' => $result['descr']);

  if (count($fields)) {

    foreach (array('delivery', 'billing') as $prefix) {
      $args = array(
        '!titleprefix' => ($prefix == 'delivery' ? UC_RECIPIENT_PREFIX : UC_PAYER_PREFIX),
      );
      
      foreach ($fields as $field => $item) {
       
        $data['uc_extra_fields_values'][$field . '_' . $prefix] = array(
          'title' => t('!titleprefix !titlesuffix', $args + array('!titlesuffix' => $item['name'])),
          'help' => $item['description'],
          'field' => array(
            'handler' => 'views_handler_field',
            'click sortable' => TRUE,
          ),
          'sort' => array(
            'handler' => 'views_handler_sort',
          ),
          'filter' => array(
            'handler' => 'views_handler_filter_string',
          ),
          'argument' => array(
            'handler' => 'views_handler_argument_string',
          ),

        );
      }
    }  
  }
  return $data;
}


function uc_extra_fields_pane_views_views_data_alter(&$data) {

}  
