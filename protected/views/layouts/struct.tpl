{extends './struct_base.tpl'}

{block 'head'}
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css" />
    {block 'css-ext'}
    {/block}
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/js/json2.js"></script>
    <script type="text/javascript" src="/js/underscore-min.js"></script>
    <script type="text/javascript" src="/js/backbone-min.js"></script>
    <script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
    {block 'js-ext'}
        <script type="text/javascript" src="/js/app.js"></script>
    {/block}
{/block}

{block 'body'}
    <div class="container" id="page">

        <div id="header">
            {block 'header'}
                <div id="logo">
                    {#appname#}
                </div>
            {/block}
        </div>

        <div id="mainmenu">
            {block 'mainmenu'}
            {/block}
        </div>

        <div id="content">
            {block 'content'}
            {/block}
        </div>

        <div id="footer">
            {block 'footer'}
                Copyright &copy; {'Y'|date} by {#company#}.<br/>
                All Rights Reserved.<br/>
            {/block}
        </div>

    </div>
{/block}
