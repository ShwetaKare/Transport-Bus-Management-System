<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            display: flex;
            padding:150px;
            background-attachment:fixed;
            background-image: url('assets\\bus2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
            }
        #searchBarContainer {
            background-color: white;
            width: calc(100%);
            position: fixed;
            top: 0;
            left: 250px;
            z-index: 1;
        }
        #searchBar {
            border: 1px solid black;
            border-radius: 5px;
            width: 100%;
            max-width: 1000px;
            height: 40px;
            font-weight:bold;
            color:black;
            
        }

        #container {
            width: 200px;
            background-color: orange;
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }
        #container h1 {
            color: white;
        }
        #tables {
            margin-top: 20px;
        }
        #tables label {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        #tables label:hover {
            background-color: white;
            color: #007bff;
        }
        #tables input[type="radio"] {
            display: none;
        }
        #tables i {
            margin-right: 5px;
        }
        #content {
            position: absolute;
            top: -10px;
            left: 200px;
            text-align: left;
            padding: 50px;
            margin-left: 0;
        }
        #showBuyTicketForm {
            display: block;
            background-color: #007bff;
            color: white;
            font-size: 18px;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-bottom: 20px;
        }
        #showBuyTicketForm:hover {
            background-color: #0056b3;
        }
        #buyTicketForm {
            display: none;
            margin-top: 50px;
        }
        #buyTicketForm select,
        #buyTicketForm input[type="text"] {
            width: calc(100% - 30px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid black;
            border-radius: 5px;
            background-color: white;
            box-sizing: border-box;
        }
        #buyTicketForm select:hover,
        #buyTicketForm input[type="text"]:hover {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }
        #buyTicketForm button {
            width: 100%;
            background-color: #007bff;
            color: white;
            font-size: 18px;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        #buyTicketForm button:hover {
            background-color: #0056b3;
        }
        #ticket {
            display: none;
        }
        #printTicketBtn {
            display: none;
            width: 100%;
            background-color: #28a745;
            color: white;
            font-size: 18px;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        #printTicketBtn:hover {
            background-color: #218838;
        }
        #fareResult {
            display: none;
        }
    </style>
