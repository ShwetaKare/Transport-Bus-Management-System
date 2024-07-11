<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport System</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('assets\\collage.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: white;
            overflow-x: hidden;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            text-align: center;
            z-index: 1000;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .white-layer {
            height: 200px;
            background-color: white;
            margin-bottom: 250px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        .icon {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .icon img {
            width: 120px;
            height: 120px;
            color: black;
        }
        .icon p {
            margin: 0;
            font-size: 14px;
            color: black;
        }
        .route {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .route p {
            margin: 0;
            color: black;
        }
        .about-section {
            padding: 50px;
            text-align: center;
            background-color: white;
            color: black;
        }
        #home {
            margin-top: 80px;
            margin-bottom: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 140px);
        }
        #home form {
            margin-top: 20px;
            display: none;
        }
        #home.show-form form {
            display: block;
        }
        
        #spacer {
            height: 1000px;
        }

        /* Animation for welcome text */
        @keyframes slideInFromTop {
            0% {
                transform: translateY(-100%);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Apply animation to welcome text */
        .welcome-text {
            animation: slideInFromTop 1.5s ease-out;
            background-color: white;
            padding: 20px;
            z-index: 1001;
            color: black;
            overflow-y: auto;
            max-height: calc(100vh - 40px);
        }

        /* Style for the "Click Here" button */
        .start-form button {
            background-color: white;
            color: red;
            font-size: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Hover effect for the "Click Here" button */
        .start-form button:hover {
            background-color: red;
            color: white;
        }

        /* Style for download button */
        .download-button {
            background-color: black;
            color: white;
            font-size: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Hover effect for download button */
        .download-button:hover {
            background-color: #333;
        }

        /* Icon before download button text */
        .download-button::before {
            content: "\1F4E5"; /* Unicode for download icon */
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
    </div>

    <div id="home" class="section">
        <!-- Animated welcome text -->
        <h1 class="welcome-text">Welcome to Transport System !</h1>
        <form action="dashboard.php" method="get" class="start-form">
            <button type="submit">Click Here</button>
        </form>
    </div>

    <div class="white-layer">
        <div class="route">
            <img src="assets\route.png" alt="Icon 1">
            <p style="color: black;margin: 0;"><strong>16</strong></p>
            <p style="color: black;margin: 0;">Routes</p>
        </div>
        <div class="icon">
            <img src="assets\rating.png" alt="Icon 2">
            <p style="color: black;font-size:20px;"><strong>5</strong></p>
            <p>Ratings</p>
        </div>
        <div class="icon">
            <img src="assets\ticket.png" alt="Icon 3">
            <p>Ticketing</p>
        </div>
    </div>

    <div class="about-section" id="about">
        <h2 style="margin-bottom: 50px;">About Us</h2>
        <p>
            This website is made as a project for Database Management System by a Second year IT student. It offers a glimpse into the B.E.S.T transport management of COLABA depot, showcasing various functionalities such as insert, delete, update, search, and ticketing. The frontend is developed using HTML, CSS, and JS, while the backend is powered by PHP and MariaDB. It is user-friendly, developed for convenience and practical application of theoretical knowledge in web development and database management.
        </p>
        <!-- Link to the PDF file -->
        <a href="pdf/visualization.pdf" target="_blank">For more visualization (PDF)</a>
        <!-- Download button for the PDF file -->
        <button class="download-button" onclick="downloadPDF()">Download PDF</button>
    </div>

    <script>
        // Show the start button when the welcome text appears
        document.querySelector('.welcome-text').addEventListener('animationend', function() {
            document.querySelector('.start-form').style.display = 'block';
        });

        // Function to download the PDF file
        function downloadPDF() {
            // Create a temporary anchor element
            var link = document.createElement('a');
            link.href = 'pdf/visualization.pdf';
            link.download = 'visualization.pdf';
            // Simulate a click event to trigger the download
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>
