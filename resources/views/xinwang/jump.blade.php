<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>新网存管系统测试环境跳转页面</title>
        <!-- Latest compiled and minified CSS -->
        <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- Optional theme -->
        <!-- <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" rel="stylesheet"> -->

        <!-- <script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> -->

        <!-- Latest compiled and minified JavaScript -->
        <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                        <div class="form-group">
                            <div>
                                <h3>新网存管系统网关接口回调数据</h3>
                            </div>
                        </div>
                        <div class="form-group">
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>字段名</th>
                                    <th>内容</th>
                                </tr>
                            </thead>
                            @foreach ($datas as $key=>$value)
                                <tr >
                                <td>{{ $key }}</td>
                                <td>{{ $value }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
        </div>
    </body>
</html>
