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
        $direction = $_POST['direction'];
        $stop_sequence = $_POST['stop_sequence'];
        $distance = $_POST['distance'];
        $cumulative_distance = $_POST['cumulative_distance'];
        $stop_id = $_POST['stop_id'];
        
        $sql = "INSERT INTO stop_distance (Route_id, Direction, Stop_Sequence, Distance, Cumulative_Distance, Stop_id) VALUES ('$route_id', '$direction', '$stop_sequence', '$distance', '$cumulative_distance', '$stop_id')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<div id='success_message'>New record created successfully <button onclick='removeSuccessMessage()'>X</button></div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Handle form submission for editing data
    if(isset($_POST['submit_edit'])) {
        $route_id = $_POST['route_id'];
        $direction = $_POST['direction'];
        $stop_sequence = $_POST['stop_sequence'];
        $distance = $_POST['distance'];
        $cumulative_distance = $_POST['cumulative_distance'];
        $stop_id = $_POST['stop_id'];
        
        $sql = "UPDATE stop_distance SET Route_id='$route_id', Direction='$direction', Stop_Sequence='$stop_sequence', Distance='$distance', Cumulative_Distance='$cumulative_distance' WHERE Stop_id=$stop_id";
        
        if ($conn->query($sql) === TRUE) {
            echo "<div id='success_message'>Record updated successfully <button onclick='removeSuccessMessage()'>X</button></div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Handle form submission for deleting data
    if(isset($_POST['submit_delete'])) {
        $stop_id = $_POST['stop_id'];
        $sql = "DELETE FROM stop_distance WHERE Stop_id=$stop_id";
        if ($conn->query($sql) === TRUE) {
            echo "<div id='success_message'>Record deleted successfully <button onclick='removeSuccessMessage()'>X</button></div>";
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
    <title>Manage Stop Distance</title>
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

        form input[type="text"], input[type="submit"] {
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #000;
            border-radius: 8px;
            background-color: #fff;
            width: 300px; /* Increased size for text inputs */
        }

        input[type="submit"] {
            cursor: pointer;
            border: none;
            border-radius: 8px;
            /* padding: 10px 2px; Increased padding for buttons */
            margin-right: 5px;
            width:25px
            color:white;
            background-color: green;
        }

        input[type="submit"]:hover {
            background-color: white;
            color: green;
            border: 1px solid green;
        }

        input[type="submit"].edit {
            background-color: blue;
            color: white;
        }

        input[type="submit"].delete {
            background-color: red;
            color: white;
        }

        input[type="submit"].edit:hover {
            background-color: white;
            color: blue;
            border: 1px solid blue;
        }

        input[type="submit"].delete:hover {
            background-color: white;
            color: red;
            border: 1px solid red;
        }

        table {
            border-collapse: collapse;
            width: 80%; /* Increased width of table */
            margin-top: 20px;
            background-color: #fff;
            border: 1px solid #000;
        }

        th {
            background-color: #000;
            color: #fff;
            padding: 12px;
            text-align: left;
        }

        th, td {
            border: 1px solid #000;
            padding: 10px; /* Increased padding for table cells */
        }

        #success_message {
            background-color: #d1fad8;
            padding: 12px;
            color: green;
            font-weight: bold;
            border-radius: 8px;
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
</head>
<body>

    <!-- Add new data form -->
    <h2>Add New Stop Distance</h2>
    <form method="post">
        <label for="route_id">Route ID:</label><br>
        <input type="text" id="route_id" name="route_id" required><br><br>
        <label for="direction">Direction:</label><br>
        <input type="text" id="direction" name="direction" required><br><br>
        <label for="stop_sequence">Stop Sequence:</label><br>
        <input type="text" id="stop_sequence" name="stop_sequence" required><br><br>
        <label for="distance">Distance:</label><br>
        <input type="text" id="distance" name="distance" required><br><br>
        <label for="cumulative_distance">Cumulative Distance:</label><br>
        <input type="text" id="cumulative_distance" name="cumulative_distance" required><br><br>
        <label for="stop_id">Stop ID:</label><br>
        <input type="text" id="stop_id" name="stop_id" required><br><br>
        <input type="submit" name="submit_insert" value="Insert">
    </form>

    <!-- Main table with edit and delete options -->
    <h2>Stop Distance </h2>
    <table border="1">
        <tr>
            <th>Route ID</th>
            <th>Direction</th>
            <th>Stop Sequence</th>
            <th>Distance</th>
            <th>Cumulative Distance</th>
            <th>Stop ID</th>
            <th>Actions</th>
        </tr>
        <?php
        // Fetch data from stop_distance table
        $query = "SELECT * FROM stop_distance";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Route_id'] . "</td>";
                echo "<td>" . $row['Direction'] . "</td>";
                echo "<td>" . $row['Stop_Sequence'] . "</td>";
                echo "<td>" . $row['Distance'] . "</td>";
                echo "<td>" . $row['Cumulative_Distance'] . "</td>";
                echo "<td>" . $row['Stop_id'] . "</td>";
                echo "<td>";
                // Edit form
                echo "<form method='post'>";
                echo "<input type='hidden' name='stop_id' value='".$row['Stop_id']."'>";
                echo "<input type='text' name='route_id' value='".$row['Route_id']."'>";
                echo "<input type='text' name='direction' value='".$row['Direction']."'>";
                echo "<input type='text' name='stop_sequence' value='".$row['Stop_Sequence']."'>";
                echo "<input type='text' name='distance' value='".$row['Distance']."'>";
                echo "<input type='text' name='cumulative_distance' value='".$row['Cumulative_Distance']."'>";
                echo "<input type='submit' name='submit_edit' value='Edit'>";
                echo "</form>";
                // Delete form
                echo "<form method='post'>";
                echo "<input type='hidden' name='stop_id' value='".$row['Stop_id']."'>";
                echo "<input type='submit' name='submit_delete' value='Delete'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No records found</td></tr>";
        }
        ?>
    </table>

    <script>
        function removeSuccessMessage() {
            var element = document.getElementById("success_message");
            element.parentNode.removeChild(element);
        }
    </script>
</body>
</html>

<?php
$conn->close(); // Close the connection
?>
