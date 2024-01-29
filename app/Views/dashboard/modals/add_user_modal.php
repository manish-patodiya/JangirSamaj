<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js">
</script>
<style>
#frm-add-member i {
    color: red;
}

.hindi {
    font-size: 14px;
}
</style>
<div class="modal fade" id="mdl-add-user">
    <div class="modal-dialog modal-xl modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form class="p-0 m-0 form " id="frm-add-user" method="post">
                <div class="modal-body row mx-2">
                    <div class="row m-2">
                        <div class="col-md-3">
                            <div class="border border-dark position-relative " id="add-member-profile">
                                <img src="public/img/avatar.png" alt=" Admin" class="w-100" id="member-profile-photo">
                                <div class="position-absolute top-0 bottom-0 start-0 end-0 justify-content-center align-items-center "
                                    id="change-photo" style="cursor:pointer; display:none; background:#abacac;">
                                    <a class="h3 mt-2 fa fa-camera  text-dark"></a>
                                </div>
                            </div>
                            <input type="file" name="profile" id="choose-photo" accept="image/*" class="d-none">
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-3">
                                    <label class="label">First Name / <span class="hindi">पहला
                                            नाम</span><i>*</i></label>
                                    <input type="text" name="fname" class="form-control " required>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-3">
                                    <label class="label">Middle Name / <span class="hindi">मध्य नाम</span></label>
                                    <input type="text" name="mname" class="form-control">
                                </div>
                                <div class="col-md-6 col-sm-12  mb-3">
                                    <label class="label">Last Name /
                                        <span class="hindi">अंतिम नाम</span><i>*</i></label>
                                    <input type="text" name="lname" class="form-control" required>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-3">
                                    <label class="label">Phone no. / <span class="hindi">फोन नं.</span><i>*</i></label>
                                    <div class="m-0 row">
                                        <span class="col-2 p-2 input-group-text">+91</span>
                                        <input type="number" name="phone" id="phone" required
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
                                                    class="form-check-input " required value="Male">Male /
                                                <span class="hindi">पुरुष<span></label>
                                            <label class="me-5"><input type="radio" name="gender"
                                                    class="form-check-input" required value="Female"> Female /
                                                <span class="hindi">महिला</span></label>
                                            <label class=""><input type="radio" name="gender" class="form-check-input"
                                                    required value="Other">Other /
                                                <span class="hindi">अन्य</span></label><br>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 ">
                                    <p class="m-0">
                                        <label class="label">Gotra / <span class="hindi">गोत्र</span><i>*</i></label>
                                        <select class="selectpicker form-control text-dark" name="gotra" id="gotra"
                                            data-live-search="true" required>
                                            <option value="">Select your gotra / अपना गोत्र चुनें</option>
                                            <?php foreach ($gotra as $value) {?>

                                            <option value="<?=$value->id?>">
                                                <?=$value->gotra?></option><?php }?>
                                        </select>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col-md-3 col-sm-12 card border-0">
                            <div class="row ">
                                <div class="mb-3 col-12 ">
                                    <label class="label">Date of birth / <span
                                            class="hindi">जन्मदिवस</span><i>*</i></label>
                                    <input class="form-control" name="dob" type="date" required>
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="label">State / <span class="hindi">राज्य</span><i>*</i></label>
                                    <select name="state" class="form-select" id="state" required>
                                        <option value="" selected>Select state / राज्य चुनें</option>
                                        <?php foreach ($states as $value) {?>
                                        <option value='<?=$value->id?>'>
                                            <?=$value->state?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="label">District /
                                        <span class="hindi">ज़िला</span><i>*</i></label>

                                    <select name="district" class="form-select" id="district" required>
                                        <option value="" selected>Select district /
                                            जिले का चयन करें</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-12">

                                    <label class="label">Tahsil / <span class="hindi">तहसील</span><i>*</i></label>
                                    <input type="text" name="tahsil" required class="form-control">
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="label">Address / <span class="hindi">पता</span> </label>
                                    <textarea name="address" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col card border-0">
                            <div class="row">
                                <div class="col-md-6 col-sm-10 mb-3">
                                    <label class="label">Education / <span class="hindi">शिक्षा</span><i>*</i></label>
                                    <select name="education" id="select-education" class="form-select" required>
                                        <option selected value="">Select One </option>
                                        <?php foreach ($education as $value) {?>
                                        <option value='<?=$value->education?>'><?=$value->education?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-10 mb-3">
                                    <label class="label">Qualification / <span
                                            class="hindi">योग्यता</span><i>*</i></label>
                                    <select name="qualification" id="select-qualification" class="form-select" required>
                                        <option selected value="">Select One </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-3">
                                    <label class="label">Father's Name / <span class="hindi">पिता का
                                            नाम</span><i>*</i></label>
                                    <input type="text" name="father" class="form-control" required>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-3">
                                    <label class="label">Mother's Name / <span class="hindi">माता का नाम</span> </label>
                                    <input type="text" name="mother" class="form-control">
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
                                        <option value=<?=$value->id?>>
                                            <?=$value->occupation?></option>
                                        <?php }?>
                                        <option value="0">Other /
                                            अन्य</option>
                                    </select>
                                    <input type="text" name="new-occ" class="form-control" id="new-occ"
                                        style="display:none" required>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-3">
                                    <label class="label">Occupation detail/
                                        <span class="hindi">व्यवसाय विवरण</span> </label>
                                    <textarea name="occdetail" class="form-control h-75"
                                        placeholder="Write something about your occupation"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-3">
                                    <label class="label">Marital Status / <span class="hindi">वैवाहिक
                                            स्थिति</span><i>*</i></label>
                                    <select name="mstatus" class="form-select" required id="marital-status">
                                        <option selected value="">Select One</option>
                                        <option value="Single">Single / एकल</option>
                                        <option value="Married">Married / विवाहित</option>
                                        <option value="Divorcee"> Divorcee / तलाक</option>
                                        <option value="Widow">Widow / विधवा</option>
                                        <option value="Not to disclose">Not to disclose / प्रकट नहीं करना चाहते
                                        </option>
                                    </select>
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" name="formarriage" type="checkbox" value="1"
                                            id="availableForMarriage" disabled>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Available for marriage / <span class="hindi">जीवन साथी खोज रहे हैं</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style=" display:none" id="mr-info">
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <p>
                                        <label class="label">Gotra (Mother) / <span class="hindi">माता का गोत्र</span>
                                            <i>*</i></label>
                                        <select class="selectpicker form-control" name="motherGotra"
                                            data-live-search="true" required>
                                            <option value="">Select your mother's gotra</option>
                                            <?php foreach ($gotra as $value) {?>
                                            <option value="<?=$value->id?>">
                                                <?=$value->gotra?><?php }?>
                                        </select>
                                    </p>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <p>
                                        <label class="label">Gotra (Dadi) / <span class="hindi">दादी का
                                                गोत्र</span><i>*</i></label>
                                        <select class="selectpicker form-control " name="dadiGotra"
                                            data-live-search="true" required>
                                            <option value="">Select your grand mother's gotra</option>
                                            <?php foreach ($gotra as $value) {?>
                                            <option value="<?=$value->id?>">
                                                <?=$value->gotra?><?php }?>
                                        </select>
                                    </p>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-3">
                                    <p>
                                        <label class="label">Gotra (Nani) / <span class="hindi">नानी का
                                                गोत्र</span><i>*</i></label>
                                        <select class="selectpicker form-control" name="naniGotra"
                                            data-live-search="true" required>
                                            <option value="">Select your nani's gotra</option>
                                            <?php foreach ($gotra as $value) {?>
                                            <option value="<?=$value->id?>">
                                                <?=$value->gotra?><?php }?>
                                        </select>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-3">
                                        <label class="label">Place of birth /
                                            <span class="hindi">जन्म स्थान</span><i>*</i></label>
                                        <input name="pob" type="text" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <label class="label">Height (in cms)<i>*</i></label>
                                        <input type="number" name="height" class="form-control" id="hight" required>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <label class="label">Skin color / <span class="hindi">त्वचा का
                                                रंग</span><i>*</i></label>
                                        <select name="skin" class="form-select" required>
                                            <option selected value="">Select One /
                                                एक का चयन करें</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Wheatish">Wheatish</option>
                                            <option value="Dark">Dark</option>
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
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="user-role" name="role" value="">
                    <button class="btn btn-primary" type="submit">Add</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?=base_url('public/js/user_add.js')?>"></script>

<script>
document.getElementById('hight').addEventListener('input', function(e) {
    var x = e.target.value.match(/(\d{0,3})/);
    e.target.value = x[1]
});
</script>