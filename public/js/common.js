$(function() {
    $("#users").click(function() {
        window.location = BASE_URL + "/members";
    });
    $("#shabha-member").click(function() {
        window.location = BASE_URL + "/members";
    });

    $("#moderators").click(function() {
        window.location = BASE_URL + "/moderators";
    });

    $("#matrimonial").click(function() {
        window.location = BASE_URL + "/matrimonial";
    });

    $("#slct-switch-role").change(function(e) {
        window.location = BASE_URL + "/auth/loginAs/" + $(this).val();
    });


    $(document).on("click", ".message", function() {
        var mid = $(this).attr("mid");
        $.ajax({
            url: BASE_URL + "/messages/msgSeen",
            dataType: "json",
            data: {
                'mid': mid,
            },
            method: "post",
            success: function(res) {
                if (res.status == 1) {
                    window.location = BASE_URL + "/messages";
                }
            },
            error: function(err) {
                console.log(err);
            }

        })
    })
});