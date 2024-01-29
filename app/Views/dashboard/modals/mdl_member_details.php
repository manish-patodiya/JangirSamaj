<div class="modal  fade" id="mdl-member-details">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 p-3">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="position-relative text-center" id="profile">
                                <img alt="Admin" width="200" height="200" id="member-profile-photo">
                            </div>
                        </div>
                        <div class="col-md-9 ps-md-4 pe-0 row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <div class="h1 mb-1 fw-normal" style="color:#4f6376">
                                        <span id="member-name"></span>
                                    </div>
                                </div>
                                <div class=" d-flex flex-column justify-content-center">
                                    <div class="mb-2 fw-normal" id="member-email">
                                    </div>
                                    <div class="mb-2 fw-normal" id="member-phone">
                                    </div>
                                    <div class="mb-2 fw-normal">
                                        <i class="fas fa-map-marker-alt me-3" style="font-size:18px"></i>
                                        <span id="member-address"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-tab">My
                                    Profile</button>
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#business-tab"
                                    id="nav-business">My Business</button>
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#family-tab"
                                    id="nav-family">Family Members</button>
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#matrimonial-tab"
                                    id="nav-matrimonial" style="display:none">Matrimonial Profile</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="profile-tab" role="tabpanel">
                                <div class="row p-3 pe-5">
                                    <h4 class="text-secondary">ABOUT</h4>
                                    <hr class="m-0 ms-2">
                                    <div class="col-md-6 ">
                                        <div class="my-4">
                                            <label class="text-secondary">Date of birth</label>
                                            <div class="h6" style="font-size:18px">
                                                <span id="member-dob"></span>
                                            </div>
                                        </div>
                                        <div class="my-4">
                                            <label class="text-secondary">Gender</label>
                                            <div class="h6" style="font-size:18px">
                                                <span id="member-gender"></span>
                                            </div>
                                        </div>
                                        <div class="my-4">
                                            <label class="text-secondary">Education</label>
                                            <div class="h6" style="font-size:18px">
                                                <span id="member-education"></span>
                                            </div>
                                        </div>
                                        <div class="my-4">
                                            <label class="text-secondary">Qualification</label>
                                            <div class="h6" style="font-size:18px">
                                                <span id="member-qualification"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my-4">
                                            <label class="text-secondary">Father's Name</label>
                                            <div class="h6" style="font-size:18px">
                                                <span id="member-father"></span>
                                            </div>
                                        </div>
                                        <div class="my-4">
                                            <label class="text-secondary">Mother's Name</label>
                                            <div class="h6" style="font-size:18px">
                                                <span id="member-mother"></span>
                                            </div>
                                        </div>
                                        <div class="my-4">
                                            <label class="text-secondary">Marital Status</label>
                                            <div class="h6" style="font-size:18px">
                                                <span id="member-mstatus"></span>
                                            </div>
                                        </div>
                                        <div class="my-4">
                                            <label class="text-secondary">Occupation</label>
                                            <div class="h6" style="font-size:18px">
                                                <span id="member-occupation"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" style="min-height: 372px;" id="business-tab" role="tabpanel">
                                <div id="business-cards" class="p-3 row">
                                    <span class="h1 text-secondary ">Loading.....</span>
                                </div>
                            </div>
                            <div class="tab-pane fade" style="min-height: 372px;" id="family-tab" role="tabpanel">
                                <div id="fam-member-cards" class="row p-3">
                                    <span class="h1 text-secondary ">Loading.....</span>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="matrimonial-tab" role="tabpanel">
                                <div class="row p-3 pe-5">
                                    <div class="col-md-6 me-2 row">
                                        <h4 class="text-secondary">Self</h4>
                                        <hr class="m-0">
                                        <div class="col-md-6">
                                            <div class="my-4">
                                                <label class="text-secondary">Age</label>
                                                <div class="h6" style="font-size:18px">
                                                    <span id="member-age"></span>
                                                </div>
                                            </div>
                                            <div class="my-4">
                                                <label class="text-secondary">Income</label>
                                                <div class="h6" style="font-size:18px">
                                                    <span id="member-income"></span>
                                                </div>
                                            </div>
                                            <div class="my-4">
                                                <label class="text-secondary">Gotra</label>
                                                <div class="h6" style="font-size:18px">
                                                    <span id="member-gotra"></span>
                                                </div>
                                            </div>
                                            <div class="my-4">
                                                <label class="text-secondary">Height</label>
                                                <div class="h6" style="font-size:18px">
                                                    <span id="member-height"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="my-4">
                                                <label class="text-secondary">Skin</label>
                                                <div class="h6" style="font-size:18px">
                                                    <span id="member-skin"></span>
                                                </div>
                                            </div>
                                            <div class="my-4">
                                                <label class="text-secondary">Place of birth</label>
                                                <div class="h6" style="font-size:18px">
                                                    <span id="member-pob"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <h4 class="text-secondary">Family</h4>
                                        <hr class="m-0">
                                        <div class="col-md-6">
                                            <div class="my-4">
                                                <label class="text-secondary">Mother's Gotra</label>
                                                <div class="h6" style="font-size:18px">
                                                    <span id="member-mgotra"></span>
                                                </div>
                                            </div>
                                            <div class="my-4">
                                                <label class="text-secondary">Dadi gotra</label>
                                                <div class="h6" style="font-size:18px">
                                                    <span id="member-dgotra"></span>
                                                </div>
                                            </div>
                                            <div class="my-4">
                                                <label class="text-secondary">Nani Gotra</label>
                                                <div class="h6" style="font-size:18px">
                                                    <span id="member-ngotra"></span>
                                                </div>
                                            </div>
                                            <div class="my-4">
                                                <label class="text-secondary">Family Income</label>
                                                <div class="h6" style="font-size:18px">
                                                    <span id="member-f-income"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="my-4">
                                                <label class="text-secondary">Father's Occupation</label>
                                                <div class="h6 " style="font-size:18px">
                                                    <span id="member-father-occupation"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>