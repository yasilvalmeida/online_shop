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
                <a class="btn btn-danger" href="javascript:exit()">Yes</a>
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
                <form class="user">
                    <div class="form-group">
                        <input id="username_changed" type="text" class="form-control form-control-user" />
                    </div>
                    <div class="form-group">
                        <input id="password_changed" type="password" class="form-control form-control-user" />
                    </div>
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