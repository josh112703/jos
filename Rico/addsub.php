<?php
require('session.php');
require('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get the form data
    $subjectID = $_POST['subjectID'];
    $courseID = $_POST['courseID'];
    $courseCode = $_POST['courseCode'];
    $subdetail = $_POST['subdetail'];
    $units = $_POST['units'];
    $lab = $_POST['lab'];
    $lec = $_POST['lec'];
    $prerequisite = $_POST['prerequisite'];
    $yearlevl = $_POST['yearlevl'];
    $semester = $_POST['semester'];

    // Prepare the SQL query
    $query = "INSERT INTO `subjects` (subjectID, courseID, courseCode, subdetail, units, lab, lec, prerequisite, yearlevl, semester) 
              VALUES ('$subjectID', '$courseID', '$courseCode', '$subdetail', '$units', '$lab', '$lec', '$prerequisite', '$yearlevl', '$semester')";

    // Execute the query and check for success
    if (mysqli_query($conn, $query)) {
        mysqli_commit($conn);
        echo "<script>
                alert('Subject added successfully!');
                window.location.href='subjects.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Failed to add subject. Please try again.');
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
    <title>Add Subject</title>
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
    </style>
</head>
<body>
    <form id="add_subject" action="" method="post">
        <h1>Add Subject</h1>
        <div class="label-input-group">
            <label for="courseID">Course</label>
            <select id="courseID" name="courseID" required>
                <option value="1">BSIT</option> <!-- courseID 1 -->
                <option value="2">BSCS</option> <!-- courseID 2 -->
                <!-- Add more course options as necessary -->
            </select>
        </div>
        <div class="label-input-group">
            <label for="courseCode">Course Code</label>
            <input type="text" id="courseCode" name="courseCode" required>
        </div>
        <div class="label-input-group">
            <label for="subdetail">Subject Detail</label>
            <input type="text" id="subdetail" name="subdetail" required>
        </div>
        <div class="label-input-group">
            <label for="units">Units</label>
            <input type="number" id="units" name="units" required>
        </div>
        <div class="label-input-group">
            <label for="lab">Lab Hours</label>
            <input type="number" id="lab" name="lab" required>
        </div>
        <div class="label-input-group">
            <label for="lec">Lecture Hours</label>
            <input type="number" id="lec" name="lec" required>
        </div>
        <div class="label-input-group">
            <label for="prerequisite">Prerequisite</label>
            <input type="text" id="prerequisite" name="prerequisite">
        </div>
        <div class="label-input-group">
            <label for="yearlevl">Year Level</label>
            <input type="number" id="yearlevl" name="yearlevl" required>
        </div>
        <div class="label-input-group">
            <label for="semester">Semester</label>
            <input type="text" id="semester" name="semester" required>
        </div>
        <input type="submit" name="submit" value="Add Subject">
        <a href="home.php" class="btn btn-danger m-t-15 waves-effect">Cancel</a>
    </form>
</body>
</html>
