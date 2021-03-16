<?php 
	$data = [
		'fname' => $_POST['fname'],
		'lname' => $_POST['lname'],
		'pin' => $_POST['pin'],
		'email' => $_POST['email'],
		'room' => $_POST['room'],
		'people' => $_POST['people'],
		'startingDate'=>$_POST['startingDate'],
		'endingDate'=>$_POST['endingDate'],
		'price' => ''

	];

	echo json_encode($data);
?>