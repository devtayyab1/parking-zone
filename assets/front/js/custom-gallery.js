!function(i){"use strict";var t=i(".image-link"),e=i(".filter-button"),a=i(".filter");t.magnificPopup({type:"image",closeBtnInside:!0,mainClass:"mfp-with-zoom mfp-img-mobile",gallery:{enabled:!0}});var l=e.on("click",function(){var t=i(this).attr("data-filter");"filter"==t?a.show("1000"):(a.not("."+t).hide("3000"),a.filter("."+t).show("3000")),l.removeClass("active"),i(this).addClass("active")})}(jQuery);