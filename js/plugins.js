
// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  arguments.callee = arguments.callee.caller;  
  if(this.console) console.log( Array.prototype.slice.call(arguments) );
};
// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();)b[a]=b[a]||c})(window.console=window.console||{});


// place any jQuery/helper plugins in here, instead of separate, slower script files.



//Black Ink Modal
(function(a){a.fn.modal=function(d){var h={style:"message",text:"",url:"",cancel:"",reportError:true,reportURL:"",height:"",width:"60%"};var d=a.extend(h,d);var g=a(this);g.before('<div id="mask"><div>');$placement="center";if(h.style=="error"){g.html('<div class="text">'+h.text+"<div>");h.width="40%";i()}else{if(h.style=="message"){g.html(h.text);$placement="top";e()}else{if(h.style=="html"){g.html('<div class="text">'+h.text+"</div>");c()}}}function i(){g.removeClass();g.addClass("error");g.addClass("modal");g.children(".text").after('<a class="reportError button">Report Error</a>');f()}function e(j){g.removeClass();g.addClass("message");g.addClass("modal");f();g.delay(3000).fadeOut(200,function(){b()})}function c(){g.removeClass();g.addClass("html");g.addClass("modal");a.ajax({type:"POST",url:h.url,success:function(j){g.children(".text").html(j);f()},error:function(k,l,j){g.html('<ul class="errors"><li>Something went wrong with out System, please alert our admin with this id: AJ198473</li></ul>');f()}})}function f(){if($placement=="center"){var l=a(window).height()+a(window).scrollTop();var k=a(window).width();g.css("width",h.width);g.css("height",h.height);var j=a(window).height()+g.offset().top+g.height();var m=a(window).width();a("#mask").css({width:m,height:j});a("#mask").fadeIn(1000);a("#mask").fadeTo("slow",0.6);g.css({top:l/4,left:k/2-g.width()/2});g.children(".text").before('<a class="close"></a>');_left=g.offset().left;_objectW=g.outerWidth()-15;_totalLeft=_objectW+_left;_top=g.offset().top;_objectH=35/2;_totalTop=_top-_objectH;g.children("a.close").css({left:_totalLeft,top:_totalTop})}g.fadeIn(1000)}a(".modal .close").live("click",function(){b();h.cancel.call(this)});a("#mask").live("click",function(){b();h.cancel});function b(){a.ajax({url:"/ajax/admin/admin_functionality.php",type:"POST",data:{closeError:1},success:function(j){g.hide();g.html("");g.removeClass();a("#mask").remove()},error:function(k,l,j){a(".text").html("I was not able to close your error. Please report to system Admin.")}})}}})(jQuery);




//Black Ink Valdation
var $message="This field is required";$(".required").live("focus",function(){clearPaint($(this))});$(".required").live("focusout",function(){required($(this).val())&&cssPaint($(this))});$(".email").live("focus",function(){clearPaint($(this))});$(".email").live("focusout",function(){email($(this).val())&&cssPaint($(this))});$(".usPhone").live("focus",function(){clearPaint($(this))});$(".usPhone").live("focusout",function(){usPhone($(this).val())&&cssPaint($(this))});$(".date").live("focus",function(){clearPaint($(this))});
$(".date").live("focusout",function(){date($(this).val())&&cssPaint($(this))});$(".age").live("focus",function(){clearPaint($(this))});$(".age").live("focusout",function(){age($(this).val())&&cssPaint($(this))});$(".adminAge").live("focus",function(){clearPaint($(this))});$(".adminAge").live("focusout",function(){adminAge($(this).val())&&cssPaint($(this))});$(".futureDate").live("focus",function(){clearPaint($(this))});$(".futureDate").live("focusout",function(){futureDate($(this).val())&&cssPaint($(this))});
$(".numeric").live("focus",function(){clearPaint($(this))});$(".numeric").live("focusout",function(){numeric($(this).val())&&cssPaint($(this))});$(".zip").live("focus",function(){clearPaint($(this))});$(".zip").live("focusout",function(){zip($(this).val())&&cssPaint($(this))});$(".equalTo").live("focus",function(){clearPaint($(this))});$(".equalTo").live("focusout",function(){equalTo($(this).val(),$(this))&&cssPaint($(this))});$(".checkPassword").live("focus",function(){clearPaint($(this))});
$(".checkPassword").live("focusout",function(){checkPassword($(this).val(),$(this).attr("sel"),$(this))});$(".nospecial").live("focus",function(){clearPaint($(this))});$(".nospecial").live("focusout",function(){nospecial($(this).val())&&cssPaint($(this))});$(".ac_input").live("focus",function(){clearPaint($(this))});$(".isChecked").live("click",function(){clearPaint($(this));$(".message").html("")});$(".disabled").live("click",function(a){a.preventDefault()});
function cssPaint(a){a.addClass("hasError");a.after('<span class="validationError">'+$message+"</span>");$("form button").addClass("disabled")}function clearPaint(a){a.removeClass("hasError");a.next("span.validationError").remove();$("form button").removeClass("disabled")}function required(a){return 0==a.length?($message="This field is required",!0):!1}
function email(a){a=a.replace(" ","").replace("\t","");if(0==a.length)return $message="Your email is required",!0;return!/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(a)?($message="Please provide a valid email",!0):!1}function equalTo(a,c){var b=c.parent("p").prev("p").children("input").val();return a!=b?($message="The passwords do not match",!0):!1}
function checkPassword(a,c,b){$.ajax({url:"/ajax/admin/admin_functionality.php",type:"POST",data:{id:c,checkPassword:a},success:function(a){!1!=a&&($message=a,cssPaint(b))}})}function numeric(a){if(0==a.length)return $message="this field is required",!0;return!/^[-]?\d*\.?\d*$/.test(a)?($message="All values must be numeric",!0):!1}function zip(a){if(0==a.length)return!0;return!/^\d{5}(-\d{4})?$/.test(a)?($message="Please enter a valid zip",!0):!1}
function usPhone(a){if(0==a.length)return $message="This field is required",!0;return!/^\(?[2-9]\d{2}[\)\.-]?\s?\d{3}[\s\.-]?\d{4}$/.test(a)?($message="Please enter a valid US phone (xxx)xxx-xxxx",!0):!1}function nospecial(a){if(0==a.length)return!0;return!/^[a-zA-Z0-9 \?]*$/.test(a)?($message="Please do not enter any special characters",!0):!1}
function date(a){if(0==a.length)return!0;var c=/^(\d{2})[\/](\d{2})[\/](\d{4})$/;if(!c.test(a))return $message="Please enter a valid date. mm/dd/yyyyy",!0;var b=a.match(c),a=b[1],c=parseInt(b[2]),b=parseInt(b[3]),d=(new Date).getFullYear();(new Date).getDate();(new Date).getMonth();if(1>a||12<a||1900>b||b>d)return $message="Please enter a valid date. mm/dd/yyyyy",!0;return 1>c&&c>(2==a?0==b%4?29:28:4==a||6==a||9==a||11==a?30:31)?($message="Please enter a valid date. mm/dd/yyyyy",!0):!1}
function futureDate(a){if(0==a.length)return!0;var c=/^(\d{2})[\/](\d{2})[\/](\d{4})$/;if(!c.test(a))return $message="Please Enter Valid Date mm/dd/yyyy",!0;var b=a.match(c),a=parseInt(b[1]),c=parseInt(b[2]),b=parseInt(b[3]),d=(new Date).getFullYear(),e=(new Date).getDate(),f=(new Date).getMonth();if(1>a||12<a||1900>b)return $message="Please Enter Valid Date mm/dd/yyyy",!0;if(1>c&&c>(2==a?0==b%4?29:28:4==a||6==a||9==a||11==a?30:31))return $message="Please enter a valid date. mm/dd/yyyyy",!0;if(b<
d)return $message="Must be a future Date",!0;if(b==d&&a<f+1)return $message="Must be a future Date",!0;if(b==d&&a==f+1&&c<e)return $message="Must be a future Date",!0}function isChecked(a){return!a.is(":checked")?!0:!1}
function validate(a){a.children("fieldset").find(":input:not(button)").each(function(){var a=$(this),b=a.attr("class"),d=a.val(),e=a.attr("sel");switch(b){case "required":required(d)&&cssPaint(a);break;case "email":email(d)&&cssPaint(a);break;case "date":date(d)&&cssPaint(a);break;case "age":age(d)&&cssPaint(a);break;case "usPhone":usPhone(d)&&cssPaint(a);break;case "numeric":numeric(d)&&cssPaint(a);break;case "zip":zip(d)&&cssPaint(a);break;case "equalTo":equalTo(d,a)&&cssPaint(a);break;case "checkPassword":checkPassword(d,
e)&&cssPaint(a);break;case "nospecial":nospecial(d)&&cssPaint(a);break;case "isChecked":isChecked(a.attr("checked"))&&(a.addClass("hasError"),$(".message").html("<p>Please comply with our privacy policy.</p>"))}$(this).children("button").addClass("disabled")})};




