<nav aria-label="Page navigation example">
    <ul class="pagination">
    {if $pagination.prev_page}
        <li class="page-item">
            <a class="page-link" href="{$view->url("/?page=`$pagination.prev_page`&items_per_page=`$pagination.items_per_page`")}" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
            </a>
        </li>
    {/if}
	<li class="page-item active"><a class="page-link" href="#">1</a></li>
	<li class="page-item"><a class="page-link" href="#">2</a></li>
	<li class="page-item"><a class="page-link" href="#">3</a></li>
    {if $pagination.next_page < $pagination.pages}
        <li class="page-item">
            <a class="page-link" href="{$view->url("/?page=`$pagination.next_page`&items_per_page=`$pagination.items_per_page`")}" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
            </a>
        </li>
    {/if}
    </ul>
</nav>
