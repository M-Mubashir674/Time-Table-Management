<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "LogData";
	$tablename = "Time";
	
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'],$dbname);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	
	createTable($dbname,$tablename);
	$days = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun") ;
	$time = array("01:00","01:30","02:00","02:30","03:00","03:30","04:00","04:30","05:00","05:30","06:00","06:30","07:00","07:30","08:00","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30","20:00","20:30","21:00","21:30","22:00","22:30","23:00","23:30","24:00","24:30") ;
	
	for($inn=0 ; $inn<7 ; $inn++){
		for($innn=0 ; $innn<48 ; $innn++){
			insertData($dbname,$tablename,$days[$inn],$time[$innn]);
		}
	}
	
FUNCTION createTable($databasename,$tablename){ 
	$sql = "CREATE TABLE IF NOT EXISTS ". $tablename ." (
	time_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	day VARCHAR(3) NOT NULL,
	time VARCHAR(5) NOT NULL,
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";

	if ($GLOBALS['conn']->query($sql) === FALSE) {
		echo "Error creating table: " . $GLOBALS['conn']->error;
	}
}
	
FUNCTION insertData($databasename,$table,$day,$time){
	$sql = "INSERT INTO ".$table."(day,time) VALUES ('{$day}','{$time}')";
	
	if ($GLOBALS['conn']->query($sql) === FALSE) {
	  echo "Error: " . $sql . "<br>" . $GLOBALS['conn']->error;
	}
}
$conn->close();
?>

</body>
</html>
