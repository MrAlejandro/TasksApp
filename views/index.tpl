<!DOCTYPE HTML>
<html>
    {include file="components/head.tpl"}
    <body>
        <div class="container">
            {include file="components/menu.tpl"}

            {if !empty($render_template)}
                {include file=$render_template}
            {/if}

            {include file="components/footer.tpl"}
        <div class="container">

        {include file="components/scripts.tpl"}
    </body>
</html>
