var sideOpen = true;
// browserWindowheight = window.innerHeight;
// document.getElementsByClassName("container")[0].style.height = browserWindowheight;
// document.getElementsByClassName("container")[0].style.maxHeight = browserWindowheight;
function sideToggle(){
    if(sideOpen){
        document.getElementsByTagName("nav")[0].style.width = "48px";
        document.getElementById("searchbox").style.display = "none";
        document.getElementById("searchicon").style.display = "inline";
        sideOpen = false;
    }
    else{
        document.getElementsByTagName("nav")[0].style.width = "23%";
        document.getElementById("searchbox").style.display = "block";
        document.getElementById("searchicon").style.display = "none";
        sideOpen = true;
    }
}