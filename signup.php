<?php session_start(); ?>
<html>
    <head>
        <title>Sign In playlist</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link rel="icon" href="images/favicon.gif" type="image/gif" sizes="32x32">
        <script src="js/init-login.js"></script>
    </head>
    <body>
        <?php
            $fname=$username=$pass=$confPass=$email=$artist=$dob="";
            $Err="";
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $flag=true;
                if(empty($_POST["fname"])){
                    echo "<script>errorList.push('fname*Full Name is required');</script>";
                    $flag= false;
                }
                else{
                    $fname = cleaninput($_POST["fname"]);
                }
                if(empty($_POST["username"])){
                    echo "<script>errorList.push('username*Username is required');</script>";
                    $flag= false;
                }
                else{
                    $username = cleaninput($_POST["username"]);
                    $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                    if($conn->connect_error){
                        $Err = "Error Connecting ".$conn->connect_error;
                    }
                    else{
                        $sql = "SELECT username FROM users WHERE username = '".$username."';";
                        $result = $conn->query($sql);
                        if($result->num_rows!=0){
                            echo "<script>errorList.push('username*Username exists');</script>";
                            $flag= false;
                        }
                        $conn->close();
                    }
                }
                if(empty($_POST["pass"])){
                    echo "<script>errorList.push('pass*Password is required');</script>";
                    $flag= false;
                }
                else{
                    $pass = cleaninput($_POST["pass"]);
                    if(!preg_match("/^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&?]).*$/", $pass)){
                        echo "<script>errorList.push('pass*Password must contain atleast one digit, uppercase letter and special character');</script>";
                        $flag= false;
                    }
                }
                if(empty($_POST["confPass"])){
                    echo "<script>errorList.push('confPass*Confirmed password is required');</script>";
                    $flag= false;
                }
                else{
                    $confPass = cleaninput($_POST["confPass"]);
                    if($confPass!=$pass){
                        echo "<script>errorList.push('confPass*Password is not matching');</script>";
                        $flag= false;
                    }
                }
                if(empty($_POST["email"])){
                    echo "<script>errorList.push('email*Email ID is required');</script>";
                    $flag= false;
                }
                else{
                    $email = cleaninput($_POST["email"]);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "<script>errorList.push('email*Invalid Email ID');</script>";
                        $flag= false;
                    }
                }
                if(empty($_POST["artist"])){
                    echo "<script>errorList.push('artist*Artist is required');</script>";
                    $flag= false;
                }
                else{
                    $artist = cleaninput($_POST["artist"]);
                    if(strlen($artist)>20){
                        echo "<script>errorList.push('artist*Artist name maximum 20 characters');</script>";
                        $flag= false;
                    }
                }
                if(empty($_POST["dob"])){
                    echo "<script>errorList.push('dob*Date of birth is required');</script>";
                    $flag= false;
                }
                else{
                    $dob = cleaninput($_POST["dob"]);
                }
                if($flag){
                    $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                    if($conn->connect_error){
                        $Err = "Error Connecting ".$conn->connect_error;
                    }
                    else{
                        $sql = "INSERT INTO users(username, password, fullname, emailID, artistName, dob) VALUES('".$username."', '".$pass."', '".$fname."', '".$email."', '".$artist."', '".$dob."');";
                        if($conn->query($sql)){
                            $_SESSION["valid"]=true;
                            $_SESSION["timeout"]=time();
                            $_SESSION["uid"] =  $conn->insert_id;;
                            $_SESSION["fname"] = $fname;
                            $_SESSION["artistName"] = $artist;
                            $conn->close();
                        }
                        else{
                            $Err = "Error Creating profile ".$conn->error;
                            $conn->close();
                        }
                    }
                }
            }
            function cleaninput($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
        <div class="container">
            <div class="loginwrap">
                <form class="loginform" id="signup-form" method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <span class="loginformtitle">
                                CREATE ACCOUNT
                        </span>
                        <div class="login-input-wrap top full" data-validate="Full Name is required" tag="Full Name">
                            <input type="text" name="fname" id="fname" class="login-text validate-input" value="<?php echo $fname; ?>">
                            <span class="label-login-input">Enter Full name</span>
                        </div>
                        <div class="login-input-wrap full" data-validate="Username is required" tag="Username">
                                <input type="text" name="username" id="username" class="login-text validate-input" value="<?php echo $username; ?>">
                                <span class="label-login-input">Enter Username</span>
                        </div>
                        <div class="login-input-wrap full" data-validate="Password is required" tag="Password">
                            <input type="password" name="pass" id="pass" class="login-text validate-input" value="<?php echo $pass; ?>">
                            <span class="label-login-input">Enter Password</span>
                        </div>
                        <div class="login-input-wrap full" data-validate="Confirm Password is required" tag="Confirm Password">
                                <input type="password" name="confPass" id="confPass" class="login-text validate-input" value="<?php echo $confPass; ?>">
                                <span class="label-login-input">Confirm Password</span>
                        </div>
                        <div class="login-input-wrap full" data-validate="Email ID is required" tag="Email ID">
                            <input type="text" name="email" id="email" class="login-text validate-input" value="<?php echo $email; ?>">
                            <span class="label-login-input">Enter Email ID</span>
                        </div>
                        <div class="login-input-wrap full" data-validate="Artist Name is required" tag="Artist Name">
                            <input type="text" name="artist" id="artist" class="login-text validate-input" value="<?php echo $artist; ?>">
                            <span class="label-login-input">Enter Artist Name</span>
                        </div>
                        <div class="login-input-wrap full" data-validate="Date of Birth is required" tag="Date of Birth">
                                <input type="date" name="dob" id="dob" class="login-text validate-input" value="<?php echo $dob; ?>">
                                <span class="label-login-input">Enter Date of Birth</span>
                        </div>
                        <!--<div class="login-textarea-wrap full">
                                <textarea name="description" id="description" class="login-text"></textarea>
                                <span class="label-login-input">About You</span>
                        </div>-->
                        <div class="login-form-btn-wrap">
                            <input type="submit" value="SIGN UP" id="sbmt" class="login-form-btn">  
                        </div>
                        <?php 
                            if($Err!=""){
                                echo "<div class='error text-center'>".$Err."</div>";
                            }
                        ?>
                        <div class="text-center">
                                <a href="login.php">
                                    Sign In
                                </a>
                        </div>
                </form>
            </div>
        </div>
        <script src="js/login.js"></script>
    </body>
</html>