var hasActive = false;

function getState(){
	return hasActive;
}

function setState(_v){
	hasActive = _v;
}

$(document).ready(function(){
  
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