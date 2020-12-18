<html>
<body>
<script>
	var arraysubject =
	"<?php	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "LogData";
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'],$dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT CONCAT(firstname,' ',lastname) AS name , subject FROM course JOIN instructor USING(instructor_id) ORDER BY name";
	$result = $conn->query($sql);
	if($result->num_rows >0){
		while($row = $result->fetch_assoc()) { 
			echo $row['subject']."|";
		}
	} else {
		echo "0 results";
	}
	?>";

	var arrayinstructor =
	"<?php	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "LogData";
	$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'],$dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT CONCAT(firstname,' ',lastname) AS name ,subject FROM course JOIN instructor USING(instructor_id) ORDER BY name";
	$result = $conn->query($sql);
	if($result->num_rows >0){
		while($row = $result->fetch_assoc()) { 
			echo $row['name']."|";
		}
	} else {
		echo "0 results";
	}
	?>";	
	
	
	arraysubject = arraysubject.split('|');
	arrayinstructor = arrayinstructor.split('|');
</script>


	<?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "LogData";
		$conn = new mysqli($GLOBALS['servername'],$GLOBALS['username'],$GLOBALS['password'],$dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "select * from timetable" ;
		$result = $GLOBALS["conn"]->query($sql);
		$numrows = $result->num_rows ;
	for($i=0 ; $i<$numrows ;$i++){
		
		if(isset($_POST['Update'.$i])){
			$day = $_POST["day"] ;
			
			$time = $_POST["time"] ;            
			$department = $_POST["deptname"] ;            
			$semester = $_POST["semester"] ;            
			$section = $_POST["section"] ;            
			$subject = $_POST["subject"] ;            
			$instructor = $_POST["instructor"] ;            
			$block = $_POST["block"] ;            
			$room = $_POST["room"] ;			
			updateData("logdata","timetable",$day,$time,$department,$semester,$section,$subject,$instructor,$block,$room);
		} 	
	}

		FUNCTION updateData($dbname,$tablename,$day,$time,$department,$semester,$section,$subject,$instructor,$block,$room){

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
			$result1 = $GLOBALS["conn"]->query($sql);
			if ($result1->num_rows > 0) {
					while($row1 = $result1->fetch_assoc()) {
						$deptid = $row1["dept_id"] ;
					}
			} else {
			  echo "0 results";
			}	
			$sql = "SELECT cid.course_id AS course FROM course AS cid JOIN instructor AS inst USING(instructor_id) WHERE cid.subject='{$subject}' AND CONCAT(inst.firstname,' ',inst.lastname)='{$instructor}'";
			$result2 = $GLOBALS["conn"]->query($sql);
			if ($result2->num_rows > 0) {
					while($row2 = $result2->fetch_assoc()) {
						$courseid = $row2["course"] ;
					}
			} else {
			  echo "0 results";
			}	
			$sql = "UPDATE ".$tablename." SET course_id=$courseid ,block= '{$block}', room=$room WHERE time_id=$timeid AND dept_id=$deptid ";
			if ($GLOBALS['conn']->query($sql) === TRUE) {
			  echo "Record updated successfully";
			} else {
			  echo "Error: " . $sql . "<br>" . $GLOBALS['conn']->error;
			}
		}



	$sql = "SELECT day , time , subject , CONCAT(firstname,' ',lastname) AS name, block , room ,dept_name,semester,section FROM timetable as tb JOIN time USING(time_id) JOIN course USING(course_id) JOIN department USING(dept_id) JOIN instructor USING(instructor_id) WHERE dept_id=1";
	$result = $GLOBALS["conn"]->query($sql);
	if ($result->num_rows > 0) {
		$i =0 ;
		while($row = $result->fetch_assoc()) {
			echo "<form method='POST'>
				<input type='text' value='{$row['day']}' name='day'  readonly='true'>
				<input type='text' value='{$row['time']}' name='time'  readonly='true'>
				<input type='text' value='{$row['dept_name']}' name='deptname'  readonly='true'>
				<input type='text' value='{$row['semester']}' name='semester'  readonly='true'>
				<input type='text' value='{$row['section']}' name='section'  readonly='true'>
				<select id='subjectsubject$i' name='subject'>";								
					$sql = "SELECT subject FROM course";
					$result1 = $GLOBALS["conn"]->query($sql);
					if($result1->num_rows >0){
						while($row1 = $result1->fetch_assoc()) {
							if($row['subject']==$row1['subject']){	
								echo "<option selected='selected'>".$row1['subject']."</option>";
							}
							else{
								echo "<option>".$row1['subject']."</option>";
							}
						}
					} else {
						echo "0 results";
					}
				echo "</select>					
					<script>
					document.getElementById('subjectsubject$i').onchange = function(){
							var s1 = document.getElementById('subjectsubject$i');
							var s2 = document.getElementById('instructr$i');
							s2.innerHTML = '' ;
							for(var index in arrayinstructor){
								if(arraysubject[index]==s1.value){
								var newOption = document.createElement('option');
								newOption.innerHTML = arrayinstructor[index];
								s2.options.add(newOption);}
							}}
					</script>";
				echo "</select>
					<select id='instructr$i' name='instructor'><option>good</option>";
					$sql = "SELECT CONCAT(firstname,' ',lastname) AS name FROM instructor";
					$result2 = $GLOBALS["conn"]->query($sql);
					if($result2->num_rows >0){
						while($row2 = $result2->fetch_assoc()) { 
							if($row['name']==$row2['name']){	
								echo "<option selected='selected'>".$row2['name']."</option>";
							}
							else{
								echo "<option>".$row2['name']."</option>";
							}
						}
					} else {
						echo "0 results";
					}
				echo "</select>
				<select id='block' name='block'>";
					$block = array("AB-I","AB-II","AB-III") ;
					for($inn=0 ; $inn<3 ; $inn++){
						if($row['block']==$block[$inn]){
							echo "<option selected='selected'>$block[$inn]</option>" ;							
						}
						else{
							echo "<option>$block[$inn]</option>" ;	
						}
					}
				echo "</select>
				<select id='room' name='room'>";	
					$room = array(101,102,103,104,105,106,107,108) ;
					for($inn=0 ; $inn<8 ; $inn++){
						if($row['room']==$room[$inn]){
							echo "<option selected='selected'>$room[$inn]</option>" ;
						}
						else{
							echo "<option>$room[$inn]</option>" ;
						}
					}
				echo "</select>
				<input type='submit' value='Update' name='Update$i'>
			</form>" ;
			$i++ ;
		}
	} else {
	  echo "0 results";
	}	
	$conn->close();
	
	?>
</body>
</html>
