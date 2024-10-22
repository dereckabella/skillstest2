<?php

include 'connector.php';

if(isset($_POST['submit'])){
    $depName = $_POST['depName'];
    $depHead = $_POST['depHead'];
    $depTelNo = $_POST['depTelNo'];

    $sql = "INSERT INTO departments(depName, depHead, depTelNo)
            VALUES ('$depName', '$depHead', '$depTelNo')";

        if ($conn->query($sql) === TRUE) {
            echo "New record successfully";
        } else {
            echo "Error: " . $sql . "<br>". $conn->error;
        }

        echo "
            <script>
                alert('ADDED DEPARTMENT SUCCESFULLY');
                window.location.href='department.php';
            </script>
        ";
}


?>

<html>
    <head>
        <style>

        </style>
    </head>


    <body>
        <form action="add_department.php" method="POST">
            <label for="depName">Department Name: </label><br>
            <input type="text" id="depName" name="depName" required><br>

            <label for="depHead">Department Head: </label><br>
            <input type="text" id="depHead" name="depHead" required><br>

            <label for="depTelNo">Department Tel. No: </label><br>
            <input type="text" id="depTelNo" name="depTelNo" required><br>

            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
</html>