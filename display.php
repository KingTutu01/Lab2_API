<?php
session_start();
// Including a config file to it
require_once "connection.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
                        <table style="width:100%";>
                                        <thead>
                                            <tr>
                                                <th>Full name</th>
                                                <th>Phone</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php 
                                                require_once('const.php');
                                                 $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                                 $sql = "SELECT * FROM phonebook";
                                                 $result = mysqli_query($mysqli, $sql);
                                                 while($row=mysqli_fetch_assoc($result)){
                                                     echo "
                                                     <tr>
                                                    <td>". $row['pname']. "</td>
                                                    <td>". $row['pphoned']. "</td>
                                                    <td><a href='update.php?pid=" .$row['pid']."'><button class='btn btn-primary btn-lg'>Edit</button></a></td>
                                                    <td><a href='delete.php' name='remove'><button class='btn btn-danger btn-lg'>Delete</button></a></td>
                                                    </tr>
                                                    ";
                                                 }
                                                ?>
                                        </tbody>
                                    </table> 
                                               
</head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding-top: 10px;
  padding-bottom: 20px;
  padding-left: 30px;
  padding-right: 40px;
}
</style>
<body>
</body>
</html>