(function($){
    $.centerElement = function(element, userOptions){

        var base = this;

        // Access to jQuery and DOM versions of element
        var $element = $(element);
        var element = element;

        var alignmentElement;

        base.publicMethod = function(){
          //my public method
        }

        function init(){

            base.options = $.extend(true,{},$.centerElement.defaultOptions, userOptions, $.centerElement.privateOptions);

            alignmentElement = $(base.options.align);
            if(alignmentElement.length === 0) {
              //align with parent
              alignmentElement = $element.parent();
            }

            alignmentElement.css(base.options.alignCSS);
            $element.css(base.options.css);

            // horizontal: center || left || right
            switch(base.options.horizontal){
              case 'left':
               $element.css({'left':'0'});
                break;
              case 'right':
               $element.css({'right':'0'});
                break;
              case 'center':
              default:
                $element.css({ 'left': ( alignmentElement.width() - $element.width() ) / 2 });
            }


            // vertical: center || top || bottom
            switch(base.options.vertical){
              case 'top':
               $element.css({'top':'0'});
                break;
              case 'bottom':
               $element.css({'bottom':'0'});
                break;
              case 'center':
              default:
                $element.css({ 'top': ( alignmentElement.height() - $element.height() ) / 2 });
            }



        };

        // Run initializer
        init();
        return base;
    };

    $.centerElement.defaultOptions = {
      horizontal:'center',
      vertical:'center',
      alignCSS:
      {
        'position':'relative'
      }
    };

    $.centerElement.privateOptions = {
      css:
      {
        'position':'absolute'
      }

    };

    $.fn.centerElement = function(options){
        var centerElement;
        this.each(function(){
            centerElement = (new $.centerElement(this, options));
        });
        return centerElement;
    };

})(jQuery);
