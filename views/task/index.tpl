<div class="jumbotron">
    {include file="components/pagination.tpl"}

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
                <td><b><a href="{$view->url("/task/edit/`$task.id`")}" target="_blank">#{$task.id}</a></b></td>
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
</div>

