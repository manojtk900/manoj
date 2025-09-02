<?php
include("config.php");
include("includes/header.php");

if (!isset($_POST['usn'])) {
    echo "<p style='color:red;'>No USN provided.</p>";
    include("includes/footer.php");
    exit();
}

$usn = $_POST['usn'];

$sql = "SELECT * FROM students WHERE usn=?";
$ps  = $con->prepare($sql);
$ps->bind_param("s", $usn);
$ps->execute();
$result = $ps->get_result();

if ($row = $result->fetch_assoc()) {
    echo "<h2>Result for USN: " . htmlspecialchars($row['usn']) . "</h2>";
    echo "Name: " . htmlspecialchars($row['name']) . "<br>";
    echo "Department: " . htmlspecialchars($row['dept']) . "<br>";
    echo "Semester: " . htmlspecialchars($row['sem']) . "<br>";
    echo "Marks: " . htmlspecialchars($row['marks']) . "<br>";
} else {
    echo "<p style='color:red;'>No record found!</p>";
}

include("includes/footer.php");
?>
