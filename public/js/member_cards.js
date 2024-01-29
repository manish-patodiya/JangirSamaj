$(function() {
    var total_members = 0;
    var loaded_total_member = 0;
    cardsProfile = p => {
        cards = {
            url: BASE_URL + "/members/getMembersProfile",
            method: "post",
            data: {
                "page": p,
                district_id: $("#choose-district").val(),
                tahsil: $("#choose-tahsil").val(),
                gender: $("input[name=m-card]:checked").val(),
            },
            dataType: "json",
            success: function(res) {
                if (res.status == 1) {
                    res.members.map(function(members) {
                        let path = members.profile_photo ? BASE_URL + "/public/uploads/members_profile/" + members.profile_photo : (members.gender == "Male" ? BASE_URL + '/public/img/male.jpg' : BASE_URL + '/public/img/female.jpg');
                        let occupation = "";
                        if (members.occupation && members.occupation_detail) {
                            occupation = members.occupation + " (" + members.occupation_detail + ")";
                        } else if (members.occupation) {
                            occupation = members.occupation;
                        } else {
                            occupation = "N/A";
                        }

                        $("#member-cards").append(`<div class="col-md-6 "style="cursor:pointer;">
                        <div class="card mb-3 mcard" >
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="${path}" class="img-fluid rounded-start" alt="..." style="height: 176px;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body" style="padding: 10px 8px 15px 8px;">
                                    <h4 class="card-members pointer" uid="${members.user_id}">${members.first_name + " " + members.last_name}</h4>
                                   <div class="row">
                                       <div class="col-sm-5 label_style">
                                           <label class="mb-0">Father Name</label>
                                       </div>
                                       <div class="col-7 text-secondary hideextra" id="gender"  title="${members.father_name ? members.father_name : "Not available"}">
                                       ${members.father_name ? members.father_name : "N/A"} 
                                       </div>
                                   </div>
                                        <div class="row">
                                            <div class="col-sm-5 label_style">
                                                <label class="mb-0">Address</label>
                                            </div>
                                            <div class="col-7 text-secondary hideextra" id="marital_status" title="${members.state == 0 + "," + members.pob=='' ?"Not available" : members.state + "," + members.pob }">
                                                ${members.state == 0 + "," + members.pob=='' ?"N/A" : members.state + " ," + members.pob } 
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-sm-5 label_style">
                                                <label class="mb-0">Occupation</label>
                                            </div>
                                            <div class="col-7 text-secondary hideextra" id="height" title="${occupation == "N/A" ? "Not available":occupation}">
                                            ${occupation}</div>
                                        </div>                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`)
                    });
                    loaded_total_member = loaded_total_member + res.members.length;
                    total_members = res.total_members;
                } else if (res.total_members == 0) {
                    $("#member-cards").append(`<h4>${res.message}</h4>`)
                }
            }
        }
        $.ajax(cards)
    }

    let recreateCard = () => {
        $("#member-cards").html("");
        p = 1;
        loaded_total_member = 0;
        cardsProfile(p);
    };

    //filters functionality started

    $("#f-male").click(function(e) {
        $(this).addClass("bg-dark text-white");
        $("#f-female").removeClass("bg-dark text-white");
        $("#radio-m").prop("checked", true);
        recreateCard();
    });
    $("#f-female").click(function(e) {
        $(this).addClass("bg-dark text-white");
        $("#f-male").removeClass("bg-dark text-white");
        $("#radio-f").prop("checked", true);
        recreateCard();
    });

    $(document).on("change", "#choose-district", function() {
        $("#member-cards").html("");
        p = 1;
        loaded_total_member = 0;
        cardsProfile(p);
    })
    $(document).on("change", "#choose-state", function() {
        $("#member-cards").html("");
        p = 1;
        loaded_total_member = 0;
        cardsProfile(p);
    })

    // share link in by fb wb..........
    $(document).on("click", "share_link", function() {
        $("#shares_link").modal("show");
    });

    var p = 1;
    cardsProfile(p)
    window.onscroll = function() {
        if (window.innerHeight + window.scrollY + 1 >= document.body.offsetHeight) {
            // you're at the bottom of the page
            p++;
            if (total_members > loaded_total_member)
                cardsProfile(p);
            //get_matrimonial_users(p);
        }
    };
    //mdl_buiness_details..........

    $("#member-profile-photo").on('error', function() {
        $(this).prop('src', BASE_URL + "/public/img/avatar.png");
    });

    $(document).on("click", ".card-members", function() {
        var id = $(this).attr('uid');
        let getMember = {
            url: BASE_URL + "/members/getMemberDetails",
            data: {
                id: id,
            },
            dataType: "json",
            type: "post",
            success: function(res) {
                if (res.status == 1) {
                    let member = res.details;
                    member.profile_photo ? $('#member-profile-photo').prop('src', BASE_URL + "/public/uploads/members_profile/" + member.profile_photo) : $('#member-profile-photo').prop('src', BASE_URL + "/public/" + ((member.gender == "Male" ? 'img/male.jpg' : 'img/female.jpg')));
                    member.email ? $('#member-email').html(`<i class="far fa-envelope me-3"></i>
                    <span>${member.email}</span>`) : false;
                    $('#member-name').html(member.first_name + " " + member.middle_name + member.last_name);
                    $("#member-address").html(
                        member.address +
                        (member.tahsil ? ", " + member.tahsil : "") +
                        (member.district ? ", " + member.district : "") +
                        (member.state ? member.state : "")
                    );
                    $('#member-occupation').html(member.occupation || "N/A");
                    $('#member-phone').html(member.phone ? `<i class='fas fa-phone-alt me-3'></i><span>${member.phone}</span>` : false);
                    $('#member-dob').html(new Date(member.dob).toLocaleString('en-us', { month: 'short', year: 'numeric' }));
                    $('#member-gender').html(member.gender || "N/A");
                    $('#member-education').html(member.education || "N/A");
                    $('#member-mstatus').html(member.marital_status || "N/A");
                    $('#member-father').html(member.father_name || "N/A");
                    $('#member-mother').html(member.mother_name || "N/A");
                    $('#member-qualification').html(member.qualification || "N/A");

                    $('#member-age').html(new Date().getFullYear() - new Date(member.dob).getFullYear() + " years");
                    $('#member-income').html(member.self_income ? member.self_income + " pa" : "N/A");
                    $('#member-gotra').html(member.gotra || "N/A");
                    var realFeet = ((member.height * 0.393700) / 12);
                    var feet = Math.floor(realFeet);
                    var inches = Math.round((realFeet - feet) * 12);
                    $('#member-height').html(member.height ? feet + "." + inches + " feet" : "N/A");
                    $('#member-skin').html(member.skin || "N/A");
                    $('#member-pob').html(member.pob || "N/A");
                    $('#member-mgotra').html(member.mgotra || "N/A");
                    $('#member-dgotra').html(member.dgotra || "N/A");
                    $('#member-ngotra').html(member.ngotra || "N/A");
                    $('#member-f-income').html(member.family_income || "N/A");
                    $('#member-father-occupation').html(member.father_occupation || "N/A");
                    $('#nav-business').attr('uid', id);
                    $('#nav-family').attr('uid', id);
                    if (member.availableformarriage == "1")
                        $('#nav-matrimonial').show();
                    $("#mdl-member-details").modal("show");
                }
            },
            error: function(err) {}
        }
        $.ajax(getMember);
    });

    businessImgError = (ele) => {
        $(ele).prop('src', BASE_URL + "/public/img/product.jpg");
    };

    var originalModal = $('#mdl-member-details').clone();
    $(document).on('hidden.bs.modal', '#mdl-member-details', function(e) {
        $(this).remove();
        var myClone = originalModal.clone();
        $('body').append(myClone);
    });

    $(document).on('click', '#nav-business', function() {
        var id = $(this).attr('uid');
        let getBusiness = {
            url: BASE_URL + "/members/getBusinessDetail",
            data: {
                id: id,
            },
            dataType: "json",
            type: "post",
            success: function(res) {
                if (res.status == 1) {
                    $('#business-cards').html('');
                    res.details.map(function(e) {
                        $('#business-cards').append(`<div class="col-md-6 card p-3 shadow" style="max-width: 540px;">
                        <div class="row">
                        <div class="col-md-5">
                        <img src="${e.business_photo ? BASE_URL + "/public/uploads/business_photos/"+e.business_photo:BASE_URL + "/public/img/product.jpg"}" alt="Admin" width="190" height="160" onerror="businessImgError(this)" id="business-photo">
                        </div>
                        <div class="col-md-7 ps-0">
                        <div class="mb-2">
                        <span class="h4 text-secondary">${e.business}</span>
                        </div>
                        <div class="fw-normal">
                        <i class="fas fa-phone-alt me-3"></i>
                        <span>${e.phone}</span>
                        </div>
                        <div class="fw-normal">
                                <i class="fal fa-envelope me-3"></i>
                                <span>${e.email}</span>
                            </div>
                            <div class="fw-normal">
                            <i class="fal fa-clock me-2"></i>
                            <span>${e.time}</span>
                            </div>
                            <div class=" fw-normal">
                                <i class="fal fa-map-marker-alt me-2"></i>
                                <span>${e.address}</span>
                                </div>
                                </div>
                                <div class="mt-2 fw-normal">
                                <i class="far fa-info-circle me-2"></i>
                                <span id="business-detail">${e.business_detail}</span>
                                </div>
                                </div>
                                </div>`);
                    })
                } else {
                    $('#business-cards').html('<span class="h1 text-secondary ">No Business Found</span>');
                }
            },
            error: function(err) {
                console.log(err);
            }
        }
        $.ajax(getBusiness);
    });

    userImgError = (ele, gen) => {
        $(ele).prop('src', BASE_URL + (gen ? "/public/img/male.jpg" : "/public/img/female.jpg"));
    }

    $(document).on('click', '#nav-family', function() {
        var id = $(this).attr('uid');
        let getBusiness = {
            url: BASE_URL + "/members/getFamilyMembers",
            data: {
                id: id,
            },
            dataType: "json",
            type: "post",
            success: function(res) {
                if (res.status == 1) {
                    $('#fam-member-cards').html('');
                    res.family.map(function(member) {
                        let path = BASE_URL + "/public/" + (member.profile_photo ? "uploads/members_profile/" + member.profile_photo : (member.gender == "Male" ? 'img/male.jpg' : 'img/female.jpg'));
                        $('#fam-member-cards').append(`<div class="col-md-6 " ">
                        <div class="card mb-3 mcard">
                            <div class="row g-0">
                                <div class="col-md-4"style="max-width: 176px;">
                                    <img src="${path}" onerror="userImgError(this,${member.gender == "Male"})" class="img-fluid rounded-start" alt="..." style="height: 176px;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body" style="padding: 10px 8px 15px 8px;">
                                    <span class="h4">${member.first_name + " " + member.last_name}</span>
                                    <span class="w-100 d-block text-muted h5 fw-normal">${(member.father_name ? (member.gender == "Male"?"S/O ": "D/O "): "W/O " ) + (member.father_name || member.husband_name)}</span>
                                        <div class="row ">
                                            <div class="col-md-5">
                                                <label class="">Occupation</label>
                                            </div>
                                            <div class="col-7 text-secondary hideextra" >
                                                ${member.occupation}
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-md-5">
                                                <label class="">Education</label>
                                            </div>
                                            <div class="col-7 text-secondary hideextra">
                                                ${ member.education+ ' (' + member.qualification +')' }
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-md-5">
                                                <label class="">Relation</label>
                                            </div>
                                            <div class="col-7 text-secondary hideextra">
                                                ${member.relation}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="">Address</label>
                                            </div>
                                            <div class="col-7 text-secondary hideextra">
                                                ${((member.tahsil || "") + " " + (member.district || "") + " " + (member.state || "")||"")} 
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);
                    })
                } else {
                    $('#fam-member-cards').html('<span class="h1 text-secondary ">No Member Found</span>');
                }
            },
            error: function(err) {
                console.log(err);
            }
        }
        $.ajax(getBusiness);
    });

    $("#choose-state").change(function(e) {
        $stateID = $("#choose-state").val();
        if ($stateID) {
            var dist = {
                url: BASE_URL + "/states/getDistricts/" + $stateID,
                dataType: "json",
                success: function(res) {
                    $("#choose-district").html(
                        `<option val="" selected>Select District</option>`
                    );
                    res.districts.forEach((ele) => {
                        $("#choose-district").append(
                            `<option value="${ele.id}" >${ele.district}</option>`
                        );
                    });
                },
                error: function(err) {},
            };
            $.ajax(dist);
        } else {
            $("#choose-district").html(
                `<option value="" >Select a State first</option>`
            );
        }
    });
    $("#choose-district").change(function(e) {
        $districtID = $("#choose-district").val();
        if ($districtID) {
            var tahsil = {
                url: BASE_URL + "/states/getTahsil",
                dataType: "json",
                method: "post",
                data: {
                    district_id: $districtID
                },
                success: function(res) {
                    $("#choose-tahsil").html(
                        `<option val="" selected>Select Tahsil</option>`
                    );
                    res.tahsil.forEach((ele) => {
                        $("#choose-tahsil").append(
                            `<option value="${ele.tahsil}" >${ele.tahsil}</option>`
                        );
                    });
                },
                error: function(err) {},
            };
            $.ajax(tahsil);
        } else {
            $("#choose-tahsil").html(
                `<option value="" >Select a District first</option>`
            );
        }
    });
    $(document).on("change", "#choose-tahsil", function() {
        $("#member-cards").html("");
        p = 1;
        loaded_total_member = 0;
        cardsProfile(p);
    })
})