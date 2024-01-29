<?php
echo view('dashboard/header/header_top');
?>
<div class="col-6 card m-4">
    <a class="fs-4  m-2" href="<?=base_url()?>">
        <img src="<?=base_url('public/img/Vishwakarma.jpg')?>" width="40" height="40"> Jangid
        Samaj </a>
    <hr class="my-0">
    <div class="mt-2 ">
        <form method="post" autocomplete="off" id="frm-send-msg" enctype="multipart/form_data">
            <div class="m-2">
                <span class="h4 ">Message / संदेश</span>
                <textarea class="form-control mt-2" name="msg" placeholder="Type your message here" rows="3"
                    id="msg"></textarea>
                <input type="hidden" name="uid" value="" id="matrimonial-membr-id">
                <div class="text-end me-3 mt-1">
                    Back to <a href="<?php echo base_url("matrimonial"); ?>"> matrimonial
                        card</a>
                </div>

                <div class="text-end me-3 my-3 ">
                    <span id="sucs-send" class="text-success" style="display:none">Your message has been
                        sent</span>

                    <label>
                        <input type="checkbox" name="share_phone">
                        Share your contact
                    </label>

                    <button class="btn btn-sm btn-primary" id="btn-send" type="submit">
                        Send message</button>
                </div>
            </div>
        </form>
    </div>
</div>