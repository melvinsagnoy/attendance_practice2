
<?php
session_start();
include 'conn.php';

$totalhours = 0;
$attendance_record = [];

function calculateHours($TimeIn, $TimeOut){
    $interval = (new DateTime($TimeIn))->diff(new DateTime($TimeOut));
    return $interval->h + ($interval->i / 60);
}

if(isset($_POST['searchDate'])){
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];

    $sql = "SELECT * FROM attendance WHERE attDate BETWEEN '$dateFrom' AND '$dateTo'";

    $result = $conn->query($sql);
    if($result){
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $attendance_record[] = $row;
                $totalhours += calculateHours($row['attTimeIn'], $row['attTimeOut']);     
            }
        } else {
            // Set error if no records found
            $_SESSION['error'] = "NO SUCH DATA IN THE DATE RANGE!";
            header('location:search_by_date.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "ERROR IN QUERY!";
        header('location:search_by_date.php');
        exit();
    }
}
?>

<html>
    <head>
        <body>
            <h3>ATTENDANCE MONITORING BY DATE</h3>
            <a href = "index.php">Back To Menu</a>
            <br><br>
            <form method = "post">
                <label>Date From: </label>
                <input type = "date" name = "dateFrom"> 
                <label>Date To: </label>
                <input type = "date" name = "dateTo"> 
                <input type = "submit" name = "searchDate">
            </form>
            <?php
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
            ?>
            <table border = "1" align = "center">
            <th>RECORD #</th>
            <th>Employee ID</th>
            <th>Date/ Time In</th>
            <th>Date/ Time Out</th>
            <th>Total</th>
            <?php foreach($attendance_record as $record):?>
            <tr>
                <td><?=$record['attRN'];?></td>
                <td><?=$record['empID'];?></td>
                <td><?=$record['attDate'];?>, <?=$record['attTimeIn'];?></td>
                <td><?=$record['attDate'];?>, <?=$record['attTimeOut'];?></td>
                <td><?=number_format(calculateHours($record['attTimeIn'], $record['attTimeOut']), 2)?></td>
            </tr>
            <?php endforeach; ?>
            </table>
            <div align = "center">
                <label>Date Generated: <?=date('Y-m-d')?></label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>Total: <?=$totalhours?></label>
            </div>
        </body>
    </head>
</html>