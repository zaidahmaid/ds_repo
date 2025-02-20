
<?php
// include('attack.php');
$db_server="localhost";
$db_user="root";
$db_password="";
$db_name="task";
$conn="";
$conn=mysqli_connect($db_server,$db_user,$db_password,$db_name);
echo"<h1>1</h1>";

if ($conn->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$sql = "SELECT * FROM Students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Students</h2>";
    echo "<table border='1'><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Date of Birth</th><th>Gender</th><th>Major</th><th>Enrollment Year</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["student id"]. "</td><td>" . $row["first name"]. "</td><td>" . $row["last name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["date of birth"]. "</td><td>" . $row["gender"]. "</td><td>" . $row["major"]. "</td><td>" . $row["enrollment year"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

echo"<h1>2</h1>";
$sql = 
" SELECT COUNT(*) AS total_courses FROM Courses";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br>" . $row["total_courses"]. "<br>" ;
}
}
// echo"<h1>3</h1>";

// $grada = "SELECT * FROM courses";
// $res = $conn->query($grada);
// if ($res-> num_rows > 0){
//     while($row = $res->fetch_assoc()) {
//         echo "<br>" . $row["course id"]. "<br>" . $row["course name"]. "<br>" . $row["course code"]. "<br>" . $row["credits"]. "<br>" . $row["department"]. "<br>";
//     }
// }

echo"<h1>3</h1>";

$sql = 
" SELECT s.`first name`, s.`last name`
FROM Students s
JOIN Enrollments e ON s.`student id` = e.`student id`
WHERE e.`course id` = 1;";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br>" . $row["first name"]. "<br>" . $row["last name"]; 
}
}

echo"<h1>4</h1>";

$sql = 
"SELECT `email`
FROM Instructors
WHERE `department` = 'Computer Science';";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br><br>" . $row["email"]. "<br>";
}
}

echo"<h1>5</h1>";

$sql ="SELECT c.`course name`, c.`course code`, COUNT(e.`student id`) AS `number of students`
FROM Courses c
LEFT JOIN Enrollments e ON c.`course id` = e.`course id`
GROUP BY c.`course id`, c.`course name`, c.`course code`;";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br><br>" . $row["course name"]. "<br>" . $row["course code"];
}
}


echo"<h1>6</h1>";
//Find the students who were enrolled in a course with a grade of 'A'.
$sql ="SELECT s.`first name`, s.`student id`
FROM students s
LEFT JOIN Enrollments e ON s.`student id`=e.`student id`
WHERE grade ='A'";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br><br>" . $row["first name"]. " " . $row["student id"];
}
}
echo"<h1>7</h1>";
//Retrieve the courses and the instructors assigned for a specific semester.
$sql ="SELECT c.`course name`, c.`course code`, i.`first name`, i.`last name`, ca.`semester`
FROM Courses c
JOIN `Course assignments` ca 
JOIN Instructors i 
WHERE ca.`semester` = 'summer ' AND ca.`year` = 2023; ";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br><br>" . $row["course name"]. " || " . $row["course code"] . " || " . $row["first name"] . " || " . $row["semester"];
    }
}

mysqli_close($conn);
?>
