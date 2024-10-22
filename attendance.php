<?php 

include 'connector.php';


$sql = "SELECT attRN, attDate, attTimeIn, attTimeOut, attStat, empID FROM attendance";
$result = $conn->query($sql); 


if (isset($_GET['cancel_id'])) {
    $attRN = $_GET['cancel_id'];

    $sql = "UPDATE attendance SET attStat = 'Cancelled' WHERE attRN = '$attRN'";
    if ($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Status changed to cancelled');
                window.location.href='attendance.php';
            </script>
        ";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<html>
    <head>
        <style>
           
        </style>
    </head>

    <body>
      
        <a href="record_attendance.php">Add Attendance</a>
        <a href="index.html">Back to Menu</a>
        
      
        <table border="1">
            <tr>
                <th>Record #</th>
                <th>Emp ID</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php
                // Check if any results were returned
                if ($result->num_rows > 0) {
                  
                    while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $row['attRN'] ?></td>
                    <td><?php echo $row['empID'] ?></td>
                    <td><?php echo $row['attDate'] ?></td>
                    <td><?php echo $row['attTimeIn'] ?></td>
                    <td><?php echo $row['attTimeOut'] ?></td>
                    <td><?php echo $row['attStat'] ?></td>
                    <td>
                       
                        <a href="attendance.php?cancel_id=<?php echo $row['attRN'] ?>">Cancel</a>
                    </td>
                </tr>
            <?php
                    }  
                } else {
                    echo "<tr><td colspan='7'>No attendance records found</td></tr>";
                }
            ?>
        </table>
    </body>
</html>
