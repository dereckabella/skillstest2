<?php

include 'connector.php';

$sql = "SELECT employees.*, departments.depName FROM employees 
    LEFT JOIN departments ON employees.depCode = departments.depCode";
$result = $conn->query($sql);

?>

<html>
    <head>
        <title>Employee</title>
    </head>

    <body>
        <a href="add_employee.php">Add Employee</a>
        <table border="1">
            <tr>
                <th>Employee ID</th>
                <th>Dept</th>
                <th>Employee Name</th>
                <th>Employee Email</th>
                <th>Employee Phone Number</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                    <td><?php echo $row['empCode']; ?></td>
                    <td><?php echo $row['depCode']; ?></td>
                    <td><?php echo $row['empName']; ?></td>
                    <td><?php echo $row['empEmail']; ?></td>
                    <td><?php echo $row['empTelNo']; ?></td>
                    <td>
                        <a href="edit_employee.php?empCode=<?php echo $row['empCode']; ?>">Edit</a>
                        <a href="delete_employee.php?empCode=<?php echo $row['empCode']; ?>">Delete</a>
                    </td>
                    </tr>
            <?php
                }
            } else {
                echo "0 results";
            }
            ?>
        </table>
    
</html>