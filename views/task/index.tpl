<div class="jumbotron task__list-main-content">
    {capture name="pagination"}
        {include file="components/pagination.tpl"}
    {/capture}

    {$smarty.capture.pagination}

    <table class="table">
        <thead>
        <tr>
            <th>{__("id")}</th>
            <th>{__("name")}</th>
            <th>{__("status")}</th>
            <th>{__("priority")}</th>
            <th>{__("tags")}</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$tasks item="task"}
            <tr>
                <td><b><a href="{$view->url("/task/edit/`$task.uuid`")}" target="_blank">#{$task.id}</a></b></td>
                <td>{$task.name}</td>
                <td>{__($statuses[$task.status])}</td>
                <td>{__($priorities[$task.priority])}</td>
                <td>
                    {foreach from=$task.tags key="key" item="tag"}
                        {if $key === 'total'}
                            ...
                        {else}
                            <div class="task__tags-containner">
                                <span class="task__tag-content">
                                    <span class="task__tag-value">{$tag}</span>
                                </span>
                                <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                            </div>
                        {/if}
                    {/foreach}
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>

    {$smarty.capture.pagination}
</div>
<script type="text/javascript">

    var sendTaskPaginationAjaxRequest = function (elem)
    {
        var url = $(elem).data('pagination-url');

        if (url) {
            $.ajax({
                url: url + '&is_ajax=1',
                method: 'GET',
                timeout: 5000,
                beforeSend: function (xhr) {
                    $('#overlay, #loader').show();
                },
                error: function (xhr) {
                    $('#overlay, #loader').hide();
                },
            }).done(function (res) {
                if (res && typeof res === 'object' && 'html' in res) {
                    var container = $('.task__list-main-content')[0].outerHTML = res.html;

                    if (container.length) {
                        container[0].outerHTML = res.html;
                    }
                }

                $("#overlay, #loader").hide();
            });
        }
    }
</script>
