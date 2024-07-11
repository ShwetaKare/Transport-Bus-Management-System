<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stops</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #ffffff;
            background-image: url('assets\\bus3.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0 auto; /* Center the list */
            width: fit-content; /* Adjust width as needed */
        }
        h1 {
            text-align: center;
            color: black; /* Change title color to black */
        }
        li.stop {
            background-color: rgba(0, 0, 0, 0.5); /* Background color with opacity */
            padding: 10px; /* Adjust padding as needed */
            margin-bottom: 5px; /* Adjust margin as needed */
            border-radius: 5px; /* Rounded corners */
            text-align: center;
            font-weight: bold;
        }
        li.arrow {
            color: black;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php
// Check if the route ID is provided in the URL
if(isset($_GET['routeID'])) {
    // Retrieve the route ID from the URL
    $routeID = $_GET['routeID'];

    // Connect to your database
    $servername = "192.168.177.165";
    $username = "root";
    $password = "shweta123";
    $database = "shweta";
    $port = 3307;
    $conn = new mysqli($servername, $username, $password, $database, $port);
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch stop names in order of stop sequence for the given route ID and direction
    $sql = "SELECT Stop_Name FROM stop_details WHERE Route_id = '$routeID' AND Direction = 'UP' ORDER BY Stop_Sequence";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        echo "<h1>Stops</h1>";
        echo "<ul>";
        $num_rows = $result->num_rows;
        $counter = 0;
        while($row = $result->fetch_assoc()) {
            $counter++;
            echo "<li class='stop'>" . $row["Stop_Name"] . "</li>";
            // Check if it's not the last stop
            if ($counter < $num_rows) {
                echo "<li class='arrow'><span>&#8595;</span></li>"; // Add downward arrow after each stop
            }
        }
        echo "</ul>";
    } else {
        echo "<p style='text-align:center;'>No stop names found for this route.</p>";
    }

    // Close the database connection
    $conn->close();
} else {
    // If route ID is not provided in the URL
    echo "<p style='text-align:center;'>Route ID not provided.</p>";
}
?>

</body>
</html>
