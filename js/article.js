/*
  article.js
*/

$(document).ready(function(){
    $('.title').justify();
    $('body').inputLabel();

    new Form();
    /*

    var commentButton = $('#comment_button');
    var container = $('#comment_form_container');
    var form      = $('#comment_form');
    var name      = $('#comment_form #name');
    var content   = $('#comment_form #content');

    commentButton.on('click',function(){
        $(this).hide();
        container.show();
    });

    $('#cancel').on('click',function(){
        container.hide();
        name.val(name.attr('value'));
        name.toggleClass('label',true);
        content.val(content.attr('value'));
        content.toggleClass('label',true);
        commentButton.show();
    });



    //function bindSubmit(){

    $('#submit').one('click',function(){
        if(content.hasClass('label') || content.val() === '') {
          $('.js.error').text('please type a comment');
          $('.js.error').show();
        }else{
          submitToServer();
        }
    });

    //}

    function submitToServer(){

      var nameVal;
      if(name.hasClass('label') || name.val() === '') {
        nameVal = 'nameless';
      }else{
        nameVal = name.val();
      }

      var contentVal = content.val();
      var articleId = $('#article_info').attr('article-id');

      var data = {
        comment_name:    nameVal,
        comment_content: contentVal,
        article_id:      articleId
      }
      console.log(data);
      $.post(HOME+'new/comment',data,function(response){

          console.log(response.success);

          if(response.success) {
            $('.comments.container .error').remove();
            $('.comments.container').prepend(response.comment);
            container.hide();
            name.val(name.attr('value'));
            name.toggleClass('label',true);
            content.val(content.attr('value'));
            content.toggleClass('label',true);
            commentButton.show();
          }else{
            $('.js.error').text('please try again');
            $('.js.error').show();
          }
      });
    }
    */


});

function Form(){
  var base = this;
  var commentButton  = $('#comment_button');
  var formContainer  = $('#comment_form_container');
  var commentForm    = $('#comment_form');
  var commentName    = $('#comment_form #name');
  var commentContent = $('#comment_form #content');
  var commentCheck;
  var error = $('.js.error');

  function construct(self){
    self.insertCheckBox();
    self.bindCommentButton();
  }


  this.insertCheckBox = function(){

    var botDiv = $('<div>').attr('id','bot');
    var checkbox = $('<input>').attr({'type':'checkbox','name':'check','id':'check'});
    var label = $('<label>').attr('for','check').text('I am human');

    commentContent.after(botDiv);
    botDiv.append(checkbox).append(label);
    commentCheck = $('#comment_form #check');
  }

  this.bindCommentButton = function(){
    commentButton.on('click',function(){
        commentButton.hide();
        base.bindSubmit();
        base.bindCancel();
        base.bindHideError();
        formContainer.show();
    });
  }
  this.bindSubmit = function(){
    $('#submit').one('click',function(){
        if(commentContent.hasClass('label') || commentContent.val() === '') {
          base.showError('please type a comment');
        }else if(!( commentCheck.is(':checked') )){
          base.showError('bot detected!');
        }else{
          base.submitToServer();
        }
        console.log(commentCheck);
    });
  }
  this.bindCancel = function(){
    $('#cancel').on('click',function(){
        base.removeForm();
    });
  }
  this.removeForm = function(){
        base.hideError();
        formContainer.hide();
        commentName.val(commentName.attr('value'));
        commentName.toggleClass('label',true);
        commentContent.val(commentContent.attr('value'));
        commentContent.toggleClass('label',true);
        commentButton.show();
  }

  this.bindHideError = function(){
    commentContent.on('keypress',function(){
        base.hideError();
    });
    commentCheck.on('change',function(){
        base.hideError();
    });
  }
  this.hideError = function(){
    if (error.is(':visible')) {
      error.hide();
    }
  }
  this.showError = function(message){
    if(error.text != message) {
      error.text(message);
    }
    if(error.is(':hidden')) {
      error.show();
    }
    base.bindSubmit();
  }

  this.submitToServer = function(){

    console.log('submitting');
      var nameVal;
      if(commentName.hasClass('label') || commentName.val() === '') {
        nameVal = 'nameless';
      }else{
        nameVal = commentName.val();
      }

      var contentVal = commentContent.val();
      var articleId = $('#article_info').attr('article-id');

      var data = {
        comment_name:    nameVal,
        comment_content: contentVal,
        article_id:      articleId
      }
      $.post(HOME+'new/comment',data,function(response){

          console.log(response.success);

          if(response.success) {
            formContainer.after(response.comment);
            base.removeForm();
          }else{
            base.showError('please try again');
          }
      });
    }


  construct(this);
}





