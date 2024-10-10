<?php

include 'connector.php';


if(isset($_POST['submit'])){
    $depName = $_POST['depName'];
    $depHead = $_POST['depHead'];
    $depTelNo = $_POST['depTelNo'];

    $sql = "INSERT INTO departments (depName, depHead, depTelNo) VALUES ('$depName', '$depHead', '$depTelNo')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    echo "
    <script>
        alert('STUDENT SUCCESSFULLY REGISTERED');
        window.location.href='department.php';
    </script>
";
}


?>

<!DOCTYPE html>
    <head>
        <title>Add Department</title>
    </head>

    <body>
        <form action="add_department.php" method="post">
            <label for="depName">Department Name:</label><br>
            <input type="text" id="depName" name="depName"><br>
            <label for="depHead">Department Head:</label><br>
            <input type="text" id="depHead" name="depHead"><br>
            <label for="depTelNo">Department Phone Number:</label><br>
            <input type="text" id="depTelNo" name="depTelNo"><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>

</!DOCTYPE>