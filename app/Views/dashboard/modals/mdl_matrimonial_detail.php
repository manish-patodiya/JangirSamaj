<style>
a {
    color: #0e0f0f;
}
</style>
<div class="modal fade bd-example-modal-xl" id="mdl-matrimonial-detail">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: #f25a0f;">Full Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <section class="content">
                    <!-- Prasnal Information -->
                    <div class="row  mb-3">
                        <div class="col-md-4 ">
                            <img src="" alt="Admin" width="360" height="300" id="photo">
                        </div>
                        <div class="col-md-7 ">
                            <div class="mb-3">
                                <span class="h2 text-secondary" id="f_name"> </span>
                                <div class="mb-2 fw-normal font-size" id="self-occuption">
                                </div>
                            </div>
                            <div class=" d-flex flex-column justify-content-center">
                                <div class="mb-2 fw-normal font-size">
                                    <i class="fas fa-birthday-cake me-3"></i>
                                    <span id="dob"></span>
                                </div>
                                <div class="mb-2 fw-normal font-size" id="phone" style="display: none;">
                                </div>
                                <div class="mb-2 fw-normal font-size" id="email" style="display: none;">
                                </div>
                                <div class="mb-2 fw-normal font-size">
                                    <i class="fas fa-map-marker-alt me-3"></i>
                                    <a href="https://www.google.com/maps/" target="_blank">
                                        <span class="pointer" id="address"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="position pointer">
                                <i class="fal fa-share-alt fa-2x prs-share m-2" title="share detail "
                                    data-bs-target="#share-matrimonail-card" data-bs-toggle="modal"
                                    data-bs-dismiss="modal"></i>
                                <i class="fa text-danger fa-heart fa-2x  btn-favorite" title="favorite"
                                    id="favorite-uid" uid=""></i>
                            </div>
                        </div>
                    </div>

                    <!-- Family Details   -->
                    <div class="row  mt-5">
                        <div class="col-md-6">
                            <h4 style="color: #f25a0f; font-weight: 400;" class="mb-3">Family Details /
                                <snap class="font">पारिवारिक विवरण</snap>
                            </h4>
                            <div class="row mb-3">
                                <div class="col-6 m-auto">
                                    <span class="mb-0">Father's Name / पिता का नाम</span>
                                </div>
                                <div class="col-6 text-secondary" id="father-name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <span class="mb-0">Mother's Name / माता का नाम</span>
                                </div>
                                <div class="col-6 text-secondary" id="mother-name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 ">
                                    <span class="mb-0">Self Income / स्वयं आय</span>
                                </div>
                                <div class="col-6 text-secondary" id="slf-income">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 ">
                                    <span class="mb-0">Family Income / पारिवारिक आय</span>
                                </div>
                                <div class="col-6 text-secondary" id="fmly-income">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 ">
                                    <span class="mb-0">Father Occupation / पिता का व्यवसाय</span>
                                </div>
                                <div class="col-6 text-secondary" id="fa_occuption">
                                </div>
                            </div>
                        </div>

                        <!-- Gotras Details -->
                        <div class="col-md-6">
                            <h4 style="color: #f25a0f; font-weight: 400;" class="mb-3">Gotras Details / <snap
                                    class="font">गोत्र विवरण
                                </snap>
                            </h4>
                            <div class="row mb-3">
                                <div class="col-6 ">
                                    <span class="mb-0"> Self Gotra /
                                        गोत्र ( स्वयं )</span>
                                </div>
                                <div class="col-6 text-secondary" id="self-gotra">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 ">
                                    <span class="mb-0"> Mother's Gotra /
                                        गोत्र ( माता )</span>
                                </div>
                                <div class="col-6 text-secondary" id="mtnl-gotra">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <span class="mb-0"> Gotra (Dadi) / गोत्र ( दादी )</span>
                                </div>
                                <div class="col-6 text-secondary" id="gd-mtnl-gotra">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 ">
                                    <span class="mb-0"> Gotra (Nani) / गोत्र ( नानी )</span>
                                </div>
                                <div class="col-6 text-secondary" id="grand-mtnl-gotra">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- lifeststyle And  Education Details  -->
                    <div class="row ">
                        <div class="col-md-6">
                            <h4 style="color: #f25a0f; font-weight: 400;" class="mb-3">Lifest Style / <snap
                                    class="font">जीवन शैली</snap>
                            </h4>
                            <div class="row mb-3">
                                <div class="col-6 ">
                                    <span class="mb-0">Heigth / ऊँचाइ</span>
                                </div>
                                <div class="col-6 text-secondary" id="heigth">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 m-auto">
                                    <span class="mb-0">Blood Group / रक्त समूह</span>
                                </div>
                                <div class="col-6 text-secondary" id="bld-group">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 m-auto">
                                    <span class="mb-0">Marital Status / वैवाहिक स्थिति</span>
                                </div>
                                <div class="col-6 text-secondary" id="mrtl-stutus">
                                </div>
                            </div>
                        </div>

                        <!-- Education Details -->
                        <div class="col-md-6">
                            <h4 style="color: #f25a0f; font-weight: 400;" class="mb-3">Education Details /
                                <snap class="font"> शिक्षा विवरण</snap>
                            </h4>
                            <div class="row mb-3">
                                <div class="col-6 m-auto">
                                    <label class="mb-0">Highest Education / उच्चतम शिक्षा</labelS>
                                </div>
                                <div class="col-6 text-secondary" id="hgh-education">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Message Send By Partner a phone number  -->
            <div class="modal-footer d-block">
                <div class=" row ">
                    <form method="post" autocomplete="off" id="frm-send-msg" enctype="multipart/form_data">
                        <div class="row">
                            <span class="h4 font">Message / संदेश</span>
                            <textarea class="form-control " name="msg" placeholder="Type your message here" rows="3"
                                id="msg"></textarea>
                            <input type="hidden" name="uid" value="" id="matrimonial-membr-id">

                            <div class="text-end me-3 my-4 ">
                                <span id="sucs-send" class="text-success" style="display:none">Your message has been
                                    sent</span>

                                <label>
                                    <input type="checkbox" name="share_phone">
                                    Share your contact
                                </label>

                                <!-- <button class="btn btn-sm btn-primary"> check box</button> -->

                                <button class="btn btn-sm btn-primary" id="btn-send" type="submit">
                                    Send message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>