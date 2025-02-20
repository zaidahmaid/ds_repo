<?php
$host = 'localhost'; 
$dbname = 'task'; 
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted for soft deleting
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
        $student_id = $_POST['student_id'];

        // Set the soft_delete flag to 1 in the database
        $sql = "UPDATE students SET soft_delete = 1 WHERE student_id = :student_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':student_id' => $student_id]);

        // Redirect back to the delete page to refresh the data
        header("Location: delete.php");
        exit();
    }

    // Fetch data from the database (excluding soft deleted rows)
    $stmt = $pdo->query("SELECT student_id, first_name, last_name, email, date_of_birth, gender, major, enrollment_year FROM students WHERE soft_delete = 0");
    echo "<h2>Delete Student Information</h2>";
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
                    <input type='hidden' name='student_id' value='" . htmlspecialchars($row['student_id']) . "'>
                    <button type='submit'>Delete</button>
                </form>
              </td>";
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
