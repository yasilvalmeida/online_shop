<!-- Modals -->
<!-- Add Modal-->
<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Insert shipping</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user-insert">
                    <div class="form-group">
                        <input id="name_to_insert" type="text" class="form-control form-control-user" placeholder="Name"/>
                    </div>
                    <div class="form-group">
                        <input id="price_to_insert" type="text" class="form-control form-control-user" placeholder="Price $"/>
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
                <h5 class="modal-title">Update shipping</h5>
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
                        <label>Name </label>
                        <input id="name_to_update" type="text" class="form-control form-control-user" />
                    </div>
                    <div class="form-group">
                        <label>Price $ </label>
                        <input id="price_to_update" type="text" class="form-control form-control-user" />
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
                <h5 class="modal-title">Delete shipping</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you want to delete this shipping?</p>
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