<?php
echo view('dashboard/header/header_top');
echo view('dashboard/sidebar/sidebar_admin');
?>
<div id="content" class="bg-light">
    <?php echo view("dashboard/header/header"); ?>
    <section class="content-header px-2 ">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="fw-lighter">Gotras</h2>
                </div>
                <div class="col-sm-6 text-end">
                    <a class="btn btn-outline-dark" id="btn-add-gotra">Add</a>
                </div>
            </div>
        </div>
    </section>
    <div class="alert alert-success" style="display:none" id="success-msg"></div>
    <section style="display:block" id="sec-table">
        <div class="container-fluid">
            <div class="row m-2 rounded">
                <div class="card border-0 m-p">
                    <table class="table table-striped" id="table-gotras">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url("public/js/gotras.js") ?>"></script>
<?php
echo view('dashboard/modals/change_pass_modal');
echo view('dashboard/modals/delete_modal');
echo view('dashboard/footer/footer.php');
echo view('dashboard/modals/add_gotra_modal');
echo view('dashboard/modals/edit_gotra_modal');
?>