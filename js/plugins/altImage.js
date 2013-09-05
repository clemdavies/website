(function($){
    $.altImage = function(element, selector,tag){

        var base = this;

        // Access to jQuery and DOM versions of element
        base.$element = $(element);
        base.element = element;

        // Add a reverse reference to the DOM object
        base.$element.data('altImage', base);

        base.init = function(){

            if( typeof( tag ) === 'undefined' || tag === null ) tag = $.altImage.defaultOptions.tag;
            base.tag = tag;

            base.$element.on('mouseenter',selector,function(){
                base.swapImage(this);
            });
            base.$element.on('mouseleave',selector,function(){
                base.swapImage(this);
            });
        };
        base.swapImage = function(self){

          var alternate = $(self).attr(base.tag);
          var src = $(self).attr('src');
          $(self).attr('src',alternate);
          $(self).attr(base.tag,src);
        }
        base.init();
    };

    $.altImage.defaultOptions = {
        tag: 'alternate'
    };
    $.fn.altImage = function(selector,tag){
        return this.each(function(){
            (new $.altImage(this, selector,tag));
        });
    };

})(jQuery);

