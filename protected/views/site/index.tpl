{extends '../layouts/struct.tpl'}

{block 'js-ext'}
    <script type="text/javascript" src="{$baseUrl}/js/ajaxfileupload.js"></script>
    <script type="text/javascript" src="{$baseUrl}/js/upload.js"></script>
{/block}

{block 'content'}
    <form class="form-horizontal" action="authenticate" method="post">
        <div class="control-group">
            <label class="control-label" for="uploadfile">File</label>
            <div class="controls">
                <input class="uploadfile" name="uploadfile" type="file" placeholder="File">
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="button" class="upload btn btn-primary">Upload</button>
            </div>
        </div>
    </form>
{/block}
