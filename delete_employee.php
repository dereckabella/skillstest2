<?php

include 'connector.php';

// Check if the empID is provided and confirmation is not set yet
if (isset($_GET['empID']) && !isset($_GET['confirm'])) {
    $empID = $_GET['empID'];

    // Show confirmation prompt
    echo "
    <script>
        if (confirm('Are you sure you want to delete this employee?')) {
            window.location.href = 'delete_employee.php?confirm=yes&empID=$empID';
        } else {
            window.location.href = 'employee.php';
        }
    </script>";
    exit(); // Stop further execution to wait for the user's confirmation
}

// If the user confirmed the deletion
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes' && isset($_GET['empID'])) {
    $empID = $_GET['empID'];

    // Delete attendance records related to the employee
    $sqlAttendance = "DELETE FROM attendance WHERE empID = '$empID'";
    if ($conn->query($sqlAttendance) === TRUE) {

        // Delete the employee
        $sql = "DELETE FROM employees WHERE empID = '$empID'";
        if ($conn->query($sql) === TRUE) {
            echo "
            <script>
                alert('Employee Deleted Successfully');
                window.location.href='employee.php';
            </script>";
        } else {
            echo "Error deleting employee: " . $conn->error;
        }
    } else {
        echo "Error deleting related attendance: " . $conn->error;
    }
}

?>
