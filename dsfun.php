
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 50vW;
            
        }
        table ,td,th {
            border:2px solid black ;
        }
    </style>
</head>
<body>
    
</body>
</html>
<?php 
$db_server="localhost";
$db_user="root";
$db_password="";
$db_name="task";
$conn="";
$conn=mysqli_connect($db_server,$db_user,$db_password,$db_name);


if ($conn->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo"<h1>1</h1>";
//Create a function to calculate a student's age based on date_of_birth.
$sql="SELECT `first_name`,`last_name`,TIMESTAMPDIFF(YEAR, students.date_of_birth, CURDATE()) AS age 
FROM students;";
$result=$conn->query($sql);
echo"<table><th>first_name</th><th>last_name</th><th>age</th>";
while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row["first_name"]. "</td><td>" . $row["last_name"]. "</td><td>" . $row["age"] . "</td>";
}
echo"</table>";

echo"<h1>2</h1>";
//Create a stored procedure to enroll a student in a course.
/*"DELIMITER $$

CREATE PROCEDURE EnrollStudent(
    IN p_student_id INT,
    IN p_course_id INT,
    IN p_grade char(1)
)
BEGIN
    -- Insert the enrollment data into the Enrollments table
    INSERT INTO Enrollments (student_id, course_id, grade)
    VALUES (p_student_id, p_course_id, p_grade);
END$$

DELIMITER ;*/

//to call it CALL EnrollStudent(1, 101, 'A');


echo"<h3>Use aggregate functions to show average grades by department.</h3>";
//Use aggregate functions to show average grades by department.
echo"DELIMITER $$<br>

CREATE PROCEDURE aggregate_functions()<br>
BEGIN<br>
    SELECT<br>
        c.department,<br>
        AVG(e.grade) AS average_grade<br>
    FROM<br>
        Enrollments e<br>
        JOIN Courses c ON e.course_id = c.course_id<br>
    GROUP BY<br>
        c.department;<br>
END$$<br>

DELIMITER ;<br>

it workes when grade are numeric" 
















?>