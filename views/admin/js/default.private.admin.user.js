PHPEasy.Page.Sitemap.Admin.User = PHPEasy.Page.Sitemap.Admin.User || {};
PHPEasy.Page.Sitemap.Admin.User = {
    Init: {
        Table: function() {
            // Init Table
            var tableName = '#list-page';
            var tableColumnToGroup = 0;
            var colSpan = 3;
            var actionColumn = 3; // TODO: Will be auto in future

            var table = $(tableName).DataTable({
                "deferRender": true,
                "pagingType": "full_numbers",
                "columnDefs": [{
                        // "orderable": false,
                        // "targets": actionColumn
                    },
                    {
                        "targets": 2,
                        "render": function(data, type, full, meta) {
                            return '<a href="mailto:' + data + '">' + data + '</a>';
                        }
                    },
                    {
                        "targets": 1,
                        "className": 'tablecentered',
                        "render": function(data, type, full, meta) {
                            return (data !== "") ? '<img src="' + data + '" class="img-circle text-center" height="32px" width="32px">' : data;
                        },
                        "searchable": false
                    },
                    {
                        "targets": 5,
                        "render": function(data, type, full, meta) {
                            return (data == 1) ? "M" : "F";
                        }
                    }

                ],
                "order": [
                    [0, 'asc']
                ],
                "ajax": {
                    url: "/admin/user/GetDataForUserTable",
                    type: 'POST'
                },
                "columns": [{
                        "data": "UserId"
                    },
                    { "data": "AvatarUrl" },
                    { "data": "Email" },
                    { "data": "FirstName" },
                    { "data": "LastName" },
                    { "data": "Gender" },
                    { "data": "DOB" },

                    {
                        "data": "FacebookOauthId"
                    },
                    { "data": "GoogleOauthId" },
                    { "data": "Action" }
                ],
                "rowId": "PageRowId",
                "initComplete": function(settings, json) {
                    // Add Search box
                    DataTableCustomize.addSearchBoxOnEachColumn(tableName);

                    // Custom Search box
                    DataTableCustomize.removeContentWithoutChild(tableName + '_filter label');
                    DataTableCustomize.datatableCustom(tableName + '_filter input', 250, 'fa fa-search');

                    // List item per page box
                    DataTableCustomize.removeContentWithoutChild(tableName + '_length label');
                    DataTableCustomize.datatableCustom(tableName + '_length select', 125, 'fa fa-eye');

                    // // Apply On click order group
                    // DataTableCustomize.onClickGroup(table, tableName, tableColumnToGroup);


                    // Apply Search By Column
                    DataTableCustomize.applySearchBox(table);

                    // Apply Live Ajax
                    DataTableCustomize.applyLiveAjax(table, 30000); // Check if user action or not if not then allow to refresh else extend.

                },
                "drawCallback": function(settings) {
                    DataTableCustomize.paginate_button(tableName);
                    // // ApplyGrouping(this.api(), tableColumnToGroup, colSpan, 'Controller', 'files-o');
                    DataTableCustomize.applyTooltip();
                }
            });

            return table;
        }
    }
};

//TODO: HERE

(function($) {
    var result = PHPEasy.Page.Sitemap.Admin.User.Init.Table();
})(jQuery);