/*
  contact.js
*/

$(document).ready(function(){

    $('body').on('click','.item .image',function(){
        var target = $(this).attr('target');
        if(target !== undefined && target !== false) {
          window.open($(this).attr('href'),target);
        }else{
          window.location = $(this).attr('href');
        }

    });

});
