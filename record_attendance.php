<?php

include 'connector.php';

// Handle form submission to record attendance
if (isset($_POST['submit'])) {
    $empID = $_POST['empID'];
    $attDate = $_POST['attDate'];
    $attTimeIn = $_POST['attTimeIn'];
    $attTimeOut = $_POST['attTimeOut'];
    $attStat = 'Present'; // Assuming default status is 'Present'

    // Combine date and time for datetime fields
    $attTimeIn = $attDate . ' ' . $attTimeIn;
    $attTimeOut = $attDate . ' ' . $attTimeOut;

    // Check if employee ID exists
    $empCheckQuery = "SELECT empID FROM employees WHERE empID = '$empID'";
    $empCheckResult = mysqli_query($conn, $empCheckQuery);

    if (mysqli_num_rows($empCheckResult) > 0) {
        // Employee ID exists, record attendance
        $sql = "INSERT INTO attendance (empID, attDate, attTimeIn, attTimeOut, attStat) VALUES ('$empID', '$attDate', '$attTimeIn', '$attTimeOut', '$attStat')";

        if ($conn->query($sql) === TRUE) {
            echo "
            <script>
                alert('ATTENDANCE SUCCESSFULLY RECORDED');
                window.location.href='attendance.php';
            </script>
            ";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Employee ID does not exist, show alert
        echo "
        <script>
            alert('Employee ID does not exist');
            window.location.href='record_attendance.php';
        </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Attendance</title>
</head>
<body>
    <h2>Record Attendance</h2>
    <a href="attendance.php">Back to Attendance Records</a>
    <form method="post" action="record_attendance.php">
        <label for="empID">Employee ID:</label>
        <input type="text" id="empID" name="empID" required><br><br>
        
        <label for="attDate">Date:</label>
        <input type="date" id="attDate" name="attDate" required><br><br>
        
        <label for="attTimeIn">Time In:</label>
        <input type="time" id="attTimeIn" name="attTimeIn" required><br><br>
        
        <label for="attTimeOut">Time Out:</label>
        <input type="time" id="attTimeOut" name="attTimeOut" required><br><br>
        
        <input type="submit" name="submit" value="Record Attendance">
    </form>
</body>
</html>