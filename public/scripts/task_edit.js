(function ($) {
    var tagEditFormSendHandler = function () {
        $('#save_task_button').on('click', function (e) {
            var form = $('#task_edit_form');
            var url = form.attr('action');

            $.ajax({
                url: url,
                method: 'POST',
                data: form.serialize(),
                beforeSend: function( xhr ) {
                    // xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                }
            }).done(function (res) {
                console.log(res);
            });
        });
    };

    $(document).ready(function () {
        tagEditFormSendHandler();
    });
})($);
