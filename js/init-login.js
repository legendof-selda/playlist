function showValidate(input, message) {
    input.parentElement.setAttribute("data-validate", message);
    input.parentElement.classList.add("alert-validate");
}
function hideValidate(input) {
    input.parentElement.setAttribute("data-validate", "");
    input.parentElement.classList.remove("alert-validate");
}
var errorList = [];