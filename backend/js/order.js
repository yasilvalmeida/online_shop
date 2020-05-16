var order_data_table;
$(() => {
    $.post("api/shop.php?action=fetchSingleClient",
    { 
        id : $("#cid").val()
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                $("#title").html("OSCB | Orders of " + r.username);
                $("#header").html("Orders of " + r.username);
                
            } catch (error) {
                console.log(error);
            }
        }
        else{
            console.log(data);
        }
    });

    order_data_table = $('#dataTable').DataTable({
        "processing": true,
        "serverSide": false,
        "order": [],
        "ajax": {
            url: "api/shop.php?action=fetchAllOrder",
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
            { orderable: false, targets: [4, 5] }
        ]
    });
    
    /* This function will update the text in the tips div the the text and the css */
    function updateTips(tips, text) {
        tips
            .text(text)
            .removeClass("alert-light")
            .addClass("alert-danger");
    }
});
/* This function will update the text in the tips div the the text and the css */
function updateTips(tips, text) {
    tips
        .text(text)
        .removeClass("alert-light")
        .addClass("alert-danger");
}
function remove(id) {
    $("#id_to_remove").val(id);
    tips.addClass("alert-light");
    $("#remove_modal").modal('show');
}
function removeAsync() {
    var tips = $("#remove_state");
    tips.addClass("alert-light");
    tips.html("<img src='../img/loader.gif' />");
    $.post("api/shop.php?action=removeOrder",
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
                    order_data_table.ajax.reload();
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
    /* Remove */
    $("#id_to_remove").val("");
    $("#remove_state").removeClass("alert-success");
    $("#remove_state").addClass("alert-light");
    $("#remove_state").html("");
}