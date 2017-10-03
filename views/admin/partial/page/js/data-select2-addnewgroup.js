(function($) {
    $(".selectGroupName").select2({
        ajax: {
            url: "/admin/page/GETJSONAllGroupThatIsNotCurrentlyInPage",
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function(params) {
                return {
                    requestParam: params.term // search term
                };
            },
            processResults: function(data) {
                return {
                    results: data.items
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        placeholder: "Type name of group or All",
        allowClear: true,
        dropdownParent: $(".modal") // Fix bootstrap modal not regconize select2
    });
})(jQuery);