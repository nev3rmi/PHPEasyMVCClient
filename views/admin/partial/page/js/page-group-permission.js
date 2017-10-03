// Table
var PrivatePageGroupPermissionTable = (function($) {
    var tableName = '#list-page-group-permission';
    var actionColumn = 1; // TODO: Will be auto in future
    // Init
    var buttonIcon = new Array();
    var buttonName = new Array();
    // Button Custom
    buttonIcon[0] = 'plus';
    buttonName[0] = 'Group';

    var table = $(tableName).DataTable({
        "deferRender": true,
        "pagingType": "full_numbers",
        "columnDefs": [{
            "orderable": false,
            "targets": actionColumn
        }],
        "ajax": {
            url: "/admin/page/GETJSONPagesPermissionTable",
            type: 'POST'
        },
        "columns": [
            { "data": "GroupName" },
            { "data": "Action" }
        ],
        "rowId": "GroupId",
        "initComplete": function(settings, json) {
            // Add Search box
            DataTableCustomize.addSearchBoxOnEachColumn(tableName);

            // Custom Search box
            DataTableCustomize.removeContentWithoutChild(tableName + '_filter label');
            DataTableCustomize.datatableCustom(tableName + '_filter input', 250, 'fa fa-search');

            // List item per page box
            DataTableCustomize.removeContentWithoutChild(tableName + '_length label');
            DataTableCustomize.datatableCustom(tableName + '_length select', 125, 'fa fa-eye');

            // Apply Search By Column
            DataTableCustomize.applySearchBox(table);
        },
        "drawCallback": function(settings) {
            DataTableCustomize.paginate_button(tableName);
            DataTableCustomize.applyTooltip();
        },
        "dom": 'lBfrtip',
        "buttons": [{
            // TODO: Add new group with read permission in
            text: '<i class="glyphicon glyphicon-' + buttonIcon[0] + '" aria-hidden="true"></i> <b>' + buttonName[0] + '</b>',
            className: 'btn btn-success',
            action: function(e, dt, node, config) {
                var modalName = "Group's Permission";
                var modelIcon = 'share';
                var modelCloseButtonId = 'btn-addupdateGroupPerm-pageform-close';

                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_PRIMARY,
                    title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                    description: "Loading Controller's Form",
                    message: function(dialog) {
                        var $message = $('<div>Loading...</div>');
                        var pageToLoad = dialog.getData('pageToLoad');
                        // Load Page
                        $message.load(pageToLoad);
                        $('*[data-toggle="toggle"]').bootstrapToggle();
                        return $message;
                    },
                    data: {
                        'pageToLoad': '/admin/page/FORMAddNewGroupToPage'
                    },
                    buttons: [{
                        id: modelCloseButtonId,
                        label: 'Close',
                        cssClass: 'btn-default',
                        action: function(dialog) {
                            dialog.close();
                        }
                    }, {
                        label: 'Save',
                        icon: 'glyphicon glyphicon-save',
                        cssClass: 'btn-success',
                        hotkey: 13,
                        autospin: true,
                        action: function(dialog) {
                            // Get Data
                            var data = $('#formAddNewGroupToPage').serialize();
                            // Initiate Modal: disallow to close and disable buttons
                            dialog.enableButtons(false);
                            dialog.setClosable(false);
                            dialog.getModalBody().html('Request processing...');
                            $.post('/admin/page/POSTAddNewGroupToPage', data, function(result) {
                                returnResult = parseInt(result.replace(/\s/g, ''));
                                if (returnResult === 1) {
                                    dialog.getModalBody().html('Request successful!');
                                    dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                    // Reload table
                                    table.ajax.reload(null, false);
                                    // Time out dialog
                                    setTimeout(function() {
                                        dialog.close();
                                    }, 500);
                                } else {
                                    dialog.getModalBody().html(result);
                                    dialog.setType(BootstrapDialog.TYPE_DANGER);
                                    dialog.getButton(modelCloseButtonId).enable();
                                    dialog.setClosable(true);
                                }
                            })
                        }
                    }]
                });
            }
        }]
    });

    return table;
})(jQuery);

var PrivatePagePermission = {
    getGroupPagePermission: function(key) {
        // Boostrap Modal Here Ajax to Admin / GetPermissionOfGroupInPage(key)
        var modalName = "Group's Permission";
        var modelIcon = 'share';
        var modelCloseButtonId = 'btn-addupdateGroupPerm-pageform-close';

        BootstrapDialog.show({
            type: BootstrapDialog.TYPE_PRIMARY,
            size: BootstrapDialog.SIZE_SMALL,
            title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
            description: "Loading Controller's Form",
            message: function(dialog) {
                var $message = $('<div>Loading...</div>');
                var pageToLoad = dialog.getData('pageToLoad');
                // Load Page
                $message.load(pageToLoad);
                $('*[data-toggle="toggle"]').bootstrapToggle();
                return $message;
            },
            data: {
                'pageToLoad': '/admin/page/FORMGroupPagePermission/key=' + key
            },
            buttons: [{
                id: modelCloseButtonId,
                label: 'Close',
                cssClass: 'btn-default',
                action: function(dialog) {
                    dialog.close();
                }
            }]
        });

    },

    deleteGroupPagePermission: function(id) {
        var modalName = 'Delete Access Permission Of Group';
        var modelIcon = 'trash';
        var modelCloseButtonId = 'btn-delete-grouppermform-close';

        BootstrapDialog.show({
            title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
            type: BootstrapDialog.TYPE_DANGER,
            description: "Loading Page's Form",
            message: 'Are you sure to delete this group\'s permission to access the current page ?',
            buttons: [{
                    id: modelCloseButtonId,
                    label: 'Close',
                    cssClass: 'btn-default',
                    action: function(dialog) {
                        dialog.close();
                    }
                },
                {
                    label: 'OK',
                    cssClass: 'btn-danger',
                    autospin: true,
                    hotkey: 13,
                    action: function(dialog) {
                        dialog.enableButtons(false);
                        dialog.setClosable(false);
                        $.post('/admin/page/POSTDeleteGroupPagePermission', { groupId: id }, function(result) {
                            returnResult = parseInt(result.replace(/\s/g, ''));
                            if (returnResult === 1) {
                                dialog.getModalBody().html('Request successful!');
                                dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                // Reload table
                                PrivatePageGroupPermissionTable.ajax.reload(null, false);
                                // Time out dialog
                                setTimeout(function() {
                                    dialog.close();
                                }, 500);
                            } else {
                                dialog.getModalBody().html(result);
                                dialog.setType(BootstrapDialog.TYPE_DANGER);
                                dialog.getButton(modelCloseButtonId).enable();
                                dialog.setClosable(true);
                            }
                        });
                    }
                }
            ]
        });
    }
};