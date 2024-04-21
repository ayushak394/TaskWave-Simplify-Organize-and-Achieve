<?php
$servername = "localhost";
$username = "root";
$password = "yourpasswd"; 
$database = "project";
$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT username, password FROM signup WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
   
    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];
    

    if (password_verify($password, $hashedPassword)) {
    
        $login_time = date('Y-m-d H:i:s');
        $sql_insert_login = "INSERT INTO login_history (username) VALUES (?) ON DUPLICATE KEY UPDATE login_time = ?";
        $stmt_insert_login = $conn->prepare($sql_insert_login);
        $stmt_insert_login->bind_param("ss", $username, $login_time);
        $stmt_insert_login->execute();

       
        header("Location: /Checkinout.php");
        exit(); 
    } else {
    
        header("Location: /usernotf.html");
        exit(); 
    }
}


$stmt->close();
$stmt_insert_login->close();
$conn->close();
?>
