/*
 * jquery.ebMenu 1.0
 *
 *	  Copyright (c) 2011
 *   Ebupt UIGroup
 *
 * Dual licensed under the GPL (http://www.gnu.org/licenses/gpl.html)
 * and MIT (http://www.opensource.org/licenses/mit-license.php) licenses.
 *
 * 
 */
(function($) {

$.fn.ebMenu = function (options) {
	var defaults = {
		activeFirstMenu:false,
		viewMode:"auto",//是否允许同时展开多个菜单
		animationSpeed:"fast"//
	}
	var options = $.extend(defaults, options);

	var initMenu = function(obj){
		obj.find("ul").addClass("v-menu2");
		obj.find("li").first().addClass("first");
		obj.find("a").focus(function(){$(this).blur()});

		if (options.viewMode!="full"){
				$("ul",obj).hide().siblings("a").addClass("collapsed");	
		}//隐藏二级菜单
		else{
			obj.children("li").children("a").each(function(){
				if ($(this).parent().find("ul").length!=0){
						$(this).addClass("fullmode");
				}
			});
		}
		obj.show();

		obj.children("li").children("a").click(function(){
			switch(options.viewMode){
				case "auto":{
					if ($(this).hasClass("collapsed")){
						$(this).parent().find("ul").slideDown(options.animationSpeed);
						$(this).removeClass("collapsed").addClass("expanded");
					}
					else{
							if ($(this).hasClass("expanded")){
								$(this).parent().find("ul").slideUp(options.animationSpeed);
								$(this).removeClass("expanded").addClass("collapsed");
							}
							else{
							//	$(".active",obj).removeClass("active");
								$(this).parent().addClass("active");
							}
					}
					break;
				}

				case "compact":{

					if ($(this).hasClass("collapsed")){
						$(".expanded",obj).removeClass("expanded").addClass("collapsed").parent().find("ul").slideUp(options.animationSpeed);
						$(this).parent().find("ul").slideDown(options.animationSpeed);
						$(this).removeClass("collapsed").addClass("expanded");
					}
					else{
							if ($(this).hasClass("expanded")){
								$(this).parent().find("ul").slideUp(options.animationSpeed);
								$(this).removeClass("expanded").addClass("collapsed");
							}
							else{
								//$(".active",obj).removeClass("active");
								$(this).parent().addClass("active");
							}
					}
					break;
				}

				case "full":{
					if ($(this).parent().find("ul").length==0)
					{
					//	$(".active",obj).removeClass("active");
						$(this).parent().addClass("active");
					}
				}
			}
		});



		if (options.activeFirstMenu){
			obj.children("li").eq(0).children("a").click();
		}

	}

	initMenu(this);


}
})( jQuery );