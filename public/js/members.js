$(document).ready(function() {
    $('#table-mess').DataTable({
        serverSide: true,
        ajax: {
            url: BASE_URL + "/messages/getMessages",
        },


    })

    $("#table-users").DataTable({
        serverSide: true,
        ajax: {
            url: BASE_URL + "/members/getMembers",
            data: {
                gender: $("input[name=gender]:checked").val(),
                district_id: function() {
                    return $("#select-district").val();
                },
                sabha_member: function() {
                    return $("input[name=sabha_member]").prop("checked") ? 1 : 0;
                }
            },
        },
        infoCallback: function(settings, start, end, max, total, pre) {
            if (start > total && total != 0) {
                $("#table-users").DataTable().page("previous").draw("page");
            }
        },
        pageLength: 10,
        columns: [
            { orderable: false },
            null,
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false },
        ],
        order: [
            [1, 'asc']
        ],
        searchDelay: 1000,
    });

    $("#select-state").change(function(e) {
        $stateID = $("#select-state").val();
        if ($stateID) {
            var dist = {
                url: BASE_URL + "/states/getDistricts/" + $stateID,
                dataType: "json",
                success: function(res) {
                    $("#select-district").html(
                        `<option val="" selected>Select district</option>`
                    );
                    res.districts.forEach((ele) => {
                        $("#select-district").append(
                            `<option value="${ele.id}" >${ele.district}</option>`
                        );
                    });
                },
                error: function(err) {},
            };
            $.ajax(dist);
        } else {
            $("#select-district").html(
                `<option value="" >Select a State first</option>`
            );
        }
    });

    $(document).on("click", "#sabha-mem", function() {
        $("input[name=sabha_member]").prop("checked", !$("input[name=sabha_member]").prop("checked"));
        $(this).toggleClass("btn-light").toggleClass("btn-dark");
        $("#table-users").DataTable().ajax.reload();
    })

    $(document).on("change", "#select-district", function(e) {
        $("#table-users").DataTable().ajax.reload();
    });

    $(document).on("click", ".btn-dlt", function() {
        let id = $(this).attr("uid");
        $("#mdl-delete").modal("show");
        $("#delete-id").val(id);
    });

    let btnPromote;
    $(document).on("click", ".btn-promote", function() {
        let id = $(this).attr("uid");
        btnPromote = $(this);
        $("#mdl-pmt-member").modal("show");
        $("#promote-id").val(id);
    });


    $(document).on("click", ".btn-demote", function() {
        let id = $(this).attr("uid");
        btnPromote = $(this);
        $("#mdl-dmt-member").modal("show");
        $("#demote-id").val(id);
    });

    $("#btn-add-mem").click(function() {
        $("#mdl-add-user").modal("show");
        $('#user-role').val($(this).attr('role'));
    });

    $("#btn-add-csv").click(function() {
        $("#mdl-add-csv").modal("show");
    });

    $('#mdl-add-csv').on('hidden.bs.modal', function(e) {
        var target = $(e.target);
        target.removeData('bs.modal')
            .find("input").val('');
    });

    $("#frm-add-csv").validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            let btn_upload;
            var formData = new FormData(form);
            var upload = {
                url: BASE_URL + "/members/uploadCSV",
                data: formData,
                dataType: "json",
                method: "post",
                beforeSend: function() {
                    btn_upload = $('#btn-upload-csv').html();
                    console.log(btn_upload);
                    $('#btn-upload-csv').html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
                },
                processData: false,
                contentType: false,
                success: function(res) {
                    if ((res.status = 1)) {
                        $("#mdl-add-csv").modal("hide");
                        $(".modal-backdrop").remove();
                        $("#success-msg").html(res.msg);
                        $("#success-msg").show();
                        $("#table-users").DataTable().ajax.reload(null, false);
                        setTimeout(function() {
                            $("#success-msg").hide();
                        }, 3000);
                    }
                },
                complete: function() {
                    $('#btn-upload-csv').html(btn_upload).prop('disabled', false);
                },
                error: function(err) {},
            };
            $.ajax(upload);
        },
    });

    let btn_view;
    $(document).on("click", ".btn-view", function() {
        $("#mdl-view").modal("show");
        let id = $(this).attr("uid");
        let btn = $(this);
        let getProfile = {
            url: BASE_URL + "/members/showMemberProfile",
            data: {
                id: id,
            },
            method: "post",
            dataType: "json",
            beforeSend: function() {
                btn.attr("disabled", true);
                btn_view = btn.html();
                btn.html(`<i class="fas fa-circle-notch fa-spin"></i>`);
            },
            success: function(res) {
                if (res.status == 1) {
                    let info = res.info;
                    let path = info.profile_photo ?
                        BASE_URL + "/public/uploads/members_profile/" + info.profile_photo :
                        BASE_URL + "/public/img/avatar.png";
                    $("#profile").prop("src", path);
                    $("#name").html(": " + info.first_name + " " + info.middle_name + " " + info.last_name);
                    $("#father").html(": " + info.father_name);
                    $("#mother").html(": " + info.mother_name);
                    $("#gotra").html(": " + info.gotra);
                    $("#mstatus").html(": " + info.marital_status);
                    info.availableformarriage ? $("#available").html(": " + "Yes") : $("#available").html(": " + "No");
                    $("#dob").html(": " + info.dob);
                    info.dob ? $("#age").html(": " + (new Date().getFullYear() - new Date(info.dob).getFullYear())) : false;
                    $("#gender").html(": " + info.gender);
                    $("#phone").html(": " + info.phone);
                    $("#education").html(": " + info.education);
                    info.height != 0 ? $("#height").html(": " + info.height) : $("#height").html(": ");
                    $("#skin").html(": " + info.skin);
                    $("#mgotra").html(": " + info.mgotra);
                    $("#dgotra").html(": " + info.dgotra);
                    $("#ngotra").html(": " + info.ngotra);
                    $("#address").html(": " + info.address + ", " + (info.tahsil ? info.tahsil : "") + ", " + (info.district ? info.district : "") + ", " + (info.state ? info.state : ""));
                    $("#pob").html(": " + info.pob);
                }
            },
            error: function() {},
            complete: function() {
                btn.attr("disabled", false).html(btn_view);
            },
        };
        $.ajax(getProfile);
    });

    $("#frm-delete").submit(function() {
        let dlt = {
            url: BASE_URL + "/members/deleteuser",
            method: "post",
            dataType: "json",
            data: $("#frm-delete").serialize(),
            success: function(res) {
                $("#mdl-delete").modal("hide");
                $(".modal-backdrop").remove();
                if (res.status == 1) {
                    $("#success-msg").html(res.msg);
                    $("#success-msg").show();
                    $("#table-users").DataTable().ajax.reload(null, false);
                    setTimeout(function() {
                        $("#success-msg").hide();
                    }, 3000);
                }
            },
            error: function(err) {},
        };
        $.ajax(dlt);
    });

    $("#frm-pmt-member").submit(function() {
        let pmtmem = {
            url: BASE_URL + "/members/promoteMember",
            method: "post",
            dataType: "json",
            data: $(this).serialize(),
            success: function(res) {
                $("#mdl-pmt-member").modal("hide");
                $(".modal-backdrop").remove();
                if (res.status == 1) {
                    btnPromote.toggleClass("btn-promote").toggleClass("btn-demote").toggleClass("text-danger").toggleClass("text-success").children("i").toggleClass("fa-arrow-circle-down").toggleClass("fa-arrow-circle-up")
                    $("#success-msg").html(res.msg);
                    $("#success-msg").show();
                    setTimeout(function() {
                        $("#success-msg").hide();
                    }, 3000);
                }
            },
            error: function(err) {},
        };
        $.ajax(pmtmem);
    });

    $("#frm-dmt-member").submit(function() {
        let pmtmem = {
            url: BASE_URL + "/members/demoteMember",
            method: "post",
            dataType: "json",
            data: $(this).serialize(),
            success: function(res) {
                $("#mdl-dmt-member").modal("hide");
                $(".modal-backdrop").remove();
                if (res.status == 1) {
                    $("#success-msg").html(res.msg);
                    $("#success-msg").show();
                    btnPromote.toggleClass("btn-promote").toggleClass("btn-demote").toggleClass("text-danger").toggleClass("text-success").children("i").toggleClass("fa-arrow-circle-down").toggleClass("fa-arrow-circle-up");
                    setTimeout(function() {
                        $("#success-msg").hide();
                    }, 3000);
                }
            },
            error: function(err) {},
        };
        $.ajax(pmtmem);
    });

    $(".filter-male").click(function(e) {
        $(this).addClass("bg-dark text-white");
        $(".filter-female").removeClass("bg-dark text-white");
        $(".radio-male").prop("checked", true);
        $("#table-users").DataTable().ajax.reload();
    });
    $(".filter-female").click(function(e) {
        $(this).addClass("bg-dark text-white");
        $(".filter-male").removeClass("bg-dark text-white");
        $(".radio-female").prop("checked", true);
        $("#table-users").DataTable().ajax.reload();
    });

});