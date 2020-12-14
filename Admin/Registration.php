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

FUNCTION createDatbase($databasename){
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password']);
//	$sql = "DROP DATABASE logdata". $databasename;
//	$conn->query($sql);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "CREATE DATABASE IF NOT EXISTS ". $databasename;
	if ($conn->query($sql) === TRUE) {
		echo "Database created successfully";
	} else {
	echo "Error creating database: " . $conn->error;
	}
	$conn->close();
}
FUNCTION createTable($databasename,$tablename){ 
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'],$databasename);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "CREATE TABLE IF NOT EXISTS ". $tablename ." (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	cms_id VARCHAR(11),
	password VARCHAR(20),
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
	  echo "Table ". $tablename ." created successfully";
	} else {
	echo "Error creating table: " . $conn->error;
	}
	$conn->close();
}
FUNCTION insertData($databasename,$fname,$lname,$email,$password,$cmsid){
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'], $databasename);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	$sql = "INSERT INTO Data(firstname, lastname, email,cms_id,password) VALUES ('{$fname}','{$lname}','{$email}','{$cmsid}','{$password}')";
	if ($conn->query($sql) === TRUE) {
	  echo "New record created successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}
createDatbase($dbname);
createTable($dbname,"Data");
insertData($dbname,$firstname,$lastname,$email,$lpassword,$cmsid);
?>