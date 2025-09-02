<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE username=? AND password=?";
    $ps  = $con->prepare($sql);
    $ps->bind_param("ss", $username, $password);
    $ps->execute();
    $result = $ps->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid login!";
    }
}
?>
<?php include("includes/header.php"); ?>
<h2>Admin Login</h2>
<form method="post">
  Username: <input type="text" name="username" required><br>
  Password: <input type="password" name="password" required><br>
  <input type="submit" value="Login">
</form>
<p style="color:red;"><?php if(isset($error)) echo $error; ?></p>
<?php include("includes/footer.php"); ?>
