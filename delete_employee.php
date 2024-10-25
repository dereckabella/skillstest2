<?php
include 'connector.php';
if (isset($_GET['empCode'])) {
    $empCode = $_GET['empCode'];
    $sqlAttendance = "DELETE FROM attendance WHERE empID = '$empCode'";
    if ($conn->query($sqlAttendance) === TRUE) {
        $sqlEmployee = "DELETE FROM employees WHERE empID = '$empCode'";
        if ($conn->query($sqlEmployee) === TRUE) {
            echo "
            <script>
                alert('EMPLOYEE SUCCESSFULLY DELETED');
                window.location.href='employee.php';
            </script>";
        } else {
            echo "Error deleting employee: " . $conn->error;
        }
    } else {
        echo "Error deleting related attendance records: " . $conn->error;
    }
}
?>