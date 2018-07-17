<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>消息服务(MNS)系统测试</title>
        <!-- Latest compiled and minified CSS -->
        <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- Optional theme -->
        <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" rel="stylesheet">

        <link href="{{asset('/layui/css/layui.css')}}" rel="stylesheet">

        <script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>

        <script src="//cdn.bootcss.com/json2/20160511/json2.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{asset('/layui/layui.js')}}"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <form id="mns-form" class="form-horizontal" role="form" action="" method="post" target="_blank">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <h3 style="margin-top: 20px; margin-bottom: 10px">消息服务(MNS)-数据推送</h3>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label for="platformNo" class="col-sm-2 control-label">消息内容</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="message" name="message" rows="5" required="required"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-default" onclick="mns_post()">推送</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       <script type="text/javascript">
            function mns_post() {
                var data =  $("#mns-form").serialize();
                $.ajax({
                    headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                    type:"POST",
                    url:"{{ route('push_server') }}",
                    data:data,
                    success:function(data){
                        layui.use(['layer'], function(){
                              var layer = layui.layer;                          
                              layer.alert(data);
                            });
                        // $("#message").val(data);
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $("#post-result").html(jqXHR.responseText);
                    }
                });
            }
        </script>
    </body>
</html>
