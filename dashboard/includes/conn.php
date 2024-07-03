<?php

	// session_start();
    $conn = new mysqli('localhost', 'root', 'root', 'libraray2');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	
?>