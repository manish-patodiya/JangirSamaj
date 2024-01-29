<?php
echo view('dashboard/header/header_top');
echo view('dashboard/sidebar/sidebar_admin');
?>
<style>
#table-users tbody tr td {
    padding-left: 20px;
}
</style>
<div id="content" class="bg-light">
    <?php echo view("dashboard/header/header"); ?>
    <section class="content-header px-2 ">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <h2 class="fw-lighter">Moderators</h2>
                </div>
                <div class="col-md-9 d-flex justify-content-end mb-2">
                    <a class=" btn btn-outline-dark me-2" id="btn-add-mod" role="2">Add Moderator</a>
                </div>
            </div>
        </div>
    </section>
    <div class="alert alert-success" style="display:none" id="success-msg"></div>
    <section style="display:block" id="sec-table">
        <div class="container-fluid">
            <div class="row m-2 rounded">
                <div class="card border-0 m-p">
                    <div class="card py-3 px-2 border-0 border-bottom mb-2">
                        <div class="d-flex flex-row justify-content-center">
                            <div class="col-md-2 margin">
                                <select class="form-select" id="select-state">
                                    <option value="" selected>Select state</option>
                                    <?php foreach ($states as $value) {echo "<option value='$value->id'>$value->state</option>";}?>
                                </select>
                            </div>
                            <div class="col-md-2 margin">
                                <select class="form-select " id="select-district">
                                    <option value="" selected>Select a state</option>
                                </select>
                            </div>
                            <div class="col-md-8" style="text-align: right;">
                                <span><?php echo $moderatorscount ?>
                                    <?php echo $moderatorscount == 1 ? "member" : "members"; ?></span>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped" id="table-users">
                        <thead>
                            <tr>
                                <th scope="col">Photo</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone no.</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Address</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <nav class="nav justify-content-end">
                    </nav>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url('public/js/moderators.js') ?>"></script>
<?php
echo view('dashboard/modals/delete_modal');
echo view('dashboard/modals/view_user_modal');
echo view('dashboard/footer/footer.php');
echo view('dashboard/modals/add_user_modal');
?>