<?php
    session_start();
    include 'conn.php';

    $employee = null;
    $attendance_records = [];
    $RPH = 0;
    $salary = 0;
    $totalhours = 0;

    function calculateHours($TimeIn, $TimeOut){
        $interval = (new DateTime($TimeIn))->diff(new DateTime($TimeOut));
        return $interval->h +($interval->i / 60);
    }


    if(isset($_POST['search'])){
        $empID = $_POST['empID'];

        $empsql = "SELECT * FROM Employees INNER JOIN Departments ON Employees.depCode = Departments.DepCode WHERE empID = '$empID' ";
        $empresult = $conn->query($empsql);

        if($empresult && $empresult->num_rows > 0){
            $employee = $empresult->fetch_assoc();
            $RPH = $employee['empRPH'];

            $attsql = "SELECT * FROM attendance WHERE empID = '$empID'";
            $attresult = $conn->query($attsql);

            if($attresult){
                while ($row = $attresult->fetch_assoc() ){
                    $attendance_records[] = $row;
                    $totalhours += calculateHours($row['attTimeIn'],$row['attTimeOut']);
                }
                $salary = $RPH * $totalhours;
            }
        }
        else{
            $_SESSION['error'] = "INVALID ACTION";
            header('location:search_by_id.php'); 
            exit();  
        }
    }
?>
<html>
    <head>
        <body>
            <h3>ATTENDANCE MONITORING BY EMPLOYEE ID</h3>
            <a href = "index.php">Back to Menu</a><br><br>
            <form method = "post">
                <label>Input Employee #: </label>
                <input type = "text" name = "empID">
                <input type = "submit" name = "search">
            </form>
            <?php
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
            ?>
            <?php if($employee):?>
                <label>Name: </label>
                <input type = "text" value = "<?=$employee['empLName'];?>, <?=$employee['empFName'];?> " readonly>
                
                <div align = "right">
                <label>Department: </label>
                <input type = "text" value = "<?=$employee['depName'];?>" readonly>
                </div>
            <?php endif;?>
            <table border = "1" align = "center">
                <th>Record #</th>
                <th>Employee ID</th>
                <th>Date/ Time In</th>
                <th>Date/ Time Out</th>
                <th>Total</th>
                <?php foreach($attendance_records as $record):?>
                    <tr>
                        <td><?=$record['attRN'];?></td>
                        <td><?=$record['empID'];?></td>
                        <td><?=$record['attDate'];?>, <?=$record['attTimeIn'];?></td>
                        <td><?=$record['attDate'];?>, <?=$record['attTimeOut'];?></td>
                        <td>
                        <?= number_format(calculateHours($record['attTimeIn'], $record['attTimeOut']), 2) ?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
            <div align = "center">
                <label>Rate Per Hour: <?=number_format($employee['empRPH'],2);?></label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>Total Hours Work: <?=number_format($totalhours, 2);?></label>
                <br><br>
                <label>Salary: <?=number_format($salary, 2);?></label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>Date Generated: <?= date('Y-m-d')?></label>
            </div>
        </body>
    </head>
</html>
