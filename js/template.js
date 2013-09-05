$(document).ready(function(){

  $('body').altImage('.icon .image');

  $('body').on('click','.icon .image',function(){
      var href = $(this).attr('href');
      if( href !== undefined && href !== false ) {
        window.location = $(this).attr('href');
      }
  });
});

