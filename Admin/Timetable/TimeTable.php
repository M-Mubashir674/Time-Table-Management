<html>
	<body>
		<script>
			var ab1 = [101,102,103,104,105,106,107,108,109,110] ;
			var ab2 = [201,202,203,204,205,206,207,208,209,210] ;
			var ab3 = [301,302,303,304,305,306,307,308,309,310] ;
			var blocks = ["AB-I","AB-II","AB-III"] ;
			
			function getRooms(s1,s2){
				var s1 = document.getElementById(s1);
				var s2 = document.getElementById(s2);
				s2.innerHTML = '' ;
				if(s1.value=="AB-I"){
					ab=ab1 ;
				}else if(s1.value=="AB-II"){
					ab=ab2 ;
				}else{
					ab=ab3 ;	
				}
				for(var index in ab){
					var newOption = document.createElement('option');
					newOption.innerHTML = ab[index];
					s2.options.add(newOption);
				}					
			}	
			
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
			$sql = "SELECT CONCAT(firstname,' ',lastname) AS name ,subject FROM course JOIN instructor USING(instructor_id) ORDER BY name";
			$result = $conn->query($sql);
			if($result->num_rows >0){
				while($row = $result->fetch_assoc()) { 
					echo $row['name'].'|';
				}
			} else {
				echo "0 results";
			}
			?>";	
						
			var arraydepartment =
			"<?php	
			$sql = "SELECT dept_name , semester , section FROM department";
			$result = $conn->query($sql);
			if($result->num_rows >0){
				while($row = $result->fetch_assoc()) { 
					echo $row['dept_name'].','.$row['semester'].','.$row['section'].'|';
				}
			} else {
				echo "0 results";
			}
			?>";	
			
			arraydepartment = arraydepartment.slice(0,arraydepartment.length-1) ;
			arraydepartment = arraydepartment.split('|') ;
			
			for(var i = 0 ; i<arraydepartment.length ; i++){
				arraydepartment[i] = arraydepartment[i].split(',');
			}

			for(var i = 0 ; i<arraydepartment.length ; i++){
				for(var k = i ; k<arraydepartment.length ; k++){
						if(arraydepartment[i][0]==arraydepartment[k][0] & i!=k){			 
							arraydepartment[i][1] = arraydepartment[i][1]+","+arraydepartment[k][1] ;
							arraydepartment[i][2] = arraydepartment[i][2]+","+arraydepartment[k][2] ;
							arraydepartment.splice(k,1);
							k-- ;
						}
				}
			}
			
			for(var i = 0 ; i<arraydepartment.length ; i++){
					arraydepartment[i][1] = arraydepartment[i][1].split(",") ;
					arraydepartment[i][2] = arraydepartment[i][2].split(",") ;
			}
			
			for(var i = 0 ; i<arraydepartment.length ; i++){
				for(var j=0 ; j<arraydepartment[i][1].length ; j++){
					for(var k=j ; k<arraydepartment[i][1].length ; k++){
						if(arraydepartment[i][1][j]==arraydepartment[i][1][k] & j!=k){
							arraydepartment[i][2][j] = arraydepartment[i][2][j]+","+arraydepartment[i][2][k] ;
							arraydepartment[i][1].splice(k,1) ;
							arraydepartment[i][2].splice(k,1) ;
						}
					}
				}
			}
			
			for(var i=0 ; i<arraydepartment.length ; i++){
				for(var j=0 ; j<arraydepartment[i][1].length ; j++){
					arraydepartment[i][2][j] = arraydepartment[i][2][j].split(",") ;
				}
			}			

			
			arraysubject = arraysubject.slice(0,arraysubject.length-1) ;
			arrayinstructor = arrayinstructor.slice(0,arrayinstructor.length-1) ;
			arraysubject = arraysubject.split("|");
			arrayinstructor = arrayinstructor.split("|");
		</script>
		
		<?php
			
			if(isset($_POST['submitTimetable'])){
				$day = $_POST["day"] ;
				$time = $_POST["time"] ;            
				$department = $_POST["depart"] ;            
				$semester = $_POST["semester"] ;            
				$section = $_POST["section"] ;            
				$subject = $_POST["subject"] ;            
				$instructor = $_POST["instructor"] ;            
				$block = $_POST["block"] ;            
				$room = $_POST["room"] ;         
				insertData($dbname,$day,$time,$department,$semester,$section,$subject,$instructor,$block,$room);
			} 	
			FUNCTION insertData($dbname,$day,$time,$department,$semester,$section,$subject,$instructor,$block,$room){			
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
				
				$sql = "INSERT INTO timetable (time_id, dept_id,course_id,block,room) VALUES ($timeid,$deptid,$courseid,'{$block}','{$room}')";
				if ($GLOBALS['conn']->query($sql) === TRUE) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . $GLOBALS['conn']->error;
				}
			}
		?>

		<form method="POST">
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
			<select id="subject" name="subject" onchange="getInstructors(this.id,'instructor')">
			<script>
				var subj = document.getElementById('subject') ;
				for(var index in arraysubject){
					var newOption = document.createElement('option');
					newOption.innerHTML = arraysubject[index];
					subj.options.add(newOption);
				}
			</script>	
			</select><br>
			<script>
				function getInstructors(s1,s2){
					var s1 = document.getElementById(s1);
					var s2 = document.getElementById(s2);
					s2.innerHTML = '' ;
					for(var index in arrayinstructor){
						if(arraysubject[index]==s1.value){
							var newOption = document.createElement('option');
							newOption.innerHTML = arrayinstructor[index];
							s2.options.add(newOption);
						}
					}
				}
			</script>
			Instructor:
			<select id="instructor" name="instructor">
			
			<script>
				var inst = document.getElementById('instructor');
				for(var index in arrayinstructor){
					var newOption = document.createElement('option');
					newOption.innerHTML = arrayinstructor[index];
					inst.options.add(newOption);
				}
			</script>
			
			</select><br>
			Department:
			<select id="depart" name="depart" onchange="getSemesterSection(this.id,'semester','section')">
			<script>	
				var depart = document.getElementById('depart');
				for(var i=0 ; i<arraydepartment.length ; i++){
					var newOption = document.createElement('option');
					newOption.innerHTML = arraydepartment[i][0];
					depart.options.add(newOption);
				}
			</script>
			<script>
				function getSemesterSection(s1,s2,s3){
					var s1 = document.getElementById(s1);
					var s2 = document.getElementById(s2);
					var s3 = document.getElementById(s3);
					s2.innerHTML = '' ;
					s3.innerHTML = '' ;
					for(var i=0 ; i<arraydepartment.length ; i++){
						for(var j=0 ; j<arraydepartment[i][1].length;j++){
							if(arraydepartment[i][0]==s1.value){
								var newOption = document.createElement('option');
								newOption.innerHTML = arraydepartment[i][1][j];
								s2.options.add(newOption);
							}
						}
					}
					for(var i=0 ; i<arraydepartment.length ; i++){
						for(var j=0 ; j<arraydepartment[i][1].length;j++){
							if(arraydepartment[i][0]==s1.value & arraydepartment[i][1][j]==s2.value){
								for(var m=0; m<arraydepartment[i][1][j].length ; m++ ){
									var newOption = document.createElement('option');
									newOption.innerHTML = arraydepartment[i][2][j][m];
									s3.options.add(newOption);
								}
							}
						}
					}
				}
			</script>

			
			</select>
			<select id="semester" name="semester" onchange="getSection('depart',this.id,'section')">
			<script>
				var semester = document.getElementById('semester');
				var depart = document.getElementById('depart') ;
				for(var i=0 ; i<arraydepartment.length ; i++){
					for(var j=0 ; j<arraydepartment[i][1].length;j++){
						if(arraydepartment[i][0]==depart.value){
							var newOption = document.createElement('option');
							newOption.innerHTML = arraydepartment[i][1][j];
							semester.options.add(newOption);
						}
					}
				}
			</script>	
			</select>
			
			<script>
				function getSection(s1,s2,s3){
					var s1 = document.getElementById(s1);
					var s2 = document.getElementById(s2);
					var s3 = document.getElementById(s3);
					s3.innerHTML = '' ;
					for(var i=0 ; i<arraydepartment.length ; i++){
						for(var j=0 ; j<arraydepartment[i][1].length;j++){
							if(arraydepartment[i][0]==s1.value & arraydepartment[i][1][j]==s2.value){
								for(var m=0; m<arraydepartment[i][1][j].length ; m++ ){
									var newOption = document.createElement('option');
									newOption.innerHTML = arraydepartment[i][2][j][m];
									s3.options.add(newOption);
								}
							}
						}
					}
				}
			</script>

			
			
			<select id="section" name="section">
			<script>
				var semester = document.getElementById('semester');
				var depart = document.getElementById('depart') ;
				var section = document.getElementById('section') ;
				for(var i=0 ; i<arraydepartment.length ; i++){
					for(var j=0 ; j<arraydepartment[i][1].length;j++){
						if(arraydepartment[i][0]==depart.value & arraydepartment[i][1][j]==semester.value){
							for(var m=0; m<arraydepartment[i][1][j].length ; m++ ){
								var newOption = document.createElement('option');
								newOption.innerHTML = arraydepartment[i][2][j][m];
								section.options.add(newOption);
							}
						}
					}
				}
			</script>	
			</select><br>
			Room: 
			<select id="block" name="block" onchange="getRooms(this.id,'room')">
			<script>	
				var blck = document.getElementById('block') ;
				for(var index in blocks){
					var newOption = document.createElement('option');
					newOption.innerHTML = blocks[index];
					blck.options.add(newOption);
				}					
			</script>
			</select>
			<select id="room" name="room">
			<script>	
				var rom = document.getElementById('room') ;
				for(var index in ab1){
					var newOption = document.createElement('option');
					newOption.innerHTML = ab1[index];
					rom.options.add(newOption);
				}
			</script>
			</select><br>
			<input type="submit" name="submitTimetable" value="Add">
		</form>

	</body>
</html>