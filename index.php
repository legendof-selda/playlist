<?php session_start(); ?>
<html>
    <head>
        <title>playlist</title>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
        <link rel="icon" href="images/favicon.gif" type="image/gif" sizes="32x32">
        <link rel="stylesheet" type="text/css" href="css/avatar.css">
        <style>
            @font-face{
                font-family: "English157BT";
                src: url(fonts/English157BT.ttf)
            }
            * {
                margin: 0px; 
                padding: 0px; 
                box-sizing: border-box;
            }
            .container{
                width:100%;
                min-height: 100vh;
                margin: 0 auto;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                background-color: black;
            }
            .navnormal, .nav-mini{
                display:block;
                position: fixed;
                top:0;
                width:100%;
                /* overflow: hidden; */
                text-align: center;

                transition: all 0.4s;
                -webkit-transition: all 0.4s;
                -o-transition: all 0.4s;
                -moz-transition: all 0.4s;
            }
            .navnormal{
                height: 92px;
                z-index: 100;
                background: transparent;
                color: white;
                margin: 30px 0px 38px 0px;
                padding: 20px;
            }
            .nav-mini{
                height: 52px;
                z-index: 100;
                background: #333;
                color: white;
                margin: 0;
                padding: 0 !important;
            }
            .navnormal a.navitem, .nav-mini a.navitem{
                float: left;
                display: block;
                color: white;
                text-align: center;
                text-decoration: none;
                background-color: transparent;
                height: 100%;
                text-transform: uppercase;

                transition: all 0.4s;
                -webkit-transition: all 0.4s;
                -o-transition: all 0.4s;
                -moz-transition: all 0.4s;
            }
            .navnormal a.navitem{
                padding: 14px 16px;
                font-size: 20px;
            }
            .navnormal a.navitem:hover{
                background-color: rgba(221,221,221,0.2);
            }
            .nav-mini a.navitem{
                padding: 10px 12px;
                padding-top: auto;
                font-size: 16px;
            }
            .nav-mini a.navitem:hover{
                background-color: #ddd;
            }
            a.navitem.rtside{
                float: right;
            }
            .rtside{
                float:right;
            }
            .navnormal .avatardropdown.rtside{
                margin-right: -20px;
            }
            .nav-mini .avatardropdown.rtside{
                margin-right: 0;
            }
            .navnormal a.logo{
                display: block;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                background: url(images/logowhite.png) no-repeat;
                background-size: auto 52px;
                width: 136px; /* Width of new image */
                height: 52px; /* Height of new image */
                padding-left: 136px; /* Equal to width of new image */
                margin-right: 10px;
            }
            .nav-mini a.logo{
                display: block;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                background: url(images/faviconwhite.png) no-repeat;
                background-size: auto 52px;
                width: 52px; /* Width of new image */
                height: 52px; /* Height of new image */
                padding-left: 52px;
                margin-right: 5px;
            }
            .carousel{
                overflow:hidden;
                width:100%;
            }
            @keyframes carousel{
                0%    { left:0; }
                11%   { left:0; }
                12.5% { left:-100%; }
                23.5% { left:-100%; }
                25%   { left:-200%; }
                36%   { left:-200%; }
                37.5% { left:-300%; }
                48.5% { left:-300%; }
                50%   { left:-400%; }
                61%   { left:-400%; }
                62.5% { left:-300%; }
                73.5% { left:-300%; }
                75%   { left:-200%; }
                86%   { left:-200%; }
                87.5% { left:-100%; }
                98.5% { left:-100%; }
                100%  { left:0; }
            }
            .panes{
                list-style:none;
                position:relative;
                width:400%; /*No. of images * 100%*/
                overflow:hidden;
                    
                -moz-animation:carousel 30s infinite;
                -webkit-animation:carousel 30s infinite;
                animation:carousel 30s infinite;
            }
            .panes > li{
                position:relative;
                float:left;
                width:25%; /* 100 / number of panes */
                overflow:hidden;
            }
            .panes img{
                display:block;
                width:100%;
                max-width:100%;
            }
            .panes h2{
                font-size:1em;
                padding:0.5em;
                position:absolute;
                right:10px;
                bottom:10px;
                left:10px;
                text-align:right;
                color:#fff;
                background-color:rgba(0,0,0,0.75);
            }
            .ad-head{
                font-family: "Interstate","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Garuda,Verdana,Tahoma,sans-serif;
                font-weight: 100;
                line-height: 1.2;
                font-size: 36px;
                margin-bottom: 17px;
                color: white;
            }
            .ad-row:after{
                content: "";
                display: table;
                clear: both;
            }
            .ad-col{
                width: 50%;
                float:left;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                    $(window).scroll(function(){
                    if($(window).scrollTop()>100)
                        $("nav").addClass("nav-mini");
                    else
                        $("nav").removeClass("nav-mini");                
                    });
                });
        </script>
    </head>
    <body>
        <nav class="navnormal">
            <a href="index.php" class="navitem logo"></a>
            <?php
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
                if(isset($_SESSION["uid"])){
                    echo '<a href="player.php" class="navitem">PLAYER</a>';
                    echo '<a href="" class="navitem">WALL</a>';
                    echo '<a href="" class="navitem">FRIENDS</a>';
                    echo '<div class="avatardropdown rtside">
                    <div class="avatardropbtn"><img src="'.avatar().'" class="avatarIcon">'.$_SESSION["artistName"].'</div>
                    <div class="avatar-options">
                        <a href="accountSettings.php" target="_blank">Account Settings</a>
                        <a href="logout.php">Logout</a>
                    </div></div>';
                }
                else{
                    echo '<a href="login.php" class="navitem rtside">Log In</a>';
                    echo '<a href="signup.php" class="navitem rtside">Create Account</a>';
                }
            ?>
        </nav>
        <div class="container">
            <div class="carousel">
                <ul class="panes">
                    <li><img src="images/home/c4.jpg"></li>
                    <li><img src="images/home/c1.png"></li>
                    <li><img src="images/home/c2.jpg"></li>
                    <li><img src="images/home/c2.jpg"></li>
                </ul>
            </div>
            <div class="card">
                <h3>Find all you Songs in one Place!</h3>
            </div>
            <div class="card">
                <div class="ad-row">
                    <div class="ad-col">
                        <div class="ad-head">Never stop listening</div>
                            <p class="g-type-marketing-info">playlist is available on Web, iOS, Android, Sonos, Chromecast, and Xbox One.</p>
                        <div class="frontMobileTeaser__links">
                            <a class="g-appStoreButton g-appStoreButton__appStore sc-ir" href="https://itunes.apple.com/us/app/soundcloud/id336353151?mt=8" target="_blank">
                                Download on the App Store
                            </a>
                            <a class="g-appStoreButton g-appStoreButton__googlePlay sc-ir" href="https://play.google.com/store/apps/details?id=com.soundcloud.android&amp;hl=us" target="_blank">
                                Get it on Google Play
                            </a>
                        </div>
                    </div>  
                    <div class="ad-col">
                        <div class="frontMobileTeaser__deviceWrapper">
                            <figure class="frontMobileTeaser__device"></figure>
                        </div>
                    </div>
            </div>
        </div>
    </body>
</html>