<!-- Modals -->
<!-- Add Modal-->
<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Insert user</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user-insert">
                    <div class="form-group">
                        <input id="username_to_insert" type="text" class="form-control form-control-user" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <input id="password_to_insert" type="password" class="form-control form-control-user" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <input id="access_to_insert" type="number" min="0" max="1" class="form-control form-control-user" placeholder="Access"/>
                    </div>
                    <hr />
                    <table>
                        <tr>
                            <td><b>Access 0:</b></td>
                            <td>Full access</td>
                        </tr>
                        <tr>
                            <td><b>Access 1:</b></td>
                            <td>Restricted access without user management</td>
                        </tr>
                    </table>
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
                <h5 class="modal-title">Update user</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="update-user">
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
                        <label>Acesso </label>
                        <input id="access_to_update" type="number" min="0" max="1" class="form-control form-control-user" />
                    </div>
                    <hr />
                    <table>
                        <tr>
                            <td><b>Access 0:</b></td>
                            <td>Full access</td>
                        </tr>
                        <tr>
                            <td><b>Access 1:</b></td>
                            <td>Restricted access without user management</td>
                        </tr>
                    </table>
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
                <h5 class="modal-title">Delete user</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you want to delete this user?</p>
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