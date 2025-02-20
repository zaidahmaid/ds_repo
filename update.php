<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Information</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Update Student Information</h2>

    <!-- Form to add or edit student information -->
    <form action="" method="post">
        <input type="hidden" id="student_id" name="student_id" value="">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="" required><br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="" required><br><br>
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="" required><br><br>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select><br><br>
        <label for="major">Major:</label>
        <input type="text" id="major" name="major" value="" required><br><br>
        <label for="enrollment_year">Enrollment Year:</label>
        <input type="number" id="enrollment_year" name="enrollment_year" value="" required><br><br>
        <button type="submit" name="action" value="update">Update</button>
    </form>
    
    <br>
    
    <?php
    $host = 'localhost'; 
    $dbname = 'task'; 
    $username = 'root'; 
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the form is submitted for updating
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'update') {
            $student_id = $_POST['student_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $date_of_birth = $_POST['date_of_birth'];
            $gender = $_POST['gender'];
            $major = $_POST['major'];
            $enrollment_year = $_POST['enrollment_year'];

            // Update the student record in the database
            $sql = "UPDATE students SET first_name = :first_name, last_name = :last_name, email = :email, 
                    date_of_birth = :date_of_birth, gender = :gender, major = :major, enrollment_year = :enrollment_year 
                    WHERE student_id = :student_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':email' => $email,
                ':date_of_birth' => $date_of_birth,
                ':gender' => $gender,
                ':major' => $major,
                ':enrollment_year' => $enrollment_year,
                ':student_id' => $student_id
            ]);

            // Redirect to avoid form resubmission and reload the updated data
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        // Fetch data from the database
        $stmt = $pdo->query("SELECT * FROM students");
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Major</th>
                    <th>Enrollment Year</th>
                    <th>Actions</th>
                </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
            echo "<td>" . htmlspecialchars($row['major']) . "</td>";
            echo "<td>" . htmlspecialchars($row['enrollment_year']) . "</td>";
            echo "<td>
                    <form style='display:inline;' action='' method='post'>
                        <input type='hidden' name='action' value='edit'>
                        <input type='hidden' name='student_id' value='" . htmlspecialchars($row['student_id']) . "'>
                        <input type='hidden' name='first_name' value='" . htmlspecialchars($row['first_name']) . "'>
                        <input type='hidden' name='last_name' value='" . htmlspecialchars($row['last_name']) . "'>
                        <input type='hidden' name='email' value='" . htmlspecialchars($row['email']) . "'>
                        <input type='hidden' name='date_of_birth' value='" . htmlspecialchars($row['date_of_birth']) . "'>
                        <input type='hidden' name='gender' value='" . htmlspecialchars($row['gender']) . "'>
                        <input type='hidden' name='major' value='" . htmlspecialchars($row['major']) . "'>
                        <input type='hidden' name='enrollment_year' value='" . htmlspecialchars($row['enrollment_year']) . "'>
                        <button type='submit'>Edit</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";

        // Check if the form is submitted for editing
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'edit') {
            $student_id = $_POST['student_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $date_of_birth = $_POST['date_of_birth'];
            $gender = $_POST['gender'];
            $major = $_POST['major'];
            $enrollment_year = $_POST['enrollment_year'];

            echo "<script>
                    document.getElementById('student_id').value = '$student_id';
                    document.getElementById('first_name').value = '$first_name';
                    document.getElementById('last_name').value = '$last_name';
                    document.getElementById('email').value = '$email';
                    document.getElementById('date_of_birth').value = '$date_of_birth';
                    document.getElementById('gender').value = '$gender';
                    document.getElementById('major').value = '$major';
                    document.getElementById('enrollment_year').value = '$enrollment_year';
                  </script>";
        }

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    ?>
</body>
</html>
