$(document).ready(function(){
  // filename searching:
   var qs = $('input#id_search_list').quicksearch('div.column-child ul li a',
 	{'show': function () {
           $(this).parent().show();
       },
   'hide': function () {
           $(this).parent().hide();
       },
  'onBefore': function () {
               //$("span#clear_button").hide();
       },
   'onAfter': function () {
              // $("span#clear_button").show();
       },
       'loader': 'img#loading_image',
       'noResults': 'div#not_found'
       
   });
  
  var script_path = Drupal.settings.jqueryTree.treePath+'/jqueryFileTree.php';
  $('#dl-col-1').fileTree({callback:function(){qs.cache();}, root: Drupal.settings.basePath+Drupal.settings.jqueryTree.fileDirectory+'/default/comunicati_stampa/', script: script_path, folderEvent: 'click', expandSpeed: 750, collapseSpeed: 750, loadMessage: 'Un momento...' }, function(file) {
    openFile(file);
  });
  
  $('#dl-col-2').fileTree({callback:function(){qs.cache();}, root: Drupal.settings.basePath+Drupal.settings.jqueryTree.fileDirectory+'/products/imported/', script: script_path, folderEvent: 'click', expandSpeed: 750, collapseSpeed: 750, loadMessage: 'Un momento...' }, function(file) {
    openFile(file);
  });
  
  $('#dl-col-3').fileTree({callback:function(){qs.cache();}, root: Drupal.settings.basePath+Drupal.settings.jqueryTree.fileDirectory+'/default/catalog_pdf/', script: script_path, folderEvent: 'click', expandSpeed: 750, collapseSpeed: 750, loadMessage: 'Un momento...' }, function(file) {
    openFile(file);
  });
  

  
  
  function openFile(file){
    
    window.location = Drupal.settings.jqueryTree.treePath+'/download_image.php?file_path='+file;

  }
  
});