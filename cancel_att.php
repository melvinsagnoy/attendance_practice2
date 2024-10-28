<?php
    session_start();
    include 'conn.php';

    $attRN = $_GET['attRN'];

    if(isset($_GET['cancel'])){
        $attRN = $_GET['cancel'];

        $sql = "UPDATE attendance set attStat = 'Cancelled' WHERE attRN = '$attRN'";

        if($conn->query($sql)){
            $_SESSION['success'] = "ATTENDANCE CANCELLED SUCCESSFULLY!";
        }
        else{
            $_SESSION['error'] = "INVALID ACTION";
        }
        header('location:att_recording.php');
    }
?>