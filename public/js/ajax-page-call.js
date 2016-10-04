/**
 * Created by Daniel on 9/25/2016.
 */

$.pagehandler = $.pagehandler || {};
$.pagehandler.loadContent = function (url) {
    var pageUrl = url;
   // $("#body").load(pageUrl);

   // $('.ajax-loader').show();
   $.ajax({
      //url: pageUrl + '?type=ajax',
      url: pageUrl,
      success: function (data){
          $("#all").html($(data).filter("#all").html());
         //$('#body').html();
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
               $('#all').html($(data).filter("#all").html());
            }
         });
      }
   });
};

$.pagehandler.backForwardButtons();

