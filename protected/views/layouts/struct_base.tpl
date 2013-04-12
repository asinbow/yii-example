{config_load 'app.conf'}
{config_load 'zh_cn/app.conf'}

{assign 'baseUrl' $app->request->baseUrl}
{assign 'homeUrl' $baseUrl|cat:"/index.php"}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>
            {block 'title'}{#appname#}{/block}
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript">
            var baseUrl = '{$baseUrl}';
            var homeUrl = '{$homeUrl}';
            var apiUrl = homeUrl + '/api';
        </script>
        {block 'head'}
        {/block}
    </head>
    <body>
        {block 'body'}
        {/block}
    </body>
</html>
