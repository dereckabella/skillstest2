<?php
include 'connector.php';
if (isset($_GET['depCode'])) {
    $depCode = $_GET['depCode'];
    // Delete related attendance records first
    $sqlAttendance = "DELETE FROM attendance WHERE empID IN (SELECT empID FROM employees WHERE depCode = '$depCode')";
    if ($conn->query($sqlAttendance) === TRUE) {
        // Delete related employees
        $sqlEmployees = "DELETE FROM employees WHERE depCode = '$depCode'";
        if ($conn->query($sqlEmployees) === TRUE) {
            // Now delete the department
            $sqlDepartment = "DELETE FROM departments WHERE depCode = '$depCode'";
            if ($conn->query($sqlDepartment) === TRUE) {
                echo "
                <script>
                    alert('DEPARTMENT SUCCESSFULLY DELETED');
                    window.location.href='department.php';
                </script>";
            } else {
                echo "Error deleting department: " . $conn->error;
            }
        } else {
            echo "Error deleting related employees: " . $conn->error;
        }
    } else {
        echo "Error deleting related attendance records: " . $conn->error;
    }
}
?>