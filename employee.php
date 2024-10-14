<?php

include 'connector.php';

$sql = "SELECT employees.*, departments.depName FROM employees 
    LEFT JOIN departments ON employees.depCode = departments.depCode";
$result = $conn->query($sql);

?>

<html>
    <head>
        <title>Employee</title>
        <style>
             table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding: 15px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    a {
        text-decoration: none;
        color: black;
        padding: 8px 16px;
        display: inline-block;
        border: 1px solid black;
    }
        </style>
    </head>

    <body>
        <a href="add_employee.php">Add Employee</a>
        <a href="index.html">Back to Menu</a>
        <table border="1">
            <tr>
                <th>Employee ID</th>
                <th>Dept</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Rate Per Hour</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                    <td><?php echo $row['empID']; ?></td>
                    <td><?php echo $row['depCode']; ?></td>
                    <td><?php echo $row['empFName']; ?></td>
                    <td><?php echo $row['empLName']; ?></td>
                    <td><?php echo $row['empRPH']; ?></td>
                    <td>
                        <a href="edit_employee.php?empID=<?php echo $row['empID']; ?>">Edit</a>
                        <a href="delete_employee.php?empID=<?php echo $row['empID']; ?>">Delete</a>
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