$(document).ready(function(){

  $("div#lotus-map-expand").toggle(function(){
    $(this).prev().animate({height: "400px"}, 1000 );
    var _img = $(this).children("img");
    _img.attr("src",_img.attr("src").replace("down","up"));
    var _span = $(this).children("span");
    _span.text(_span.text().replace("Espandi","Chiudi"));
    return false;
  },
  function(){
    $(this).prev().animate({height: "210px"}, 1000 );
    var _img = $(this).children("img");
    _img.attr("src",_img.attr("src").replace("up","down"));
    var _span = $(this).children("span");
    _span.text(_span.text().replace("Chiudi","Espandi"));
    return false;
  }
  
  );
});