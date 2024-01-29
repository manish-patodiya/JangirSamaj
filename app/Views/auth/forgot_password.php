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
    <section style="display:block;" id="sec-login">
        <div class=" row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 my-5">
                <div class="card bg-light text-dark shadow my-5" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center" id="card-otp-verification">
                        <a class="fs-4 text-dark" href="<?=base_url()?>"><img
                                src="<?=base_url('public/img/Vishwakarma.jpg')?>" width="40" height="40"> Jangid
                            Samaj</a>
                        <div class="mt-4" style="display:block;" id="btn_phone">
                            <span class="mobile-text h5 ">Enter your mobile phone <br>
                                <form method="post" id="forgot_password">
                                    <div class="form-outline mb-2 mt-4 inputvalues" style="text-align:left">
                                        <label class="form-label">Phone no.</label>
                                        <input type="number" name="phone" id="phone" class="form-control" />
                                    </div>
                                    <div class="text-center mt-2">
                                        <button type="submit" class="btn  btn-success">
                                            send
                                        </button>
                                    </div>
                                </form>
                        </div>
                        <div style=" display:none;" id="otp_form">
                            <h3 class="mt-2 mb-4 text-uppercase">OTP</h3>
                            <span class="mobile-text">Enter the code we just send on
                                your mobile phone <br>
                                <b id="otp-phone" class="text-danger"></b></span>

                            <form method="post" id="frm-otp-verification" style="">

                                <div class="mx-5 mt-5">
                                    <input type="number" name="otp" class="form-control" id="otp" autofocus="">
                                    <span id="otp-err" class="text-danger" style="display:none"></span>
                                    <input type="hidden" name="id" id="user-id">
                                </div>
                                <div class="text-center mt-2">
                                    <button type="submit" class="btn  btn-success" id="btn-verify">
                                        Verify
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <span class="d-block mobile-text">Don't receive the code?</span>
                                    <a href="javascript:void(0)" id="resend-otp"
                                        class="font-weight-bold text-danger cursor" style="display:none">Resend</a>
                                    <span class="text-secondary" id="regenerate-timer">resend in 59 seconds</span>
                                </div>
                            </form>
                        </div>
                        <div style="display:none;" id="sec-pass">
                            <h3 class="mt-4 mb-4 text-uppercase">New password</h3>
                            <form method="post" id="frm-change-pass">
                                <!-- <div class="alert alert-danger" id="pass-err"></div> -->
                                <div class="modal-body mx-5">
                                    <div class="form-outline mb-2 inputvalues" style="text-align:left">
                                        <lable class="form-label">New passwpword.</lable>
                                        <input name="new_pass" class="form-control" type="password"
                                            placeholder="New password" id="new_pass">
                                    </div>
                                    <div class="form-outline mb-2 inputvalues" style="text-align:left">
                                        <lable class="form-label">Confime passwpword.</lable>
                                        <input name="cpassword" class="form-control" type="password"
                                            placeholder="Confirm Password">
                                        <input type="hidden" name="user_id" id="fgt-pass-uid" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-dark" id="btn-save"> <a
                                            href="<?php echo base_url('auth/login') ?>">Save</a></button>
                                </div>
                            </form>
                        </div>
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
    <script src="<?=base_url('public/js/forgot_pwd.js')?>"></script>

</body>

</html>