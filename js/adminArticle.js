/*
  adminArticle.js
*/



$(document).ready(function(){

    var options = {align:'.container',text:{content:'Delete this article?'}};
    var alert = $('.alert').overlay(options);
    $('#delete_article').on('click',function(){
        alert.showOverlay();
        $('#no').one('click',function(){
          alert.closeOverlay();
        });
        $('#yes').one('click',function(){

            data = {'article_id':$('#article_info').attr('article-id')}

            $.post(HOME+'admin/delete/article',data,function(response){

                if(response.success) {
                  alert.closeOverlay(function(){
                      window.location = HOME;
                  });
                }else{
                  console.log('failed to delete article');
                }
            });
        });

    });

});
