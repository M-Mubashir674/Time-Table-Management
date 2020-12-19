<?php
	$servername = "localhost" ;
	$username = "root" ;
	$password = "" ;

	$days = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun") ;
	$time = array("01:00","01:30","02:00","02:30","03:00","03:30","04:00","04:30","05:00","05:30","06:00","06:30","07:00","07:30","08:00","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30","20:00","20:30","21:00","21:30","22:00","22:30","23:00","23:30","24:00","24:30") ;

	$conn = new mysqli($servername,$username,$password);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "CREATE DATABASE IF NOT EXISTS LoginData" ;
	if ($conn->query($sql) === TRUE) {
		echo "Database LoginData created successfully";
	} else {
		echo "Error creating database: " . $conn->error;
	}
	
	$sql = "CREATE DATABASE IF NOT EXISTS TimeTableData" ;
	if ($conn->query($sql) === TRUE) {
		echo "Database TimeTableData created successfully";
	} else {
		echo "Error creating database: " . $conn->error;
	}

	$conn = new mysqli($servername,$username,$password,"logindata");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "CREATE TABLE IF NOT EXISTS data (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) DEFAULT ' ',
	email VARCHAR(50) NOT NULL ,
	id VARCHAR(11) NOT NULL,
	password VARCHAR(20) DEFAULT '123',
	position VARCHAR(10) DEFAULT 'Student';
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "Table logdata created successfully";
	} else {
		echo "Error creating table: " . $conn->error;
	}
	
	$conn->close ;

	$conn = new mysqli($servername,$username,$password,"TimeTableData");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "CREATE TABLE IF NOT EXISTS instructor (
	instructor_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) DEFAULT ' ',
	email VARCHAR(50) NOT NULL,
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";
	
	if ($conn->query($sql) === TRUE) {
		echo "Table instructor created successfully";
	} else {
		echo "Error creating table: " . $conn->error;
	}

	$sql = "CREATE TABLE IF NOT EXISTS course (
	course_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	subject VARCHAR(30) NOT NULL,
	duration DECIMAL(4,2) NOT NULL ,
	instructor_id INT(6) UNSIGNED ,
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY(instructor_id) REFERENCES Instructor(instructor_id)
	)";

	if ($conn->query($sql) === TRUE) {
		echo "Table course created successfully";
	} else {
		echo "Error creating table: " . $conn->error;
	}

	$sql = "CREATE TABLE IF NOT EXISTS department (
	dept_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	dept_name VARCHAR(30) NOT NULL,
	semester INT(1) NOT NULL,
	section VARCHAR(1) NOT NULL,
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "Table department created successfully";
	} else {
		echo "Error creating table: " . $conn->error;
	}

	$sql = "CREATE TABLE IF NOT EXISTS time (
	time_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	day VARCHAR(3) NOT NULL,
	time VARCHAR(5) NOT NULL,
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "Table time created successfully";
	} else {
		echo "Error creating table: " . $conn->error;
	}

	$sql = "CREATE TABLE IF NOT EXISTS timetable (
	time_id INT(6) UNSIGNED NOT NULL,
	dept_id INT(6) UNSIGNED NOT NULL,
	course_id INT(6) UNSIGNED NOT NULL,
	block VARCHAR(6) NOT NULL,
	room INT NOT NULL,
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(time_id,dept_id) ,
	FOREIGN KEY (time_id) REFERENCES time(time_id),
	FOREIGN KEY (dept_id) REFERENCES department(dept_id),
	FOREIGN KEY (course_id) REFERENCES course(course_id)
	)";

	if ($conn->query($sql) === TRUE) {
		echo "Table timetable created successfully";
	} else {
		echo "Error creating table: " . $GLOBALS['conn']->error;
	}
	
	for($inn=0 ; $inn<7 ; $inn++){
		for($innn=0 ; $innn<48 ; $innn++){
				$sql = "INSERT INTO ".$table."(day,time) VALUES ('{$day[$inn]}','{$time[$innn]}')";				
				if ($GLOBALS['conn']->query($sql) === FALSE) {
				  echo "Error: " . $sql . "<br>" . $conn->error;
				}
		}
	}

	$conn->close ;
?>