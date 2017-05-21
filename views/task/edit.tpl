<div class="jumbotron">
    <form action="{$view->url("task/create")}" method="POST" id="task_edit_form">
        <div class="form-group">
            <label for="task_name">{__("task_name")}</label>
            <input type="text" class="form-control" id="task_name" />
        </div>

        <div class="form-group">
            <label for="task_priority">{__("task_priority")}</label>
            <select id="task_priority" class="form-control">
                {foreach from=$priorities key="priority_id" item="priority_name"}
                    <option value="{$priority_id}">{__($priority_name)}</option>
                {/foreach}
            </select>
        </div>

        <div class="form-group">
            <label for="task_status">{__("task_status")}</label>
            <select id="task_status" class="form-control">
                {foreach from=$statuses key="status_id" item="status_name"}
                    <option value="{$status_id}">{__($status_name)}</option>
                {/foreach}
            </select>
        </div>

        <div class="form-group">
            <label for="add_task_tag">{__("add_new_task_tag")}</label>
            <input type="text" class="form-control" id="add_task_tag" />
            <input class="btn btn-default btn-inline" id="add_tag_button" type="button" value="{__("add_task_tag")}">
        </div>

        <div class="form-group">
            <label >{__("task_tags")}</label>
        </div>

        <div id="tags_container">
            <div class="task__tags-containner hidden" id="tag_template">
                <input type="hidden" name="task_tag[]" value="" disabled />
                <span class="task__tag-content">
                    <span class="glyphicon glyphicon-remove-sign task__tag-rmove-button" aria-hidden="true"></span>
                    <span class="task__tag-value"></span>
                </span>
                <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
            </div>

            {if !empty($tags)}
                {foreach from=$tags item="value"}
                {/foreach}
            {else}
                <div class="task__no-tags">
                    {__("no_tags")}
                </div>
            {/if}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Sign in</button>
        </div>
    </form>
</div>

