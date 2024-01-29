<div class="modal fade" id="mdl-delete">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" id="frm-delete" onsubmit="return false">
                <div class="modal-body">

                    <div class="inputvalues">
                        <input name="id" type="hidden" id="delete-id">
                        <span>You want to delete it?</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-dark" data-bs-dismiss="modal">Cancel</a>
                    <button class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>