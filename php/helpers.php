<?php

function calculatePrice($from, $to, $roomType){
	$startingDate = date_create($from);

	$endingDate = date_create($to);

	$difference = date_diff($startingDate,$endingDate);

	$days =  $difference->format('%a');

	$roomType = explode(" ", $roomType);

	$finalPrice = $roomType[2] * $days;

	return $finalPrice;
}

function validate_required($value){
	if (empty($value)){
		return false;
	} else {			
		$result = validate_input($value);

		return $result;		
	}	
}	

function validate_email($value){
	if (empty($value) || filter_var($input['email'], FILTER_VALIDATE_EMAIL)){
		return false;
	} else {
		$result = validate_input($value);

		return $result;
	}
}

		
function validate_people($value, $roomType){
	if (empty($value) || !is_numeric($value)){
		return false;		
	} else if ($roomType === 'Single-Bed - 30'){
		if($value != '1'){
			return false;
		}
	} else if ($roomType === 'Double-bed - 50'){
		if($value != '2'){
			return false;
		}
	} else if ($roomType === 'With Child - 60'){
		if ($value != '2' && $value != '3' ){
			return false;
		}
	} else if ($roomType === 'Double Room - 85'){
		if ($value != '4'){
			return false;
		}
	}
	
	return true;

} 

function validate_pin($value){	
	if (empty($value) || !is_numeric($value) || strlen($value) == 9){
		return false;
	} else{
		$result = validate_input($value);

		return $result;
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

		$validationCallback = 'validate_' . $rule;
		
		if($validationCallback === 'validate_people'){
			$roomType = $input['room'];

			if($validationCallback($value,$roomType) === false){
				$error_array[] = $name . ' is not valid!';
			}			
		} else {
			if($validationCallback($value) === false){
				$error_array[] = $name . ' is not valid!';
			}
		}
	}

	if(count($error_array) == 0){
		return true;
	} else{
		return $error_array;
	}	
}




