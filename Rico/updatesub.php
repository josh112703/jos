<?php
require('session.php');
require('db.php');

$ID = $_GET['id'] ?? ''; // Retrieve ID from the query parameter

// Initialize variables for current subject information
$subjectID = '';
$currentCourseID = '';
$currentCourseCode = '';
$currentSubDetail = '';
$currentUnits = '';
$currentLab = '';
$currentLec = '';
$currentPrerequisite = '';
$currentYearLevel = '';
$currentSemester = '';

// Fetch existing data if ID is provided
if ($ID) {
    $check_query = "SELECT * FROM `subjects` WHERE subjectID='$ID'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $subjectID = $row['subjectID'];
        $currentCourseID = $row['courseID'];
        $currentCourseCode = $row['courseCode'];
        $currentSubDetail = $row['subdetail'];
        $currentUnits = $row['units'];
        $currentLab = $row['lab'];
        $currentLec = $row['lec'];
        $currentPrerequisite = $row['prerequisite'];
        $currentYearLevel = $row['yearlevl'];
        $currentSemester = $row['semester'];
    } else {
        echo "<script>
                alert('Subject ID not found.');
                window.location.href='home.php';
              </script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $courseID = $_POST['courseID'];
    $courseCode = $_POST['courseCode'];
    $subdetail = $_POST['subdetail'];
    $units = $_POST['units'];
    $lab = $_POST['lab'];
    $lec = $_POST['lec'];
    $prerequisite = $_POST['prerequisite'];
    $yearlevl = $_POST['yearlevl'];
    $semester = $_POST['semester'];

    // Proceed with the update
    $query = "UPDATE `subjects` 
              SET courseID='$courseID', courseCode='$courseCode', subdetail='$subdetail', 
                  units='$units', lab='$lab', lec='$lec', prerequisite='$prerequisite', 
                  yearlevl='$yearlevl', semester='$semester' 
              WHERE subjectID='$ID'";
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Update successful!');
                window.location.href='home.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Update failed: " . mysqli_error($conn) . "');
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
    <title>Update Subject Information</title>
    <style>
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

        .label-input-group {
            width: 48%; 
            display: flex;
            flex-direction: column;
            margin-bottom: 16px;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="number"], select {
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
    <form id="update_subject" action="" method="post">
        <h1>Update Subject Information</h1>
        <div class="label-input-group">
            <label for="ID">Subject ID</label>
            <input type="text" id="ID" name="ID" value="<?php echo htmlspecialchars($ID); ?>" readonly>
        </div>
        <div class="label-input-group">
            <label for="courseID">Course</label>
            <select id="courseID" name="courseID" required>
                <option value="1" <?php if($currentCourseID == 1) echo 'selected'; ?>>BSIT</option>
                <option value="2" <?php if($currentCourseID == 2) echo 'selected'; ?>>BSCS</option>
                <!-- Add more course options as necessary -->
            </select>
        </div>
        <div class="label-input-group">
            <label for="courseCode">Course Code</label>
            <input type="text" id="courseCode" name="courseCode" value="<?php echo htmlspecialchars($currentCourseCode); ?>" required>
        </div>
        <div class="label-input-group">
            <label for="subdetail">Subject Detail</label>
            <input type="text" id="subdetail" name="subdetail" value="<?php echo htmlspecialchars($currentSubDetail); ?>" required>
        </div>
        <div class="label-input-group">
            <label for="units">Units</label>
            <input type="number" id="units" name="units" value="<?php echo htmlspecialchars($currentUnits); ?>" required>
        </div>
        <div class="label-input-group">
            <label for="lab">Lab Hours</label>
            <input type="number" id="lab" name="lab" value="<?php echo htmlspecialchars($currentLab); ?>" required>
        </div>
        <div class="label-input-group">
            <label for="lec">Lecture Hours</label>
            <input type="number" id="lec" name="lec" value="<?php echo htmlspecialchars($currentLec); ?>" required>
        </div>
        <div class="label-input-group">
            <label for="prerequisite">Prerequisite</label>
            <input type="text" id="prerequisite" name="prerequisite" value="<?php echo htmlspecialchars($currentPrerequisite); ?>">
        </div>
        <div class="label-input-group">
            <label for="yearlevl">Year Level</label>
            <input type="number" id="yearlevl" name="yearlevl" value="<?php echo htmlspecialchars($currentYearLevel); ?>" required>
        </div>
        <div class="label-input-group">
            <label for="semester">Semester</label>
            <input type="text" id="semester" name="semester" value="<?php echo htmlspecialchars($currentSemester); ?>" required>
        </div>
        <input type="submit" name="submit" value="Update Subject">
        <a href="subjects.php" class="btn btn-danger m-t-15 waves-effect">Cancel</a>
    </form>
</body>
</html>
