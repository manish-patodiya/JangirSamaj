<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?=base_url('public/css/style.css')?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <style>
    .inputvalues input {
        border: 1px solid;
    }

    label.error {
        color: red;
    }

    a {
        text-decoration: none;
    }
    </style>
    <script>
    const BASE_URL = "<?php $url = config('app');
echo $url->baseURL;?>";
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body class="bg-light">
    <section style="display: block;" id="sec-login">
        <div class="container h-100">
            <div class="position-fixed " style="right:30; bottom:30;">
                <img src="<?=base_url('public/img/appstore.png')?>" height="70" class="pointer" id="playstore">
                <img src="<?=base_url('public/img/playstore.png')?>" height="56" class="pointer" id="ios">
            </div>
            <div class=" row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 my-5">
                    <div class="card bg-light text-dark shadow my-5" style="border-radius: 1rem;">
                        <div class="card-body p-5 pt-4 text-center " id="card-login">
                            <a class="fs-4 text-dark " href="<?=base_url()?>"><img
                                    src="<?=base_url('public/img/Vishwakarma.jpg')?>" class="rounded-circle img-fluid"
                                    width="80" height="80"></a>
                            <h3 class="mb-2 text-uppercase " style="margin-top:2rem;">sign in</h3>
                            <p class="text-black-50 mb-4">Please enter your login and password!</p>
                            <div class="alert alert-danger" id="login-err" style="display: none;"></div>
                            <form method="post" autocomplete="off" id="frm-login">
                                <div class="form-outline mb-2 inputvalues" style="text-align:left">
                                    <label class="form-label">Phone no.</label>
                                    <input type="number" name="phone" class="form-control" />
                                </div>

                                <div class="form-outline form-white mb-2 inputvalues" style="text-align:left">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control " />
                                </div>

                                <p class="small mb-3 pb-lg-2 text-end"><a class="text-dark-50"
                                        href="<?php echo base_url('auth/forgot_password') ?>">Forgot
                                        password?</a>
                                </p>
                                <div id="validation-err" class="alert alert-danger" style="display:none"></div>
                                <button class="btn btn-dark btn-lg px-5 form-control" type="submit"
                                    id="btn-login">Login</button>
                                <div>
                                    <p class="text-center text-dark mt-5 mb-0">Don't have an account? <a
                                            href="<?php echo base_url('auth/signUp') ?>"
                                            class="text-50 fw-bold"><u>Register Here</u></a></p>
                                </div>
                            </form>
                        </div>
                        <?=view('auth/verifyOTP');?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- <script src="public/js/validation_functions.js"></script> -->
    <script src="<?=base_url('public/js/auth.js')?>"></script>

</body>

</html>