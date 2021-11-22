var close = document.getElementsByClassName("closebtn");
windowload = function() {
    var alerts = document.getElementsByClassName("alert");
    if(alerts.length>0){
        for(var i=0; i<alerts.length; i++){
            alerts[i].style.top="0";
        }
    }
    for (var i = 0; i < close.length; i++) {
        close[i].onclick = function(){
            var div = this.parentElement;
            div.style.top = "-40px";
            setTimeout(function(){ div.style.display = "none"; }, 800);
        }
        timeoutAlert(close[i], i, close.length);
    }
};
function timeoutAlert(closebtn, i, length){
    setTimeout(function(){closebtn.click();}, (length-i)*4000);
}
function message(msg){
    document.getElementById("jsmsg").innerHTML = msg;
    document.getElementById("jsalert").style.display="block";
    document.getElementById("jsalert").style.top="0";
}