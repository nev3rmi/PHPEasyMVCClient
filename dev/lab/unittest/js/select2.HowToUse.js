// Load data for .selectController Ajax
(function($) {
    $(".selectController").select2({
        ajax: {
            url: "/admin/POSTAvailableController",
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function(params) {
                return {
                    requestParam: params.term // search term [$_POST['requestParam']]
                };
            },
            processResults: function(data) {
                return {
                    results: data.items // {items:[{"id":"1","text":"test"}]}
                };
            },
            cache: true
        },
        minimumInputLength: 2 // Input min length
    });
})(jQuery);
// Load data for .selectController Ajax Multiple Select
(function($) {
    $(".selectController").select2({
        ajax: {
            url: "/admin/POSTAvailableController",
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
        multiple: true
    });
})(jQuery);
// Load data for .selectController Ajax Multiple Select Allow New Value
(function($) {
    $(".selectController").select2({
        ajax: {
            url: "/admin/POSTAvailableController",
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
        multiple: true,
        tags: true
    });
})(jQuery);
// In Modal
(function($) {
    $(".selectController").select2({
        dropdownParent: $(".modal") // Fix bootstrap modal not regconize select2
    })
})(jQuery);

// https://select2.github.io/examples.html -> For more info