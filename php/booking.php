<?php 

include 'helpers.php';

$_POST['price'] = calculatePrice($_POST['startingDate'],$_POST['endingDate'],$_POST['room']);

$responseArray = [
	'status' => '',
	'message' => '',
	'errors' => [],
	'data' => $_POST
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

$isSuccessfull = validate($_POST,$rules);

if($isSuccessfull === true){
	$responseArray['status'] = 'success';

	$responseArray['message'] = 'You successfully made a reservation!';

	echo json_encode($responseArray);
	
	
} else{
	$responseArray['status'] = 'error';

	$responseArray['errors'] = $isSuccessfull;

	echo json_encode($responseArray);
}	
?>