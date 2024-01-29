$(document).ready(function() {
    $('#table-users').DataTable({
        serverSide: true,
        ajax: {
            url: BASE_URL + "/moderators/getModerators",
            data: {
                'value': function() {
                    return $('#select-district').val();
                },
            }
        },
        "infoCallback": function(settings, start, end, max, total, pre) {
            if (start > total && total != 0) {
                $('#table-users').DataTable().page('previous').draw('page');
            }
        },
        pageLength: 10,
        columns: [
            { orderable: false },
            null,
            { orderable: false },
            { orderable: false },
            { orderable: false },
            { orderable: false }
        ],
        order: [
            [1, 'asc']
        ],
        searchDelay: 1000,
    });

    $('#select-state').change(function(e) {
        $stateID = $('#select-state').val();
        if ($stateID) {
            var dist = {
                url: BASE_URL + "/states/getDistricts/" + $stateID,
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
        } else {
            $('#select-district').html(`<option value="" >Select a State first</option>`);
        }
    });

    $(document).on('change', '#select-district', function(e) {
        $('#table-users').DataTable().ajax.reload();
    });

    $(document).on('click', '.btn-dlt', function() {
        var id = $(this).attr('uid');
        $('#mdl-delete').modal('show');
        $("#delete-id").val(id);
    })

    $('#btn-add-csv').click(function() {
        $('#mdl-add-csv').modal('show');
    })

    $("#btn-add-mod").click(function() {
        $("#mdl-add-user").modal("show");
        $('#user-role').val($(this).attr('role'));
    });

    let btn_view;
    $(document).on('click', '.btn-view', function() {
        $('#mdl-view').modal('show');
        let id = $(this).attr('uid');
        let btn = $(this);
        let getProfile = {
            url: BASE_URL + "/moderators/showModeratorProfile",
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
                    info.availableformarriage == "1" ? $("#available").html(": " + "Yes") : $("#available").html(": " + "No");
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
            error: function() {

            },
            complete: function() {
                btn.attr("disabled", false).html(btn_view);
            }
        }
        $.ajax(getProfile);
    })

    $("#frm-delete").submit(function() {
        let dlt = {
            url: BASE_URL + "/moderators/deleteModerator",
            method: "post",
            dataType: "json",
            data: $("#frm-delete").serialize(),
            success: function(res) {
                $("#mdl-delete").modal("hide");
                $(".modal-backdrop").remove();
                if (res.status == 1) {
                    $("#success-msg").html(res.msg);
                    $("#success-msg").show();
                    $('#table-users').DataTable().ajax.reload(null, false);
                    setTimeout(function() {
                        $("#success-msg").hide();
                    }, 3000);
                }
            },
            error: function(err) {},
        };
        $.ajax(dlt);
    });
});