</head>
<body>
    <div id="searchBarContainer">
        <input type="text" id="searchBar" placeholder="Enter Route">
    </div>
    <div id="container">
        <h1 id="dashboard"></h1>
        <img src="assets\buslogo.png" alt="Login Logo">

        <form action="dashboard.php" method="post" id="tables">
            <label for="dashboard_option">
                <input type="radio" id="dashboard_option" name="selected_table" value="dashboard" checked>
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </label>
            <?php
                $tables_with_titles = array(
                    "bus_type" => "Bus Types",
                    "routes" => "Routes",
                    "bus" => "Buses",
                    "stop_details" => "Stop Details",
                    "stop_distance" => "Stop Distance"
                );

                foreach ($tables_with_titles as $table_name => $table_title) {
                    echo "<label for='$table_name'>";
                    echo "<input type='radio' id='$table_name' name='selected_table' value='$table_name'>";
                    echo "<i class='fas fa-table'></i> $table_title";
                    echo "</label>";
                }
            ?>
        </form>
    </div>
    <div id="content">
        <h1>Welcome!</h1>
        <div id="tableContent">
            <!-- Dashboard content will be loaded here -->
        </div>
        <button id="showBuyTicketForm">Buy Ticket Here</button>
        <form id="buyTicketForm">
            <h2>Buy Ticket</h2>
            <label for="route_id">Route ID:</label>
            <select id="route_id" name="route_id" required>
                <!-- Route IDs will be loaded dynamically here -->
            </select>
            <label for="start_stop_name">Start Stop Name:</label>
            <select id="start_stop_name" name="start_stop_name" required>
                <!-- Start stop names will be loaded dynamically here -->
            </select>
            <label for="end_stop_name">End Stop Name:</label>
            <select id="end_stop_name" name="end_stop_name" required>
                <!-- End stop names will be loaded dynamically here -->
            </select>
            <label for="direction">Direction:</label>
            <input type="text" id="direction" name="direction" required>
            <label for="is_ac">AC:</label>
            <input type="checkbox" id="is_ac" name="is_ac">
            <button type="submit">Calculate Fare</button>
        </form>
        <div id="ticket">
            <h2>Ticket</h2>
            <p>Date: <span id="ticketDate"></span></p>
            <p>Time: <span id="ticketTime"></span></p>
            <p>Start Stop: <span id="ticketStartStop"></span></p>
            <p>End Stop: <span id="ticketEndStop"></span></p>
            <p>Route ID: <span id="ticketRouteID"></span></p>
            <p>Route Name: <span id="ticketRouteName"></span></p>
            <p>Direction: <span id="ticketDirection"></span></p>
            <p>AC: <span id="ticketAC"></span></p>
            <p>Fare: <span id="ticketFare"></span></p>
        </div>
        <div id="fareResult"></div>
        <button id="printTicketBtn">Print Ticket</button>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"></script>
    <script>
        document.getElementById('searchBar').addEventListener('click', function() {
            window.location.href = 'search.php';
        });

        function displayTable(tableName) {
            if (tableName === 'dashboard') {
                document.getElementById('tableContent').innerHTML = '<p></p>';
                document.getElementById('showBuyTicketForm').style.display = 'block';
                document.getElementById('buyTicketForm').style.display = 'none';
                document.getElementById('fareResult').style.display = 'block';
                document.getElementById('searchBarContainer').style.display = 'block';
                document.body.style.backgroundImage = 'block';
            } else {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('tableContent').innerHTML = this.responseText;
                        document.getElementById('showBuyTicketForm').style.display = 'none';
                        document.getElementById('buyTicketForm').style.display = 'none';
                        document.getElementById('fareResult').style.display = 'none';
                        document.getElementById('ticket').style.display = 'none';
                        document.getElementById('printTicketBtn').style.display = 'none';
                        document.getElementById('searchBarContainer').style.display = 'none';
                    }
                };
                xhttp.open("POST", "view.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("selected_table=" + tableName);
            }
        }

        var radios = document.querySelectorAll('input[type=radio][name=selected_table]');
        radios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                displayTable(this.value);
            });
        });

        displayTable('dashboard');

        function fetchRouteIDs() {
            fetch('fetch_route_ids.php')
            .then(response => response.json())
            .then(data => {
                const routeDropdown = document.getElementById('route_id');
                routeDropdown.innerHTML = '';
                data.forEach(routeID => {
                    const option = document.createElement('option');
                    option.value = routeID;
                    option.textContent = routeID;
                    routeDropdown.appendChild(option);
                });
                routeDropdown.dispatchEvent(new Event('change'));
            })
            .catch(error => console.error('Error:', error));
        }

        function fetchStops(routeID) {
            fetch('fetch_stops.php?route_id=' + routeID)
            .then(response => response.json())
            .then(data => {
                const startStopDropdown = document.getElementById('start_stop_name');
                const endStopDropdown = document.getElementById('end_stop_name');
                startStopDropdown.innerHTML = '';
                endStopDropdown.innerHTML = '';
                data.forEach(stop => {
                    const startOption = document.createElement('option');
                    startOption.value = stop;
                    startOption.textContent = stop;
                    startStopDropdown.appendChild(startOption);

                    const endOption = document.createElement('option');
                    endOption.value = stop;
                    endOption.textContent = stop;
                    endStopDropdown.appendChild(endOption);
                });
            })
            .catch(error => console.error('Error:', error));
        }

        document.getElementById('route_id').addEventListener('change', function() {
            const routeID = this.value;
            fetchStops(routeID);
        });

        document.getElementById('buyTicketForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('calculate_fare.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('fareResult').innerHTML = '<p>Calculated fare: $' + data.calculated_fare + '</p>';
                document.getElementById('printTicketBtn').style.display = 'block';

                sessionStorage.setItem('ticketInfo', JSON.stringify({
                    date: new Date().toLocaleDateString(),
                    time: new Date().toLocaleTimeString(),
                    start_stop: document.getElementById('start_stop_name').value,
                    end_stop: document.getElementById('end_stop_name').value,
                    route_id: document.getElementById('route_id').value,
                    direction: document.getElementById('direction').value,
                    ac: document.getElementById('is_ac').checked ? 'AC' : 'Non AC',
                    calculated_fare: data.calculated_fare
                }));
            })
            .catch(error => console.error('Error:', error));
        });

        document.getElementById('showBuyTicketForm').addEventListener('click', function() {
            document.getElementById('buyTicketForm').style.display = 'block';
        });

        document.getElementById('printTicketBtn').addEventListener('click', function() {
            var ticketInfo = JSON.parse(sessionStorage.getItem('ticketInfo'));
            if (ticketInfo) {
                document.getElementById('ticketDate').textContent = ticketInfo.date;
                document.getElementById('ticketTime').textContent = ticketInfo.time;
                document.getElementById('ticketStartStop').textContent = ticketInfo.start_stop;
                document.getElementById('ticketEndStop').textContent = ticketInfo.end_stop;
                document.getElementById('ticketRouteID').textContent = ticketInfo.route_id;
                document.getElementById('ticketRouteName').textContent = ticketInfo.route_name;
                document.getElementById('ticketDirection').textContent = ticketInfo.direction;
                document.getElementById('ticketAC').textContent = ticketInfo.ac;
                document.getElementById('ticketFare').textContent = '$' + ticketInfo.calculated_fare;

                document.getElementById('ticket').style.display = 'block';

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                doc.text("Ticket", 10, 10);
                doc.text("Date: " + ticketInfo.date, 10, 20);
                doc.text("Time: " + ticketInfo.time, 10, 30);
                doc.text("Start Stop: " + ticketInfo.start_stop, 10, 40);
                doc.text("End Stop: " + ticketInfo.end_stop, 10, 50);
                doc.text("Route ID: " + ticketInfo.route_id, 10, 60);
                doc.text("Direction: " + ticketInfo.direction, 10, 70);
                doc.text("AC: " + ticketInfo.ac, 10, 80);
                doc.text("Fare: $" + ticketInfo.calculated_fare, 10, 90);

                doc.save("ticket.pdf");
            }
        });

        fetchRouteIDs();
    </script>
</body>
</html>
