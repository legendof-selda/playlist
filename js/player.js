var modalAddMusic = document.getElementById('modalAddMusic');
var btn = document.getElementById("addMusic");
var span = document.getElementById("musicClose");
btn.onclick = function() {
    modalAddMusic.style.display = "block";
}
span.onclick = function() {
    modalAddMusic.style.display = "none";
}
window.onclick = function(event) {
    if (event.target == modalAddMusic) {
        modalAddMusic.style.display = "none";
    }
};

function deleteBtnClick(sid, songName){
    document.getElementById('deletesid').value = sid;
    document.getElementById('deletesongName').value = songName;
    document.getElementById('songToDelete').innerHTML = songName;
    document.getElementById('modalDeleteMusic').style.display ='block';
}

var modalAddAlbum = document.getElementById('modalAddAlbum');
var btn1 = document.getElementById("addAlbum");
var span1 = document.getElementById("albumClose");
btn1.onclick = function() {
    modalAddAlbum.style.display = "block";
}
span1.onclick = function() {
    modalAddAlbum.style.display = "none";
}
window.onclick = function(event) {
    if (event.target == modalAddAlbum) {
        modalAddAlbum.style.display = "none";
    }
};

window.onload = windowload;

function songUploadValidate(){
    var flag= true;
    var msg = "";
    var file = document.getElementById("songFile").files[0];
    var ext = file.type;
    if(ext!='audio/mp3' && ext!='audio/wav' && ext!='audio/ogg'){
        msg+="Only mp3, wav and ogg files supported. ";
        flag=false;
    }
    if(file.size>9000000){
        msg+="File size cannot be greater than 9MB. ";
        flag=false;
    }
    if(document.getElementById("songName").value==""){
        msg+="Song Name is required ";
        flag=false;
    }
    if(document.getElementById("TrackNo").value==""){
        msg+="Track Number is required ";
        flag=false;
    }
    else{
        if(!(parseInt(document.getElementById("TrackNo").value)>=1 && parseInt(document.getElementById("TrackNo").value)<=1000)){
            msg+="Track number should be between 1 and 1000 ";
            flag=false;
        }
    }
    if(document.getElementById("DiscNo").value==""){
        msg+="Track Number is required ";
        flag=false;
    }
    else{
        if(!(parseInt(document.getElementById("DiscNo").value)>=1 && parseInt(document.getElementById("DiscNo").value)<=1000)){
            msg+="Disc number should be between 1 and 1000 ";
            flag=false;
        }
    }
    if(flag==false){
        message(msg);
    }
    return flag;
}
function albumUploadValidate(){
    var flag= true;
    var msg = "";
    if(document.getElementById("albumName").value==""){
        msg+="Album Name is required ";
        flag=false;
    }
    if(flag==false){
        message(msg);
    }
    return flag;
}