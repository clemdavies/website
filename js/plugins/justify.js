(function($){
    $.justify = function(element){
        var base = this;

        // Access to jQuery and DOM versions of element
        var $element = $(element);
        var element = element;

        // my private variables
        var fontSize;

        base.hello = function(){
          console.log('hello');
        }

        /* private functions */
        function init(){
          if( extractFontSize() ){
            $(window).resize(function(){
                bindEvent();
            });
            bindEvent();
          }
        };

        function extractFontSize(){
          fontSize = $element.css('font-size');
          fontSize = fontSize.match(/\d+([.]?\d+)*/);
          if(fontSize !== null) {
            fontSize = fontSize[0];
          }
          if(typeof(fontSize) === 'string'){
            fontSize = parseFloat(fontSize);
          }
          if(fontSize != NaN && typeof(fontSize) === 'number') {
            return true;
          }else{
            //didnt capture usable font-size
            console.log('$.justify: didn\'t capture usable font-size from element.');
            console.log(fontSize);
            return false;
          }
        }

        function bindEvent(){

              if( $element.height() > fontSize * 2 && !$element.hasClass('justify-left')){
                //left justify
                $element.addClass('justify-left');
                $element.removeClass('justify-center');
                $element.css({'text-align':'left'});
              }

              if( $element.height() < fontSize * 2 && !$element.hasClass('justify-center')){
                //center justify
                $element.addClass('justify-center');
                $element.removeClass('justify-left');
                $element.css({'text-align':'center'});
              }

        }
        init();
        return base;
    };

    $.fn.justify = function(){
        var justify;
        this.each(function(){
            justify = ( new $.justify(this) );
        });
        return justify;
    };


})(jQuery);
