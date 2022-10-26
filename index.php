<?php
session_start();
// Including a config file to it
require_once "connection.php";
 
// Variable are initialize with empty values
$fullname = $phone = "";
$fullname_err =  $phone_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
     
      //validating the full name
      if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter your last name.";
    }else{
        $fullname = trim($_POST["fullname"]);
    }
   
    //validating the phone number
    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter your phone number.";
        }else if (!preg_match( "/^[\W][0-9]{3}?[\s]?[0-9]{2}?[\s]?[0-9]{3}[\s]?[0-9]{4}$/", $_POST["phone"])){
            $phone_err= "please input the right information";
        }
    else{
        $phone = trim($_POST["phone"]);
    }
    
    //Checking the input errors before updating into the database
    if(empty($fullname_err) && empty($phone_err)){
        $sql = "INSERT INTO phonebook (pname, pphoned) VALUES (?, ?)";
        if($stmt = $mysqli->prepare($sql)){      
            $_SESSION["fullname"] = $fullname; 
            $_SESSION["phone"] = $phone;    
                ///// Storing Data session variables
                $store_fullname = $fullname;
                $store_phone = $phone;
            $stmt->bind_param("ss", $store_fullname,  $store_phone);
            // Attempting to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: display.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            
            }

            // Closing the statement
            $stmt->close();
        }
    }
    // Closing the connection
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
</style>
<body>
        <div class="container">
                    <div class="section-header">
                        <h2 class="title" style="text-align: center;">Login</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($fullname_err)) ? 'has-error' : ''; ?>">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" value="<?php echo $fullname; ?>">
                <span class="help-block"><?php echo $fullname_err; ?></span>   
            </div>
            <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone</label>
                <input type="tel" name="phone" class="form-control" placeholder="+233 548342152" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>   
            </div>
            <input type="hidden" name='pid' value="<?php echo $id; ?>">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Form</button>
                        </div>
                    </form>
            </div>
</body>
</html>
