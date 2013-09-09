/*
  feed.js
*/
$(document).ready(function(){

  var feed = new Feed();

  var feedItems = new FeedItems();

  $(window).resize(function(){
      feedItems.windowResized();
  });
  feedItems.windowResized();
  new SpaceShip();
});

/* controls spaceship scroll to top icon */
function SpaceShip(){

  var anchorIcon;
  var initialUpPosition     = 0;
  var currentScrollPosition = 0;
  var lastScrollPosition    = 0;

  var lastTopArticle = $();

  function construct(self){
    anchorIcon = $('#top_anchor').clone();
    $('#top_anchor').detach();
    self.scrollEvent();
    self.clickEvent();
  }

  this.clickEvent = function(){
    $('#anchor_image').on('click',function(){

        //var position = lastTopArticle.prev().position().top;
        var position = $('#anchor_image').position().top - ( $(window).height() / 2 );

        console.log(position);

        $('#anchor_image').animate({top:position},300,function(){
            window.location.hash = 'top';
            $('#top_anchor').remove();
            initialUpPosition = 0;
        });

    });
  }

  this.scrollEvent = function(){
    var self = this;

    $(document).on('scroll',function(){
      self.findCurrentScrollPosition();


      if( self.headerIsHidden() && self.scrollingUp() && self.firstTimeScrollingUp() ) {
        //first time scrolling up
        initialUpPosition = currentScrollPosition;

      }else if( self.headerIsHidden() && self.scrollingUp() && self.scrolledFarEnough() ) {
        //scrolled far enough
        self.processIconPosition();

      }else if( self.headerIsHidden() ) {
        //scrolling down
        self.initialUpPosition = 0;
        $('#top_anchor').remove();
        $('#anchor_image').hide();

      }else{
        // header is visible
        $('#top_anchor').remove();
        $('#anchor_image').hide();

      }

      lastScrollPosition = currentScrollPosition;

    });

  }

  this.processIconPosition = function(){
    var topArticle = this.topVisibleArticle(currentScrollPosition);
    if(!( topArticle.hasClass('hasScrollIconAttached') )) {
      //continue
      lastTopArticle.removeClass('hasScrollIconAttached');
      topArticle.append(anchorIcon);
      anchorIcon.show();
      this.animateIconImage();
      topArticle.addClass('hasScrollIconAttached');
    }
    lastTopArticle = topArticle;
  }

  this.scrolledFarEnough = function(){
    return (initialUpPosition - 450 ) > currentScrollPosition;
  }

  this.firstTimeScrollingUp = function(){
    return initialUpPosition == 0;
  }

  this.findCurrentScrollPosition = function(){
    currentScrollPosition = $(document).scrollTop();
  }
  this.headerIsHidden = function(){
    return currentScrollPosition > ( $('.header').height() + 5 );
  }
  this.scrollingUp = function(){
    return lastScrollPosition > currentScrollPosition;
  }

  this.animateIconImage = function (){

    anchorImage = $('#anchor_image');
    var speed = 600;

    if(anchorImage.is(':hidden')) {
      anchorImage.css('top',$('.content.center.column').height());
      anchorImage.show();
      speed = 800;
    }

    anchorImage.css('left',$('#top_anchor').position().left - 58);

    var position = Math.ceil($('#top_anchor').position().top - 60);
    anchorImage.animate({top:position},speed);

  }
  this.topVisibleArticle = function(scrollTop){

    var returnElement = false;
    var previousElement;

     $('.article.container').each(function(index,element){
         // for each article container
         // determine top position until greater than scrolltop position

         var bottom = $(element).position().top + $(element).height() - 70;

         if( bottom > scrollTop) {
           if(!( returnElement )) {
             returnElement = $(element);
           }
         }
         previousElement = element;
     });
     if(!( returnElement )) {
       console.log('couldn\'t find article within window range');
     }
     return returnElement;

  }

  construct(this);
}







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
    $.getJSON('feed',data,function(response){
        self.insertArticles(response);

    });
  }

  this.insertArticles = function(data){

    $('.article.container').last().after(data.articles);
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
    this.setLastArticle($('.article.content').last());
  }
  this.setLastArticle = function(newLastArticle){
    lastArticle = newLastArticle;
  }
  this.getLastArticle = function(){
    return lastArticle;
  }
  construct(this);
}





