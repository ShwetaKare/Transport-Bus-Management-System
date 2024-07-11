<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .hover-white:hover {
            background-color: white !important;
            color: black !important;
            border: 1px solid black;
        }
        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <button onclick="window.print()" class="hover-white" style="background-color: black; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">Print Table</button>
    </div>

    <?php
    // Check if a table is selected
    if(isset($_GET['table'])) {
        $table = $_GET['table'];
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
        
        // Query to select all data from the selected table
        $query = "SELECT * FROM $table";
        
        // Execute the query
        $result = $conn->query($query);
        
        if($result) {
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
</body>
</html>
