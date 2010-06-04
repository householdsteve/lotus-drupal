// $Id: uc_addresses.js,v 1.4 2009/12/14 17:47:23 freixas Exp $

/**
 * Set the select box change behavior for the country selector
 */
Drupal.behaviors.ucAddressesCountrySelect = function(context) {
  if (Drupal.settings.uc_address_default) {
    $('select[id$=-country]:not(.ucAddressCountrySelect-processed)', context).each(
      function() {
        uc_update_zone_select(this.id, Drupal.settings.uc_address_default.zone);
        $(this).addClass('ucAddressCountrySelect-processed');
      }
    );
  }
}
