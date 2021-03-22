$(document).ready(function(){

  var rules = { 
    fname: 'required',
    lname:'required',
    pin:'pin',
    email:'required',
    room:'required',
    startingDate:'required',
    endingDate:'required',
    people:'people'    
  };

  function validate_required(value){
    if (value === ''){
      return false;
    } 
}

  function validate_pin(value){  
  if (value === '' || isNaN(value) || value.length != 10){
    return false;
  }
}

function validate_people(value, roomType){
  if (empty(value) || isNaN(value)){
    return false;   
  } else if (roomType === 'Single-Bed - 30'){
    if(value != '1'){
      return false;
    }
  } else if (roomType === 'Double-bed - 50'){
    if(value != '2'){
      return false;
    }
  } else if (roomType === 'With Child - 60'){
    if (value != '2' && value != '3' ){
      return false;
    }
  } else if (roomType === 'Double Room - 85'){
    if (value != '4'){
      return false;
    }
  }
  
  return true;

}

  $('#booking_form').on('submit',function(e){
    e.preventDefault();

    
    var formData = $('#booking_form').serializeArray();

    var roomString = formData[4]['value'];

    var roomType = roomString.split(' ');

    for(field in formData){
      var rule = rules[formData[field]['name']];

      var value = formData[field]['value']; 

      var validationCallback = 'validate_' + rule; 

      console.log(validationCallback);   

      if(validationCallback === 'validate_required'){
        if (validationCallback(value) === false){
          $('input[name=' + formData[field]['name'] + ']').css('border','solid 1px red');

          $('#result_' + formData[field]['name']).html(formData[field]['name'] + " is not valid!").css('color','red');

          return false;
        } 
      } else if(validationCallback === 'validate_pin'){
          if(validationCallback(value) === false){
            $('input[name=' + formData[field]['name'] + ']').css('border','solid 1px red');

            $('#result_' + formData[field]['name']).html(formData[field]['name'] + " is not valid!").css('color','red');
            
            return false;
          }   
        } else if(validationCallback === 'people'){
          if(validationCallback(value,roomType[0])){
            $('input[name=' + formData[field]['name'] + ']').css('border','solid 1px red');

            $('#result_' + formData[field]['name']).html(formData[field]['name'] + " is not valid!").css('color','red');

            return false;
          }     
        }        
    }   



    $.ajax({
      url: 'php/booking.php',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response){
        if(response.status == 'success'){
          $('#book_form-content').css("display","none");

          $('#name_info').html(response.data['fname'] + " " + response.data['lname']);

          $('#pin_info').html(response.data['pin']);

          $('#email_info').html(response.data['email']);

          $('#room_info').html(response.data['room'] + " lv");

          $('#people_info').html(response.data['people']);

          $('#time_info').html(response.data['startingDate'] + " - " + [response
            .data['endingDate']]);

          $('#price_info').html(response.data['price'] + " lv");

          $('#responseHeader').html(response.message).css('color','green');

          $('#applicant_info').css('display','block');
        } else{
          $('#errorMessage').html(Object.values(response.errors)).css('color','red');
        }
      }
    });
  });

  function minDate(){
    var today = new Date();

    var dd = today.getDate();

    var mm = today.getMonth()+1; 

    var yyyy = today.getFullYear();

      if(dd<10){
          dd = '0' +dd
      }

      if(mm<10){
           mm = '0' +mm
      } 

    today = yyyy+'-'+mm+'-'+dd;

    return today;
  }

  function maxDate(){     
    var today = new Date();

    var dd = today.getDate();

    var mm = today.getMonth()+1; 

    var yyyy = today.getFullYear()+1;

      if (dd<10) {
        dd = '0' +dd
      }

      if (mm<10) {
        mm = '0' +mm
      } 

    today = yyyy+'-'+mm+'-'+dd;

    return today;
  }   

  document.getElementById('startingDate').setAttribute('min', minDate());

  document.getElementById('endingDate').setAttribute('max', maxDate());
});