//JQuery Autocomplete
(function(c){c.fn.extend({autocomplete:function(a,b){var q="string"==typeof a,b=c.extend({},c.Autocompleter.defaults,{url:q?a:null,data:q?null:a,delay:q?c.Autocompleter.defaults.delay:10,max:b&&!b.scroll?10:150},b);b.highlight=b.highlight||function(a){return a};b.formatMatch=b.formatMatch||b.formatItem;return this.each(function(){new c.Autocompleter(this,b)})},result:function(a){return this.bind("result",a)},search:function(a){return this.trigger("search",[a])},flushCache:function(){return this.trigger("flushCache")},
setOptions:function(a){return this.trigger("setOptions",[a])},unautocomplete:function(){return this.trigger("unautocomplete")}});c.Autocompleter=function(a,b){var q,p;function m(){var a=i.selected();if(!a)return!1;var c=a.result;k=c;if(b.multiple){var d=o(f.val());1<d.length&&(c=d.slice(0,d.length-1).join(b.multipleSeparator)+b.multipleSeparator+c);c+=b.multipleSeparator}f.val(c);e();f.trigger("result",[a.data,a.value]);return!0}function n(a,c){if(s==q)i.hide();else{var g=f.val();if(c||g!=k)k=g,g=
h(g),g.length>=b.minChars?(f.addClass(b.loadingClass),b.matchCase||(g=g.toLowerCase()),r(g,d,e)):(f.removeClass(b.loadingClass),i.hide())}}function o(a){if(!a)return[""];var a=a.split(b.multipleSeparator),g=[];c.each(a,function(a,b){c.trim(b)&&(g[a]=c.trim(b))});return g}function h(a){if(!b.multiple)return a;a=o(a);return a[a.length-1]}function e(){var g=i.visible();i.hide();clearTimeout(l);f.removeClass(b.loadingClass);b.mustMatch&&f.search(function(a){a||(b.multiple?(a=o(f.val()).slice(0,-1),f.val(a.join(b.multipleSeparator)+
(a.length?b.multipleSeparator:""))):f.val(""))});g&&c.Autocompleter.Selection(a,a.value.length,a.value.length)}function d(d,j){if(j&&j.length&&g){f.removeClass(b.loadingClass);i.display(j,d);var l=j[0].value;b.autoFill&&h(f.val()).toLowerCase()==d.toLowerCase()&&s!=p&&(f.val(f.val()+l.substring(h(k).length)),c.Autocompleter.Selection(a,k.length,k.length+l.length));i.show()}else e()}function r(g,d,e){b.matchCase||(g=g.toLowerCase());var f=j.load(g);if(f&&f.length)d(g,f);else if("string"==typeof b.url&&
0<b.url.length){var l={timestamp:+new Date};c.each(b.extraParams,function(a,b){l[a]="function"==typeof b?b():b});c.ajax({mode:"abort",port:"autocomplete"+a.name,dataType:b.dataType,url:b.url,data:c.extend({q:h(g),limit:b.max},l),success:function(a){var e;if(!(e=b.parse&&b.parse(a))){e=[];for(var a=a.split("\n"),f=0;f<a.length;f++){var h=c.trim(a[f]);h&&(h=h.split("|"),e[e.length]={data:h,value:h[0],result:b.formatResult&&b.formatResult(h,h[0])||h[0]})}}j.add(g,e);d(g,e)}})}else i.emptyList(),e(g)}
q=46;p=8;var f=c(a).attr("autocomplete","off").addClass(b.inputClass),l,k="",j=c.Autocompleter.Cache(b),g=0,s,u={mouseDownOnSelect:!1},i=c.Autocompleter.Select(b,a,m,u),t;c.browser.opera&&c(a.form).bind("submit.autocomplete",function(){if(t)return t=!1});f.bind((c.browser.opera?"keypress":"keydown")+".autocomplete",function(a){s=a.keyCode;switch(a.keyCode){case 38:a.preventDefault();i.visible()?i.prev():n(0,!0);break;case 40:a.preventDefault();i.visible()?i.next():n(0,!0);break;case 33:a.preventDefault();
i.visible()?i.pageUp():n(0,!0);break;case 34:a.preventDefault();i.visible()?i.pageDown():n(0,!0);break;case b.multiple&&","==c.trim(b.multipleSeparator)&&188:case 9:case 13:if(m())return a.preventDefault(),t=!0,!1;break;case 27:i.hide();break;default:clearTimeout(l),l=setTimeout(n,b.delay)}}).focus(function(){g++}).blur(function(){g=0;u.mouseDownOnSelect||(clearTimeout(l),l=setTimeout(e,200))}).click(function(){1<g++&&!i.visible()&&n(0,!0)}).bind("search",function(){function a(g,c){var d;if(c&&c.length)for(var e=
0;e<c.length;e++)if(c[e].result.toLowerCase()==g.toLowerCase()){d=c[e];break}"function"==typeof b?b(d):f.trigger("result",d&&[d.data,d.value])}var b=1<arguments.length?arguments[1]:null;c.each(o(f.val()),function(b,g){r(g,a,a)})}).bind("flushCache",function(){j.flush()}).bind("setOptions",function(a,g){c.extend(b,g);"data"in g&&j.populate()}).bind("unautocomplete",function(){i.unbind();f.unbind();c(a.form).unbind(".autocomplete")})};c.Autocompleter.defaults={inputClass:"ac_input",resultsClass:"ac_results",
loadingClass:"ac_loading",minChars:1,delay:400,matchCase:!1,matchSubset:!0,matchContains:!1,cacheLength:10,max:100,mustMatch:!1,extraParams:{},selectFirst:!0,formatItem:function(a){return a[0]},formatMatch:null,autoFill:!1,width:0,multiple:!1,multipleSeparator:", ",highlight:function(a,b){return a.replace(RegExp("(?![^&;]+;)(?!<[^<>]*)("+b.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi,"\\$1")+")(?![^<>]*>)(?![^&;]+;)","gi"),"<strong>$1</strong>")},scroll:!0,scrollHeight:180};c.Autocompleter.Cache=
function(a){function b(b,c){a.matchCase||(b=b.toLowerCase());var d=b.indexOf(c);"word"==a.matchContains&&(d=b.toLowerCase().search("\\b"+c.toLowerCase()));return-1==d?!1:0==d||a.matchContains}function q(b,c){o>a.cacheLength&&m();n[b]||o++;n[b]=c}function p(){if(!a.data)return!1;var b={},e=0;if(!a.url)a.cacheLength=1;b[""]=[];for(var d=0,m=a.data.length;d<m;d++){var f=a.data[d],f="string"==typeof f?[f]:f,l=a.formatMatch(f,d+1,a.data.length);if(!1!==l){var k=l.charAt(0).toLowerCase();b[k]||(b[k]=[]);
f={value:l,data:f,result:a.formatResult&&a.formatResult(f)||l};b[k].push(f);e++<a.max&&b[""].push(f)}}c.each(b,function(b,g){a.cacheLength++;q(b,g)})}function m(){n={};o=0}var n={},o=0;setTimeout(p,25);return{flush:m,add:q,populate:p,load:function(h){if(!a.cacheLength||!o)return null;if(!a.url&&a.matchContains){var e=[],d;for(d in n)if(0<d.length){var m=n[d];c.each(m,function(a,c){b(c.value,h)&&e.push(c)})}return e}if(n[h])return n[h];if(a.matchSubset)for(d=h.length-1;d>=a.minChars;d--)if(m=n[h.substr(0,
d)])return e=[],c.each(m,function(a,c){b(c.value,h)&&(e[e.length]=c)}),e;return null}}};c.Autocompleter.Select=function(a,b,q,p){var m;function n(){l&&(k=c("<div/>").hide().addClass(a.resultsClass).css("position","absolute").appendTo(document.body),j=c("<ul/>").appendTo(k).mouseover(function(a){o(a).nodeName&&"LI"==o(a).nodeName.toUpperCase()&&(d=c("li",j).removeClass(m).index(o(a)),c(o(a)).addClass(m))}).click(function(a){c(o(a)).addClass(m);q();b.focus();return!1}).mousedown(function(){p.mouseDownOnSelect=
!0}).mouseup(function(){p.mouseDownOnSelect=!1}),0<a.width&&k.css("width",a.width),l=!1)}function o(a){for(a=a.target;a&&"LI"!=a.tagName;)a=a.parentNode;return!a?[]:a}function h(b){e.slice(d,d+1).removeClass(m);d+=b;0>d?d=e.size()-1:d>=e.size()&&(d=0);b=e.slice(d,d+1).addClass(m);if(a.scroll){var c=0;e.slice(0,d).each(function(){c+=this.offsetHeight});c+b[0].offsetHeight-j.scrollTop()>j[0].clientHeight?j.scrollTop(c+b[0].offsetHeight-j.innerHeight()):c<j.scrollTop()&&j.scrollTop(c)}}m="ac_over";var e,
d=-1,r,f="",l=!0,k,j;return{display:function(b,h){n();r=b;f=h;j.empty();for(var k=a.max&&a.max<r.length?a.max:r.length,i=0;i<k;i++)if(r[i]){var l=a.formatItem(r[i].data,i+1,k,r[i].value,f);!1!==l&&(l=c("<li/>").html(a.highlight(l,f)).addClass(0==i%2?"ac_even":"ac_odd").appendTo(j)[0],c.data(l,"ac_data",r[i]))}e=j.find("li");a.selectFirst&&(e.slice(0,1).addClass(m),d=0);c.fn.bgiframe&&j.bgiframe()},next:function(){h(1)},prev:function(){h(-1)},pageUp:function(){0!=d&&0>d-8?h(-d):h(-8)},pageDown:function(){d!=
e.size()-1&&d+8>e.size()?h(e.size()-1-d):h(8)},hide:function(){k&&k.hide();e&&e.removeClass(m);d=-1},visible:function(){return k&&k.is(":visible")},current:function(){return this.visible()&&(e.filter("."+m)[0]||a.selectFirst&&e[0])},show:function(){var d=c(b).offset();k.css({width:"string"==typeof a.width||0<a.width?a.width:c(b).width(),top:d.top+b.offsetHeight,left:d.left}).show();if(a.scroll&&(j.scrollTop(0),j.css({maxHeight:a.scrollHeight,overflow:"auto"}),c.browser.msie&&"undefined"===typeof document.body.style.maxHeight)){var f=
0;e.each(function(){f+=this.offsetHeight});d=f>a.scrollHeight;j.css("height",d?a.scrollHeight:f);d||e.width(j.width()-parseInt(e.css("padding-left"))-parseInt(e.css("padding-right")))}},selected:function(){var a=e&&e.filter("."+m).removeClass(m);return a&&a.length&&c.data(a[0],"ac_data")},emptyList:function(){j&&j.empty()},unbind:function(){k&&k.remove()}}};c.Autocompleter.Selection=function(a,b,c){if(a.createTextRange){var p=a.createTextRange();p.collapse(!0);p.moveStart("character",b);p.moveEnd("character",
c);p.select()}else if(a.setSelectionRange)a.setSelectionRange(b,c);else if(a.selectionStart)a.selectionStart=b,a.selectionEnd=c;a.focus()}})(jQuery);


