<?php

include 'connector.php';

if(isset($_GET['depCode'])){
    $depCode = $_GET['depCode'];

    $sqlAttendance = "DELETE FROM attendance WHERE empID IN (SELECT empID FROM employees WHERE depCode = '$depCode')";
    if ($conn->query($sqlAttendance) === TRUE) {
        
        $sqlEmployees = "DELETE FROM employees WHERE depCode = '$depCode'";
            if($conn->query($sqlEmployees) === TRUE) {

                $sqlDepartment = "DELETE FROM departments WHERE depCode = '$depCode'";
                if($conn->query($sqlDepartment) === TRUE ) {
                    echo "
                      <script>
                        alert('DEPARTMENT DELETED SUCCESSFULLY');
                        window.location.href='department.php';
                      </script>
                    ";
                } else {
                    echo "Error deleting department: " . $conn->error;
                }
            } else {
                echo "Error deleting employee: " . $conn->error;
            }
    } else {
        echo "Error delete attendance: " . $conn->error;
    }

}

?>