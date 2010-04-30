var hasActive = false;

function getState(){
	return hasActive;
}

function setState(_v){
	hasActive = _v;
}

$(document).ready(function(){
	
	if($("div#navigation > ul > li > ul > li a.active").length > 0){
		
		$("div#navigation").css({height:"80px"});
		$("div#navigation > ul > li > ul > li a.active").parent().parent().show();
		setState(true);
	}
	
	$("div#navigation > ul > li").has("ul").hover(function(e){
		
		if($("div#navigation > ul > li.over").length < 1){ // if no one has over class
			$("div#navigation").animate({height:"80px"}, 500 ); // do slide
		}
		
		$(this).children("ul").slideDown();
		
		$(this).addClass("over");
		setState(true);
		
	},function(e){
		
		$(this).removeClass("over");
		setTimeout(function(){
		
			if($("div#navigation > ul > li.over").length < 1){ // if no one has over class
				$("div#navigation").animate({height:"37px"}, 500);
			}
		},300);

			
	
		$(this).children("ul").slideUp();	
		
	});
	
});