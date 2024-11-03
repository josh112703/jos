<?php
require('session.php');

echo "Welcome, $Fname $Midname $Lname!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects Page</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #111827;
            color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Navigation Styles */
        nav {
            width: 100%;
            background-color: #f4f4f4;
            padding: 10px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            display: flex;
        }

        nav ul li a {
            margin-left: 20px;
            color: #050505;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav ul li a:hover {
            background-color: #555;
            color: #e0e0e0;
        }

        /* Heading Styles */
        h1 {
            color: #333;
            text-align: left;
            font-size: 16px;
            max-width: 600px;
            margin: 0;
            padding: 8px 16px;
        }

        /* Table Styles */
        table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #f4f4f4;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #ddd;
        }

        tr:nth-child(odd) {
            background-color: #f4f4f4;
        }

        td {
            color: #333;
        }

        /* Link Styles */
        a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
            margin-right: 8px;
        }

        a.add {
            background-color: #007BFF;
            color: #fff;
        }

        a.add:hover {
            background-color: #0056b3;
        }

        a.update {
            background-color: #28a745;
            color: #fff;
        }

        a.update:hover {
            background-color: #218838;
        }

        a.delete {
            background-color: #dc3545;
            color: #fff;
        }

        a.delete:hover {
            background-color: #c82333;
        }

        /* Container Styles */
        .container {
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><h1><?php echo htmlspecialchars($_SESSION['email']); ?></h1></li>
            <li><a href="home.php">Student</a></li>
            <li><a href="subjects.php">Subjects</a></li>
            <li>
            <a href="profile.php?id=<?php echo $userId; ?>">
            <img src="<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
            </a>
        </li>
            <li><a href="logout.php">Logout</a></li>
        </ul>    
    </nav>

    <div class="container">
        <a href="addsub.php" class="add">Add Subject</a>
        <?php
        include_once 'db.php';

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to retrieve subjects
        $result = mysqli_query($conn, "SELECT subjectID, courseID, courseCode, subdetail, units, lab, lec, prerequisite, yearlevl, semester FROM subjects");

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <thead>
                <tr>
                    <th>Subject ID</th>
                    <th>Course ID</th>
                    <th>Course Code</th>
                    <th>Subject Detail</th>
                    <th>Units</th>
                    <th>Lab Hours</th>
                    <th>Lecture Hours</th>
                    <th>Prerequisite</th>
                    <th>Year Level</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row["subjectID"]; ?></td>
                    <td><?php echo $row["courseID"]; ?></td>
                    <td><?php echo $row["courseCode"]; ?></td>
                    <td><?php echo $row["subdetail"]; ?></td>
                    <td><?php echo $row["units"]; ?></td>
                    <td><?php echo $row["lab"]; ?></td>
                    <td><?php echo $row["lec"]; ?></td>
                    <td><?php echo $row["prerequisite"]; ?></td>
                    <td><?php echo $row["yearlevl"]; ?></td>
                    <td><?php echo $row["semester"]; ?></td>
                    <td>
                        <a href="updatesub.php?id=<?php echo $row["subjectID"]; ?>" class="update">Update</a>
                        <a href="delete.php?id=<?php echo $row["subjectID"]; ?>" class="delete">Delete</a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php
            } else {
                echo "<p>No subjects found.</p>";
            }
        } else {
            echo "<p>Error executing query: " . mysqli_error($conn) . "</p>";
        }
        ?>
    </div>
</body>
</html>
