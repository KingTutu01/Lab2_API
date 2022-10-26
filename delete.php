<?php
session_start();
include "connection.php"; // Using database connection file here

$del = mysqli_query($mysqli,"DELETE FROM phonebook where pid= 1"); // delete query

if($del)
{
    mysqli_close($mysqli); // Close connection
    header("location:display.php"); // redirects to all records page
   
}
else{
    echo "Error deleting record"; // display error message if not delete
}

?>