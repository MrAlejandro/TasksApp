(function ($) {
    var tagEditFormSendHandler = function () {
        var activeAjaxRequest = null;

        var showSuccessNotification = function ($message) {

            if ($message) {
                $html = '<div class="alert alert-success fade in alert-dismissable">'
                    + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'
                    + '<strong>Success!</strong> ' + $message
                    + '</div>';

                $('#notifications_container').html($html);
            }
        };

        var showErrorNotification = function ($message) {

            if ($message) {
                $html = '<div class="alert alert-danger fade in alert-dismissable">'
                    + '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'
                    + '<strong>Error!</strong> ' + $message
                    + '</div>';

                $('#notifications_container').html($html);
            }
        };

        $('#save_task_button').on('click', function (e) {

            if (activeAjaxRequest === null) {
                var form = $('#task_edit_form');
                var url = form.attr('action');

                activeAjaxRequest = $.ajax({
                    url: url,
                    method: 'POST',
                    timeout: 5000,
                    data: form.serialize(),
                    beforeSend: function (xhr) {
                        $('#overlay, #loader').show();
                    },
                    error: function (xhr) {
                        $('#overlay, #loader').hide();
                    },
                }).done(function (res) {

                    if (res && typeof res === 'object') {

                        if ('message' in res && res.message) {

                            if ('success' in res && res.success) {
                                showSuccessNotification(res.message);
                            } else {
                                showErrorNotification(res.message);
                            }
                        }
                    } else {
                        showErrorNotification('Error occured');
                    }

                    $("#overlay, #loader").hide();
                    activeAjaxRequest = null;
                });
            }
        });
    };

    $(document).ready(function () {
        tagEditFormSendHandler();
    });
})($);
