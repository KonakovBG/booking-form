<?php 
	$data = [];

	foreach ($_POST as $value) {
		var_dump($value); 
		$data[] = $value;
	}

	var_dump($_POST['room']);

	echo json_encode($data);
?>