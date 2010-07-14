/* $Id: README.txt,v 1.1 2009/12/17 14:17:40 mogtofu33 Exp $ */

Advanced catalog add custom filer on ubercart catalog
 - Products per page
 - Ordering by position, name or price
 - Sort ascending or descending
 - Mode filter to display your catalog using views
Advanced catalog fully integrate ubercart catalog with view, so you can adjust the display
like you want and offer to your customer multiple display.
Default views with the module are grid, table, list.
Extra views "sticky" give the ability to add a view before the catalog to promote some products
of the current taxonomy.


*******************************************************************************************
Warning
-------

You need to mod your template.php file. It could affect your site.
Don't make any change to this file on production site !

*******************************************************************************************

Requirements
------------

This module require at least version 6.x of Drupal and Ubercart 6.x-2.2
Other dependencies
  * Views 6.x.2.8: http://drupal.org/project/views
  * Views UI 6.x.2.8: included in views
  * Ubercart Views 6.x-3.0: http://drupal.org/project/uc_views

Installation
------------
1. Edit your template.php file and add this code:

  // code added begin
  /**
   * Add uc_advanced_catalog override.
   */
  function phptemplate_uc_catalog_browse($tid = 0) {
    if (variable_get('uc_advanced_catalog', FALSE) && module_exists('uc_advanced_catalog')) {
      return uc_advanced_catalog_browse($tid);
    }
    // default is ubercart handler
    return theme_uc_catalog_browse($tid);
  }
  // end of the code

2. Go to 'admin/settings/performance' and Flush all cache.

3. Copy the folder named 'uc_advanced_catalog' and its contents to the Ubercart contrib modules 
   directory of your Drupal installation
   (for example 'sites/all/modules/ubercart/contrib/').
   
4. Go to 'admin/build/modules' and enable Ubercart advanced catalog.

5. Go to 'admin/store/settings/catalog/edit/advanced' and edit option for the module.

4. Configure views advanced_catalog, but there is some restriction :
  * If you delete arguments, it can't work
  * If you change argument, it could not work
  * You can't use node style plugin in any view, because we need a reference to uc_products field

*******************************************************************************************

This module has been developed by Mog for arthur-com.net

Post a message on the drupal.org site if you have any ideas on 
how we can improve the module.

Mog.
tech@arthura.fr