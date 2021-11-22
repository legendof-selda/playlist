<!DOCTYPE html>
<html>
    <head>
        <title>playlist</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            var sideOpen = false;
            // browserWindowheight = window.innerHeight;
            // document.getElementsByClassName("container")[0].style.height = browserWindowheight;
            // document.getElementsByClassName("container")[0].style.maxHeight = browserWindowheight;
            function sideToggle(){
                if(sideOpen){
                    document.getElementsByClassName("sidenavbar")[0].style.width = "40px";
                    document.getElementById("search").style.display = "none";
                    document.getElementById("search").style.width = "0px";
                    sideOpen = false;
                }
                else{
                    document.getElementsByClassName("sidenavbar")[0].style.width = "200px";
                    document.getElementById("search").style.display = "inline";
                    document.getElementById("search").style.width = "143px";
                    sideOpen = true;
                }
            }
            $('.navitem').click(function(e){
                $('.navitem').css("border-bottom", "5px solid transparent");
                $(this).css("border-bottom", "5px solid white");
            });
        </script>
        <style>
        html, body {margin:0;padding:0;height:100%;}
        body {
            font-family: "Lato", sans-serif;
            background-color: black;
        }
        .icon
        {
           width: 25px;
           height: 25px; 
        }
        .nav{
            background-color:rgb(23, 23, 23);;
        }
        .navitem{
                white-space: normal;
                float:left;
                width:auto;
                display:block;
                padding: 12px 24px;
                vertical-align: middle;
                text-align: center;
                color:white;
                background-color: inherit;
                cursor: pointer;
                text-decoration: none;
                border-bottom:5px solid transparent;
        }
        a.navitem{
            text-decoration:none !important;
        }
        .navitem:hover, .navitem:active, .navitem:visited{
            text-decoration:none !important;
            color:white !important;
        }
        .w3-bar > .navitem:hover{
            border-bottom:5px solid white;
        }
        .sidenavbar{
            position: absolute;
            left:0;
            bottom: 0;
            /*top: 51px;*/
            margin: 0;
            padding: 0;
            width: 40px;
            background-color:rgb(23, 23, 23);
            height: 100%; 
            overflow: hidden;
            transition: width 0.25s linear 0s;
        }
        .sidenavbar > .navitem{
            display: block;
            color: #fff;
            padding: 8px 16px 8px 5px;
            text-decoration: none;
            width: 200px;
            text-align: left;
            border-left:5px solid transparent;
            height: 46px;
            overflow: hidden;
        }
        .sidenavbar > .navitem:hover{
            background-color: #555;
            color: white;
        }
        .sidenavbar > .selectednavitem{
            border-left:5px solid turquoise;
            border-bottom: none;
        }
        .selectednavitem{
            border-bottom:5px solid turquoise;
        }
        .w3-content{
            max-width:2000px;margin-top:46px;
            /*background-image: url("wallpaper.jpg");*/
        }
        #searchbox{
            /*border: 1px solid white;
            background: #555;
            color: black;*/
            display: block;
            padding: 8px 16px 8px 5px;
            border-left:5px solid transparent;
            overflow: hidden;
            height: 46px !important;
        }
        #search{
            background: 10px #444;
            /*visibility: hidden;*/
            width: 143px;
            /*padding: 0;
            padding-left: 12px;*/
            font: bold 12px Arial,Helvetica,Sans-serif;
            padding: 6px 6px;
            display:none;
        }
        .table-striped > tbody > tr:nth-child(even){
            background-color:rgb(23, 23, 23);;
            color: white;
        }
        .table-striped > tbody > tr:nth-child(odd){
            background-color: #000;
            color: white;
        }
        .table-striped > tbody > tr:hover{
            background-color: #555;
        }
        .table th, .table td { 
            border-top: none !important; 
            
        }
        .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td
        {
            padding: 12px 24px !important;
        }
        ::-webkit-scrollbar {
            width: 5px;
        }
        
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        }
        ::-webkit-scrollbar-thumb {
            background-color: darkgrey;
            border-radius: 5px;
            opacity:0.8;
            /*visibility: hidden;*/
        }
        #content:hover{
            overflow:auto;
        }
        #content, .container-fluid, .span9
        {
            overflow:hidden;
            height:100%;
        }​
        </style>
    </head>
    <body>
        <!-- Navbar -->
        <div class="w3-top navbar navbar-fixed-top">
        <div class="w3-bar w3-card-2 nav navbar-nav">
            <!--<a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>-->
            <a href="javascript:void(0)" onclick="sideToggle();" style="padding: 12px 24px; float:left; padding-left:0px; border-left:5px solid transparent;"><img src="icons/menu.png" class="icon" /></a>
            <a href="#songs" class="navitem selectednavitem">Songs</a>
            <a href="#albums" class="navitem">Albums</a>
            <a href="#artists" class="navitem">Artists</a>
            <a href="#artists" class="navitem">Playlists</a>
            <!--<a href="#songs" class="navitem w3-bar-item w3-button w3-padding-large">Songs</a>
            <a href="#albums" class="navitem w3-bar-item w3-button w3-padding-large">Albums</a>
            <a href="#artists" class="navitem w3-bar-item w3-button w3-padding-large">Artists</a>-->
            <!--<div class="w3-dropdown-hover w3-hide-small">
            <button class="w3-padding-large w3-button" title="More">MORE <i class="fa fa-caret-down"></i></button>     
            <div class="w3-dropdown-content w3-bar-block w3-card-4">
                <a href="#" class="w3-bar-item w3-button">Merchandise</a>
                <a href="#" class="w3-bar-item w3-button">Extras</a>
                <a href="#" class="w3-bar-item w3-button">Media</a>
            </div>-->
            </div>
        </div>
        <!-- Navbar on small screens -->
        <div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
            <a href="#songs" class="navitem w3-bar-item w3-button w3-padding-large">Songs</a>
            <a href="#albums" class="navitem w3-bar-item w3-button w3-padding-large">Albums</a>
            <a href="#artists" class="navitem w3-bar-item w3-button w3-padding-large">Artists</a>
        </div>
        <!-- Side Navbar -->
        <div class="sidenavbar navbar navbar-left" >
            <a href="#" class="navitem" style="margin-bottom:15px;"></a>
            <form id="searchbox"><img src="icons/search.png" class="icon" /><input type="search" id="search" required="required" placeholder="Search" /></form>
            <!--<input id="submitsearch" type="submit" value=""-->
            <a href="#" class="navitem selectednavitem"><img src="icons/music.png" class="icon" />&nbsp My Music</a>
            <a href="#" class="navitem"><img src="icons/recent.png" class="icon" />&nbsp Recent</a>
            <a href="#" class="navitem"><img src="icons/nowplaying.png" class="icon" />&nbsp Now Playing</a>
        </div>
        <!-- Page content -->
        <div class="container container-fluid" id="content" style="padding-top:51px;">
            <div class="table-responsive"  style="height:100%;">
              <table class="table table-striped table-hover table-condensed" cellpadding="15">
                <?php
                    $conn = mysqli_connect("localhost", "root", "3333333", "playlist");
                    $res = mysqli_query($conn, "SELECT * FROM songs;");
                    if (mysqli_num_rows($res) > 0) {
                        while($row = mysqli_fetch_assoc($res)){
                            echo "<tr>"."<td>".$row["Name"]."</td>"."<td>".$row["Album"]."</td>"."<td>".$row["Artist"]."</td>"."<td>".$row["Genre"]."</td>"."</tr>";
                        }
                    }
                    mysqli_close($conn);
                ?>
              </table>
            </div> 
        </div>
    </body>
</html>