<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>新网存管系统测试</title>
        <!-- Latest compiled and minified CSS -->
        <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- Optional theme -->
        <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" rel="stylesheet">

        <script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
    <h2>
        <a href="/xinwang/gateway" target="_self">网关接口测试</a>
    </h2>
    <h2>
        <a href="/xinwang/direct" target="_self">直连接口测试</a>
        <!-- <a href="/xinwang/direct" target="_self">直连接口测试</a> -->
    </h2>
    <h2>
        <a href="{{url('/xinwang/download')}}" target="_self">对账文件下载</a>
        <!-- <a href="/xinwang/direct" target="_self">直连接口测试</a> -->
    </h2>
    <h2>
        <a href="{{url('/xinwang/recharge')}}" target="_self">模拟回调</a>
        <!-- <a href="/xinwang/direct" target="_self">直连接口测试</a> -->
    </h2>
    </body>
    </body>
</html>
