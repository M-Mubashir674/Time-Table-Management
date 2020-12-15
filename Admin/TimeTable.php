<html>
<body>

<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "LogData";
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'],$dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
if(isset($_POST['submt'])){
	$tablename = "timetable";
	$day = $_POST["day"] ;
	$time = $_POST["time"] ;            
	$department = $_POST["depart"] ;            
	$semester = $_POST["semester"] ;            
	$section = $_POST["section"] ;            
	$subject = $_POST["subject"] ;            
	$instructor = $_POST["instructor"] ;            
	$block = $_POST["block"] ;            
	$room = $_POST["room"] ;            
	createTable($dbname,$tablename);
	insertData($dbname,$tablename,$day,$time,$department,$semester,$section,$subject,$instructor,$block,$room);
} 	
FUNCTION createTable($databasename,$tablename){ 
	$sql = "CREATE TABLE IF NOT EXISTS ". $tablename ." (
	time_id INT(6) UNSIGNED NOT NULL,
	dept_id INT(6) UNSIGNED NOT NULL,
	course_id INT(6) UNSIGNED NOT NULL,
	block VARCHAR(6),
	room INT ,
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	FOREIGN KEY (time_id) REFERENCES time(time_id),
	FOREIGN KEY (dept_id) REFERENCES department(dept_id),
	FOREIGN KEY (course_id) REFERENCES course(course_id)
	)";

	if ($GLOBALS['conn']->query($sql) === TRUE) {
	  echo "Table ". $tablename ." created successfully";
	} else {
	echo "Error creating table: " . $GLOBALS['conn']->error;
	}
}
FUNCTION insertData($dbname,$tablename,$day,$time,$department,$semester,$section,$subject,$instructor,$block,$room){
	
	$sql = "SELECT time_id FROM time WHERE day='{$day}' AND time='{$time}'";
	$result = $GLOBALS["conn"]->query($sql);
	if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$timeid = $row["time_id"] ;
			}
	} else {
	  echo "0 results";
	}	
	$sql = "SELECT dept_id FROM department WHERE dept_name='{$department}' AND semester= $semester AND section='{$section}'";
	$result = $GLOBALS["conn"]->query($sql);
	if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$deptid = $row["dept_id"] ;
			}
	} else {
	  echo "0 results";
	}	
	$sql = "SELECT cid.course_id AS course FROM course AS cid JOIN instructor AS inst USING(instructor_id) WHERE cid.subject='{$subject}' AND CONCAT(inst.firstname,' ',inst.lastname)='{$instructor}'";
	$result = $GLOBALS["conn"]->query($sql);
	if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$courseid = $row["course"] ;
			}
	} else {
	  echo "0 results";
	}	
	$sql = "INSERT INTO ".$tablename."(time_id, dept_id,course_id,block,room) VALUES ($timeid,$deptid,$courseid,'{$block}','{$room}')";
	if ($GLOBALS['conn']->query($sql) === TRUE) {
	  echo "New record created successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $GLOBALS['conn']->error;
	}
}
?>

<form method="post">
	Time:
	<select id="day" name="day">
	<?php
		$days = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun") ;
		for($inn=0 ; $inn<7 ; $inn++){
			echo "<option>$days[$inn]</option>" ;
		}
	?>
	</select>
	<select id="time" name="time">
	<?php	
		$time = array("01:00","01:30","02:00","02:30","03:00","03:30","04:00","04:30","05:00","05:30","06:00","06:30","07:00","07:30","08:00","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30","20:00","20:30","21:00","21:30","22:00","22:30","23:00","23:30","24:00","24:30") ;
		
		for($inn=0 ; $inn<48 ; $inn++){
			echo "<option>$time[$inn]</option>" ;
		}
	?>
	</select><br>
	Subject:
	<select id="subject" name="subject">
	<?php
		$sql = "SELECT subject FROM course";
		$result = $GLOBALS["conn"]->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option>" . $row["subject"] . "</option>";
			}
		} else {
		  echo "0 results";
		}	
	?>
	</select><br>
	Instructor:
	<select id="instructor" name="instructor">
	<?php
		$sql = "SELECT CONCAT(firstname,' ',lastname) AS name FROM instructor";
		$result = $GLOBALS["conn"]->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option>" . $row["name"] . "</option>";
			}
		} else {
		  echo "0 results";
		}	
	?>
	</select><br>
	Department:
	<select id="depart" name="depart">
	<?php
		$sql = "SELECT dept_name FROM department";
		$result = $GLOBALS["conn"]->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option>" . $row["dept_name"] . "</option>";
			}
		} else {
		  echo "0 results";
		}	
	?>
	</select>
	<select id="semester" name="semester">
	<?php	
		$semesters = array(1,2,3,4,5,6,7,8) ;
		for($inn=0 ; $inn<8 ; $inn++){
			echo "<option>$semesters[$inn]</option>" ;
		}
	?>
	</select>
	<select id="section" name="section">
	<?php
		$sql = "SELECT section FROM department";
		$result = $GLOBALS["conn"]->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option>" . $row["section"] . "</option>";
			}
		} else {
		  echo "0 results";
		}	
		$conn->close();
	?>
	</select><br>
	Room: 
	<select id="block" name="block">
	<?php	
		$blocks = array("AB-I","AB-II","AB-III") ;
		for($inn=0 ; $inn<3 ; $inn++){
			echo "<option>$blocks[$inn]</option>" ;
		}
	?>
	</select>
	<select id="room" name="room">
	<?php	
		$room = array(101,102,103,104,105,106,107,108) ;
		for($inn=0 ; $inn<8 ; $inn++){
			echo "<option>$room[$inn]</option>" ;
		}
	?>
	</select><br>
	<input type="submit" name="submt" value="submit">
</form>


</body>
</html>
