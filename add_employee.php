<?php

include 'connector.php';

// Fetch departments for the dropdown
$departments = [];
$sql = "SELECT depCode, depName FROM departments";
$depResult = mysqli_query($conn, $sql);

if ($depResult) {
    while ($row = mysqli_fetch_assoc($depResult)) {
        $departments[] = $row;
    }
}

if (isset($_POST['submit'])) {
    $empFName = $_POST['empFName'];
    $empLName = $_POST['empLName'];
    $empRPH = $_POST['empRPH'];
    $depCode = $_POST['depCode'];

    $sql = "INSERT INTO employees (empFName, empLName, empRPH, depCode) VALUES ('$empFName', '$empLName', '$empRPH', '$depCode')";

    if ($conn->query($sql) === TRUE) {
        echo "New employee added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    echo "
    <script>
        alert('EMPLOYEE SUCCESSFULLY REGISTERED');
        window.location.href='employee.php';
    </script>
";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
</head>
<body>
    <h2>Add Employee</h2>
    <form method="post" action="add_employee.php">
        <label for="empFName">First Name:</label>
        <input type="text" id="empFName" name="empFName" required><br><br>
        
        <label for="empLName">Last Name:</label>
        <input type="text" id="empLName" name="empLName" required><br><br>
        
        <label for="empRPH">RPH:</label>
        <input type="text" id="empRPH" name="empRPH" required><br><br>
        
        <label for="depCode">Department:</label>
        <select id="depCode" name="depCode" required>
            <?php foreach ($departments as $department): ?>
                <option value="<?php echo htmlspecialchars($department['depCode']); ?>"><?php echo htmlspecialchars($department['depName']); ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <input type="submit" name="submit" value="Add Employee">
    </form>
</body>
</html>