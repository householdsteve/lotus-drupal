var hasActive = false;

var playAudio = true;

var orig_bg_bg;

var orig_bg;
var orig_pad;
function getState(){
	return hasActive;
}

function setState(_v){
	hasActive = _v;
}

function loadHome(){
  playAudio = false;
  $(document).ready(function(){
    $.backstretch(Drupal.settings.theme.themePath+"/images/spacer.gif",{showFirst:true});
    // set up main state before animation:
   
    orig_bg_bg = $("html").css("background");
    orig_bg = $(".content-body").css("background");
    orig_pad = $(".content-body").css("padding");
    $(".content-body").css({"background":"none","padding":"0"});
        $("html").css("background","#000");
    
    $(".column.full.main").hide();
    $("#backstretch").hide();
    $("#primary").hide();
    $("#navigation-holder").hide();
    $("#scoprite").hide();
    $("#standard-cat").hide();
    $("#outlet-cat").hide();
    $("#footer").hide();
    
    $("#content").css({"top":($(document).height()/2) - 75});
    $(".wrapper").css({"width":"660px"});
    
    var so = new SWFObject(Drupal.settings.theme.themePath+'/intro-lotus.swf','intro-clip','660','150','9');
    so.addParam('allowfullscreen','true');
    so.addParam('allowscriptaccess','always');
    so.addParam('wmode','transparent');
    so.write('intro');
  });
}

function loadOut(){
  
   $("html").css("background",orig_bg_bg);
  $("#intro").animate({"opacity":0},600,function(){
    $("#intro").remove();
   
  });
  $("#intro-bg").fadeOut(600);
  $("#backstretch").delay(500).fadeIn();
  $(".column.full.main").delay(1500).fadeIn();
  $(".wrapper").delay(600).animate({"width":"930px"});
  $("#content").animate({"top":"0px"});
  
  $("#primary").delay(1400).slideDown();
  $("#navigation-holder").delay(1600).fadeIn();
  $("#scoprite").delay(1800).fadeIn("slow",function(){
    
    $(".content-body").css({"background":orig_bg,"padding":orig_pad});
  });
  $("#standard-cat").delay(2000).fadeIn();
  $("#outlet-cat").delay(2200).fadeIn();
  $("#footer").delay(2800).fadeIn("slow",function(){
    loadAudio(true);  
  });
    
}

function loadAudio(play){
  // write player into html //
  
  if(play){
  var so = new SWFObject(Drupal.settings.theme.themePath+'/player.swf','mpl','380','32','9');
  so.addParam('allowfullscreen','true');
  so.addParam('flashvars','&file='+Drupal.settings.theme.themePath+'/playlist.xml&repeat=single&autostart=true&icons=false&dock=false&image=none&skin='+Drupal.settings.theme.themePath+'/stylish_slim.swf&playlist=none&playlistsize=0&backcolor=989795&frontcolor=000000&lightcolor=8e1d2f&screencolor=cccccc');
  so.addParam('allowscriptaccess','always');
  so.addParam('wmode','opaque');
  so.addVariable('plugins', 'revolt-1');
  so.write('mediaspace');
  
  // end player code //
  }else{
    $("#mediaspace").hide();
  }
}

function getQueryVariable(variable)
{
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++)
  {
    var pair = vars[i].split("=");
    if (pair[0] == variable)
    {
      return pair[1];
    }
  }
}


