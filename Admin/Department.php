<html>
<body>

<?php

if(isset($_POST['submt'])){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "LogData";
	$tablename = "Department";
	$department = $_POST["name"] ;
	$semester = $_POST["semester"] ;
	$section = $_POST["section"] ;            
	createTable($dbname,$tablename);
	insertData($dbname,$tablename,$department,$semester,$section);
} 	
FUNCTION createTable($databasename,$tablename){ 
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'],$databasename);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "CREATE TABLE IF NOT EXISTS ". $tablename ." (
	dept_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	dept_name VARCHAR(30) NOT NULL,
	semester INT(1) NOT NULL,
	section VARCHAR(1),
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
	  echo "Table ". $tablename ." created successfully";
	} else {
	echo "Error creating table: " . $conn->error;
	}
	$conn->close();
}
FUNCTION insertData($databasename,$table,$name,$semester,$section){
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'], $databasename);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	$sql = "INSERT INTO ".$table."(dept_name, semester,section) VALUES ('{$name}','{$semester}','{$section}')";
	if ($conn->query($sql) === TRUE) {
	  echo "New record created successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}
?>

<form action="" method="post">
	Department: <input type="text" name="name"><br>
	Semester: <input type="text" name="semester"><br>
	Section: <input type="text" name="section"><br>
	<input type="submit" name="submt" value="submit">
</form>


</body>
</html>
