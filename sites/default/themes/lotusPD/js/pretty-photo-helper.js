$(document).ready(function(){
  $("div.page-top-images a.imagecache-page_image").prettyPhoto({theme:'dark_square'});
  $("div.page-top-images a.imagecache-page_image").each(function(i){
    var _div = $("<div/>").hide(); 
    var _span = $("<span/>").text("ZOOM");
    _div.append(_span); 
    $(this).append(_div);
    
    $(this).hover(function(){
       
        _div.slideDown("fast");
      },function(){
         _div.slideUp("fast");
      }); 
  });
});