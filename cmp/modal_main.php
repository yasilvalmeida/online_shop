<!-- Log In Modal-->
<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log In</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="client">
                    <div class="form-group">
                        <input id="username_login" type="text" class="form-control form-control-user" placeholder="Username" />
                    </div>
                    <div class="form-group">
                        <input id="password_login" type="password" class="form-control form-control-user" placeholder="Password" />
                    </div>
                    <hr />
                    <div id="login_state" class="d-flex justify-content-center" role="alert"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="javascript:login()">Log In</a>
            </div>
        </div>
    </div>
</div>
<!-- Sign Up Modal-->
<div class="modal fade" id="signup_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a new account</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="client">
                    <div class="form-group">
                        <input id="username_signup" type="text" class="form-control form-control-user" placeholder="Username" />
                    </div>
                    <div class="form-group">
                        <input id="password_signup" type="password" class="form-control form-control-user" placeholder="Password" />
                    </div>
                    <hr />
                    <div id="signup_state" class="d-flex justify-content-center" role="alert"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="javascript:signup()">Sign Up</a>
            </div>
        </div>
    </div>
</div>
<!-- Logout Modal-->
<div class="modal fade" id="logout_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Logout!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Do you want to leave?</div>
            <hr />
            <div id="exit_state" class="d-flex justify-content-center" role="alert"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                <a class="btn btn-danger" href="javascript:logoutAsync()">Yes</a>
            </div>
        </div>
    </div>
</div>
<!-- Change Modal-->
<div class="modal fade" id="change_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change my information</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="client">
                    <table>
                        <tr>
                            <td>
                                <label>Username</label>
                                <input id="username_changed" type="text" class="form-control form-control-user" />
                            </td>
                            <td>
                                <label>Password</label>
                                <input id="password_changed" type="password" class="form-control form-control-user" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Initial balance</label>
                                <input id="initial_balance" type="text" disabled class="form-control form-control-user" />
                            </td>
                            <td>
                                <label>Total purchase</label>
                                <input id="total_purchase" type="text" disabled class="form-control form-control-user" />
                            </td>
                            <td>
                                <label>Remaining balance</label>
                                <input id="balance" type="text" disabled class="form-control form-control-user" />
                            </td>
                        </tr>
                    </table>
                    <hr />
                    <div id="change_my_info_state" class="d-flex justify-content-center" role="alert"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="javascript:changeMyInfo()">Change</a>
            </div>
        </div>
    </div>
</div>
<!-- Rating Modal-->
<div class="modal fade" id="rating_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product rating</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="ratingContent" class="modal-body">
                <!-- Content depends on the cases -->
            </div>
            <div id="ratingButtons" class="modal-footer">
                <!-- Buttons depend on the cases -->
            </div>
        </div>
    </div>
</div>
<!-- Cart Modal-->
<div class="modal fade" id="cart_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:550px;">
            <div class="modal-header">
                <h5 class="modal-title">Cart</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <spam id='cart-balance'></spam>
                    <hr>
                    <table class="table table-hover table-stripped">
                        <thead>
                            <tr>
                                <th scope="col"><div style="text-align:center"><i class="far fa-trash-alt"></i></div></th>
                                <th scope="col"><div style="text-align:center"><i class='fas fa-edit'></i></div></th>
                                <th scope="col">Product</th>
                                <th scope="col"><div style="text-align:center">Qty</div></th>
                                <th scope="col"><div style="text-align:right">Unit $</div></th>
                                <th scope="col"><div style="text-align:right">Total $</div></th>
                            </tr>
                        </thead>
                        <tbody id="cartContent">
                            <!-- Load cart footer -->
                        </tbody>
                        <tfoot id="cartFooter">
                            <!-- Load cart footer -->
                        </tfoot>
                    </table>
                </div>
                <hr />
                <div id="cart_state" class="d-flex justify-content-center" role="alert"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="javascript:buyAsync()">Buy</a>
            </div>
        </div>
    </div>
</div>
<!-- Order Modal-->
<div class="modal fade" id="order_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:550px;">
            <div class="modal-header">
                <h5 class="modal-title">My Orders</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <table class="table table-hover table-stripped">
                        <thead>
                            <tr>
                                <th scope="col"><div style="text-align:center">Order ID</div></th>
                                <th scope="col"><div style="text-align:center">Date</div></th>
                                <th scope="col"><div style="text-align:center">Shipping</div></th>
                                <th scope="col"><div style="text-align:center">Status</div></th>
                                <th scope="col"><div style="text-align:right">Total $</div></th>
                            </tr>
                        </thead>
                        <tbody id="orderContent">
                            <!-- Load cart footer -->
                        </tbody>
                        <tfoot id="orderFooter">
                            <!-- Load cart footer -->
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>