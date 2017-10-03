PHPEasy.Page.Sitemap.Admin.Group.UserInGroup = PHPEasy.Page.Sitemap.Admin.Group.UserInGroup || {};
PHPEasy.Page.Sitemap.Admin.Group.UserInGroup = {
    Table: "",
    Init: {
        Table: function() {
            // Init Table
            var tableName = '#list-user-in-group';
            var tableColumnToGroup = 0;
            var colSpan = 3;
            var actionColumn = 3; // TODO: Will be auto in future
            // Init
            var buttonIcon = new Array();
            var buttonName = new Array();
            // Button Custom
            buttonIcon[0] = 'plus';
            buttonName[0] = 'User';
            var table = $(tableName).DataTable({
                "deferRender": true,
                "pagingType": "full_numbers",
                "columnDefs": [{

                }],
                "order": [
                    [0, 'asc']
                ],
                "ajax": {
                    url: "/admin/group/GETJSONUserInGroup",
                    type: 'POST'
                },
                "columns": [
                    { "data": "Email" },
                    // { "data": "GroupDescription" },
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
                },
                "dom": 'lBfrtip',
                "buttons": [{
                    // TODO: Add new group with read permission in
                    text: '<i class="glyphicon glyphicon-' + buttonIcon[0] + '" aria-hidden="true"></i> <b>' + buttonName[0] + '</b>',
                    className: 'btn btn-success',
                    action: function(e, dt, node, config) {
                        var modalName = "Add New User to Group";
                        var modelIcon = 'plus';
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
                                'pageToLoad': '/admin/group/GETFormForAddNewUserToGroup'
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
                                    var data = $('#formAddNewUserToGroup').serialize();

                                    // Initiate Modal: disallow to close and disable buttons
                                    dialog.enableButtons(false);
                                    dialog.setClosable(false);
                                    dialog.getModalBody().html('Request processing...');
                                    $.post('/admin/group/POSTAddNewUserToGroup', data, function(result) {
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

            PHPEasy.Page.Sitemap.Admin.Group.UserInGroup.Table = table;
        }
    },
    Action: function() {
        return {
            Add: {
                Select2: function() {
                    $(".selectUserToAddToGroup").select2({
                        ajax: {
                            url: "/admin/group/GETJSONAllUserNotInGroup",
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
                        placeholder: "Type email, userid or All",
                        allowClear: true,
                        dropdownParent: $(".modal") // Fix bootstrap modal not regconize select2
                    });
                }
            },
            Delete: function(id) {
                var modalName = 'Remove User From Group';
                var modelIcon = 'trash';
                var modelCloseButtonId = 'btn-delete-userfromgroupform-close';

                BootstrapDialog.show({
                    title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                    type: BootstrapDialog.TYPE_DANGER,
                    description: "Loading Remove User From Group Form",
                    message: 'Are you sure to delete this user from group ?',
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
                                $.post('/admin/group/POSTDeleteUserFromGroup', { userId: id }, function(result) {
                                    returnResult = parseInt(result.replace(/\s/g, ''));
                                    if (returnResult === 1) {
                                        dialog.getModalBody().html('Request successful!');
                                        dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                        // Reload table
                                        PHPEasy.Page.Sitemap.Admin.Group.UserInGroup.Table.ajax.reload(null, false);
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
        }
    }
};

(function($) {
    PHPEasy.Page.Sitemap.Admin.Group.UserInGroup.Init.Table();
})(jQuery);