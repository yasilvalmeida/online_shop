/* This function will set new cookie name = value */
function setCookie(name,value) {
    var date = new Date();
        date.setTime(date.getTime() + (100*365*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
/* This function will get cookie by name */
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
/* This function will delete cookie name */
function delCookie(name) {
    document.cookie = name +'=; Path=/; Expires=01 Jan 2000 00:00:00 GMT;';
}