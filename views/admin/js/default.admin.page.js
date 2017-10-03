PHPEasy.Page.Sitemap.Admin.Pages = PHPEasy.Page.Sitemap.Admin.Pages || {};
PHPEasy.Page.Sitemap.Admin.Pages = {
    Table: "",
    Init: {
        Table: function() {
            // Init Table
            var tableName = '#list-page';
            var tableColumnToGroup = 0;
            var colSpan = 5;
            var actionColumn = 5; // TODO: Will be auto in future

            var table = $(tableName).DataTable({
                "deferRender": true,
                "pagingType": "full_numbers",
                "columnDefs": [
                    { "visible": false, "targets": 0 },
                    {
                        "orderable": false,
                        "targets": actionColumn
                    }
                ],
                "order": [
                    [0, 'asc']
                ],
                "ajax": {
                    url: "/admin/page/GETJSONPageTables",
                    type: 'POST'
                },
                "columns": [{
                        "data": "ControllerName"
                    },
                    {
                        "data": "FunctionName"
                    },
                    { 
                        "data": "PageUrl" 
                    },
                    { 
                        "data": "ParentName" 
                    },
                    { 
                        "data": "ParentUrl" 
                    },
                    { 
                        "data": "Action" 
                    }
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

                    // Apply On click order group
                    DataTableCustomize.onClickGroup(table, tableName, tableColumnToGroup);


                    // Apply Search By Column
                    DataTableCustomize.applySearchBox(table);

                    // Apply Live Ajax
                    DataTableCustomize.applyLiveAjax(table, 30000); // Check if user action or not if not then allow to refresh else extend.

                },
                "drawCallback": function(settings) {
                    DataTableCustomize.paginate_button(tableName);
                    // ApplyGrouping(this.api(), tableColumnToGroup, colSpan, 'Controller', 'files-o');
                    DataTableCustomize.applyGrouping(this.api(), tableColumnToGroup, colSpan, 'Controller', 'files-o', 'group', true, 'controllerInit', 'Edit Controller', 'controller', '/admin/controller/POSTInsertUpdateController', 'inline', 'PHPEasy.Page.Sitemap.Admin.Pages.Controller.deleteController');
                    DataTableCustomize.applyTooltip();
                }
            });

            PHPEasy.Page.Sitemap.Admin.Pages.Table = table
        }
    },
    Page: {
        getFormToAddUpdatePage: function(id = 0) {
            var modalName = null;
            var modelIcon = null;
            var modelCloseButtonId = 'btn-addupdate-pageform-close-' + id;

            if (id === 0) {
                modalName = 'New Page';
                modelIcon = 'plus';
            } else {
                modalName = 'Edit Page [ID: ' + id + ']';
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
                    'pageToLoad': '/admin/page/FORMAddUpdatePage/FunctionId=' + id
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
                        var data = $('#formAddUpdatePages').serialize();
                        data = data + '&functionId=' + id;
                        // Initiate Modal: disallow to close and disable buttons
                        dialog.enableButtons(false);
                        dialog.setClosable(false);
                        dialog.getModalBody().html('Request processing...');
                        $.post('/admin/page/POSTInsertUpdatePage', data, function(result) {
                            returnResult = parseInt(result.replace(/\s/g, ''));
                            if (returnResult === 1) {
                                dialog.getModalBody().html('Request successful!');
                                dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                // Reload table
                                PHPEasy.Page.Sitemap.Admin.Pages.Table.ajax.reload(null, false);
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
        },

        deletePage: function(id) {
            var modalName = 'Delete Page [ID: ' + id + ']';
            var modelIcon = 'trash';
            var modelCloseButtonId = 'btn-delete-pageform-close-' + id;

            BootstrapDialog.show({
                title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                type: BootstrapDialog.TYPE_DANGER,
                description: "Loading Page's Form",
                message: 'Are you sure to delete this page ?',
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
                            $.post('/admin/page/POSTDeletePage', { "functionId": id }, function(result) {
                                returnResult = parseInt(result.replace(/\s/g, ''));
                                if (returnResult === 1) {
                                    dialog.getModalBody().html('Request successful!');
                                    dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                    // Reload table
                                    PHPEasy.Page.Sitemap.Admin.Pages.Table.ajax.reload(null, false);
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
        },

        getPermissionGroup: function(id) {
            var modalName = "Page's Permission [ID: " + id + "]";
            var modelIcon = 'lock';
            var modelCloseButtonId = 'btn-groupperm-pageform-close-' + id;

            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_PRIMARY,
                size: BootstrapDialog.SIZE_WIDE,
                title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                description: "Loading Controller's Form",
                message: function(dialog) {
                    var $message = $('<div>Loading...</div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    // Load Page
                    $message.load(pageToLoad);
                    return $message;
                },
                data: {
                    'pageToLoad': '/admin/page/GETPageGroupPermission/PageId=' + id
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
        CMS: {
            Table: {},
            showListOfContent: function(id) {
                var modalName = "Page's Content [ID: " + id + "]";
                var modelIcon = 'floppy-disk';
                var modelCloseButtonId = 'btn-content-pageform-close-' + id;

                BootstrapDialog.show({
                    type: BootstrapDialog.TYPE_WARNING,
                    size: BootstrapDialog.SIZE_WIDE,
                    title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                    description: "Loading page content form",
                    message: function(dialog) {
                        var $message = $('<div>Loading...</div>');
                        var pageToLoad = dialog.getData('pageToLoad');
                        // Load Page
                        $message.load(pageToLoad);
                        return $message;
                    },
                    data: {
                        'pageToLoad': '/admin/page/cms/index/PageId=' + id
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
            Init: {
                Table: function() {
                    // Init Table
                    var tableName = '#list-page-stage-content';
                    var tableColumnToGroup = 0;
                    var colSpan = 3;
                    var actionColumn = 4; // TODO: Will be auto in future
                    // Init
                    var buttonIcon = new Array();
                    var buttonName = new Array();
                    // Button Custom
                    buttonIcon[0] = 'plus';
                    buttonName[0] = 'Page Content';

                    buttonIcon[1] = 'eye-open';
                    buttonName[1] = 'View Page Content';
                    // Get FunctionId
                    var functionId = $(tableName).data();

                    var table = $(tableName).DataTable({
                        "deferRender": true,
                        "pagingType": "full_numbers",
                        "columnDefs": [{
                            "orderable": false,
                            "targets": actionColumn
                        }],
                        "order": [
                            [0, 'asc']
                        ],
                        "ajax": {
                            url: "/admin/page/cms/GETJSONPageContentTable",
                            type: 'POST'
                        },
                        "columns": [{
                                "data": "StageName"
                            },
                            {
                                "data": "StageDescription"
                            },
                            {
                                "data": "Email"
                            },
                            {
                                "data": "LanguageName"
                            },
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
                                PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Action().Create();
                            }
                        }, {
                            text: '<i class="glyphicon glyphicon-' + buttonIcon[1] + '" aria-hidden="true"></i> <b>' + buttonName[1] + '</b>',
                            className: 'btn btn-info',
                            action: function(e, dt, node, config) {
                                $.post('/admin/page/cms/QUICKGETFunctionId', {}, function(result) {
                                    result = parseInt(result);
                                    var url = $('a[data-view-page-id="' + result + '"]').attr("href");
                                    window.open(url, '_blank');
                                })
                            }
                        }]
                    });

                    PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Table = table
                }
            },
            Action: function() {
                var _action = function(PageStageId = 0) {
                    var modalName = "Page's Content";
                    var modelIcon = 'blackboard';
                    var modelCloseButtonId = 'btn-addUpdatePageContent-pageform-close';

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
                            'pageToLoad': '/admin/page/cms/FORMAddUpdatePageContent/PageStageId=' + PageStageId
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
                                var data = $('#formAddUpdatePagesContent').serialize();
                                // Initiate Modal: disallow to close and disable buttons
                                dialog.enableButtons(false);
                                dialog.setClosable(false);
                                dialog.getModalBody().html('Request processing...');
                                $.post('/admin/page/cms/POSTAddUpdatePageContent', data, function(result) {
                                    returnResult = parseInt(result.replace(/\s/g, ''));
                                    if (returnResult === 1) {
                                        dialog.getModalBody().html('Request successful!');
                                        dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                        // Reload table
                                        PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Table.ajax.reload(null, false);
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
                return {
                    Create: function() {
                        _action();
                    },
                    Edit: function(id) {
                        _action(id);
                    },
                    Delete: function(id) {
                        var modalName = 'Delete Page Content [ID: ' + id + ']';
                        var modelIcon = 'trash';
                        var modelCloseButtonId = 'btn-delete-pagecontent-close-' + id;

                        BootstrapDialog.show({
                            title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                            type: BootstrapDialog.TYPE_DANGER,
                            description: "Loading Delete Page Content's Form",
                            message: 'Are you sure to delete this page content?',
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
                                        $.post('/admin/page/cms/POSTDeletePageContent', { "FunctionStageId": id }, function(result) {
                                            returnResult = parseInt(result.replace(/\s/g, ''));
                                            if (returnResult === 1) {
                                                dialog.getModalBody().html('Request successful!');
                                                dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                                // Reload table
                                                PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Table.ajax.reload(null, false);
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
                    },
                    Apply: function(id) {
                        var modalName = 'Apply Page Content [ID: ' + id + ']';
                        var modelIcon = 'ok';
                        var modelCloseButtonId = 'btn-ok-pagecontent-close-' + id;

                        BootstrapDialog.show({
                            title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                            type: BootstrapDialog.TYPE_SUCCESS,
                            description: "Loading Apply Page Content's Form",
                            message: 'Are you sure to apply this page content?',
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
                                    cssClass: 'btn-success',
                                    autospin: true,
                                    hotkey: 13,
                                    action: function(dialog) {
                                        dialog.enableButtons(false);
                                        dialog.setClosable(false);
                                        $.post('/admin/page/cms/POSTApplyPageContent', { "FunctionStageId": id }, function(result) {
                                            returnResult = parseInt(result.replace(/\s/g, ''));
                                            if (returnResult === 1) {
                                                dialog.getModalBody().html('Request successful!');
                                                dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                                // Reload table
                                                PHPEasy.Page.Sitemap.Admin.Pages.Page.CMS.Table.ajax.reload(null, false);
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
            },
            Content: function() {
                var _getContent = function(stageId, msg, apply = false) {
                    var content = $("#cms-content").keditor('getContent');
                    // TODO: get ID in here.
                    
                    // $.post('/admin/page/cms/POSTContent', { data: content }, function(result) {
                    //     console.log(result);
                    // });

                    var modalName = 'Save Content';
                    var modelIcon = 'ok';
                    var modelCloseButtonId = 'btn-savecontent-pageform-close';

                    // console.log(content);

                    BootstrapDialog.show({
                        title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                        type: BootstrapDialog.TYPE_PRIMARY,
                        description: "Loading Page's Form",
                        message: msg,
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
                                cssClass: 'btn-success',
                                autospin: true,
                                hotkey: 13,
                                action: function(dialog) {
                                    dialog.enableButtons(false);
                                    dialog.setClosable(false);
                                    $.post('/admin/page/cms/POSTContent', { stageId: stageId, data: content, apply: apply }, function(result) {
                                        returnResult = parseInt(result.replace(/\s/g, ''));
                                        if (returnResult === 1 || returnResult == null) {
                                            dialog.getModalBody().html('Request successful!');
                                            dialog.setType(BootstrapDialog.TYPE_SUCCESS);
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
                return {
                    Save: function(stageId) {
                        _getContent(stageId, 'Are you sure to save this content ?');
                    },
                    Apply: function(stageId) {
                        _getContent(stageId, 'Are you sure to save and apply this content ?', true);
                    }
                }
            }
        },
        editContent: function(url) {
            window.location = '/admin/page/cms/editpage/url=' + url;
        },

        viewSiteMap: function (){
            var modalName = "Sitemap";
            var modelIcon = 'sitemap';
            var modelCloseButtonId = 'btn-content-sitemap';

            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_INFO,
                size: BootstrapDialog.SIZE_WIDE,
                title: '<i class="fa fa-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                description: "Loading page content form",
                message: function(dialog) {
                    var $message = $('<div>Loading...</div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    // Load Page
                    $message.load(pageToLoad);
                    return $message;
                },
                data: {
                    'pageToLoad': '/admin/page/sitemap'
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
    Controller: {
        getFormToAddUpdateController: function(id = 0) {
            var modalName = null;
            var modelIcon = null;
            var modelCloseButtonId = 'btn-addupdate-controllerform-close-' + id;

            if (id === 0) {
                modalName = 'New Controller';
                modelIcon = 'plus';
            } else {
                modalName = 'Edit Controller [ID: ' + id + ']';
                modelIcon = 'pencil';
            }

            BootstrapDialog.show({
                title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                type: BootstrapDialog.TYPE_DEFAULT,
                description: "Loading Controller's Form",
                message: function(dialog) {
                    var $message = $('<div>Loading...</div>');
                    var pageToLoad = dialog.getData('pageToLoad');
                    // Load Page
                    $message.load(pageToLoad);
                    return $message;
                },
                data: {
                    'pageToLoad': '/admin/controller/FORMInsertNewController/ControllerId=' + id
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
                        var data = $('#formNewController').serialize();
                        data = data + '&controllerId=' + id;
                        // Initiate Modal: disallow to close and disable buttons
                        dialog.enableButtons(false);
                        dialog.setClosable(false);
                        dialog.getModalBody().html('Request processing...');
                        $.post('/admin/controller/POSTInsertUpdateController', data, function(result) {
                            returnResult = parseInt(result.replace(/\s/g, ''));
                            if (returnResult === 1) {
                                dialog.getModalBody().html('Request successful!');
                                dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                // Reload table
                                PHPEasy.Page.Sitemap.Admin.Pages.Table.ajax.reload(null, false);
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
        },

        deleteController: function() {
            var id = $('.editable-open').data('pk');
            var modalName = 'Delete Controller [ID: ' + id + ']';
            var modelIcon = 'trash';
            var modelCloseButtonId = 'btn-delete-controllerform-close-' + id;

            BootstrapDialog.show({
                title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
                type: BootstrapDialog.TYPE_DANGER,
                description: "Loading Controller's Form",
                message: 'Are you sure to delete this controller ?',
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
                            $.post('/admin/controller/POSTDeleteController', { "controllerId": id }, function(result) {
                                returnResult = parseInt(result.replace(/\s/g, ''));
                                if (returnResult === 1) {
                                    dialog.getModalBody().html('Request successful!');
                                    dialog.setType(BootstrapDialog.TYPE_SUCCESS);
                                    // Reload table
                                    PHPEasy.Page.Sitemap.Admin.Pages.Table.ajax.reload(null, false);
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
};




// var PrivateAdminPageTable = (function($) {
//     // Init Table
//     var tableName = '#list-page';
//     var tableColumnToGroup = 0;
//     var colSpan = 3;
//     var actionColumn = 3; // TODO: Will be auto in future

//     var table = $(tableName).DataTable({
//         "deferRender": true,
//         "pagingType": "full_numbers",
//         "columnDefs": [
//             { "visible": false, "targets": 0 },
//             {
//                 "orderable": false,
//                 "targets": actionColumn
//             }
//         ],
//         "order": [
//             [0, 'asc']
//         ],
//         "ajax": {
//             url: "/admin/page/GETJSONPageTables",
//             type: 'POST'
//         },
//         "columns": [{
//                 "data": "ControllerName"
//             },
//             {
//                 "data": "FunctionName"
//             },
//             { "data": "PageUrl" },
//             { "data": "Action" }
//         ],
//         "rowId": "PageRowId",
//         "initComplete": function(settings, json) {
//             // Add Search box
//             DataTableCustomize.addSearchBoxOnEachColumn(tableName);

//             // Custom Search box
//             DataTableCustomize.removeContentWithoutChild(tableName + '_filter label');
//             DataTableCustomize.datatableCustom(tableName + '_filter input', 250, 'fa fa-search');

//             // List item per page box
//             DataTableCustomize.removeContentWithoutChild(tableName + '_length label');
//             DataTableCustomize.datatableCustom(tableName + '_length select', 125, 'fa fa-eye');

//             // Apply On click order group
//             DataTableCustomize.onClickGroup(table, tableName, tableColumnToGroup);


//             // Apply Search By Column
//             DataTableCustomize.applySearchBox(table);

//             // Apply Live Ajax
//             DataTableCustomize.applyLiveAjax(table, 30000); // Check if user action or not if not then allow to refresh else extend.

//         },
//         "drawCallback": function(settings) {
//             DataTableCustomize.paginate_button(tableName);
//             // ApplyGrouping(this.api(), tableColumnToGroup, colSpan, 'Controller', 'files-o');
//             DataTableCustomize.applyGrouping(this.api(), tableColumnToGroup, colSpan, 'Controller', 'files-o', 'group', true, 'controllerInit', 'Edit Controller', 'controller', '/admin/controller/POSTInsertUpdateController', 'inline', 'PrivateControllerControl.deleteController');
//             DataTableCustomize.applyTooltip();
//         }
//     });

//     return table;
// })(jQuery);

// var PrivatePageControl = {
//     getFormToAddUpdatePage: function(id = 0) {
//         var modalName = null;
//         var modelIcon = null;
//         var modelCloseButtonId = 'btn-addupdate-pageform-close-' + id;

//         if (id === 0) {
//             modalName = 'New Page';
//             modelIcon = 'plus';
//         } else {
//             modalName = 'Edit Page [ID: ' + id + ']';
//             modelIcon = 'pencil';
//         }

//         BootstrapDialog.show({
//             title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
//             type: BootstrapDialog.TYPE_DEFAULT,
//             description: "Loading Page's Form",
//             message: function(dialog) {
//                 var $message = $('<div></div>');
//                 var pageToLoad = dialog.getData('pageToLoad');
//                 $message.load(pageToLoad);
//                 return $message;
//             },
//             data: {
//                 'pageToLoad': '/admin/page/FORMAddUpdatePage/FunctionId=' + id
//             },
//             buttons: [{
//                 id: modelCloseButtonId,
//                 label: 'Close',
//                 cssClass: 'btn-default',
//                 action: function(dialog) {
//                     dialog.close();
//                 }
//             }, {
//                 label: 'Save',
//                 icon: 'glyphicon glyphicon-save',
//                 cssClass: 'btn-success',
//                 hotkey: 13,
//                 autospin: true,
//                 action: function(dialog) {
//                     // Get Data
//                     var data = $('#formAddUpdatePages').serialize();
//                     data = data + '&functionId=' + id;
//                     // Initiate Modal: disallow to close and disable buttons
//                     dialog.enableButtons(false);
//                     dialog.setClosable(false);
//                     dialog.getModalBody().html('Request processing...');
//                     $.post('/admin/page/POSTInsertUpdatePage', data, function(result) {
//                         returnResult = parseInt(result.replace(/\s/g, ''));
//                         if (returnResult === 1) {
//                             dialog.getModalBody().html('Request successful!');
//                             dialog.setType(BootstrapDialog.TYPE_SUCCESS);
//                             // Reload table
//                             PrivateAdminPageTable.ajax.reload(null, false);
//                             // Time out dialog
//                             setTimeout(function() {
//                                 dialog.close();
//                             }, 500);
//                         } else {
//                             dialog.getModalBody().html(result);
//                             dialog.setType(BootstrapDialog.TYPE_DANGER);
//                             dialog.getButton(modelCloseButtonId).enable();
//                             dialog.setClosable(true);
//                         }
//                     })
//                 }
//             }]
//         });
//     },

//     deletePage: function(id) {
//         var modalName = 'Delete Page [ID: ' + id + ']';
//         var modelIcon = 'trash';
//         var modelCloseButtonId = 'btn-delete-pageform-close-' + id;

//         BootstrapDialog.show({
//             title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
//             type: BootstrapDialog.TYPE_DANGER,
//             description: "Loading Page's Form",
//             message: 'Are you sure to delete this page ?',
//             buttons: [{
//                     id: modelCloseButtonId,
//                     label: 'Close',
//                     cssClass: 'btn-default',
//                     action: function(dialog) {
//                         dialog.close();
//                     }
//                 },
//                 {
//                     label: 'OK',
//                     cssClass: 'btn-danger',
//                     autospin: true,
//                     hotkey: 13,
//                     action: function(dialog) {
//                         dialog.enableButtons(false);
//                         dialog.setClosable(false);
//                         $.post('/admin/page/POSTDeletePage', { "functionId": id }, function(result) {
//                             returnResult = parseInt(result.replace(/\s/g, ''));
//                             if (returnResult === 1) {
//                                 dialog.getModalBody().html('Request successful!');
//                                 dialog.setType(BootstrapDialog.TYPE_SUCCESS);
//                                 // Reload table
//                                 PrivateAdminPageTable.ajax.reload(null, false);
//                                 // Time out dialog
//                                 setTimeout(function() {
//                                     dialog.close();
//                                 }, 500);
//                             } else {
//                                 dialog.getModalBody().html(result);
//                                 dialog.setType(BootstrapDialog.TYPE_DANGER);
//                                 dialog.getButton(modelCloseButtonId).enable();
//                                 dialog.setClosable(true);
//                             }
//                         });
//                     }
//                 }
//             ]
//         });
//     },

//     getPermissionGroup: function(id) {
//         var modalName = "Page's Permission [ID: " + id + "]";
//         var modelIcon = 'lock';
//         var modelCloseButtonId = 'btn-groupperm-pageform-close-' + id;

//         BootstrapDialog.show({
//             type: BootstrapDialog.TYPE_PRIMARY,
//             size: BootstrapDialog.SIZE_WIDE,
//             title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
//             description: "Loading Controller's Form",
//             message: function(dialog) {
//                 var $message = $('<div>Loading...</div>');
//                 var pageToLoad = dialog.getData('pageToLoad');
//                 // Load Page
//                 $message.load(pageToLoad);
//                 return $message;
//             },
//             data: {
//                 'pageToLoad': '/admin/page/GETPageGroupPermission/PageId=' + id
//             },
//             buttons: [{
//                 id: modelCloseButtonId,
//                 label: 'Close',
//                 cssClass: 'btn-default',
//                 action: function(dialog) {
//                     dialog.close();
//                 }
//             }]
//         });
//     }
// };

// var PrivateControllerControl = {
//     getFormToAddUpdateController: function(id = 0) {
//         var modalName = null;
//         var modelIcon = null;
//         var modelCloseButtonId = 'btn-addupdate-controllerform-close-' + id;

//         if (id === 0) {
//             modalName = 'New Controller';
//             modelIcon = 'plus';
//         } else {
//             modalName = 'Edit Controller [ID: ' + id + ']';
//             modelIcon = 'pencil';
//         }

//         BootstrapDialog.show({
//             title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
//             type: BootstrapDialog.TYPE_DEFAULT,
//             description: "Loading Controller's Form",
//             message: function(dialog) {
//                 var $message = $('<div>Loading...</div>');
//                 var pageToLoad = dialog.getData('pageToLoad');
//                 // Load Page
//                 $message.load(pageToLoad);
//                 return $message;
//             },
//             data: {
//                 'pageToLoad': '/admin/controller/FORMInsertNewController/ControllerId=' + id
//             },
//             buttons: [{
//                 id: modelCloseButtonId,
//                 label: 'Close',
//                 cssClass: 'btn-default',
//                 action: function(dialog) {
//                     dialog.close();
//                 }
//             }, {
//                 label: 'Save',
//                 icon: 'glyphicon glyphicon-save',
//                 cssClass: 'btn-success',
//                 hotkey: 13,
//                 autospin: true,
//                 action: function(dialog) {
//                     // Get Data
//                     var data = $('#formNewController').serialize();
//                     data = data + '&controllerId=' + id;
//                     // Initiate Modal: disallow to close and disable buttons
//                     dialog.enableButtons(false);
//                     dialog.setClosable(false);
//                     dialog.getModalBody().html('Request processing...');
//                     $.post('/admin/controller/POSTInsertUpdateController', data, function(result) {
//                         returnResult = parseInt(result.replace(/\s/g, ''));
//                         if (returnResult === 1) {
//                             dialog.getModalBody().html('Request successful!');
//                             dialog.setType(BootstrapDialog.TYPE_SUCCESS);
//                             // Reload table
//                             PrivateAdminPageTable.ajax.reload(null, false);
//                             // Time out dialog
//                             setTimeout(function() {
//                                 dialog.close();
//                             }, 500);
//                         } else {
//                             dialog.getModalBody().html(result);
//                             dialog.setType(BootstrapDialog.TYPE_DANGER);
//                             dialog.getButton(modelCloseButtonId).enable();
//                             dialog.setClosable(true);
//                         }
//                     })
//                 }
//             }]
//         });
//     },

//     deleteController: function() {
//         var id = $('.editable-open').data('pk');
//         var modalName = 'Delete Controller [ID: ' + id + ']';
//         var modelIcon = 'trash';
//         var modelCloseButtonId = 'btn-delete-controllerform-close-' + id;

//         BootstrapDialog.show({
//             title: '<i class="glyphicon glyphicon-' + modelIcon + '" aria-hidden="true"></i> <b>' + modalName + '</b>',
//             type: BootstrapDialog.TYPE_DANGER,
//             description: "Loading Controller's Form",
//             message: 'Are you sure to delete this controller ?',
//             buttons: [{
//                     id: modelCloseButtonId,
//                     label: 'Close',
//                     cssClass: 'btn-default',
//                     action: function(dialog) {
//                         dialog.close();
//                     }
//                 },
//                 {
//                     label: 'OK',
//                     cssClass: 'btn-danger',
//                     autospin: true,
//                     hotkey: 13,
//                     action: function(dialog) {
//                         dialog.enableButtons(false);
//                         dialog.setClosable(false);
//                         $.post('/admin/controller/POSTDeleteController', { "controllerId": id }, function(result) {
//                             returnResult = parseInt(result.replace(/\s/g, ''));
//                             if (returnResult === 1) {
//                                 dialog.getModalBody().html('Request successful!');
//                                 dialog.setType(BootstrapDialog.TYPE_SUCCESS);
//                                 // Reload table
//                                 PrivateAdminPageTable.ajax.reload(null, false);
//                                 // Time out dialog
//                                 setTimeout(function() {
//                                     dialog.close();
//                                 }, 500);
//                             } else {
//                                 dialog.getModalBody().html(result);
//                                 dialog.setType(BootstrapDialog.TYPE_DANGER);
//                                 dialog.getButton(modelCloseButtonId).enable();
//                                 dialog.setClosable(true);
//                             }
//                         });
//                     }
//                 }
//             ]
//         });
//     }
// };