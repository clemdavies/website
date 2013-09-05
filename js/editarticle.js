/*
  editarticle.js
*/

$(document).ready(function(){
    var editarticle = EditArticle();

});


function ScrollBar(passedElement){

  var element = passedElement;

  function construct(self){
    element.removeClass('inactive');
    element.addClass('active');
    element.mCustomScrollbar({
        horizontalScroll:true,
        scrollInertia:500,
        theme:'light'
    });

    self.initiate();
    $(window).resize(function(){
        window.setTimeout(function(){self.initiate();},200);
    });

  }

  this.initiate = function(){
    if( $('.mCSB_container').hasClass('mCS_no_scrollbar') ) {
      element.removeClass('inactive');
      element.addClass('active');
      element.mCustomScrollbar('update');
    }
    if( $('.mCSB_container').hasClass('mCS_no_scrollbar') ) {
      element.addClass('inactive');
      element.removeClass('active');
    }else{
      var contentWidth   = $('.mCSB_container').width();
      var containerWidth = element.width();
      var excessWidth = contentWidth - containerWidth;
      element.mCustomScrollbar('scrollTo',excessWidth/2);
    }
  }
  this.destroy = function(){
    element.mCustomScrollbar('destroy');
    element.addClass('inactive');
    element.removeClass('active');
  }

  construct(this);
}




function EditArticle(){

    //private variables
    var categorySelection = $('#category_selection');

    var title    = $('#title');
    var content  = $('#content');
    var submit   = $('#submit');
    var form     = $('#new_article');
    var scrollbarObject;

    //constructor
    function construct(self){
      self.selectCategoryEvent();
      self.submitEvent();
    }

    //public methods
    this.selectCategoryEvent = function(){

      $('.category_item').tooltip({
          track:true,
          show:{ duration:300 },
          hide:{ duration:400 }
      });

      $('.selecting .category_item').on('click',function(){

          if($(this).hasClass('upload')) {
            new Upload();
          }else{

            $(this).siblings().remove();
            var item = $(this);

            item.children('.text_border').hide();

            item.children('.border').hide();
            scrollbarObject.destroy();
            categorySelection.addClass('selected');
            categorySelection.removeClass('selecting');
            selectCategoryEvent();
            $( '.category_item' ).tooltip( 'close' );
          }

      });

      $('.selected .category_item').on('click',function(){
          // ajax to server
          $.getJSON(HOME+'admin/read/category',function(response){
              categorySelection.empty();
              categorySelection.append(response.category);
              categorySelection.addClass('selecting');
              categorySelection.removeClass('selected');
              selectCategoryEvent();
              scrollbarObject = new ScrollBar(categorySelection);
          });
      });

      $('.category_item').on('mouseenter',function(){
          $(this).children('.border').show();
      });
      $('.category_item').on('mouseleave',function(){
          $(this).children('.border').hide();
      });

    }
    this.submitEvent = function(){
      submit.on('click',function(event){
          event.preventDefault();
          processForm();
      });
    }
    this.processForm = function(){

      var errors = {};
      errors.num = 0;
      //check category
      if(!( categorySelection.hasClass('selected' )  )) {
        //fails
        errors.category = 'select a category';
        errors.num++;
      }
      //check title
      if(!( title.val().length > 0 && title.val() != 'title' )) {
        //fails
        errors.title = 'type a title';
        errors.num++;
      }
      //check content
      if(!( content.val().length > 0 && content.val() != 'content' )) {
        //fails
        errors.content = 'type some content';
        errors.num++;

      }
      errors.submit = 'failed, ' + errors.num + ' errors';

      if(errors.num > 0) {
        outputErrors(errors);
      }else{
        submitToServer();
      }
    }

    this.outputErrors = function(errors){


      var options = {};

      if(errors.category) {

          var categoryCount = $('.category_item').length;
          var categoryCenter = Math.floor(categoryCount / 2)
          var categoryItem = $($('.category_item')[categoryCenter]);

          categoryItem.attr('title','');
          options = categoryItem.tooltip( 'option' );
          categoryItem.tooltip('option','content',errors.category);

          categoryItem.tooltip( 'option', 'position', { my: 'center center', at: 'center+6 center' } );
          categoryItem.tooltip( 'option', 'tooltipClass', 'error-tooltip' );

          categoryItem.addClass('tool-error');

      }
      if(errors.title) {
        title.attr('title','');
        title.tooltip({
          track:true,
          show:{ duration:300 },
          hide:{ duration:400 },
          content:errors.title,
          position:{my:'center center', at:'center center'},
          tooltipClass: 'error-tooltip'
        });

      title.addClass('tool-error');
      }
      if(errors.content) {
        content.attr('title','');
        content.tooltip({
          track:true,
          show:{ duration:300 },
          hide:{ duration:400 },
          content:errors.content,
          position:{my:'center center', at:'center center'},
          tooltipClass: 'error-tooltip'
        });
      content.addClass('tool-error');

      }

      form.attr('title','');
      form.tooltip({
        show:{ duration:300 },
        hide:{ duration:400 },
        content:errors.submit,
        position:{my:'bottom-2', at:'bottom'},
        tooltipClass: 'error-tooltip'
      });
      form.addClass('tool-error');


      errorShow(options);
    }

    this.errorShow = function(options){

      var element = $('.tool-error');


      element.tooltip('open');

      window.setTimeout(function(){element.tooltip('close');},2000);
      window.setTimeout(function(){
          element.tooltip('destroy');
          element.tooltip(options);
      },3000);
    }

    this.submitToServer = function(){

      var data = {
                  'category_id': $('.category_item').attr('category_id'),
                  'title':$('#title').val(),
                  'content':$('#content').val().replace(/[\r?\n]+$/g,'').replace(/\r?\n/g, '<br />').replace(/<\/h3><br\s?[\/]?>/g,'</h3>'),
                  'article_id':$('#new_article').attr('article-id')
                 }

        $.post(HOME+'admin/update/article',data,function(response){

            if(response.success) {
              //success
              window.location = HOME+'article/'+response.articleTitle;

            }else{
              //fail
              form.attr('title','');
              form.tooltip({
                show:{ duration:300 },
                hide:{ duration:400 },
                content:'failed to save to server',
                position:{my:'bottom-2', at:'bottom'},
                tooltipClass: 'error-tooltip'
              });
              form.addClass('tool-error');
              errorShow({});
            }


        });
    }



    //calls constructor once on object instantiation
    construct(this);
}
