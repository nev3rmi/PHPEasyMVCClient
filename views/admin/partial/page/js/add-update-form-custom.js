(function($) {
    $(".selectController").select2({
        ajax: {
            url: "/admin/page/POSTAvailableController",
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
        placeholder: "Type name of controller or All",
        allowClear: true,
        dropdownParent: $(".modal") // Fix bootstrap modal not regconize select2
    });

    $(".parentId").select2({
        ajax: {
            url: "/admin/page/POSTAvailablePage",
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
        placeholder: "Type name of page, /url, or All",
        allowClear: true,
        dropdownParent: $(".modal") // Fix bootstrap modal not regconize select2
    });
})(jQuery);