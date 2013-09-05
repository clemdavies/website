(function($){
    $.handleForm = function(element, options){

        var base = this;

        // Access to jQuery and DOM versions of element
        var $element = $(element);
        var element = element;

        base.publicMethod = function(){
          //my public method
        }

        function init(){

            base.options = $.extend(true,{},$.handleForm.defaultOptions, userOptions, $.handleForm.privateOptions);




        };

        // Run initializer
        init();
        return base;
    };

    $.handleForm.defaultOptions = {
        radius: '20px'
    };

    $.handleForm.privateOptions = {
        color:'orange'
    };

    $.fn.handleForm = function( options ){
        var handleForm;
        this.each(function(){
            handleForm = (new $.handleForm(this, options));
        });
        return handleForm;
    };

})(jQuery);
