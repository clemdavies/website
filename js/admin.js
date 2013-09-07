/*
  admin.js
*/
$(document).ready(function(){

    $('#edit_article').one('click',function(){
        var articleId = $('#article_info').attr('article-id');
        window.location = HOME+'admin/edit/article/'+articleId;
    });

    if($('.admin_message').length != 0) {
      var element = $('.admin_message');
      var top = $('.header').height() + 5;
      element.animate({'top':top},1000,function(){
          window.setTimeout( function(){element.animate({'top':0},1000)},500);
      });
    }

});
