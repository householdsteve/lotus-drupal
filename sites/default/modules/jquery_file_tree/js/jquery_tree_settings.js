$(document).ready(function(){
  var script_path = Drupal.settings.jqueryTree.treePath+'/jqueryFileTree.php';
  $('#dl-col-1').fileTree({ root: Drupal.settings.basePath+Drupal.settings.jqueryTree.fileDirectory+'/', script: script_path, folderEvent: 'click', expandSpeed: 750, collapseSpeed: 750, loadMessage: 'Un momento...' }, function(file) {
    openFile(file);
  });
  
  $('#dl-col-2').fileTree({ root: Drupal.settings.basePath+Drupal.settings.jqueryTree.fileDirectory+'/products/imported/', script: script_path, folderEvent: 'click', expandSpeed: 750, collapseSpeed: 750, loadMessage: 'Un momento...' }, function(file) {
    openFile(file);
  });
  
  $('#dl-col-3').fileTree({ root: Drupal.settings.basePath+Drupal.settings.jqueryTree.fileDirectory+'/pages_images/', script: script_path, folderEvent: 'click', expandSpeed: 750, collapseSpeed: 750, loadMessage: 'Un momento...' }, function(file) {
    openFile(file);
  });
  
  
  function openFile(file){
    
    window.location = Drupal.settings.jqueryTree.treePath+'/download_image.php?file_path='+file;

  }
  
});