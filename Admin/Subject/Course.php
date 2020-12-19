<html>
	<body>

		<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "logData";
			$conn = new mysqli($servername,$username,$password,$dbname);
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			}

			if(isset($_POST['submitCourse'])){
				$subject = $_POST["subject"] ;
				$duration = $_POST["duration"] ;
				$instructor = $_POST["instructor"] ;            
				insertData($subject,$duration,getInstructorsID($instructor));
			} 	
				
			FUNCTION getInstructorsID($instructorname){
				$sql = "SELECT instructor_id FROM instructor WHERE CONCAT(firstname,' ',lastname)='{$instructorname}'";
				$result = $GLOBALS['conn']->query($sql) ;
				$instructorid = 0 ;
				if ($result->num_rows > 0) {
				   while($row = $result->fetch_assoc()) {
						$instructorid = $row["instructor_id"] ;
				  }
				} else {
				   echo "0 results";
				}
				return $instructorid ;
			}
			
			FUNCTION insertData($subject,$duration,$instructorid){
				$sql = "INSERT INTO course(subject, duration,instructor_id) VALUES ('{$subject}',$duration,$instructorid)";
				if ($GLOBALS['conn']->query($sql) === TRUE) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . $GLOBALS['conn']->error;
				}
			}
		?>

		<form action="" method="post">
			Subject: <input type="text" name="subject"><br>
			Duration: <input type="text" name="duration"><br>
			Instructor:
			<select id="instructor" name="instructor">
			<?php			
				$sql = "SELECT CONCAT(firstname,' ',lastname) AS name FROM instructor";
				$result = $GLOBALS['conn']->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo "<option>" . $row["name"] . "</option>";
					}
				} else {
					echo "0 results";
				}
				$conn->close();	
			?>
			</select>
			<input type="submit" name="submitCourse" value="Add">
		</form>
		
	</body>
</html>
