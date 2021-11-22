<?php session_start();?>
<html>
    <head>
        <title>Sign In playlist</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link rel="icon" href="images/favicon.gif" type="image/gif" sizes="32x32">
        <script src="js/init-login.js"></script>
    </head>
    <body>
            <?php
            $username=$pass="";
            $Err="";
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $flag=true;
                if(empty($_POST["username"])){
                    echo "<script>errorList.push('username*Username is required');</script>";
                    $flag= false;
                }
                else{
                    $username = cleaninput($_POST["username"]);
                }
                if(empty($_POST["pass"])){
                    echo "<script>errorList.push('pass*Password is required');</script>";
                    $flag= false;
                }
                else{
                    $pass = cleaninput($_POST["pass"]);
                }
                if($flag){
                    $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                    if(!$conn->connect_error){
                        $sql = "SELECT uid, fullname, artistName FROM users WHERE username = '".$username."' AND password='".$pass."';";
                        $result = $conn->query($sql);
                        if($result->num_rows == 0){
                            echo "<script>errorList.push('username*Username does not match');</script>";
                            echo "<script>errorList.push('pass*Password does not match');</script>";
                            $conn->close();
                        }
                        else{
                            $row = $result->fetch_assoc();
                            $_SESSION["valid"]=true;
                            $_SESSION["timeout"]=time();
                            $_SESSION["uid"] = $row["uid"];
                            $_SESSION["fname"] = $row["fullname"];
                            $_SESSION["artistName"] = $row["artistName"];
                            if(isset($_POST["return"])){
                                header("Location:".htmlspecialchars($_POST["return"]));
                            }
                            else{
                                header("Location:index.php");
                            }
                            $conn->close();
                        }
                    }
                    else{
                        $Err = "Error Connecting ".$conn->connect_error;
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
                <form class="loginform" id="login-form" method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <span class="loginformtitle">
                                ACCOUNT LOGIN
                        </span>
                        <div class="login-input-wrap left-corner" tag="Username">
                            <input type="text" name="username" id="username" class="login-text validate-input">
                            <span class="label-login-input">Username</span>
                        </div>
                        <div class="login-input-wrap right-corner" tag="Password">
                            <input type="password" name="pass" id="pass" class="login-text validate-input">
                            <span class="label-login-input">Password</span>
                        </div>
                        <div class="login-form-btn-wrap">
                            <input type="submit" value="SIGN IN" id="sbmt" class="login-form-btn">  
                        </div>
                        <?php 
                            if($Err!=""){
                                echo "<div class='error text-center'>".$Err."</div>";
                            }
                        ?>
                        <div class="text-center">
                                <a href="#">
                                    Forgot password?
                                </a>
                                <a href="signup.php">
                                        Create Account
                                </a>
                        </div>
                        <?php
                        foreach($_GET as $name => $value) {
                        $name = htmlspecialchars($name);
                        $value = htmlspecialchars($value);
                        echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
                        }
                        ?>
                </form>
            </div>
        </div>
        <script src="js/login.js"></script>
    </body>
</html>