<?php

include 'connector.php';


$departments = [];
$sql = "SELECT depCode, depName FROM departments";
$depResult = $conn->query($sql);

if ($depResult) {
    while ($row = $depResult->fetch_assoc()) {
        $departments[] = $row;
    }
}

if (isset($_POST['submit'])) {
    $empFName = $_POST['empFName'];
    $empLName = $_POST['empLName'];
    $empRPH = $_POST['empRPH'];
    $depCode = $_POST['depCode'];


    $sql = "INSERT into employees (empFName, empLName, empRPH, depCode)
            VALUES ('$empFName', '$empLName', '$empRPH', '$depCode')";

    if($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Added employee successfully');
                window.location.href='employee.php';
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
        <form action="add_employee.php" method="POST">
            <label for="depCode">Department:</label>
            <select id="depCode" name="depCode">
                <?php  foreach ($departments as $department): ?>
                    <option value="<?php echo ($department['depCode']); ?>"><?php echo ($department['depName']);?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="empFName">Employee First Name:</label>
            <input type="text" id="empFname" name="empFName"><br><br>

            <label for="empLName">Employee Last Name:</label>
            <input type="text" id="empLName" name="empLName"><br><br>

            <label for="empRPH">Employee Rate Per Hour:</label>
            <input type="text" id="empRPH" name="empRPH"><br><br>

            <input type="submit"  name="submit" value="Add employee">

        </form>
    </body>
</html>