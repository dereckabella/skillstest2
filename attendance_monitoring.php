<?php

include 'connector.php';

$employee = null;
$attendanceRecords = [];
$totalHours = 0;
$salary = 0;
$ratePerHour = 0;

if(isset($_POST['searchByID'])) {
    $empID = $_POST['empID'];

    $empSql = "SELECT e.empID, e.empFName, e.empLName, e.empRPH, d.depName
                FROM employees e
                JOIN departments d ON e.depCode = d.depCode
                WHERE e.empID = '$empID'";
    $empResult = $conn->query($empSql);

    if($empResult -> num_rows > 0 ) {
        $employee = $empResult->fetch_assoc();
        $ratePerHour = $employee['empRPH'];

        $attSql = "SELECT attRn, attDate, attTimeIn, attTimeOut, empID
                   FROM attendance 
                   WHERE empID = '$empID'";
        $attResult = $conn->query($attSql);

        if($attResult) {
            while($row = $attResult->fetch_assoc()) {
                $attendanceRecords[] = $row;

                $timeIn = new DateTime($row['attTimeIn']);
                $timeOut = new DateTime($row['attTimeOut']);
                $interval = $timeIn->diff($timeOut);
                $hoursWorked = $interval->h + ($interval->i / 60);
                $totalHours += $hoursWorked;
            }

            $salary = $totalHours * $ratePerHour;
        } else {
            echo "
                <script>
                    alert('Employee ID does not exist!!');
                    window.location.href='attendance_monitoring.php';
                </script>
            ";
        }
    }

}

if(isset($_POST['searchByDate'])) {
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];

    $attSql = "SELECT attRn, attDate, attTimeIn, attTimeOut, empID FROM attendance WHERE attDate BETWEEN '$dateFrom' AND '$dateTo'";
    $attResult = $conn->query($attSql);

    if($attResult) {
        while ($row = $attResult->fetch_assoc()) {
            $attendanceRecords[] = $row;

            $timeIn = new DateTime($row['attTimeIn']);
            $timeOut = new DateTime($row['attTimeOut']);
            $interval = $timeIn->diff($timeOut);
            $hoursWorked = $interval->h + ($interval->i / 60);
            $totalHours += $hoursWorked;
        }
    }
}

?>

<html>

    <head>
        <style>

        </style>
    </head>

    <body>
        <div class="container">
            <a href="index.html">Back to Menu</a>

            <form action="attendance_monitoring.php" method="POST">
                <div class="form-container">
                    <div class="form-left">
                        <label for="empID">Employee ID:</label>
                        <input type="text" id="empID" name="empID"><br><br>
                        <input type="submit" name="searchByID" value="Search by ID"><br><br>
                    </div>
                    <div class="form-right">
                        <label for="dateFrom">Date From:</label>
                        <input type="date" id="dateFrom" name="dateFrom"><br><br>
                        <label for="dateTo">Date To:</label>
                        <input type="date" id="dateTo" name="dateTo"><br><br>
                        <input type="submit" name="searchByDate" value="Search By Date">
                    </div>
                </div>
            </form>

            <?php if($employee): ?>
                <div class="header">
                    <div>
                        <p>Name: <?php echo $employee['empFName'] . ' ' . $employee['empLName']; ?></p>
                    </div>
                    <div>
                        <p>Department: <?php echo $employee['depName']; ?></p>
                    </div>
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
                        $interval = $timeIn->diff($timeOut);
                        $hoursWorked = $interval->h + ($interval->i / 60);    
                    ?>

                    <tr>
                        <td><?php echo $record['attRn']?></td>
                        <td><?php echo $record['empID']?></td>
                        <td><?php echo $record['attDate']?></td>
                        <td><?php echo $record['attTimeIn']?></td>
                        <td><?php echo $record['attTimeOut']?></td>
                        <td><?php echo number_format($hoursWorked, 2);?></td>
                    </tr>
                <?php endforeach;?>
            </table>

            <div class="summary">
                    <div>
                        <p>Date Generated: <?php echo date('Y-m-d');?></p>
                    </div>

                    <div>
                        <p>Total Hours: <?php echo number_format($totalHours, 2); ?></p>
                    </div>
            </div>

            <?php if ($employee):?>
                <div class="footer">
                    <div>
                        <p>Rate Per Hour: <?php echo number_format($ratePerHour, 2); ?></p>
                        <p>Salary: <?php echo number_format($salary, 2);?></p>
                    </div>
                </div>

            <?php endif;?>
        </div>
    </body>

</html>