var product_data_table;
$(() => {
    product_data_table = $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": [],
        "ajax": {
            url: "api/shop.php?action=fetchAllProductBackEnd",
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
            { orderable: false, targets: [4, 5, 6] }
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
    var name_to_insert     = $("#name_to_insert"),
        price_to_insert    = $("#price_to_insert"),
        quantity_to_insert = $("#quantity_to_insert"),
        unit_to_insert     = $("#unit_to_insert"),
        bValid = true,
        tips = $("#insert_state");
    tips
        .removeClass("alert-danger")
        .addClass("alert-light");
    bValid = bValid && checkLength(tips, name_to_insert, "name", 1, 20, tips);
    bValid = bValid && checkLength(tips, price_to_insert, "price", 1, 5, tips);
    bValid = bValid && checkLength(tips, quantity_to_insert, "quantity", 1, 3, tips);
    bValid = bValid && checkLength(tips, unit_to_insert, "unit", 1, 5, tips);
    if (bValid) {
        insertAsync();
    }
}
function insertAsync() {
    var tips = $("#insert_state");
    tips.addClass("alert-light");
    tips.html("<img src='../img/loader.gif' />");
    $.post("api/shop.php?action=insertProduct",
    { 
        name    : $("#name_to_insert").val(),
        price   : $("#price_to_insert").val(),
        quantity: $("#quantity_to_insert").val(),
        unit    : $("#unit_to_insert").val()
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                    tips.html("Insert success!");
                    $('#insert_modal').modal('hide');
                    clear_form();
                    product_data_table.ajax.reload();
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
function update(product) {
    var tips = $("#update_state");
    $("#id_to_update").val(product.id);
    $("#name_to_update").val(product.name);
    $("#price_to_update").val(product.price);
    $("#quantity_to_update").val(product.quantity);
    $("#unit_to_update").val(product.unit);
    tips.addClass("alert-light");
    $("#update_modal").modal('show');
}
function updateAsync() {
    var tips = $("#update_state");
    tips.addClass("alert-light");
    tips.html("<img src='../img/loader.gif' />");
    $.post("api/shop.php?action=updateProduct",
    { 
        id      : $("#id_to_update").val(),
        name    : $("#name_to_update").val(),
        price   : $("#price_to_update").val(),
        quantity: $("#quantity_to_update").val(),
        unit    : $("#unit_to_update").val()
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                    tips.html("Update success!");
                    $('#update_modal').modal('hide');
                    clear_form();
                    product_data_table.ajax.reload();
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
    $.post("api/shop.php?action=removeProduct",
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
                    product_data_table.ajax.reload();
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
    $("#name_to_insert").val("");
    $("#price_to_insert").val("");
    $("#quantity_to_insert").val("");
    $("#unit_to_insert").val("");
    $("#insert_state").removeClass("alert-success");
    $("#insert_state").addClass("alert-light");
    $("#insert_state").html("");
    /* Update */
    $("#name_to_update").val("");
    $("#price_to_update").val("");
    $("#quantity_to_update").val("");
    $("#unit_to_update").val("");
    $("#update_state").removeClass("alert-success");
    $("#update_state").addClass("alert-light");
    $("#update_state").html("");
    /* Remove */
    $("#id_to_remove").val("");
    $("#remove_state").removeClass("alert-success");
    $("#remove_state").addClass("alert-light");
    $("#remove_state").html("");
}
// Go to rating page
function rating(id){
    window.location.href = "rating.php?pid=" + id;
}