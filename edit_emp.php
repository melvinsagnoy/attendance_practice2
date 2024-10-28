<?php
    session_start();
    include 'conn.php';

    $departments = [];
    $sql = "SELECT depCode, depName FROM Departments";
    $result = $conn->query($sql);
    if($result){
        while($row = $result->fetch_assoc()){
            $departments[] = $row;
        }
    }

    $id = $_GET['edit'];
    $sql = "SELECT * FROM Employees WHERE empID = '$id'";

    $empresult = $conn->query($sql);
    $row = $empresult->fetch_assoc();

    if(isset($_POST['update'])){
        $empID = $_POST['empID'];
        $depCode = $_POST['depCode'];
        $empFName = $_POST['empFName'];
        $empLName = $_POST['empLName'];
        $empRPH = $_POST['empRPH'];

        $sql = "UPDATE Employees SET empFName = '$empFName', empLName = '$empLName', empRPH = '$empRPH' WHERE empID = '$id'";

        if($conn->query($sql)){
            $_SESSION['success'] = "EMPLOYEE UPDATED SUCCESSFULLY!!";
        }
        else{
            $_SESSION['error'] = "INVALID ACTION!!";
        }
        header('location:employee.php');
    }
    
?>
<form method = "post">
    <label>Employee ID: </label>
    <input type = "text" name = "empID" value = "<?=$row['empID'];?>" readonly>
    <br><br>
    <label>First Name: </label>
    <input type = "text" name = "empFName" value = "<?=$row['empFName'];?>">
    <br><br>
    <label>Last Name: </label>
    <input type = "text" name = "empLName" value = "<?=$row['empLName'];?>">
    <br><br>
    <label>Department: </label>
    <select name = "depCode">
    <?php
        foreach($departments as $department):
    ?>
    <option value = "<?=$department['depCode'];?>"><?=$department['depName'];?></option>
    <?php
        endforeach;
    ?>
    </select>
    <br><br>
    <label>RPH: </label>
    <input type = "number" name = "empRPH" value = "<?=$row['empRPH'];?>">
    <br><br>
    <button type = "submit" name = "update">UPDATE EMPLOYEE</button>
</form>
