/*login.js*/


    $(document).ready(function(){
        attachEventHandlers();
        $('body').inputLabel();
    });

    function login(){


        var data = { 'name' : $("#name").val(),
                     'pass' : Sha256.hash($("#pass").val())
                   };
        $.get(HOME+"admin/login",data,function(response){

            console.log(response);

            if(response.success){
              //valid
              var location = $('.redirect').attr('location');

              if(!(location)){
                location = window.location;
              }

              window.location = location;
            }else{
              //invalid
              insertErrorMessage('please try again');
              $('#pass').attr('type','text');
              $('#pass').val('password');
              $('#pass').addClass('label');
            }
        });
    }
    function attachEventHandlers(){
        $('.submit').on('click',function(event){
            if($('#login input').hasClass('label')) {
              insertErrorMessage('complete form before submitting');
            }else{
              event.preventDefault();
              login();
            }
        });
    }

    function insertErrorMessage(msg){

      if($('.flash.error, .flash.success')) {
        $('.flash.error, .flash.success').remove();
      }
      $('.js.error').text(msg);
      $('.js.error').show();

    }

