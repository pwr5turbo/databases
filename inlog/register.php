<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div id="main_header_body" >
        <h1 id="main_header"><a id="main_header_text" href="home.php">Main page</a></h1>
    </div>
    <div id="login_body">
        <form method="post">
            <h1 id="head_log">Login</h1><br>
            <label for="f_name">First name</label><br>
            <input type="fname" id="f_name" name="first_name"><br>
            <label for="l_name">Last name</label><br>
            <input type="lname" id="l_name" name="last_name" ><br>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email"><br>
            <label for="password_1">Eerste wachtwoord</label><br>
            <input type="password" id="password_1" name="password1"><br>
            <label for="password_2">Wachtwoord ter verificatie</label><br>
            <input type="password" id="password_2" name="password2"><br>
            <input type="submit" id="submit" value="Registreren" name="sub">
        </form>
    </div>
</body>
</html>

<?php
    if(isset($_POST["sub"])){  
        if( ! isset($_POST["first_name"])){
            die("Enter a first name");
        }
        if( ! isset($_POST["last_name"])){
            die("Enter a last name");
        }
        if( ! isset($_POST["email"])){
            die("Enter a email");
        }
        if( ! isset($_POST["password1"])){
            die("Enter a password");
        }
        if($_POST["password1"] != $_POST["password2"]){
            die("passwords don't match");
        }
    }

    if(isset($_POST["password1"]) && isset( $_POST["first_name"]) && isset( $_POST["last_name"]) && isset( $_POST["email"])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password_user = $_POST['password1'] ;

        $servername = "localhost";
        $username = "root";
        $password_db = "";
        $dbname = "login_db";

        $conn = mysqli_connect("$servername","$username","$password_db","$dbname");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO `user` (`id`, `first`, `last`, `email`, `password`)
        VALUES (NULL, '$first_name', '$last_name', '$email', '$password_user')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
    
?>