function base_url(uri) {
    return BASE_URL + uri;
}
$(function () {
    var btn_register;
    $("#frm-register").validate({
        rules: {
            fname: {
                required: true,
                minlength: 2,
            },
            lname: {
                required: true,
                minlength: 2,
            },
            phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
                mobileExist: true,
            },
            gotra: {
                required: true,
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 20,
            },
            cpassword: {
                required: true,
                equalTo: "#password",
            },
        },
        messages: {
            cpassword: {
                equalTo: "Password does not match",
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr('name') == "gotra") {
                error.appendTo(element.parents('p'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            let register = {
                beforeSend: function () {
                    $("#btn-register").attr("disabled", true);
                    btn_register = $("#btn-register").html();
                    $("#btn-register").html(`<span class="fa-lg">
            <i class="fas fa-circle-notch fa-spin"></i>
        </span>`);
                },
                url: base_url("/auth/registerUser"),
                data: $("#frm-register").serialize(),
                method: "post",
                dataType: "json",
                success: function (res) {
                    if (res.status == 1) {
                        $('#card-register').hide();
                        $('#user-id').val(res.user_id);
                        $('#otp-phone').html("+91 " + res.phone);
                        $('#card-otp-verification').show();
                        resendOTPTCount();
                    } else {
                        if (res.errors) {
                            let keys = Object.keys(res.errors);
                            $("#validation-err").html(``);
                            keys.map(function (key) {
                                $("#validation-err").append(`
                                <li>${res.errors[key]}</li>
                                `);
                            });;
                            $("#validation-err").show();
                        }
                    }
                },
                complete: function () {
                    $("#btn-register").attr("disabled", false).html(btn_register);
                },
                error: function (err) {
                    console.log(err);
                },
            };
            $.ajax(register);
        },
    });


    $("#resend-otp").click(function () {
        resendOTP();
    })

    resendOTP = () => {
        let reOTP = {
            url: base_url("/auth/regenerateOTP"),
            data: {
                id: $('#user-id').val(),
            },
            beforeSend: function () {
                $("#resend-otp").hide();
                $('#regenerate-timer').html('resend in 59 seconds').show();
            },
            dataType: "json",
            method: "post",
            success: function (res) {
                if (res.status == 1) { }
            },
            complete: function () {
                var time = 58;
                var interval = setInterval(function () {
                    $('#regenerate-timer').html('resend in ' + time + " seconds")
                    time--;
                    if (time == 0) {
                        clearInterval(interval);
                        $("#resend-otp").show();
                        $('#regenerate-timer').hide()
                    }
                }, 1000)
            },
            error: function () {

            }
        }
        $.ajax(reOTP);
    }

    $("#frm-otp-verification").validate({
        rules: {
            otp: {
                required: true,
                minlength: 6,
                maxlength: 6
            },
        },
        messages: {
            otp: {
                minlength: "OTP must be of 6 digits",
                maxlength: "OTP must be of 6 digits",
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            let verify = {
                url: base_url('/auth/verifyOTP'),
                data: $(form).serialize(),
                dataType: "json",
                method: "post",
                beforeSend: function () {
                    $("#btn-verify").html(`<i class="fas fa-circle-notch fa-spin"></i>`).attr('disabled', true);
                },
                success: function (res) {
                    if (res.status == 1) {
                        window.location = base_url("/dashboard");
                    } else {
                        $("#otp-err").html(res.msg).show();
                    }
                },
                complete: function () {
                    $("#btn-verify").attr("disabled", false).html(`Verify`);
                },
                error: function (err) { }
            }
            $.ajax(verify);
        },
    });


    $("#frm-otp-verification input").keyup(function (e) {
        $("#otp-err").hide();
    });

    $("#frm-login input").keyup(function () {
        $("#login-err").hide();
    });

    $("#frm-register input").keyup(function () {
        $("#gotra-err").hide();
    });

    $(document).on('click', '#verify-phn', function () {
        resendOTP();
        $('#card-login').hide();
        $('#card-otp-verification').show();
        resendOTPTCount();
    })

    let resendOTPTCount = () => {
        var time = 58;
        var interval = setInterval(function () {
            $('#regenerate-timer').html('resend in ' + time + " seconds")
            time--;
            if (time == 0) {
                clearInterval(interval);
                $("#resend-otp").show();
                $('#regenerate-timer').hide()
            }
        }, 1000)
    }

    var btn_login;
    $("#frm-login").validate({
        rules: {
            phone: {
                required: true,
            },
            password: {
                required: true,
            },
        },
        submitHandler: function (form, event) {
            let login = {
                url: base_url("/auth/login"),
                beforeSend: function () {
                    $("#btn-login").attr("disabled", true);
                    btn_login = $("#btn-login").html();
                    $("#btn-login").html(`<span class="fa-lg">
              <i class="fas fa-circle-notch fa-spin"></i>
          </span>`);
                },
                data: $("#frm-login").serialize(),
                method: "post",
                dataType: "json",
                success: function (res) {
                    if (res.status == 1) {
                        $("#login-err").hide();
                        if (res.roles) {
                            window.location = base_url("auth/loginAs");
                        } else {
                            window.location = base_url("dashboard");
                        }
                    } else {
                        if (res.errors) {
                            let keys = Object.keys(res.errors);
                            $("#validation-err").html(``);
                            keys.map(function (key) {
                                $("#validation-err").append(`
                                <li>${res.errors[key]}</li>
                                `);
                            });
                            $("#validation-err").show();
                        } else {
                            $("#login-err").html(res.message);
                            $("#login-err").show();
                            $('#user-id').val(res.user_id);
                        }
                    }
                    if (res.phone) {
                        $('#otp-phone').html("+91 " + res.phone);
                    }
                },
                complete: function () {
                    $("#btn-login").attr("disabled", false).html(btn_login);
                },
                error: function (err) {
                    console.log(err);
                },
            };
            $.ajax(login);
        },
    });

    $('#ios').click(function () {
        alert("The app will coming soon");
    })

    $('#playstore').click(function () {
        alert("The app will coming soon");
    })
});