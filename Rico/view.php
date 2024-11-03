<div class="container">
    <h2>Subjects for Course ID: <?php echo htmlspecialchars($_GET['courseID']); ?></h2>
    <a href="home.php">back</a>
    <?php
    include_once 'db.php';

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the courseID from the URL
    $courseID = isset($_GET['courseID']) ? intval($_GET['courseID']) : 0;

    if ($courseID > 0) {
        // Query to retrieve subjects filtered by courseID
        $query = "SELECT subjectID, courseID, courseCode, subdetail, units, lab, lec, prerequisite, yearlevl, semester FROM subjects WHERE courseID = $courseID";
        
        $result = mysqli_query($conn, $query);

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
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row["subjectID"]); ?></td>
                <td><?php echo htmlspecialchars($row["courseID"]); ?></td>
                <td><?php echo htmlspecialchars($row["courseCode"]); ?></td>
                <td><?php echo htmlspecialchars($row["subdetail"]); ?></td>
                <td><?php echo htmlspecialchars($row["units"]); ?></td>
                <td><?php echo htmlspecialchars($row["lab"]); ?></td>
                <td><?php echo htmlspecialchars($row["lec"]); ?></td>
                <td><?php echo htmlspecialchars($row["prerequisite"]); ?></td>
                <td><?php echo htmlspecialchars($row["yearlevl"]); ?></td>
                <td><?php echo htmlspecialchars($row["semester"]); ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
            } else {
                echo "<p>No subjects found for Course ID $courseID.</p>";
            }
        } else {
            echo "<p>Error executing query: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Please provide a valid course ID in the URL.</p>";
    }

    mysqli_close($conn);
    ?>
</div>

<style>
    /* Add your existing styles here */
    .container {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .add {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 15px;
        background-color: #28a745;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    .update {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 4px;
    }

    .delete {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 4px;
    }

    .update:hover, .delete:hover {
        opacity: 0.8;
    }
</style>
