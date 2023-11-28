function promptclose() {
    let el = document.getElementById("overlay prompt");
    el.style.visibility = "hidden";
}
function hideMessage() {
    document.getElementById("alert-error").style.visibility = "hidden";
    document.getElementById("alert-error").style.display = "none";
}
setTimeout(hideMessage, 5000);