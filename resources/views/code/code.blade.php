<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>沙小僧短信验证码查询</title>
    <!-- Latest compiled and minified CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional theme -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" rel="stylesheet">

    <script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <form class="form-horizontal" role="form" action="" method="get">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <h3>短信验证码查询</h3>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="server" class="col-sm-2 control-label">数据库</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="server" name="server">
                            <option value="1" selected="true">230服务器</option>
                            <option value="2" >线上服务器</option>
                            <option value="3">测试服务器</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-sm-2 control-label">手机号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="mobile" name="mobile"
                               placeholder="" autocomplete="on">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-default" onclick="usercode()">查询信息</button>
                    </div>
                </div>
                <div class="form-group" >
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10" id="userinfo">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function usercode() {
        var server = $("#server").val();
        var mobile = $("#mobile").val();
        $.ajax({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
            type:"POST",
            url:"{{ route('server_usercode') }}",
            data:"mobile="+mobile+"&server="+server,
            success:function(data){
                $("#userinfo").html(data);
            },
            error:function(jqXHR, textStatus, errorThrown){
                $("#userinfo").html(jqXHR.responseText);
            }
        });
    }
</script>
</body>
</html>
