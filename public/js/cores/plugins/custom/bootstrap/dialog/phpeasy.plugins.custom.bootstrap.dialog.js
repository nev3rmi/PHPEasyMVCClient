PHPEasy.Plugins.Custom.Bootstrap.Dialog = PHPEasy.Plugins.Custom.Bootstrap.Dialog || {};

PHPEasy.Plugins.Custom.Bootstrap.Dialog = {
    Alert: {
        Success: function() {
            BootstrapDialog.alert({
                title: 'Success',
                message: 'The Action has been done successful.',
                type: BootstrapDialog.TYPE_SUCCESS, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                closable: true, // <-- Default value is false
            });
            return BootstrapDialog;
        },
        Fail: function(message) {
            BootstrapDialog.alert({
                title: 'Failed',
                message: message,
                type: BootstrapDialog.TYPE_DANGER, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                closable: true, // <-- Default value is false
            });
            return BootstrapDialog;
        },
        Loading: function(message = 'Please Wait ...') {
            var dialog = new BootstrapDialog({
                title: '<i class="glyphicon glyphicon-refresh gly-spin" aria-hidden="true"></i> <b>Processing</b>',
                message: message,
                type: BootstrapDialog.TYPE_PRIMARY, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
                closable: true, // <-- Default value is false
            });
            dialog.open();
            return dialog;
        }
    }
}