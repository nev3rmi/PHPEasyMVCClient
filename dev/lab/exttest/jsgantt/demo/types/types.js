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
    }, true);

});
