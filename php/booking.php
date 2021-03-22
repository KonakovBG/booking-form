<?php 

include 'helpers.php';

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
	'startingDate' => 'required',
	'endingDate' => 'required',
	'people' => 'people'
];	

$isSuccessfull = validate($_POST,$rules);

$finalPrice = calculatePrice($_POST['startingDate'],$_POST['endingDate'],$_POST['room']);

$responseArray['data']['price'] = $finalPrice;

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