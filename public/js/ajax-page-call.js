/**
 * Created by Daniel on 9/25/2016.
 */



$.pagehandler = $.pagehandler || {};
$.pagehandler.loadContent = function (url) {
   var pageUrl = url;
   // $('.ajax-loader').show();
   $.ajax({
      //url: pageUrl + '?type=ajax',
      url: pageUrl,
      success: function (data) {
         $('html').html(data);
         // hide ajax loader
         //   $('.ajax-loader').hide();
      }
   });
   if (pageUrl != window.location) {
      window.history.pushState({ path: pageUrl }, '', pageUrl);
   }
};


$.pagehandler.backForwardButtons = function () {
   $(window).on('popstate', function () {
      if(window.location.href.indexOf("#") == -1){
         $.ajax({
            url: location.pathname,
            success: function (data) {
               $('html').html(data);
            }
         });
      }
   });
};
$.pagehandler.backForwardButtons();