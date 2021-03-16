<?php 
	$data = [
		'fname' => $_POST['fname'],
		'lname' => $_POST['lname'],
		'pin' => $_POST['pin'],
		'email' => $_POST['email'],
		'room' => $_POST['room'],
		'people' => $_POST['people']

	];

	echo json_encode($data);
?>