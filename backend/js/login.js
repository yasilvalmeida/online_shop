var username_login = $("#username_login"),
    password_login = $("#password_login");
$(() => {
    /* This function will update the text in the tips div the the text and the css */
    function updateTips(tips, text) {
        tips
            .text(text)
            .removeClass("alert-light")
            .addClass("alert-danger");
    }
    /* This function will check the length of the JS objects is between min and max, and will update tip div */
    function checkLength(tips, o, n, min, max, tips) {
		if (o.val().length > max || o.val().length < min) {
            o.addClass("alert-danger");
            updateTips(tips, "The length of " + n + " must be between " + min + " and " + max + ".")
            return false;
        }
        else {
			return true;
        }
    }
    /* This function will check if the regular expression is true or false, and will update the tip div */
	function checkRegexp(tips, o, regexp, n, tips) {
		if (!(regexp.test(o.val()))) {
            o.addClass("alert-danger");
            updateTips(tips, n);
            return false;
        }
		else {
			return true;
        }
    }
    /* This function will trigger when the user press Enter key in username input */
    $('#username_login').keyup((e) => {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) { //Enter keycode
            var tips = $("#login_state");
            if (username_login.val() == "") {
                updateTips(tips, "The username must be filled.");
                username_login.focus();
            }
            else if (password_login.val() == "") {
                updateTips(tips, "The password must be filled.");
                password_login.focus();
            }
            else {
                loginAsync();
            }
        }
    });
    /* This function will trigger when the user press Enter key in password input */
	$('#password_login').keyup((e) => {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) { //Enter keycode
            var tips = $("#login_state");
            if (username_login.val() == "") {
                updateTips(tips, "The username must be filled.");
                username_login.focus();
            }
            else if (password_login.val() == "") {
                updateTips(tips, "The password must be filled.");
                password_login.focus();
            }
            else {
                loginAsync();
            }
        }
    });
});
$.ajaxSetup({
    cache: false
});
/* This function will update the text in the tips div the the text and the css */
function updateTips(tips, text) {
    tips
        .text(text)
        .removeClass("alert-light")
        .addClass("alert-danger");
}
/* This function will check the length of the JS objects is between min and max, and will update tip div */
function checkLength(tips, o, n, min, max, tips) {
    if (o.val().length > max || o.val().length < min) {
        o.addClass("alert-danger");
        updateTips(tips, "The length of " + n + " must be between " + min + " and " + max + ".")
        return false;
    }
    else {
        return true;
    }
}
/* This function will check if the regular expression is true or false, and will update the tip div */
function checkRegexp(tips, o, regexp, n, tips) {
    if (!(regexp.test(o.val()))) {
        o.addClass("alert-danger");
        updateTips(tips, n);
        return false;
    }
    else {
        return true;
    }
}
/* This function validade all user parameter and call another login_async */
function login(){
    var tips = $("#login_state");
    if (username_login.val() == "") {
        updateTips(tips, "The username must be filled.");
        username_login.focus();
    }
    else if (password_login.val() == "") {
        updateTips(tips, "The password must be filled.");
        password_login.focus();
    }
    else {
        loginAsync();
    }
}
/* This is a async function that call the API to do the login */
function loginAsync() {
    var _username = $("#username_login").val(),
        _password = $("#password_login").val(),
        tips = $("#login_state");
    tips.addClass("alert-light");
    tips.html("<img src='../img/loader.gif' />");
    $.post("api/shop.php?action=logIn",
    {
        username : _username, 
        password : _password
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data),
                    result = parseInt(r.result);
                if(result != NaN && result == 1){
                    tips.html("Login success!");
                    window.location.href = "main.php";
                }
                else{
                    updateTips(tips, r.result);
                }
            } catch (error) {
                updateTips(tips, error);
            }
        }
        else{
            updateTips(tips, data);
        }
    });
}