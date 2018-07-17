<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>模拟回调_新网存管系统测试</title>
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
                    <form class="form-horizontal" role="form" action="/xinwang/recharge_prepare" method="post">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <h3>模拟回调--{{ $name }}</h3>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label for="serviceName" class="col-sm-2 control-label">serviceName</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="serviceName" name="serviceName">
                                    @foreach ($sns as $value)
                                        @if ($value['serviceName'] == $sn)
                                            <option value="{{ $value['serviceName'] }}" selected="selected"> {{$value['serviceName']}}（{{ $value['name'] }}）</option>
                                        @else
                                            <option value="{{ $value['serviceName'] }}">{{$value['serviceName']}}（{{ $value['name'] }}）</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @foreach ($prams as $key=>$value)
                            <div class="form-group">
                            <label class="col-sm-2 control-label">{{ $key }} 【<?=(isset($value[1]) && $value[1] == 1) ? '必填' : "非必填"?>】</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" name="{{ $key }}"
                                placeholder="" autocomplete="on" value="{{$value[0]}}" <?=(isset($value[1]) && $value[1] == 1) ? 'required="required"' : ""?> <?=(isset($value[2]) && $value[2] == 1) ? 'readonly="readonly"' : ""?>>
                            </div>
                        </div>
                         @endforeach
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default" onclick="">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $('#serviceName').change(function () {
                if($('#serviceName').val() != '')
                {
                    $sn = $('#serviceName').val();
                    self.location='/xinwang/recharge?sn='+$sn;
                }
            });
        </script>
    </body>
</html>
