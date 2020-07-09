var user_data_table;
$(() => {
    user_data_table = $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": [],
        "ajax": {
            url: "api/shop.php?action=fetchAllUser",
            type: "POST",
            data: { }
        },
        "oLanguage": {
            "sLengthMenu": "Show _MENU_ rows per page",
            "sZeroRecords": "No record found!",
            "sInfo": "Show _START_ to _END_ of _TOTAL_ rows",
            "sInfoEmpty": "Showing 0 of 0 of 0 rows",
            "sInfoFiltered": "(Filter of _MAX_ total rows)",
            "sSearch": "Search <i class='fa fa-search'></i>",
            "oPaginate": {
                "sFirst": "First", // This is the link to the first page
                "sPrevious": "<i class='fas fa-arrow-circle-left'></i> Prev", // This is the link to the previous page
                "sNext": "Next <i class='fas fa-arrow-circle-right'></i>", // This is the link to the next page
                "sLast": "Last" // This is the link to the last page
            }
        },
        columnDefs: [
            { orderable: false, targets: [1, 3, 4] }
        ]
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
function insert() {
    var username_to_insert = $("#username_to_insert"),
        password_to_insert = $("#password_to_insert"),
        access_to_insert = $("#access_to_insert"),
        bValid = true,
        tips = $("#insert_state");
    tips
        .removeClass("alert-danger")
        .addClass("alert-light");
    if (username_to_insert.val() == "") {
        updateTips(tips, "The username must be filled.");
        username_to_insert.focus();
    }
    else if (password_to_insert.val() == "") {
        updateTips(tips, "The password must be filled.");
        password_to_insert.focus();
    }
    else if (username_to_insert.val() == password_to_insert.val()) {
        updateTips(tips, "The username and password must be different.");
        password_to_insert.focus();
    }
    else if (password_to_insert.val().includes(username_to_insert.val())) {
        updateTips(tips, "The password must not contain the username.");
        password_to_insert.focus();
    }
    else {
        bValid = bValid && checkLength(tips, username_to_insert, "username", 5, 20, tips);
        bValid = bValid && checkRegexp(tips, username_to_insert, /[QWERTYUIOPASDFGHJKLZXCVBNM]([0-9qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM])+$/i, "The username must begin with a letter and followed by numbers or letters.", tips);
        bValid = bValid && checkLength(tips, password_to_insert, "password", 6, 20, tips);
        bValid = bValid && checkRegexp(tips, password_to_insert, /[0-9]/, "The password must containt at least one number.", tips);
        bValid = bValid && checkRegexp(tips, password_to_insert, /[qwertyuiopasdfghjklzxcvbnm]/, "The password must contain at least one lowercase letter.", tips);
        bValid = bValid && checkRegexp(tips, password_to_insert, /[QWERTYUIOPASDFGHJKLZXCVBNM]/, "The password must contain at least one capital letter.", tips);
        bValid = bValid && checkRegexp(tips, password_to_insert, /[@£€#$%&*+-?!]/, "The password must consist of at least 1 special character, namely @, £, €, #, $, %, &, *, +, -, ? or !.", tips);
        bValid = bValid && checkRegexp(tips, access_to_insert, /[01]/, "The access must be 0 or 1.", tips);
        if (bValid) {
            insertAsync();
        }
    }
}

function insertAsync() {
    var tips = $("#insert_state");
    tips.addClass("alert-light");
    tips.html("<img src='../img/loader.gif' />");
    $.post("api/shop.php?action=insertUser",
    { 
        username: $("#username_to_insert").val(),
        password: $("#password_to_insert").val(),
        access  : $("#access_to_insert").val()
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                    tips.html("Insert success!");
                    $('#insert_modal').modal('hide');
                    clear_form();
                    user_data_table.ajax.reload();
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
function update(user) {
    var tips = $("#update_state");
    $("#id_to_update").val(user.id);
    $("#username_to_update").val(user.username);
    $("#password_to_update").val(user.password);
    $("#access_to_update").val(user.access);
    tips.addClass("alert-light");
    $("#update_modal").modal('show');
}
function updateAsync() {
    var tips = $("#update_state");
    tips.addClass("alert-light");
    tips.html("<img src='../img/loader.gif' />");
    $.post("api/shop.php?action=updateUser",
    { 
        id      : $("#id_to_update").val(),
        username: $("#username_to_update").val(),
        password: $("#password_to_update").val(),
        access  : $("#access_to_update").val()
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                    tips.html("Update success!");
                    $('#update_modal').modal('hide');
                    clear_form();
                    user_data_table.ajax.reload();
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
function remove(id) {
    var tips = $("#remove_state");
    $("#id_to_remove").val(id);
    tips.addClass("alert-light");
    $("#remove_modal").modal('show');
}
function removeAsync() {
    var tips = $("#remove_state");
    tips.addClass("alert-light");
    tips.html("<img src='../img/loader.gif' />");
    $.post("api/shop.php?action=removeUser",
    { 
        id: $("#id_to_remove").val()
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                    tips.html("Remove success!");
                    $('#remove_modal').modal('hide');
                    clear_form();
                    user_data_table.ajax.reload();
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
// Reset all input form
function clear_form() {
    /* Insert */
    $("#username_to_insert").val("");
    $("#password_to_insert").val("");
    $("#access_to_insert").val("");
    $("#insert_state").removeClass("alert-success");
    $("#insert_state").addClass("alert-light");
    $("#insert_state").html("");
    /* Update */
    $("#username_to_update").val("");
    $("#password_to_update").val("");
    $("#access_to_update").val("");
    $("#update_state").removeClass("alert-success");
    $("#update_state").addClass("alert-light");
    $("#update_state").html("");
    /* Remove */
    $("#id_to_remove").val("");
    $("#remove_state").removeClass("alert-success");
    $("#remove_state").addClass("alert-light");
    $("#remove_state").html("");
}