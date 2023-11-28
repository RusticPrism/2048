function promptclose() {
    let el = document.getElementById("overlay prompt");
    el.style.visibility = "hidden";
}
function checkForm() {
    let inpuser = document.getElementById('username');
    if (inpuser.value==="")
    {
        alert("Nickname für Rangliste ist leer, bitte eingeben.");
        return false;
    }
    if (inpuser.value.substring(0, 1) === " ")
    {
        alert("Nickname für Rangliste ist leer, bitte eingeben.");
        return false;
    }
    if (!inpuser.value.match(/^[0-9a-zA-Z\s\r\n\-]+$/))
    {
        alert("Nickname enthält ungültige Zeichen, bitte neu eingeben.\n\nGültige Zeichen:\nA-Z,a-z,0-9");
        return false;
    }
}
function hideMessage() {
    document.getElementById("alert-error").style.visibility = "hidden";
}
setTimeout(hideMessage, 2000);