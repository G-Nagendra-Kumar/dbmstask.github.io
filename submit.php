<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "1234";  // default in XAMPP
$dbname = "student_marks";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form values
$student_name=$_POST['student_name'];
$student_id = $_POST['student_id'];
$daa = $_POST['daa'];
$dld = $_POST['dld'];
$dbms = $_POST['dbms'];
$flat = $_POST['flat'];
$ps = $_POST['ps'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO marks (student_name,student_id, daa, dld, dbms, flat, ps) VALUES (?,?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiiiii",$student_name, $student_id, $daa, $dld, $dbms, $flat, $ps);

// Execute
if ($stmt->execute()) {
    echo <<<HTML_SUCCESS_PAGE
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Successful!</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4CAF50; /* Green for success */
            --secondary-color: #673AB7; /* Deep Purple for contrast */
            --accent-color: #FFC107; /* Amber for highlight */
            --text-dark: #333;
            --text-light: #f9f9f9;
            --bg-light: #e0f2f1; /* Light Teal background */
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, var(--bg-light) 0%, #c8e6c9 100%); /* Subtle gradient */
            color: var(--text-dark);
            overflow: hidden; /* Prevent scrollbar due to animations */
        }

        .container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            padding: 50px 40px;
            text-align: center;
            max-width: 600px;
            width: 90%;
            opacity: 0; /* Hidden by default for fade-in */
            transform: translateY(20px); /* Slightly lower for slide-up */
            animation: fadeInSlideUp 0.8s ease-out forwards;
            position: relative;
            overflow: hidden; /* For pseudo-element animation */
        }

        /* Animated background elements */
        .container::before,
        .container::after {
            content: '';
            position: absolute;
            background: rgba(76, 175, 80, 0.1); /* Lighter version of primary, manually set RGB for direct rgba() */
            border-radius: 50%;
            z-index: 0;
            filter: blur(40px);
            opacity: 0;
            animation: bubbleEffect 20s infinite ease-in-out;
        }

        .container::before {
            width: 150px;
            height: 150px;
            top: -50px;
            left: -50px;
            animation-delay: 0s;
        }

        .container::after {
            width: 180px;
            height: 180px;
            bottom: -60px;
            right: -60px;
            animation-delay: 5s;
        }

        @keyframes bubbleEffect {
            0% { transform: translate(0, 0) scale(0.8); opacity: 0.3; }
            25% { transform: translate(20px, 30px) scale(1.1); opacity: 0.5; }
            50% { transform: translate(0, 60px) scale(0.9); opacity: 0.4; }
            75% { transform: translate(-20px, 30px) scale(1.2); opacity: 0.6; }
            100% { transform: translate(0, 0) scale(0.8); opacity: 0.3; }
        }

       .icon-wrapper {
    font-size: 80px;
    color: var(--primary-color);
    margin-bottom: 25px;
    animation: popIn 0.6s cubic-bezier(0.68, -0.55, 0.27, 1.55) forwards; /* Bounce effect */
    animation-delay: 0.5s;
    opacity: 0; /* <--- THIS IS THE CULPRIT! */
    position: relative;
    z-index: 1; /* Ensure icon is above pseudo-elements */
}

        h1 {
            color: var(--primary-color);
            font-size: 2.8em;
            margin-bottom: 15px;
            font-weight: 700;
            letter-spacing: 0.5px;
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInSlideUp 0.8s ease-out forwards;
            animation-delay: 0.7s;
            position: relative;
            z-index: 1;
        }

        p {
            color: var(--text-dark);
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 35px;
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInSlideUp 0.8s ease-out forwards;
            animation-delay: 0.9s;
            position: relative;
            z-index: 1;
        }

        .add-another-btn {
            background-color: var(--secondary-color);
            color: var(--text-light);
            padding: 15px 35px;
            border: none;
            border-radius: 50px; /* Pill shape */
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none; /* Remove underline for anchor */
            display: inline-block; /* Allow padding and sizing */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
            animation-delay: 1.2s;
            position: relative;
            z-index: 1;
        }

        .add-another-btn:hover {
            background-color: #512DA8; /* Darker secondary on hover */
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3);
        }

        .add-another-btn:active {
            transform: translateY(0);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        /* Keyframe Animations */
        @keyframes fadeInSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes popIn {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }
            80% {
                opacity: 1;
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 40px 30px;
                width: 95%;
            }
            h1 {
                font-size: 2.2em;
            }
            p {
                font-size: 1em;
            }
            .icon-wrapper {
                font-size: 60px;
            }
            .add-another-btn {
                padding: 12px 25px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div  >
        <span style="font-size: 60px;">&#x2714;</span>

             </div>
        <h1>Submission Successful!</h1>
        <p>Your student's marks have been successfully recorded. Thank you!</p>
        <a href="index.html" class="add-another-btn">Add Another Student</a>
    </div>

    <script>
        // This script is optional but can be used for more complex interactions
        // For this page, CSS animations handle most of the effects.
        // If you had, for example, a confetti animation library, you'd initialize it here.
    </script>
</body>
</html>
HTML_SUCCESS_PAGE;
} else {
    echo "Error: " . $stmt->error;
}

// Close
$stmt->close();
$conn->close();
?>
