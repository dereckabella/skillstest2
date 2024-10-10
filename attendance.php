<?php

include 'connector.php';

// Fetch attendance records
$attendanceRecords = [];
$sql = "SELECT attRN, empID, attDate, attTimeIn, attTimeOut, attStat FROM attendance";
$attResult = mysqli_query($conn, $sql);

if ($attResult) {
    while ($row = mysqli_fetch_assoc($attResult)) {
        $attendanceRecords[] = $row;
    }
}

// Handle cancellation of attendance
if (isset($_GET['cancel_id'])) {
    $attRN = $_GET['cancel_id'];

    // Update the status to "Cancelled"
    $sql = "UPDATE attendance SET attStat = 'Cancelled' WHERE attRN = '$attRN'";

    if ($conn->query($sql) === TRUE) {
        echo "
        <script>
            alert('Attendance status updated to Cancelled');
            window.location.href='attendance.php';
        </script>
        ";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Records</title>
</head>
<body>
    <h2>Attendance Records</h2>
    <a href="index.html">Back to Main Menu</a>
    <table border="1">
        <tr>
            <th>Record ID</th>
            <th>Employee ID</th>
            <th>Date</th>
            <th>Date/Time In</th>
            <th>Date/Time Out</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($attendanceRecords as $record): ?>
            <tr>
                <td><?php echo $record['attRN']; ?></td>
                <td><?php echo $record['empID']; ?></td>
                <td><?php echo $record['attDate']; ?></td>
                <td><?php echo $record['attTimeIn']; ?></td>
                <td><?php echo $record['attTimeOut']; ?></td>
                <td><?php echo $record['attStat']; ?></td>
                <td><a href="attendance.php?cancel_id=<?php echo $record['attRN']; ?>">Cancel</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Record Attendance</h2>
    <a href="record_attendance.php">Record Attendance</a>
</body>
</html>