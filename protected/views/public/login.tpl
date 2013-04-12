{extends '../layouts/struct.tpl'}

{block 'css-ext'}
    <link rel="stylesheet/less" type="text/css" href="{$baseUrl}/css/login.less" />
{/block}

{block 'content'}

<div class="login-page">
    <div class="modal">
        <div class="modal-header">
            <h3>{#login_title#}</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" action="authenticate" method="post">
                <div class="control-group">
                    <label class="control-label" for="username">{#username#}</label>
                    <div class="controls">
                        <input class="username" name="username" type="text" placeholder="{#username#}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password">{#password#}</label>
                    <div class="controls">
                        <input class="password" name="password" type="password" placeholder="{#password#}">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox">
                            <input class="rememberme" name="rememberme" type="checkbox">
                            {#remember_me#}
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input class="redirect" name="redirect" type="text" value="{$redirect}" style="display: none;">
                        <button type="submit" class="btn btn-primary">{#login_button#}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#" class="">{#forgot_password#}</a>
        </div>
    </div>
</div>

{/block}
