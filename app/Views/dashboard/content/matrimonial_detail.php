<?php
echo view('dashboard/header/header_top');
echo view('dashboard/sidebar/' . $sidebar);
?>
<div id="content" class="bg-light">
    <?php echo view("dashboard/header/header"); ?>
    <section class="content m-3">
        <!-- Prasnal Information -->
        <div class="col-sm-3 mb-3">
            <label class="fw-lighter" style="font-size:30px">Member Profile</label>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 ">
                <img src="<?=base_url('public/uploads/members_profile/' . $detail['profile_photo'])?>" alt="Admin"
                    width="360" height="300" id="photo">
            </div>
            <div class="col-md-7">
                <div class="mb-3">
                    <span class="h2 text-secondary"><?=$detail['first_name'] . " " . $detail['last_name']?></span>
                    <div class="mb-2 fw-normal font-size">
                        <span><?=$detail['occupation']?></span>
                    </div>
                </div>
                <div class=" d-flex flex-column justify-content-center">
                    <div class="mb-2 fw-normal font-size">
                        <i class="fas fa-birthday-cake me-3"></i>
                        <span><?=$detail['dob']?></span>
                    </div>
                    <div class="mb-2 fw-normal font-size">
                        <i class="fas fa-phone-alt me-3" target="_blank"></i>
                        <span><?=$detail['phone'] ?: ""?></span>
                    </div>
                    <div class="mb-2 fw-normal font-size">
                        <i class="far fa-envelope me-3"></i>
                        <a href="mailto:<?=$detail['email']?> " target="_blank">
                            <span><?=$detail['email']?></span>
                        </a>
                    </div>
                    <div class="mb-2 fw-normal font-size">
                        <i class="fas fa-map-marker-alt me-3"></i>
                        <a href="https://www.google.com/maps/place/<?=trim(implode(" ", [$detail['address'], $detail['district'], $detail['state']]))?>"
                            target="_blank">
                            <span class="pointer">
                                <span><?=trim(implode(" ", [$detail['address'], $detail['district'], $detail['state']])) ?: "N/A"?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Family Details   -->
        <div class="row  mt-4">
            <div class="col-md-6">
                <h4 style="color: #f25a0f; font-weight: 400;" class="mb-3">Family Details /
                    <snap class="font">पारिवारिक विवरण</snap>
                </h4>
                <div class="row mb-3">
                    <div class="col-6 m-auto">
                        <span class="mb-0">Father's Name / पिता का नाम</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['father_name']?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <span class="mb-0">Mother's Name / माता का नाम</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['mother_name']?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 ">
                        <span class="mb-0">Self Income / स्वयं आय</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['self_income']?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 ">
                        <span class="mb-0">Family Income / पारिवारिक आय</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['family_income']?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 ">
                        <span class="mb-0">Father Occupation / पिता का व्यवसाय</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['father_occupation']?>
                    </div>
                </div>
            </div>

            <!-- Gotras Details -->
            <div class="col-md-6">
                <h4 style="color: #f25a0f; font-weight: 400;" class="mb-3">Gotras Details / <snap class="font">गोत्र
                        विवरण
                    </snap>
                </h4>
                <div class="row mb-3">
                    <div class="col-6 ">
                        <span class="mb-0"> Self Gotra /
                            गोत्र ( स्वयं )</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['gotra']?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 ">
                        <span class="mb-0"> Mother's Gotra /
                            गोत्र ( माता )</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['mgotra']?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <span class="mb-0"> Gotra (Dadi) / गोत्र ( दादी )</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['dgotra']?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 ">
                        <span class="mb-0"> Gotra (Nani) / गोत्र ( नानी )</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['ngotra']?>
                    </div>
                </div>
            </div>
        </div>

        <!-- lifeststyle And  Education Details  -->
        <div class="row ">
            <div class="col-md-6">
                <h4 style="color: #f25a0f; font-weight: 400;" class="mb-3">Lifest Style / <snap class="font">जीवन शैली
                    </snap>
                </h4>
                <div class="row mb-3">
                    <div class="col-6 ">
                        <span class="mb-0">Heigth / ऊँचाइ</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['height']?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 m-auto">
                        <span class="mb-0">Blood Group / रक्त समूह</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['blood_group']?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 m-auto">
                        <span class="mb-0">Marital Status / वैवाहिक स्थिति</span>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['marital_status']?>
                    </div>
                </div>
            </div>

            <!-- Education Details -->
            <div class="col-md-6">
                <h4 style="color: #f25a0f; font-weight: 400;" class="mb-3">Education Details /
                    <snap class="font"> शिक्षा विवरण</snap>
                </h4>
                <div class="row mb-3">
                    <div class="col-6 m-auto">
                        <label class="mb-0">Highest Education / उच्चतम शिक्षा</labelS>
                    </div>
                    <div class="col-6 text-secondary"><?=$detail['education']?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
echo view('dashboard/footer/footer');
?>