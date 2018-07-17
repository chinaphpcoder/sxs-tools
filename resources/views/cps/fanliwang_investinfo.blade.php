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
                    <form class="form-horizontal" role="form" action="" method="post">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <h3>返利网投资信息</h3>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label for="start_time" class="col-sm-2 control-label">开始时间</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="start_time" name="start_time"
                                placeholder="" autocomplete="on" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end_time" class="col-sm-2 control-label">结束时间</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="end_time" name="end_time"
                                placeholder="" autocomplete="on" required="required">
                            </div>
                        </div>

                                           
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-default" onclick="investinfo()">查询信息</button>
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
