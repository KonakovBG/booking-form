$(document).ready(function(){

  // $( function() {
  //   $( "#startingDate" ).datepicker();
  // } );

  $('#booking_form').on('submit',function(e){
    e.preventDefault();

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