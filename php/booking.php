<?php 

include 'helpers.php';

$data = $_POST;

$data['price'] = calculatePrice();

$responseArray = [
	'status' => '',
	'message' => '',
	'errors' => [],
	'data' => $data
];	

$rules = [
	'fname' => 'required',
	'lname' => 'required',
	'pin' => 'pin',
	'email' => 'email',
	'room' => 'required',
	'people' => 'people',
	'startingDate' => 'required',
	'endingDate' => 'required'
];

$ifError = validate($_POST,$rules);

if($ifError === true){
	$responseArray['status'] = 'success';

	$responseArray['message'] = 'You successfully made a reservation!';

	echo json_encode($responseArray);
	
	
} else{
	$responseArray['status'] = 'error';

	$responseArray['errors'] = $ifError;

	echo json_encode($responseArray);
}	
?>