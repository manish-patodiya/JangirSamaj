$(function() {

    $("#change-photo").click(function() {
        $("#choose-photo").click();
    })

    $("#choose-photo").change(function() {
        var file = this.files[0];
        if (file) {
            $("#profile-photo").attr('src', URL.createObjectURL(file));
        }
        $("#profile-photo").css("height", document.getElementById('profile-photo').clientWidth);
    })

    $("#profile").hover(function() {
        $('#change-photo').fadeIn(80).css('display', 'flex');
    }, function() {
        $('#change-photo').fadeOut(80);
    });

    $('#marital-status').change(function() {
        var status = $(this).val();
        if (status == 'Single') {
            $("#availableForMarriage").attr('disabled', false);
        } else {
            $("#availableForMarriage").attr('disabled', true);
            $("#availableForMarriage").prop('checked', false);
            $('#mr-info').slideUp();
        }
    })

    $('#availableForMarriage').change(function() {
        if ($('#availableForMarriage').prop('checked') == true) {
            $('#mr-info').slideDown();
        } else {
            $('#mr-info').slideUp();
        }
    })

    $("#occupation").change(function() {
        var v = $(this).val();
        if (v == '0') {
            $("#new-occ").slideDown(300);
        } else {
            $("#new-occ").slideUp(300);
        }
    })

    $('#select-state').change(function(e) {
        var stateID = $('#select-state').val();
        var dist = {
            url: BASE_URL + "/states/getDistricts/" + stateID,
            dataType: "json",
            success: function(res) {
                $('#select-district').html(`<option val="" selected>Select district</option>`);
                res.districts.forEach(ele => {
                    $('#select-district').append(
                        `<option value="${ele.id}" >${ele.district}</option>`
                    );
                });
            },
            error: function(err) {}
        }
        $.ajax(dist);
    });

    $('#education').change(function(e) {
        var edu = $(this).val();
        var qualification = {
            url: BASE_URL + "/Profile/getQualifications/",
            dataType: "json",
            data: {
                title: edu,
            },
            success: function(res) {
                $('#select-qualification').html(`<option val="" selected>Select One</option>`);
                res.qualification.forEach(ele => {
                    $('#select-qualification').append(
                        `<option value="${ele.id}" >${ele.qualification}</option>`
                    );
                });
            },
            error: function(err) {}
        }
        $.ajax(qualification);
    });

    $('#select-district').change(function(e) {
        $('#table-users').DataTable().ajax.reload();
    });

    $("#frm-profile").validate({
        rules: {
            fname: {
                minlength: 4,
            },
            lname: {
                minlength: 2,
            },
            father: {
                minlength: 2,
            },
            mother: {
                minlength: 2,
            },
            height: {
                maxlength: 2,
            }
        },
        messages: {
            fname: {
                required: "Type your first name",
                minlength: "Not a valid name",
            },
            lname: {
                required: "Type your last name",
                minlength: "Not a valid name",
            },
            father: {
                required: "Type your father's name",
                minlength: "Not a valid name",
            },
            mother: {
                minlength: 2,
                minlength: "Not a valid name",
            },
            gender: "Select your gender",
            state: "Select your state",
            district: "Select your district",
            dob: "DOB is required",
            gotra: {
                required: "Gotra is necessary",
            },
            naniGotra: {
                required: "Nani's gotra is necessary"
            },
            motherGotra: {
                required: "Mother's gotra is necessary"
            },
            dadiGotra: {
                required: "Dadi's gotra is necessary"
            },
            mstatus: "Select your status",
            education: "Select your education",
            occupation: "Select your occupation",
        },
        errorPlacement: function(error, element) {
            if (element.attr('name') == "gotra" || element.attr('name') == "mothergotra" || element.attr('name') == "dadigotra" || element.attr('name') == "nanigotra") {
                error.appendTo(element.parents('p'));
            } else if (element.is(":radio")) {
                error.appendTo(element.parents('p'));
            } else { // This is the default behavior 
                error.insertAfter(element);
            }
        },
        submitHandler: function(form, event) {
            event.preventDefault();
            let btn_update;
            var formData = new FormData(form);
            var saveinfo = {
                url: BASE_URL + '/profile/updateProfile',
                data: formData,
                dataType: "json",
                method: "post",
                beforeSend: function() {
                    $("#btn-update").attr("disabled", true);
                    btn_update = $("#btn-update").html();
                    $("#btn-update").html(`<i class="fas fa-circle-notch fa-spin"></i>`);
                },
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.status == 1) {
                        $('#incmplt-prfl').hide();
                        $('#scs-cmplt-prfl').append(`<i class="fas fa-spinner fa-pulse"></i>`).show();
                        let updt = setInterval(() => {
                            $('#scs-cmplt-prfl').hide();
                            if ($('#new-window').html() == 1) {
                                window.open('', '_parent', '');
                                window.close();
                            } else {
                                window.history.back();
                            }
                            $("#btn-update").attr("disabled", false).html(btn_update);
                            clearInterval(updt);
                        }, 3000);
                    }

                },
                error: function(err) {},
            }
            $.ajax(saveinfo);
        }
    })

    $("#btn-change-pass").click(function() {
        $("#mdl-change-pass").modal("show");
    });

    $("#frm-change-pass").validate({
        rules: {
            password: {
                required: true,
            },
            new_password: {
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
            password: {
                required: "Current password must be required"
            },
            cpassword: {
                equalTo: "Password does not match",
            },
        },
        submitHandler: function(form) {
            let changepass = {
                url: BASE_URL + "/profile/changepass",
                data: $("#frm-change-pass").serialize(),
                method: "post",
                dataType: "json",
                success: function(res) {
                    if (res.status == 1) {
                        window.location.reload();
                    } else {
                        $("#pass-err").html(res.msg);
                        $("#pass-err").show();
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            }
            $.ajax(changepass);
        }
    });

})