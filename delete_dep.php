<?php
    session_start();
    include 'conn.php';

    $id = $_GET['delete'];

    $sql = "DELETE FROM Departments WHERE depCode = '$id'";
    if($conn->query($sql)){
        $_SESSION['success'] = "DEPARTMENT DELETED SUCCESSFULLY!!";
    }
    else{
        $_SESSION['error'] = "INVALID ACTION!!";
    }

    header('location:department.php');
?>