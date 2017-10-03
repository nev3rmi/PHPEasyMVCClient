// Neccessary ????
function submitNewController(data, dialog) {
    //var data = $('#formNewController').serialize();
    dialog.getModalBody().html('Request processing...');
    $.post('/admin/GetDataFromFormInsertNewController', data, function(result) {
        alert(result);
    });
}