
(function ($) {

  "use strict";

  $(document).ready( function(){

    // --- Event onChange select in portfolios
    var choice = $('#portfolio_layout').val();
    function display (choice){
      switch(choice) {
          case "video":
              $('#portfolio_video_link').parent().parent().show();
              $('.rwmb-file_advanced-wrapper').hide();
            break;
          case "default":
            $('#portfolio_video_link').parent().parent().hide();
            $('.rwmb-file_advanced-wrapper').hide();
            break;
          case "gallery":
          case "slideshow":
          default:
            $('#portfolio_video_link').parent().parent().hide();
            $('.rwmb-file_advanced-wrapper').show();
            break;
      } 
    }
    display (choice);

    //--------------
    $('#portfolio_layout').on('change', function(){ 
      var selected = this.value;
      display (selected);
    });

  });
})(jQuery);