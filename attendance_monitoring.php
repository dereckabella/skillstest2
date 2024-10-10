<?php

include 'connector.php';

$employee = null;
$attendanceRecords = [];
$totalHours = 0;
$salary = 0;
$ratePerHour = 0;

if (isset($_POST['searchByID'])) {
    $empID = $_POST['empID'];

    // Fetch employee details
    $empQuery = "SELECT e.empID, e.empFName, e.empLName, e.empRPH, d.depName 
                 FROM employees e 
                 JOIN departments d ON e.depCode = d.depCode 
                 WHERE e.empID = '$empID'";
    $empResult = mysqli_query($conn, $empQuery);

    if ($empResult && mysqli_num_rows($empResult) > 0) {
        $employee = mysqli_fetch_assoc($empResult);
        $ratePerHour = $employee['empRPH'];

        // Fetch attendance records
        $attQuery = "SELECT attRN, attDate, attTimeIn, attTimeOut, empID 
                     FROM attendance 
                     WHERE empID = '$empID'";
        $attResult = mysqli_query($conn, $attQuery);

        if ($attResult) {
            while ($row = mysqli_fetch_assoc($attResult)) {
                $attendanceRecords[] = $row;

                // Calculate total hours worked
                $timeIn = new DateTime($row['attTimeIn']);
                $timeOut = new DateTime($row['attTimeOut']);
                $interval = $timeIn->diff($timeOut);
                $hoursWorked = $interval->h + ($interval->i / 60);
                $totalHours += $hoursWorked;
            }

            // Calculate salary
            $salary = $totalHours * $ratePerHour;
        }
    } else {
        echo "
        <script>
            alert('Employee ID does not exist');
            window.location.href='attendance_monitoring.php';
        </script>
        ";
    }
}

if (isset($_POST['searchByDate'])) {
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];

    // Fetch attendance records within the date range
    $attQuery = "SELECT attRN, attDate, attTimeIn, attTimeOut, empID 
                 FROM attendance 
                 WHERE attDate BETWEEN '$dateFrom' AND '$dateTo'";
    $attResult = mysqli_query($conn, $attQuery);

    if ($attResult) {
        while ($row = mysqli_fetch_assoc($attResult)) {
            $attendanceRecords[] = $row;

            // Calculate total hours worked
            $timeIn = new DateTime($row['attTimeIn']);
            $timeOut = new DateTime($row['attTimeOut']);
            $interval = $timeIn->diff($timeOut);
            $hoursWorked = $interval->h + ($interval->i / 60);
            $totalHours += $hoursWorked;
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Monitoring</title>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header, .footer {
            display: flex;
            justify-content: space-between;
        }
        .footer {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .form-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .form-left {
            flex: 1;
        }
        .form-right {
            flex: 1;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Attendance Monitoring</h2>
        <a href="index.html">Back to Main Menu</a>
        <form method="post" action="attendance_monitoring.php">
            <div class="form-container">
                <div class="form-left">
                    <label for="empID">Employee ID:</label>
                    <input type="text" id="empID" name="empID"><br><br>
                    <input type="submit" name="searchByID" value="Search by Employee ID"><br><br>
                </div>
                <div class="form-right">
                    <label for="dateFrom">Date From:</label>
                    <input type="date" id="dateFrom" name="dateFrom"><br><br>
                    <label for="dateTo">Date To:</label>
                    <input type="date" id="dateTo" name="dateTo"><br><br>
                    <input type="submit" name="searchByDate" value="Search by Date Range">
                </div>
            </div>
        </form>

        <?php if ($employee): ?>
            <div class="header">
                <div>
                    <p>Name: <?php echo $employee['empFName'] . ' ' . $employee['empLName']; ?></p>
                </div>
                <div>
                    <p>Department:<?php echo $employee['depName']; ?></p>
                </div>
            </div>
        <?php endif; ?>

        <h3>Attendance Records</h3>
        <table>
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
                    $interval = $timeIn->diff($timeOut);
                    $hoursWorked = $interval->h + ($interval->i / 60);
                ?>
                <tr>
                    <td><?php echo $record['attRN']; ?></td>
                    <td><?php echo $record['empID']; ?></td>
                    <td><?php echo $record['attDate']; ?></td>
                    <td><?php echo $record['attTimeIn']; ?></td>
                    <td><?php echo $record['attTimeOut']; ?></td>
                    <td><?php echo number_format($hoursWorked, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="summary">
            <div>
                <p>Date Generated:<?php echo date('Y-m-d'); ?></p>
            </div>
            <div>
                <p>Total Hours:<?php echo number_format($totalHours, 2); ?></p>
            </div>
        </div>

        <?php if ($employee): ?>
            <div class="footer">
                <div>
                    
                    <p>Rate per Hour: <?php echo number_format($ratePerHour, 2); ?></p>
                    <p>Salary:<?php echo number_format($salary, 2); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>