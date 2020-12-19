<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "LogData";
	$firstname = $_POST["fname"] ;
	$lastname = $_POST["lname"] ;
	$lpassword = $_POST["password"] ;
	$cmsid = $_POST["cms_id"] ;
	$email = $_POST["email"] ;
	$position = $_POST["position"] ;

	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'], $databasename);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	
	insertData($dbname,$firstname,$lastname,$email,$lpassword,$cmsid);]
	
	FUNCTION insertData($databasename,$fname,$lname,$email,$password,$cmsid,$position){
		$sql = "INSERT INTO Data(firstname, lastname, email,cms_id,password,position) VALUES ('{$fname}','{$lname}','{$email}','{$cmsid}','{$password}','{position}')";
		if ($GLOBALS['conn']->query($sql) === TRUE) {
		  echo "New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	$conn->close();
?>