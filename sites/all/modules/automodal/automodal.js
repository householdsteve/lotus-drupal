(function ($) {
  Drupal.behaviors.automodal = function () {
    var selector = Drupal.settings.automodal.selector || '.automodal';
    
	var active = Drupal.settings.automodal.active;
	
    var settings = {
      autoResize: true,
      autoFit: true,
      width: 600,
      height: 400,
      //onSubmit: function (a, b) {} 
    }
    
    $(selector).toggle(function () {
      settings.url = $(this).attr('href') || '#';
      
      if (settings.url.indexOf('?') >= 0) {
        settings.url += '&'
      }
      else {
        settings.url += '?'
      }
      settings.url += 'automodal=true';
	
	   //Drupal.modalFrame.open(settings);
	
	
	 settings.clickParent = $(this).parent().parent();
        
		if(!$(this).hasClass("processed")){
				var _tr = $("<tr/>").attr({display:"none"});
				var _td = $("<td/>").attr({colspan:"11"}).addClass("iframeHolder");
 
				var _ifr = $("<iframe/>").attr({src:settings.url,width:"100%",height:"350px"});
	
				_tr.append(_td.append(_ifr));
		
	  			settings.clickParent.after(_tr);
	 			$(this).addClass("processed");
	
    	}else{
		
			$(this).parent().parent().next().show();
		
	}
	
      		return false;

    },function(){
	
			$(this).parent().parent().next().hide();
	
			return false;
	
		});
  }
  
})(jQuery);