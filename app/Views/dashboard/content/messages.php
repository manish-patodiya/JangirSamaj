<?php
echo view('dashboard/header/header_top');
echo view('dashboard/sidebar/' . $sidebar);
?>
<div id="content" class="bg-light">
    <?php echo view("dashboard/header/header"); ?>
    <section class="content-header px-2 ">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-3">
                    <h2 class="fw-lighter">Messages</h2>
                </div>
            </div>
        </div>
    </section>
    <section style="display:block" id="sec-table">
        <div class="container-fluid">
            <div class="row m-2 rounded">
                <div class="card border-0  m-p">


                    <table class="table table-striped" id="table-mess">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Messages</th>
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
<script src="<?php echo base_url('public/js/messages.js') ?>"></script>
<?php echo view('dashboard/footer/footer'); ?>