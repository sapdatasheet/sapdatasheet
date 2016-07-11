function langOnFocus(sapDescLangu) {
    sapDescLangu._initValue = sapDescLangu.value;
}
function langOnChnage(sapDescLangu) {
    if (sapDescLangu._initValue !== sapDescLangu.value) {
        // change happened
        clearCookie();
        setCookie('sap-desc-langu', sapDescLangu.value, 30);

        // Reload the Content page or Jump to Language Specific Index Page
        var pathArray = window.location.pathname.split('/');
        if (window.location.pathname === "/abap/bmfr/"
                || window.location.pathname === "/abap/clas/"
                || window.location.pathname === "/abap/cus0/"
                || window.location.pathname === "/abap/cvers/"
                || window.location.pathname === "/abap/devc/"
                || window.location.pathname === "/abap/doma/"
                || window.location.pathname === "/abap/dtel/"
                || window.location.pathname === "/abap/fugr/"
                || window.location.pathname === "/abap/func/"
                || window.location.pathname === "/abap/intf/"
                || window.location.pathname === "/abap/msag/"
                || window.location.pathname === "/abap/prog/"
                || window.location.pathname === "/abap/shlp/"
                || window.location.pathname === "/abap/sqlt/"
                || window.location.pathname === "/abap/tabl/"
                || window.location.pathname === "/abap/tran/"
                || window.location.pathname === "/abap/view/") {
            if (sapDescLangu.value !== 'E') {
                newURL = window.location.href + sapDescLangu.value + "/";
                window.open(newURL, "_self");
            }
        } else if ((pathArray.length === 5 && window.location.pathname.length === 13)
                || (pathArray.length === 5 && window.location.pathname.length === 14 && window.location.pathname.substring(0, 12) === "/abap/cvers/")
                ) {
            //  -- /abap/devc/1/    -- 13
            //  -- /abap/cvers/1/   -- 14
            if (sapDescLangu.value === 'E') {
                newURL = window.location.protocol
                        + "//" + window.location.host
                        + "/" + pathArray[1] + "/" + pathArray[2] + "/";
            } else {
                newURL = window.location.protocol
                        + "//" + window.location.host
                        + "/" + pathArray[1] + "/" + pathArray[2] + "/" + sapDescLangu.value + "/";
            }
            window.open(newURL, "_self");
        } else if (pathArray.length === 4 && pathArray[3].substring(0, 6) === 'index-' && sapDescLangu.value !== 'E') {
            newURL = window.location.protocol
                    + "//" + window.location.host
                    + "/" + pathArray[1] + "/" + pathArray[2] + "/" + sapDescLangu.value + "/" + pathArray[3];
            window.open(newURL, "_self");
        } else if (pathArray.length === 5 && pathArray[4].substring(0, 6) === 'index-') {
            if (sapDescLangu.value === 'E') {
                newURL = window.location.protocol
                        + "//" + window.location.host
                        + "/" + pathArray[1] + "/" + pathArray[2] + "/" + pathArray[4];
            } else {
                newURL = window.location.protocol
                        + "//" + window.location.host
                        + "/" + pathArray[1] + "/" + pathArray[2] + "/" + sapDescLangu.value + "/" + pathArray[4];
            }
            window.open(newURL, "_self");
        } else {
            // Simply re-load current page, the cookie containing language will work
            window.location.reload();
        }
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
