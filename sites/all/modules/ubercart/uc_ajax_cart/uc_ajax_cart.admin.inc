<?php 
/** admin functions **/

function uc_ajax_cart_settings_overview()
{
	$form = array();
	$form['settings_messages'] = array
	(
		'#type' => 'fieldset',
		'#title' => t('Message settings'),
		'#description' => t('You can switch beetween blockUI and growl like messages.'),
		'#collapsible' => true ,
		'messages' => array
		(
			'#type' => 'radios',
			'#title' => t('Message effect') ,
			'#required' => true ,
			'#options' => array( 1 => 'jQuery block UI messages.', 2 => 'Growl like messages.' ),
			'#default_value' => variable_get('ajax_cart_message_effect' , UC_AJAX_CART_DEFAULT_EFFECT ) 
		),
		'timeout' => array
		(
			'#type' => 'textfield' ,
			'#size' => 6 ,
			'#required' => true ,
			'#title' => t('Standard message timeout') ,
			'#default_value' => variable_get('ajax_cart_message_timeout' , UC_AJAX_CART_DEFAULT_TIMEOUT )
		),
		/**
		'display_remove_message' => array
		(
			'#type' => 'checkbox' ,
			'#title' => t('Should show a message if product is removed from cart.') ,
			'#default_value' => variable_get('ajax_cart_message_remove_display' , 1 )
		),

		'display_add_message' => array
		(
			'#type' => 'checkbox' ,
			'#title' => t('Should show a message if product is added from cart.') ,
			'#default_value' => variable_get('ajax_cart_message_add_display' , 1 )
		),
		**/

	);
	
	$form['cache_settings'] = array
	(
		''
	);
	
	$form['cart_view_on'] = array
	(
		'#type' => 'checkbox',
		'#default_value' => variable_get('uc_ajax_cart_cart_view',0) ,
		'#title'		 => t('Enable ajax cart view')
	);
	
	
	$form['submit'] = array
	(
		'#type' => 'submit',
		'#value' => t('Submit')
	);

	return $form ;
}

function uc_ajax_cart_settings_overview_validate()
{
	//here validation
}

function uc_ajax_cart_settings_overview_submit( $form , $form_state)
{
	variable_set('ajax_cart_message_timeout' , $form_state['values']['timeout'] );
	variable_set('ajax_cart_message_effect' , $form_state['values']['messages'] );
	variable_set('uc_ajax_cart_cart_view' , $form_state['values']['cart_view_on']);
	/**
	variable_set('ajax_cart_message_remove_display' , $form_state['values']['display_remove_message'] );
	variable_set('ajax_cart_message_add_display' , $form_state['values']['display_add_message'] );
	**/
}