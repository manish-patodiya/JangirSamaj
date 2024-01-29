<?php
echo view('dashboard/header/header_top');
echo view('dashboard/sidebar/' . $sidebar);
?>
<style>
.w-15 {
    width: 15% !important;
}

#table-users tbody tr td {
    padding-left: 20px;
}
</style>
<div id="content" class="bg-light">
    <?php echo view("dashboard/header/header"); ?>
    <section class="content-header px-2 ">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-3">
                    <h2 class="fw-lighter">Members</h2>
                </div>
                <div class="col-md-9 d-flex justify-content-end mb-2">
                    <a class=" btn btn-outline-dark me-2" id="btn-add-mem" role="3">Add Member</a>
                    <a class="btn btn-outline-dark" id="btn-add-csv">Upload Members</a>
                </div>
            </div>
        </div>
    </section>
    <div class="alert alert-success" style="display:none" id="success-msg"></div>
    <section style="display:block" id="sec-table">
        <div class="container-fluid">
            <div class="row m-2 rounded">
                <div class="card border-0  m-p">
                    <div class="card py-3 px-2 border-0 border-bottom mb-2">
                        <div class="d-flex justify-content-start ">
                            <div class="col-md-2 col-sm-4 col-xs-12 mb-2 margin">
                                <div class="d-flex p-0 text-center">
                                    <div class="border border-dark pointer w-75 rounded-start bg-dark text-white filter-male"
                                        style="padding:.38rem !important">
                                        <Span>Male</Span>
                                        <input class="d-none radio-male" type="radio" name="gender" value="Male"
                                            checked>
                                    </div>
                                    <div class="border border-dark w-100 border-start-0 pointer rounded-end filter-female"
                                        style="padding:.38rem !important">
                                        <span>Female</span>
                                        <input class="d-none radio-female" type="radio" name="gender" value="Female">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 margin">
                                <select class="form-select " id="select-state">
                                    <option value="" selected>Select state</option>
                                    <?php foreach ($states as $value) {echo "<option value='$value->id'>$value->state</option>";}?>
                                </select>
                            </div>
                            <div class="col-md-2 margin">
                                <select class="form-select " id="select-district">
                                    <option value="" selected>Select District</option>
                                </select>
                            </div>
                            <div class="col-md-3 margin">
                                <button type="button" class="btn btn-light  border" id="sabha-mem">Mahasabha
                                    Member</button>
                                <input name="sabha_member" type="checkbox" style="display:none" value="1">
                            </div>
                            <div class="col-md-3" style="text-align:right;">
                                <span><?php echo $userscount ?>
                                    <?php echo $userscount == 1 ? "member" : "members" ?></span>
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
<script src="<?php echo base_url('public/js/members.js') ?>"></script>
<?php
echo view('dashboard/modals/delete_modal');
echo view('dashboard/modals/demote_member_modal');
echo view('dashboard/modals/promote_member_modal');
echo view('dashboard/modals/view_user_modal');
echo view('dashboard/modals/upload_csv');
echo view('dashboard/modals/add_user_modal');
echo view('dashboard/footer/footer.php');
?>