<nav aria-label="pagination">
    <ul class="pagination">

    {if $pagination.prev_page}
        <li class="page-item">
            <span class="page-link" data-pagination-url="{$view->url("/?page=`$pagination.prev_page`&items_per_page=`$pagination.items_per_page`")}" aria-label="Previous" onclick="sendTaskPaginationAjaxRequest(this)">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
            </span>
        </li>
    {/if}

    {foreach from=$pagination.pagination key="i" item="page"}
        {assign var="link_text" value=$page}

        {if $page == -1}
            {assign var="link_text" value="..."}
            {assign var="page" value=$pagination.pagination[$i+1]-1}
        {elseif $page == 0}
            {assign var="link_text" value="..."}
            {assign var="page" value=$pagination.pagination[$i-1]+1}
        {/if}

        {assign var="is_current_page" value=$pagination.page == $page}

        <li class="page-item {if $is_current_page}active{/if}">
            <span class="page-link" data-pagination-url="{if !$is_current_page}{$view->url("/?page=`$page`&items_per_page=`$pagination.items_per_page`")}{/if}" onclick="sendTaskPaginationAjaxRequest(this)">{$link_text}</span>
        </li>
    {/foreach}

    {if $pagination.next_page <= $pagination.pages}
        <li class="page-item">
            <span class="page-link" data-pagination-url="{$view->url("/?page=`$pagination.next_page`&items_per_page=`$pagination.items_per_page`")}" aria-label="Next" onclick="sendTaskPaginationAjaxRequest(this)">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
            </span>
        </li>
    {/if}

    </ul>
</nav>
