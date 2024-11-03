<?php
include_once 'db.php';
$sql = "DELETE FROM `studinfo` WHERE sID='" . $_GET["id"] . "'";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('student record has been deleted');</script>"; 
    echo "<script>window.location.href = 'home.php'</script>";     
  
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>