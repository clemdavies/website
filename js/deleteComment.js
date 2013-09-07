/*
  deleteComment.js
*/

$(document).ready(function(){

    var controls = $('<div>').attr({'id':'comment_controls'});

    var deleteButton = $('<input>').attr({'id':'delete_comment','type':'button','value':'delete','class':'small delete'});
    var seenButton   = $('<input>').attr({'id':'seen_comment','type':'button','value':'seen','class':'small'});

    var options = {align:'.content.center.column',text:{content:'Delete this comment?'}};
    var alert = $('.alert').overlay(options);

    //comments available
    $('.comment').on('mouseenter',function(){
        $(this).addClass('active');
        options = { 'horizontal':'center','vertical':'top',css:{'margin-top':'3px'}};
        $(this).children('.name').after(controls);
        controls.append(deleteButton);
        if($(this).attr('seen') == 0) {
          controls.append(seenButton);
          bindCommentSeen();
        }
        controls.centerElement(options);
        bindCommentDelete();
    });
    $('.comment').on('mouseleave',function(){
        $(this).removeClass('active');
        $(this).animate({'font-size':'100%'});
        deleteButton.remove();
        seenButton.remove();
    });

    function bindCommentSeen(){

      $('#seen_comment').one('click',function(){
        var data = commentData($(this));
          $.get(HOME+'seen/comment',data.send,function(response){
              if(response.success) {
                console.log('comment marked as seen');
                data.comment.attr('seen','1');
                seenButton.remove();
              }else{
                console.log('comment unchanged');
              }

          });
      });
    }

    function bindCommentDelete(){
      $('#delete_comment').one('click',function(){
        var data = commentData($(this));
        alert.showOverlay();
        $('#no').one('click',function(){
          alert.closeOverlay();
        });

        $('#yes').one('click',function(){

          $.get(HOME+'delete/comment',data.send,function(response){
              if(response.success) {
                alert.closeOverlay(function(){
                  data.comment.animate({'height':'0','padding':'0','margin':'0'},function(){
                      data.comment.remove();
                  });
                });

              }else{
                console.log('comment failed to delete');
              }

          });
        });
      });
    }

    function commentData(element){
      var comment = element.parent().parent('.comment');
      var id = comment.attr('comment-id');
      var data = {send:{comment_id:id},comment:comment};
      return data;
    }

});
