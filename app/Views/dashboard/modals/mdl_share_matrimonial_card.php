<link rel="stylesheet" href="<?php echo base_url("public/css/share_msg.css") ?>">
<div class="modal fade " id="share-matrimonail-card">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModelLabel">Share This Link</h5> <button type="button" class="btn-close"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center icons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=example.org" target="_blank"
                        class="fs-5 d-flex align-items-center justify-content-center">
                        <span class="fab fa-facebook-f"></span>
                    </a>
                    <a href="https://www.twitter.com/share?url" target="_blank"
                        class="fs-5 d-flex align-items-center justify-content-center">
                        <span class="fab fa-twitter"></span>
                    </a>
                    <a href="https://instagram.com/api/v1/media/upload/" target="_blank"
                        class="fs-5 d-flex align-items-center justify-content-center">
                        <span class="fab fa-instagram"></span>
                    </a>
                    <a target="_blank" href="https://wa.me?text=http://localhost/jangirsamaj"
                        class="fs-5 d-flex align-items-center justify-content-center">
                        <span class="fab fa-whatsapp"></span>
                    </a>
                    <a href="https:mailto:" target="_blank" id="share-link-email"
                        class="fs-5 d-flex align-items-center justify-content-center">
                        <span class="far fa-envelope"></span>
                    </a>
                </div>
                <p>Or copy link</p>
                <div class="field d-flex align-items-center justify-content-between"> <span
                        class="fas fa-link text-center"></span>
                    <input type="text" value="" id="inpt-share-mcard">
                    <button onclick="copyToClip()" class="copy" id="copy">Copy</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function copyToClip() {
    /* Get the text field */
    var copyText = document.getElementById("inpt-share-mcard");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    navigator.clipboard.writeText(copyText.value);

}
$(document).on("click", ".copy", function() {
    $("#copy").html('copide');
});


// $('#share-link-email').on('click', function(event) {
//     event.preventDefault();
//     var email = '';
//     var subject = '';
//     var emailBody = `<!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="UTF-8">
//     <meta http-equiv="X-UA-Compatible" content="IE=edge">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <title>Document</title>
// </head>
// <body>
//     <a>lskfjsfdklj</a>
// </body>
// </html>`;
//     window.location = 'mailto:' + email + '?subject=' + subject + '&body=' + emailBody;
// });
</script>