$(document).ready(function(){
  
  
  if($("input.list-add-to-cart").length > 0){
    var $form = $("input.list-add-to-cart").parents("form");
    $("input.list-add-to-cart").click(function(){
      $form.submit();
    });
    
    $("input.list-add-to-cart").appendTo($("#add_to_cart_holder"));
  }
  
  if($(".details-content").length > 0){
    // check we have stuff to work with
    $(".details-content").each(function(i){
      var $h3 = $(this).children("h3");
      
      //var origBottom = $(this).css("bottom");
      var origH = $(this).outerHeight();
      var diff = -(origH - $h3.outerHeight());
    
      $(this).css("bottom", diff+"px");
      var $obj = $(this);
      $(this).parent().hover(function(){
        if(!$obj.is(":animated")){
          $obj.animate({bottom:"0"},500);
        }
      },function(){
        //if(!$(this).is(":animated")){  
          $obj.animate({bottom:diff+"px"},500);
        //}  
      });
      
      
      // lets get the click link from the image just incase people try to click it
      
      var $parent = $(this).parents("div.product-column");
      var siblingHref = $parent.children("span.catalog-grid-image").find("a").attr("href");
      
      $(this).click(function(){
        window.location = siblingHref;
      });
      $parent.click(function(){
        window.location = siblingHref;
      });
      
    });
  }
  
  
  
  if(playAudio){
    $.backstretch(Drupal.settings.theme.themePath+"/images/spacer.gif",{showFirst:false});
    loadAudio(playAudio);
  }
  
  if($("#submit-code").length > 0){
   $("#cerca-codce").attr("value",getQueryVariable("code"));
    $("form#page-catalog_submit_code").submit(function(){
      window.location = Drupal.settings.basePath + "catalog/ricerca?code=" + $("#cerca-codce").val();
      return false;
    });
  }
  
  if($("#submit-prices").length > 0){
     // get the price from query string
      var completeURL = window.location.href; 
      var URl = completeURL.split("?");

      var price_range = getQueryVariable("price");
      if(price_range){
          var s_price_range = price_range.split(":");
          $("select#from").attr('value', s_price_range[1]);
          $("select#to").attr("value",s_price_range[3]);
      }
        $("form#page-catalog_submit_prices").submit(function(){
          window.location = URl[0] + "?price=from:" + $("select#from option:selected").val() + ":to:" + $("select#to option:selected").val();
          return false;
        });
  
  }
  
  if($("#submit-quantity").length > 0){
     // get the price from query string
      var completeURL = window.location.href; 
      var URl = completeURL.split("?");

      var range = getQueryVariable("quantity");
      if(range){
          var s_range = range.split(":");
          $("input#from_qty").attr('value', s_range[1]);
          $("input#to_qty").attr("value",s_range[3]);
      }
        $("form#page-catalog_submit_quantity").submit(function(){
          window.location = URl[0] + "?quantity=from:" + $("input#from_qty").val() + ":to:" + $("input#to_qty").val();
          return false;
        });
  
  }
  
  
  if($("#fast-cat-change").length > 0){
    // see if fast changer is available
    $("#fast-cat-change").change(function(){
      var selectedVal = $(this).find("option:selected").val();
      if(selectedVal != "null"){
        window.location = $(this).find("option:selected").val();
      }
    });
  }
  
  // grab the parents so we can associate then to their children
  var $ulParents = $("div#navigation > ul > li").has("ul");
  
  // fuck dove siamo we're doing it te bad way. why does chrome render two of the same items differently? the li after it is the same.
  $('a[title="DOVE SIAMO"]').parent().css("width","120px");
  
  $ulParents.each(function(i){
    //var $ul = $(this).children("ul").remove(); // this takes the ul out of the object and leaves just the a tag in the $(this) variable
    var id = $(this).children("a:first").text().toLowerCase() + "-menu";
    
    //var _div = $("<div/>").attr("id",id).addClass("sub-nav").hide().append($ul); // give it a new id and hide it for later.
    
    var _div = $("<div/>").attr("id",id).addClass("bg-spacer").html($("<div/>").addClass("bg-child")).hide(); // give it a new id and hide it for later.
    $("#navigation-holder").append(_div);
    $(this).hover(function(){
     
        if(!$(this).is(":animated")){    
          _div.show().css("z-index","2").animate({top:"30px"}, 500 );
      		$(this).children("ul").animate({top:"34px"}, 500 );
      		$(this).addClass("over");
      	}
      },function(){
        if(!$(this).is(":animated")){
          _div.css("z-index","1").animate({top:"-10px"}, 500, function(e){});
        	$(this).children("ul").animate({top:"0px"}, 500);
        	$(this).removeClass("over");
        }
    });
    
    // this is for deeping linking menu opening
  	if($(this).children("ul").find("a.active").length > 0){
      _div.show().css("z-index","2").animate({top:"30px"}, 500 );
      $(this).children("ul").animate({top:"34px"}, 500 );
  	}
  	
  });
});