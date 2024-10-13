<?php

include 'connector.php';

$employee = null;
$departments = [];

// Fetch departments for the dropdown
$sql = "SELECT depCode, depName FROM departments";
$depResult = mysqli_query($conn, $sql);

if ($depResult) {
    while ($row = mysqli_fetch_assoc($depResult)) {
        $departments[] = $row;
    }
}

// Fetch employee details if empID is set
if (isset($_GET['empID'])) {
    $empID = $_GET['empID'];
    $sql = "SELECT * FROM employees WHERE empID = '$empID'";
    $empResult = mysqli_query($conn, $sql);

    if ($empResult && mysqli_num_rows($empResult) > 0) {
        $employee = mysqli_fetch_assoc($empResult);
    } else {
        echo "
        <script>
            alert('Employee ID does not exist');
            window.location.href='employee.php';
        </script>";
    }
}

// Update employee details if form is submitted
if (isset($_POST['submit'])) {
    $empID = $_POST['empID'];
    $empFName = $_POST['empFName'];
    $empLName = $_POST['empLName'];
    $empRPH = $_POST['empRPH'];
    $depCode = $_POST['depCode'];

    $sql = "UPDATE employees SET empFName = '$empFName', empLName = '$empLName', empRPH = '$empRPH', depCode = '$depCode' WHERE empID = '$empID'";

    if ($conn->query($sql) === TRUE) {
        echo "
        <script>
            alert('Employee successfully updated');
            window.location.href='employee.php';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
</head>
<body>
    <h2>Edit Employee</h2>
    <?php if ($employee): ?>
        <form method="post" action="edit_employee.php">
            <input type="hidden" name="empID" value="<?php echo $employee['empID']; ?>">
            
            <label for="empFName">First Name:</label>
            <input type="text" id="empFName" name="empFName" value="<?php echo $employee['empFName']; ?>" required><br><br>
            
            <label for="empLName">Last Name:</label>
            <input type="text" id="empLName" name="empLName" value="<?php echo $employee['empLName']; ?>" required><br><br>
            
            <label for="empRPH">Rate per Hour:</label>
            <input type="text" id="empRPH" name="empRPH" value="<?php echo $employee['empRPH']; ?>" required><br><br>
            
            <label for="depCode">Department:</label>
            <select id="depCode" name="depCode" required>
                <?php foreach ($departments as $department): ?>
                    <option value="<?php echo $department['depCode']; ?>" <?php if ($department['depCode'] == $employee['depCode']) echo 'selected'; ?>>
                        <?php echo $department['depName']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>
            
            <input type="submit" name="submit" value="Update Employee">
        </form>
    <?php else: ?>
        <p>Employee not found.</p>
    <?php endif; ?>
</body>
</html>