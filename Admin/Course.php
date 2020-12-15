<html>
<body>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "LogData";
$tablename = "course" ;


if(isset($_POST['smt'])){
	$subject = $_POST["subject"] ;
	$duration = $_POST["duration"] ;
	$instructor = $_POST["instructor"] ;            
	$instructorid = 0;
	createTable($dbname,$tablename);
	getInstructorsID($instructor,$dbname) ;
	insertData($dbname,$subject,$duration,$instructorid);
} 	
FUNCTION createTable($databasename,$tablename){ 
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'],$databasename);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "CREATE TABLE IF NOT EXISTS ". $tablename ." (
	course_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	subject VARCHAR(30) NOT NULL,
	duration DECIMAL(4,2),
	instructor_id INT(6) UNSIGNED,
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY(instructor_id) REFERENCES Instructor(instructor_id)
	)";

	if ($conn->query($sql) === TRUE) {
	  echo "Table ". $tablename ." created successfully";
	} else {
	echo "Error creating table: " . $conn->error;
	}
	$conn->close();
}
FUNCTION getInstructorsID($instructorname,$dbname){
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'], $dbname);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT instructor_id FROM instructor WHERE CONCAT(firstname,' ',lastname)='{$instructorname}'";
	$result = $conn->query($sql) ;
	if ($result->num_rows > 0) {
	   while($row = $result->fetch_assoc()) {
		$GLOBALS["instructorid"] = $row["instructor_id"] ;
	  }
	} else {
	   echo "0 results";
	}
		
	if ($conn->query($sql) == TRUE) {
		$instructorid = $result->fetch_assoc();
		
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}
FUNCTION insertData($databasename,$subject,$duration,$instructorid){
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'], $databasename);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	$sql = "INSERT INTO course(subject, duration,instructor_id) VALUES ('{$subject}',{$duration},$instructorid)";
	if ($conn->query($sql) === TRUE) {
	  echo "New record created successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}
?>

<form action="" method="post">
	Subject: <input type="text" name="subject"><br>
	Duration: <input type="text" name="duration"><br>
	Instructor:
	<select id="instructor" name="instructor">
	<?php
	
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "LogData";
		getInstructors($dbname) ;
		
		FUNCTION getInstructors($databasename){ 
			$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'],$databasename);
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			}
			$sql = "SELECT CONCAT(firstname,' ',lastname) AS name FROM instructor";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			  while($row = $result->fetch_assoc()) {
				echo "<option>" . $row["name"] . "</option>";
			  }
			} else {
			  echo "0 results";
			}
			$conn->close();
		}	
	?>
	</select>
	<input type="submit" name="smt" value="submit">
</form>


</body>
</html>
