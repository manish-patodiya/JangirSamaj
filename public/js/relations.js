$(function() {
    $("#table-relations").DataTable({
        ajax: {
            url: BASE_URL + '/relations/relations',
            dataSrc: 'relations',
        }
    })
    $("#btn-add-relations").click(function() {
        $("#mdl-add-relations").modal("show")
    })
    $("#frm-add-relations").validate({
        rules: {
            name: {
                required: true
            }
        },
        submitHandler: function(form, event) {
            event.preventDefault()
            let relations = {
                url: BASE_URL + "/relations/insertRelations",
                method: "post",
                data: $(form).serialize(),
                dataType: "json",
                success: function(res) {
                    $("#mdl-add-relations").modal("hide")
                    $(".modal-backdrop").remove()
                    if (res.status == 1) {
                        $("#success-msg").html(res.msg)
                        $("#success-msg").show()
                        setTimeout(function() {
                            $("#success-msg").hide()
                        }, 3000)
                    }
                }
            }
            $.ajax(relations)
        }
    })
    $(document).on("click", ".btn-edit", function() {
        let id = $(this).attr('uid')
        $("#mdl-edit-relations").modal("show")
        $("#relations-id").val(id)
        let relations = {
            url: BASE_URL + '/relations/getRelations',
            method: "post",
            data: {
                'id': id
            },
            dataType: "json",
            success: function(res) {
                if (res.status == 1) {
                    $("#relations-name").val(res.name)
                }
            }
        }
        $.ajax(relations)
    })
    $("#frm-edit-relations").validate({
        rules: {
            name: {
                required: true
            }
        },
        submitHandler: function(form, event) {
            event.preventDefault()
            let relations = {
                url: BASE_URL + "/relations/editRelations",
                method: "post",
                data: $(form).serialize(),
                dataType: "json",
                success: function(res) {
                    $("#mdl-edit-relations").modal("hide")
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
            $.ajax(relations)
        }
    })
    $(document).on("click", ".btn-dlt", function() {
        let id = $(this).attr('uid')
        $("#mdl-delete").modal("show")
        $("#delete-id").val(id)
    })
    $("#frm-delete").submit(function() {
        let dlt = {
            url: BASE_URL + "/relations/deleteRelations",
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
                        window.location.reload()
                        $("#success-msg").hide()
                    }, 3000)
                }
            }
        }
        $.ajax(dlt)
    })
})