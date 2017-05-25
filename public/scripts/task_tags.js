(function ($) {

    var applyNewTagAdditionHandler = function ()
    {
        var tagTemplate = $('#tag_template');

        $('#add_tag_button').on('click touch', function (e) {
            var tagValue = $('#add_task_tag').val();

            if (tagTemplate.length == 1 && tagValue) {
                var tagTemplateClone = tagTemplate.clone();

                tagTemplateClone
                    .attr('id', '')
                    .removeClass('hidden');

                // set value into hidden input and the tag-vlaue element
                tagTemplateClone.find('.task__tag-value').text(tagValue);
                tagTemplateClone.find('input[name^="task_tag"]')
                    .prop('disabled', false)
                    .val(tagValue);

                // append new tag
                $('#tags_container').append(tagTemplateClone);

                $('.task__no-tags').hide();

                applyTagRemoveHandler();
            }

        });
    };

    var applyTagRemoveHandler = function ()
    {
        var tagRemoveButtons = $('.task__tags-containner .task__tag-rmove-button');

        tagRemoveButtons.off();
        tagRemoveButtons.on('click touch', function (e) {
            $(e.target).closest('.task__tags-containner').remove();

            var tagRemoveButtons = $('.task__tags-containner .task__tag-rmove-button');
            if (tagRemoveButtons.length <= 1) {
                $('.task__no-tags').show();
            }
        });
    };

    $(document).ready(function () {
        applyNewTagAdditionHandler();
        applyTagRemoveHandler();
    });
})(jQuery);
