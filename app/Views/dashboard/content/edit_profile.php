<?php
echo view('dashboard/header/header_top');
echo view('dashboard/sidebar/' . $sidebar);
?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js">
</script>
<style>
#frm-profile i {
    color: red;
}

.hindi {
    font-size: 14px;
}
</style>
<div id="content">
    <?=view('dashboard/header/header.php');?>
    <section class="content-header px-2 ">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="fw-lighter">Profile</h2>
                </div>
                <div class="col-sm-6 text-end"
                    style="<?=$session->get('user_details')['complete_profile'] ? false : 'display:none'?>">
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="alert alert-danger text-center mt-2"
        style=" <?=$session->get('user_details')['complete_profile'] ? 'display:none' : false?>" id="incmplt-prfl">
        Your profile is incomplete, please complete your profile!
    </div>
    <div class="alert alert-success text-center mt-2" id="scs-cmplt-prfl" style="display:none;">
        Succesful! Redirecting
    </div>
    <section class="content-header ">
        <div class="container-fluid">
            <form class="p-0 m-0 form needs-validation" novalidate id="frm-profile" method="post">
                <div class="row m-2 mb-0 border border-bottom-0 rounded">
                    <div class="col-md-3 card border-0 ">
                        <div class="card-body m-auto">
                            <div class="text-center">
                                <div class="circle border border-dark position-relative " id="profile">
                                    <img src="<?=$info->profile_photo?>" alt="Admin" class="circle" id="profile-photo">
                                    <div class="position-absolute top-0 bottom-0 start-0 end-0 circle   justify-content-center align-items-center "
                                        id="change-photo" style="cursor:pointer; display:none; background:#abacac;">
                                        <a class="h3 mt-2 fa fa-camera  text-dark"></a>
                                    </div>
                                </div>
                                <input type="file" name="profile" id="choose-photo" accept="image/*" class="d-none">
                                <div class=" mt-2">
                                    <h4 class="mb-3">
                                        <?=ucfirst($info->first_name) . " " . ucfirst($info->middle_name) . " " . ucfirst($info->last_name)?>
                                    </h4>
                                </div>
                                <script>
                                let width = document.getElementById('profile-photo').clientWidth;
                                $("#profile-photo").css("height", width - 2);
                                let height = document.getElementById('profile-photo').clientHeight;
                                $("#profile").css("height", height + 2);
                                $("#profile").css("width", width);
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 card border-0 p-3 pb-0">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="label">First Name / <span class="hindi">पहला
                                        नाम</span><i>*</i></label>
                                <input type="text" name="fname" class="form-control " value="<?=$info->first_name?>"
                                    required>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="label">Middle Name / <span class="hindi">मध्य नाम</span></label>
                                <input type="text" name="mname" class="form-control" value="<?=$info->middle_name?>">
                            </div>
                            <div class="col-md-6 col-sm-12  mb-3">
                                <label class="label">Last Name /
                                    <span class="hindi">अंतिम नाम</span><i>*</i></label>
                                <input type="text" name="lname" class="form-control" value="<?=$info->last_name?>"
                                    required>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="label">Phone no. / <span class="hindi">फोन नं.</span><i>*</i></label>
                                <div class="m-0 row">
                                    <span class="col-2 p-2 input-group-text">+91</span>
                                    <input type="text" name="phone" value="<?=$info->phone ?: 'N/A'?>" disabled
                                        class="col border-start-0 rounded-0 rounded-end form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class=" col-md-6 col-sm-12 ">
                                <label class="label mb-1">Gender<i>*</i></label>
                                <div class="text-secondary form-check ps-2">
                                    <p class="m-0 ms-3">
                                        <label class="me-5"><input type="radio" name="gender"
                                                <?=$info->gender == "Male" ? 'checked' : false?>
                                                class="form-check-input " required value="Male">Male / <span
                                                class="hindi">पुरुष</span></label>
                                        <label class="me-5"><input type="radio" name="gender"
                                                <?=$info->gender == "Female" ? 'checked' : false?>
                                                class="form-check-input" required value="Female"> Female / <span
                                                class="hindi">महिला</span></label>
                                        <label class=""><input type="radio" name="gender"
                                                <?=$info->gender == "Other" ? 'checked' : false?>
                                                class="form-check-input" required value="Other">Other / <span
                                                class="hindi">अन्य</span></label>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 ">
                                <p class="m-0">
                                    <label class="label">Gotra/ <span class="hindi">गोत्र</span><i>*</i></label>
                                    <select class="selectpicker form-control text-dark" name="gotra" id="gotra"
                                        data-live-search="true" required>
                                        <option value="">Select your gotra / अपना गोत्र चुनें</option>
                                        <?php foreach ($gotra as $value) {?>

                                        <option value="<?=$value->id?>"
                                            <?=$value->id == $info->self_gotra_id ? "selected" : false?>>
                                            <?=$value->gotra?></option><?php }?>
                                    </select>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-10 mb-3">
                                <label class="label">Education / <span class="hindi">शिक्षा</span><i>*</i></label>
                                <select name="education" id="education" class="form-select" required>
                                    <option selected value="">Select One </option>
                                    <?php foreach ($education as $value) {
    $slct = strtoupper($info->education) == $value->education ? 'selected' : '';
    echo " <option $slct value='$value->education'>$value->education</option>";}?>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-10 mb-3">
                                <label class="label">Qualification / <span class="hindi">योग्यता</span><i>*</i></label>
                                <select name="qualification" id="select-qualification" class="form-select" required>
                                    <option selected value="">Select One </option>
                                    <?php if ($qualification) {foreach ($qualification as $value) {
    $slct = $info->qualification_id == $value->id ? 'selected' : '';
    echo " <option $slct value='$value->id'>$value->qualification</option>";}}?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row m-2 mt-0  border border-top-0 rounded">
                    <div class="col-md-3 col-sm-12 card border-0">
                        <div class="row ">
                            <div class="mb-3 col-12 ">
                                <label class="label">Date of birth / <span class="hindi">जन्मदिवस</span><i>*</i></label>
                                <input class="form-control" value="<?=$info->dob?>" name="dob" type="date" required>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="label">State / <span class="hindi">राज्य</span><i>*</i></label>
                                <select name="state" class="form-select" id="select-state" required>
                                    <option value="" selected>Select state / राज्य चुनें</option>
                                    <?php foreach ($states as $value) {?>
                                    <option value='<?=$value->id?>'
                                        <?=$value->id == $info->state_id ? "selected" : false?>>
                                        <?=$value->state?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="label">District /
                                    <span class="hindi">ज़िला</span><i>*</i></label>

                                <select name="district" class="form-select" id="select-district" required>
                                    <option value="" selected>Select district /
                                        जिले का चयन करें</option>
                                    <?php if ($districts) {foreach ($districts as $value) {?>
                                    <option value="<?=$value->id?>"
                                        <?=$value->id == $info->district_id ? "selected" : false?>>
                                        <?=$value->district?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="mb-3 col-12">

                                <label class="label">Tahsil/ <span class="hindi">तहसील</span><i>*</i></label>
                                <input type="text" name="tahsil" required class="form-control"
                                    value="<?=$info->tahsil?>">
                            </div>
                            <div class="mb-3 col-12">
                                <label class="label">Address / <span class="hindi">पता</span> </label>
                                <textarea name="address" class="form-control"> <?=$info->address?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col card border-0">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="label">Father's Name / <span class="hindi">पिता का
                                        नाम</span><i>*</i></label>
                                <input type="text" name="father" class="form-control" value="<?=$info->father_name?>"
                                    required>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="label">Mother's Name / <span class="hindi">माता का नाम</span> </label>
                                <input type="text" name="mother" class="form-control" value="<?=$info->mother_name?>">
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="label">Occupation /
                                    <span class="hindi">पेशा</span><i>*</i></label>
                                <select name="occupation" class="form-select" id="occupation" required>
                                    <option selected value="">Select One /
                                        एक का चयन करें </option>
                                    <?php foreach ($occupation as $value) {?>
                                    <option <?=$info->occupation_id == $value->id ? "selected" : false?>
                                        value=<?=$value->id?>>
                                        <?=$value->occupation?></option>
                                    <?php }?>
                                    <option value="0">Other /
                                        अन्य</option>
                                </select>
                                <input type="text" name="new-occ" class="form-control" id="new-occ" style="display:none"
                                    required>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="label">Occupation detail/
                                    <span class="hindi">व्यवसाय विवरण</span> </label>
                                <textarea name="occdetail"
                                    class="form-control h-75"><?=$info->occupation_detail?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="label">Marital Status / <span class="hindi">वैवाहिक
                                        स्थिति</span><i>*</i></label>
                                <select name="mstatus" class="form-select" required id="marital-status">
                                    <option selected value="">Select One</option>
                                    <option value="Single" <?=$info->marital_status == "Single" ? "selected" : false?>>
                                        Single / एकल
                                    </option>
                                    <option value="Married"
                                        <?=$info->marital_status == "Married" ? "selected" : false?>>Married / विवाहित
                                    </option>
                                    <option value="Divorcee"
                                        <?=$info->marital_status == "Divorcee" ? "selected" : false?>>Divorcee / तलाक
                                    </option>
                                    <option value="Widow" <?=$info->marital_status == "Widow" ? "selected" : false?>>
                                        Widow / विधवा</option>
                                    <option value="Not to disclose"
                                        <?=$info->marital_status == "Not to disclose" ? "selected" : false?>>Not to
                                        disclose / प्रकट नहीं करना चाहते</option>
                                </select>
                                <div class="form-check mt-1">
                                    <input class="form-check-input" name="formarriage" type="checkbox" value="1"
                                        id="availableForMarriage"
                                        <?=$info->availableformarriage == 1 ? "checked" : false?>
                                        <?=$info->marital_status == "Single" ? false : "disabled"?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Available for marriage / <span class="hindi">जीवन साथी खोज रहे हैं</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="<?=$info->availableformarriage == 1 ? "false" : "display:none"?>"
                            id="mr-info">
                            <div class="col-md-4 col-sm-12 mb-3">
                                <p>
                                    <label class="label">Gotra (Mother) / <span class="hindi">माता का गोत्र</span>
                                        <i>*</i></label>
                                    <select class="selectpicker form-control" name="motherGotra" data-live-search="true"
                                        required>
                                        <option value="">Select your mother's gotra</option>
                                        <?php foreach ($gotra as $value) {?>
                                        <option value="<?=$value->id?>"
                                            <?=$value->id == $info->mother_gotra_id ? "selected" : false?>>
                                            <?=$value->gotra?><?php }?>
                                    </select>
                                </p>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <p>
                                    <label class="label">Gotra (Dadi) / <span class="hindi">दादी का
                                            गोत्र</span><i>*</i></label>
                                    <select class="selectpicker form-control " name="dadiGotra" data-live-search="true"
                                        required>
                                        <option value="">Select your grand mother's gotra</option>
                                        <?php foreach ($gotra as $value) {?>
                                        <option value="<?=$value->id?>"
                                            <?=$value->id == $info->dadi_gotra_id ? "selected" : false?>>
                                            <?=$value->gotra?><?php }?>
                                    </select>
                                </p>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-3">
                                <p>
                                    <label class="label">Gotra (Nani) / <span class="hindi">नानी का
                                            गोत्र</span><i>*</i></label>
                                    <select class="selectpicker form-control" name="naniGotra" data-live-search="true"
                                        required>
                                        <option value="">Select your nani's gotra</option>
                                        <?php foreach ($gotra as $value) {?>
                                        <option value="<?=$value->id?>"
                                            <?=$value->id == $info->nani_gotra_id ? "selected" : false?>>
                                            <?=$value->gotra?><?php }?>
                                    </select>
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-3">
                                    <label class="label">Place of birth /
                                        <span class="hindi">जन्म स्थान</span><i>*</i></label>
                                    <input name="pob" type="text" class="form-control" value="<?=$info->pob?>" required>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <label class="label">Height (in inches)<i>*</i></label>
                                    <input type="number" name="height" value="<?=$info->height?>" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <label class="label">Skin color / <span class="hindi">त्वचा का
                                            रंग</span><i>*</i></label>
                                    <select name="skin" class="form-select" required>
                                        <option selected value="">Select One /
                                            एक का चयन करें</option>
                                        <option value="Fair" <?=$info->skin == "Fair" ? "selected" : false?>>Fair
                                        </option>
                                        <option value="Wheatish" <?=$info->skin == "Wheatish" ? "selected" : false?>>
                                            Wheatish</option>
                                        <option value="Dark" <?=$info->skin == "Dark" ? "selected" : false?>>Dark
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-check mt-1">
                                <p class="m-0">
                                    <input class="form-check-input" name="manglik" type="checkbox" value="1">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Manglik / <span class="hindi">मांगलिक</span>
                                    </label><br>
                                </p>
                            </div>
                        </div>
                        <div class="text-end me-3 my-4 ">
                            <input type="hidden" name="id" value="<?=$id?>" />
                            <span class="d-none" id="new-window"><?=$newwindow?></span>
                            <button class="btn btn-primary" id="btn-update" type="submit">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div><!-- /.container-fluid -->
<script src="<?php echo base_url('public/js/profile.js') ?>"></script>
<?php
echo view('dashboard/modals/change_pass_modal');
echo view('dashboard/footer/footer.php');
?>