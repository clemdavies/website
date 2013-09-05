(function($){
    $.yourPluginName = function(element, radius, options){

        var base = this;

        // Access to jQuery and DOM versions of element
        var $element = $(element);
        var element = element;

        base.publicMethod = function(){
          //my public method
        }

        function init(){
            if( typeof( radius ) === 'undefined' || radius === null ) radius = '20px';

            base.radius = radius;

            base.options = $.extend(true,{},$.yourPluginName.defaultOptions, userOptions, $.yourPluginName.privateOptions);

            // Put your initialization code here
        };

        // Run initializer
        init();
        return base;
    };

    $.yourPluginName.defaultOptions = {
        radius: '20px'
    };

    $.yourPluginName.privateOptions = {
        color:'orange'
    };

    $.fn.yourPluginName = function(radius, options){
        var yourPluginName;
        this.each(function(){
            yourPluginName = (new $.yourPluginName(this, radius, options));
        });
        return yourPluginName;
    };

})(jQuery);
