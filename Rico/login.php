<?php
require('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format.")</script>';
        echo "<script>window.location.href ='login.php'</script>";
        exit();
    }

    // Fetch the password and regID from the login table
    $query = "SELECT password, regID FROM `login` WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];
        $regID = $row['regID'];

        // Check if the entered password matches the stored password
        if ($stored_password === $password) {
            // Fetch additional user information from the accounts table
            $query_user_info = "SELECT Fname, Midname, Lname, profile_pic, facultyID FROM `accounts` WHERE regID = '$regID'";
            $result_user_info = mysqli_query($conn, $query_user_info);

            if ($result_user_info && mysqli_num_rows($result_user_info) > 0) {
                $user_info = mysqli_fetch_assoc($result_user_info);
                $Fname = $user_info['Fname'];
                $Midname = $user_info['Midname'];
                $Lname = $user_info['Lname'];
                $profile_pic = $user_info['profile_pic'];
                $facultyID = $user_info['facultyID']; // Fetch profile picture

                // Store user information in session
                $_SESSION['email'] = $email;
                $_SESSION['Fname'] = $Fname;
                $_SESSION['Midname'] = $Midname;
                $_SESSION['Lname'] = $Lname;
                $_SESSION['regID'] = $regID;
                $_SESSION['profile_pic'] = $profile_pic;
                $_SESSION['facultyID'] = $facultyID;// Store profile picture in session

                echo '<script>alert("Successfully Logged In!")</script>';
                echo "<script>window.location.href ='home.php'</script>";
            } else {
                echo '<script>alert("Error fetching user information.")</script>';
                echo "<script>window.location.href ='login.php'</script>";
            }
        } else {
            echo '<script>alert("Incorrect email or password.")</script>';
            echo "<script>window.location.href ='login.php'</script>";
        }
    } else {
        echo '<script>alert("No user found with this email.")</script>';
        echo "<script>window.location.href ='login.php'</script>";
    }

    // Close the connection
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
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-image: linear-gradient(92.88deg, #455EB5 9.16%, #5643CC 43.89%, #673FD7 64.72%);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            box-shadow: rgba(80, 63, 205, 0.5) 0 1px 30px;
            transition-duration: .1s;
        }
    </style>
</head>
<body>
<form id="sign_in" action="" method="post">
    <h2>Sign in</h2>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="submit" name="submit" value="Submit">
    <div class="m-t-25 m-b--5 align-center">
        <a href="signup.php">Create Account?</a>
    </div>
</form>
</body>
</html>
