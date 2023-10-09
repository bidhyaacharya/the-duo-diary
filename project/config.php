<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "utsha_class";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if($conn)
	{
		echo "Database Connection Successful.";
	}
	else{
		echo "connection fail";
	}

?>