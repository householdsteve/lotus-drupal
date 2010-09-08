$(document).ready(function(){
  var $current = $("div.column.product.middle a:first-child");
  var $next;
  $("div.column.product.middle a.prettyPhoto").prettyPhoto({theme:'dark_square'});
  
  $current.addClass('selected');
  $("a."+$current.attr("id")).css("opacity",0.5);
  
  
  // if there is only one product hide the thumbnail
  if($("div.product-thumbs a").length < 2){
    $("div.product-thumbs a").hide();
  }else{
    // we need to create a thumb selection system
    
    $thumbs = $("div.product-thumbs a");
    
    $thumbs.click(function(){
      var fId = $(this).attr("class");
      $next = $("#"+fId);
      loadNextProduct();
      return false;
    });
    
  }
  
  function loadNextProduct(){
    
    if($current.attr("id") != $next.attr("id")){ // if the thumb clicked is not the same
      if($current.length > 0){
        $current.fadeOut("slow");
        $("a."+$current.attr("id")).fadeTo("fast",1);
      }
        $("a."+$next.attr("id")).fadeTo("fast",0.5);
        $next.fadeIn("slow",function(){
          $current = $next;
        });
      
    }
    
  }
  
  $("div.column.product.middle a.prettyPhoto").each(function(i){
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
  
  
 
    var $form = $("input.list-add-to-cart").parents("form");
    $("input.list-add-to-cart").click(function(){
      $form.submit();
    });
    
    $("input.list-add-to-cart").appendTo($("#add_to_cart_holder"));
    
    var price_array = new Array();
    var $prices = $("form#lotus-product-versions-cart-form table td.price");
    
    
    $prices.each(function(){
      price_array.push($(this).text());
     });
    
    // get them in order:
    price_array.sort();
    
    if(price_array[0] != price_array[price_array.length-1]){
     
      $("#price_range").text("Da: "+price_array[0]+" a "+price_array[price_array.length-1]);
    }else{
     $("#price_range").text(price_array[price_array.length-1]);
   }
  
});