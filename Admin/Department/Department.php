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

			if(isset($_POST['submitDepartment'])){
				$department = $_POST["name"] ;
				$semester = $_POST["semester"] ;
				$section = $_POST["section"] ;            
				insertDataInDepartment($dbname,$department,$semester,$section);
			} 	
			
			FUNCTION insertDataInDepartment($databasename,$name,$semester,$section){
				$sql = "INSERT INTO department (dept_name, semester,section) VALUES ('{$name}','{$semester}','{$section}')";
				if ($GLOBALS['conn']->query($sql) === TRUE) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
			$conn->close();
		?>

		<form method="POST">
			Department: <input type="text" name="name"><br>
			Semester: <input type="text" name="semester"><br>
			Section: <input type="text" name="section"><br>
			<input type="submit" name="submitDepartment" value="Add">
		</form>

	</body>
</html>
