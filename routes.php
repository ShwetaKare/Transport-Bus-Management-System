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
    $route_id = $_POST['route_id'];
    $route = $_POST['route'];
    $no_of_buses = $_POST['no_of_buses'];
    $from_location = $_POST['from_location'];
    $first_from = $_POST['first_from'];
    $last_from = $_POST['last_from'];
    $to_location = $_POST['to_location'];
    $first_to = $_POST['first_to'];
    $last_to = $_POST['last_to'];
    
    // Check for empty fields
    if ($route_id === null || $route_id === '') {
        echo "<span class='error'>Error: Route ID cannot be empty</span><br>";
        exit(); // Stop execution if Route ID is empty
    }
    if ($no_of_buses === null || $no_of_buses === '') {
        echo "<span class='error'>Error: Number of Buses cannot be empty</span><br>";
        exit(); // Stop execution if Number of Buses is empty
    }

    $sql = "INSERT INTO routes (Route_id, Route, no_of_Buses, From_location, first_from, last_from, To_location, first_to, last_to) 
            VALUES ('$route_id', '$route', '$no_of_buses', '$from_location', '$first_from', '$last_from', '$to_location', '$first_to', '$last_to')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div id='success_message'><b>Successful!</b> Record inserted successfully <button onclick='removeSuccessMessage()'>X</button></div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle form submission for editing data
if(isset($_POST['submit_edit'])) {
    $id = $_POST['id'];
    $route = $_POST['route'];
    $no_of_buses = $_POST['no_of_buses'];
    $from_location = $_POST['from_location'];
    $first_from = $_POST['first_from'];
    $last_from = $_POST['last_from'];
    $to_location = $_POST['to_location'];
    $first_to = $_POST['first_to'];
    $last_to = $_POST['last_to'];
    
    $sql = "UPDATE routes SET Route='$route', no_of_Buses='$no_of_buses', From_location='$from_location', first_from='$first_from', last_from='$last_from', 
            To_location='$to_location', first_to='$first_to', last_to='$last_to' WHERE Route_id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div id='success_message'><b>Successful!</b> Record updated successfully <button onclick='removeSuccessMessage()'>X</button></div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle form submission for deleting data
if(isset($_POST['submit_delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM routes WHERE Route_id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<div id='success_message'><b>Successful!</b> Record deleted successfully <button onclick='removeSuccessMessage()'>X</button></div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Routes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 20px;
            padding: 0;
        }

        h2 {
            margin-top: 20px;
        }

        form input[type="text"], input[type="submit"], input[type="time"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #fff;
        }

        input[type="submit"] {
            cursor: pointer;
            border: none;
            color:white;
            background-color:green;
            border-radius: 5px;
            padding: 10px 20px;
            margin-right: 10px;
        }

        input[type="submit"]:hover {
            background-color: white;
            color: green;
            border: 1px solid green;
        }

        input[type="submit"].edit {
            background-color: #008CBA;
            color:white
        }

        input[type="submit"].delete {
            background-color: red;
            color:white;
        }
        input[type="submit"].edit:hover {
            background-color: white;
            color:blue;
            border: 1px solid blue;
        }

        input[type="submit"].delete:hover {
            background-color: white;
            color:red;
            border: 1px solid red;
        }

        table {
            border-collapse: collapse;
            width: 70%;
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

        #success_message {
            background-color: #d1fad8;
            padding: 10px;
            color: green;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 10px;
            position: relative;
        }

        #success_message button {
            background-color: transparent;
            border: none;
            color: green;
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
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
    <!-- Add new data form -->
    <h2>Add New Route</h2>
    <form method="post">
        <label for="route_id">Route ID:</label><br>
        <input type="text" id="route_id" name="route_id" required><br><br>
        <label for="route">Route:</label><br>
        <input type="text" id="route" name="route" required><br><br>
        <label for="no_of_buses">Number of Buses:</label><br>
        <input type="text" id="no_of_buses" name="no_of_buses" required><br><br>
        <label for="from_location">From Location:</label><br>
        <input type="text" id="from_location" name="from_location" required><br><br>
        <label for="first_from">First Departure Time:</label><br>
        <input type="time" id="first_from" name="first_from" required><br><br>
        <label for="last_from">Last Departure Time:</label><br>
        <input type="time" id="last_from" name="last_from" required><br><br>
        <label for="to_location">To Location:</label><br>
        <input type="text" id="to_location" name="to_location" required><br><br>
        <label for="first_to">First Arrival Time:</label><br>
        <input type="time" id="first_to" name="first_to" required><br><br>
        <label for="last_to">Last Arrival Time:</label><br>
        <input type="time" id="last_to" name="last_to" required><br><br>
        <input type="submit" name="submit_insert" value="Insert">
    </form>

    <!-- Main table with edit and delete options -->
    <h2>Routes</h2>
    <table border="1">
        <tr>
            <th>Route ID</th>
            <th>Route</th>
            <th>Number of Buses</th>
            <th>From Location</th>
            <th>First Departure Time</th>
            <th>Last Departure Time</th>
            <th>To Location</th>
            <th>First Arrival Time</th>
            <th>Last Arrival Time</th>
            <th>Actions</th>
        </tr>
        <?php
        // Fetch data from routes table
        $query = "SELECT * FROM routes";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Route_id'] . "</td>";
                echo "<td>" . $row['Route'] . "</td>";
                echo "<td>" . $row['no_of_Buses'] . "</td>";
                echo "<td>" . $row['From_location'] . "</td>";
                echo "<td>" . $row['first_from'] . "</td>";
                echo "<td>" . $row['last_from'] . "</td>";
                echo "<td>" . $row['To_location'] . "</td>";
                echo "<td>" . $row['first_to'] . "</td>";
                echo "<td>" . $row['last_to'] . "</td>";
                echo "<td>";
                // Edit form
                echo "<form method='post'>";
                echo "<input type='hidden' name='id' value='".$row['Route_id']."'>";
                echo "<input type='text' name='route' value='".$row['Route']."'>";
                echo "<input type='text' name='no_of_buses' value='".$row['no_of_Buses']."'>";
                echo "<input type='text' name='from_location' value='".$row['From_location']."'>";
                echo "<input type='time' name='first_from' value='".$row['first_from']."'>";
                echo "<input type='time' name='last_from' value='".$row['last_from']."'>";
                echo "<input type='text' name='to_location' value='".$row['To_location']."'>";
                echo "<input type='time' name='first_to' value='".$row['first_to']."'>";
                echo "<input type='time' name='last_to' value='".$row['last_to']."'>";
                echo "<input type='submit' class='edit' name='submit_edit' value='Edit'>";
                echo "</form>";
                // Delete form
                echo "<form method='post'>";
                echo "<input type='hidden' name='id' value='".$row['Route_id']."'>";
                echo "<input type='submit' class='delete' name='submit_delete' value='Delete'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No records found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
