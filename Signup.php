<?php
$servername = "localhost";
$username = "root";
$password = "yourpasswd"; 
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO signup (username, password, email, confirmpassword) VALUES ('$username', '$hashedPassword', '$email', '$confirmpassword')";

if ($conn->query($sql) === TRUE) {
    header("Location: /login.html");
    exit(); 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn = new mysqli($servername, $username, $password, $database);

$conn->close();

?>

