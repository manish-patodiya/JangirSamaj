<?php
echo view('dashboard/header/header_top');
echo view('dashboard/sidebar/' . $sidebar);
?>
<div id="content">
    <?=view('dashboard/header/header.php');?>
    <section class="px-2">
        <div class="w-100 p-3">
            <div class="row">
                <div class="col-md-3 mb-4" style="min-width:270px">
                    <div id="profile">
                        <img src="<?=$info->profile_photo?>" alt="Admin" width="270" height="270" id="profile-photo">
                    </div>
                </div>
                <div class="col-md-9 ps-md-4 pe-0 row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <div class="h1 mb-1 fw-normal " style="color:#4f6376">
                                <?=$info->first_name . " " . $info->last_name?>
                            </div>
                            <div class="h4 text-secondary fw-normal">
                                <?=$info->occupation?>
                            </div>
                        </div>
                        <div class=" d-flex flex-column justify-content-center">
                            <div class="mb-2 fw-normal ">
                                <i class="far fa-envelope me-3"></i>
                                <span style="color:#3875ce"><?='N/A'?></span>
                            </div>
                            <div class="mb-2 fw-normal">
                                <i class="fas fa-phone-alt me-3"></i>
                                <span style="color:#3875ce"><?=$info->phone?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end my-3" style="min-width:282px">
                        <a class="btn btn-outline-dark " id="btn-change-pass">Change Password</a>
                        <a class="btn btn-outline-dark"
                            href="<?=base_url("profile/editProfile/" . base64_encode($session->get('user_details')['id']))?>">Edit
                            profile</a>
                    </div>
                </div>
            </div>
            <div class="bg-white">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" data-bs-toggle="tab"
                            data-bs-target="#profile-tab">Profile</button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#business-tab">Business</button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#setting-tab">Setting</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="profile-tab" role="tabpanel">
                        <div class="row p-3 pe-5">
                            <div class="col-md ">
                                <h4 class="text-secondary">ABOUT</h4>
                                <hr class="m-0">
                                <div class="my-4">
                                    <label class="text-secondary">Date of birth</label>
                                    <div class="h6" style="font-size:18px">
                                        <?=$info->dob?>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <label class="text-secondary">Gender</label>
                                    <div class="h6" style="font-size:18px">
                                        <?=$info->gender?>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <label class="text-secondary">Education</label>
                                    <div class="h6" style="font-size:18px">
                                        <?=$info->education?>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <label class="text-secondary">Marital Status</label>
                                    <div class="h6" style="font-size:18px">
                                        <?=$info->marital_status?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <h4 class="text-secondary">LOCATION</h4>
                                <hr class="m-0">
                                <div class="my-4">
                                    <label class="text-secondary">Country</label>
                                    <div class="h6" style="font-size:18px">
                                        India
                                    </div>
                                </div>
                                <div class="my-4">
                                    <label class="text-secondary">State</label>
                                    <div class="h6" style="font-size:18px">
                                        <?=$info->state?>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <label class="text-secondary">District</label>
                                    <div class="h6" style="font-size:18px">
                                        <?=$info->district?>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <label class="text-secondary">Address</label>
                                    <div class="h6" style="font-size:18px">
                                        <?=$info->address . ", " . $info->tahsil?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="business-tab" role="tabpanel">...
                    </div>
                    <div class="tab-pane fade" id="setting-tab" role="tabpanel">..
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url('public/js/profile.js') ?>"></script>
<?php
echo view('dashboard/modals/change_pass_modal');
echo view('dashboard/footer/footer.php');
?>