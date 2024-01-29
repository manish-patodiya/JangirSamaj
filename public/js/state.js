$(function() {
    $("#table-state").DataTable({
        ajax: {
            url: BASE_URL + '/states/states',
            dataSrc: 'state',
        }
    })
    $("#btn-add-state").click(function() {
        $("#mdl-add-state").modal("show")
    })
    $("#frm-add-state").validate({
        rules: {
            name: {
                required: true
            }
        },
        submitHandler: function(form, event) {
            event.preventDefault()
            let state = {
                url: BASE_URL + "/states/insertState",
                method: "post",
                data: $(form).serialize(),
                dataType: "json",
                success: function(res) {
                    $("#mdl-add-state").modal("hide")
                    $(".modal-backdrop").remove()
                    if (res.status == 1) {
                        $("#success-msg").html(res.msg)
                        $("#success-msg").show()
                        showTable()
                        setTimeout(function() {
                            $("#success-msg").hide()
                        }, 3000)
                    }
                }
            }
            $.ajax(state)
        }
    })
    $(document).on("click", ".btn-edit", function() {
        let id = $(this).attr('uid')
        $("#mdl-edit-state").modal("show")
        $("#state-id").val(id)
        let state = {
            url: BASE_URL + '/states/getState',
            method: "post",
            data: {
                'id': id
            },
            dataType: "json",
            success: function(res) {
                if (res.status == 1) {
                    $("#state-name").val(res.name)
                }
            }
        }
        $.ajax(state)
    })
    $("#frm-edit-state").validate({
        rules: {
            name: {
                required: true
            }
        },
        submitHandler: function(form, event) {
            event.preventDefault()
            let state = {
                url: BASE_URL + "/states/editState",
                method: "post",
                data: $(form).serialize(),
                dataType: "json",
                success: function(res) {
                    $("#mdl-edit-state").modal("hide")
                    $(".modal-backdrop").remove()
                    if (res.status == 1) {
                        $("#success-msg").html(res.msg)
                        $("#success-msg").show()
                        setTimeout(function() {
                            $("#success-msg").hide()
                            window.location.reload()
                        }, 3000)
                    }
                }
            }
            $.ajax(state)
        }
    })
    $(document).on("click", ".btn-dlt", function() {
        let id = $(this).attr('uid')
        $("#mdl-delete").modal("show")
        $("#delete-id").val(id)
    })
    $("#frm-delete").submit(function() {
        let dlt = {
            url: BASE_URL + "/states/deleteState",
            method: "post",
            data: $("#frm-delete").serialize(),
            dataType: "json",
            success: function(res) {
                $("#mdl-delete").modal("hide")
                $(".modal-backdrop").remove()
                if (res.status == 1) {
                    $("#success-msg").html(res.msg)
                    $("#success-msg").show()
                    setTimeout(function() {
                        $("#success-msg").hide()
                        window.location.reload()
                    }, 3000)
                }
            }
        }
        $.ajax(dlt)
    })
})