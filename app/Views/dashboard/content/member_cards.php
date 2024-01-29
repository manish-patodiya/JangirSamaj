<?php
echo view('dashboard/header/header_top');
echo view('dashboard/sidebar/sidebar_member');
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
                    <label class="fw-lighter" style="font-size:35px">Members</label>
                </div>
                <div class=" col-md-4 col-sm-4 col-xs-12 mb-2">
                </div>
                <div class="col-sm-5 total_member">
                    <span>Total Members: <?php echo $membercount ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-4 col-xs-12 mb-2 ">
                    <div class="d-flex p-0 text-center">
                        <div class="border border-dark pointer w-75 rounded-start bg-dark text-white"
                            style="padding:.38rem !important" id="f-male">
                            <Span>Male</Span>
                            <input class="d-none" type="radio" name="m-card" value="Male" checked id="radio-m">
                        </div>
                        <div class="border border-dark w-100 border-start-0 pointer rounded-end"
                            style="padding:.38rem !important" id="f-female">
                            <span>Female</span>
                            <input class="d-none" type="radio" name="m-card" value="Female" id="radio-f">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12 mb-2 ">
                    <select class="form-select form-control" id="choose-state">
                        <option value="" selected>Select state</option>
                        <?php foreach ($states as $value) {echo "<option value='$value->id'>$value->state</option>";}?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12 mb-2 ">
                    <select class="form-select form-control" id="choose-district">
                        <option value="" selected>Select state</option>
                    </select>
                </div>
                <div class=" col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="form-select form-control" id="choose-tahsil">
                        <option value="" selected>Select District</option>
                    </select>
                </div>
            </div>
        </div>
    </section>
    <section style="display:block" id="sec-table">
        <div class="container-fluid">
            <div class="row  m-2 rounded">
                <div class="row p-0" id="member-cards">
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url('public/js/member_cards.js') ?>"></script>
<?php
echo view('dashboard/modals/mdl_member_details');
echo view('dashboard/footer/footer.php');
?>