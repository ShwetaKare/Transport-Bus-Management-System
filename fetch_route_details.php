<?php
// Establish a connection to your database
$servername = "192.168.177.165";
$username = "root";
$password = "shweta123";
$database = "shweta";
$port = 3307;
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch route details based on the input received from the client-side
$input = $_GET['route'];

// Perform a database query to find matching routes
$sql = "SELECT * FROM bus_info_view WHERE Route LIKE '%$input%'"; // Assuming 'Route' is the column in your database table containing route names

$result = $conn->query($sql);

// Prepare the result as JSON
$routeDetails = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $routeDetails[] = $row;
    }
}

// Output the route details as JSON
echo json_encode($routeDetails);

// Close the database connection
$conn->close();
?>