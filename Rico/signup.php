<?php
require('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Retrieve POST data directly
    $FacultyID = $_POST['FacultyID'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $bdate = $_POST['bdate'];
    $age = (int)$_POST['age'];

    // Start a transaction
    mysqli_begin_transaction($conn);

    // Insert into accounts table
$queryFaculty = "INSERT INTO `accounts` (facultyID, Fname, Lname, Midname, Ddate, age) 
VALUES ('$FacultyID', '$fname', '$lname', '$mname', '$bdate', $age)";

if (mysqli_query($conn, $queryFaculty)) {
// Get the last inserted ID (regID)
$regID = mysqli_insert_id($conn);

// Insert into the login table
$queryLogin = "INSERT INTO `login` (regID, username, email, password) 
  VALUES ($regID, '$username', '$email', '$password')";

if (mysqli_query($conn, $queryLogin)) {
mysqli_commit($conn);
echo "<script>
                        alert('Registration successful!');
                        window.location.href='login.php';
                      </script>";
                exit;
} else {
mysqli_rollback($conn);
echo "Error inserting into login table: " . mysqli_error($conn);
}
} else {
mysqli_rollback($conn);
echo "Error inserting into accounts table: " . mysqli_error($conn);
}

    // Close the database connection
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

input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"],
input[type="number"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
input[type="date"]:focus,
input[type="number"]:focus {
    border-color: #673FD7;
    outline: none;
}

input[type="submit"] {
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

input[type="submit"]:hover {
    box-shadow: rgba(80, 63, 205, 0.5) 0 2px 15px;
    transition: box-shadow 0.3s ease;
}
h2{
    margin-right: 20rem;
}

    </style>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
            gap: 10px;
        }
        .label-input-group {
            width: 48%;
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus {
            border-color: #673FD7;
            outline: none;
        }
        input[type="submit"] {
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
        input[type="submit"]:hover {
            box-shadow: rgba(80, 63, 205, 0.5) 0 2px 15px;
            transition: box-shadow 0.3s ease;
        }
        .align-center {
            text-align: center;
        }
        .m-t-25 {
            margin-top: 25px;
        }
        .m-b--5 {
            margin-bottom: -5px;
        }
    </style>
</head>
<body>
    <?php 
        $length = 4; // Length of random bytes
        $randomBytes = random_bytes($length);
        $randomId = bin2hex($randomBytes);
        $upperCaseId = strtoupper($randomId);
    ?>
    <form id="sign_up" action="" method="post">
        <h2>Sign Up</h2>
        <div class="label-input-group">
            <label for="FacultyID">Faculty ID</label>
            <input type="text" id="FacultyID" name="FacultyID" value="<?php echo htmlspecialchars($upperCaseId); ?>" required>
        </div>
        <div class="label-input-group">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" required>
        </div>
        <div class="label-input-group">
            <label for="mname">Middle Name</label>
            <input type="text" id="mname" name="mname" required>
        </div>
        <div class="label-input-group">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" required>
        </div>
        <div class="label-input-group">
            <label for="bdate">Birthdate</label>
            <input type="date" id="bdate" name="bdate" required>
        </div>
        <div class="label-input-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" required min="0" step="1" readonly>
        </div>
        <div class="label-input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="label-input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="label-input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <input type="submit" name="submit" value="Submit">
        <div class="m-t-25 m-b--5 align-center">
            <a href="login.php">You already have an account?</a>
        </div>
    </form>
    <script>
        function calculateAge(bdate) {
            const today = new Date();
            const birthDate = new Date(bdate);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            // Adjust age if birthdate hasn't occurred yet this year
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        document.getElementById('bdate').addEventListener('change', function() {
            const bdate = this.value;
            const ageInput = document.getElementById('age');
            if (bdate) {
                ageInput.value = calculateAge(bdate);
            } else {
                ageInput.value = ''; // Clear age if birthdate is not provided
            }
        });
    </script>
</body>
</html>

</body>
</html>