//Block UI
(function(b){function m(d,a){var e=d==window,c=a&&void 0!==a.message?a.message:void 0,a=b.extend({},b.blockUI.defaults,a||{});a.overlayCSS=b.extend({},b.blockUI.defaults.overlayCSS,a.overlayCSS||{});var g=b.extend({},b.blockUI.defaults.css,a.css||{}),i=b.extend({},b.blockUI.defaults.themedCSS,a.themedCSS||{}),c=void 0===c?a.message:c;e&&j&&p(window,{fadeOut:0});if(c&&"string"!=typeof c&&(c.parentNode||c.jquery)){var h=c.jquery?c[0]:c,f={};b(d).data("blockUI.history",f);f.el=h;f.parent=h.parentNode;
f.display=h.style.display;f.position=h.style.position;f.parent&&f.parent.removeChild(h)}var f=a.baseZ,k=b.browser.msie||a.forceIframe?b('<iframe class="blockUI" style="z-index:'+f++ +';display:none;border:none;margin:0;padding:0;position:absolute;width:100%;height:100%;top:0;left:0" src="'+a.iframeSrc+'"></iframe>'):b('<div class="blockUI" style="display:none"></div>'),h=b('<div class="blockUI blockOverlay" style="z-index:'+f++ +';display:none;border:none;margin:0;padding:0;width:100%;height:100%;top:0;left:0"></div>'),
f=b(a.theme&&e?'<div class="blockUI '+a.blockMsgClass+' blockPage ui-dialog ui-widget ui-corner-all" style="z-index:'+f+';display:none;position:fixed"><div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(a.title||"&nbsp;")+'</div><div class="ui-widget-content ui-dialog-content"></div></div>':a.theme?'<div class="blockUI '+a.blockMsgClass+' blockElement ui-dialog ui-widget ui-corner-all" style="z-index:'+f+';display:none;position:absolute"><div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+
(a.title||"&nbsp;")+'</div><div class="ui-widget-content ui-dialog-content"></div></div>':e?'<div class="blockUI '+a.blockMsgClass+' blockPage" style="z-index:'+f+';display:none;position:fixed"></div>':'<div class="blockUI '+a.blockMsgClass+' blockElement" style="z-index:'+f+';display:none;position:absolute"></div>');c&&(a.theme?(f.css(i),f.addClass("ui-widget-content")):f.css(g));(!a.applyPlatformOpacityRules||!b.browser.mozilla||!/Linux/.test(navigator.platform))&&h.css(a.overlayCSS);h.css("position",
e?"fixed":"absolute");(b.browser.msie||a.forceIframe)&&k.css("opacity",0);var g=[k,h,f],o=e?b("body"):b(d);b.each(g,function(){this.appendTo(o)});a.theme&&a.draggable&&b.fn.draggable&&f.draggable({handle:".ui-dialog-titlebar",cancel:"li"});g=v&&(!b.boxModel||0<b("object,embed",e?null:d).length);if(r||g){e&&a.allowBodyStretch&&b.boxModel&&b("html,body").css("height","100%");if((r||!b.boxModel)&&!e)var g=parseInt(b.css(d,"borderTopWidth"))||0,i=parseInt(b.css(d,"borderLeftWidth"))||0,m=g?"(0 - "+g+
")":0,n=i?"(0 - "+i+")":0;b.each([k,h,f],function(b,d){var c=d[0].style;c.position="absolute";if(2>b)e?c.setExpression("height","Math.max(document.body.scrollHeight, document.body.offsetHeight) - (jQuery.boxModel?0:"+a.quirksmodeOffsetHack+') + "px"'):c.setExpression("height",'this.parentNode.offsetHeight + "px"'),e?c.setExpression("width",'jQuery.boxModel && document.documentElement.clientWidth || document.body.clientWidth + "px"'):c.setExpression("width",'this.parentNode.offsetWidth + "px"'),n&&
c.setExpression("left",n),m&&c.setExpression("top",m);else if(a.centerY)e&&c.setExpression("top",'(document.documentElement.clientHeight || document.body.clientHeight) / 2 - (this.offsetHeight / 2) + (blah = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"'),c.marginTop=0;else if(!a.centerY&&e){var f="((document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "+(a.css&&a.css.top?parseInt(a.css.top):
0)+') + "px"';c.setExpression("top",f)}})}c&&(a.theme?f.find(".ui-widget-content").append(c):f.append(c),(c.jquery||c.nodeType)&&b(c).show());(b.browser.msie||a.forceIframe)&&a.showOverlay&&k.show();if(a.fadeIn)g=a.onBlock?a.onBlock:q,k=a.showOverlay&&!c?g:q,g=c?g:q,a.showOverlay&&h._fadeIn(a.fadeIn,k),c&&f._fadeIn(a.fadeIn,g);else if(a.showOverlay&&h.show(),c&&f.show(),a.onBlock)a.onBlock();s(1,d,a);e?(j=f[0],l=b(":input:enabled:visible",j),a.focusInput&&setTimeout(t,20)):w(f[0],a.centerX,a.centerY);
a.timeout&&(c=setTimeout(function(){e?b.unblockUI(a):b(d).unblock(a)},a.timeout),b(d).data("blockUI.timeout",c))}function p(d,a){var e=d==window,c=b(d),g=c.data("blockUI.history"),i=c.data("blockUI.timeout");i&&(clearTimeout(i),c.removeData("blockUI.timeout"));a=b.extend({},b.blockUI.defaults,a||{});s(0,d,a);var h;h=e?b("body").children().filter(".blockUI").add("body > .blockUI"):b(".blockUI",d);e&&(j=l=null);a.fadeOut?(h.fadeOut(a.fadeOut),setTimeout(function(){n(h,g,a,d)},a.fadeOut)):n(h,g,a,d)}
function n(d,a,e,c){d.each(function(){this.parentNode&&this.parentNode.removeChild(this)});if(a&&a.el)a.el.style.display=a.display,a.el.style.position=a.position,a.parent&&a.parent.appendChild(a.el),b(c).removeData("blockUI.history");if("function"==typeof e.onUnblock)e.onUnblock(c,e)}function s(d,a,e){var c=a==window,a=b(a);if(d||!(c&&!j||!c&&!a.data("blockUI.isBlocked")))c||a.data("blockUI.isBlocked",d),e.bindEvents&&(!d||e.showOverlay)&&(d?b(document).bind("mousedown mouseup keydown keypress",e,
u):b(document).unbind("mousedown mouseup keydown keypress",u))}function u(d){if(d.keyCode&&9==d.keyCode&&j&&d.data.constrainTabKey){var a=l,e=d.shiftKey&&d.target===a[0];if(!d.shiftKey&&d.target===a[a.length-1]||e)return setTimeout(function(){t(e)},10),!1}a=d.data;return 0<b(d.target).parents("div."+a.blockMsgClass).length?!0:0==b(d.target).parents().children().filter("div.blockUI").length}function t(b){l&&(b=l[!0===b?l.length-1:0])&&b.focus()}function w(d,a,e){var c=d.parentNode,g=d.style,i=(c.offsetWidth-
d.offsetWidth)/2-(parseInt(b.css(c,"borderLeftWidth"))||0),d=(c.offsetHeight-d.offsetHeight)/2-(parseInt(b.css(c,"borderTopWidth"))||0);if(a)g.left=0<i?i+"px":"0";if(e)g.top=0<d?d+"px":"0"}if(/1\.(0|1|2)\.(0|1|2)/.test(b.fn.jquery)||/^1.1/.test(b.fn.jquery))alert("blockUI requires jQuery v1.2.3 or later!  You are using v"+b.fn.jquery);else{b.fn._fadeIn=b.fn.fadeIn;var q=function(){},o=document.documentMode||0,v=b.browser.msie&&(8>b.browser.version&&!o||8>o),r=b.browser.msie&&/MSIE 6.0/.test(navigator.userAgent)&&
!o;b.blockUI=function(b){m(window,b)};b.unblockUI=function(b){p(window,b)};b.growlUI=function(d,a,e,c){var g=b('<div class="growlUI"></div>');d&&g.append("<h1>"+d+"</h1>");a&&g.append("<h2>"+a+"</h2>");void 0==e&&(e=3E3);b.blockUI({message:g,fadeIn:700,fadeOut:1E3,centerY:!1,timeout:e,showOverlay:!1,onUnblock:c,css:b.blockUI.defaults.growlCSS})};b.fn.block=function(d){return this.unblock({fadeOut:0}).each(function(){if("static"==b.css(this,"position"))this.style.position="relative";if(b.browser.msie)this.style.zoom=
1;m(this,d)})};b.fn.unblock=function(b){return this.each(function(){p(this,b)})};b.blockUI.version=2.37;b.blockUI.defaults={message:"<h1>Please wait...</h1>",title:null,draggable:!0,theme:!1,css:{padding:0,margin:0,width:"30%",top:"40%",left:"35%",textAlign:"center",color:"#000",border:"3px solid #aaa",backgroundColor:"#fff",cursor:"wait"},themedCSS:{width:"30%",top:"40%",left:"35%"},overlayCSS:{backgroundColor:"#000",opacity:0.6,cursor:"wait"},growlCSS:{width:"350px",top:"10px",left:"",right:"10px",
border:"none",padding:"5px",opacity:0.6,cursor:"default",color:"#fff",backgroundColor:"#000","-webkit-border-radius":"10px","-moz-border-radius":"10px","border-radius":"10px"},iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank",forceIframe:!1,baseZ:1E3,centerX:!0,centerY:!0,allowBodyStretch:!0,bindEvents:!0,constrainTabKey:!0,fadeIn:200,fadeOut:400,timeout:0,showOverlay:!0,focusInput:!0,applyPlatformOpacityRules:!0,onBlock:null,onUnblock:null,quirksmodeOffsetHack:4,
blockMsgClass:"blockMsg"};var j=null,l=[]}})(jQuery);


