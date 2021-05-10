$(document).ready(function(){

  const rules = { 
    fname: 'required',
    lname:'required',
    pin:'pin',
    email:'required',
    room:'required',
    startingDate:'required',
    endingDate:'required',
    people:'people'    
  };

  const errorMessages = {
  'required': 'The field is required!',
  'people': 'Invalid number of people!',
  'pin': 'Invalid Phone number!'
};

  const validator = {
    validate_required: function validate_required(value){
      if (value === ''){
        return false;
      }
      return true; 
  },
  validate_pin: function validate_pin(value){  
    if (value === '' || isNaN(value) || value.length != 10){
      return false;
    }
    return true;
  },
  validate_people: function validate_people(value, roomType){
    if (value === '' || isNaN(value)){
      return false;   
    } else if (roomType === 'Single-Bed'){
      if(value != '1'){
        return false; 
      }
    } else if (roomType === 'Double-Bed'){
      if(value != '2'){
        return false; 
      }
    } else if (roomType === 'With Child'){
      if (value != '2' && value != '3' ){
        return false; 
      }
    } else if (roomType === 'Double Room'){
      if (value != '4'){
        return false; 
      }
    } return true;   
  }
};

  $('#booking_form').on('submit',function(e){
    e.preventDefault();

    var formData = $('#booking_form').serializeArray();

    var roomString = formData[4]['value'];

    var roomType = roomString.split(' ');

    for(field in formData){
      var rule = rules[formData[field]['name']];

      var value = formData[field]['value']; 

      var validationCallback = 'validate_' + rule; 

      const result = validator[validationCallback](value);
      
      if(validationCallback === 'validate_people'){
        const result = validator[validationCallback](value,roomType[0]);               
      }

      if(result === false){
        $('#result_' + formData[field]['name']).html(errorMessages[rule]).css('color','red'); 

        return false;
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