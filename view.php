<?php
// Check if a table is selected
if(isset($_POST['selected_table'])) {
    $servername = "192.168.177.165";
    $username = "root";
    $password = "shweta123";
    $database = "shweta"; 
    $port = 3307; 
    
    // Creating connection
    $conn = new mysqli($servername, $username, $password, $database, $port);
    
    // Checking connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    // Define table names and their corresponding titles
    $table_titles = array(
        "bus_type" => "Bus Types",
        "routes" => "Routes",
        "bus" => "Buses",
        "stop_details" => "Stop Details",
        "stop_distance" => "Stop Distance"
        // Add more mappings for other tables as needed
    );

    $selected_table = $_POST['selected_table'];
    
    // Get the title for the selected table
    $table_title = isset($table_titles[$selected_table]) ? $table_titles[$selected_table] : $selected_table;
    
    // Query to select all data from the selected table
    $query = "SELECT * FROM $selected_table";
    
    // Execute the query
    $result = $conn->query($query);
    
    if($result) {
        // Display the table name
        echo "<h2>$table_title</h2>";

        // Button to add new data
        // Map table names to corresponding PHP files for adding new data
        $add_new_data_links = array(
            "bus" => "bus.php",
            "bus_type" => "bus_type.php",
            "routes" => "routes.php",
            "stop_details" => "stop_details.php",
            "stop_distance" => "stop_distance.php"
            // Add more mappings for other tables as needed
        );

        // Check if the selected table has a corresponding PHP file for adding new data
        if(array_key_exists($selected_table, $add_new_data_links)) {
            $add_new_data_link = $add_new_data_links[$selected_table];
            echo "<button onclick=\"location.href='$add_new_data_link?table=$selected_table'\" class=\"hover-white\" style=\"background-color: black; color: white; padding: 10px; border: 1px solid black; border-radius: 5px; cursor: pointer; margin-bottom: 20px;\"><i class=\"fas fa-plus\"></i> Add New Data</button>";
        } else {
            echo "No PHP file found for adding new data to this table.";
        }

        // Button to print table
        echo "<button onclick=\"location.href='print_table.php?table=$selected_table'\" class=\"hover-white\" style=\"background-color: black; color: white; padding: 10px; border: 1px solid black; border-radius: 5px; cursor: pointer; margin-bottom: 20px; margin-left: 10px;\"><i class=\"fas fa-print\"></i> Print Table</button>";

        // Display the table contents
        echo "<table border='1' style='border-collapse: collapse; width: 50%; margin: 0 auto;'>";
        // Display table headers
        echo "<tr>";
        while ($fieldinfo = $result->fetch_field()) {
            echo "<th style='background-color: black; color: white; padding: 10px;'>{$fieldinfo->name}</th>";
        }
        echo "</tr>";
        // Display table rows
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td style='border: 1px solid black; padding: 10px;'>{$value}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close(); // Close the connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .hover-white:hover {
            background-color: white !important;
            color: black !important;
        }
    </style>
</head>
<body>
    <button onclick="location.href='dashboard.php'" class="hover-white" style="background-color: black; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; position: fixed; bottom: 20px; left: 20px;"><i class="fas fa-home"></i> Back to Home</button>
</body>
</html>
