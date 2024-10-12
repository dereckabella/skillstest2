<?php

include 'connector.php';

// Fetch departments for the dropdown   
$departments = [];
$sql = "SELECT depCode, depName, depHead, depTelno FROM departments";
$depResult = mysqli_query($conn, $sql);

if ($depResult) {
    while ($row = mysqli_fetch_assoc($depResult)) {
        $departments[] = $row;
    }
}

if (isset($_POST['submit'])) {
    $depCode = $_POST['depCode'];
    $depName = $_POST['depName'];
    $depHead = $_POST['depHead'];
    $depTelno = $_POST['depTelno'];

    $sql = "UPDATE departments SET depName = '$depName', depHead = '$depHead', depTelno = '$depTelno' WHERE depCode = '$depCode'";

    if ($conn->query($sql) === TRUE) {
        echo "Department updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    echo "
    <script>
        alert('DEPARTMENT SUCCESSFULLY UPDATED');
        window.location.href='department.php';
    </script>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Department</title>
</head>
<body>
    <h2>Edit Department</h2>
    <form method="post" action="edit_department.php">
        <label for="depCode">Department Code:</label>
        <select id="depCode" name="depCode" required>
            <?php foreach ($departments as $department): ?>
                <option value="<?php echo htmlspecialchars($department['depCode']); ?>"><?php echo htmlspecialchars($department['depName']); ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="depName">Department Name:</label>
        <input type="text" id="depName" name="depName" required><br><br>
        
        <label for="depHead">Department Head:</label>
        <input type="text" id="depHead" name="depHead" required><br><br>
        
        <label for="depTelno">Department Telno:</label>
        <input type="text" id="depTelno" name="depTelno" required><br><br>
        
        <input type="submit" name="submit" value="Update Department">
    </form>
</body>
</html>