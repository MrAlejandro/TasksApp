<!DOCTYPE HTML>
<html>
    {include file="components/head.tpl"}
    <body>
        <div class="container">
            <div id="overlay"></div>
            <div id="loader"></div>

            {include file="components/menu.tpl"}

            <div id="notifications_container"></div>

            {if !empty($render_template)}
                {include file=$render_template}
            {/if}

            {include file="components/footer.tpl"}
        <div class="container">

        {include file="components/scripts.tpl"}
    </body>
</html>
