<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>沙小僧-新网对账记录</title>
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
                    <form class="form-horizontal" role="form" action="" method="post">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <h3></h3>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="date" class="col-sm-1 control-label">数据日期</label>
                            <div class="col-sm-11">
                                <select class="form-control" id="date" name="date">
                                    @foreach ($dates as $value)
                                        @if ($value == $date)
                                            <option value="{{ $value }}" selected="selected">{{ $value }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <table class="table table-striped">
                                    <caption >对账信息</caption>
                                    <thead>
                                        <tr>
                                        <th>日期</th>
                                        <th>下载状态</th>
                                        <th>确认状态</th>
                                        <th>总体对账状态</th>
                                        <th>充值对账状态</th>
                                        <th>提现对账状态</th>
                                        <th>佣金对账状态</th>
                                        <th>回充对账状态</th>
                                        <th>交易对账状态</th>
                                        <th>确认时间</th>
                                        <th>更新时间</th>
                                        </tr>

                                        @foreach ($datas as $value)
                                            <tr >
                                            <td>{{$value['date']}}</td>
                                            <td>{{$value['download_status']}}</td>
                                            <td>{{$value['confirm_status']}}</td>
                                            <td>{{$value['overall_bill_status']}}</td>
                                            <td>{{$value['recharge_bill_status']}}</td>
                                            <td>{{$value['withdraw_bill_status']}}</td>
                                            <td>{{$value['commission_bill_status']}}</td>
                                            <td>{{$value['backroll_bill_status']}}</td>
                                            <td>{{$value['transaction_bill_status']}}</td>
                                            <td>{{$value['confirm_time']}}</td>
                                            <td>{{$value['last_time']}}</td>
                                            </tr>
                                        @endforeach
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $('#date').change(function () {
                if($('#date').val() != '')
                {
                    $date = $('#date').val();
                    self.location='/xinwang/checkbill?date='+$date;
                }
            });
        </script>
    </body>
</html>
