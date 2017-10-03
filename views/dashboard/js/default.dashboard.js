$(function (){
    $('#xhrForm').submit(function (){
        var url = $(this).attr('action');
        var data = $(this).serialize();
        
        $.post(url, data, function(result){
            alert(result);
        });

        return false;
    })
});