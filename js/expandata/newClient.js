/*
  newClient.js
*/

$(document).ready(function(){


    var inputNames = ['unit_number','street_number','street_name','city','postcode','suburb','state'];
    var i = 0;
    $('#populate').on('click',function(){
        animate();
    });

    function animate(){
      if(!( inputNames[i] )){
        i = 0;
      }
      var inputName = inputNames[i];
      var streetInput = $('#street_'+inputName);
      var postalInput = $('#postal_'+inputName);
      var height = streetInput.css('height');
      streetInput.add(postalInput).animate({
          height:0
      },50,function(){
        postalInput.val(streetInput.val());
        $(this).animate({height:height},50);
      });
      i++;
      if(inputNames[i]) {
        window.setTimeout(function(){animate()},100);
      }
    }

    $('#submit').one('click',submitClient);


    // change to one
    $('#create_type').one('click',submitType);
    $('#create_attribute').one('click',submitAttribute);

});

function submitAttribute(event){

  event.preventDefault();

  var form = $('#new_attribute');

  var name = $('#new_attribute_name');

  var typeSelection = $('#new_attribute_type_selection input');
  var boolType   = $('#bool_attribute');
  var stringType = $('#string_attribute');


  var errors = new Array();


  if(!( name.val().trim() )) {
    errors.push( {element:name,message:'type a name'} );
  }

  if(!( boolType.is(':checked') ) && !( stringType.is(':checked') )) {
    errors.push( {element:typeSelection,message:'select a data type'} );
  }

  if(errors.length) {
    outputErrors(errors,form);
    $(this).one('click',submitAttribute);
  }else{
    data = {'new_attribute_name':name.val(),
            'new_attribute_type':typeSelection.filter(':checked').val()};

    $.post(EXPHOME+'new/attribute/ajax',data,function(response){
      errors = new Array();

      console.log(response);
      if(response.success) {
        name.val('');
        typeSelection.prop('checked',false);
        $('#current_attribute').children('.alert').remove();
        $('#current_'+response.dataType).append(response.html);
        errors.push({element:$('#current_attribute, #new_attribute'),message:'new attribute added'});
      } else {
        errors.push({element:name,message:'server didn\'t update'},{element:name,message:'please try again'});
      }
      outputErrors(errors,form);
    });
    $(this).one('click',submitAttribute);

    console.log('submit attribute to server, then update DOM');
    //submitToServer();
  }

}


function submitType(event){

  event.preventDefault();

  var form = $('#new_type');

  var name = $('#new_type_name');

  var errors = new Array();
  if(!( name.val().trim() )) {
    errors.push({element:name,message:'type a name'});
  }

  if(errors.length) {
    outputErrors(errors,form);
    $(this).one('click',submitType);
  }else{

    data = {'new_type_name':name.val()};

    $.post(EXPHOME+'new/type/ajax',data,function(response){
      errors = new Array();
      if(response.success) {
        name.val('');
        $('#current_type').children('.alert').remove();
        $('#current_type').append(response.html);
        errors.push({element:$('#current_type, #new_type'),message:'new type added'});
      } else {
        errors.push({element:name,message:'server didn\'t update'},{element:name,message:'please try again'});
      }
      outputErrors(errors,form);
    });

    $(this).one('click',submitType);
  }



}


function submitClient(event){

    event.preventDefault();
    //validate form

    valid = true;

    var bool_attributes   = $('#current_bool_attribute .attribute');
    var string_attributes = $('#current_string_attribute .attribute');

    // if attributes are checked, are their radio buttons activated?
    var errors = new Array();
    var errorCount = 0;
    bool_attributes.each(function(i,e){
        // boolean test for radio is checked

      if( $(this).children().first().is(':checked') ) {
        if(!( $(this).children(':radio').is(':checked') )){
          //radio not checked :. output error
          element = $(e);
          errorCount++;
          errors = new Array();
          errors.push({element:element,message:'select a data type'});
          outputErrors(errors,element);
        }
      }

    });
    string_attributes.each(function(i,e){
      if( $(this).children().first().is(':checked') ) {
        if( $(this).children(':text').val().trim() === '' ){
          //text input not filled :. output error
          element = $(e);
          errorCount++;
          errors = new Array();
          errors.push({element:element,message:'type a name'});
          outputErrors(errors,element);
        }
      }
    });



    if(errorCount) {
      console.log('invalid');
      $(this).one('click',submitClient);
    }else{
      $(this).off('click',submitClient);
      $(this).trigger('click');
      console.log('valid');
    }

}

function outputErrors(errors,form){

  form.children('.form_error').remove();

  var div = $('<div>').addClass('form_error').hide();
  form.addClass('form_error_container');
  form.append(div);

  errorTextDivs = new Array();

  $.each(errors,function(i,object){
      var uniqueId = form.attr('id')+'_error_'+i;
      var errorText = $('<div>').attr('id',uniqueId).text('- '+object.message).hide();
      div.append(errorText);
      object.element.on('input change',function(){
          var errorContainer = $('#'+uniqueId).parent();
          $('#'+uniqueId).hide(200,function(){
            $('#'+uniqueId).remove();
            if(!( errorContainer.children().length )){
              errorContainer.animate({left:'200px'},400,function(){
                  errorContainer.remove();
              });
            }
          });
      });


      errorTextDivs.push(errorText);
  });


  div.show();

  var i = 0;
  div.animate({left:'-180px'},700,function(){
      animateCollapseOpen();
  });

  function animateCollapseOpen(){
    errorTextDivs[i].show(300);
    i++;
    if(errorTextDivs[i]) {
      window.setTimeout(function(){animateCollapseOpen(errorTextDivs[i])},100);
    }
  }
}

