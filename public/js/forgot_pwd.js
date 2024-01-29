function base_url(uri) {
    return BASE_URL + uri;
}
console.log(BASE_URL);
$(function () {
    $("#frm-change-pass").validate({
        rules: {
            new_pass: {
                required: true,
                minlength: 6,
                maxlength: 20,
            },
            cpassword: {
                required: true,
                equalTo: "#new_pass",
            },
        },
        messages: {
            new_pass:
            {
                minlength: "Password must be of minimum 6 char.",
                maxlength: "Password must be of less than 20 char."
            }, cpassword: {
                equalTo: "Password does not match",
            },
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            var btn_save;
            let cngpwd = {
                beforeSend: function () {
                    $("#brn-save").attr("disabled", true);
                    btn_save = $("#btn-save").html();
                    $("#btn-save").html(`<span class="fa-lg">
            <i class="fas fa-circle-notch fa-spin"></i>
        </span>`);
                },
                url: base_url("/auth/changePass"),
                data: $("#frm-change-pass").serialize(),
                method: "post",
                dataType: "json",
                success: function (res) {
                    if (res.status == 1) {
                        window.location = base_url("/dashboard");
                    }
                },
                complete: function () {
                    $("#btn-save").attr("disabled", false).html(btn_save);
                },
                error: function (err) {
                    console.log(err);
                },
            };
            $.ajax(cngpwd);
        }
    });
    $("#forgot_password").validate({
        rules: {
            phone: {
                required: true,
            }
        },
        submitHandler: function (form, event) {
            event.preventDefault()
            let fg_password = {
                url: base_url("auth/fg_password"),
                method: "post",
                dataType: "json",
                data: $(form).serialize(),
                success: function (res) {
                    if (res.status == 1) {
                        $('#user-id').val(res.user_id);
                        $('#btn_phone').hide();
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
                        $("#otp_form").show();
                    }
                    else {
                        console.log("OOOO me toh dar gi");
                    }
                }
            }
            $.ajax(fg_password);

        }
    })

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
                url: base_url('/auth/verifyForgotPassOTP'),
                data: $(form).serialize(),
                dataType: "json",
                method: "post",
                beforeSend: function () {
                    $("#btn-verify").html(`<i class="fas fa-circle-notch fa-spin"></i>`).attr('disabled', true);
                },
                success: function (res) {
                    $('#fgt-pass-uid').val($('#user-id').val());
                    $("#otp_form").hide();
                    $('#sec-pass').show();
                },
                complete: function () {
                    $("#btn-verify").attr("disabled", false).html(`Verify`);
                },
                error: function (err) { }
            }
            $.ajax(verify);
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
})