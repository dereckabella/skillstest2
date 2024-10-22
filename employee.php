<?php

include 'connector.php';

$sql = "SELECT employees.*, departments.depName FROM employees
        LEFT JOIN departments ON employees.depCode = departments.depCode";
$result = $conn->query($sql);

?>

<html>
    <head>
        <style>

        </style>
    </head>

    <body>
        <a href="add_employee.php">Add employees</a>
        <a href="index.html">Back to Menu</a>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Dept</th>
                <th>LastName</th>
                <th>FirstName</th>
                <th>Rate Per Hour</th>
                <th>Actions</th>
            </tr>

            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

            ?>
                <tr>
                    <td><?php echo $row['empID']?></td>
                    <td><?php echo $row['depCode']?></td>
                    <td><?php echo $row['empLName']?></td>
                    <td><?php echo $row['empFName']?></td>
                    <td><?php echo $row['empRPH']?></td>
                    <td>
                        <a href="edit_employee.php?empID=<?php echo $row['empID']?>">Edit</a>
                        <a href="delete_employee.php?empID=<?php echo $row['empID']?>">Delete</a>
                    </td>
                </tr>
            <?php
                     
                    }
                }
            ?>
        </table>
    </body>
</html>