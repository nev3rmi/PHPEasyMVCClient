angular.module("demo").controller("TypesDemoController", function($scope) {



    $scope.lists = [

        {

            label: "Men",

            allowedTypes: ['man'],

            max: 4,

            people: [

                {name: "Bob", type: "man", resource : "Fank"},

                {name: "Charlie", type: "man", resource : "Fank"},

                {name: "Dave", type: "man", resource : "Fank"}

            ]

        },

        {

            label: "Women",

            allowedTypes: ['woman'],

            max: 4,

            people: [

                {name: "Alice", type: "woman", resource : "Alice"},

                {name: "Eve", type: "woman", resource : "Alice"},

                {name: "Peggy", type: "woman", resource : "Alice"}

            ]

        },

        {

            label: "People",

            allowedTypes: ['man', 'woman'],

            max: 6,

            people: [

                {name: "Frank", type: "man", resource : "Fank"},

                {name: "Mallory", type: "woman", resource : "Alice"},

                {name: "Alex", type: "unknown", resource : "Unkno"},

                {name: "Oscar", type: "man", resource : "Fank"},

                {name: "Wendy", type: "woman", resource : "Alice"}

            ]

        }

    ];



    // Model to JSON for demo purpose

    $scope.$watch('lists', function(lists) {

        $scope.modelAsJson = angular.toJson(lists, true);

        // console.log(this);

        $(".user-email-address").select2({
            placeholder: "Type an email address",
            ajax: {
                url: '/dev/lab/exttest/jsgantt/demo/echo/json.txt',
                dataType: 'json',
                type: 'POST',
                delay: 250,
                data: function(params) {
                    return {
                        json: '[{"id":"apple@apple.com","email":"apple@apple.com"},{"id":"pear@apple.com","email":"pear@apple.com"},{"id":"orange@apple.com","email":"orange@apple.com"},{"id":"lemon@apple.com","email":"lemon@apple.com"},{"id":"lime@apple.com","email":"lime@apple.com"}]',
                        delay: 0
                    };
                },
                processResults: function(data, params) {
                    var payload = {
                        results: data
                    };
                    return payload;
                },
                cache: true
            },
            templateResult: function(result) {
                return result.email;
            },
            templateSelection: function(selection) {
                return selection.email;
            },
            minimumInputLength: 2
        });

    }, true);



});

