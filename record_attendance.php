<?php 

include 'connector.php';

$employee = null;

// Step 1: Search for Employee
if (isset($_POST['search'])) {
    $empID = $_POST['empID'];
    $sqlEmp = "SELECT * FROM employees WHERE empID = '$empID'";
    $empResult = $conn->query($sqlEmp);

    if ($empResult->num_rows > 0) {
        $employee = $empResult->fetch_assoc();
    } else {
        echo "
        <script>
            alert('Employee ID does not exist');
            window.location.href='record_attendance.php';
        </script>";
        exit();
    }
}

// Step 2: Record Attendance
if (isset($_POST['submit'])) {
    $empID = $_POST['empID'];  
    $attDate = $_POST['attDate'];
    $attTimeIn = $_POST['attTimeIn'];
    $attTimeOut = $_POST['attTimeOut'];
    $attStat = 'Present';

    $attTimeIn = $attDate . ' ' . $attTimeIn;
    $attTimeOut = $attDate . ' ' . $attTimeOut;

    $sql = "INSERT INTO attendance (empID, attDate, attTimeIn, attTimeOut, attStat)
            VALUES ('$empID', '$attDate', '$attTimeIn', '$attTimeOut', '$attStat')";

    if ($conn->query($sql) === TRUE) {
        echo "
        <script>
            alert('Attendance Record Successfully');
            window.location.href='attendance.php';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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

    <!-- Step 1: Search for Employee -->
    <?php if (!$employee): ?>
        <form method="post" action="record_attendance.php">
            <label for="empID">Employee ID:</label>
            <input type="text" id="empID" name="empID" required><br><br>
            <input type="submit" name="search" value="Search Employee">
        </form>
    <?php endif; ?>

    <!-- Step 2: Record Attendance -->
    <?php if ($employee): ?>
        <form method="post" action="record_attendance.php">
            <input type="hidden" name="empID" value="<?php echo $employee['empID']; ?>">
            
            <label for="empName">Employee Name:</label>
            <input type="text" id="empName" name="empName" value="<?php echo $employee['empFName'] . ' ' . $employee['empLName']; ?>" readonly><br><br>
            
            <label for="attDate">Date:</label>
            <input type="date" id="attDate" name="attDate" required><br><br>
            
            <label for="attTimeIn">Time In:</label>
            <input type="time" id="attTimeIn" name="attTimeIn" required><br><br>
            
            <label for="attTimeOut">Time Out:</label>
            <input type="time" id="attTimeOut" name="attTimeOut" required><br><br>
            
            <input type="submit" name="submit" value="Record Attendance">
        </form>
    <?php endif; ?>
</body>
</html>