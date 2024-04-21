<?php
$servername = "localhost";
$username = "root";
$password = "yourpasswd";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT employee_name, total_hours_worked FROM checkinout";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array($row['employee_name'], (int)$row['total_hours_worked']);
    }
} else {
    echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head border-radius: 20px;>
    <meta charset="UTF-8">
    <title>Pie Chart</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Employee Name', 'Total Hours Worked'],
                <?php
                foreach ($data as $row) {
                    echo "['" . $row[0] . "', " . $row[1] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Total Hours Worked by each Employee',
                titleTextStyle: { 
                    fontSize: 20,
                    bold: true,
                    textAlign: 'center'
                },
                is3D: true,
                legend: {
                    position: 'bottom'
                },
                pieSliceText: 'label',
                slices: {
                    0: { color: '#3366cc' },
                    1: { color: '#dc3912' },
                    2: { color: '#ff9900' },
                    3: { color: '#109618' },
                    4: { color: '#990099' }
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</head>
<style>
.menu {
    background-color: none;
    overflow: hidden;
    position: fixed;
    height: 100vh;
    width: 15vw;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
    box-shadow: 2px 2px 4px white;
}

.menu a {
    display: block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.menu a:hover {
    background-color: #ddd;
    color: black;
    border-radius: 10px;
}

.Logo {
    max-height: 200px;
    max-width: 200px;
    border-radius: 20px;
    margin-top: 20px;
    margin-left: 7px;
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    background-color: #EFF1F3;
    position: relative;
    background-image: url(ToDoBG.jpeg);
    background-repeat: no-repeat;
    background-size: cover;
}

.logout {
    background-color: #4caf50;
    border: none;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    position: absolute;
    bottom: 20px;
    left: 20px;
    width: 12vw;;
}

</style>
<body>
<img src="Logo.png" class="Logo">

<div class="menu">
    <a href="/Checkinout.php">Check In/Out</a>
    <a href="/Calendar.html">Calendar</a>
    <a href="/Notes.html">Notes</a>
    <a href="/ProgressReports.php">Progress Reports</a>
    <a href="/ToDo.html">To-Do List</a>
    <a href="/ContactUs.html">Contact Us</a>
</div>

<div id="piechart" style="width: 900px; height: 500px; margin-top: 1%; margin-left: 25%; border-radius: 50px;"></div>

<a href="/Login.html"><button class="logout">Logout</button></a>

</body>
</html>
