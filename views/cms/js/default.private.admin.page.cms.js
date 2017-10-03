// Test
var bsTooltip = $.fn.tooltip;
var bsButton = $.fn.button;
$.widget.bridge('uibutton', $.ui.button);
$.widget.bridge('uitooltip', $.ui.tooltip);
$.fn.tooltip = bsTooltip;
$.fn.button = bsButton;

// Init
(function($) { // TODO: Button to update class only :)
    $('#cms-content').keditor({
        tabTooltipEnabled: false,
        snippetsTooltipEnabled: false,
        containerSettingEnabled: true,
        containerSettingInitFunction: function(form) {
            form.append(
                '<form class="form-horizontal">' +
                '   <div class="form-group">' +
                '       <div class="col-sm-12">' +
                '           <label for="container-class"><b>Class:</b></label>' +
                '           <input type="text" class="form-control" id="container-class">' +
                '       </div>' +
                '   </div>' +
                '   <hr>' +
                '   <div class="form-group">' +
                '       <div class="col-sm-12">' +
                '           <label for="column-divide"><b>Code Render Column:</b> <a target="_blank" href="https://jsfiddle.net/rpox8052/32/" data-toggle="tooltip" title="Click me to get example :)"><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>' +
                '           <input type="text" class="form-control" id="column-divide" value="{3:{6:12,12:12},6:12,9:12,12:{3:12,6:12,12:12}}">' +
                '       </div>' +
                '   </div>' +
                '   <hr>' +
                '   <div class="form-group">' +
                '       <div class="col-sm-12">' +
                '           <button type="button" class="btn btn-block btn-success btn-slide-submit">Submit</button>' +
                '       </div>' +
                '   </div>' +
                '</form>'
            );



        },
        containerSettingShowFunction: function(form) {
            var classOfChild = this.getSettingContainer().find('.keditor-container-inner').children();
            var motherClass = classOfChild.attr('class');
            // Append Mother Class
            form.find('#container-class').val(motherClass);

            var submitBtn = form.find('.btn-slide-submit');
            submitBtn.on('click', function(e) {
                e.preventDefault();
                // Prompt
                if (confirm('In other to update container, all element inside container will gone, and this page will save and refresh! \n\nWould you like to continue?')) {
                    var columnDivideInput = form.find('#column-divide');
                    var valueOfDivide = '(' + columnDivideInput.val() + ')';
                    var convertToObject = eval(valueOfDivide);

                    // Change class
                    classOfChild.attr('class', form.find('#container-class').val());

                    // Create Column base on Code render
                    function createLayout(code) {
                        var layout = '';

                        function renderLayout(code) {
                            var lastKey = '';

                            $.each(code, function(key, value) {
                                if (value.constructor === Object) {
                                    layout += '<div class="col-sm-' + (key - lastKey) + '">';
                                    layout += '<div class="row">';
                                    renderLayout(value);
                                    layout += '</div>';
                                    layout += '</div>';
                                } else {
                                    layout += '<div class="col-sm-' + (key - lastKey) + '" data-type="container-content"></div>';
                                }
                                lastKey = key;
                            })
                        }
                        renderLayout(code);

                        return layout;
                    }

                    // Show
                    classOfChild.html(createLayout(convertToObject));
                    // Save it!
                    var content = $("#cms-content").keditor('getContent');
                    $.post('/admin/page/cms/POSTContent', { data: content, apply: false }, function() {
                        location.reload();
                    });
                }
            });


            // if (motherClass === 'row') {
            //     var classRow = classOfChild.children('div');
            // } else {
            //     var classRow = classOfChild.find('.row').children('div');
            // }

            // console.log(classRow.length);
        },
        containerSettingHideFunction: function(form) {
            // form.html('');
        },
        snippetsFilterEnabled: true,
        onReady: function() {
            $('.keditor-content-area').css('min-height', $(window).height());
        }
    });
})(jQuery);