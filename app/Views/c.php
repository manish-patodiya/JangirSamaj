<!DOCTYPE html>
<html>

<head>
    <title>Take Image Snapshot from webcam with Jquery and PHP - Fulltotech.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <style type="text/css">
    #results {
        padding: 10px;
        border: 1px solid;
        background: #ccc;
    }
    </style>
</head>

<body>
    <button class="btn-sm btn-primary" onClick="abc()">dfg</button>
</body>
<script>
abc = () => {
    console.log("asdf");
    $("#mdl-upload-photo").modal('show');
    Webcam.set({
        width: 270,
        height: 270,
        image_format: 'jpeg',
        jpeg_quality: 120
    });
    Webcam.attach('#my_camera');
}
</script>

<?=view("dashboard/modals/take_profile_photo")?>

</html>