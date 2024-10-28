<?php
    session_start();
    include 'conn.php';



    
?>
<html>
    <head>
        <body>
            <div align = "center">
                <a href = "add_dep.php">Add a Department Here | </a>
                <a href = "index.php">Back to Menu</a> 
            </div>
            <?php
                if(isset($_SESSION['success'])){
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                }
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
            ?>
            <br>
            <table border = "1" align = "center">
                <th>Department Code </th>
                <th>Department Name</th>
                <th>Department Head</th>
                <th>Department Tel.No</th>
                <th>ACTIONS</th>
            <?php
                $sql = "SELECT * FROM Departments ORDER BY depCode ASC";

                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
            ?>
            <tr>
                <td><?=$row['depCode'];?></td>
                <td><?=$row['depName'];?></td>
                <td><?=$row['depHead'];?></td>
                <td><?=$row['depTelNo'];?></td>
                <td>
                    <a href = "edit_dep.php?edit=<?=$row['depCode'];?>">EDIT</a>
                    <a href = "delete_dep.php?delete=<?=$row['depCode'];?>" onclick = "return confirm('Are you sure you want to delete?')">DELETE</a>
                </td>
            </tr>
            <?php
                }
            }
            ?>
             </table>
        </body>
    </head>
</html>