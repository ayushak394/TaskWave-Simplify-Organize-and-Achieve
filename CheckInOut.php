<?php
$servername = "localhost";
$username = "root";
$password = "yourpasswd"; 
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM checkinout";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dates = $_POST['date'];
    $employee_names = $_POST['employee_name'];
    $check_in_times = $_POST['check_in_time'];
    $check_out_times = $_POST['check_out_time'];
    $total_hours_worked = $_POST['total_hours_worked'];

    $stmt = $conn->prepare("INSERT INTO checkinout (date, employee_name, check_in_time, check_out_time, total_hours_worked) VALUES (?, ?, ?, ?, ?)");

    for ($i = 0; $i < count($dates); $i++) {
        $date = $dates[$i];
        $employee_name = $employee_names[$i];
        $check_in_time = $check_in_times[$i];
        $check_out_time = $check_out_times[$i];
        $hours_worked = $total_hours_worked[$i];

        $stmt->bind_param("sssss", $date, $employee_name, $check_in_time, $check_out_time, $hours_worked);

        if ($stmt->execute() === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $stmt->close();
}

$sql = "SELECT * FROM checkinout";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employee Check-in/Check-out Timings</title>
<style>
    body {
        background-image:url(ToDoBG.jpeg);
        background-repeat: no-repeat;
        background-size: cover;
        font-family: Arial, sans-serif; 
        font-size: 16zpx;
        color: #333;
    }
    table {
    width: 80%;
    margin-left: 18%; 
    position: absolute;
    top: 0; 
    border-collapse: collapse;
    color: black;
}
    th, td {
        border: 1px solid #ddd;
        text-align: left;
        padding: 8px;
        color: black;
        margin-left: 10px;
        
    }
    th {
        background-color: #f2f2f2;
        color: black;
    }

    .menu {
          background-color:none;
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

    .add-row-button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        margin-left: 100px; 
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    .add-row-button:hover {
        background-color: #45a049;
    }

    .submit-button {
        background-color: #4CAF50; 
        border: none;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin-left: 10px; 
        cursor: pointer;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }
    
    .submit-button:hover {
        background-color: #45a049; 
    }

    .button-container {
        text-align: center;
        margin-top: 20px; 
    }

    input[type="date"], input[type="text"], input[type="time"] {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        box-sizing: border-box;
    }

    .delete-button {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 10px;
        cursor: pointer;
    }

    .Logo {
            max-height: 200px;
            max-width: 200px;
            border-radius: 20px;
            margin-top: 20px;
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
        bottom: 20px; /* Adjusted bottom spacing */
        left: 20px; /* Adjusted left spacing */
        width: 12vw;;
    }
    

</style>
<script>
   function addRow() {
    var table = document.getElementById("timingsTable");
    var row = table.insertRow(-1); 
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5); 

    cell1.innerHTML = '<input type="date" name="date[]">';
    cell2.innerHTML = '<input type="text" placeholder="Employee Name" name="employee_name[]">';
    cell3.innerHTML = '<input type="time" name="check_in_time[]">';
    cell4.innerHTML = '<input type="time" name="check_out_time[]">';
    cell5.innerHTML = '<input type="text" readonly name="total_hours_worked[]">';

    var deleteButton = document.createElement("button");
    deleteButton.textContent = "Delete";
    deleteButton.onclick = function() {
        table.deleteRow(row.rowIndex);
        recalculateButtonMarginTop();
    };
    cell6.appendChild(deleteButton);
    
    var checkInInput = row.cells[2].querySelector('input[type="time"]');
    var checkOutInput = row.cells[3].querySelector('input[type="time"]');
    checkInInput.addEventListener('change', calculateHours);
    checkOutInput.addEventListener('change', calculateHours);

    calculateHours.call(checkInInput);

    recalculateButtonMarginTop();
}

function recalculateButtonMarginTop() {
    var table = document.getElementById("timingsTable");
    var buttonContainer = document.querySelector('.button-container');
    var marginTop = Math.max(table.clientHeight - 10, 0) + 'px'; 
    buttonContainer.style.marginTop = marginTop;
}

    function calculateHours() {
        var row = this.parentNode.parentNode;
        var checkIn = row.cells[2].querySelector('input[type="time"]').valueAsDate;
        var checkOut = row.cells[3].querySelector('input[type="time"]').valueAsDate;
        if (checkIn && checkOut) {
            var diff = checkOut.getTime() - checkIn.getTime();
            var hours = Math.floor(diff / (1000 * 60 * 60));
            var minutes = Math.floor((diff / (1000 * 60)) % 60);
            row.cells[4].querySelector('input').value = hours + ':' + (minutes < 10 ? '0' : '') + minutes;
        }
    }
</script>
</head>
<body>
<img src="Logo.png" class="Logo"></img>
   <div class="menu">
        <div class="menu">
        <a href="/Checkinout.php">Check In/Out</a>
        <a href="/Calendar.html">Calendar</a>
        <a href="/Notes.html">Notes</a>
        <a href="/ProgressReports.php">Progress Reports</a>
        <a href="/ToDo.html">To - Do List</a>
        <a href="/ContactUs.html">Contact Us</a>

    </div>
    </div>

<br>
<br>
<br>

<form method="post" action="">
    <table id="timingsTable" style="margin-top: 10px;">
        <tr>
            <th>Date</th>
            <th>Employee Name</th>
            <th>Check-in Time</th>
            <th>Check-out Time</th>
            <th>Total Hours Worked</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["date"] . "</td>";
                echo "<td>" . $row["employee_name"] . "</td>";
                echo "<td>" . $row["check_in_time"] . "</td>";
                echo "<td>" . $row["check_out_time"] . "</td>";
                echo "<td>" . $row["total_hours_worked"] . "</td>";
                echo "<td><button onclick='deleteRow(this)'>Delete</button></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

    <div class="button-container">
        <button type="button" class="add-row-button" onclick="addRow()">Add Row</button>
        <input type="submit" value="Submit" class="submit-button">
    </div>
</form>

<a href="/Login.html"><button class="logout">Logout</button></a>

</body>
</html>

<?php
$conn->close();
?>
