<?php
require('session.php');
require('db.php');

$ID = $_GET['id'] ?? ''; // Retrieve ID from the query parameter

// Initialize variables for current student information
$studID = '';
$currentName = '';
$currentCourseID = '';
$currentYear = '';

// Fetch existing data if ID is provided
if ($ID) {
    $check_query = "SELECT * FROM `studinfo` WHERE sID='$ID'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $studID = $row['studID'];
        $currentName = $row['fullname'];
        $currentCourseID = $row['courseID']; // Use courseID instead of course
        $currentYear = $row['year'];
    } else {
        echo "<script>
                alert('Student ID not found.');
                window.location.href='home.php';
              </script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $Name = $_POST['Name'];
    $courseID = $_POST['courseID']; // Use courseID for updating the course
    $Year = $_POST['Year'];

    // Proceed with the update
    $query = "UPDATE `studinfo` SET fullname='$Name', courseID='$courseID', year='$Year' WHERE sID='$ID'";
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
    <title>Update Student Information</title>
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

        input[type="text"], select {
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
    <form id="update_student" action="" method="post">
        <h2>Update Student Information</h2>
        <div class="label-input-group">
            <label for="ID">sID</label>
            <input type="text" id="ID" name="ID" value="<?php echo htmlspecialchars($ID); ?>" readonly>
        </div>
        <div class="label-input-group">
            <label for="studID">Student ID</label>
            <input type="text" id="studID" name="studID" value="<?php echo htmlspecialchars($studID); ?>" readonly>
        </div>
        <div class="label-input-group">
            <label for="Name">Name</label>
            <input type="text" id="Name" name="Name" value="<?php echo htmlspecialchars($currentName); ?>" required>
        </div>
        <div class="label-input-group">
            <label for="courseID">Course</label>
            <select id="courseID" name="courseID" required>
                <option value="1" <?php if($currentCourseID == 1) echo 'selected'; ?>>BSIT</option> <!-- courseID 1 -->
                <option value="2" <?php if($currentCourseID == 2) echo 'selected'; ?>>BSCS</option> <!-- courseID 2 -->
            </select>
        </div>
        <div class="label-input-group">
            <label for="Year">Year</label>
            <input type="text" id="Year" name="Year" value="<?php echo htmlspecialchars($currentYear); ?>" required>
        </div>
        <input type="submit" name="submit" value="Update Student">
        <a href="home.php" class="btn btn-danger m-t-15 waves-effect">Cancel</a>
    </form>
</body>
</html>
