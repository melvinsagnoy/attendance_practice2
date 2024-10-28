<?php
    session_start();
    include 'conn.php';

    $id= $_GET['delete'];

    $sql = "DELETE FROM Employees WHERE empID = '$id'";

    if($conn->query($sql)){
        $_SESSION['success'] = "EMPLOYEE SUCCESSFULLY DELETED!!";
    }
    else{
        $_SESSION['error'] = "INVALID ACTION";
    }
    header('location:employee.php');
?>