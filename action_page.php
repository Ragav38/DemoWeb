<?php
if(!empty($_POST))
    {
        $email = $_POST['email'];
        $psw = password_hash($_POST['psw'], PASSWORD_DEFAULT);
        $type = $_POST['membership'];
        
        //database details. You have created these details in the third step. Use your own.
        $host = "db4free.net";
        $username = "ragawebuser";
        $password = "Super*38";
        $dbname = "ragawebmysql";

        //create connection
        $con = mysqli_connect($host, $username, $password, $dbname);
        //check connection if it is working or not
        if (!$con)
        {
            die("Connection failed!" . mysqli_connect_error());
        }
        //This below line is a code to Send form entries to database
        $sql = "INSERT INTO Register (emailID, PASSWORD, userType) VALUES ('$email', '$psw', '$type')";
        //fire query to save entries and check it with if statement
        $rs = mysqli_query($con, $sql);
        if($rs)
        {
            echo "User successfully registered!";
        }
      	else{
         	echo "Error, Something's Wrong!"; 
        }
      //connection closed.
        mysqli_close($con);
    }
?>
