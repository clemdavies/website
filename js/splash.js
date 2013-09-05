
/*
  splash.js
*/
$(document).ready(function(){

    $('.name').on('click',function(){
        window.location = 'home';
    });


    setFontSize();
    setVerticalCenter();
    $(window).on('resize',function(){
        setFontSize();
        setVerticalCenter();
    });


      $('.name').hide();
      $('.block').hide();
    window.setTimeout(function(){
      $('.overlay').hide();
      $('.name').show();
      $('.block').show();
      $('.block').animate({color:'black'},1000);
    },100);

});

function setFontSize(){
    var screenWidth = $(window).width();
    var margin = screenWidth * 0.05;
    var fontSize = (screenWidth - (margin * 2)) * 6560 / 41041;
    fontSize = Math.ceil(fontSize);

    $('.name').css('font-size',fontSize + 'px');
}

function setVerticalCenter(){

  var screenHeight = $(window).height();
  var textHeight = $('.name').height();

  var paddingTop = Math.ceil( (screenHeight - textHeight) / 2 );

  $('.name').css('padding-top',paddingTop + 'px');
}
