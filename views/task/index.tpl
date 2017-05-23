<div class="jumbotron">
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
                <td>{$task.status}</td>
                <td>{$task.priority}</td>
                <td>{$task.tags}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>

