<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlog</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div id="a_body">
        <form method="post">
        <button name="register">register</button>
        </form>
        <a id="reg" href="register.php">Register</a>
        <a id="log" href="login.php">Login</a>
    </div>
</body>
</html>
<?php  

$reg = $_POST["register"];
echo $reg;

if (isset($_POST["register"])){
    include('register.php');
    echo "hello";
}

?>