<?php
    session_start();
    include 'conn.php';

    if(isset($_POST['add'])){
        $depName = $_POST['depName'];
        $depHead = $_POST['depHead'];
        $depTelNo = $_POST['depTelNo'];

        $sql = "INSERT INTO departments (depName, depHead, depTelNo) VALUES ('$depName', '$depHead', '$depTelNo')";

        if($conn->query($sql)){
            $_SESSION['success'] = "SUCCESSFULLY ADDED DEPARTMENT";
        }
        else{
            $_SESSION['error'] = "ERROR ADDING DEPARTMENT";
        }
        header('location:department.php');
    }
?>
<html>
    <body align = "center">
        <h3>ADD DEPARTMENT</h3>
        <form method = "post">
            <label>Department Name: </label>
            <input type = "text" name = "depName" required>
            <br><br>
            <label>Department Head: </label>
            <input type = "text" name = "depHead" required>
            <br><br>
            <label>Department TEL NO: </label>
            <input type = "text" name = "depTelNo" required>
            <br><br>
            <button type = "submit" name = "add" >ADD</button>
        </form>
    </body>
</html>