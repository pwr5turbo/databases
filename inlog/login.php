
<?php
    if (isset($_POST['submit'])) {
    $email = $_POST["email"];
    $password = $_POST["password_user"];

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "login_db";

    $conn = mysqli_connect("$servername","$username","$password_db","$dbname");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }        

        $sql = htmlspecialchars("select * from user where email = '$email' and password = '$password'");  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_assoc($result);  
        $count = mysqli_num_rows($result);  
        
        if($count == 1){  
            header("Location:register.php");
            echo "hey";
        }  
        else{  
            echo  '<script>
                        window.location.href = "index.php";
                        alert("Login failed. Invalid username or password!!")
                    </script>';
        }    
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div id="main_header_body" >
        <h1 id="main_header"><a id="main_header_text" href="home.php">Main page</a></h1>
    </div>
    <form method="post">
        <div id="form_container">
            <h1 id="head_log">Login</h1>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="email"><br>
            <label>Password</label><br>
            <input type="password" id="password_user" name="password_user" placeholder="password"><br>
            <input type="submit" name="submit" id="submit" value="login">
        </div>
    </form>
</body>
</html>


