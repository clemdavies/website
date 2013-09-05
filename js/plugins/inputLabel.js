(function($){
    $.inputLabel = function(element, options){

        var base = this;

        // Access to jQuery and DOM versions of element
        base.$element = $(element);
        base.element = element;

        // Add a reverse reference to the DOM object
        base.$element.data('inputLabel', base);

        base.init = function(){
            base.options = $.extend({},$.inputLabel.defaultOptions, options);

            $('.' + $.inputLabel.defaultOptions.className).each(function(){
                var type = $(this).attr('type');
                $(this).attr('input-label-type',type);
                $(this).attr('type','text');
            });

            var storedText;
            base.$element.on('focusin','input',function(){
                if($(this).hasClass(base.options.className)) {
                  storedText = $(this).val();
                  var type = $(this).attr('input-label-type');
                  $(this).attr('type',type);
                  $(this).val('');
                  $(this).removeClass(base.options.className);
                }
            });
            base.$element.on('focusout','input',function(){
                if( $(this).val() == '' && storedText ) {
                  $(this).addClass(base.options.className);
                  $(this).attr('type','text');
                  $(this).val(storedText);
                }
                storedText = undefined;
            });
            base.$element.on('focusin','textarea',function(){
                if($(this).hasClass(base.options.className)) {
                  storedText = $(this).val();
                  $(this).val('');
                  $(this).removeClass(base.options.className);
                }
            });
            base.$element.on('focusout','textarea',function(){
                if( $(this).val() === '' && storedText ) {
                  $(this).addClass(base.options.className);
                  $(this).val(storedText);
                }
                storedText = undefined;
            });
        };
        // Run initializer
        base.init();
    };

    $.inputLabel.defaultOptions = {
        className: 'label'
    };

    $.fn.inputLabel = function(options){
        return this.each(function(){
            (new $.inputLabel(this, options));
		   // HAVE YOUR PLUGIN DO STUFF HERE

        });
    };

})(jQuery);
