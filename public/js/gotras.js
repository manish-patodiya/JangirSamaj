$(function() {
    $("#table-gotras").DataTable({
        ajax: {
            url: BASE_URL + '/gotras/gotras',
            dataSrc: 'gotras',
        }
    })
    $("#btn-add-gotra").click(function() {
        $("#mdl-add-gotra").modal("show")
    })
    $("#frm-add-gotra").validate({
        rules: {
            name: {
                required: true
            }
        },
        submitHandler: function(form, event) {
            event.preventDefault()
            let gotra = {
                url: BASE_URL + "/gotras/insertGotra",
                method: "post",
                data: $(form).serialize(),
                dataType: "json",
                success: function(res) {
                    $("#mdl-add-gotra").modal("hide")
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
            $.ajax(gotra)
        }
    })
    $(document).on("click", ".btn-edit", function() {
        let id = $(this).attr('uid')
        $("#mdl-edit-gotra").modal("show")
        $("#gotra-id").val(id)
        let gotra = {
            url: BASE_URL + '/gotras/getGotra',
            method: "post",
            data: {
                'id': id
            },
            dataType: "json",
            success: function(res) {
                if (res.status == 1) {
                    $("#gotra-name").val(res.name)
                }
            }
        }
        $.ajax(gotra)
    })
    $("#frm-edit-gotra").validate({
        rules: {
            name: {
                required: true
            }
        },
        submitHandler: function(form, event) {
            event.preventDefault()
            let gotra = {
                url: BASE_URL + "/gotras/editGotra",
                method: "post",
                data: $(form).serialize(),
                dataType: "json",
                success: function(res) {
                    $("#mdl-edit-gotra").modal("hide")
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
            $.ajax(gotra)
        }
    })
    $(document).on("click", ".btn-dlt", function() {
        let id = $(this).attr('uid')
        $("#mdl-delete").modal("show")
        $("#delete-id").val(id)
    })
    $("#frm-delete").submit(function() {
        let dlt = {
            url: BASE_URL + "/gotras/deleteGotra",
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