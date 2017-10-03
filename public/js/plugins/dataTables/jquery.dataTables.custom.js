var DataTableCustomize = {
    // Custom page number button
    paginate_button: function(tableName) {
        $(tableName + '_paginate a').removeClass('active').addClass('btn btn-default').removeClass('paginate_button');
        $(tableName + '_paginate a.current').addClass('active');
    },

    removeContentWithoutChild: function(name) {
        $(name).contents().filter(function() {
            return (this.nodeType == 3);
        }).remove();
    },

    datatableCustom: function(name, width, icon) {
        $(name).unwrap();
        $(name).wrap('<div class="input-group" style="max-width: ' + width + 'px; margin: auto;"></div>');
        $(name).css("margin-left", "0");
        $(name).addClass('form-control');
        $(name).before('<span class="input-group-addon"><i class="' + icon + '" aria-hidden="true"></i></span>');
    },

    addSearchBoxOnEachColumn: function(tableName) {
        $(tableName + ' tfoot th').not('.dataTables_nosearch').not(':last-child').each(function() {
            var title = $(this).text();
            $(this).html('<div class="input-group"><span class="input-group-addon hidden-xs"><i class="fa fa-search" aria-hidden="true"></i></span><input class="' + tableName.replace('#', '') + '_searchBox form-control" type="text" placeholder="' + title + '" /></div>');
        });
    },

    applySearchBox: function(table) {
        // Apply the search
        table.columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        })
    },

    applyTooltip: function(tooltip = null) {
        if (tooltip !== null) {
            $(tooltip).tooltip();
        } else {
            $('[data-toggle="tooltip"]').tooltip();
        }
    },

    applyLiveAjax: function(table, time = 30000) {
        setInterval(function() {
            table.ajax.reload(null, false); // user paging is not reset on reload
        }, time);
    },

    // TODO: Need to refactor in future, just test 1.
    applyGrouping: function(tableAPI, columnToGroup, colspan = null, titleGroup = null, iconGroup = null, groupName = 'group', xEditable = false, xEditInitClass = null, xEditTitle = null, xEditPrimaryKey = null, xEditURLPost = null, xEditMode = 'inline', xEditDeleteButtonFn = null) { // TODO: Put Array Here xEditable 
        var rows = tableAPI.rows({ page: 'current' }).nodes();
        var last = null;
        var doRow = null;

        tableAPI.column(columnToGroup, { page: 'current' }).data().each(function(group, i) {
            if (last !== group) {
                doRow = $(rows).eq(i);

                if (!xEditable) {
                    doRow.before(
                        '<tr class="' + groupName + ' alert alert-info text-primary"><td colspan="' + colspan + '"><i class="fa fa-' + iconGroup + '" aria-hidden="true"></i> ' + titleGroup + ': <b>' + group + '</b><span class="pull-right"><i class="fa fa-arrow-up group-filter"></i></span></td></tr>'
                    );
                } else if (xEditable) {
                    getRowId = doRow.attr('id');
                    getEndPk = getRowId.match(xEditPrimaryKey + "_(.*)_");
                    explodeEndPk = getEndPk[1].split('_');
                    getPk = explodeEndPk[0];

                    doRow.before( // Not work
                        '<tr class="' + groupName + ' alert alert-info text-primary"><td colspan="' + colspan + '"><i class="fa fa-' + iconGroup + '" aria-hidden="true"></i> ' + titleGroup + ': <b><span>' +
                        '<a href="javascript:;" class="' + xEditInitClass + '" data-type="text" data-pk="' + getPk + '" data-url="' + xEditURLPost + '" data-title="' + xEditTitle + '">' + group + '</a>' +
                        '</span></b><span class="pull-right"><i class="fa fa-arrow-up group-filter"></i></span></td></tr>'
                    );
                    // TODO: Need to refactor + implement module + parameter.
                    // Init xEditable
                    $('.' + xEditInitClass).editable({ // Refactor HERE
                        "mode": xEditMode,
                        success: function(response, newValue) {
                            if (response.status == 'error') {
                                return response.msg; //msg will be shown in editable form
                            } else {
                                returnResult = parseInt(response.replace(/\s/g, ''));
                                if (returnResult === 1) {
                                    PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Success();
                                } else {
                                    PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Fail(response);
                                }
                                tableAPI.ajax.reload(null, false);
                            }
                        }
                    });

                    if (xEditDeleteButtonFn !== null) {
                        var xEditDeleteButtonFnInput = 'onclick="' + xEditDeleteButtonFn + '()"';
                    } else {
                        var xEditDeleteButtonFnInput = '';
                    }

                    $.fn.editableform.buttons = // Need to refactor to custom this.
                        '<button type="submit" class="btn btn-sm btn-success editable-submit"><i class="fa fa-check" aria-hidden="true"></i></button>' +
                        '<button type="button" class="btn btn-sm btn-danger editable-delete" ' + xEditDeleteButtonFnInput + '><i class="fa fa-trash" aria-hidden="true"></i></button>' +
                        '<button type="button" class="btn btn-sm btn-default editable-cancel"><i class="fa fa-times" aria-hidden="true"></i></button>';
                }
                last = group;
            }
        });
    },

    onClickGroup: function(table, tableName, columnToGroup, groupName = 'group') {
        // Order by the grouping
        $(tableName + ' tbody').on('click', 'tr.' + groupName + ' i.group-filter', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === columnToGroup && currentOrder[1] === 'asc') {
                table.order([columnToGroup, 'desc']).draw();
                $('.group-filter').addClass('fa-arrow-down').removeClass('fa-arrow-up');
            } else {
                table.order([columnToGroup, 'asc']).draw();
                $('.group-filter').addClass('fa-arrow-up').removeClass('fa-arrow-down');
            }
        });
    }
};