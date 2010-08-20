var hasActive = false;

function getState(){
	return hasActive;
}

function setState(_v){
	hasActive = _v;
}



$(document).ready(function(){
  
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
  
  $.backstretch(Drupal.settings.theme.themePath+"/images/spacer.gif");
  
  // write player into html //
  var so = new SWFObject(Drupal.settings.theme.themePath+'/player.swf','mpl','380','32','9');
  so.addParam('allowfullscreen','true');
  so.addParam('flashvars','&file='+Drupal.settings.theme.themePath+'/playlist.xml&repeat=single&autostart=true&icons=false&dock=false&image=none&skin='+Drupal.settings.theme.themePath+'/stylish_slim.swf&playlist=none&playlistsize=0&backcolor=989795&frontcolor=000000&lightcolor=8e1d2f&screencolor=cccccc');
  so.addParam('allowscriptaccess','always');
  so.addParam('wmode','opaque');
  so.addVariable('plugins', 'revolt-1');
  //so.write('mediaspace');
  $("#mediaspace").hide();
  // end player code //
  
  
  
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