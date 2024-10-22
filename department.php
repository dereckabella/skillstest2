<?php

include 'connector.php';

$sql = "SELECT * FROM departments";
$result = $conn->query($sql);

?>

<html>
    <head>
        <style>

        </style>
    </head>

    <body>
        <a href="add_department.php">Add deparment here</a>
        <a href="index.html">Back to Menu</a>
        <table border="1">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Head</th>
                <th>Tel. No</th>
                <th>Actions</th>
            </tr>

            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

              
            ?>

            <tr>
                <td><?php echo $row['depCode']?></td>
                <td><?php echo $row['depName']?></td>
                <td><?php echo $row['depHead']?></td>
                <td><?php echo $row['depTelNo']?></td>
                <td>
                    <a href="edit_department.php?depCode=<?php echo $row['depCode']?>">Edit</a>
                    <a href="delete_department.php?depCode=<?php echo $row['depCode']?>">Delete</a>
                </td>
            </tr>

            <?php
                  }
                }
            
            ?>

        </table>

        
    </body>
</html>
