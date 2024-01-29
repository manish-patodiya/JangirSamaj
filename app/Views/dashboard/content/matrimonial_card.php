<?php
echo view('dashboard/header/header_top');
?>
<style>
a {
    color: #212529;
}



.imgwidth {
    width: 220px
}
</style>
<div class="col-md-6 card-member bodywidth">
    <div class="card mb-3 mcard m-2">
        <a class="fs-4  m-2" href="<?=base_url()?>">
            <img src="<?=base_url('public/img/Vishwakarma.jpg')?>" width="40" height="40"> Jangid
            Samaj </a>
        <hr class="my-0">
        <div class="row g-0 m-2">
            <div class="col-md-4 imgwidth">
                <?php
$path = $profile_photo ? base_url() . "/public/uploads/members_profile/" . $profile_photo : ($gender && $gender == "Male" ? base_url() . "/public/img/male.jpg" : base_url() . "/public/img/female.jpg");
?>
                <img src="<?=$path;?>" class="img-fluid rounded-start" alt="<?=$first_name . " " . $last_name;?>"
                    style="height:215px;">
            </div>
            <div class="col-md-8 p-1">
                <span class="h4" uid="<?=$user_id;?>"><?=$first_name . " " . $last_name;?></span>
                <span class="h6" uid="<?=$user_id;?>"><?="s/o " . $father_name;?></span>

                <div class="row ">
                    <div class="col-sm-6 wcrd">
                        <label class="mb-0 label">Marital Status</label>
                    </div>
                    <div class="col-6 text-secondary hideextra" title="<?=$marital_status;?>">
                        <?php echo $marital_status ? $marital_status : "N/A"; ?>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-6 wcrd">
                        <label class="mb-0 label">Gender</label>
                    </div>
                    <div class="col-6 text-secondary hideextra" id="gender"
                        title="<?php echo $gender ? $gender : "Not available"; ?>">
                        <?php echo $gender ? $gender : "N/A"; ?>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-6 wcrd">
                        <label class="mb-0 label">Height</label>
                    </div>
                    <div class="col-6 text-secondary hideextra" id="height"
                        title="<?php echo $height ? $height : "Not available"; ?>">
                        <?php echo $height ? $height : "N/A"; ?>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-6 wcrd">
                        <label class="mb-0 label">Date of birth</label>
                    </div>
                    <div class="col-6 text-secondary hideextra" title="<?php echo $dob ? $dob : "Not available"; ?>">
                        <?php echo $dob ? $dob : "N/A"; ?></div>
                </div>
                <div class="row ">
                    <div class="col-sm-6 wcrd">
                        <label class="mb-0 label">Education</label>
                    </div>
                    <div class="col-6 text-secondary hideextra" id="edu"
                        title="<?php echo $education ? $education : "Not available"; ?>">
                        <?php echo $education ? $education : "N/A"; ?>
                    </div>
                </div>
                <div clssa="row ">
                    <div class="text-end me-3 mt-4 text-secondary">
                        <a href="<?php echo base_url("matrimonial/matrimonial_msg"); ?>"
                            class="btn btn-primary btn-sm">Contact
                            me</a>
                        <a href="<?php echo base_url("matrimonial/matrimonial_detail/$user_id"); ?>"
                            class="btn btn-primary btn-sm" id="dateil">Show
                            full details</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>