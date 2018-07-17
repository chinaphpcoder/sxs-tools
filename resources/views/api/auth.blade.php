<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>沙小僧API加密解密工具</title>
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
                                <h3>API加密解密调试工具</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">客户端</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="type" name="type">
                                    <option value="1">IOS</option>
                                    <option value="2">ANDROID</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-default" onclick="genauth()">随机生成</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="col-sm-10" id="authinfo">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function genauth() {
                var type = $("#type").val();
                $.ajax({
                    headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                    type:"POST",
                    url:"{{ route('server_api_auth') }}",
                    data:"type="+type,
                    success:function(data){
                        $("#authinfo").html(data);
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $("#authinfo").html(jqXHR.responseText);
                    }
                });
            }
            function encode() {
                var server = $("#server").val();
                var type = $("#type").val();
                var userid = $("#userid").val();
                var authid = $("#authid").val();
                var data = $("#data2").val();
                data = encodeURIComponent(data);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                    type:"POST",
                    url:"{{ route('server_appencode') }}",
                    data:"server="+server+"&type="+type+"&userid="+userid+"&authid="+authid+"&data="+data,
                    success:function(data){
                        $("#data1").val(data);
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        // alert(jqXHR.responseText);
                        // alert(jqXHR.status);
                        // alert(jqXHR.readyState);
                        // alert(jqXHR.statusText);
                        // alert(textStatus);
                        // alert(errorThrown);
                        $("#data1").val(jqXHR.responseText);
                    }
                });
            }
            $('#userid').blur(function () {
                if($('#userid').val() != '')
                {
                    $('#authid').attr("disabled",true);
                } else {
                    $('#authid').attr("disabled",false);
                }
                //alert($(this).val());
            });

            $('#authid').blur(function () {
                if($('#authid').val() != '')
                {
                    $('#userid').attr("disabled",true);
                } else {
                    $('#userid').attr("disabled",false);
                }
                //alert($(this).val());
            });
//                $.ajax({
//                    url : url,
//                    async : false, // 注意此处需要同步，因为返回完数据后，下面才能让结果的第一条selected
//                    type : "POST",
//                    dataType : "json",
//                    success : function(fields) {
//                        var rf = new Array();
//                        for ( var f in fields) {
//                            rf.push(fields[f].fieldName);
//                        }
//                        requiredCols = rf.join(",");
//                    }
//                });

               // alert(requiredCols );// (2)

           // }
        </script>
    </body>
</html>
