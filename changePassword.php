<?php session_start();
    if(!isset($_SESSION["uid"])){
        header("Location: login.php");
    }
?>
<html>
    <head>
        <title>Change Password</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link rel="icon" href="images/favicon.gif" type="image/gif" sizes="32x32">
        <script src="js/init-login.js"></script>
    </head>
    <body>
        <?php
            $oldpass=$newpass=$confPass="";
            $username="";
            $Err="";
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $flag=true;
                if(empty($_POST["oldpass"])){
                    echo "<script>errorList.push('oldpass*Old Password is required');</script>";
                    $flag= false;
                }
                else{
                    $oldpass = cleaninput($_POST["oldpass"]);
                    $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                    if($conn->connect_error){
                        $Err = "Error Connecting ".$conn->connect_error;
                    }
                    else{
                        $sql = "SELECT username FROM users WHERE password = '".$oldpass."' AND uid = ".$_SESSION["uid"].";";
                        $result = $conn->query($sql);
                        if($result->num_rows==0){
                            echo "<script>errorList.push('oldpass*Incorrect Password');</script>";
                            $flag= false;
                        }
                        else{
                            $row = $result->fetch_assoc();
                            $username = $row["username"];
                        }
                        $conn->close();
                    }
                }
                if(empty($_POST["newpass"])){
                    echo "<script>errorList.push('newpass*New Password is required');</script>";
                    $flag= false;
                }
                else{
                    $newpass = cleaninput($_POST["newpass"]);
                    if(!preg_match("/^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&?]).*$/", $newpass)){
                        echo "<script>errorList.push('pass*New Password must contain atleast one digit, uppercase letter and special character');</script>";
                        $flag= false;
                    }
                }
                if(empty($_POST["confPass"])){
                    echo "<script>errorList.push('confPass*Confirmed password is required');</script>";
                    $flag= false;
                }
                else{
                    $confPass = cleaninput($_POST["confPass"]);
                    if($confPass!=$newpass){
                        echo "<script>errorList.push('confPass*Password is not matching');</script>";
                        $flag= false;
                    }
                }
                if($flag){
                    $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                    if($conn->connect_error){
                        $Err = "Error Connecting ".$conn->connect_error;
                    }
                    else{
                        $sql = "UPDATE users SET password = '".$newpass."' WHERE username = '".$username."';";
                        if($conn->query($sql)){
                            session_unset();
                            session_destroy();
                            header("Location: login.php");
                            $conn->close();
                        }
                        else{
                            $Err = "Error Updating Password ".$conn->error;
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
                                CHANGE PASSWORD
                        </span>
                        <div class="login-input-wrap top full" data-validate="Old Password is required" tag="Old Password">
                            <input type="password" name="oldpass" id="oldpass" class="login-text validate-input" value="<?php echo $oldpass; ?>">
                            <span class="label-login-input">Enter Old Password</span>
                        </div>
                        <div class="login-input-wrap full" data-validate="New Password is required" tag="New Password">
                            <input type="password" name="newpass" id="newpass" class="login-text validate-input" value="<?php echo $newpass; ?>">
                            <span class="label-login-input">Enter New Password</span>
                        </div>
                        <div class="login-input-wrap full" data-validate="Confirm Password is required" tag="Confirm Password">
                                <input type="password" name="confPass" id="confPass" class="login-text validate-input" value="<?php echo $confPass; ?>">
                                <span class="label-login-input">Confirm Password</span>
                        </div>
                        <div class="login-form-btn-wrap">
                            <input type="submit" value="CHANGE PASSWORD" id="sbmt" class="login-form-btn l"><input type="button" value="cancel" class="login-form-btn r" onclick="window.open('','_parent',''); window.close();">
                        </div>
                        <?php 
                            if($Err!=""){
                                echo "<div class='error text-center'>".$Err."</div>";
                            }
                        ?>
                </form>
            </div>
        </div>
        <script src="js/login.js"></script>
    </body>
</html>