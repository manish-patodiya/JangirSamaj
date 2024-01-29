<div class="modal fade" id="mdl-add-csv">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Member List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" id="frm-add-csv">
                <div class="modal-body mx-5">
                    <div class="my-2">
                        <input class="form-control" name='csv' required accept=".csv" type="file">
                        <span class="text-secondary" style="font-size:13px">Only CSV file allowed</span>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button class="btn btn-primary">Download Sample</button>
                    <button class="btn btn-primary" id="btn-upload-csv">upload</button>
                </div>
            </form>
        </div>
    </div>
</div>