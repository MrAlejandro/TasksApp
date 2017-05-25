    {var_dump($pagination)}
<nav aria-label="pagination">
    <ul class="pagination">

    {if $pagination.prev_page}
        <li class="page-item">
            <a class="page-link" href="{$view->url("/?page=`$pagination.prev_page`&items_per_page=`$pagination.items_per_page`")}" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
            </a>
        </li>
    {/if}

    {assign var="items" value=min(9, $pagination.pages)}

    {if $items < $pagination.pages}
        {assign var="first_pages" value=3}
        {assign var="last_pages" value=2}

        {for $page=1 to $first_pages}
            {assign var="is_current_page" value=$pagination.page == $page}

            <li class="page-item {if $is_current_page}active{/if}">
                <a class="page-link" href="{if $is_current_page}#{else}{$view->url("/?page=`$page`&items_per_page=`$pagination.items_per_page`")}{/if}">{$page}</a>
            </li>
        {/for}

        {if $pagination.page > $first_pages+1 && $pagination.page > ($pagination.page-$last_pages)}

            {if $pagination.page > $first_pages+2}
                <li class="page-item">
                    <a class="page-link" href="#" onclick="return false;">...</a>
                </li>
            {/if}

            {for $page=($pagination.page-1) to ($pagination.page+1)}
                {assign var="is_current_page" value=$pagination.page == $page}

                <li class="page-item {if $is_current_page}active{/if}">
                    <a class="page-link" href="{if $is_current_page}#{else}{$view->url("/?page=`$page`&items_per_page=`$pagination.items_per_page`")}{/if}">{$page}</a>
                </li>
            {/for}

            {if $pagination.page > ($pagination.page-($last_pages+1))}
                <li class="page-item">
                    <a class="page-link" href="#" onclick="return false;">...</a>
                </li>
            {/if}
        {else}
            <li class="page-item">
                <a class="page-link" href="#" onclick="return false;">...</a>
            </li>
        {/if}


        {for $page=($pagination.pages-$last_pages) to $pagination.pages}
            {assign var="is_current_page" value=$pagination.page == $page}

            <li class="page-item {if $is_current_page}active{/if}">
                <a class="page-link" href="{if $is_current_page}#{else}{$view->url("/?page=`$page`&items_per_page=`$pagination.items_per_page`")}{/if}">{$page}</a>
            </li>
        {/for}
    {else}

        {for $page=1 to $items}
            {assign var="is_current_page" value=$pagination.page == $page}

            <li class="page-item {if $is_current_page}active{/if}">
                <a class="page-link" href="{if $is_current_page}#{else}{$view->url("/?page=`$page`&items_per_page=`$pagination.items_per_page`")}{/if}">{$page}</a>
            </li>
        {/for}

    {/if}

    {if $pagination.next_page <= $pagination.pages}
        <li class="page-item">
            <a class="page-link" href="{$view->url("/?page=`$pagination.next_page`&items_per_page=`$pagination.items_per_page`")}" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
            </a>
        </li>
    {/if}

    </ul>
</nav>
