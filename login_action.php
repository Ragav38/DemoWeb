<?php
// Initialize the session
session_start();
 
// Define variables and initialize with empty values
$email = $psw = "";
$email_err = $psw_err = $login_err = "";

$uri = $_SERVER['REQUEST_URI'];
//echo $uri; // Outputs: URI
 
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
 
$url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url_error = str_replace("login_action.php", "login_error.html", $url, $count);
$url_success = str_replace("login_action.php", "login_success.html", $url, $count);
 
// Processing form data when form is submitted
//if($_SERVER["REQUEST_METHOD"] == "POST"){
//if (isset($_POST['submit'])){
if(!empty($_POST)){
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
        //$psw = password_hash(trim($_POST["psw"]), PASSWORD_BCRYPT);
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
        die("Connection failed!".mysqli_connect_error());
    }
    
    // Validate credentials
    if(empty($email_err) && empty($psw_err))
    {
        // Prepare a select statement
        $sql = "SELECT emailID, PASSWORD FROM Register WHERE emailID = '$email'";
        
        //fire query to save entries and check it with if statement
        $rs = mysqli_query($con,$sql);
        //$rs = $con->query($sql);
     
        if(mysqli_num_rows($rs) == 0)
        {
            //echo "Username or password is wrong!";
            //echo $url_error;
            header("location:$url_error");
            exit();
        }

        //$row = $rs->fetch_assoc();
        $row = mysqli_fetch_row($rs);

        $result_emailID = $row["emailID"];
        $result_password = $row["PASSWORD"];
            
        if(password_verify($psw, $result_password))
        {
            // Password is correct, so start a new session
            //session_start();
                            
            // Store data in session variables
            //$_SESSION["loggedin"] = true;
            //$_SESSION["username"] = $email;                            
            // Redirect user to welcome page
            header("location:$url_success");
            //exit();
        } 
        else
        {
            // Password is not valid, display a generic error message
            //$login_err = "Invalid username or password.";
            header("location:$url_error");
        }
    }
} 
?>
