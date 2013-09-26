/*
  newHome.js
*/
$(document).ready(function(){



    $('#skills_container').delegate('.box.inactive','click',function(){
        console.log('inactive click');

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

            console.log($(this));
            $(this).siblings('.content').fadeIn(50);

        });
        $('.box').not(this).hide();
        $(this).addClass('active');
        $(this).removeClass('inactive');
    });

    $('#skills_container').delegate('.box.active','click',function(){
        console.log('active click');

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

        if(pos >= 50 && (!head.hasClass('opaque')) ) {
        //then make opaque
          console.log('pos >= 50 !hasClass(opaque)');
          head.fadeTo(100,0.5);
          head.toggleClass('opaque',true);

          head.animate({'height':'20px'});
        }else if(pos < 50 && head.hasClass('opaque')){
        //then make visible
          console.log('pos < 50 hasClass(opaque)');
          head.fadeTo(100,1);
          head.toggleClass('opaque',false);

          head.animate({'height':'50px'});
        }


    });


});
