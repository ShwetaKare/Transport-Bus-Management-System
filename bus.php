<?php
// Connect to the database
$servername = "192.168.177.165";
$username = "root";
$password = "shweta123";
$database = "shweta";
$port = 3307;
$conn = new mysqli($servername, $username, $password, $database, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding new data
if(isset($_POST['submit_insert'])) {
    $bus_id = $_POST['bus_id'];
    $route_id = $_POST['route_id'];
    $schedule = $_POST['schedule'];
    $sql = "INSERT INTO bus (bus_id, Route_id, schedule) VALUES ('$bus_id', '$route_id', '$schedule')";
    if ($conn->query($sql) === TRUE) {
        echo "<div id='success_message' style='background-color: #d1fad8; padding: 10px;'><b style='color: green;'>Successful!</b> Record inserted successfully <button onclick='removeSuccessMessage()'>X</button></div>";
    } else {
        echo "<div style='background-color: #d1fad8; padding: 10px;'><b style='color: red;'>Error:</b> " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Handle form submission for updating data
if(isset($_POST['submit_update'])) {
    $route_id = $_POST['route_id'];
    $new_bus_id = $_POST['new_bus_id']; // Updated bus_id
    $new_schedule = $_POST['new_schedule']; // Updated schedule

    // Update the record based on Route_id
    $sql = "UPDATE bus SET bus_id='$new_bus_id', schedule='$new_schedule' WHERE Route_id='$route_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<div id='success_message' style='background-color: #d1fad8; padding: 10px;'><b style='color: green;'>Successful!</b> Record updated successfully <button onclick='removeSuccessMessage()'>X</button></div>";
    } else {
        echo "<div style='background-color: #d1fad8; padding: 10px;'><b style='color: red;'>Error:</b> " . $conn->error . "</div>";
    }
}

// Handle form submission for deleting data
if(isset($_POST['submit_delete'])) {
    $route_id = $_POST['route_id'];
    $sql = "DELETE FROM bus WHERE Route_id='$route_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<div id='success_message' style='background-color: red; padding: 10px;'><b style='color: white;'>Successful!</b> Record deleted successfully <button onclick='removeSuccessMessage()'>X</button></div>";
    } else {
        echo "<div style='background-color: #d1fad8; padding: 10px;'><b style='color: red;'>Error:</b> " . $conn->error . "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bus Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 20px; /* Added margin */
            padding: 0;
        }

        h2 {
            margin-top: 20px;
        }

        form input[type="text"],
        input[type="submit"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #fff;
        }

        input[type="submit"] {
            border: none;
            cursor: pointer;
        }

        input[type="submit"].insert-button {
            background-color: green;
            color: #fff;
        }

        input[type="submit"].insert-button:hover {
            background-color: #fff;
            color: green;
            border: 1px solid green;
        }

        input[type="submit"].edit-button {
            background-color: blue;
            color: #fff;
        }

        input[type="submit"].edit-button:hover {
            background-color: #fff;
            color: blue;
            border: 1px solid blue;
        }

        input[type="submit"].delete-button {
            background-color: red;
            color: #fff;
        }

        input[type="submit"].delete-button:hover {
            background-color: #fff;
            color: red;
            border: 1px solid red;
        }

        table {
            border-collapse: collapse;
            width: 70%; /* Limited width */
            margin-top: 20px;
            background-color: #fff;
            border: 1px solid #000;
        }

        th {
            background-color: #000;
            color: #fff;
            padding: 10px;
            text-align: left;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
    <script>
        function removeSuccessMessage() {
            var element = document.getElementById("success_message");
            element.parentNode.removeChild(element);
        }
    </script>
</head>
<body>
    <!-- Add, Update, Delete form -->
    <h2>Add, Update, or Delete Bus Schedule</h2>
    <form method="post">
        <label for="bus_id">Bus ID:</label><br>
        <input type="text" id="bus_id" name="bus_id" required><br><br>
        <label for="route_id">Route ID:</label><br>
        <input type="text" id="route_id" name="route_id" required><br><br>
        <label for="schedule">Schedule:</label><br>
        <input type="text" id="schedule" name="schedule" required><br><br>
        <input type="submit" name="submit_insert" class="insert-button" value="Insert">
    </form>

    <!-- Table to display existing data -->
    <h2>Bus Schedules</h2>
    <table border="1">
        <tr>
            <th>Bus ID</th>
            <th>Route ID</th>
            <th>Schedule</th>
            <th>Actions</th>
        </tr>
        <?php
        // Fetch data from bus table
        $query = "SELECT * FROM bus";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>";
                // Edit form for route_id and schedule
                echo "<form method='post'>";
                echo "<input type='hidden' name='route_id' value='".$row['Route_id']."'>";
                echo "<input type='text' name='new_bus_id' value='".$row['bus_id']."'>";
                echo "</td>";
                echo "<td>" . $row['Route_id'] . "</td>";
                echo "<td>" . $row['schedule'] . "</td>";
                echo "<td>";
                // Edit form
                echo "<input type='text' name='new_schedule' value='".$row['schedule']."'>";
                echo "<input type='submit' name='submit_update' class='edit-button' value='Edit'>";
                echo "</form>";
                // Delete form
                echo "<form method='post'>";
                echo "<input type='hidden' name='route_id' value='".$row['Route_id']."'>";
                echo "<input type='submit' name='submit_delete' class='delete-button' value='Delete'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close(); // Close the connection
?>
