<?php

$id = $_POST["cms_id"] ;
$pas = $_POST["password"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timetable";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT cms_id, password FROM LogData WHERE cms_id=". $id . " AND password=". $pas .";";
$result = $conn->query($sql);

if($result==TRUE){
	echo nl2br("Welcome ".$_POST["name"]."\n");
	}
else{
	echo ("Sorry your code is wrong");
}	


?>
