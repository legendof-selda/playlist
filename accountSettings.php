<?php
session_start();
    if(!isset($_SESSION["uid"]) || empty($_SESSION["uid"])){
        header("Location: login.php?return=accountSettings.php"); /*?->%3F =->%3D &->%26 */
        exit();
    }
?>
<html>
    <head>
        <title>Account Settings</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link rel="icon" href="images/favicon.gif" type="image/gif" sizes="32x32">
        <script src="js/init-login.js"></script>
        <style>
            #avatarImg{
                width:170px;
                height: 170px;
                border-radius:100%;
                margin:8px;
            }
        </style>
    </head>
    <body>
        <?php
            $fname=$email=$artist=$you="";
            $Err=""; $msg="";
            $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
            if($conn->connect_error){
                $Err = "Error Connecting ".$conn->connect_error;
            }
            else{
                $sql = "SELECT * FROM users WHERE uid = '".$_SESSION["uid"]."';";
                $result = $conn->query($sql);
                if($result->num_rows==1){
                    $row = $result->fetch_assoc();
                    $fname = $row["fullname"];
                    $email = $row["emailID"];
                    $artist = $row["artistName"];
                    $you = $row["you"];
                }
            }
            $conn->close();
            function avatar(){
                $avatar = "avatars/".$_SESSION["uid"].".jpg";
                $full = dirname(__FILE__)."/".$avatar;
                if(file_exists($full)){
                    return $avatar;
                }
                else{
                    return "icons/avatar.png";
                }
            }
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $flag=true;
                if(empty($_POST["fname"])){
                    echo "<script>errorList.push('fname*Full Name is required');</script>";
                    $flag= false;
                }
                else{
                    $fname = cleaninput($_POST["fname"]);
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
                if(!empty($_POST["description"])){
                    $you = cleaninput($_POST["description"]);
                    $you = str_replace("'", "\'", $you);
                    $you = "'".$you."'";
                }
                else{
                    $you="NULL";
                }
                if($flag){
                    $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                    if($conn->connect_error){
                        $Err = "Error Connecting ".$conn->connect_error;
                    }
                    else{
                        $sql = "UPDATE users SET fullname='".$fname."', emailID='".$email."', artistName='".$artist."', you=".$you." WHERE uid=".$_SESSION["uid"].";";
                        if($conn->query($sql)){
                            $_SESSION["valid"]=true;
                            $_SESSION["timeout"]=time();
                            $_SESSION["fname"] = $fname;
                            $_SESSION["artistName"] = $artist;
                            $msg = "Profile Updated!";
                            $you = cleaninput($_POST["description"]);
                            $conn->close();
                        }
                        else{
                            $Err = "Error Creating profile ".$conn->error;
                            $conn->close();
                        }
                    }
                    if(isset($_FILES["avatarFile"]) && !empty($_FILES["avatarFile"]["name"])){
                        $target_dir = dirname(__FILE__)."/avatars/";
                        $target_file = $target_dir.$_SESSION["uid"].".jpg";
                        $fileType = strtolower(pathinfo($_FILES["avatarFile"]["name"],PATHINFO_EXTENSION));
                        $uploadok=1;
                        if ($_FILES["avatarFile"]["size"] > 500000) {
                            $Err .= "Sorry, max file size 5MB. ";
                            $uploadOk = 0;
                        }
                        if($fileType != "png" && $fileType != "jpg" && $fileType != "gif") {
                            $Err.= "Only .png, .jpg, .gif files are allowed. ";
                            $uploadOk = 0;
                        }
                        if($uploadok){
                            if (file_exists($target_file)) {
                                unlink($target_file);
                            }
                            if (move_uploaded_file($_FILES["avatarFile"]["tmp_name"], $target_file)) {

                            } else {
                                $Err.="Sorry, there was an error uploading your avatar. ";
                            }
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
                <form class="loginform" id="signup-form" method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <span class="loginformtitle">
                                YOUR ACCOUNT
                        </span>
                        <div class="top full">
                            <img src="<?php echo avatar(); ?>" id="avatarImg" onclick="document.getElementById('avatarFile').click();"> <input type="file" name="avatarFile" id="avatarFile" style="visibility:hidden;" accept="image/&ast;">
                        </div>
                        <div class="login-input-wrap full" data-validate="Full name is required" tag="Full name">
                            <input type="text" name="fname" id="fname" class="login-text validate-input" value="<?php echo $fname; ?>">
                            <span class="label-login-input">Full name</span>
                        </div>
                        <div class="login-input-wrap full" data-validate="Artist name is required" tag="Artist name">
                            <input type="text" name="artist" id="artist" class="login-text validate-input" value="<?php echo $artist; ?>">
                            <span class="label-login-input">Artist name</span>
                        </div>
                        <div class="login-input-wrap full" data-validate="Email ID is required" tag="Email ID">
                            <input type="text" name="email" id="email" class="login-text validate-input has-val" value="<?php echo $email; ?>">
                            <span class="label-login-input">Email ID</span>
                        </div>
                        <div class="login-textarea-wrap full">
                            <textarea name="description" id="description" class="login-text"><?php echo $you; ?></textarea>
                            <span class="label-login-input">About You</span>
                        </div>
                        <div class="login-form-btn-wrap">
                            <input type="submit" value="UPDATE" id="sbmt" class="login-form-btn l"><input type="button" value="back" class="login-form-btn r"  onclick="window.open('','_parent',''); window.close();">
                        </div>
                        <?php 
                            if($Err!=""){
                                echo "<div class='error text-center'>".$Err."</div>";
                            }
                            if($msg!=""){
                                echo "<div class='msg text-center'>".$msg."</div>";
                            }
                        ?>
                        <div class="text-center">
                            <a href="changePassword.php" target="_blank">
                                Change Password
                            </a>
                        </div>
                </form>
            </div>
        </div>
        <script>
            document.getElementById('avatarFile').onchange = function(evt){
                var tgt = evt.target || window.event.srcElement,
                files = tgt.files;
                if (FileReader && files && files.length) {
                    var fr = new FileReader();
                    fr.onload = function () {
                        document.getElementById("avatarImg").src = fr.result;
                    }
                    fr.readAsDataURL(files[0]);
                }
            };
        </script>
        <script src="js/login.js"></script>
    </body>
</html>