<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "yourpasswd";
$database = "project";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$eventDate = $_POST['eventDate'];
$eventDescription = $_POST['eventDescription'];

$sql_last_username = "SELECT username FROM login_history ORDER BY login_time DESC LIMIT 1";
$result_last_username = $conn->query($sql_last_username);

if ($result_last_username->num_rows > 0) {
    $row_last_username = $result_last_username->fetch_assoc();
    $username = $row_last_username['username'];

    $sql_insert_calendar = "INSERT INTO calendar (username, eventDate, eventDescription) VALUES (?, ?, ?)";
    $stmt_insert_calendar = $conn->prepare($sql_insert_calendar);
    $stmt_insert_calendar->bind_param("sss", $username, $eventDate, $eventDescription);

    if ($stmt_insert_calendar->execute()) {
        echo "<script>";
        echo "document.addEventListener('DOMContentLoaded', function() {";
        echo "var eventDescriptionElement = document.querySelector('.day[data-event-date=\"$eventDate\"] .event-description');";
        echo "eventDescriptionElement.textContent = \"$eventDescription\";";
        echo "});";
        echo "</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt_insert_calendar->close();
} else {
    echo "Error: Unable to fetch last inserted username";
}
