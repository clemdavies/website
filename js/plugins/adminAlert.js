(function($){
    $.adminAlert = function(element, options){
        // element contains alert element
        var base = this;

        // Access to jQuery and DOM versions of element
        var $element = $(element);
        var element = element;

        base.publicMethod = function(){
          //my public method
        }

        function init(){
            base.options = $.extend(true,{},$.adminAlert.defaultOptions, userOptions, $.adminAlert.privateOptions);



        };

        // Run initializer
        init();
        return base;
    };

    $.adminAlert.defaultOptions = {

      css:
      {
        alert:
        {
          'background-color':'#161616',
          'border':'1px solid #FFBE59',
          'color':'#FFFFFF',
          'height':'100%',
          'padding-bottom':'30px',
          'text-align':'center'
        },
        overlay:
        {
          'opacity':'0.8',
          'background-color': 'black'
        }
      }
      align:'body'
      speed:500
    };


    $.overlay.privateOptions = {
      css:
      {
        container:
        {
          'position':'fixed',
          'z-index':'9999'
        },
        overlay:
        {
          'position': 'fixed',
          'top': '0',
          'left': '0',
          'width': '100%',
          'height': '100%',
          'z-index': '999',
          'display':'none'
        }
      },
      classname:
      {
        container:'overlay-container',
        overlay:'overlay-element'
      }
    };

    $.fn.adminAlert = function(radius, options){
        var adminAlert;
        this.each(function(){
            adminAlert = (new $.adminAlert(this, radius, options));
        });
        return adminAlert;
    };

})(jQuery);
