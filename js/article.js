/*
  article.js
*/

$(document).ready(function(){
    $('.title').justify();
    $('body').inputLabel();

    $('#comment_button').on('click',function(){
        $(this).hide();
        $('#comment_form').show();
    });
    $('#comment_form .submit').on('click',function(){
        $('#comment_form').hide();
        $('#comment_button').show();
    });

});
