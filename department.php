<?php

include 'connector.php';

$sql = "SELECT * FROM departments";
$result = $conn->query($sql);

?>



<!DOCTYPE html>

<head>
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

    <a href="add_department.php">Add Department</a>
    <a href="index.html">Back to Menu</a>
    <table border="1">
        <tr>
            <th>Department ID</th>
            <th>Department Name</th>
            <th>Department Head</th>
            <th>Tel No</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                <td><?php echo $row['depCode']; ?></td>
                <td><?php echo $row['depName']; ?></td>
                <td><?php echo $row['depHead']; ?></td>
                <td><?php echo $row['depTelNo']; ?></td>
                <td>
                    <a href="edit_department.php?depCode=<?php echo $row['depCode']; ?>">Edit</a>
                    <a href="delete_department.php?depCode=<?php echo $row['depCode']; ?>">Delete</a>
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