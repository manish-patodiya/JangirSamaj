<div class="modal fade" id="mdl-upload-photo">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Member List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- <form action="" method="post"> -->
            <div class="modal-body mx-5">
                <div class="my-2">
                    <div id="my_camera"></div><br />
                    <img id="img" src="" alt="" height="270" width="270" style="display:none">
                    <button class="btn btn-primary" id="take-photo" onClick="take_snapshot()">Take Photo</button>
                    <button class="btn btn-primary" id="retake" onClick="retake_snapshot()"
                        style="display:none">retake</button>
                    <input type="hidden" name="image" class="image-tag">
                </div>
            </div>
            <div class="modal-footer ">
                <button class="btn btn-primary" onclick="saveSnap()">upload</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>
<?php
pr($_FILES);
if (isset($_POST['image'])) {
    $img = md5($_POST['image']);
    move_uploaded_file(base_url("public/img/" . $img));
}

?>
<script language="JavaScript">
function take_snapshot() {
    Webcam.snap(function(data_uri) {
        Webcam.reset();
        $(".image-tag").val(data_uri);
        $('#img').prop('src', data_uri);
    });
    $('#take-photo').hide();
    $('#retake').show();
    $('#my_camera').hide();
    $('#img').show();
}

function retake_snapshot() {
    $('#retake').hide();
    $('#take-photo').show();
    $('#my_camera').show();
    $('#img').hide();
    Webcam.set({
        width: 270,
        height: 270,
        image_format: 'jpeg',
        jpeg_quality: 120
    });
    Webcam.attach('#my_camera');
}

function saveSnap() {
    // Get base64 value from <img id='imageprev'> source
    var base64image = document.getElementById("img").src;
    console.log(base64image);

    Webcam.upload(base64image, 'b',
        function(code, text) {
            console.log('Save successfully');
        });
}
</script>