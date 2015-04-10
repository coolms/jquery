/*global jQuery */
/*!
* VerticalAlignCenter.js 1.0
* 
* Copyright 2015, Dmitry Popov http://www.altgraphic.com
* Released under the New BSD License
* http://www.coolms.com/license/new-bsd
* 
* Date: Sat Feb 7 20:29:00 2015 +0300
*/
(function($)
{
    jQuery.fn.verticalAlignCenter = function(options)
    {
    	var settings = $.extend({
    		cssAttribute: 'top',          // the attribute to apply the calculated value to
    		verticalOffset: 0,            // the number of pixels to offset the vertical alignment by
    		parentSelector: $(window),    // a selector representing the parent to vertically center this element within
    		timeout: 25                   // a default timeout in milliseconds
        }, options || {});

    	return this.each(function(){
    		var timeoutHandler;
    		var self = $(this); // store the object

    		// Call on resize.
    		$(window).resize(function(){
    			clearTimeout(timeoutHandler);
    			timeoutHandler = setTimeout(resizer, settings.timeout);
    		});

    		// Call once to set after window loads.
    		$(window).load(function(){
    			self.css("position", "absolute");
    			resizer($(window).scrollTop());
    		});

    		// Apply a load event to images within the element so it fires again after an image is loaded
    		self.find("img").load(resizer);

    		// recalculate the distance to the top of the element to keep it centered
    		var resizer = function(){
    			var scrollTop = arguments.count > 0 ? arguments[0] : 0;
    			self.css(settings.cssAttribute, Math.max(0, ((settings.parentSelector.height() - self.outerHeight()) / 2) + scrollTop + parseInt(settings.verticalOffset)) + "px");
    		};
    	});
    };
})(jQuery);
