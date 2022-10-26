<?php
// Initialize the session
session_start();
// Including the config file
require_once "connection.php";
 
// Variable are initialize with empty values
$fullname = $phone ="";
$new_fullname_err = $new_phone_err = "";

// Data being processed when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

 //validating the full name
 if(empty(trim($_POST["fullname"]))){
    $new_fullname_err = "Please enter your last name.";
}else{
    $fullname = trim($_POST["fullname"]);
}

//validating the phone number
if(empty(trim($_POST["phone"]))){
    $new_phone_err = "Please enter your phone number.";
    }else if (!preg_match( "/^[\W][0-9]{3}?[\s]?[0-9]{2}?[\s]?[0-9]{3}[\s]?[0-9]{4}$/", $_POST["phone"])){
        $new_phone_err= "please enter a valid phone number";
    }
else{
    $phone = trim($_POST["phone"]);
}


// Checking the input errors before updating into the database
if(empty($new_fullname_err) && empty($new_phone_err)){
    // Prepare an update statement
    $sql = "UPDATE phonebook SET pname = ?, pphoned = ? WHERE pid= 1";
      // Binding variables to parameters
    if($stmt = $mysqli->prepare($sql)){
     
        $stmt->bind_param("ss", $store_fullname, $store_phone);
          // Setting parameters
          $store_fullname = $fullname;
          $store_phone = $phone;
         
        
        // Attemptings to execute the prepared statement
        if($stmt->execute()){  
            $_SESSION["fullname"] =  $fullname;
            $_SESSION["phone"] = $phone; 
            
            header("location: display.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Closing the statement
        $stmt->close();
    }
}

// Close connection
$mysqli->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Input information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
        <div class="container">
                    <div class="section-header">
                        <h2 class="title" style="text-align: center;">Update</h2>
                    </div>
                    <form class="form-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($new_fullname_err)) ? 'has-error' : ''; ?>">
                    <label>Full Name</label>
                    <input type="text" name="fullname" class="form-control" value="<?php echo $_SESSION["fullname"];?>" placeholder="Full Name" >
                    <span class="help-block"><?php echo $new_fullname_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($new_phone_err)) ? 'has-error' : ''; ?>">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" class="form-control" value="<?php echo $_SESSION["phone"];?>" placeholder="tel" >
                    <span class="help-block"><?php echo $new_phone_err; ?></span>
                </div>
                <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">Update Form</button>
                        </div>
                    </form>
            </div>
</body>
</html>