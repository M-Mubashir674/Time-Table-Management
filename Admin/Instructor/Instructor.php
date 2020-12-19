<html>
	<body>
		<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "LogData";
			$conn = new mysqli($servername,$username,$password,$dbname);
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			}
		
			if(isset($_POST['submitInstructor'])){
				$firstname = $_POST["fname"] ;
				$lastname = $_POST["lname"] ;
				$email = $_POST["email"] ;        
				insertData($dbname,$firstname,$lastname,$email);
			} 	
			
			FUNCTION insertData($databasename,$fname,$lname,$email){
				
				$sql = "INSERT INTO instructor(firstname, lastname,email) VALUES ('{$fname}','{$lname}','{$email}')";
			if ($GLOBALS['conn']->query($sql) === TRUE) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
			$conn->close();
		?>
		
		<form action="" method="post">
			First Name: <input type="text" name="fname"><br>
			Last Name: <input type="text" name="lname"><br>
			email: <input type="text" name="email"><br>
			<input type="submit" name="submitInstructor" value="Add">
		</form>
		
	</body>
</html>
