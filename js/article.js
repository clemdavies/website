/*
  article.js
*/

$(document).ready(function(){
    $('.title').justify();
    $('body').inputLabel();

    new Form();


});

function Form(){
  var base = this;
  var header         = $('.comments.container #panel');
  var commentsCounter = $('.comments.container #counter');
  var commentButton  = $('#comment_button');
  var formContainer  = $('#comment_form_container');
  var commentForm    = $('#comment_form');
  var commentName    = $('#comment_form #name');
  var commentContent = $('#comment_form #content');
  var commentCheck;
  var error = $('.js.error');
  var charCount = $('#comment_form #count');

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
        header.hide();
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
        }else if(charCount.hasClass('invalid')){
          base.showError('please shorten comment');
        }else if(!( commentCheck.is(':checked') )){
          base.showError('bot detected!');
        }else{
          base.submitToServer();
        }
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
        header.show();
  }

  this.bindHideError = function(){
    commentContent.on('keypress',function(){
        base.hideError();
        //if(commentContent.val().length == 0) {
          //base.showCharCount();
        //}
    });
    commentContent.on('keyup',function(){
        //if(commentContent.val().length > 0) {

          base.showCharCount();
        //}
    });
    commentCheck.on('change',function(){
        base.hideError();
    });
  }
  this.hideCharCount = function(){
    charCount.text('');
  }
  this.showCharCount = function(){
    var text;
    var charsLeft = 140 - commentContent.val().length;
    if(charsLeft < 0) {
      // over char limit
        var charsOver = charsLeft * -1;
        charCount.toggleClass('valid',false);
        charCount.toggleClass('invalid',true);
        if(charsOver === 1) {
          text = String(charsOver) + ' char over';
        }else{
          text = String(charsOver) + ' chars over';
        }
    }else{
      //under char limit
        charCount.toggleClass('valid',true);
        charCount.toggleClass('invalid',false);
        if(charsLeft === 1) {
          text = String(charsLeft) + ' char left';
        }else{
          text = String(charsLeft) + ' chars left';
        }
    }
    charCount.text(text);
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
            base.resetCounter();
            base.removeForm();
          }else{
            base.showError('please try again');
          }
      });
    }
    this.resetCounter = function(){
      numberOfComments = $('.comment').length;
      var text = String(numberOfComments) + ' comment';
      if(numberOfComments != 1) {
        text += 's';
      }
      commentsCounter.text(text);
    }


  construct(this);
}





