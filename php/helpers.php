<?php

function calculatePrice(){
	$startingDate = date_create($_POST['startingDate']);

	$endingDate = date_create($_POST['endingDate']);

	$difference = date_diff($startingDate,$endingDate);

	$days =  $difference->format('%a');

	$roomType = explode(" ", $_POST['room']);

	$finalPrice = $roomType[2] * $days;

	return $finalPrice;
}

function validate_name($value){
	if (empty($value)){
		return false;
	} else {			
		validate_input($value);

		return true;		
	}	
}	

function validate_email($value){
	if (empty($value) || !filter_var($input['email'], FILTER_VALIDATE_EMAIL)){
		return false;
	} else {
		validate_input($value);

		return true;
	}
}

		
function validate_people($value){
	if (empty($value) || !is_numeric($value)){		
		return false;
	} else if($input['room'] === 'Single-Bed - 30'){
		if($value != '1'){
			return false;
		}
	} else if($input['room'] === 'Double-bed - 50'){
		if($value != '2'){
			return false;
		}
	} else if($input['room'] === 'With Child - 60'){
		if($value != '2' || $value != '3' ){
			return false;
		}
	} else if($input['room'] === 'Double Room - 85'){
		if($value != '4'){
			return false;
		}
	} else {
		validate_input($value);

		return true;
	}
} 


function validate_pin($value){	
	if (empty($value) || !is_numeric($value) || strlen($value) == 9){
		return false;
	} else{
		validate_input($value);

		return true;
	}
}


function validate_input($data){
	$data = trim($data);

	$data = stripcslashes($data);

	$data = htmlspecialchars($data);

	return $data;
}

function validate($input,$array_rules){
	$error_array = [];
		
	foreach ($input as $name => $value) {
		$rule = $array_rules[$name];

		if($rule == 'required'){
			if(validate_name($value)){

			} else{
				$error_array[] = "Name is not valid!";
			}
		} else if($rule == 'email'){
			if(validate_name($value)){

			} else{
				$error_array[] = "email is not valid!";
			}
		} else if($rule == 'pin'){
			if(validate_pin($value)) {

			} else{
				$error_array[] = "PIN is not valid!";
			}
		} else if($rule == 'people'){
			if(validate_people($value)){

			} else{
				$error_array[] = "Number of people is not valid!";
			}
		}
	}

	if(count($error_array) == 0){
		return true;
	} else{
		return $error_array;
	}	
}




