<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logdata";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT tm.day as day ,tm.time as time,dpt.dept_name as dptname ,dpt.semester as semester,dpt.section as section,sb.subject as subject,sb.duration as duration,CONCAT(ins.firstname,' ',ins.lastname) as name,tb.block as block,tb.room as room FROM timetable as tb JOIN time as tm USING(time_id) JOIN department as dpt USING(dept_id) JOIN course as sb USING(course_id) JOIN instructor as ins USING(instructor_id)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table border =\"1\" style='border-collapse: collapse'>";
	echo "<tr><th>Day</th>" ;
	echo "<th>Time</th>" ;
	echo "<th>Department</th>" ;
	echo "<th>Subject</th>" ;
	echo "<th>Instructor</th>" ;
	echo "<th>Duration</th>" ;
	echo "<th>Room</th></tr>" ;
	while($row = $result->fetch_assoc()) { 
			echo "<tr><td>".$row["day"]."</td><td>".$row["time"]."</td><td>".$row["dptname"]." ".$row["semester"]." ".$row["section"]."</td><td>".$row["subject"]."</td><td>".$row["name"]."</td><td>".$row["duration"]."</td><td>".$row["block"]." ".$row["room"]."</td></tr>";
	}
	echo "</table>";
} else {
  echo "0 results";
}
$conn->close();
?>