//Open JS Grid 
$(function(){$.fn.loadGrid=function(a){return this.each(function(){function c(a){b.data().loadStart&&b.loadStart();b.data("gridLoading",!1);b.data("totalRows",a.nRows);b.data("firstRowShowing",a.start);b.data("lastRowShowing",a.end);b.data("rowData",{});a.colData&&$.each(a.colData,function(a,c){$.each(c,function(c,d){b.data().columnOpts[a]&&(b.data().columnOpts[a][c]=d)})});if(b.data().pager){var c=b.getHeaderRow().find("th[col="+a.order_by+"]").text();if(a.end>a.nRows)a.end=a.nRows;g.find(".gridTotal").html(""+
a.start+" - "+a.end+" of <span class='nRows'>"+a.nRows+"</span> by "+c+" "+a.sort);$(".nRows").click(function(){$(this).parents(".gridContainer").find(".grid").loadGrid({nRowsShowing:$(this).html()})})}b.find("tr").remove();b.getHeaderRow().find("th[col='#'],th[col='X'],th[col='+']").remove();b.getHeaderRow().find("th");if(a.rows&&"[object Object]"==a.rows.toString()){var e=d.rowClick?d.rowClick:null;$.each(a.rows,function(a,c){a=a.substr(1);if(!b.getHeaderRow().find("[primary_key="+a+"]").length){var d=
$("<tr primary_key='"+a+"'>");e&&d.click(e);$.each(b.data().columnOpts,function(f,g){var h=c[f];g.currency&&(h=formatMoney(h,g.currency));b.data().columnOpts[f].value=h;if(g.type&&"image"==g.type){var h="<img style='width:100%' src='"+h+"'/>",e=b.getHeaderRow().find("th[col="+f+"]");e.attr("width")||e.attr("width",100)}g.link&&(e="<a target='"+g.linkTarget+"' href='"+g.link+"'>"+h+"</a>",h=e=e.replace("{COL}",f).replace("{VALUE}",h).replace("{ROWID}",a));d.append("<td col='"+f+"'>"+h+"</td>")});b.append(d);
$.each(c,function(a,c){b.data().rowData[a]||(b.data().rowData[a]=[]);b.data().rowData[a].push({value:c})})}})}else b.append("<tr><td colspan=100>No Rows</td></tr>");$.each(b.data().columnOpts,function(a,c){c.link&&b.getCol(a).getTdsFromTh().each(function(){var a=$(this).find("a"),c=a.attr("href"),d=$(this).parents("tr"),f=c.match(/\[([\w]+)\]/g);f&&$.each(f,function(f,g){var h=g.match(/\[([\w]+)\]/)[1],e=d.prevAll().length;c=c.replace("["+h+"]",b.data().rowData[h][e].value);a.attr("href",c)})})});
b.getHeaderRow().find("th").each(function(a){if($(this).attr("width")){var c=parseInt($(this).attr("width"));b.find("tr:first td").eq(a).css("width",c)}});b.data().inlineEditing&&b.setupInlineEditing();try{$(".datepicker").datepicker({dateFormat:b.data().dateFormat})}catch(i){}0<b.data().totalRows?(b.data().showRowNumber&&b.createRowCount(),b.data().deleting&&b.createDeleteColumn()):b.parents(".gridContainer").find(".gridSave").fadeOut();b.hideHiddenCols();b.equalizeColumns();$.blockUI&&b.unblock();
b.data().loadComplete&&b.loadComplete()}var d=$.extend({order_by:"",sort:"ASC",page:1,search:"",justSearched:!1,nRowsShowing:10,resizable:!1,resizableColumns:!0,pager:!0,pagerLocation:"bottom",saveLocation:"pager",refreshButton:!1,dateRange:!1,dateRangeFrom:"",dateRangeTo:"",stickyRows:!0,clickToSort:!0,inlineEditing:!1,showRowNumber:!1,loadingMessage:"loading",maxLength:!1,width:"100%",height:"auto",maxHeight:500,fullScreen:!1,adding:!1,addButton:!1,linkTarget:"_blank",confirmBeforeSort:!0,deleting:!0,
deleteConfirm:!0,dateFormat:"yy-mm-dd",pageSearchResults:!1,columnOpts:null,rowClick:null,rowAdd:null,cellAdd:null,beforeLoadStart:null,loadStart:null,loadComplete:null,saveSuccess:null,saveFail:null,deleteSuccess:"Content Deleted",deleteFail:"Delete Failed",title:!1,searchBar:!0},a),b=$(this);b.parents(".gridWrapper").length||b.wrap("<div class='gridContainer'>").wrap("<div class='gridWrapper'>");b.data().page?$.extend(b.data(),a):$.each(d,function(a,c){"function"!=typeof c?b.data(a,c):($.fn[a]=
c,b.data(a,!0))});b.parents(".gridContainer").width(b.data().width);b.parents(".gridContainer").height(b.data().height);b.parents(".gridWrapper").css("max-height",b.data().maxHeight);$.blockUI&&b.block({message:b.data().loadingMessage});var e=b.moveHeaderRow();b.data().objectized||(e.find("th").each(function(){var a=$(this);1<a[0].attributes.length&&$.each($(a[0].attributes),function(c){var d=a[0].attributes[c].name,c=a[0].attributes[c].value;b.data().columnOpts||b.data("columnOpts",{});b.data().columnOpts[a.attr("col")]||
(b.data().columnOpts[a.attr("col")]={});b.data().columnOpts[a.attr("col")][d]=c})}),b.data("objectized",!0));if(b.data().pager)var g=b.createPager();b.attr("title")&&!b.parents(".gridContainer").find(".gridTitle").length&&(b.parents(".gridContainer").prepend("<div class='gridTitle'>"+b.attr("title")+"</div>"),b.data().adding?(b.parents(".gridContainer").find(".gridTitle").append("<div class='gridButton gridAdd'><div>Add</div></div>"),b.parents(".gridContainer").find(".gridAdd").click(function(){var a=
[];$.each(b.data().columnOpts,function(b,c){c.editable&&a.push(b)});$.post(b.attr("action"),{add:!0,cols:a},function(a){b.loadGrid({order_by:a,sort:"DESC"})})})):b.data().addButton&&b.parents(".gridContainer").find(".gridTitle").append("<a href='"+b.data().addButton+"' class='gridButton gridAdd'><div>Add</div></a>"));if(b.data().fullScreen){b.parents(".gridContainer").width("100%");b.parents(".gridContainer").find(".gridHeaderRow").width("100%");b.parents(".gridWrapper").css("max-height","none");
var e=parseInt(b.find("tr:last").css("height")),i=parseInt(b.parents(".gridContainer").find(".gridHeaderRow th:first").css("padding-top"));b.css("margin-bottom",e+i);g.addClass("fixed");$(window).resize(function(){b.equalizeColumns()})}b.data().resizable&&b.makeResizable();b.data("cols",b.getHeaderRow().find("th[col!='X'][col!='#'][col!='+']").attrJoin("col"));b.data().beforeLoadStart&&b.beforeLoadStart();b.data("gridLoading",!0);$.ajax({url:b.attr("action"),type:"POST",data:{data:b.data(),table:b.attr("sel"),
load:!0}, dataType:"json",  success:function(a,b,d){$(".data").html(a);$(".data").html(a.colData);c(a,b,d)}})})};$(".gridSearch input[type=text]").live("keyup",function(){var a=$(this).parents(".gridContainer").find(".grid");!1==a.data().justSearched?(a.loadGrid({search:$(this).val(),page:1}),a=$(this).parents(".gridContainer").find(".grid"),a.parents(".gridContainer").find(".gridSearch input").val(search)):a.data("justSearched",!1)}).live("keydown",function(a){var c=$(this).parents(".gridContainer").find(".grid");
if("13"==a.keyCode&&(2<$(this).val().length||0==$(this).val().length))c.data("justSearched",!0),c.loadGrid({search:$(this).val(),page:1})});$(".nRowsShowing").live("keydown",function(a){13==a.keyCode&&0<parseInt($(this).val())&&($(this).parents(".gridContainer").find(".grid").loadGrid({nRowsShowing:$(this).val()}),a.preventDefault())}).live("keyup",function(){$(this).parents(".gridContainer").find(".grid").parents(".gridContainer").find(".nRowsShowing").val($(this).val())});$(".gridHeaderRow th").live("click",
function(a){var c=$(this).parents(".gridContainer").find(".grid"),d=!0;c.find("tr.toBeSaved").length&&c.data().confirmBeforeSort&&(d=confirm("You have unsaved changes on the grid, if you continue those changes will be lost. Continue?"));!$(a.target).hasClass("colHandle")&&d&&c.data().clickToSort&&(a="DESC"==c.data().sort?"ASC":"DESC",c.loadGrid({sort:a,order_by:$(this).attr("col")}))});$(".gridHeaderRow th").live("mousedown",function(a){if(3!=a.which)return!1});$(".gridHeaderRow th").live("contextmenu",
function(a){var c=$(this),d=$(this).parents(".gridContainer").find(".grid");0<$(".gridContext").length&&$(".gridContext").remove();var b="checkbox"==d.data().columnOpts[$(this).attr("col")].editable?"block":"none",e=!1,g=null,i=null,f=null,h=null,k=null;$(this).getTdsFromTh().each(function(a){var b=$(this).find("input").length?$(this).find("input").val():$(this).text();-1==b.search(/^[\d.\$\u00db\u00a3\u00b4\u00a3]*$/)&&(e=!0);b=parseFloat(b.replace(/[\$\u00db\u00a3\u00b4]/,""));g+=b;h||(h=b);f=b>
f?b:f;h=b<h?b:h;k=a});var g=Math.round(100*g)/100,i=Math.round(100*(f/k))/100,j=e?"none":"block";if(d.data().columnOpts[c.attr("col")].currency)c=d.data().columnOpts[c.attr("col")].currency,g=formatMoney(g,c),h=formatMoney(h,c),f=formatMoney(f,c),i=formatMoney(i,c);a=$("<div class='gridContext'><div class='closeContext'>x</div><div class='makeFluid'>Make Fluid</div><div class='colHide'>Remove</div><div class='colHighlite'>Highlite</div><div class='colDeHighlight'>Un-Highlite</div><hr style='display:"+
j+"'><div style='display:"+j+"'>Sum: <span class='showSum'>"+g+"</span></div><div style='display:"+j+"'>Avg: <span class='showAvg'>"+i+"</span></div><div style='display:"+j+"'>Max: <span class='showMax'>"+f+"</span></div><div style='display:"+j+"'>Min: <span class='showMin'>"+h+"</span></div><hr style='display:"+b+"'><div style='display:"+b+"' class='checkAll'>Check All</div><div style='display:"+b+"' class='uncheckAll'>UnCheck All</div></div>").css({left:a.clientX+200>$(window).width()?a.clientX-
200:a.clientX,top:a.clientY});a.attr("index",$(this).prevAll().length);$(this).parents(".gridContainer").append(a);d=$(this).parents(".gridContainer").find(".grid");$(".closeContext").click(function(){d.equalizeColumns()});return!1});$(".checkAll").live("click",function(){var a=$(this).parent().attr("index"),c=$(this).parents(".gridContainer").find(".grid");c.getHeaderRow().find("th").eq(a).getTdsFromTh().each(function(){$(this).find(":checkbox").attr("checked",!0);$(this).parents("tr").addClass("toBeSaved")});
c.equalizeColumns()});$(".uncheckAll").live("click",function(){var a=$(this).parent().attr("index"),c=$(this).parents(".gridContainer").find(".grid");c.getHeaderRow().find("th").eq(a).getTdsFromTh().each(function(){$(this).find(":checkbox").attr("checked",!1);$(this).parents("tr").addClass("toBeSaved")});c.equalizeColumns()});$(".makeFluid").live("click",function(){var a=$(this).parent().attr("index"),c=$(this).parents(".gridContainer").find(".grid"),d=c.getHeaderRow().find("th").eq(a),a=c.find("tr:first td").eq(a);
d.removeAttr("width");a.width("auto");c.equalizeColumns()});$(".colHide").live("click",function(){var a=$(this).parent().attr("index"),c=$(this).parents(".gridContainer").find(".grid"),a=c.getHeaderRow().find("th").eq(a);a.getTdsFromTh().each(function(){$(this).remove()});a.remove();c.equalizeColumns()});$(".colHighlite").live("click",function(){var a=$(this).parent().attr("index"),c=$(this).parents(".gridContainer").find(".grid");c.getHeaderRow().find("th").eq(a).getTdsFromTh().each(function(){$(this).addClass("hilite")});
c.equalizeColumns()});$(".colDeHighlight").live("click",function(){var a=$(this).parent().attr("index"),c=$(this).parents(".gridContainer").find(".grid");c.getHeaderRow().find("th").eq(a).getTdsFromTh().each(function(){$(this).removeClass("hilite")});c.equalizeColumns()});$(".gridTitle").live("click",function(){0<$(".gridContext").length&&$(".gridContext").remove()});$(".grid tr").live("dblclick",function(){var a=$(this).parents(".grid");a.data().stickyRows&&($(this).addClass("stuckRow"),a.getHeaderRow().append($(this)),
a.equalizeColumns())});$(".gridHeaderRow tr").live("dblclick",function(){var a=$(this).parents(".gridContainer").find(".grid");$(this).prevAll().length&&($(this).remove(),a.loadGrid())});$(".gridNext").live("click",function(){var a=$(this).parents(".gridContainer").find(".grid");if(!a.data().gridLoading){var c=parseInt(a.data().lastRowShowing);parseInt(a.data().nRowsShowing);var d=parseInt(a.data().totalRows);c<d&&a.loadGrid({page:parseInt(a.data().page)+1})}});$(".gridBack").live("click",function(){var a=
$(this).parents(".gridContainer").find(".grid");!a.data().gridLoading&&1<a.data().page&&a.loadGrid({page:parseInt(a.data().page)-1})});$(".gridRefresh").live("click",function(){$(this).parents(".gridContainer").find(".grid").loadGrid()});$(".gridWrapper").live("mousedown",function(){if(!$(this).find(".grid").data().inlineEditing)return!1});$(".gridButton, .gridHandle").live("mousedown",function(){return!1});$(window).resize(function(){});$.fn.exportAsJson=function(){return $(this).data().rowData};
$.fn.hideHiddenCols=function(){var a=$(this);$.each(a.data().columnOpts,function(c,d){d.display&&"hidden"==d.display&&a.hideCol(d.col)})};$.fn.hideCol=function(a){a=$(this).getHeaderRow().find("th[col="+a+"]");a.hide();a.getTdsFromTh().hide()};$.fn.setupInlineEditing=function(){var a=$(this);a.data().pager||a.data("saveLocation","title");a.parents(".gridContainer").find(".gridSave").remove();switch(a.data().saveLocation){case "title":a.parents(".gridContainer").find(".gridTitle").append("<div class='gridButton gridSave'><div>Save</div></div>");
break;case "both":a.getPager().append("<div class='gridButton gridSave'><div>Save</div></div>");a.parents(".gridContainer").find(".gridTitle").append("<div class='gridButton gridSave'><div>Save</div></div>");break;default:a.getPager().append("<div class='gridButton gridSave'><div>Save</div></div>")}var c=a.parents(".gridContainer").find(".gridSave");"none"==c.css("display")&&c.fadeIn().click(function(){var d=[];a.find("tr.toBeSaved").each(function(){var a=[];$(this).find(".editableInput").each(function(){var b=
$(this).parent().attr("col"),c="checkbox"==$(this)[0].type?$(this)[0].checked?1:0:$(this).val(),c=c.toString().replace(/"/g,'\\"'),c=c.toString().replace(/\r|\n/g,"\\n");a.push('"'+b+'":"'+c+'"')});var b=$(this).attr("primary_key"),c="{"+a.join(",")+"}";d.push('"'+b+'":'+c)});var b="{"+d.join(",")+"}";"{}"!=b&&(console.log(b),$.blockUI&&a.block({message:a.data().loadingMessage}),$.post(a.attr("action"),{save:1,json:b},function(b){b?(c.text("ERROR! refresh"),alert(b),a.data().saveFail&&a.saveFail()):
(c.html("Saved!").fadeOut("fast",function(){c.fadeIn("fast",function(){c.html("Save");a.data().saveSuccess&&a.saveSuccess()})}),a.loadGrid())}))});a.getHeaderRow().find("th").each(function(){var c=$(this),b=c.attr("col");if(a.data().columnOpts[b]&&a.data().columnOpts[b].editable){var e=a.data().columnOpts[b].editable;"text"==e||"inline"==e||"date"==e||"textarea"==e?c.getTdsFromTh().each(function(){var c=$(this);if(!c.hasClass("editableCell")){c.addClass("editableCell");var d=d?0:c.width(),f="";a.data().columnOpts[b].maxLength&&
(f="maxlength='"+a.data().columnOpts[b].maxLength+"'");"null"==c.text()&&c.text("");var h="date"==e?"datepicker":"",f="textarea"==e?$("<textarea "+f+' class="editableInput '+h+'"></textarea>'):$("<input "+f+' class="editableInput '+h+'" type="text" />');f.val(c.text());f.focus(function(){$(this).parents("tr").addClass("toBeSaved")});c.html(f);c.width(d)}}):"passthru"==e?c.getTdsFromTh().each(function(){var a=$(this);if(!a.hasClass("editableCell")){a.addClass("editableCell");"null"==a.text()&&a.text("");
var b=$("<input type='hidden' class='editableInput' value='"+a.text()+"'/>");b.focus(function(){$(this).parents("tr").addClass("toBeSaved")});a.append(b)}}):"select"==e?$.post(a.attr("action"),{select:1,col:b},function(g){c.getTdsFromTh().each(function(){var c=$(this),d=$("<select class='editableInput'></select>");(nullText=a.data().columnOpts[b].nulltext)&&d.append("<option value=''>"+nullText+"</option>");$.each(g,function(a,b){c.text()==a?d.append("<option selected value='"+a+"'>"+b+"</option>"):
d.append("<option value='"+a+"'>"+b+"</option>")});d.focus(function(){$(this).parents("tr").addClass("toBeSaved")});$(this).addClass("editableCell").html(d)});a.equalizeColumns()},"json"):"checkbox"==e&&c.getTdsFromTh().each(function(){$(this).addClass("editableCell");var a=parseInt($(this).text()),a=a?$("<input class='editableInput' type='checkbox' checked value='"+a+"'/>"):$("<input class='editableInput' type='checkbox' value='"+a+"'/>");a.click(function(){$(this).parents("tr").addClass("toBeSaved")});
$(this).html(a)})}})};$.fn.createRowCount=function(){var a=$(this);a.getHeaderRow().find("tr:first").prepend("<th style='width:20px' col='#'><div class='colResizer' style='width:20px'>#<div class='colHandle'></div></div></th>");a.find("tr").each(function(c){c+=parseInt(a.data().firstRowShowing);$(this).prepend("<td col='#'>"+c+"</td>")});a.equalizeColumns()};$.fn.createDeleteColumn=function(){var a=$(this);a.getHeaderRow().find("tr:first").append("<th col='X' style='width:20px'><div class='colResizer' style='width:20px'>Delete<div class='colHandle'></div></div></th>");
a.find("tr").each(function(){var c=$(this);$del=$("<div class='deleteGrid ninjaSymbol ninjaSymbolClear'></div>");$del.click(function(){if(a.data().deleteConfirm){var d=c.prevAll().length,d=a.data().rowData[a.data().deleteConfirm]?a.data().rowData[a.data().deleteConfirm][d].value:"";confirm("Are you sure you want to delete "+d+" ?")&&$.post(a.attr("action"),{"delete":!0,primary_key:$(this).parents("tr").attr("primary_key"),table:$(this).parents("tr").parent("tbody").parent("table").attr("sel")},function(b){b?
(a.loadGrid(),a.data().deleteSuccess&&a.deleteSuccess()):(a.data().deleteFail&&a.deleteFail(),alert("Error: Delete Failed"))})}else $.post(a.attr("action"),{"delete":!0,primary_key:$(this).parents("tr").attr("primary_key")},function(){a.loadGrid()})});$(this).append($("<td col='X' style='width:20px'></td>").append($del))});a.equalizeColumns()};$.fn.getCol=function(a){return $(this).getHeaderRow().find("th[col="+a+"]")};$.fn.getTdsFromTh=function(){return $(this).parents(".gridContainer").find(".grid").find("td[col="+
$(this).attr("col")+"]")};$.fn.equalizeColumns=function(){var a=$(this);return this.each(function(){0<$(".gridContext").length&&$(".gridContext").remove();var c=a.getHeaderRow();if(a.height()>a.parents(".gridWrapper").height()){c.find(".scrollTh").remove();var d=$("<th></th>").addClass("scrollTh").css({padding:0,margin:0,width:15});c.find("tr:first").append(d)}else a.parents(".gridWrapper").height()>a.height()&&$(".scrollTh").remove();a.find("tr:first td:visible").each(function(a){a=c.find(".colResizer").eq(a);
parseInt(a.parents("th").css("padding-left"));parseInt(a.parents("th").css("padding-left"));a.width($(this).width())})})};$.fn.moveHeaderRow=function(){var a=$(this);a.getHeaderRow().length||($firstTr=a.find("tr:first").clone(),a.parents(".gridContainer").prepend($("<table class='gridHeaderRow'>").append($firstTr)),$firstTr.find("th").each(function(){var c=$(this),d=c.text();c.html("");a.getHeaderRow().find("th");var b=$("<div class='colHandle'></div>");b.height(c.outerHeight());d=$("<div class='colResizer'></div>").html(d).append(b);
a.data().resizableColumns&&b.mousedown(function(b){var d=b.clientX;$(document).bind("mousemove.grid",function(b){var f=c.find("div.colResizer"),e=f.width()+(b.clientX-d),k=c.prevAll().length;f.width(e);a.find("tr:first td").eq(k).width(e);d=b.clientX;a.equalizeColumns();c.attr("width",e)});$(document).mouseup(function(){$(document).unbind("mousemove.grid")})});c.width("auto");c.append(d);d=-1*parseInt(c.css("padding-top"));b.css({top:d,right:-1*b.outerWidth()/1.9})}),a.getHeaderRow().find(".colhandle:last").remove());
return a.getHeaderRow()};$.fn.createPager=function(){var a=$(this),c=a.getPager();if(!c.length){c="";a.data().dateRange&&(c="<div class='dateRange'><input type='text' class='dateRangeFrom datepicker' value='"+a.data().dateRangeFrom+"'/> -<input type='text' class='dateRangeTo datepicker' value='"+a.data().dateRangeTo+"'/></div><div class='gridButton dateGo'><div>Go</div></div>");var d="";a.data().refreshButton&&(d="<div class='gridButton gridRefresh'><div>Refresh</div></div>");c=$("<div class='gridPager'>"+
d+"<div class='gridSearch'><input type='text' placeholder='search' value=''/></div><div class='gridLimit'><input type='text' value='"+a.data().nRowsShowing+"' style='width:20px' class='nRowsShowing'/></div><div class='gridButton gridBack'><div>Back</div></div><div class='gridButton gridNext'><div>Next</div></div><div class='gridTotal'></div>"+c+"<div class='gridButton gridSave'><div>Save</div></div></div>");switch(a.data().pagerLocation){case "bottom":a.parents(".gridContainer").append(c);break;case "top":a.parents(".gridContainer").prepend(c);
break;case "both":a.parents(".gridContainer").prepend(c.clone()),a.parents(".gridContainer").append(c)}a.data().dateRange&&($(".dateGo").click(function(){a.loadGrid({dateRangeFrom:$(this).parents(".gridContainer").find(".dateRangeFrom").val(),dateRangeTo:$(this).parents(".gridContainer").find(".dateRangeTo").val()})}),$(".dateRangeFrom").change(function(){$(this).parents(".gridContainer").find(".dateRangeFrom").val($(this).val())}),$(".dateRangeTo").change(function(){$(this).parents(".gridContainer").find(".dateRangeTo").val($(this).val())}))}return a.getPager()};
$.fn.getHeaderRow=function(){return $(this).parent().prev(".gridHeaderRow")};$.fn.getPager=function(){return $(this).parents(".gridContainer").find(".gridPager")};$.fn.makeResizable=function(){var a=$(this),c=a.parents(".gridContainer"),d=a.parents(".gridWrapper"),b=$("<div class='gridHandle'></div>");b.mousedown(function(b){var g=b.clientX,i=b.clientY;$(document).bind("mousemove.resize",function(b){c.width(c.width()+(b.clientX-g));d.height(d.height()+(b.clientY-i));d.css("max-height",d.css("max-height")+
(b.clientY-i));g=b.clientX;i=b.clientY;a.equalizeColumns()});$(document).mouseup(function(){$(document).unbind("mousemove.resize")})});a.parents(".gridContainer").append(b)};$.fn.attrJoin=function(a){return $(this).map(function(){return $(this).attr(a)}).get().join(",")}});
function formatMoney(a,c){var d=parseFloat(a);isNaN(d)&&(d=0);var b="";0>d&&(b="-");d=Math.abs(d);d=parseInt(100*(d+0.005));s=new String(d/100);0>s.indexOf(".")&&(s+=".00");s.indexOf(".")==s.length-2&&(s+="0");s=b+s;return c+addCommas(s)}
function addCommas(a){var c=a.split(".",2),a=c[1],c=parseInt(c[0]);if(isNaN(c))return"";var d="";0>c&&(d="-");for(var c=Math.abs(c),b=new String(c),c=[];3<b.length;){var e=b.substr(b.length-3);c.unshift(e);b=b.substr(0,b.length-3)}0<b.length&&c.unshift(b);b=c.join(",");a=1>a.length?b:b+"."+a;return d+a};



/* Very Simple Modal Plugin for JQUERY */


(function($){
	$.fn.modal = function (options) {
		var defaults =  {
			style: 'message',
			text: '',
			url: '',
			cancel: '',
			reportError: true,
			reportURL: '',
			height: '',
			width: '60%'
		};
		
		options = $.extend(defaults, options);
		var $object = $(this);
		
		$object.before('<div id="mask"><div>');
		var $placement = 'center';
		
	//Load Modal based on Style
		if (defaults.style === 'error') {
			$object.html('<div class="text">'+defaults.text+'<div>'); //Add Text tag to Modal
			defaults.width = '40%';
			modalError(); //Load Modal as an Error
		} else if (defaults.style === 'message') {
			$object.html(defaults.text); //Add Text tag to Modal
			$placement = 'top';
			modalMessage(); //Load Modal as an Message
		} else if (defaults.style === 'html') {
			$object.html('<div class="text">'+ defaults.text +'</div>'); //Add HTML wrapper for AJAX
			
			modalHTML(); //Load Modal as HTML
		}
		
		
		
	//Modal Errors
		function modalError() {
			//Add and remove Classes to call CSS
			$object.removeClass();
			$object.addClass('error');
			$object.addClass('modal');
			
			//If Default option to report Error is true print report error button
			//if (defaults.reportError == true) {
			$object.children('.text').after('<a class="reportError button">Report Error</a>');
			//}
			modal(); //Show Modal
		}
	
	
	//Modal Messages
		function modalMessage($text) {
			//Add and remove Classes to call CSS
			$object.removeClass();
			$object.addClass('message');
			$object.addClass('modal');
			
			modal(); //Load Modal
			
			$object.delay(3000).fadeOut(200, function () {
				clearModal();
			});
		}
		
		
	//Modal AJAX
		function modalHTML() {
			//Add and remove Classes to call CSS
			$object.removeClass();
			$object.addClass('html');
			$object.addClass('modal');
			
			
			//AJAX Load the URL
			$.ajax({
				type: 'POST',
				url: defaults.url,
				success: function (data) {
					$object.children('.text').html(data);
					modal();
				},
				//If failed load the Error Modal
				error: function(xhr, textStatus, errThrown) {
					$object.html('<ul class="errors"><li>Something went wrong with out System, please alert our admin with this id: AJ198473</li></ul>');
					modal();
				}
			});
		}
		
	//Function to load modal and display it.
		function modal () {
			//Center Placement
			if ($placement === 'center') {
				
				
				//Set the popup window to center
				$object.css('width', defaults.width);
				$object.css('height', defaults.height);
				
				_height = $(window).scrollTop();

				$('.mask').css({
					height: $(document).height(),
					width: $(document).width()
				});

				$('.dialog').css({
					top: (($(window).height()/2) - (defaults.height/2)) + _height,
					left: ($(window).width()/2) - (defaults.width/2)
				});
	
				
				//transition effect
				$('#mask').fadeIn(1000);
				$('#mask').fadeTo('slow', 0.6);
				
				
				$object.css({
					top: ($(window).height()/4),
					left: $(window).width()/2-$object.width()/2
				});
				
				$object.children('.text').before('<a class="close"></a>');
				
				_left = $object.offset().left;
				_objectW = $object.outerWidth() - 15;
				var _totalLeft = _objectW + _left;
				
				_top = $object.offset().top;
				_objectH = 35/2;
				var _totalTop = _top-_objectH;
				
				
				$object.children('a.close').css({
					left: _totalLeft,
					top: _totalTop
				});
			}
			
			//transition effect
			$object.fadeIn(1000);
			
		}
		
		//Click of the close button.  Clear modal and run callback function
		$('.modal .close').live('click', function () {
			clearModal();
			defaults.cancel.call(this);
		});
	
		//Click of the background.  Clear Modal and run callback function
		$('#mask').live('click', function() {
			clearModal();
			defaults.cancel.call();
		});
		
		//Clear the modal and remove all classes
		function clearModal() {
			//Send Ajax to clear modal
			$.ajax({
				url: '/ajax/admin/admin_functionality.php',
				type: 'POST',
				data: {'closeError': 1},
				success: function (data) {
					$object.hide();
					$object.html('');
					$object.removeClass();
					$('#mask').remove();
				},
				error: function(xhr, textStatus, errThrown) {
					$('.text').html('I was not able to close your error. Please report to system Admin.');
				}
			});
		}
		
		
	};
})(jQuery);

	
	


			

