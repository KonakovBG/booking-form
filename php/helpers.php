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

function validate_input($data){
	$data = trim($data);

	$data = stripcslashes($data);

	$data = htmlspecialchars($data);

	return $data;
}

function validate($input,$array_rules) {
	foreach ($input as $name => $value) {
		$rule = $array_rules[$name];

		if($rule == 'required'){
			if (empty($value)){
				$responseArray['status'] = 'error';

				$responseArray['errors'][$name] = "Name is not valid! ";

				return false;
		} else {			
				validate_input($value);
			}
		} else if ($rule == 'email'){
			if (empty($value) || !filter_var($input['email'], FILTER_VALIDATE_EMAIL)){
				$responseArray['status'] = 'error';

				$responseArray['errors'][$name] = "Email is not valid! ";

				return false;
			} else {
				validate_input($value);
			}
		} else if($rule == 'people'){
			if (empty($value) || !is_numeric($value)){
				$responseArray['status'] = 'error';

				$responseArray['errors'][$name] = " Number of people is not valid! ";

				return false;			
			} else if($input['room'] === 'Single-Bed - 30'){
				if($value != '1'){
					$responseArray['status'] = 'error';

					$responseArray['errors'][$name] = "Number of people is not valid! ";

					return false;
				}
			} else if($input['room'] === 'Double-bed - 50'){
				if($value != '2'){
					$responseArray['status'] = 'error';

					$responseArray['errors'][$name] = "Number of people is not valid! ";

					return false;
				}
			} else if($input['room'] === 'With Child - 60'){
				if($value != '2' || $value != '3' ){
					$responseArray['status'] = 'error';

					$responseArray['errors'][$name] = "Number of people is not valid! ";

					return false;
				}
			} else if($input['room'] === 'Double Room - 85'){
				if($value != '4'){
					$responseArray['status'] = 'error';

					$responseArray['errors'][$name] = "Number of people is not valid! ";

					return false;
				}
			} else {
				validate_input($value);
			}
		} else if($rule == 'pin'){
			if (empty($value) || !is_numeric($value) || strlen($value) == 9){
				$responseArray['status'] = 'error';

				$responseArray['errors'][$name] = "PIN is not valid! ";

				return false;
			} else{
				validate_input($value);
			}
		}		
	}

	return true;
}

