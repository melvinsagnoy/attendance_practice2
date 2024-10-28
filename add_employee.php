<?php
    session_start();
    include 'conn.php';

    $departments = [];

    $sql = "SELECT depCode, depName FROM Departments";
    $result = $conn->query($sql);
    if($result){
        while($row= $result->fetch_assoc()){
            $departments[] = $row;
        }
    }

    if(isset($_POST['add'])){
        $empFName = $_POST['empFName'];
        $empLName = $_POST['empLName'];
        $depCode = $_POST['depCode'];
        $empRPH = $_POST['empRPH'];

        $sql = "INSERT INTO Employees (empFName, empLName, depCode, empRPH) VALUES ('$empFName', '$empLName', '$depCode', '$empRPH') ";

        if($conn->query($sql)){
            $_SESSION['success'] = "EMPLOYEE SUCCESSFULLY ADDED!!";
        }
        else{
            $_SESSION['error'] = "INVALID ACTION!!";
        }
        header('location:employee.php');
    }
?>
<h3 align = "center">ADD EMPLOYEE</h3>
<form method = "post">
    <label>First Name: </label>
    <input type = "text" name = "empFName">
    <br><br>
    <label>Last Name: </label>
    <input type = "text" name = "empLName">
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
    <input type = "number" name = "empRPH">
    <br><br>
    <button type = "submit" name = "add">ADD EMPLOYEE</button>
</form>