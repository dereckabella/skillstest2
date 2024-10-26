<?php
include 'connector.php';

$employee = null;
$attendanceRecords = [];
$totalHours = 0;
$salary = 0;
$ratePerHour = 0;

// Function to calculate hours worked
function calculateHoursWorked($timeIn, $timeOut) {
    $interval = $timeIn->diff($timeOut);
    return $interval->h + ($interval->i / 60); // Hours + minutes as decimal
}

// Search by Employee ID
if (isset($_POST['searchByID'])) {
    $empID = $_POST['empID'];

    // Get employee details
    $empSql = "SELECT e.empID, e.empFName, e.empLName, e.empRPH, d.depName
               FROM employees e
               JOIN departments d ON e.depCode = d.depCode
               WHERE e.empID = '$empID'";
    $empResult = $conn->query($empSql);

    if ($empResult->num_rows > 0) {
        $employee = $empResult->fetch_assoc();
        $ratePerHour = $employee['empRPH'];

        // Fetch attendance records for the employee
        $attSql = "SELECT attRn, attDate, attTimeIn, attTimeOut, empID
                   FROM attendance 
                   WHERE empID = '$empID'";
        $attResult = $conn->query($attSql);

        while ($row = $attResult->fetch_assoc()) {
            $attendanceRecords[] = $row;

            // Calculate total hours worked
            $timeIn = new DateTime($row['attTimeIn']);
            $timeOut = new DateTime($row['attTimeOut']);
            $totalHours += calculateHoursWorked($timeIn, $timeOut);
        }
        
        // Calculate salary
        $salary = $totalHours * $ratePerHour;
    } else {
        echo "
            <script>
                alert('Employee ID does not exist!'); 
                window.location.href='attendance_monitoring.php';
            </script>
        ";
    }
}

// Search by Date Range
if (isset($_POST['searchByDate'])) {
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];

    // Fetch attendance records within date range
    $attSql = "SELECT attRn, attDate, attTimeIn, attTimeOut, empID 
               FROM attendance 
               WHERE attDate BETWEEN '$dateFrom' AND '$dateTo'";
    $attResult = $conn->query($attSql);

    while ($row = $attResult->fetch_assoc()) {
        $attendanceRecords[] = $row;

        // Calculate total hours worked
        $timeIn = new DateTime($row['attTimeIn']);
        $timeOut = new DateTime($row['attTimeOut']);
        $totalHours += calculateHoursWorked($timeIn, $timeOut);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Monitoring</title>
</head>
<body>
    <div class="container">
        <a href="index.html">Back to Menu</a>

        <!-- Search Form -->
        <form action="attendance_monitoring.php" method="POST">
            <div>
                <label for="empID">Employee ID:</label>
                <input type="text" id="empID" name="empID">
                <input type="submit" name="searchByID" value="Search by ID">
            </div>
            <div>
                <label for="dateFrom">Date From:</label>
                <input type="date" id="dateFrom" name="dateFrom">
                <label for="dateTo">Date To:</label>
                <input type="date" id="dateTo" name="dateTo">
                <input type="submit" name="searchByDate" value="Search By Date">
            </div>
        </form>

        <?php if ($employee): ?>
            <div>
                <p>Name: <?php echo $employee['empFName'] . ' ' . $employee['empLName']; ?></p>
                <p>Department: <?php echo $employee['depName']; ?></p>
            </div>
        <?php endif; ?>

        <h3>Attendance Records</h3>
        <table border="1">
            <tr>
                <th>Record ID</th>
                <th>Employee ID</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Total Hours</th>
            </tr>

            <?php foreach ($attendanceRecords as $record): ?>
                <?php 
                    $timeIn = new DateTime($record['attTimeIn']);
                    $timeOut = new DateTime($record['attTimeOut']);
                    $hoursWorked = calculateHoursWorked($timeIn, $timeOut);
                ?>
                <tr>
                    <td><?php echo $record['attRn']; ?></td>
                    <td><?php echo $record['empID']; ?></td>
                    <td><?php echo $record['attDate']; ?></td>
                    <td><?php echo $record['attTimeIn']; ?></td>
                    <td><?php echo $record['attTimeOut']; ?></td>
                    <td><?php echo number_format($hoursWorked, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div>
            <p>Date Generated: <?php echo date('Y-m-d'); ?></p>
            <p>Total Hours: <?php echo number_format($totalHours, 2); ?></p>
        </div>

        <?php if ($employee): ?>
            <div>
                <p>Rate Per Hour: <?php echo number_format($ratePerHour, 2); ?></p>
                <p>Salary: <?php echo number_format($salary, 2); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
