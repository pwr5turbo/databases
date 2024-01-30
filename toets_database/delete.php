<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "top2000";

 // Create connection
 $conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $id = $_GET['id'];

    $sql = "DELETE FROM artist WHERE id=$id";
    $conn ->query($sql);

    $conn->close();

    header("Location: data_toets.php");
?>


