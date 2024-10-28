<?php
    session_start();
    include 'conn.php';

    $employee = null;
    if(isset($_POST['search'])){
        $empID = $_POST['empID'];

        $sql = "SELECT * FROM Employees WHERE empID = '$empID'";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            $employee = $result->fetch_assoc();
        }
        else{
            $_SESSION['error'] = "NO SUCH EMPLOYEE";
            header('location:record.php');
            exit();
        }
    }
    
    if(isset($_POST['attendance'])){
        $empID = $_POST['empID'];
        $attDate = $_POST['attDate'];
        $attTimeIn = $_POST['attTimeIn'];
        $attTimeOut = $_POST['attTimeOut'];
        $attStat = $_POST['attStat'];

        $sql = "INSERT INTO attendance (empID, attDate, attTimeIn, attTimeOut, attStat) VALUES ('$empID', '$attDate', '$attTimeIn', '$attTimeOut', '$attStat')";

        if($conn->query($sql)){
            $_SESSION['success'] = "ATTENDANCE MARKED!!";
        }
        else{
            $_SESSION['error'] = "INVALID ACTION";
        }
        header('location:att_recording.php');
        exit();
    }
?>
<html>
    <head>
        <body>
            <?php if(!$employee):?>
            <form method = "post">
            <label>Employee ID: </label>
            <input type = "text" name = "empID">
            <button type = "submit" name = "search">Search</button>
            </form>
            <?php
                endif;
            ?>
            <?php
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                    unset ($_SESSION['error']);
                }
            ?>
            <?php if($employee):?>
            <form method = "post">
                <label>Employee ID: </label>
                <input type = "text" name = "empID" value = "<?=$employee['empID'];?>" readonly>
                <label>Employee Name: </label>
                <input type = "text" name = "empFullName" value = "<?=$employee['empLName'];?>, <?=$employee['empFName'];?>" readonly>
                <label>Date: </label>
                <input type = "date" name = "attDate">
                <label>Time In: </label>
                <input type = "time" name = "attTimeIn">
                <label>Time Out: </label>
                <input type = "time" name = "attTimeOut">
                <label>Status: </label>
                <input type = "text" name = "attStat" value = "Present" readonly>
                <button type = "submit" name = "attendance">Attendance</button>
            </form>
            <?php endif; ?>
        </body>
    </head>
</html>
