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

        <script src="//cdn.bootcss.com/json2/20160511/json2.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12" id="post-result">
                    <form id="xinwangform" class="form-horizontal" role="form" action="" method="post" target="_blank">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <h3>模拟回调-数据准备({{ $url }})</h3>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label for="platformNo" class="col-sm-2 control-label">platformNo</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="platformNo" name="platformNo"
                                placeholder="" autocomplete="on" value="{{ $platformNo }}" required="required" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="serviceName" class="col-sm-2 control-label">serviceName</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="serviceName" name="serviceName"
                                placeholder="" autocomplete="on" value="{{ $serviceName }}" required="required" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="respData" class="col-sm-2 control-label">respData</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="respData" name="respData" rows="5"  readonly="readonly" required="required">{{ $respData }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="appkey" class="col-sm-2 control-label">appkey</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="appkey" name="appkey"
                                placeholder="" autocomplete="on" value="{{ $appkey }}" required="required" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="timestamp" class="col-sm-2 control-label">timestamp</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="timestamp" name="timestamp"
                                placeholder="" autocomplete="on" value="{{ $timestamp }}" required="required" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nonce" class="col-sm-2 control-label">nonce</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="nonce" name="nonce"
                                placeholder="" autocomplete="on" value="{{ $nonce }}" required="required" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sign" class="col-sm-2 control-label">sign</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="sign" name="sign"
                                placeholder="" autocomplete="on" value="{{ $sign }}" required="required" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-default" onclick="xinwangpost()">提交</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       <script type="text/javascript">
            function xinwangpost() {
                var data =  $("#xinwangform").getParamString();
                data = encodeURIComponent(data);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                    type:"POST",
                    url:"{{ route('recharge_server') }}",
                    data:'data='+data,
                    success:function(data){
                        $("#post-result").html(data);
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $("#post-result").html(jqXHR.responseText);
                    }
                });
            }
            $.fn.getParamString = function() {
                var o = '';
                var a = this.serializeArray();
                $.each(a, function() {
                    o += '&' + this.name + '=' + encodeURIComponent(this.value);
                });
                if(o.length > 1) {
                    o = o.substr(1);
                }
                return o;
            };
        </script>
    </body>
</html>
