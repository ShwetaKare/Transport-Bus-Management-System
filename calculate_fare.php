<?php
// Establish connection to your database
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

// Get form data
$route_id = $_POST['route_id'];
$start_stop_name = $_POST['start_stop_name'];
$end_stop_name = $_POST['end_stop_name'];
$direction = $_POST['direction'];
$is_ac = isset($_POST['is_ac']) ? 1 : 0; // Convert checkbox value to boolean

// Execute the calculate_fare procedure
$stmt = $conn->prepare("CALL calculate_fare(?, ?, ?, ?, ?)");
$stmt->bind_param("isssi", $route_id, $start_stop_name, $end_stop_name, $direction, $is_ac);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the calculated fare
$row = $result->fetch_assoc();
$calculated_fare = $row['calculated_fare'];

// Close the database connection
$stmt->close();
$conn->close();

// Return the calculated fare as JSON
echo json_encode(['calculated_fare' => $calculated_fare]);
?>
