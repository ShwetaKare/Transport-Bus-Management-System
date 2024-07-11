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

// Define success message variable
$success_message = '';

// Handle form submission for adding new data
if(isset($_POST['submit_insert'])) {
    $bus_id = isset($_POST['bus_id']) ? $_POST['bus_id'] : null;
    $type = $_POST['type'];
    $bus_condition = $_POST['bus_condition'];
    
    if ($bus_id === null || $bus_id === '') {
        echo "Error: Bus ID cannot be empty";
        // You can choose to exit the script here or handle it differently based on your requirements
        exit();
    }

    $sql = "INSERT INTO bus_type (bus_id, type, bus_condition) VALUES ('$bus_id', '$type', '$bus_condition')";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Successful! Record inserted";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle form submission for editing data
if(isset($_POST['submit_edit'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $bus_condition = $_POST['bus_condition'];
    $sql = "UPDATE bus_type SET type='$type', bus_condition='$bus_condition' WHERE bus_id=$id";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Successful! Record updated";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle form submission for deleting data
if(isset($_POST['submit_delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM bus_type WHERE bus_id=$id";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Successful! Record deleted";
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
    <title>Manage Bus Type</title>
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

        form input[type="text"], input[type="submit"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #000;
            border-radius: 5px;
            background-color: #fff;
        }

        input[type="submit"] {
            background-color: green;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #fff;
            color: green;
            border: 1px solid green;
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

        td form input[type="submit"] {
            background-color: blue;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        td form input[type="submit"]:hover {
            background-color: #fff;
            color: blue;
            border: 1px solid blue;
        }

        td form:nth-child(2) input[type="submit"] {
            background-color: red;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        td form:nth-child(2) input[type="submit"]:hover {
            background-color: #fff;
            color: red;
            border:1px solid red;
        }

        .success-message {
            background-color: #d1fad8;
            padding: 10px;
            color: green;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 10px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php if(!empty($success_message)): ?>
    <div class="success-message">
        <?php echo $success_message; ?>
        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
    </div>
    <?php endif; ?>

    <!-- Add new data form -->
    <h2>Add New Bus Type</h2>
    <form method="post">
        <label for="bus_id">Bus ID:</label><br>
        <input type="text" id="bus_id" name="bus_id" required><br>
        <label for="type">Type:</label><br>
        <input type="text" id="type" name="type" required><br>
        <label for="bus_condition">Bus Condition:</label><br>
        <input type="text" id="bus_condition" name="bus_condition" required><br>
        <input type="submit" name="submit_insert" value="Insert">
    </form>

    <!-- Main table with edit and delete options -->
    <h2>Bus Types</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Bus Condition</th>
            <th>Actions</th>
        </tr>
        <?php
        // Fetch data from bus_type table
        $query = "SELECT * FROM bus_type";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['bus_id'] . "</td>";
                echo "<td>" . $row['type'] . "</td>";
                echo "<td>" . $row['bus_condition'] . "</td>";
                echo "<td>";
                // Edit form
                echo "<form method='post'>";
                echo "<input type='hidden' name='id' value='".$row['bus_id']."'>";
                echo "<input type='text' name='type' value='".$row['type']."'>";
                echo "<input type='text' name='bus_condition' value='".$row['bus_condition']."'>";
                echo "<input type='submit' name='submit_edit' value='Edit'>";
                echo "</form>";
                // Delete form
                echo "<form method='post'>";
                echo "<input type='hidden' name='id' value='".$row['bus_id']."'>";
                echo "<input type='submit' name='submit_delete' value='Delete'>";
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
