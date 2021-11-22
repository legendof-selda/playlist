<?php
session_start();
    if(!isset($_SESSION["uid"]) || empty($_SESSION["uid"])){
        header("Location: login.php?return=player.php%3Fside%3Dm%26top%3Dsong"); /*?->%3F =->%3D &->%26 */
        exit();
    }
    if(!isset($_GET["side"])){
        $_GET["side"] = "m";
    }
    if(!isset($_GET["top"])){
        $_GET["top"] = "song";
    }
    ini_set('upload_max_filesize', '10M');
    ini_set('post_max_size', '10M');
    ini_set('max_input_time', 300);
    ini_set('max_execution_time', 300);
?>
<html>
    <head>
        <title>playlist player</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="images/favicon.gif" type="image/gif" sizes="32x32">
        <link rel="stylesheet" type="text/css" href="css/player.css">
        <link rel="stylesheet" type="text/css" href="css/avatar.css">
        <link rel="stylesheet" type="text/css" href="css/dropdown.css">
        <link rel="stylesheet" type="text/css" href="css/toasts.css">
        <link rel="stylesheet" type="text/css" href="css/window-modal.css">
        <script src="js/init-player.js"></script>
    </head>
    <body>
        <div class="alert warning" id="jsalert" style="display:none; z-index: 5;">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        <span id="jsmsg"></span>
        </div> 
    <?php
        $songName=""; //message("alofo","info");
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                if(isset($_POST["songFileUploaded"])){
                    $flag=true;
                    if(empty($_FILES["songFile"]["name"])){
                        message("Select a file", "warning");
                        $flag= false;
                    }
                    else{
                        $fileType = strtolower(pathinfo($_FILES["songFile"]["name"],PATHINFO_EXTENSION));
                        //message($fileType,"info");
                        //message($_FILES["songFile"]["size"], "info");
                        if ($_FILES["songFile"]["size"] > 9000000) {
                            message("Sorry, your file is too large.", "warning");
                            $uploadOk = 0;
                        }
                        if($fileType!="mp3" && $fileType!="wav" && $fileType!="ogg"){
                            message("Only mp3, ogg, wav files supported", "info");
                            $flag= false;
                        }
                    }
                    if(empty($_POST["songName"])){
                        message("Song Name is Required", "warning");
                        $flag= false;
                    }
                    else{
                        $songName = cleaninput($_POST["songName"]);
                    }
                    if(empty($_POST["album"])){
                        message("Select Album", "warning");
                        $flag= false;
                    }
                    else{
                        $aid = cleaninput($_POST["album"]);
                    }
                    if(empty($_POST["genre"])){
                        message("Select Genre", "warning");
                        $flag= false;
                    }
                    else{
                        $gid = cleaninput($_POST["genre"]);
                    }
                    if(empty($_POST["privacy"])){
                        message("Select Privacy", "warning");
                        $flag= false;
                    }
                    else{
                        $privacy = cleaninput($_POST["privacy"]);
                    }
                    if(empty($_POST["TrackNo"])){
                        message("Enter Track Number", "warning");
                        $flag= false;
                    }
                    else{
                        $TrackNo = (int) cleaninput($_POST["TrackNo"]);
                        if(!($TrackNo >=1 && $TrackNo <=1000)){
                            message("Track Number should be between 1 and 1000", "warning");
                            $flag=false;
                        }
                    }
                    if(empty($_POST["DiscNo"])){
                        message("Enter Disc Number", "warning");
                        $flag= false;
                    }
                    else{
                        $DiscNo = (int) cleaninput($_POST["DiscNo"]);
                        if(!($DiscNo >=1 && $DiscNo <=1000)){
                            message("Disc Number should be between 1 and 1000", "warning");
                            $flag=false;
                        }
                    }
                    $duration="313";
                    if($flag){
                        $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                        if($conn->connect_error){
                            message("Connection failed: ".$conn->connect_error, "error");
                        }
                        $target_dir = "c:/uploads/songs";
                        $target_file = $target_dir ."/";
                        $sql = "INSERT INTO songs(uid, songName, aid, gid, TrackNo, DiscNo, duration, privacy, ext) VALUES(".$_SESSION["uid"].", '".$songName."', ".$aid.", ".$gid.", ".$TrackNo.", ".$DiscNo.", ".$duration.", '".$privacy."', '".$fileType."');";
                        //$last_id=1; message($sql, "info");
                        if($conn->query($sql)===TRUE){
                            $last_id = $conn->insert_id;
                            $target_file.=$last_id.".".$fileType;
                        }
                        else{
                            message("Error: ".$sql." = ".$conn->error, "error");
                        }
                        $uploadOk = 1;
                        if (file_exists($target_file)) {
                            message("Sorry, file already exists.", "error");
                            $uploadOk = 0;
                        }
                        if ($uploadOk == 0) {
                            deleteFromDb($last_id);
                            message("Sorry, your file was not uploaded.", "error");
                        }
                        else {
                            if (move_uploaded_file($_FILES["songFile"]["tmp_name"], $target_file)) {
                                message(basename( $_FILES["songFile"]["name"]). " added to playlist", "success");
                            } else {
                                deleteFromDb($last_id);
                                message("Sorry, there was an error uploading your file.", "error");
                            }
                        }
                        $conn->close();
                    }
                }
                if(isset($_POST["addAlbum"])){
                    $albumName=$desc="";
                    $flag=true;
                    if(empty($_POST["albumName"])){
                        message("Album Name is Required", "warning");
                        $flag= false;
                    }
                    else{
                        $albumName = cleaninput($_POST["albumName"]);
                    }
                    if(!empty($_POST["albumDesc"])){
                        $desc = "'".cleaninput($_POST["albumDesc"])."'";
                    }
                    else{
                        $desc = "NULL";
                    }
                    if($flag){
                        $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                        if($conn->connect_error){
                            message("Connection failed: ".$conn->connect_error, "error");
                        }
                        $sql = "INSERT INTO albums(albumName, Description, uid) VALUES ('".$albumName."', ".$desc.", ".$_SESSION["uid"].");";
                        if($conn->query($sql)===TRUE){
                            message("New ".$albumName." Album added", "success");
                        }
                        else{
                            message("Error: ".$sql." = ".$conn->error, "error");
                        }
                    }
                }
                if(isset($_POST["songFileUpdate"])){
                    $flag=true;
                    $sid = $_POST["Esid"];
                    if(empty($_POST["EsongName"])){
                        message("Song Name is Required", "warning");
                        $flag= false;
                    }
                    else{
                        $songName = cleaninput($_POST["EsongName"]);
                    }
                    if(empty($_POST["Ealbum"])){
                        message("Select Album", "warning");
                        $flag= false;
                    }
                    else{
                        $aid = cleaninput($_POST["Ealbum"]);
                    }
                    if(empty($_POST["Egenre"])){
                        message("Select Genre", "warning");
                        $flag= false;
                    }
                    else{
                        $gid = cleaninput($_POST["Egenre"]);
                    }
                    if(empty($_POST["Eprivacy"])){
                        message("Select Privacy", "warning");
                        $flag= false;
                    }
                    else{
                        $privacy = cleaninput($_POST["Eprivacy"]);
                    }
                    if(empty($_POST["ETrackNo"])){
                        message("Enter Track Number", "warning");
                        $flag= false;
                    }
                    else{
                        $TrackNo = (int) cleaninput($_POST["ETrackNo"]);
                        if(!($TrackNo >=1 && $TrackNo <=1000)){
                            message("Track Number should be between 1 and 1000", "warning");
                            $flag=false;
                        }
                    }
                    if(empty($_POST["EDiscNo"])){
                        message("Enter Disc Number", "warning");
                        $flag= false;
                    }
                    else{
                        $DiscNo = (int) cleaninput($_POST["EDiscNo"]);
                        if(!($DiscNo >=1 && $DiscNo <=1000)){
                            message("Disc Number should be between 1 and 1000", "warning");
                            $flag=false;
                        }
                    }
                    if($flag){
                        $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                        if($conn->connect_error){
                            message("Connection failed: ".$conn->connect_error, "error");
                            $flag=false;
                        }
                        $sql = "UPDATE songs SET songName='".$songName."', aid=".$aid.", gid=".$gid.", privacy='".$privacy."', TrackNo=".$TrackNo.", DiscNo=".$DiscNo." WHERE sid=".$sid." AND uid=".$_SESSION["uid"].";";
                        if($conn->query($sql)===TRUE){
                            message($songName." updated", "success");
                        }
                        else{
                            message("Error: ".$sql." = ".$conn->error, "error");
                            $flag=false;
                        }
                    }
                    else{
                        $_GET["editsong"]=$sid;
                    }
                }
                if(isset($_POST["deleteSong"])){
                    $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                    if($conn->connect_error){
                        die("Connection failed: ".$conn->connect_error);
                    }
                    $sql = "DELETE FROM songs WHERE sid=".cleaninput($_POST["deletesid"])." AND uid=".$_SESSION["uid"].";";
                    if($conn->query($sql)){
                        message($_POST["deletesongName"]." deleted", "success");
                    }
                    else{
                        message($sql." = ".$conn->error, "error");
                    }
                    $conn->close();
                }
            }
            function deleteFromDb($file_no){
                $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                if($conn->connect_error){
                    die("Connection failed: ".$conn->connect_error);
                }
                $sql = "DELETE FROM songs WHERE sid=".$file_no.";";
                if($conn->query($sql)){

                }
                else{
                    echo $sql." = ".$conn->error;
                }
                $conn->close();
            }
            function cleaninput($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            function message($msg, $type){
                echo "<div class='alert ".$type."'><span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>".$msg."</div>";
            }
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
        ?>
        <nav>
            <a href="javascript:void(0)" onclick="sideToggle();" class="navbutton"><img src="icons/menu.png" class="icon" /></a>
            <div class="sidenavbar">
                <img src="icons/search.png" class="icon" id="searchicon" /><form id="searchbox"><input type="search" id="search" placeholder="Search" /></form>
                <a href="index.php" class="navitem"><img src="images/faviconwhite.png" class="icon" /><span>&nbsp Home</span></a>
                <a href="player.php?side=m&top=<?php echo $_GET["top"]; ?>" class="<?php if($_GET["side"]=="m"){echo"selectednavitem ";} ?>navitem"><img src="icons/music.png" class="icon" /><span>&nbsp My Music</span></a>
                <a href="player.php?side=r&top=<?php echo $_GET["top"]; ?>" class="<?php if($_GET["side"]=="r"){echo"selectednavitem ";} ?>navitem"><img src="icons/recent.png" class="icon" /><span>&nbsp Recent</span></a>
                <a href="#" class="navitem"><img src="icons/nowplaying.png" class="icon" /><span>&nbsp Now Playing</span></a>
                <hr style="width:90%; opacity: 0.2;"/>
                <a class="navitem" id="addMusic"><img src="icons/add.png" class="icon" /><span>&nbsp Add Music</span></a>
                <a class="navitem" id="addAlbum"><img src="icons/addAlbum.png" class="icon" /><span>&nbsp Add Album</span></a>
            </div>
        </nav>
        <div class="container" id="content">
            <div class="header">
                <div class="titlebar">
                    
                    <?php
                        if(!isset($_GET["side"])){
                            echo "<h2 class='titleitem'>My Music</h2>";
                            $_GET["side"]="m";
                        }
                        elseif($_GET["side"]=="m"){
                            echo "<h2 class='titleitem'>My Music</h2>";
                        }
                        elseif($_GET["side"]=="r"){
                            echo "<h2 class='titleitem'>Recent plays</h2>";
                        }
                        /*Log user options*/
                    ?>
                    <div class="avatardropdown titleitem" style="float:right;">
                        <div class="avatardropbtn"><img src="<?php echo avatar(); ?>" class="avatarIcon"><?php echo $_SESSION["artistName"] ?></div>
                        <div class="avatar-options">
                            <a href="accountSettings.php" target="_blank">Account Settings</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
                <div class="topnavbar">
                    <a href="player.php?side=<?php echo $_GET["side"]; ?>&top=song" class="<?php if($_GET["top"]=="song"){echo"selectednavitem ";} ?>navitem">Songs</a>
                    <a href="player.php?side=<?php echo $_GET["side"]; ?>&top=album" class="<?php if($_GET["top"]=="album"){echo"selectednavitem ";} ?>navitem">Albums</a>
                    <a href="player.php?side=<?php echo $_GET["side"]; ?>&top=artist" class="<?php if($_GET["top"]=="artist"){echo"selectednavitem ";} ?>navitem">Artists</a>
                </div>
            </div>
            <div class="main">
                <?php
                    function dropdown($sid, $songName){
                        $r = '<td style="width:10px; height:10px;"><div tabindex="0" class="dropdown">'.
                        '<div class="dropbtn">...</div>'.
                        '<div class="options">'.
                        '<a href="">Play</a>'.
                        '<a href="player.php?side='.$_GET["side"].'&top='.$_GET["top"].'&editsong='.$sid.'">Edit Info</a>'.
                        '<a href="player.php?side='.$_GET["side"].'&top='.$_GET["top"].'&showsong='.$sid.'">Properties</a>'.
                        '<a class="deleteBtn" onclick="deleteBtnClick(\''.$sid.'\', \''.$songName.'\');">Delete</a>'.
                        '</div></div></td>';
                        return $r;
                    }
                ?>
                <?php
                    $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                    $result = $conn->query("SELECT * FROM userMusic WHERE uid=".$_SESSION["uid"].";");
                    if ($result->num_rows > 0) {
                        echo "<div class='table-responsive'>
                            <table class='table table-striped table-hover table-condensed'>"; //cellpadding='15'>";
                        while($row = $result->fetch_assoc()){
                            echo "<tr>"."<td>".$row["songName"]."</td>"."<td>".$row["albumName"]."</td>"."<td>".$row["artistName"]."</td>"."<td>".$row["genreName"]."</td>".dropdown($row["sid"], $row["songName"])."</tr>";
                        }
                        echo " </table></div>";
                    }
                    else{
                        echo "<h2>Nothing in your playlist</h2>";
                    }
                    mysqli_close($conn);
                ?> 
            </div>
        </div>
        <?php
            function selectOptions($table, $id, $name, $selected){
                $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                $sql = "SELECT * FROM ".$table;
                if($table=="albums"){$sql.=" WHERE uid=".$_SESSION["uid"];}
                $sql.=" ORDER BY ".$name.";";
                $result = $conn->query($sql);
                echo '<option value="NULL"';
                    if(empty($selected) || $selected==false)
                        echo ' selected';
                if($table=="albums"){
                    echo '><--Select Album--></option>';
                }
                elseif($table=="genre"){
                    echo '><--Select Genre--></option>';
                }
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        if($row[$id]==$selected){
                            echo "<option value='".$row[$id]."' selected>".$row[$name]."</option>";
                        }                            
                        else{
                            echo "<option value='".$row[$id]."'>".$row[$name]."</option>";
                        }
                    }
                }
                $conn->close();
            }
            function selectOptionsPrivacy($selected){
                echo '<option value="public"';
                    if($selected=="public"){echo ' selected';}
                echo '>Public</option>';
                echo '<option value="friends"';
                    if($selected=="friends"){echo ' selected';}
                echo '>Friends</option>';
                echo '<option value="private"';
                    if($selected=="private"){echo ' selected';}
                echo '>Private</option>';
            }
        ?>
        <!-- Add Music Modal -->
        <div id="modalAddMusic" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                <span id="musicClose" class="close">&times;</span>
                <h2>Upload song</h2>
                </div>
                <form method="post" name="songUpload" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return songUploadValidate();" enctype="multipart/form-data">
                <div class="modal-body">
                <table style="border-collapse: collapse; border:none; padding:10px; width:70%" cellpadding="10">
                   <tr><td>Upload File</td><td><input type="hidden" name="MAX_FILE_SIZE" value="9000000" /> <input type="file" name="songFile" id="songFile" accept="audio/&ast;" required></td></tr>
                   <tr><td>Song Name</td><td><input type="text" name="songName" id="songName" required></td></tr>
                   <tr><td>Track Number</td><td><input type="number" name="TrackNo" id="TrackNo" max="1000" min="1" required></td></tr>
                   <tr><td>Disc Number</td><td><input type="number" name="DiscNo" id="DiscNo" max="1000" min="1" required></td></tr>
                    <tr><td>Album</td><td><select name="album" id="album" required>
                            <?php
                                selectOptions("albums", "aid", "albumName", false);
                            ?>
                    </select></td></tr>
                    <tr><td>Genre</td><td><select name="genre" id="genre" required>
                        <?php
                            selectOptions("genre", "gid", "genreName", false);
                        ?>
                    </select></td></tr>
                    <tr><td>Privacy</td><td><select name="privacy" id="privacy" required>
                        <?php
                            selectOptionsPrivacy("public");
                        ?>
                    </select></td></tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Add to playlist" name="songFileUploaded" class="Button">
                </div>
                </form>
            </div>
        </div>
        <!-- Edit Music Modal -->
        <?php
            if(isset($_GET["editsong"])){
                $sid=$_GET["editsong"];
                if(filter_var($sid, FILTER_VALIDATE_INT)){
                    $songName=$TrackNo=$DiscNo=$aid=$gid=$privacy="";
                    $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                    $result = $conn->query("SELECT * FROM songs WHERE uid=".$_SESSION["uid"]." AND sid=".$sid.";");
                    $row = $result->fetch_assoc();
                    $songName = $row["songName"]; $TrackNo = $row["TrackNo"]; $DiscNo = $row["DiscNo"]; $aid=$row["aid"]; $gid = $row["gid"]; $privacy = $row["privacy"];
                    echo '<div id="modalEditMusic" class="modal" style="display:block;">
                    <div class="modal-content">
                    <div class="modal-header">
                    <a href="player.php?side='.$_GET["side"].'&top='.$_GET["top"].'" class="close">&times;</a>
                    <h2>Edit Song Info</h2>
                    </div>
                    <form method="post" name="songEdit" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                    <div class="modal-body">
                    <table style="border-collapse: collapse; border:none; padding:10px; width:70%" cellpadding="10">';
                    echo '<tr><td>Song Name</td><td><input type="text" name="EsongName" id="songName" value="'.$songName.'" required></td></tr>';
                    echo '<tr><td>Track Number</td><td><input type="number" name="ETrackNo" id="ETrackNo" max="1000" min="1" value="'.$TrackNo.'" required></td></tr>';
                    echo '<tr><td>Disc Number</td><td><input type="number" name="EDiscNo" id="EDiscNo" max="1000" min="1" value="'.$DiscNo.'" required></td></tr>';
                    echo '<tr><td>Album</td><td><select name="Ealbum" id="Ealbum" required>';
                    selectOptions("albums", "aid", "albumName", $aid);
                    echo '</select></td></tr>';
                    echo '<tr><td>Genre</td><td><select name="Egenre" id="Egenre" required>';
                    selectOptions("genre", "gid", "genreName", $gid);
                    echo '</select></td></tr>';
                    echo '<tr><td>Privacy</td><td><select name="Eprivacy" id="Eprivacy" required>';
                    selectOptionsPrivacy($privacy);
                    echo '</select></td></tr>';
                    echo '</table>';
                    echo '<input type="hidden" name="Esid" id="Esid" value="'.$sid.'">';
                    echo '</div><div class="modal-footer">
                    <input type="submit" value="Make changes" name="songFileUpdate" class="Button">';
                    echo '</div></form></div></div>';
                }
            }
        ?>
        <!-- Show Music Modal -->
        <?php
            if(isset($_GET["showsong"])){
                $sid=$_GET["showsong"];
                if(filter_var($sid, FILTER_VALIDATE_INT)){
                    $songName=$TrackNo=$DiscNo=$aid=$gid=$privacy="";
                    $conn = new mysqli("localhost", "root", "3333333", "playlistDB");
                    $result = $conn->query("SELECT * FROM userMusic WHERE sid=".$sid.";");
                    $row = $result->fetch_assoc();
                    $songName = $row["songName"]; $TrackNo = $row["TrackNo"]; $DiscNo = $row["DiscNo"]; $albumName=$row["albumName"]; $genre = $row["genreName"]; $privacy = $row["privacy"];
                    $duration = (float)$row["Duration"];
                    $duration/=60;
                    $mins = floor($duration);
                    $duration -= $mins;
                    $duration*=60;
                    echo '<div class="modal" style="display:block;">
                    <div class="modal-content">
                    <div class="modal-header">
                    <a href="player.php?side='.$_GET["side"].'&top='.$_GET["top"].'" class="close">&times;</a>
                    <h2>Song Info</h2>
                    </div>
                    <form method="post" name="songEdit" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                    <div class="modal-body" style="text-align:center;">
                    <table style="border-collapse: collapse; border:none; padding:10px; width:70%" cellpadding="10">';
                    echo '<tr><td>Song Name</td><td>'.$songName.'</td>';
                    echo '<td>Album</td><td>'.$albumName.'</td></tr>';
                    echo '<tr><td>Artist</td><td>'.$row["artistName"].'</td>';
                    echo '<td>Genre</td><td>'.$genre.'</td></tr>';
                    echo '<tr><td>Track Number</td><td>'.$TrackNo.'</td>';
                    echo '<td>Disc Number</td><td>'.$DiscNo.'</td></tr>';
                    echo '<tr><td>Privacy</td><td>'.$privacy.'</td>';
                    echo '<td>Type</td><td>'.$row["ext"].'</td></tr>';
                    echo '<tr><td>Uploaded On</td><td>'.date("Y-m-d",strtotime($row["CreatedOn"])).'</td>';
                    echo '<td>Duration</td><td>'.$mins.":".$duration.'</td></tr>';
                    echo '</table>';
                    echo '</div><div class="modal-footer" style="height:10px;">';
                    echo '</div></form></div></div>';
                }
            }
        ?>
        <!-- Add Album Modal -->
        <div id="modalAddAlbum" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                <span id="albumClose" class="close">&times;</span>
                <h2>Add Album</h2>
                </div>
                <form method="post" name="albumUpload" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return albumUploadValidate();">
                <div class="modal-body">
                    <table cellpadding="10">
                        <tr><td>Album Name</td><td><input type="text" name="albumName" id="albumName" required></td></tr>
                        <tr><td>Description</td><td><textarea name="albumDesc" id="albumDesc"></textarea></td></tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Create Album" name="addAlbum" class="Button">
                </div>
                </form>
            </div>
        </div>
        <!--Delete Music Modal -->
        <div id="modalDeleteMusic" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                <h2>Delete</h2>
                </div>
                <form method="post" name="songDelete" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="modal-body" style="height:60px;">
                    Are You Sure You Want to delete <span id="songToDelete"></span>?
                    <input type="hidden" name="deletesid" id="deletesid">
                    <input type="hidden" name="deletesongName" id="deletesongName">
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Yes" name="deleteSong" class="Button"><input type="button" id="deleteClose" class="Button" onclick="document.getElementById('modalDeleteMusic').style.display='none';" value="No">
                </div>
                </form>
            </div>
        </div>
        <script src="js/toasts.js"></script>
        <script src="js/player.js"></script>
    </body>
</html>