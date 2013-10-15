/*
  newHome.js
*/
$(document).ready(function(){


  var feed = new Feed();

  var feedItems = new FeedItems();

  $(window).resize(function(){
      feedItems.windowResized();
  });
  feedItems.windowResized();



    $('#skills_container').delegate('.box.inactive','click',function(){

        var left = $(this).position().left + 'px';
        var top = $(this).position().top + 'px';

        $(this).attr('left',left);
        $(this).attr('top',top);

        $(this).css({'position':'absolute','left':left,'top':top});

        var height = $('#skills_container').height() - 2;
        var width = $('#skills_container').width() - 2;
        var css = {left:0,top:0,'height':height,'width':width};
        $(this).animate(css,500);
        $(this).children('.heading').animate({'line-height':'50px','font-size':'20px'},function(){

            $(this).siblings('.content').fadeIn(50);

        });
        $('.box').not(this).hide();
        $(this).addClass('active');
        $(this).removeClass('inactive');
    });

    $('#skills_container').delegate('.box.active','click',function(){

        var left = $(this).attr('left');
        var top = $(this).attr('top');

        var css = {'height':'150px','width':'150px','left':left,'top':top,'font-size':'20px'};
        var box = $(this);

        $(this).children('.content').fadeOut(100,function(){
          box.animate(css,500,function(){
              $('.box').not(this).fadeIn(200);
          });
          box.children('.heading').animate({'line-height':'150px'});
          box.removeClass('active');
          box.addClass('inactive');
        });

    });

    $('#skills_container').delegate('.box.inactive','mouseenter',function(){
        $(this).children('.heading').animate({'font-size':'30px'});
    });
    $('#skills_container').delegate('.box.inactive','mouseleave',function(){
        $(this).children('.heading').animate({'font-size':'20px'});
    });


    $(document).on('scroll',function(){
        var pos = $(document).scrollTop();
        var head = $('#header');
        var headText = $('#header_links, #banner');
        if(pos >= 50 && (!head.hasClass('opaque')) ) {
        //then make opaque
          headText.hide();
          head.fadeTo(100,0.5);
          head.toggleClass('opaque',true);

          head.animate({'height':'20px'});
        }else if(pos < 50 && head.hasClass('opaque')){
        //then make visible
          head.fadeTo(100,1);
          head.toggleClass('opaque',false);

          head.animate({'height':'50px'},function(){
            headText.show();
          });
        }
    });



});



function FeedItems(){

  this.windowResized = function(){

    $('.article .title').each(function(index,Element){

        if( $(this).height() != $(this).children('.spacer').height() ){
          $(this).children('.spacer').height($(this).height());
        }

        if( $(this).height() > 30 && !$(this).hasClass('left')){
          $(this).addClass('left');
          $(this).removeClass('center');
        }

        if( $(this).height() < 30 && !$(this).hasClass('center')){
          $(this).addClass('center');
          $(this).removeClass('left');
        }

    });
  }
}



function Feed(){

  var loadIcon = $('#load');

  var lastArticle;

  function construct(self){
    self.findLastArticle();
    self.bindClickScrollImageEvent();
    self.bindHoverArticleEvent();
  }

  this.bindClickScrollImageEvent = function(){
    var self = this;
    loadIcon.on('click',function(){
      self.loadMoreArticles();
    });
  }

  this.bindHoverArticleEvent = function(){
    $('.content').on('mouseenter','.category.image.border, .article .border',function(){
        $(this).addClass('highlight');
        $(this).siblings('.border').addClass('highlight');
    });
    $('.content').on('mouseleave','.category.image.border, .article .border',function(){
        $(this).removeClass('highlight');
        $(this).siblings('.border').removeClass('highlight');
    });

  }




  /* handles the onclick event for the load icon */
  this.loadMoreArticles = function(){
    var self = this;
    var data = this.retrieveLastArticleData();
    $.getJSON(HOME+'feed',data,function(response){
        self.insertArticles(response);
        console.log(response);

    });
  }

  this.insertArticles = function(data){
    $('.feed_article_link').last().after(data.articles);
    this.findLastArticle();
    if(!(data.more)){
      loadIcon.detach();
    }
  }

  this.retrieveLastArticleData = function(){
    var data  = {};
    data.date = lastArticle.attr('datetime');
    data.id   = lastArticle.attr('article_id');

    return data;
  }


  this.findLastArticle = function(){
    this.setLastArticle($('.feed_article_content').last());
  }
  this.setLastArticle = function(newLastArticle){
    lastArticle = newLastArticle;
  }
  this.getLastArticle = function(){
    return lastArticle;
  }
  construct(this);
}
