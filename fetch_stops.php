<?php

if (isset($_GET['route_id'])) {
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

    $routeID = $_GET['route_id'];

    // Fetch stops for the selected route ID from the database
    $sql = "SELECT DISTINCT Stop_Name FROM stop_details WHERE Route_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $routeID);
    $stmt->execute();
    $result = $stmt->get_result();

    $stops = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $stops[] = $row['Stop_Name'];
        }
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Return stops as JSON
    echo json_encode($stops);
} else {
    // If route ID is not provided, return an error message
    echo json_encode(['error' => 'Route ID is not provided']);
}

?>
