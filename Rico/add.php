<?php
require('session.php');
require('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $studID = $_POST['studID'];
    $Name = $_POST['Name'];
    $courseID = $_POST['courseID']; // Changed to courseID based on the database structure
    $Year = $_POST['Year'];

    $query = "INSERT INTO `studinfo` (studID, fullname, courseID, year) VALUES ('$studID', '$Name', '$courseID', '$Year')";
    if (mysqli_query($conn, $query)) {
        mysqli_commit($conn);
        echo "<script>
                alert('Registration successful!');
                window.location.href='home.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Registration failed. Please try again.');
              </script>";
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        /* Styles remain the same as before */
        body {
            font-family: Arial, sans-serif;
            background-color: #111827;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            box-sizing: border-box;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        form h1 {
            width: 100%;
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }

        form p {
            width: 100%;
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }

        .label-input-group {
            width: 48%; /* Make each input group half the form width */
            display: flex;
            flex-direction: column;
            margin-bottom: 16px;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #673FD7;
            outline: none;
        }

        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"], a {
            background-image: linear-gradient(92.88deg, #455EB5 9.16%, #5643CC 43.89%, #673FD7 64.72%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }

        input[type="submit"], a:hover {
            box-shadow: rgba(80, 63, 205, 0.5) 0 2px 15px;
            transition: box-shadow 0.3s ease;
        }

        h2 {
            margin-right: 500px;
        }
    </style>
</head>
<body>
    <form id="sign_up" action="" method="post">
        <h2>Sign Up</h2>
        <div class="label-input-group">
            <label for="studID">Student ID</label>
            <input type="text" id="studID" name="studID" required>
        </div>
        <div class="label-input-group">
            <label for="Name">Name</label>
            <input type="text" id="Name" name="Name" required>
        </div>
        <div class="label-input-group">
            <label for="courseID">Course</label>
            <select id="courseID" name="courseID" required>
                <option value="1">BSIT</option> 
                <option value="2">BSCS</option>
            </select>
        </div>
        <div class="label-input-group">
            <label for="Year">Year</label>
            <input type="text" id="Year" name="Year" required>
        </div>
        <input type="submit" name="submit" value="Add Student">
        <a href="home.php" class="btn btn-danger m-t-15 waves-effect">Cancel</a>
    </form>
</body>
</html>
