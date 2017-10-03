(function($) {
    $('*[data-toggle="toggle"]').bootstrapToggle();
    $('.permission-group-input').change(function(e) {
        var page = parseInt($(this).data('page'));
        var group = parseInt($(this).data('group'));
        var permission = parseInt($(this).val());
        var data = { functionId: page, groupId: group, permissionValue: permission };
        if ($(this).prop('checked')) {
            $.post('/admin/page/POSTSetFuncGroupPerm', data, function(result) {
                returnResult = parseInt(result.replace(/\s/g, ''));
                if (returnResult === 1) {
                    PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Success();
                } else {
                    PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Fail(result);
                }
                // // Reload table -> It works but make non sense, it should let's the users config again and not disappear
                // pageGroupPermissionTable.ajax.reload(null, false);
            });
        } else {
            $.post('/admin/page/POSTDeleteFuncGroupPerm', data, function(result) {
                returnResult = parseInt(result.replace(/\s/g, ''));
                if (returnResult === 1) {
                    PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Success();
                } else {
                    PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Fail(result);
                }
                // // Reload table
                // pageGroupPermissionTable.ajax.reload(null, false);
            });
        }
    });
})(jQuery);