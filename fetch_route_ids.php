<?php
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

// Fetch unique route IDs from the database
$sql = "SELECT DISTINCT Route_id FROM stop_details";
$result = $conn->query($sql);

$routeIDs = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $routeIDs[] = $row['Route_id'];
    }
}

// Close the database connection
$conn->close();

// Return route IDs as JSON
echo json_encode($routeIDs);

?>
