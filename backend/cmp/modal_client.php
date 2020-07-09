<!-- Modals -->
<!-- Add Modal-->
<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Insert client</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="client-insert">
                    <div class="form-group">
                        <input id="username_to_insert" type="text" class="form-control form-control-user" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <input id="password_to_insert" type="password" class="form-control form-control-user" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <input id="balance_to_insert" type="number" min="0" max="1" class="form-control form-control-user" placeholder="Access"/>
                    </div>
                    <hr />
                    <div id="insert_state" class="" role="alert">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="javascript:insert()">Insert</a>
            </div>
        </div>
    </div>
</div>
<!-- Upd Modal-->
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update client</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="update-client">
                    <div class="form-group">
                        <input id="id_to_update" type="hidden" class="form-control form-control-user" />
                    </div>
                    <div class="form-group">
                        <label>Username </label>
                        <input id="username_to_update" type="text" class="form-control form-control-user" />
                    </div>
                    <div class="form-group">
                        <label>Password </label>
                        <input id="password_to_update" type="password" class="form-control form-control-user" />
                    </div>
                    <div class="form-group">
                        <label>Balance </label>
                        <input id="balance_to_update" type="text" class="form-control form-control-user" />
                    </div>
                    <hr />
                    <div id="update_state" class="" role="alert">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="javascript:updateAsync()">Update</a>
            </div>
        </div>
    </div>
</div>
<!-- Del Modal-->
<div class="modal fade" id="remove_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete client</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you want to delete this client?</p>
                <input id='id_to_remove' type='hidden' />
                <div id='remove_state' role='alert'></div >
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="javascript:removeAsync()">Remove</a>
            </div>
        </div>
    </div>
</div>