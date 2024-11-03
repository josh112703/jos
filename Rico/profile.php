<?php
session_start();

// Include your database connection
include 'db.php'; // Ensure this file exists and is correctly pointed to

// Enable detailed error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize variables
$currentProfilePic = '';
$reg_id = $_SESSION['regID'] ?? null;

// Check if reg_id is set
if (!$reg_id || !is_numeric($reg_id)) {
    echo "Invalid user ID.";
    exit();
}

// Fetch current faculty data including the password
$stmt = $conn->prepare("SELECT Fname, Lname, Midname, Ddate, age, profile_pic, password 
                        FROM accounts 
                        JOIN login ON accounts.regID = login.regID 
                        WHERE accounts.regID = ?");
$stmt->bind_param("i", $reg_id);
$stmt->execute();
$currentResult = $stmt->get_result();

if ($currentResult && $currentResult->num_rows === 1) {
    $faculty = $currentResult->fetch_assoc();
    
    // Initialize form variables
    $firstname = $faculty['Fname'] ?? '';
    $lastname = $faculty['Lname'] ?? '';
    $midname = $faculty['Midname'] ?? '';
    $bdate = $faculty['Ddate'] ?? '';
    $age = $faculty['age'] ?? '';
    $currentProfilePic = $faculty['profile_pic'] ?? '';
    $storedPassword = $faculty['password'] ?? ''; // Fetch the stored password
} else {
    echo "No faculty found for ID: $reg_id<br>";
    exit();
}

// Handle the form submission for updating faculty information
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {

    $updated_firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $updated_lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $updated_midname = filter_var($_POST['midname'], FILTER_SANITIZE_STRING);
    $updated_bdate = filter_var($_POST['bdate'], FILTER_SANITIZE_STRING);
    $updated_age = (int) filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $entered_password = $_POST['current_password'] ?? ''; // Password entered for confirmation

    // Validate password entered for confirmation
    if (empty($entered_password) || $entered_password !== $storedPassword) {
        echo "Incorrect current password.<br>";
        exit();
    }

    // Validate new password if set
    if (!empty($new_password) && $new_password !== $confirm_password) {
        echo "New passwords do not match.<br>";
        exit();
    }

    // Handle file upload for profile picture
    $uploadDir = 'uploads/'; // Ensure this directory exists
    $profilePic = $currentProfilePic; // Keep the current picture if no new upload

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
        $fileName = basename($_FILES['profile_pic']['name']);
        $newFileName = uniqid() . '-' . $fileName;
        $destPath = $uploadDir . $newFileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $profilePic = $destPath;
        } else {
            echo "Error moving the uploaded file.";
            exit();
        }
    }

    // Update the faculty's information
    $stmt = $conn->prepare("UPDATE accounts 
                            SET Fname = ?, 
                                Lname = ?, 
                                Midname = ?, 
                                Ddate = ?, 
                                age = ?, 
                                profile_pic = ? 
                            WHERE regID = ?");
    $stmt->bind_param("ssssisi", $updated_firstname, $updated_lastname, $updated_midname, $updated_bdate, $updated_age, $profilePic, $reg_id);
    $stmt->execute();

    // Add password update only if a new password was set
    if (!empty($new_password)) {
        $stmt = $conn->prepare("UPDATE login 
                                SET password = ?
                                WHERE regID = ?");
        $stmt->bind_param("si", $new_password, $reg_id);
        $stmt->execute();
    }

    if ($stmt->affected_rows > 0) {
        echo "Updated Successfully!<br>";
        header('Location: profile.php');
        exit();
    } else {
        echo "No changes were made or error in updating: " . $conn->error . "<br>";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Faculty Information</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="number"], input[type="date"], input[type="file"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"], button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }

        .profile-upload img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<script>
function calculateAge() {
const bdateInput = document.getElementById('bdate');
const ageInput = document.getElementById('age');
const birthDate = new Date(bdateInput.value);
const today = new Date();
const age = today.getFullYear() - birthDate.getFullYear();
const monthDiff = today.getMonth() - birthDate.getMonth();

// Adjust for the case where the birthday hasn't occurred this year yet
if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
ageInput.value = age - 1;
} else {
ageInput.value = age;
}
}
</script>
<div class="container">
    <h2>Edit Faculty Information</h2>
    <form id="facultyForm" method="POST" enctype="multipart/form-data">
        <div class="profile-upload">
            <?php if ($currentProfilePic): ?>
                <img src="<?php echo htmlspecialchars($currentProfilePic); ?>" alt="Current Profile Picture">
            <?php else: ?>
                <img src="default_profile.png" alt="Default Profile Picture">
            <?php endif; ?>
            <input type="file" name="profile_pic" accept="image/*">
        </div>

        <label>First Name:</label>
        <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>

        <label>Last Name:</label>
        <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>

        <label>Middle Name:</label>
        <input type="text" name="midname" value="<?php echo htmlspecialchars($midname); ?>">

        <label>Birth Date:</label>
        <input type="date" id="bdate" name="bdate" value="<?php echo htmlspecialchars($bdate); ?>" onchange="calculateAge()">
        <label>Age:</label>
        <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>" readonly>

        <label>Current Password (for confirmation):</label>
        <input type="password" name="current_password" required>

        <label>New Password:</label>
        <input type="password" name="new_password">

        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password">

        <input type="submit" name="edit" value="Update Faculty">
        <a href="home.php">back</a>
    </form>
</div>
</body>
</html>
