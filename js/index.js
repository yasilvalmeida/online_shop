var t_client_fk = $("#logged_id").val(),
    logged_username = $("#logged_username").val() ? $("#logged_username").val() : 'Guest',
    logged_balance = parseInt($("#logged_balance").val()),
    total_product = 0,
    productArray = new Array(),
    paginationIndex = 1,
    paginationItemPerIndex = 3,
    paginationGroup,
    t_product_fk,
    t_shipping_fk,
    cartTotalPrice = 0,
    cartShippingCost = -1,
    shi
$(() => {
    // If some username is log in
    if(logged_username != 'Guest'){
        $("#username_logged_view").html('<i class="fas fa-user"></i> ' + logged_username);
        $('#change_modal').on('shown.bs.modal', () => {
            loadMyInfo();
        });
    }
    else{
        $('#login_modal').on('shown.bs.modal', () => {
            $("#username_login").focus();
        });
        $('#signup_modal').on('shown.bs.modal', () => {
            $("#username_signup").focus();
        });
    }
    $('#cart_modal').on('shown.bs.modal', () => {
        $("#cartContent").html("<img src='img/loader.gif' />");
        loadItensToCart();
        loadShippingMethodAsynt();
    });
    // Load all products from the Shop API
    fetchAllProductAsync();
    // delCookie('product_added1');
    console.log(document.cookie)
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
/* This function will load the logged user info into the change my info modal */
loadMyInfo = () => {
    $("#username_changed").val($("#logged_username").val());
    $("#password_changed").val($("#logged_password").val());
    $("#balance_changed").val('$' + $("#logged_balance").val());
}
/* This function will validate the log in username and password and call the login async function */
login = () => {
    var username_login = $("#username_login"),
        password_login = $("#password_login"),
        bValid = true,
        tips = $("#login_state");
    tips
        .removeClass("alert-danger")
        .addClass("alert-light");
    if (username_login.val() == "") {
        updateTips(tips, "The username must be filled.");
        username_login.focus();
    }
    else if (password_login.val() == "") {
        updateTips(tips, "The password must be filled.");
        password_login.focus();
    }
    else if (username_login.val() == password_login.val()) {
        updateTips(tips, "The username and password must be different.");
        password_login.focus();
    }
    else if (password_login.val().includes(username_login.val())) {
        updateTips(tips, "The password must not contain the username.");
        password_login.focus();
    }
    else {
        bValid = bValid && checkLength(tips, username_login, "username", 5, 20, tips);
        bValid = bValid && checkRegexp(tips, username_login, /[QWERTYUIOPASDFGHJKLZXCVBNM]([0-9qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM])+$/i, "The username must begin with a letter and followed by numbers or letters.", tips);
        bValid = bValid && checkLength(tips, password_login, "password", 6, 20, tips);
        bValid = bValid && checkRegexp(tips, password_login, /[0-9]/, "The password must containt at least one number.", tips);
        bValid = bValid && checkRegexp(tips, password_login, /[qwertyuiopasdfghjklzxcvbnm]/, "The password must contain at least one lowercase letter.", tips);
        bValid = bValid && checkRegexp(tips, password_login, /[QWERTYUIOPASDFGHJKLZXCVBNM]/, "The password must contain at least one capital letter.", tips);
        bValid = bValid && checkRegexp(tips, password_login, /[@£€#$%&*+-?!]/, "The password must consist of at least 1 special character, namely @, £, €, #, $, %, &, *, +, -, ? or !.", tips);
        if (bValid) {
            loginAsync();
        }
    }
}
/* This async function will call the shop api and perfom the log in action */
loginAsync = () => {
    var tips = $("#login_state");
    tips.html("<img src='img/loader.gif' />");
    $.post("backend/api/shop.php?action=logInClient",
    {
        username: $("#username_login").val(),
        password: $("#password_login").val()
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                    tips.html("Log in success!");
                    location.reload();
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
/* This function will validate the sign up username and password and call the sign up async function */
signup = () => {
    var username_signup = $("#username_signup"),
        password_signup = $("#password_signup"),
        bValid = true,
        tips = $("#login_state");
    tips
        .removeClass("alert-danger")
        .addClass("alert-light");
    if (username_signup.val() == "") {
        updateTips(tips, "The username must be filled.");
        username_signup.focus();
    }
    else if (password_signup.val() == "") {
        updateTips(tips, "The password must be filled.");
        password_signup.focus();
    }
    else if (username_signup.val() == password_signup.val()) {
        updateTips(tips, "The username and password must be different.");
        password_signup.focus();
    }
    else if (password_signup.val().includes(username_signup.val())) {
        updateTips(tips, "The password must not contain the username.");
        password_signup.focus();
    }
    else {
        bValid = bValid && checkLength(tips, username_signup, "username", 5, 20, tips);
        bValid = bValid && checkRegexp(tips, username_signup, /[QWERTYUIOPASDFGHJKLZXCVBNM]([0-9qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM])+$/i, "The username must begin with a letter and followed by numbers or letters.", tips);
        bValid = bValid && checkLength(tips, password_signup, "password", 6, 20, tips);
        bValid = bValid && checkRegexp(tips, password_signup, /[0-9]/, "The password must containt at least one number.", tips);
        bValid = bValid && checkRegexp(tips, password_signup, /[qwertyuiopasdfghjklzxcvbnm]/, "The password must contain at least one lowercase letter.", tips);
        bValid = bValid && checkRegexp(tips, password_signup, /[QWERTYUIOPASDFGHJKLZXCVBNM]/, "The password must contain at least one capital letter.", tips);
        bValid = bValid && checkRegexp(tips, password_signup, /[@£€#$%&*+-?!]/, "The password must consist of at least 1 special character, namely @, £, €, #, $, %, &, *, +, -, ? or !.", tips);
        if (bValid) {
            signupAsync();
        }
    }
}
/* This async function will call the shop api and perfom the sign up action */
signupAsync = () => {
    var tips = $("#signup_state");
    tips.html("<img src='img/loader.gif' />");
    $.post("backend/api/shop.php?action=signUpClient",
    {
        username: $("#username_signup").val(),
        password: $("#password_signup").val()
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                    tips.html("Sign up success!");
                    $("#signup_modal").modal('hide');
                    toastr.success('New client created!');
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
/* This function will validate the change my info username and password and call the change my info async function */
changeMyInfo = () => {
    var username_changed = $("#username_changed"),
        password_changed = $("#password_changed"),
        bValid = true,
        tips = $("#change_my_info_state");
    tips
        .removeClass("alert-danger")
        .addClass("alert-light");
    if (username_changed.val() == "") {
        updateTips(tips, "The username must be filled.");
        username_changed.focus();
    }
    else if (password_changed.val() == "") {
        updateTips(tips, "The password must be filled.");
        password_changed.focus();
    }
    else if (username_changed.val() == password_changed.val()) {
        updateTips(tips, "The username and password must be different.");
        password_changed.focus();
    }
    else if (password_changed.val().includes(username_changed.val())) {
        updateTips(tips, "The password must not contain the username.");
        password_changed.focus();
    }
    else {
        bValid = bValid && checkLength(tips, username_changed, "username", 5, 20, tips);
        bValid = bValid && checkRegexp(tips, username_changed, /[QWERTYUIOPASDFGHJKLZXCVBNM]([0-9qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM])+$/i, "The username must begin with a letter and followed by numbers or letters.", tips);
        bValid = bValid && checkLength(tips, password_changed, "password", 6, 20, tips);
        bValid = bValid && checkRegexp(tips, password_changed, /[0-9]/, "The password must containt at least one number.", tips);
        bValid = bValid && checkRegexp(tips, password_changed, /[qwertyuiopasdfghjklzxcvbnm]/, "The password must contain at least one lowercase letter.", tips);
        bValid = bValid && checkRegexp(tips, password_changed, /[QWERTYUIOPASDFGHJKLZXCVBNM]/, "The password must contain at least one capital letter.", tips);
        bValid = bValid && checkRegexp(tips, password_changed, /[@£€#$%&*+-?!]/, "The password must consist of at least 1 special character, namely @, £, €, #, $, %, &, *, +, -, ? or !.", tips);
        if (bValid) {
            changeMyInfoAsync();
        }
    }
}
/* This async function will call the shop api and perfom the change my info action */
changeMyInfoAsync = () => {
    var tips = $("#change_my_info_state");
    tips.html("<img src='img/loader.gif' />");
    $.post("backend/api/shop.php?action=changeLoggedClientInfo",
    {
        id: $("#t_client_fk").val(),
        username: $("#username_changed").val(),
        password: $("#password_changed").val()
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                    tips.html("Change success!");
                    location.reload();
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
/* This async function will call the shop api and perfom the log out action */
logoutAsync = () => {
    var tips = $("#exit_state");
    tips.html("<img src='img/loader.gif' />");
    $.post("backend/api/shop.php?action=logOutClient",
    { },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                    tips.html("Exit success!");
                    location.reload();
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
/* This async function will call the shop api and perfom the fetchAllProductFrontEnd action */
fetchAllProductAsync = () =>{
    $("#productContent").html("<img src='img/loader.gif' />");
    $("#productPagination").html("<img src='img/loader.gif' />");
    $.post("backend/api/shop.php?action=fetchAllProductFrontEnd",
    { },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data),
                    products = r.data;
                total_product = products.length;
                $.each(products, (i, product) => {
                    productArray[i] = new Product(product[0], product[1], product[2], product[3], product[4]);
                });
                paginationGroup = Math.ceil(total_product/paginationItemPerIndex);
                // Create the pagination
                paginationCreate();
                // Refresh the cart from cookie
                refreshCartFromCookie();
            } catch (error) {
                console.log(error)
            }
            
        }
        else{
            console.log(error)
        }
    });
}
/* This function will perfome the pagination prev action */
paginationPrev = () => {
    if(paginationIndex > 1)
    paginationIndex--;
    paginationUpdate(paginationIndex);
}
/* This function will perfome the pagination next action */
paginationNext = () => {
    if(paginationIndex < paginationGroup)
    paginationIndex++;
    paginationUpdate(paginationIndex);
}
/* This function will perfome the pagination update action */
paginationUpdate = (num) => {
    paginationIndex = num;
    var htmlCreated = '<nav><ul class="pagination justify-content-center"><li class="page-item"><a class="page-link" href="javascript:paginationPrev()">Previous</a></li>';
    for(var i = 1; i <= paginationGroup; i++){
        if(i == paginationIndex)
            htmlCreated += '<li class="page-item active"><a class="page-link" href="javascript:paginationUpdate(' + i + ')">' + i + '</a></li>';
        else
            htmlCreated += '<li class="page-item"><a class="page-link" href="javascript:paginationUpdate(' + i + ')">' + i + '</a></li>';
    }
    htmlCreated += '<li class="page-item"><a class="page-link" href="javascript:paginationNext()">Next</a></li></ul></nav>';
    $("#productPagination").html(htmlCreated);
    loadProductPerGroupAsync();
}
/* This function will perfome the pagination create action */
paginationCreate = () => {
    var htmlCreated = '<nav><ul class="pagination justify-content-center"><li class="page-item"><a class="page-link" href="javascript:paginationPrev()">Previous</a></li>';
    for(var i = 1; i <= paginationGroup; i++){
        if(i == paginationIndex)
            htmlCreated += '<li class="page-item active"><a class="page-link" href="javascript:paginationUpdate(' + i + ')">' + i + '</a></li>';
        else
            htmlCreated += '<li class="page-item"><a class="page-link" href="javascript:paginationUpdate(' + i + ')">' + i + '</a></li>';
    }
    htmlCreated += '<li class="page-item"><a class="page-link" href="javascript:paginationNext()">Next</a></li></ul></nav>';
    $("#productPagination").html(htmlCreated);
    paginationUpdate(paginationIndex);
}
/* This async function will load and show all products per pagination group in card */
loadProductPerGroupAsync = () => {
    $.post("backend/api/shop.php?action=fetchAllProductByGroup",
    { 
        offset: paginationIndex,
        limit: paginationItemPerIndex
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data),
                    products = r.data,
                    htmlCreated = '';
                switch(products.length){
                    case 3:
                        $.each(products, (i, product) => {
                            var product = new Product(product.id, product.name, product.price, product.unit, product.quantity);
                            htmlCreated += '<div class="card mb-4 box-shadow">';
                            htmlCreated += '<div class="card-header">';
                            htmlCreated += '  <h3 class="my-0 font-weight-normal">' + product.getName() + '</h4>';
                            htmlCreated += '</div>';
                            htmlCreated += '<div class="card-body">';
                            htmlCreated += '  <h2 class="card-title pricing-card-title">$' + product.getPrice() + ' / ' + product.getUnit() + '</h1>';
                            // Check if product quantity > 0 to show how many is available in stock and else out of stock
                            if (parseInt(product.getQuantity()) > 0) 
                                htmlCreated += '  <p>' + product.getQuantity() + ' available in stock</p>';
                            else
                                htmlCreated += '  <p>Out of stock</p>';
                            // Check if there's any rated cookie for this product
                            var cookieName = 'product_rated' + product.getId(),
                                cookieValueStored = getCookie(cookieName);
                            if (cookieValueStored && cookieValueStored.includes(logged_username))
                                htmlCreated += '<a class="btn btn-primary" href="javascript:ratingProduct(' + product.getId() + ')" role="button"><i class="fas fa-star"> Ratings</i></a>';
                            else
                                htmlCreated += '<a class="btn btn-primary" href="javascript:ratingProduct(' + product.getId() + ')" role="button"><i class="fas fa-star"> Rate</i></a>';
                            htmlCreated += '<hr/>';
                            // // Check if product quantity > 0 to show the button add to cart and else to hide
                            if (parseInt(product.getQuantity()) > 0)
                                htmlCreated += '<div><label style="margin-right:5px;"><b>Qty</b></label><input id="quantityToAdd' + product.getId() + '" type="number" min="1" max="' + product.getQuantity() + '" value="1" /></div><a class="btn btn-warning" href="javascript:addToCart(' + product.getId() + ')" role="button"><i class="fas fa-cart-plus"> Add to cart</i></a>';
                            htmlCreated += '</div>';
                            htmlCreated += '</div>';
                        });
                        break;
                    case 2:
                        $.each(products, (i, product) => {
                            var product = new Product(product.id, product.name, product.price, product.unit, product.quantity);
                            htmlCreated += '<div class="card mb-4 box-shadow">';
                            htmlCreated += '<div class="card-header">';
                            htmlCreated += '  <h3 class="my-0 font-weight-normal">' + product.getName() + '</h4>';
                            htmlCreated += '</div>';
                            htmlCreated += '<div class="card-body">';
                            htmlCreated += '  <h2 class="card-title pricing-card-title">$' + product.getPrice() + ' / ' + product.getUnit() + '</h1>';
                            // Check if product quantity > 0 to show how many is available in stock and else out of stock
                            if (parseInt(product.getQuantity()) > 0) 
                                htmlCreated += '  <p>' + product.getQuantity() + ' available in stock</p>';
                            else
                                htmlCreated += '  <p>Out of stock</p>';
                            // Check if there's any rated cookie for this product
                            var cookieName = 'product_rated' + product.getId(),
                                cookieValueStored = getCookie(cookieName);
                            if (cookieValueStored && cookieValueStored.includes(logged_username))
                                htmlCreated += '<a class="btn btn-primary" href="javascript:ratingProduct(' + product.getId() + ')" role="button"><i class="fas fa-star"> Ratings</i></a>';
                            else
                                htmlCreated += '<a class="btn btn-primary" href="javascript:ratingProduct(' + product.getId() + ')" role="button"><i class="fas fa-star"> Rate</i></a>';
                            htmlCreated += '<hr/>';
                            // // Check if product quantity > 0 to show the button add to cart and else to hide
                            if (parseInt(product.getQuantity()) > 0)
                                htmlCreated += '<div><label style="margin-right:5px;"><b>Qty</b></label><input id="quantityToAdd' + product.getId() + '" type="number" min="1" max="' + product.getQuantity() + '" value="1" /></div><a class="btn btn-warning" href="javascript:addToCart(' + product.getId() + ')" role="button"><i class="fas fa-cart-plus"> Add to cart</i></a>';
                            htmlCreated += '</div>';
                            htmlCreated += '</div>';
                        });
                        htmlCreated += '<div class="card mb-4 box-shadow"></div>';
                        break;
                    case 1:
                        $.each(products, (i, product) => {
                            var product = new Product(product.id, product.name, product.price, product.unit, product.quantity);
                            htmlCreated += '<div class="card mb-4 box-shadow">';
                            htmlCreated += '<div class="card-header">';
                            htmlCreated += '  <h3 class="my-0 font-weight-normal">' + product.getName() + '</h4>';
                            htmlCreated += '</div>';
                            htmlCreated += '<div class="card-body">';
                            htmlCreated += '  <h2 class="card-title pricing-card-title">$' + product.getPrice() + ' / ' + product.getUnit() + '</h1>';
                            // Check if product quantity > 0 to show how many is available in stock and else out of stock
                            if (parseInt(product.getQuantity()) > 0) 
                                htmlCreated += '  <p>' + product.getQuantity() + ' available in stock</p>';
                            else
                                htmlCreated += '  <p>Out of stock</p>';
                            // Check if there's any rated cookie for this product
                            var cookieName = 'product_rated' + product.getId(),
                                cookieValueStored = getCookie(cookieName);
                            if (cookieValueStored && cookieValueStored.includes(logged_username))
                                htmlCreated += '<a class="btn btn-primary" href="javascript:ratingProduct(' + product.getId() + ')" role="button"><i class="fas fa-star"> Ratings</i></a>';
                            else
                                htmlCreated += '<a class="btn btn-primary" href="javascript:ratingProduct(' + product.getId() + ')" role="button"><i class="fas fa-star"> Rate</i></a>';
                            htmlCreated += '<hr/>';
                            // // Check if product quantity > 0 to show the button add to cart and else to hide
                            if (parseInt(product.getQuantity()) > 0)
                                htmlCreated += '<div><label style="margin-right:5px;"><b>Qty</b></label><input id="quantityToAdd' + product.getId() + '" type="number" min="1" max="' + product.getQuantity() + '" value="1" /></div><a class="btn btn-warning" href="javascript:addToCart(' + product.getId() + ')" role="button"><i class="fas fa-cart-plus"> Add to cart</i></a>';
                            htmlCreated += '</div>';
                            htmlCreated += '</div>';
                        });
                        htmlCreated += '<div class="card mb-4 box-shadow"></div>';
                        htmlCreated += '<div class="card mb-4 box-shadow"></div>';
                        break;
                }
                $("#productContent").html(htmlCreated);
            } catch (error) {
                console.log(error)
            }
            
        }
        else{
            console.log(error)
        }
    });
}
/* This function will check if there's some browser cookie create for this product will show the rating saved else will add new rating */
ratingProduct = (id) => {
    $("#ratingContent").html("<img src='img/loader.gif' />");
    t_product_fk = id;
    var cookieName = 'product_rated' + id,
    cookieValueStored = getCookie(cookieName);
    // Check if there was any previous rating for this product id that includes this logged username
    if(cookieValueStored && cookieValueStored.includes(logged_username)){
        loadRatingAsync();
    }
    else{
        $("#ratingContent").html('<form class="rating"><div class="form-group"><label>Rate</label><input id="rate" type="number" min="1" max="5" value="1" class="form-control form-control-user" /></div><hr /><div id="rating_state" class="d-flex justify-content-center" role="alert"></div></form>');
        $("#ratingButtons").html('<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><a class="btn btn-success" href="javascript:insertRating()">Rate</a>');
        $("#rate").focus();
    }
    $("#rating_modal").modal('show');
}
/* This function will validate the rate and call the insert async function */
insertRating = () => {
    var rate = $("#rate"),
        bValid = true,
        tips = $("#rating_state");
    tips
        .removeClass("alert-danger")
        .addClass("alert-light");
    if (rate.val() == "") {
        updateTips(tips, "The rate must be filled.");
        rate.focus();
    }
    else {
        bValid = bValid && checkRegexp(tips, rate, /[1-5]/, "The rate must be between 1 and 5.", tips);
        if (bValid) {
            insertRatingAsync();
        }
    }
}
/* This async function will call the shop api and perfom the insert rating action */
insertRatingAsync = () => {
    var tips = $("#rating_state");
    tips.html("<img src='img/loader.gif' />");
    $.post("backend/api/shop.php?action=insertRating",
    {
        t_product_fk: t_product_fk,
        username: logged_username,
        rate: $("#rate").val()
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data);
                if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                    tips.html("New rating inserted!");
                    var cookieName = 'product_rated' + t_product_fk,
                        cookieValueStored = getCookie(cookieName);
                    // Check if this product was rated by some other client to add previous rating
                    if(cookieValueStored) {
                        delCookie(cookieName);
                        setCookie(cookieName, cookieValueStored + ',' + logged_username);
                    }
                    else
                    setCookie(cookieName, logged_username);
                    toastr.success('New rating inserted!');
                    $("#rating_modal").modal('hide');
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
/* This async function will load the previous rating from the database using API */
loadRatingAsync = () => {
    $.post("backend/api/shop.php?action=fetchAllRating",
    { 
        t_product_fk: t_product_fk
    },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data),
                    ratings = r.data,
                    totalRating = ratings.length,
                    sumRating = 0,
                    htmlCreated = '<table class="table table-hover table-stripped"><thead><tr><th scope="col">Username</th><th scope="col">Date</th><th scope="col">Rating</th></tr></thead><tbody>';
                $.each(ratings, (i, rating) => {
                    var rating = new Rating(rating[2], rating[0], rating[1]);
                    sumRating += parseInt(rating.getRate());
                    htmlCreated += '<tr><td>' + rating.getUsername() + '</td><td>' + rating.getDate() + '</td><td>' + convertRateToStars(rating.getRate()) + '</td></tr>';
                });
                htmlCreated += '</tbody></table><hr/><h6>Average rating = ' + ((parseFloat(sumRating))/parseFloat(totalRating)) + '</h6>';
                $("#ratingContent").html(htmlCreated);
                $("#ratingButtons").html('<button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>');
            } catch (error) {
                console.log(error)
            }
            
        }
        else{
            console.log(error)
        }
    });
}
convertRateToStars = (n) => {
    switch(parseInt(n)){
        case 1:
            return '<i class="fas fa-star"></i>';
        case 2:
            return '<i class="fas fa-star"></i><i class="fas fa-star"></i>';
        case 3:
            return '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
        case 4:
            return '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
        case 5:
            return '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
    }
} 
/* This function will add new item to cart and stored into cookie */
addToCart = (id) => {
    var cookieName = 'product_added' + id,
        cookieValueStored = parseInt(getCookie(cookieName)),
        quantityEnterByClient = parseInt($("#quantityToAdd" + id).val()),
        sumOfItens = 0;
    // If this product was added to cart and stored into cookie let's sum with stored quantity
    if (cookieValueStored) {
        sumOfItens = cookieValueStored + quantityEnterByClient;
        delCookie(cookieName);
    }
    else 
        sumOfItens = quantityEnterByClient;
    setCookie(cookieName, sumOfItens);
    refreshCartFromCookie();
    toastr.success(quantityEnterByClient + ' itens added to cart!');
}
/* This function will refresh number of itens to the cart from cookie */
refreshCartFromCookie = () => {
    var totalItensInCart = 0;
    for(var i = 0; i < total_product; i++){
        var id = productArray[i]['id'],
            cookieName = 'product_added' + id,
            cookieValueStored = parseInt(getCookie(cookieName));
        if (cookieValueStored) {
            totalItensInCart += cookieValueStored;
        }
    }
    $("#item_added_to_cart_text").html(totalItensInCart);
}
/* This function will load itens to the cart from cookie */
loadItensToCart = () => {
    $("#cart_modal").modal('show');
    updateCartItens();
}
/* This function will format the price adding the decimal part if need 1000,00 $*/
formatPrice = (price) => {
    var parts = (price + '').split('.'),
        integerPart = parts[0],
        decimalPart = parts[1],
        integerPart = (integerPart < 1000) ? integerPart : processPrice(integerPart),
        decimalPart = (!decimalPart) ? '00' : completePriceDecimalPart(decimalPart);
    return integerPart + ',' + decimalPart;
}
/* This function will process recursively the space between thousands in integer part */
processPrice = (price) => {
    if (price < 1000) return (price);
    else {
        var quotient = parseInt(price / 1000),
            remainder = parseInt(price % 1000);
        return processPrice(quotient) + " " + completePriceRemainder(remainder);
    }
}
/* This function will complete the remainder digits until complete three digits */
completePriceRemainder = (remainder) => {
    switch((remainder + '').length){
        case 3:
            return remainder;
        case 2:
            return '0' + remainder;
        case 1: 
            return '00' + remainder;
    }
}
/* This function will complete the decimal part with 0 until complete two digits */
completePriceDecimalPart = (decimalPart) => {
    return (decimalPart.length == 1) ? decimalPart + "0" : decimalPart;
}
/* This async function will load shipping method from the database using Shop API */
loadShippingMethodAsynt = () => {
    $.post("backend/api/shop.php?action=fetchAllShippingToSelect",
    { },
    (data, status) => {
        if(status == "success"){
            try {
                var r = JSON.parse(data),
                    shippings = r.data,
                    htmlCreated = '<option id="-1">Please select</option>';
                $.each(shippings, (i, shipping) => {
                    var shipping = new Shipping(shipping[0], shipping[1], shipping[2]);
                    htmlCreated += '<option value="' + shipping.getId() + '_' + shipping.getPrice() + '" >' + shipping.getName() + ' - ' + formatPrice(shipping.getPrice()) + ' $</option>';
                });
                $("#shippingMethodContent").html(htmlCreated);
                $("#shippingMethodContent").change(() => {
                    cartShippingCost = $("#shippingMethodContent option:selected").val().split('_')[1];
                    t_shipping_fk = $("#shippingMethodContent option:selected").val().split('_')[0];
                    updateCartPrice();
                });
            } catch (error) {
                console.log(error)
            }
            
        }
        else{
            console.log(error)
        }
    });
}
/* This function wil update the cart final price with shipping cost */
updateCartPrice = () => {
    if (cartShippingCost >= 0) {
        cartShippingCost = parseFloat(cartShippingCost);
        $("#cartShippingPrice").html('<div style="text-align:right">' + formatPrice(cartShippingCost) + ' $</div>');
        $("#cartFinalPrice").html('<div style="text-align:right">' + formatPrice(cartTotalPrice + cartShippingCost) + ' $</div>');
    }
    else {
        $("#cartShippingPrice").html('');
        $("#cartFinalPrice").html('<div style="text-align:right">' + formatPrice(cartTotalPrice) + ' $</div>');
    }
    
}
/* This function will update the itens in cart when removed */
updateCartItens = () => {
    var htmlCreated = '';
    for(var i = 0; i < total_product; i++){
        var id = productArray[i]['id'],
            cookieName = 'product_added' + id,
            cookieValueStored = parseInt(getCookie(cookieName));
        if (cookieValueStored) {
            var name = productArray[i]['name'],
                price = parseFloat(productArray[i]['price']),
                priceTimesQuantity = parseFloat(price * cookieValueStored);
            cartTotalPrice += priceTimesQuantity;
            htmlCreated += '<tr><td><div style="text-align:center"><a href="javascript:removeProductFromCart(' + id + ')" class="btn btn-danger"><i class="far fa-trash-alt"></i></a></div></td><td><b>' + name + '</b></td><td><div style="text-align:center">' + cookieValueStored + '</div></td><td><div style="text-align:right">' + formatPrice(price) + ' $</div></td><td><div style="text-align:right">' + formatPrice(priceTimesQuantity) + ' $</div></td></tr>';
        }
    }
    htmlCreated += '<tr><th scope="col"></th><th scope="col"></th><th scope="col"></th><th scope="col"></th><th scope="col"><div style="text-align:right">' + formatPrice(cartTotalPrice) + ' $</div></th></tr>';
    $("#cartContent").html(htmlCreated);
    htmlCreated  = '<tr><th colspan="2" scope="col"><label style="margin-top: 5px;">Shipping method</label></th><th colspan="2" scope="col"><select id="shippingMethodContent" class="form-control"></select></th><th scope="col"><div id="cartShippingPrice" style="text-align:right"></div></th></tr>';
    htmlCreated += '<tr><th scope="col"></th><th scope="col"></th><th scope="col"></th><th scope="col"></th><th scope="col"><div id="cartFinalPrice" style="text-align:right"></div></th></tr>';
    $("#cartFooter").html(htmlCreated);
    updateCartPrice();
}
/* This function will remove the product from cookie and update the cart */
removeProductFromCart = (id) => {
    var cookieName = 'product_added' + id,
        cookieValueStored = getCookie(cookieName);
    if(cookieValueStored) {
        delCookie(cookieName);
        updateCartItens();
    }
}
/* This async function will perform the buy action and generate an paid order */
buyAsync = () => {
    console.log(getProductIdAndQuantity())
    if(t_client_fk){
        if(t_shipping_fk){
            $("#cart_state").html("<img src='img/loader.gif' />");
            $.post("backend/api/shop.php?action=insertOrder",
            { 
                t_client_fk: t_client_fk,
                t_shipping_fk: t_shipping_fk,
                productQuantityArray: getProductIdAndQuantity()
            },
            (data, status) => {
                if(status == "success"){
                    try {
                        var r = JSON.parse(data);
                        if(parseInt(r.result) != NaN && parseInt(r.result) == 1){
                            tips.html("New order processed!");
                            // Check if this product was rated by some other client to add previous rating
                            cleanCart();
                            toastr.success("New order processed!");
                            $("#cart_modal").modal('hide');
                        }
                        else{
                            updateTips(tips, r.result);
                        }
                    } catch (error) {
                        console.log(error)
                    }
                    
                }
                else{
                    console.log(error)
                }
            });
        }
        else {
            $("#cart_state").html("Please select the shipping method!");
        }
    }
    else {
        setTimeout(() => {
            $("#cart_modal").modal('hide');
        }, 2000);
        $("#cart_state").html("You must log in first!");
        toastr.error("You must log in first!");
    }
}
/* This function will clean the products in cookie and update cart  */
cleanCart = () => {
    var cookieName = "product_added";
    for(var i = 0; i < total_product; i++)
        delCookie(cookieName + i);
    refreshCartFromCookie();
}
/* This function will extract all cart itens to an array of product id and quantity */
getProductIdAndQuantity = () => {
    var productIdAndQuantity = [];
    for(var i = 0; i < total_product; i++) {
        var id = productArray[i]['id'],
            cookieName = "product_added" + id,
            cookieValueStored = getCookie(cookieName);
        if(cookieValueStored) {
            productIdAndQuantity.push({ 't_product_fk' : id, 'quantity' : cookieValueStored });
        }
    }
    console.log(productIdAndQuantity.length)
    return productIdAndQuantity;
}