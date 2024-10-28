<?php
    session_start();
    include 'conn.php';
?>

<html>
    <head>
        <body>
            <div align = "center">
                <a href = "record.php">Record Attendance Here | </a>
                <a href = "index.php">Back to Menu</a>
            </div>
            <?php
                if(isset($_SESSION['success'])){
                    echo $_SESSION['success'];
                    unset ($_SESSION['success']);
                }
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                    unset ($_SESSION['errpr']);
                }
            ?>
            <br><br>
            <table border = "1" align = "center">
                <th>Record #</th>
                <th>Employee ID</th>
                <th>DATE/ TIME IN</th>
                <th>DATE/ TIME OUT</th>
                <th>STATUS</th>
                <th>ACTION</th>
                <?php
                $sql = "SELECT * FROM attendance ORDER BY attRN ASC";

                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                ?>
                <tr>
                    <td><?=$row['attRN'];?></td>
                    <td><?=$row['empID'];?></td>
                    <td><?=$row['attDate'];?> | <?=$row['attTimeIn'];?></td>
                    <td><?=$row['attDate'];?> | <?=$row['attTimeOut'];?></td>
                    <td><?=$row['attStat'];?></td>
                    <td><a href = "cancel_att.php?cancel=<?=$row['attRN'];?>" onclick = "return confirm('Are you sure want to Cancel the attendance of Employee <?=$row['empID'];?>?')" ><button style = "background-color:red;color:white;">Cancel</button></a></td>
                </tr>
                <?php
                    }
                }
                ?>
            </table>
        </body>
    </head>
</html>