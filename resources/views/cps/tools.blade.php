<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CPS_返利网投资数据导出</title>
        <!-- Latest compiled and minified CSS -->
        <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- Optional theme -->
        <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" rel="stylesheet">

        <link href="{{asset('public/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">

        <script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="{{asset('public/js/bootstrap-datetimepicker.min.js')}}"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <form class="form-horizontal" role="form" action="" method="get">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <h3>CPS测试工具</h3>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label for="start_time" class="col-sm-2 control-label">测试环境地址</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="base_url" name="base_url"
                                placeholder="" autocomplete="on" required="required" value="{{ $datas['base_url'] }}" />
                            </div>
                            <div class="col-sm-1">
                                <button type="submit" class="btn btn-default">应用</button>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-default" onclick="location.reload();">刷新数据</button>
                            </div>
                        </div>
                    </form>
                </div>
                 <div class="span12">
                    <form class="form-horizontal" role="form" action="" method="post">

                        <hr>

                        <div class="form-group">
                            <label for="start_time" class="col-sm-2 control-label">返利网注册</label>
                            <div class="col-sm-10">
                                <a  href="{{ $datas['fanli_register'] }}" target="_blank">{{ $datas['fanli_register'] }}</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start_time" class="col-sm-2 control-label">返利网查询</label>
                            <div class="col-sm-10">
                                <a href="{{ $datas['fanli_query'] }}" target="_blank">{{ $datas['fanli_query'] }}</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start_time" class="col-sm-2 control-label">车主无忧注册</label>
                            <div class="col-sm-10">
                                <a href="{{ $datas['chezhu_register'] }}" target="_blank">{{ $datas['chezhu_register'] }}</a>
                            </div>
                        </div
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function investinfo() {
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();
                $.ajax({
                    headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                    type:"POST",
                    url:"{{ route('server_cps_fanliwang_investinfo') }}",
                    data:"start_time="+start_time+"&end_time="+end_time,
                    success:function(data){
                        $("#userinfo").html(data);
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $("#userinfo").html(jqXHR.responseText);
                    }
                });
            }
            $("#start_time").datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'}); 
            $("#end_time").datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});           
        </script>
    </body>
</html>
