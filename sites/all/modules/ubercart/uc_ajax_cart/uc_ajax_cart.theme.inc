<?php 

function theme_uc_ajax_cart_attributes( $item, $options )
{
	foreach ( $options as $option )
	{
		$attribute = uc_attribute_load($option->aid) ;
		$items[] = $attribute->name .': '. $option->name ;
	}
	
	return theme('item_list',$items, null, 'ul' , array('class' => 'product-description'));
}

function theme_uc_ajax_cart_cart_links()
{
    $items[] = array( 
     	'data' => l(t('View cart'),'cart',array('attributes' => array('rel' => 'nofollow'))),
    	'class' => 'cart-block-view-cart'
    );
    // Only add the checkout link if checkout is enabled.
    if (variable_get('uc_checkout_enabled', TRUE)) 
    {
     	$items[] = array( 
     		'data' => l(t('Checkout'),'cart/checkout',array('attributes' => array('rel' => 'nofollow'))),
     		'class' => 'cart-block-checkout'
     	);
    }
	return theme('item_list',$items,null,'ul',array('class' => 'links'));
}


function uc_ajax_cart_preprocess_uc_ajax_cart_block_content( &$vars )
{
	$cartContent = $vars['items'] ;
	$items = array();
	
    $contextTotal = array(
      'revision' => 'themed',
      'type' => 'price',
    );
    
    $total = 0 ;
    $total_items = 0 ;

	foreach ( $cartContent as $item )
	{
		$display_item = module_invoke($item->module, 'cart_display', $item);
		if ( !empty($display_item) )
		{
	      	$total += $display_item['#total'] ;
	      	$total_items   += $display_item['qty']['#default_value'] ;
            $items[] = array(
                'nid' 			=> $display_item['nid']['#value'],
                'qty' 			=> t('@qty&times;', array('@qty' => $display_item['qty']['#default_value'])),
                'title' 		=> $display_item['title']['#value'],
                'descr' 			=> isset($display_item['description']['#value']) ? $display_item['description']['#value'] : FALSE,
				'link' 			=> url('node/'.$item->nid ),
				'item' 			=> $item ,
				'image'			=> uc_product_get_picture($display_item['nid']['#value'], 'cart'),
				'node'	  		=> node_load($item->nid),
				'total'	  		=> uc_price($display_item['#total'],array(
				    'revision' => 'themed-original',
				    'type' => 'amount',
				  )) ,
				'attributes' 	=> (is_array($attributes) && count($attributes)>0) ? theme('uc_ajax_cart_attributes' , $item , $attributes ) : '' ,
				'remove_link' 	=> l(t('Remove product'),
								  UC_AJAX_CART_REMOVE_CALLBACK,
								  array(
								  		'attributes' => 
								  				array(
								  						'onclick' => "ajaxCartBlockUIRemove(this.href);return false; ",
								  						'class'	  => 'remove-cart-link remove-cart-link-' . $display_item['nid']['#value']
								  				),
								  		'query' => array( 
								  			'nid' => $display_item['nid']['#value'] , 
								  			'destination' => $_GET['q'],
								  			'data' => base64_encode($display_item['data']['#value']), 'action' => 'remove' )) 
								  		) 
			);
		}
	}
	$vars['total'] = uc_price($total,$contextTotal) ;
	$vars['items'] = $items ;
	$vars['cart_links'] = theme('uc_ajax_cart_cart_links') ;
	$vars['items_text'] = format_plural( $total_items , '<span class="num-items">@count</span> Item', '<span class="num-items">@count</span> Items');
}