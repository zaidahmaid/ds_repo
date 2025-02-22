
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
        echo "<tr><td>" . $row["student_id"]. "</td><td>" . $row["first_name"]. "</td><td>" . $row["last_name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["date_of_birth"]. "</td><td>" . $row["gender"]. "</td><td>" . $row["major"]. "</td><td>" . $row["enrollment_year"]. "</td></tr>";
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
" SELECT s.`first_name`, s.`last_name`
FROM Students s
JOIN Enrollments e ON s.`student_id` = e.`student_id`
WHERE e.`course_id` = 1;";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br>" . $row["first_name"]. "<br>" . $row["last_name"]; 
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

$sql ="SELECT c.`course_name`, c.`course_code`, COUNT(e.`student_id`) AS `number of students`
FROM Courses c
LEFT JOIN Enrollments e ON c.`course_id` = e.`course_id`
GROUP BY c.`course_id`, c.`course_name`, c.`course_code`;";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br><br>" . $row["course_name"]. "<br>" . $row["course_code"];
}
}


echo"<h1>6</h1>";
//Find the students who were enrolled in a course with a grade of 'A'.
$sql ="SELECT s.`first_name`, s.`student_id`
FROM students s
LEFT JOIN Enrollments e ON s.`student_id`=e.`student_id`
WHERE grade ='A'";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br><br>" . $row["first_name"]. " " . $row["student_id"];
}
}
echo"<h1>7</h1>";
//Retrieve the courses and the instructors assigned for a specific semester.
$sql ="SELECT c.`course_name`, c.`course_code`, i.`first_name`, i.`last_name`, ca.`semester`
 FROM Courses c 
 JOIN `Course assignments` ca ON ca.`course_id` = c.`course_id`
 JOIN Instructors i ON ca.`instructor_id` = i.`instructor_id` 
 WHERE ca.`semester` = 'summer ' AND ca.`year` = 2023; ";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br><br>" . $row["course_name"]. " || " . $row["course_code"] . " || " . $row["first_name"] . " || " . $row["semester"];
    }
}
echo"<h1>8</h1>";
//Find the average grade for a particular course.
$sql= "SELECT grade
FROM Enrollments
WHERE course_id = 3
 ";
$result = $conn->query($sql);
$sum=0;
$i=0;
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        ++$i;
        if ($row["grade"]=='A') {
            $sum += 85;
        }
        if($row["grade"]=='B'){
            $sum += 70;
        }
    }
    echo "<br>avareg grade is : ". $sum/$i;
}
echo"<h1>9</h1>";
//List students taking more than 3 courses in the current semester.
$sql=" SELECT DISTINCT s.`first_name` , s.`last_name`, e.`course_id` ,c.`course_name` 
FROM students s 
join enrollments e on s.`student_id` = e.`student_id` 
JOIN courses c on c.`course_id` = e.`course_id` 
WHERE e.`student_id` =1;
";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()) {
        echo "<br><br>" . $row["first_name"]. " || " . $row["last_name"] . " || " . $row["course_id"] . " || " . $row["course_name"];
    }
}



echo"<h1>10</h1>";
//Generate a report of students with incomplete grades.
$sql =" SELECT s.`first_name`, s.`last_name` ,e.`grade`
FROM students s 
right join enrollments e on e.`student_id` = s.`student_id`
where e.`grade` ='F';
";
$result =$conn->query($sql);
if ($result->num_rows>0) {
    while ($row = $result->fetch_assoc()) {
        echo "<br>". $row["first_name"] . " ". $row["last_name"] . " || " . $row["grade"];
    }
}

echo"<h1>12</h1>";
//Find the department with the most courses taught this year.
$sql =" SELECT COUNT(courses.`course_code`) AS num_of_courses ,courses.`department` , ca.`year`
FROM courses 
JOIN `course assignments` AS ca on ca.`course_id` = courses.`course_id`
GROUP by courses.`department`
ORDER by num_of_courses DESC
LIMIT 1
";
$result =$conn->query($sql);
if ($result->num_rows>0) {
    while ($row = $result->fetch_assoc()) {
        echo "<br>". $row["num_of_courses"] . " || ". $row["department"] . " || " . $row["year"];
    }
}




mysqli_close($conn);
?>
