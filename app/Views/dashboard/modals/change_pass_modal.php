<div class="modal fade" id="mdl-change-pass">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add row here</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" id="frm-change-pass">
                <div class="alert alert-danger" id="pass-err" style="display:none;"></div>
                <div class="modal-body mx-5">
                    <div class="my-2">
                        <input name="password" class="form-control" type="password" placeholder="Current password">
                    </div>
                    <div class="my-2">
                        <input name="new_password" class="form-control" type="password" placeholder="New password"
                            id="new_pass">
                    </div>
                    <div class="my-2">
                        <input name="cpassword" class="form-control" type="password" placeholder="Confirm Password">
                        <input type="hidden" name="frm_name" value="change_pass" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>