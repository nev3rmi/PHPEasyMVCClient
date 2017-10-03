PHPEasy.Page.Sitemap.Admin.Group = PHPEasy.Page.Sitemap.Admin.Group || {};
PHPEasy.Page.Sitemap.Admin.Group = {
    Table: "",
    Init: {
        Table: function() {
            // Init Table
            var tableName = '#list-group';
            var tableColumnToGroup = 0;
            var colSpan = 3;
            var actionColumn = 3; // TODO: Will be auto in future

            var table = $(tableName).DataTable({
                "deferRender": true,
                "pagingType": "full_numbers",
                "columnDefs": [{

                }],
                "order": [
                    [0, 'asc']
                ],
                "ajax": {
                    url: "/admin/group/GetDataForGroupTable",
                    type: 'POST'
                },
                "columns": [
                    { "data": "GroupName" },
                    { "data": "GroupDescription" },
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

                    // Apply Search By Column
                    DataTableCustomize.applySearchBox(table);

                    // Apply Live Ajax
                    DataTableCustomize.applyLiveAjax(table, 30000); // Check if user action or not if not then allow to refresh else extend.

                },
                "drawCallback": function(settings) {
                    DataTableCustomize.paginate_button(tableName);
                    DataTableCustomize.applyTooltip();
                }
            });

            PHPEasy.Page.Sitemap.Admin.Group.Table = table;
        }
    },
    Create: {
        New: function() {

        },
        Edit: function(id = 0) {

        },
        _action: function(id = 0) {
            var modalName = null;
            var modelIcon = null;
            var modelCloseButtonId = 'btn-addupdate-groupform-close-' + id;

            if (id === 0) {
                modalName = 'New Group';
                modelIcon = 'plus';
            } else {
                modalName = 'Edit Group [ID: ' + id + ']';
                modelIcon = 'pencil';
            }

            BootstrapDialog.show({
                title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                type: BootstrapDialog.TYPE_DEFAULT,
                description: "Loading Page's Form",
                message: function(dialog) {
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad);
                    return $message;
                },
                data: {
                    'pageToLoad': '/admin/group/GetFormForAddUpdateGroup/GroupId=' + id
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
                        var data = $('#formAddUpdateGroups').serialize();
                        data = data + '&groupId=' + id;
                        // Initiate Modal: disallow to close and disable buttons
                        dialog.enableButtons(false);
                        dialog.setClosable(false);
                        dialog.getModalBody().html('Request processing...');
                        $.post('/admin/group/GetDataFromFormAddInsertGroup', data, function(result) {
                            returnResult = parseInt(result.replace(/\s/g, ''));
                            if (returnResult === 1) {
                                dialog.getModalBody().html('Request successful!');
                                dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                // Reload table
                                PHPEasy.Page.Sitemap.Admin.Group.Table.ajax.reload(null, false);
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
    },
    Action: function() {
        // Init private here
        var _action = function(id = 0) {
            var modalName = null;
            var modelIcon = null;
            var modelCloseButtonId = 'btn-addupdate-groupform-close-' + id;

            if (id === 0) {
                modalName = 'New Group';
                modelIcon = 'plus';
            } else {
                modalName = 'Edit Group [ID: ' + id + ']';
                modelIcon = 'pencil';
            }

            BootstrapDialog.show({
                title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                type: BootstrapDialog.TYPE_DEFAULT,
                description: "Loading Page's Form",
                message: function(dialog) {
                    var $message = $('<div></div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    $message.load(pageToLoad);
                    return $message;
                },
                data: {
                    'pageToLoad': '/admin/group/GetFormForAddUpdateGroup/GroupId=' + id
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
                        var data = $('#formAddUpdateGroups').serialize();
                        data = data + '&groupId=' + id;
                        // Initiate Modal: disallow to close and disable buttons
                        dialog.enableButtons(false);
                        dialog.setClosable(false);
                        dialog.getModalBody().html('Request processing...');
                        $.post('/admin/group/GetDataFromFormAddInsertGroup', data, function(result) {
                            returnResult = parseInt(result.replace(/\s/g, ''));
                            if (returnResult === 1) {
                                dialog.getModalBody().html('Request successful!');
                                dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                // Reload table
                                PHPEasy.Page.Sitemap.Admin.Group.Table.ajax.reload(null, false);
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
        };


        return {
            Create: function() {
                _action();
            },
            Edit: function(id) {
                _action(id);
            },
            Delete: function(id) {
                var modalName = 'Delete Group [ID: ' + id + ']';
                var modelIcon = 'trash';
                var modelCloseButtonId = 'btn-delete-controllerform-close-' + id;

                BootstrapDialog.show({
                    title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                    type: BootstrapDialog.TYPE_DANGER,
                    description: "Loading Group's Form",
                    message: 'Are you sure to delete this group ?',
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
                                $.post('/admin/group/DeleteGroup', { "groupId": id }, function(result) {
                                    returnResult = parseInt(result.replace(/\s/g, ''));
                                    if (returnResult === 1) {
                                        dialog.getModalBody().html('Request successful!');
                                        dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                        // Reload table
                                        PHPEasy.Page.Sitemap.Admin.Group.Table.ajax.reload(null, false);
                                        // Time out dialog
                                        setTimeout(function() {
                                            dialog.close();
                                        }, 500);
                                    } else {
                                        dialog.setType(BootstrapDialog.TYPE_DANGER);
                                        dialog.getButton(modelCloseButtonId).enable();
                                        dialog.getModalBody().html(result);
                                        dialog.setClosable(true);
                                    }
                                });
                            }
                        }
                    ]
                });
            }
        };
    },
    Manage: {
        People: {
            View: function(id) {
                var modalName = "Users in Group [ID: " + id + "]";
                var modelIcon = 'star';
                var modelCloseButtonId = 'btn-groupperm-pageform-close-' + id;

                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_PRIMARY,
                    size: BootstrapDialog.SIZE_WIDE,
                    title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                    description: "Loading User in Group's Form",
                    message: function(dialog) {
                        var $message = $('<div>Loading...</div>');
                        var pageToLoad = dialog.getData('pageToLoad');
                        // Load Page
                        $message.load(pageToLoad);
                        return $message;
                    },
                    data: {
                        'pageToLoad': '/admin/group/GETUserInGroup/GroupId=' + id
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
            }
        },
        Action: function() {

        }
    }
};


//TODO: HERE

(function($) {
    var result = PHPEasy.Page.Sitemap.Admin.Group.Init.Table();
})(jQuery);