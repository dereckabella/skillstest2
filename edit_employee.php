<?php

include 'connector.php';

$departments = [];
$sql = "SELECT depCode, depName FROM departments";
$depResult = $conn->query($sql);

if($depResult) {
    while($row = $depResult->fetch_assoc()) {
        $departments[] = $row;
    }
}

if(isset($_GET['empID'])) {
    $empID = $_GET['empID'];
    $sql = "SELECT * FROM employees WHERE empID = '$empID'";
    $empResult = $conn->query($sql);

    if($empResult->num_rows > 0) {
        $employee = $empResult->fetch_assoc();
    } else {
        echo "
        <script>
            alert('Employee ID does not exist');
            window.location.href='employees.php';
        </script>";
        exit();
    }
}

if(isset($_POST['submit'])) {
    $empID = $_POST['empID'];
    $empFName = $_POST['empFName'];
    $empLName = $_POST['empLName'];
    $empRPH = $_POST['empRPH'];
    $depCode = $_POST['depCode'];

    $sql = "UPDATE employees SET empFName = '$empFName', empLName = '$empLName', empRPH = '$empRPH', depCode = '$depCode' WHERE empID = '$empID'";

    if ($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Employee Updated Successfully');
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
        <a href="index.html">Back to Menu</a>
        <form action="edit_employee.php" method="POST">

            <input type="hidden" id="empID" name="empID" value="<?php echo $employee['empID']; ?>">

            <label for="depCode">Department Assigned:</label>
            <select id="depCode" name="depCode">
                <?php foreach ($departments as $department): ?>
                    <option value="<?php echo($department['depCode']); ?>"><?php echo ($department['depName']);?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="empFName">Employee First Name:</label>
            <input type="text" id="empFName" name="empFName" value="<?php echo $employee['empFName']; ?>"><br><br>

            <label for="empLName">Employee Last Name:</label>
            <input type="text" id="empLName" name="empLName" value="<?php echo $employee['empLName']; ?>"><br><br>

            <label for="empRPH">Employee Rate Per Hour:</label>
            <input type="text" id="empRPH" name="empRPH" value="<?php echo $employee['empRPH']; ?>"><br><br>

            <input type="submit" name="submit" value="Edit Employee">
        </form>
    </body>
</html>