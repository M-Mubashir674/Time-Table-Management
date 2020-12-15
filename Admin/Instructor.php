<html>
<body>

<?php

if(isset($_POST['submt'])){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "LogData";
	$firstname = $_POST["fname"] ;
	$lastname = $_POST["lname"] ;
	$email = $_POST["email"] ;            
	createTable($dbname,"Instructor");
	insertData($dbname,$firstname,$lastname,$email);
} 	
FUNCTION createTable($databasename,$tablename){ 
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'],$databasename);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "CREATE TABLE IF NOT EXISTS ". $tablename ." (
	instructor_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
	  echo "Table ". $tablename ." created successfully";
	} else {
	echo "Error creating table: " . $conn->error;
	}
	$conn->close();
}
FUNCTION insertData($databasename,$fname,$lname,$email){
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'], $databasename);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	$sql = "INSERT INTO Instructor(firstname, lastname,email) VALUES ('{$fname}','{$lname}','{$email}')";
	if ($conn->query($sql) === TRUE) {
	  echo "New record created successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}
?>

<form action="" method="post">
	First Name: <input type="text" name="fname"><br>
	Last Name: <input type="text" name="lname"><br>
	email: <input type="text" name="email"><br>
	<input type="submit" name="submt" value="submit">
</form>


</body>
</html>
