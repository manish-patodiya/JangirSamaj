$(function() {
    var total_members = 0;
    var loaded_total_member = 0;
    var is_favorite = (uid) => {
        return window.sessionStorage
            .getItem("favoriteUIDs")
            .split(",")
            .filter((f) => {
                return f == uid;
            }).length;
    };
    var matrimonial = (p) => {
        let is_fav = $("#inpt-is-fav").prop("checked") ? 1 : 0;
        cards = {
            url: BASE_URL + "/matrimonial/getMatrimonialCards",
            method: "post",
            data: {
                page: p,
                gender: $("input[name=gender]:checked").val(),
                education: $("#select-edu").val(),
                marital_status: $("#marital-status").val(),
                height: $("#height").val(),
                age: $("#age").val(),
                sgotra: $("#sg").val(),
                dgotra: $("#dg").val(),
                ngotra: $("#ng").val(),
                mgotra: $("#mg").val(),
                sort: $("#sort").val(),
                is_fav: is_fav,
            },
            dataType: "json",
            success: function(res) {
                if (res.status == 1) {
                    res.members.map(function(members) {
                        let path = members.profile_photo ?
                            BASE_URL +
                            "/public/uploads/members_profile/" +
                            members.profile_photo :
                            members.gender && members.gender == "Male" ?
                            BASE_URL + "/public/img/male.jpg" :
                            BASE_URL + "/public/img/female.jpg";
                        let dob = new Date(members.dob).toLocaleString("en-us", {
                            month: "short",
                            year: "numeric",
                        });
                        let year =
                            new Date().getFullYear() - new Date(members.dob).getFullYear();
                        var realFeet = ((members.height * 0.393700) / 12);
                        var feet = Math.floor(realFeet);
                        var inches = Math.round((realFeet - feet) * 12);
                        let height = feet + "'" + inches + '"' + "Feet";
                        $(
                            "#matrimonial-cards"
                        ).append(`<div class="col-md-6  col-xxl-4 card-member" style="cursor:pointer;">
                        <div class="card mb-3 mcard">
                        <div class="row g-0">
                        <div class="col-md-4" style="max-width: 176px;">
                        <img src=" ${path} "class="img-fluid rounded-start" alt="..." style="height:180px;">
                        </div>
                                <div class="col-md-8">                                
                                <i class="fal fa-share-alt share-icon share-mcard" title="share" uid="${members.user_id
                            }"></i>
                                <i class="${is_favorite(members.user_id)
                                ? "fa text-danger"
                                : "far"
                            } fa-heart btn-favorite favorite-icon"  title="favorite"uid="${members.user_id}"></i>
                                <div class="card-body"style="padding: 10px 13px 0px 13px;">
                                <div class="row">
                                <div class="row">
                                <div class="col-md-8 hideextra"style="padding:0px;">
                                <span class="h4"id="name"uid="${members.user_id}"title="${members.first_name + " " + members.last_name}">${members.first_name + " " + members.last_name}</span>
                                </div>
                                </div> <span class="w-100 d-block text-muted h6"style="margin-bottom: 5px;padding:0px;">${(members.father_name ? (members.gender == "Male" ? "s/o " : "d/o ") : "w/o ") + (members.father_name || members.husband_name)}</span>

                                                                </div>
                                    </div>
              <div class="row ">
                                            <div class="col-sm-6 label_style">
                                                <label class="mb-0 label"title="Marital Status">Marital Status</label>
                                                </div>
                                                <div class="col-6 text-secondary hideextra" id="marital_status" title="${members.marital_status
                                ? members.marital_status
                                : "Not available"
                            }">
                            ${members.marital_status
                                ? members.marital_status
                                : "N/A"
                            }
                                            </div>
                                            </div>
                                            <div class="row ">
                                            <div class="col-sm-6 label_style">
                                            <label class="mb-0 label"title="Maanglik">Maanglik</label>
                                            </div>
                                            <div class="col-6 text-secondary hideextra" id="gender" title="${members.is_manglik == 0
                                ? "Not available"
                                : members.is_manglik
                            }">
                                            ${members.is_manglik == 0
                                ? "N/A"
                                : "Yes"
                            }
                                            </div>
                                            </div>
                                            <div class="row ">
                                            <div class="col-sm-6 label_style">
                                                <label class="mb-0 label"title="Height">Height</label>
                                                </div>
                                                <div class="col-6 text-secondary hideextra" id="height" 
                                                title="${height == "0'0\"Feet" ? "Not available" : height}">
                                                ${height == "0'0\"Feet" ? "N/A" : height}
                            </div>
                                        </div>
                                        <div class="row ">
                                        <div class="col-sm-6 label_style">
                                        <label class="mb-0 label"title="Date of birth and age">DOB and Age</label>
                                        </div>
                                            <div class="col-6 text-secondary hideextra" title="${members.dob
                                ? dob +
                                " " +
                                "(" +
                                year +
                                " " +
                                "years old" +
                                ")"
                                : "Not available"
                            }">
                                            ${members.dob
                                ? dob +
                                " " +
                                "(" +
                                year +
                                " " +
                                "yrs" +
                                ")"
                                : "N/A"
                            }                                           
                                             </div>
                                             </div>
                                             <div class="row ">
                                             <div class="col-sm-6 label_style">
                                             <label class="mb-0 label">Education</label>
                                             </div>
                                            <div class="col-6 text-secondary hideextra" id="edu" title="${members.education
                                ? members.education
                                : "Not available"
                            }">
                                            ${members.education
                                ? members.education
                                : "N/A"
                            }
                            </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>`);
                    });
                    loaded_total_member = loaded_total_member + res.members.length;
                    total_members = res.total_members;
                } else if (res.total_members == 0) {
                    $("#matrimonial-cards").append(`<h4>${res.message}</h4>`);
                }
            },
        };
        $.ajax(cards);
    };
    loadFavorites(matrimonial);

    let recreateCard = () => {
        $("#matrimonial-cards").html("");
        p = 1;
        loaded_total_member = 0;
        matrimonial(p);
    };

    $("#filter-male").click(function(e) {
        $(this).addClass("bg-dark text-white");
        $("#filter-female").removeClass("bg-dark text-white");
        $("#radio-male").prop("checked", true);
        recreateCard();
    });
    $("#filter-female").click(function(e) {
        $(this).addClass("bg-dark text-white");
        $("#filter-male").removeClass("bg-dark text-white");
        $("#radio-female").prop("checked", true);
        recreateCard();
    });

    $(document).on("change", "#select-edu", function() {
        recreateCard();
    });
    $(document).on("change", "#marital-status", function() {
        recreateCard();
    });
    $(document).on("change", "#height", function() {
        recreateCard();
    });
    $(document).on("change", "#age", function() {
        recreateCard();
    });
    $(document).on("change", "#sg", function() {
        recreateCard();
    });
    $(document).on("change", "#dg", function() {
        recreateCard();
    });
    $(document).on("change", "#ng", function() {
        recreateCard();
    });
    $(document).on("change", "#sort", function() {
        recreateCard();
    });
    $(document).on("change", "#manglik", function() {
        recreateCard();
    });
    $(document).on("click", "#my_fav", function() {
        $(this).toggleClass("btn-outline-danger").toggleClass("btn-danger");
        $("#inpt-is-fav")
            .prop("checked", !$("#inpt-is-fav").prop("checked"))
            .trigger("change");
    });

    $("#inpt-is-fav").change(function() {
        recreateCard();
    });
    // matrimonial details................
    $(document).on("click", ".card-member #name", function() {
        let id = $(this).attr("uid");
        $("#matrimonial-membr-id").val(id);
        showMemberDetail(id);
    });
    var showMemberDetail = (id) => {
        let userProfile = {
            url: BASE_URL + "/matrimonial/getMatrimonialDetail",
            data: {
                id: id,
            },
            dataType: "json",
            method: "post",
            success: function(res) {
                console.log(res);
                if ((res.status = 1)) {
                    let photo = res.detail.profile_photo ?
                        BASE_URL +
                        "/public/uploads/members_profile/" +
                        res.detail.profile_photo :
                        res.detail.gender && res.detail.gender == "Male" ?
                        BASE_URL + "/public/img/male.jpg" :
                        BASE_URL + "/public/img/female.jpg";
                    $("#photo").attr("src", photo);
                    $("#favorite-uid").attr("uid", res.detail.user_id);
                    //check if user is favorite
                    $("#favorite-uid")
                        .removeClass("fa")
                        .removeClass("text-danger")
                        .addClass("far");

                    $(".btn-favorite").each(function(ele) {
                        if (
                            $(this).attr("uid") == res.detail.user_id &&
                            $(this).hasClass("text-danger")
                        ) {
                            $("#favorite-uid")
                                .removeClass("far")
                                .addClass("fa")
                                .addClass("text-danger");
                            return false;
                        }
                    });
                    $("#f_name").html(
                        res.detail.first_name && res.detail.last_name ?
                        res.detail.first_name + " " + res.detail.last_name :
                        "N/A"
                    );

                    $('#self-occuption').html(res.detail.occupation ? `<span>${res.detail.occupation}</span>` : false)
                    console.log(res.detail.occuption);
                    let age = new Date(res.detail.dob).toLocaleString("en-us", {
                        month: "short",
                        year: "numeric",
                    });
                    let year = new Date().getFullYear() - new Date(res.detail.dob).getFullYear();

                    $("#dob").html(
                        res.detail.dob ? age + ` (${year} Years) ` : "N/A"
                    );

                    $("#address").html(
                        res.detail.address +
                        (res.detail.tahsil ? ", " + res.detail.tahsil : "") +

                        (res.detail.district ? ", " + res.detail.district : "") +

                        (res.detail.state ? res.detail.state : "")
                    );

                    $("#father-name").html(
                        res.detail.father_name ? res.detail.father_name : "N/A"
                    );
                    $("#mother-name").html(
                        res.detail.mother_name ? res.detail.mother_name : "N/A"
                    );
                    $("#slf-income").html(
                        res.detail.self_income ? res.detail.self_income : "N/A"
                    );
                    $("#fmly-income").html(
                        res.detail.family_income ? res.detail.family_income : "N/A"
                    );
                    $("#fa_occuption").html(
                        res.detail.father_occupation ? res.detail.father_occupation : "N/A"
                    );
                    $("#self-gotra").html(res.detail.gotra ? res.detail.gotra : "N/A");
                    $("#mtnl-gotra").html(res.detail.mgotra ? res.detail.mgotra : "N/A");
                    $("#gd-mtnl-gotra").html(
                        res.detail.dgotra ? res.detail.dgotra : "N/A"
                    );
                    $("#grand-mtnl-gotra").html(
                        res.detail.ngotra ? res.detail.ngotra : "N/A"
                    );
                    var realFeet = ((res.detail.height * 0.393700) / 12);
                    var feet = Math.floor(realFeet);
                    var inches = Math.round((realFeet - feet) * 12);
                    $("#heigth").html(res.detail.height ? feet + "." + inches + " feet" : "N/A");


                    $("#bld-group").html(
                        res.detail.blood_group ? res.detail.blood_group : "N/A"
                    );
                    $("#mrtl-stutus").html(
                        res.detail.marital_status ? res.detail.marital_status : "N/A"
                    );
                    $("#hgh-education").html(
                        res.detail.education ? res.detail.education : "N/A"
                    );
                    if (res.detail.phone) {
                        $("#phone").html(`<i class="fas fa-phone-alt me-3"></i>
                        <span>${res.detail.phone} </span>`)
                        $("#phone").show();
                    }
                    if (res.detail.email) {
                        $("#email").html(`<i class="fas fa-envelope me-3"></i>
                        <span>${res.detail.email} </span>`)
                        $("#email").show();
                    }

                }
            },
            error: function(err) {
                console.log(err);
            },
            complete: function() {
                $("#mdl-matrimonial-detail").modal("show");
            },
        };
        $.ajax(userProfile);
    };

    var originalModal = $('#mdl-matrimonial-detail').clone();
    $(document).on('hidden.bs.modal', '#mdl-matrimonial-detail', function(e) {
        $(this).remove();
        var myClone = originalModal.clone();
        $('body').append(myClone);
    });

    function loadFavorites(callback) {
        $.ajax({
            url: BASE_URL + "/matrimonial/my_favorites",
            method: "post",

            dataType: "json",
            success: function(res) {
                if (res.status == 1) {
                    window.sessionStorage.setItem("favoriteUIDs", res.favorites);
                }
            },
            complete: function() {
                if (callback) callback();
            },
        });
    }

    $(document).on("click", ".btn-favorite", function() {
        let btn = $(this);
        let uid = btn.attr("uid");
        let remove = btn.hasClass("text-danger") ? 1 : 0;
        $.ajax({
            url: BASE_URL + "/matrimonial/update_favorite",
            method: "post",
            dataType: "json",
            data: {
                uid: uid,
                remove: remove,
            },
            success: function(res) {
                if (res.status == 1) {
                    $(".btn-favorite").each(function() {
                        if ($(this).attr("uid") == uid) {
                            $(this)
                                .toggleClass("text-danger")
                                .toggleClass("fa")
                                .toggleClass("far");
                        }
                    });
                    loadFavorites();
                } else {
                    alert(res.msg);
                }
            },
        });
    });

    // ajax request to send a message from matrimonial cotact form....

    $("#frm-send-msg").validate({
        rules: {
            msg: {
                required: true,
                minlength: 10,
            },
        },
        messages: {
            msg: {
                required: "Please write something",
                minlength: "Message should be greater than 10 characters",
            },
        },
        submitHandler: function(form, event) {
            event.preventDefault();
            var btn_msg;
            let sendmsg = {
                beforeSend: function() {
                    $("#btn-send").attr("disabled", true);
                    btn_msg = $("#btn-send").html();
                    $("#btn-send").html(`<span class="fa-lg">
            <i class="fas fa-circle-notch fa-1x fa-spin"></i>
        </span>`);
                },
                url: BASE_URL + "/matrimonial/sendMsg",
                data: $(form).serialize(),
                method: "post",
                dataType: "json",
                success: function(res) {
                    if (res.status == 1) {
                        $("#msg").val("");
                        $("#sucs-send").show();
                        setTimeout(() => {
                            $("#sucs-send").hide();
                        }, 10000);
                    }
                },
                complete: function() {
                    $("#btn-send").attr("disabled", false).html(btn_msg);
                },
                error: function(err) {
                    console.log(err);
                },
            };
            $.ajax(sendmsg);
        },
    });

    //share link.....
    $(document).on("click", ".share-mcard", function() {
        let id = $(this).attr("uid");
        let share_path = "http://localhost/jangirsamaj/matrimonial/card/" + id;
        $("#inpt-share-mcard").val(share_path);
        $("#share-matrimonail-card").modal("show");
    });
    // $(document).on("click", ".share-mcard", function () {
    //     $("#link-share-modal").modal("show");
    // });

    var p = 1;
    window.onscroll = function() {
        if (window.innerHeight + window.scrollY + 1 >= document.body.offsetHeight) {
            // you're at the bottom of the page
            p++;
            if (total_members > loaded_total_member) matrimonial(p);
            //get_matrimonial_users(p);
        }
    };
});