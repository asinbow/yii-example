{extends '../layouts/struct.tpl'}

{block 'body'}
    <form class="form-horizontal" action="authenticate" method="post">
        <div class="control-group">
            <label class="control-label" for="inputName">Name</label>
            <div class="controls">
                <input id="username" name="username" type="text" placeholder="Name">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputPassword">Password</label>
            <div class="controls">
                <input id="password" name="password" type="password" placeholder="Password">
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <label class="checkbox">
                    <input id="rememberme" name="password" type="checkbox"> Remember me
                </label>
                <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
        </div>
    </form>
{/block}
