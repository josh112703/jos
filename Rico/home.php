<?php
require('session.php');

echo "Welcome, $Fname $Midname $Lname! Faculty-ID:$facultyID";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
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
            margin-bottom: 20px; /* Added margin for spacing */
            border-bottom: 1px solid #ccc; /* Added border for separation */
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            display: flex;
        }

        nav ul li a {
            margin-left: 20px; /* Adjusted margin for spacing */
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
            max-width: 600px; /* Optional: max width for readability */
            margin: 0;
            padding: 8px 16px;
        }

        /* Table Styles */
        table {
            width: 100%; /* Full width for the table */
            margin: 0 auto; /* Center align the table */
            border-collapse: collapse;
            background-color: #f4f4f4; /* Table background color */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Added shadow for depth */
        }

        table, th, td {
            border: 1px solid #ccc; /* Adjusted border color */
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333; /* Header background color */
            color: #f4f4f4; /* Header text color */
        }

        tr:nth-child(even) {
            background-color: #ddd; /* Light gray for even rows */
        }

        tr:nth-child(odd) {
            background-color: #f4f4f4; /* Default color for odd rows */
        }

        td {
            color: #333; /* Text color in table cells */
        }

        /* Link Styles */
        a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
            margin-right: 8px; /* Spacing between links */
        }

        a.add {
            background-color: #007BFF; /* Blue for add link */
            color: #fff;
        }

        a.add:hover {
            background-color: #0056b3;
        }

        a.update {
            background-color: #28a745; /* Green for update link */
            color: #fff;
        }

        a.update:hover {
            background-color: #218838;
        }

        a.delete {
            background-color: #dc3545; /* Red for delete link */
            color: #fff;
        }

        a.delete:hover {
            background-color: #c82333;
        }

        a.view {
            background-color: #007BFF; /* Red for delete link */
            color: #fff;
        }

        a.view:hover {
            background-color: #0056b3;
        }

        /* Container Styles */
        .container {
            width: 80%;
            max-width: 1200px; /* Limit the maximum width */
            margin: 0 auto; /* Center align the container */
            padding: 20px;
            background-color: #fff; /* White background for contrast */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Added shadow for depth */
        }

        .container a.add {
            margin: .5rem;
            display: inline-block;
            margin-top: 20px; /* Space above the Add Student link */
            text-align: center; /* Center align the link */
            width: auto; /* Auto width to fit content */
        }
    </style>
</head>
<body>
<nav>
    <ul>
        <li><h1><?php echo htmlspecialchars($_SESSION['email']); ?></h1></li>
        <li><a href="home.php">Student</a></li>
        <li><a href="subjects.php">Subject</a></li>
        <li>
            <a href="profile.php?id=<?php echo $userId; ?>">
            <img src="<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
            </a>
        </li>
        <li><a href="logout.php">Logout</a></li>
    </ul>    
</nav>

    <?php
    include_once 'db.php';
    $result = mysqli_query($conn, "SELECT studinfo.sID, studinfo.studID, studinfo.fullname, studinfo.year, studinfo.courseID, course.Programs 
    FROM studinfo 
    INNER JOIN course ON studinfo.courseID = course.courseID");
    ?>

    <?php
    if (mysqli_num_rows($result) > 0) {
    ?>
    <div class="container">
        <table>
            <a href="add.php" class="add">Add Student</a>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Full Name</th>
                    <th>Course</th>
                    <th>Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row["sID"]; ?></td>
                    <td><?php echo $row["studID"]; ?></td>
                    <td><?php echo $row["fullname"]; ?></td>
                    <td><?php echo $row["Programs"]; ?></td>
                    <td><?php echo $row["year"]; ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $row["sID"]; ?>" class="update">Update</a>
                        <a href="delete.php?id=<?php echo $row["sID"]; ?>" class="delete">Delete</a>
                        <a href="view.php?courseID=<?php echo $row["courseID"]; ?>" class="view">View</a> <!-- Corrected this line -->
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    } else {
        echo "No result found";
    }
    ?>
</body>
</html>
