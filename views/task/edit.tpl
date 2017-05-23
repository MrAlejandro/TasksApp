<div class="jumbotron">
    <form action="{$edit_form_url}" method="POST" id="task_edit_form">
        <input type="hidden" name="task_id" value="{$task_data.id}" />

        <div class="form-group">
            <label for="task_name">{__("task_name")}</label>
            <input type="text" class="form-control" id="task_name" name="task_name" value="{$task_data.name}" />
        </div>

        <div class="form-group">
            <label for="task_priority">{__("task_priority")}</label>
            <select id="task_priority" class="form-control" name="task_priority">
                {foreach from=$priorities key="priority_id" item="priority_name"}
                    <option value="{$priority_id}" {if $priority_id == $task_data.priority}selected="selected"{/if}>{__($priority_name)}</option>
                {/foreach}
            </select>
        </div>

        <div class="form-group">
            <label for="task_status">{__("task_status")}</label>
            <select id="task_status" class="form-control" name="task_status">
                {foreach from=$statuses key="status_id" item="status_name"}
                    <option value="{$status_id}" {if $status_id == $task_data.status}selected="selected"{/if}>{__($status_name)}</option>
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
                <input type="hidden" name="task_tags[]" value="" disabled />
                <span class="task__tag-content">
                    <span class="glyphicon glyphicon-remove-sign task__tag-rmove-button" aria-hidden="true"></span>
                    <span class="task__tag-value"></span>
                </span>
                <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
            </div>

            {foreach from=$task_data.tags item="tag"}
                <div class="task__tags-containner" id="tag_template">
                    <input type="hidden" name="task_tags[]" value="{$tag}" />
                    <span class="task__tag-content">
                        <span class="glyphicon glyphicon-remove-sign task__tag-rmove-button" aria-hidden="true"></span>
                        <span class="task__tag-value">{$tag}</span>
                    </span>
                    <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                </div>
            {/foreach}

            <div class="task__no-tags {if $task_data.tags}hidden{/if}">
                {__("no_tags")}
            </div>
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-primary" id="save_task_button">{__("save")}</button>
        </div>
    </form>
</div>

