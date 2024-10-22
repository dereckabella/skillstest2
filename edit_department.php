<?php
include 'connector.php';

// Check if depCode is set in the GET request
if (isset($_GET['depCode'])) {
    $depCode = $_GET['depCode'];
    
    // Fetch department details based on depCode
    $sql = "SELECT depCode, depName, depHead, depTelNo FROM departments WHERE depCode = '$depCode'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $department = $row;
        }
    } else {
        echo "Department not found.";
        exit();
    }
}

// Update department when the form is submitted
if (isset($_POST['submit'])) {
    $depCode = $_POST['depCode'];
    $depName = $_POST['depName'];
    $depHead = $_POST['depHead'];
    $depTelNo = $_POST['depTelNo'];

    $sql = "UPDATE departments SET depName = '$depName', depHead = '$depHead', depTelNo = '$depTelNo' WHERE depCode = '$depCode'";

    if($conn->query($sql) === TRUE) {
        echo "
            <script>
                alert('Department updated successfully');
                window.location.href='department.php';
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
        /* You can add your CSS here */
    </style>
</head>
<body>
    <form action="edit_department.php" method="POST">
        <!-- Department Code as a hidden field -->
        <input type="hidden" id="depCode" name="depCode" value="<?php echo $department['depCode']; ?>">

        <label for="depName">Department Name</label><br>
        <input type="text" id="depName" name="depName" value="<?php echo $department['depName']; ?>" required><br>

        <label for="depHead">Department Head</label><br>
        <input type="text" id="depHead" name="depHead" value="<?php echo $department['depHead']; ?>" required><br>

        <label for="depTelNo">Department Tel No</label><br>
        <input type="text" id="depTelNo" name="depTelNo" value="<?php echo $department['depTelNo']; ?>" required><br>

        <input type="submit" name="submit" value="Update Department">
    </form>
</body>
</html>
