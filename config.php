<?php
$con = new mysqli("localhost", "root", "", "megdb");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
