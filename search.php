<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Search bar styles */
        #searchBarContainer {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            background-color: #ffffff; /* White background */
            border: 2px solid #000000; /* Black border */
            border-radius: 5px; /* Rounded corners */
            margin-bottom: 20px; /* Add some space below the search bar */
        }

        #searchBar {
            width: calc(100% - 20px); /* Subtract padding from the width */
            padding: 8px;
            border: none;
            outline: none;
            font-size: 16px;
            border-radius: 5px;
        }

        /* Route options styles */
        #routeDetails {
            width: 100%;
        }

        #routeDetails ul {
            list-style: none;
            padding: 0;
        }

        #routeDetails ul li {
            margin-bottom: 10px;
        }

        #routeDetails ul li button {
            background-color: #ffffff; /* White background */
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s; /* Smooth transition */
        }

        #routeDetails ul li button:hover {
            background-color: #f0f0f0; /* Lighten background on hover */
        }
    </style>
</head>
<body>
    <!-- Search bar -->
    <div id="searchBarContainer">
        <input type="text" id="searchBar" placeholder="Search for Route">
    </div>

    <!-- Content to display route details -->
    <div id="routeDetails"></div>

    <script>
       // Function to fetch route details based on input
function fetchRouteDetails(input) {
    // Perform AJAX request to fetch route details
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var routeDetails = JSON.parse(this.responseText);
            displayRouteDetails(routeDetails);
        }
    };
    xhr.open("GET", "fetch_route_details.php?route=" + input, true);
    xhr.send();
}

// Function to display route details
function displayRouteDetails(routeDetails) {
    var routeDetailsDiv = document.getElementById("routeDetails");
    routeDetailsDiv.innerHTML = ""; // Clear previous results

    if (routeDetails.length === 0) {
        routeDetailsDiv.innerHTML = "<p>No matching routes found.</p>";
    } else {
        var html = "<ul>";
        routeDetails.forEach(function(route) {
            html += "<li>";
            html += "<button onclick='window.location=\"stops.php?routeID=" + route.Route_id + "\"'>";
            html += route.From_location + " - " + route.To_location;
            html += "</button>";
            // Display bus condition and schedule
            html += "<span> " + route.bus_condition + "</span>" +"\t\t";
            html += "<span>" + route.schedule + "</span>";
            html += "</li>";
        });
        html += "</ul>";
        routeDetailsDiv.innerHTML = html;
    }
}

// Add event listener to the search bar for input events
var searchBar = document.getElementById("searchBar");
searchBar.addEventListener("input", function() {
    var input = searchBar.value.trim();
    if (input.length > 0) {
        fetchRouteDetails(input);
    } else {
        // Clear route details if input is empty
        var routeDetailsDiv = document.getElementById("routeDetails");
        routeDetailsDiv.innerHTML = "";
    }
});

// Set focus on the search bar when the page loads
window.onload = function() {
    searchBar.focus();
};

    </script>
</body>
</html>
