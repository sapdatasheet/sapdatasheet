function langOnFocus(sapDescLangu) {
    sapDescLangu._initValue = sapDescLangu.value;
}
function langOnChnage(sapDescLangu) {
    if (sapDescLangu._initValue !== sapDescLangu.value) {
        // change happened
        clearCookie();
        setCookie('sap-desc-langu', sapDescLangu.value, 30);

        // Re-load current page, the cookie containing language will work
        window.location.reload();
    }
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/"; 
}
function clearCookie() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}
