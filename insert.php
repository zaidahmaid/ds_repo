<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Student Registration</h2>
    <form action="insert.php" method="post">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required><br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select><br><br>

        <label for="major">Major:</label>
        <input type="text" id="major" name="major" required><br><br>

        <label for="enrollment_year">Enrollment Year:</label>
        <input type="number" id="enrollment_year" name="enrollment_year" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
<?php
$host = 'localhost'; 
$dbname = 'task'; 
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $major = $_POST['major'];
        $enrollment_year = $_POST['enrollment_year'];

        $stmt = $pdo->prepare("INSERT INTO students (first_name, last_name, email, date_of_birth, gender, major, enrollment_year) 
                               VALUES (:first_name, :last_name, :email, :date_of_birth, :gender, :major, :enrollment_year)");
        
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':date_of_birth' => $date_of_birth,
            ':gender' => $gender,
            ':major' => $major,
            ':enrollment_year' => $enrollment_year
        ]);

        echo "Student registered successfully!";

        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }


    
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

