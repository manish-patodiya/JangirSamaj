<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
    const BASE_URL = "<?php $url = config('app');
echo $url->baseURL;?>";
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body class="bg-light">
    <section style="display: block;" id="sec-login">
        <div class="container h-100">
            <div class=" row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 my-5">
                    <div class="card bg-light text-dark shadow" style="border-radius: 1rem;">
                        <div class="card-body py-5 " style="padding-left:6rem; padding-right:6rem">
                            <div class=" pb-3 text-center">
                                <h2 class="fw-bold">Login as</h2>
                            </div>
                            <?php foreach ($session['user_roles'] as $role) {?>
                            <div class="mb-2 d-grid gap-2">
                                <a class="btn btn-lg btn-primary text-center"
                                    href="<?=base_url('auth/loginAs/' . $role->role_id)?>">
                                    <?=ucfirst($role->role)?>
                                </a>
                            </div>
                            <?php }?>
                        </div>
                        <div class="text-end mb-3 me-3">
                            <a href="<?=base_url('auth/logout')?>" class="btn btn-sm" style="font-size:12px">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?=view('auth/verifyOTP');?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- <script src="public/js/validation_functions.js"></script> -->
    <script src="<?=base_url('public/js/auth.js')?>"></script>

</body>

</html>