<?php
session_start();
include 'conn.php';

?>
<html>
    <head>
        <body>
            <div align = "center">
            <a href = "add_employee.php">Add a Employee Here | </a>
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
            <br><br>
            <table border = "1" align = "center">
                <th>Employee ID</th>
                <th>Department Name</th>
                <th>Name</th>
                <th>Rate Per Hour</th>
                <th>Actions</th>
                <?php
                    $sql = "SELECT * FROM Employees INNER JOIN Departments ON Employees.depCode = Departments.depCode";

                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                ?>
                    <tr>
                        <td><?=$row['empID'];?></td>
                        <td><?=$row['depName'];?></td>
                        <td><?=$row['empLName'];?>, <?=$row['empFName'];?></td>
                        <td><?=$row['empRPH'];?></td>
                        <td>
                            <a href = "edit_emp.php?edit=<?=$row['empID'];?>">EDIT</a>
                            <a href = "delete_emp.php?delete=<?=$row['empID'];?>" onclick = "return confirm('Are you sure you want to delete this Employee?')">DELETE</a>
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