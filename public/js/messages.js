$(document).ready(function() {
    $('#table-mess').DataTable({
        serverSide: true,
        ajax: {
            url: BASE_URL + "/messages/getMessages",
        },
    })
})