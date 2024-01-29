<?php
echo view('dashboard/header/header_top');
echo view('dashboard/sidebar/sidebar_moderator');
?>
<div id="content" class="bg-light">
    <?php echo view("dashboard/header/header"); ?>
    <section class="content-header px-2 ">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="fw-lighter">Dashboard</h2>
                </div>
                <div class="col-sm-6 text-end"> </div>
            </div>
        </div>
    </section>
    <section style="display:block" id="sec-table">
        <div class="container-fluid">
            <div class=" m-2 rounded">
                <div class="card border-0 m-p">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box p-3">
                                <div class="mb-3 inner position-relative ">
                                    <h2>Welcome, <?php $fn = explode(" ", $session->get('user_details')['name']);?>
                                        <?=$fn[0]?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-6" style="cursor:pointer" id="shabha-member">
                            <div class="small-box bg-info text-white p-3">
                                <div class="inner position-relative ">
                                    <h3><?php echo $membercount ?></h3>
                                    <p>Mahasabha Member</p>
                                    <i class="fas fa-users fa-4x opacity-0 position-absolute end-0 top-0"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6" style="cursor:pointer" id="users">
                            <div class="small-box bg-danger text-white p-3">
                                <div class="inner position-relative ">
                                    <h3><?php echo $userscount ?></h3>
                                    <p>Members</p>
                                    <i class="fas fa-users fa-4x opacity-0 position-absolute end-0 top-0"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6" style="cursor:pointer" id="matrimonial">
                            <div class="small-box bg-secondary text-white p-3">
                                <div class="inner position-relative ">
                                    <h3><?php echo $matrimonialcount ?></h3>
                                    <p>Matrimonial</p>
                                    <i class="fas fa-crown fa-4x opacity-0 position-absolute end-0 top-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
echo view('dashboard/modals/change_pass_modal');
echo view('dashboard/footer/footer.php');
?>