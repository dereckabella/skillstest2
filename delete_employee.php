<?php 

include 'connector.php';

if(isset($_GET['empID'])) {
    $empID = $_GET['empID'];

    $sqlAttendance = "DELETE FROM attendance WHERE empID = '$empID'";
    if ($conn->query($sqlAttendance) === TRUE) {

        $sql = "DELETE FROM employees WHERE empID = '$empID'";
        if ($conn->query($sql) === TRUE) {
            echo "
                <script>
                    alert('Employee Deleted Successfully');
                    window.location.href='employee.php';
                </script>
            ";
        } else {
            echo "Error deleting employee: " .  $conn->error;
        }
    } else {
        echo "Error deleting related to attendance: " . $conn->error;
    }
}

?>