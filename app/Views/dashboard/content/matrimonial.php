<?php
echo view('dashboard/header/header_top');
echo view('dashboard/sidebar/' . $sidebar);
?>
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js">
</script>
<style>
#table-users tbody tr td {
    padding-left: 20px;

}

.form-control {
    border: 1px solid !important;
}
</style>
<div id="content" class="bg-light">
    <?php echo view("dashboard/header/header"); ?>
    <section class="content-header px-2 ">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <label class="fw-lighter" style="font-size:35px">Matrimonial</label>
                </div>
                <div class="col-sm-6 total_member">
                    <span><?php echo $matrimonialcount ?>
                        <?php echo $matrimonialcount == 1 ? "member" : "members" ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="form-select form-control" id="sort">
                        <option value="" selected>Recently Added</option>
                        <option value="sort">Sort By Age</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12 mb-2 ">
                    <div class="d-flex p-0 text-center">
                        <div class="border border-dark pointer w-75 rounded-start bg-dark text-white"
                            style="padding:.38rem !important" id="filter-male">
                            <Span>Male</Span>
                            <input class="d-none" type="radio" name="gender" value="Male" checked id="radio-male">
                        </div>
                        <div class="border border-dark w-100 border-start-0 pointer rounded-end"
                            style="padding:.38rem !important" id="filter-female">
                            <span>Female</span>
                            <input class="d-none" type="radio" name="gender" value="Female" id="radio-female">
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="form-select form-control" id="marital-status">
                        <option value="" selected>Marital Status</option>
                        <option value="Single">Single</option>
                        <option value="Divorce">Divorce</option>
                        <option value="Widow">Widow</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="form-select form-control" id="age">
                        <option value="0" selected>Choose Age</option>
                        <option value="1">Age 20-25</option>
                        <option value="2">Age 25-30</option>
                        <option value="3">Age 30-35</option>
                        <option value="4">Age 35-40</option>
                        <option value="5">Age Above 40</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="form-select form-control" id="height">
                        <option value="0" selected>Choose Height</option>
                        <option value="1">Below 5 feet</option>
                        <option value="2">5'0"-5'5" feet</option>
                        <option value="3">5'5"-6'0" feet</option>
                        <option value="4">6'0"-6'5" feet</option>
                        <option value="5">Above 6'5"</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="form-select form-control" id="select-edu">
                        <option value="" selected>Education</option>
                        <?php foreach ($education as $value) {
    echo " <option value='$value->education'>$value->education</option>";}?>
                    </select>
                </div>
            </div>

            <div class="row mt-2" id="filter-gotra">
                <div class=" col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="form-select form-control" id="manglik">
                        <option value="" selected>Choose Manglik</option>
                        <option value="1">Manglik</option>
                        <option value="0">Non Manglik</option>
                    </select>
                </div>
                <div class=" col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="selectpicker form-select form-control text-dark gotra" data-live-search="true"
                        id="sg">
                        <option value="" selected>Your Gotra</option>
                        <?php foreach ($gotra as $value) {?>

                        <option value="<?=$value->id?>">
                            <?=$value->gotra?></option><?php }?>
                    </select>
                </div>
                <div class=" col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="selectpicker form-select form-control text-dark gotra" data-live-search="true"
                        id="dg">
                        <option value="" selected>Daadi Gotra</option>
                        <?php foreach ($gotra as $value) {?>

                        <option value="<?=$value->id?>">
                            <?=$value->gotra?></option><?php }?>
                    </select>
                </div>
                <div class=" col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="selectpicker form-select form-control text-dark gotra" data-live-search="true"
                        id="ng">
                        <option value="" selected>Naani Gotra</option>
                        <?php foreach ($gotra as $value) {?>

                        <option value="<?=$value->id?>">
                            <?=$value->gotra?></option><?php }?>
                    </select>
                </div>
                <div class=" col-md-2 col-sm-4 col-xs-12 mb-2">
                    <select class="selectpicker form-select form-control text-dark gotra" data-live-search="true"
                        id="mg">
                        <option value="" selected>Mother Gotra</option>
                        <?php foreach ($gotra as $value) {?>

                        <option value="<?=$value->id?>">
                            <?=$value->gotra?></option><?php }?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12 mb-2" id="fav">
                    <button type="button" class="btn btn-outline-danger w-100"
                        uid="<?php echo $session->get("user_details")["id"] ?>" value="unchecked" id="my_fav">My
                        Favourites</button>
                    <input type="checkbox" style="display:none" id="inpt-is-fav">
                </div>
            </div>
        </div>
    </section>
    <section style="display:block" id="sec-cards">
        <div class="container-fluid">
            <div class="row  m-2 rounded">
                <div class="row p-0" id="matrimonial-cards">
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url('public/js/matrimonial.js') ?>"></script>

<?php
echo view('dashboard/modals/mdl_matrimonial_detail');
echo view('dashboard/modals/mdl_share_matrimonial_card');
echo view('dashboard/footer/footer');
?>