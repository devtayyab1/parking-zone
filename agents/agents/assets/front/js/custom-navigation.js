!function(n){"use strict";var s=n(window),o=n(document),c=n(".loader"),t=n("#mynavbar"),e=n("#mynavbar-2"),a=n("#mynavbar-3"),i=n("#top-bar"),r=n("#top-bar-2"),f=n("#top-bar-3"),l=n(".landing-page.nav a"),u=n(".navbar-collapse"),p=n("html, body"),d=n("#colorPanel"),g=n('[data-toggle="tooltip"]'),h=n("#close-btn"),y=n("#menu-btn"),b=n("#mySidenav"),m=n("ul.dropdown-menu [data-toggle=dropdown]");s.on("load",function(){c.fadeOut("slow")}),o.on("ready",function(){t.affix({offset:{top:function(){return i.height()}}})}),o.on("ready",function(){e.affix({offset:{top:function(){return r.outerHeight()}}})}),o.on("ready",function(){a.affix({offset:{top:function(){return f.outerHeight()}}})}),l.on("click",function(){u.collapse("hide")}),o.on("ready",function(){l.on("click",function(s){if(""!==this.hash){s.preventDefault();var o=this.hash;p.animate({scrollTop:n(o).offset().top},800,function(){window.location.hash=o})}})}),o.on("ready",function(){y.on("click",function(){b.css("transform","translateX(0%)")})}),o.on("ready",function(){h.on("click",function(){b.css("transform","translateX(-120%)")})}),o.on("ready",function(){g.tooltip()}),o.on("ready",function(){m.on("click",function(s){s.preventDefault(),s.stopPropagation(),n(this).parent().siblings().removeClass("open"),n(this).parent().toggleClass("open")})}),o.on("ready",function(){d.ColorPanel({styleSheet:"#cpswitch",colors:{"#ffcb05":"css/yellow.css","#3cafff":"css/skyblue.css","#ff6666":"css/pink.css","#7fc143":"css/green.css","#00cccc":"css/cyan.css","#ffbf80":"css/skin.css","#9797ff":"css/lightblue.css","#d98cb3":"css/purple.css","#cc9966":"css/brown.css","#00e6ac":"css/spring-green.css","#fc603f":"css/orange.css","#C4C920":"css/lightgreen.css","#E266E8":"css/strongpurple.css","#6CE34B":"css/stronggreen.css"},linkClass:"linka",animateContainer:!1})})}(jQuery);