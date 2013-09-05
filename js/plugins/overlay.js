(function($){
    $.overlay = function(element,userOptions){

        base = this;
        // Access to jQuery and DOM versions of element
        var $element = $(element);
        var element = element;

        var options;

        var container;
        var overlayElement;

        var resize = function(){};

        base.showOverlay = function(){
          // hides element then hides overlay
          overlayElement.show();

          var offset = function(){
              return ( $(window).height() - container.height() ) / 2
          };

          container.animate({top:offset()},400);

          resize = function(){
            container.css({top:offset()});
          }

          $(window).resize(function(){
              resize();
          });
        }

        base.closeOverlay = function(callback){

          var height = container.height() * -1.5;

          container.animate({top:height},options.speed,function(){
              overlayElement.hide();
              resize = function(){};
              if(typeof(callback) == 'function') {
                callback();
              }
          });

        }

        base.destroy = function(){
          base.closeOverlay();
          delete base.showOverlay;
          delete base.closeOverlay;
          console.log(typeof(base.showOverlay));
        }

        function init(){

          // merge options recursively, maintaining integrity of private options
          options = $.extend(true,{},$.overlay.defaultOptions, userOptions, $.overlay.privateOptions);

          $element.before($('<div>').addClass(options.classname.overlay).css(options.css.overlay));
          $element.wrap($('<div>').addClass(options.classname.container).css(options.css.container));

          container      = $('.'+options.classname.container);
          overlayElement = $('.'+options.classname.overlay);

          $(window).resize(function(){
              container.css({
                'left' : $(options.align).position().left,
                'width': $(options.align).width() / $(document).width() * 100 + '%',
                'top'  : container.height() * -1.5
              });
          });
          $(window).trigger('resize');
        };

        // Run initializer
        init();
        return base;
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

    $.overlay.defaultOptions = {
      css:
      {
        overlay:
        {
          'opacity':'0.8',
          'background-color': 'black'
        }
      },
      align:'body',
      speed:500
    };

    $.fn.overlay = function(options){
        this.each(function(){
            overlay = (new $.overlay(this,options));
        });
        return overlay;
    };

})(jQuery);
