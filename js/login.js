//blur event fill
Array.prototype.forEach.call(document.getElementsByClassName("login-text"), function(element){
    element.onblur = function(){
        if(element.value.trim()==""){
            element.classList.remove("has-val");
        }
        else{
            element.classList.add("has-val");
        }
    }
});

/*For autocorrect problem*/
//Chrome browser
setTimeout(function(){
    var autofilled = document.querySelectorAll("input:-webkit-autofill");
    if(autofilled){
        Array.prototype.forEach.call(document.querySelectorAll("input:-webkit-autofill"), function(element){
            element.classList.add("has-val");
        })
    }
},500);
//Other browsers
window.onload = function(){
    setTimeout(function(){
        Array.prototype.forEach.call(document.getElementsByClassName("login-text"), function(element){
            if(element.value.trim()==""){
                element.classList.remove("has-val");
            }
            else{
                element.classList.add("has-val");
            }
        })
    })
};

/*Validation*/
var inputs = document.getElementsByClassName("validate-input");
document.getElementsByClassName("loginform")[0].onsubmit = function(){
    var flag = true;
    for(var i=0; i<inputs.length; i++){
        var message = validate(inputs[i]); 
        if(message!=true){
            showValidate(inputs[i], message);
            flag = false;
        }
    }
    return flag;
};
function validate(input, checkRequired=true){
    if(checkRequired==true && input.value.trim()==""){
        return input.parentNode.getAttribute("tag")+" is required";
    }
    if(input.getAttribute("name")=="email"){
        if(input.value.trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
            return "Invalid Email ID";
        }
    }
    if(input.getAttribute("name")=="artist"){
        if(input.value.trim().length>20){
            return "Artist name maximum 20 characters";
        }
    }
    if(document.getElementById("signup-form")){
        if(input.getAttribute("id")=="pass"){
            if(input.value.trim().length<8){
                return "Password must be atleast 8 characters in length";
            }
            if(input.value.trim().match(/[A-Z]{1,}/) == null){
                return "Password must contain atleast one uppercase letter";
            }
            if(input.value.trim().match(/[\d]+/) == null){
                return "Password must contain atleast one number";
            }
            if(input.value.trim().match(/[!#$%&? "]+/) == null){
                return "Password must contain atleast one special character";
            }
            if(input.value.trim().match(/^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&? "]).*$/) == null){
                return "Password must contain atleast one digit, uppercase letter and special character";
            }
        }
        if(input.getAttribute("id")=="confPass"){
            if(input.value != document.getElementById("pass").value){
                return "Password is not matching";
            }
        }
    }
    return true;
}
Array.prototype.forEach.call(document.getElementsByClassName("login-text"), function(element){
    element.onfocus = function(){
        hideValidate(element);
    }
});
//Server side validation
for(var i=0; i<errorList.length; i++){
    var a = errorList[i].split("*");
    showValidate(document.getElementById(a[0]), a[1]);
}
