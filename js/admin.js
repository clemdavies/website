/*
  admin.js
*/
$(document).ready(function(){

    $('#edit_article').one('click',function(){
        var articleId = $('#article_info').attr('article-id');
        window.location = HOME+'admin/edit/article/'+articleId;
    });

    if($('.alert').length != 0) {
      var options = {align:'.container'};
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
    }

    if($('.admin_message').length != 0) {
      var element = $('.admin_message');
      var top = $('.header').height() + 5;
      element.animate({'top':top},1000,function(){
          window.setTimeout( function(){element.animate({'top':0},1000)},500);
      });
    }

    if($('.comment').length != 0) {
      //comments available
      $('.comment').on('mouseenter',function(){
          $(this).addClass('active');
          var button = $('<input>').attr({'id':'delete_comment','type':'button','value':'delete','class':'small delete'});
          $(this).children('.name').after(button);
          bindCommentDelete();
      });
      $('.comment').on('mouseleave',function(){
          $(this).removeClass('active');
      });

      function bindCommentDelete(){
        $('#delete_comment').one('click',function(){
            console.log(commentDeleted);

        });
      }

    }




});
