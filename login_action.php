<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    echo "Already logged in!"
    exit;
}
 
// Define variables and initialize with empty values
$email = $psw = "";
$email_err = $psw_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["uname"]))){
        $email_err = "Please enter username.";
    } else{
        $email = trim($_POST["uname"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["psw"]))){
        $psw_err = "Please enter your password.";
    } else{
        $psw = trim($_POST["psw"]);
    }

    //database details. You have created these details in the third step. Use your own.
    $host = "db4free.net";
    $username = "ragawebuser";
    $password = "Super*38";
    $dbname = "ragawebmysql";

    //create connection
    $con = new mysqli($host, $username, $password, $dbname);
    //check connection if it is working or not
    if ($con->connect_error)
    {
        die("Connection failed!" . mysqli_connect_error());
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err))
    {
        // Prepare a select statement
        $sql = "SELECT emailID, PASSWORD FROM Register WHERE emailID = '$email'";
        
        //fire query to save entries and check it with if statement
        $rs = $con->query($sql);

        if(!$rs->num_rows = 0)
        {
            echo "Username or password is wrong!"
        }

        $row = $rs->fetch_assoc();

        $result_emailID = $row["emailID"];
        $result_password = $row["PASSWORD"];
            
        if(password_verify($psw, $result_password))
        {
            // Password is correct, so start a new session
            session_start();
                            
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $email;                            
                            
            // Redirect user to welcome page
            header("location: welcome.php");
        } 
        else
        {
            // Password is not valid, display a generic error message
            $login_err = "Invalid username or password.";
        }
    }
} 
?>