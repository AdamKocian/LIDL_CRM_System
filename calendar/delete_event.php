<?php
require "connect.php";
$id = $_POST['id'];
$sqlDelete = "DELETE from user_productivity WHERE id=".$id;

mysqli_query($conn, $sqlDelete);
echo mysqli_affected_rows($conn);

mysqli_close($conn);
?>