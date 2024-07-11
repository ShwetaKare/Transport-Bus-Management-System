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
    $stop_id = $_POST['stop_id'];
    $route_id = $_POST['route_id'];
    $direction = $_POST['direction'];
    $stop_sequence = $_POST['stop_sequence'];
    $stop_name = $_POST['stop_name'];
    $stop_number = $_POST['stop_number'];
    
    $sql = "INSERT INTO stop_Details (Stop_id, Route_id, Direction, Stop_Sequence, Stop_Name, Stop_Number) VALUES ('$stop_id', '$route_id', '$direction', '$stop_sequence', '$stop_name', '$stop_number')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div id='success_message'>New record created successfully</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle form submission for editing data
if(isset($_POST['submit_edit'])) {
    $id = $_POST['id'];
    $stop_id = $_POST['stop_id'];
    $route_id = $_POST['route_id'];
    $direction = $_POST['direction'];
    $stop_sequence = $_POST['stop_sequence'];
    $stop_name = $_POST['stop_name'];
    $stop_number = $_POST['stop_number'];
    
    $sql = "UPDATE stop_Details SET Stop_id='$stop_id', Route_id='$route_id', Direction='$direction', Stop_Sequence='$stop_sequence', Stop_Name='$stop_name', Stop_Number='$stop_number' WHERE Stop_id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div id='success_message'>Record updated successfully</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle form submission for deleting data
if(isset($_POST['submit_delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM stop_Details WHERE Stop_id=$id";
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
    <title>Manage Stop Details</title>
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
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #fff;
        }

        input[type="submit"] {
            cursor: pointer;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin-right: 10px;
            background-color: green;
            color: white;
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
    <h2>Add New Stop Details</h2>
    <form method="post">
        <label for="stop_id">Stop ID:</label><br>
        <input type="text" id="stop_id" name="stop_id" required><br><br>
        <label for="route_id">Route ID:</label><br>
        <input type="text" id="route_id" name="route_id" required><br><br>
        <label for="direction">Direction:</label><br>
        <input type="text" id="direction" name="direction" required><br><br>
        <label for="stop_sequence">Stop Sequence:</label><br>
        <input type="text" id="stop_sequence" name="stop_sequence" required><br><br>
        <label for="stop_name">Stop Name:</label><br>
        <input type="text" id="stop_name" name="stop_name" required><br><br>
        <label for="stop_number">Stop Number:</label><br>
        <input type="text" id="stop_number" name="stop_number" required><br><br>
        <input type="submit" name="submit_insert" value="Insert">
    </form>

    <!-- Main table with edit and delete options -->
    <h2>Stop Details</h2>
    <table border="1">
        <tr>
            <th>Stop ID</th>
            <th>Route ID</th>
            <th>Direction</th>
            <th>Stop Sequence</th>
            <th>Stop Name</th>
            <th>Stop Number</th>
            <th>Actions</th>
        </tr>
        <?php
        // Fetch data from stop_Details table
        $query = "SELECT * FROM stop_Details";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Stop_id'] . "</td>";
                echo "<td>" . $row['Route_id'] . "</td>";
                echo "<td>" . $row['Direction'] . "</td>";
                echo "<td>" . $row['Stop_Sequence'] . "</td>";
                echo "<td>" . $row['Stop_Name'] . "</td>";
                echo "<td>" . $row['Stop_Number'] . "</td>";
                echo "<td>";
                // Edit form
                echo "<form method='post'>";
                echo "<input type='hidden' name='id' value='".$row['Stop_id']."'>";
                echo "<input type='text' name='stop_id' value='".$row['Stop_id']."'>";
                echo "<input type='text' name='route_id' value='".$row['Route_id']."'>";
                echo "<input type='text' name='direction' value='".$row['Direction']."'>";
                echo "<input type='text' name='stop_sequence' value='".$row['Stop_Sequence']."'>";
                echo "<input type='text' name='stop_name' value='".$row['Stop_Name']."'>";
                echo "<input type='text' name='stop_number' value='".$row['Stop_Number']."'>";
                echo "<input type='submit' class='edit' name='submit_edit' value='Edit'>";
                echo "</form>";
                // Delete form
                echo "<form method='post'>";
                echo "<input type='hidden' name='id' value='".$row['Stop_id']."'>";
                echo "<input type='submit' class='delete' name='submit_delete' value='Delete'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No records found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close(); // Close the connection
?>
