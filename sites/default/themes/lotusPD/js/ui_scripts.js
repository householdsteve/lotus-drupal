var hasActive = false;

var playAudio = true;

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
   
    orig_bg = $(".content-body").css("background");
    orig_pad = $(".content-body").css("padding");
    $(".content-body").css({"background":"none","padding":"0"});
    
    $(".column.full.main").hide();
    $("#backstretch").hide();
    $("#primary").hide();
    $("#navigation-holder").hide();
    $("#scoprite").hide();
    $("#standard-cat").hide();
    $("#outlet-cat").hide();
    $("#footer").hide();
    
    $("#content").css({"top":"100px"});
    $(".wrapper").css({"width":"660px"});
    
    var so = new SWFObject(Drupal.settings.theme.themePath+'/intro-lotus.swf','intro-clip','660','150','9');
    so.addParam('allowfullscreen','true');
    so.addParam('allowscriptaccess','always');
    so.addParam('wmode','transparent');
    so.write('intro');
  });
}

function loadOut(){
  
  
  $("#intro").fadeOut(500,function(){$("#intro").remove();});
  $("#intro-bg").fadeOut(600);
  $("#backstretch").delay(500).fadeIn();
  $(".column.full.main").show();
  $(".wrapper").delay(700).animate({"width":"930px"});
  $("#content").delay(800).animate({"top":"0px"});
  
  $("#primary").delay(1400).slideDown();
  $("#navigation-holder").delay(1600).fadeIn("slow",function(){
    $(".content-body").css({"background":orig_bg,"padding":orig_pad});
  });
  $("#scoprite").delay(1800).fadeIn("slow",function(){
    loadAudio(true);  
  });
  $("#standard-cat").delay(2000).fadeIn();
  $("#outlet-cat").delay(2200).fadeIn();
  $("#footer").delay(2600).fadeIn();
    
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
      
      $(this).hover(function(){
        if(!$(this).is(":animated")){
          $(this).animate({bottom:"0"},500);
        }
      },function(){
        //if(!$(this).is(":animated")){  
          $(this).animate({bottom:diff+"px"},500);
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