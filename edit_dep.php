<?php

session_start();
include 'conn.php';


$id = $_GET['edit'];

$sql = "SELECT * FROM Departments WHERE depCode = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


if(isset($_POST['update'])){
    $depCode = $_POST['depCode'];
    $depName = $_POST['depName'];
    $depHead = $_POST['depHead'];
    $depTelNo = $_POST['depTelNo'];


    $sql = "UPDATE Departments SET depName = '$depName', depHead = '$depHead', depTelNo = '$depTelNo' WHERE depCode = '$id'";

    if($conn->query($sql)){
        $_SESSION['success'] = "DEPARTMENT UPDATED SUCCESSFULLY!!";
    }
    else{
        $_SESSION['error'] = "INVALID ACTION";
    }

    header('location:department.php');
}
?>
<h3>UPDATE DEPARTMENT</h3>
<form method = "post">
    <label>Department Code: </label>
    <input type = "text" name = "depCode" value = "<?=$row['depCode'];?>" readonly required>
    <br><br>
    <label>Department Name: </label>
    <input type = "text" name = "depName" value = "<?=$row['depName'];?>" required>
    <br><br>
    <label>Department Head: </label>
    <input type = "text" name = "depHead" value = "<?=$row['depHead'];?>" required>
    <br><br>
    <label>Department TEL NO: </label>
    <input type = "text" name = "depTelNo" value = "<?=$row['depTelNo'];?>" required>
    <br><br>
    <button type = "submit" name = "update" >UDPATE</button>
</form>