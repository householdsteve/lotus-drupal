var hasActive = false;

function getState(){
	return hasActive;
}

function setState(_v){
	hasActive = _v;
}



$(document).ready(function(){
  
  
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
      window.location = $(this).find("option:selected").val();
    });
  }
	
	if($("div#navigation > ul > li > ul > li a.active").length > 0){
		
		$("div#navigation").css({height:"80px"});
		$("div#navigation > ul > li > ul > li a.active").parent().parent().show();
		setState(true);
	}
	
	$("div#navigation > ul > li").has("ul").hover(function(e){
		
		if($("div#navigation > ul > li.over").length < 1){ // if no one has over class
			$("div#navigation").animate({height:"80px"}, 500 ); // do slide
		}
		
		$(this).click(function(){
		  window.location = $(this).attr("href");
		});
		
		$(this).children("ul").show();
		
		$(this).addClass("over");
		setState(true);
		
	},function(e){
		
		$(this).removeClass("over");
		
		setTimeout(function(){
		
			if($("div#navigation > ul > li.over").length < 1){ // if no one has over class
				$("div#navigation").animate({height:"37px"}, 500, function(e){
					
				});
			}
		},500);

			
	
		$(this).children("ul").hide();	
		
	});
	
});