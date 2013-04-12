{extends './struct_base.tpl'}

{block 'head'}
    <link rel="stylesheet" type="text/css" href="{$baseUrl}/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet/less" type="text/css" href="{$baseUrl}/css/app.less" />
    {block 'css-ext'}
    {/block}
    <script type="text/javascript" src="{$baseUrl}/js/less-1.3.3.min.js"></script>
    <script type="text/javascript" src="{$baseUrl}/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="{$baseUrl}/js/json2.js"></script>
    <script type="text/javascript" src="{$baseUrl}/js/underscore-min.js"></script>
    <script type="text/javascript" src="{$baseUrl}/js/backbone-min.js"></script>
    <script type="text/javascript" src="{$baseUrl}/bootstrap/js/bootstrap.min.js"></script>
    {block 'js-ext'}
        <!--
        <script type="text/javascript" src="{$baseUrl}/js/app.js"></script>
        -->
    {/block}
{/block}

{block 'body'}
    <div class="header">
        {block 'header'}
            <div class="logo">
                {#appname#}
            </div>
        {/block}
    </div>

    <div class="mainmenu">
        {block 'mainmenu'}
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand pull-right" href="{$homeUrl}">{#appname#}</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            {if $user}
                                <li class="">
                                    <a href="{$homeUrl}/public/logout">{#logout_title#}</a>
                                </li>
                            {else}
                                <li class="">
                                    <a href="{$homeUrl}/public/login">{#login_title#}</a>
                                </li>
                            {/if}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {/block}
    </div>

    <div class="content">
        {block 'content'}
        {/block}
    </div>

    <footer class="footer">
        <div class="container">
            {block 'footer'}
                <p>
                    Copyright &copy; {'Y'|date} by {#company#}.<br/>
                </p>
                <p>
                    All Rights Reserved.<br/>
                </p>
            {/block}
        </div>
    </footer>
{/block}
