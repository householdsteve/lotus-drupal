var ajaxCartBlockTimeoutVar ;

jQuery(document).ready(function(){
	jQuery.blockUI.defaults.growlCSS.opacity = 1;
	jQuery.blockUI.defaults.timeout = Drupal.settings.uc_ajax_cart.TIMEOUT;

	ajaxCartCheckCartToggle();

	jQuery('a.ajax-cart-link').bind('click',function() { 
		ajaxCartBlockUI(Drupal.settings.uc_ajax_cart.ADD_TITLE,
				'<div class="messages status">' + Drupal.settings.uc_ajax_cart.ADD_MESSAGE + '</div>')
			jQuery.get(Drupal.settings.uc_ajax_cart.CART_LINK_CALLBACK,{ href : this.href },ajaxCartFormSubmitted);
		return false ; 
	} );

	var options = { 
						url : Drupal.settings.uc_ajax_cart.CALLBACK, 
						beforeSubmit : function() { 
										ajaxCartBlockUI(Drupal.settings.uc_ajax_cart.ADD_TITLE,
														'<div class="messages status">' + Drupal.settings.uc_ajax_cart.ADD_MESSAGE + '</div>') } , 
						success : ajaxCartFormSubmitted,
						type : 'post'
					}
	if ( Drupal.settings.uc_ajax_cart.CART_VIEW_ON )
	{
		jQuery('form.ajax-cart-submit-form').ajaxForm( options );
		ajaxCartInitCartView();
	}
});

function ajaxCartInitCartView()
{
	jQuery('#uc-cart-view-form input.ajax-cart-submit-form-button').bind('click',function(){
		jQuery(this).parents('form').ajaxForm( { 
				url: Drupal.settings.uc_ajax_cart.UPDATE_CALLBACK, success  :ajaxCartUpdateCartView,beforeSubmit : function() { 
					ajaxCartBlockUI(Drupal.settings.uc_ajax_cart.ADD_TITLE,	'<div class="messages status">' + Drupal.settings.uc_ajax_cart.UPDATE_MESSAGE + '</div>') 
				} 
		});
	});
}

function ajaxCartCheckCartToggle()
{
	if ( jQuery.cookie('ajax-cart-visible') == '1' )
	{
		jQuery('#ajaxCartUpdate #cart-block-contents-ajax').show();
	} else {
		jQuery('#ajaxCartUpdate #cart-block-contents-ajax').hide();
	}
}

function ajaxCartShowMessageProxy( title , message )
{
	if ( Drupal.settings.uc_ajax_cart.BLOCK_UI == 1 )
	{
		jQuery.blockUI( {  message : '<h2>' + title + '</h2>' + message });
	} else {
		jQuery.growlUI( title , message , jQuery.blockUI.defaults.timeout ); 
	}
}

function ajaxCartShowMessageProxyClose()
{
		jQuery.unblockUI();
}

function ajaxCartToggleView()
{
	jQuery('#ajaxCartUpdate #cart-block-contents-ajax').toggle();
	if ( jQuery.cookie('ajax-cart-visible') == '1' )
	{
		jQuery.cookie('ajax-cart-visible','0')
	} else {
		jQuery.cookie('ajax-cart-visible','1')
	}
}

function ajaxCartFormSubmitted( e )
{
	ajaxCartUpdateCart();
	ajaxCartBlockUI(Drupal.settings.uc_ajax_cart.CART_OPERATION,e); 
}

function ajaxCartBlockUI(title,message)
{
	ajaxCartShowMessageProxy(title,message); 
}

function ajaxCartBlockUIRemove( url )
{
	ajaxCartShowMessageProxy(Drupal.settings.uc_ajax_cart.REMOVE_TITLE,Drupal.settings.uc_ajax_cart.REMOVE_MESSAGE);
	jQuery.post(url,ajaxCartFormSubmitted) ;
}

function ajaxCartUpdateCart()
{
	jQuery('#ajaxCartUpdate').load(Drupal.settings.uc_ajax_cart.SHOW_CALLBACK,{},ajaxCartInitCartView);
}

function ajaxCartUpdateCartView( e )
{
	ajaxCartFormSubmitted(e);
	jQuery('#cart-form-pane').parent().load(Drupal.settings.uc_ajax_cart.SHOW_VIEW_CALLBACK,ajaxCartUpdateCartViewUpdated);
}

function ajaxCartUpdateCartViewUpdated( e )
{
	
	ajaxCartUpdateCart();
	ajaxCartInitCartView();
}

function ajaxCartShowMessages( e )
{
	if ( e != "" )
	{		
		clearTimeout(ajaxCartBlockTimeoutVar);
		ajaxCartShowMessageProxy('Message',e,ajaxCartBlockTimeoutVar) ; 
	}
}