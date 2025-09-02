<?php
session_start();
include("config.php");

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle Add Student
if (isset($_POST['add'])) {
    $usn = $_POST['usn'];
    $name = $_POST['name'];
    $dept = $_POST['dept'];
    $sem = intval($_POST['sem']);
    $marks = intval($_POST['marks']);
    $cgpa = $_POST['cgpa'];

    $sql = "INSERT INTO students (usn, name, dept, sem, marks,cgpa) VALUES (?, ?, ?, ?, ?,?)";
    $ps = $con->prepare($sql);
    $ps->bind_param("sssiii", $usn, $name, $dept, $sem, $marks, $cgpa);
    if ($ps->execute()) {
        $msg = "Student added.";
    } else {
        $msg = "Error: " . $con->error;
    }
}

// Handle search
$search = $_GET['search'] ?? '';
if ($search !== '') {
    $sql = "SELECT * FROM students WHERE usn LIKE ? OR name LIKE ? ORDER BY usn";
    $ps  = $con->prepare($sql);
    $term = "%{$search}%";
    $ps->bind_param("ss", $term, $term);
    $ps->execute();
    $results = $ps->get_result();
} else {
    $results = $con->query("SELECT * FROM students ORDER BY usn");
}
?>
<?php include("includes/header.php"); ?>
<h2>Admin Dashboard</h2>
<a href="logout.php"><button>Logout</button></a>
<br><br>
<?php if(isset($msg)) { echo "<p style='color:green;'>".htmlspecialchars($msg)."</p>"; } ?>

<h3>Add Student Result</h3>
<form method="post">
  USN: <input type="text" name="usn" required><br><br>
  Name: <input type="text" name="name" required><br><br>
  Department: <input type="text" name="dept" required><br><br>
  Semester: <input type="number" name="sem" required><br>
  Marks: <input type="number" name="marks" required><br>
   CGPA :<input type="number" name="cgpa" required><br>
  <input type="submit" name="add" value="Add Result">
</form>

<h3>All Results</h3>
<form method="get">
  <input type="text" name="search" placeholder="Search USN/Name" value="<?php echo htmlspecialchars($search); ?>">
  <input type="submit" value="Search">
</form>

<table border="1" cellpadding="6">
  <tr><th>USN</th><th>Name</th><th>Dept</th><th>Sem</th><th>Marks</th><th>cgpa</th></tr>
  <?php while ($row = $results->fetch_assoc()) { ?>
    <tr>
      <td><?php echo htmlspecialchars($row['usn']); ?></td>
      <td><?php echo htmlspecialchars($row['name']); ?></td>
      <td><?php echo htmlspecialchars($row['dept']); ?></td>
      <td><?php echo htmlspecialchars($row['sem']); ?></td>
      <td><?php echo htmlspecialchars($row['marks']); ?></td>
      <td><?php echo htmlspecialchars($row['cgpa']); ?></td>
    </tr>
  <?php } ?>
</table>
<?php include("includes/footer.php"); ?>
