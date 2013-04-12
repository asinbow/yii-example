(function () {
    $(function () {
        function ajaxFileUpload()
        {
            $.ajaxFileUpload({
                method: 'POST',
                url: apiUrl + '/asset',
                secureuri: false,
                fileElement: $('.uploadfile'),
                dataType: 'json',
                data: {
                    type: 'image',
                    file: 'uploadfile'
                },
                success: function (data, status) {
                    if(typeof(data.error) != 'undefined') {
                        if(data.error != '') {
                            alert(data.error);
                        } else {
                            alert(data.msg);
                        }
                    }
                },
                error: function (data, status, e) {
                    alert(e);
                }
            });

            return false;
        }

        $("button.upload").click(function () {
            ajaxFileUpload();
        });
    });
}());

