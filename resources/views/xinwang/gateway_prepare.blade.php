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
                <div class="span12">
                    <form id="xinwangform" class="form-horizontal" role="form" action="{{ $url }}" method="post" target="_blank">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <h3>网关接口-数据准备</h3>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label for="serviceName" class="col-sm-2 control-label">serviceName</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="serviceName" name="serviceName"
                                placeholder="" autocomplete="on" value="{{ $serviceName }}" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="platformNo" class="col-sm-2 control-label">platformNo</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="platformNo" name="platformNo"
                                placeholder="" autocomplete="on" value="{{ $platformNo }}" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userDevice" class="col-sm-2 control-label">userDevice</label>
                            <div class="col-sm-10">
                            <select class="form-control" id="userDevice" name="userDevice" required="required">
                                <option value="PC" selected="selected">PC</option>
                                <option value="MOBILE">MOBILE</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reqData" class="col-sm-2 control-label">reqData</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="reqData" name="reqData" rows="5"  readonly="readonly" required="required">{{ $reqData }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keySerial" class="col-sm-2 control-label">keySerial</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="keySerial" name="keySerial"
                                placeholder="" autocomplete="on" value="{{ $keySerial }}" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sign" class="col-sm-2 control-label">sign</label>
                            <div class="col-sm-10">
                            <textarea class="form-control" id="sign" name="sign" rows="5" readonly="readonly" required="required">{{ $sign }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="button" class="btn btn-default">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- json格式预览 -->
                <pre id="json-preview">
</pre>
            </div>
        </div>
        <script type="text/javascript">
            //数据格式化为对象
            $.fn.serializeObject = function() {
                var o = {};
                var a = this.serializeArray();
                $.each(a, function() {
                    if (o[this.name] !== undefined) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });
                return o;
            };

            function jsonformat(txt,compress/*是否为压缩模式*/){/* 格式化JSON源码(对象转换为JSON文本) */  
                var indentChar = '    ';   
                if(/^\s*$/.test(txt)){   
                    alert('数据为空,无法格式化! ');   
                    return;   
                }   
                try{var data=eval('('+txt+')');}   
                catch(e){   
                    alert('数据源语法错误,格式化失败! 错误信息: '+e.description,'err');   
                    return;   
                };   
                var draw=[],last=false,This=this,line=compress?'':'\n',nodeCount=0,maxDepth=0;   
                   
                var notify=function(name,value,isLast,indent/*缩进*/,formObj){   
                    nodeCount++;/*节点计数*/  
                    for (var i=0,tab='';i<indent;i++ )tab+=indentChar;/* 缩进HTML */  
                    tab=compress?'':tab;/*压缩模式忽略缩进*/  
                    maxDepth=++indent;/*缩进递增并记录*/  
                    if(value&&value.constructor==Array){/*处理数组*/  
                        draw.push(tab+(formObj?('"'+name+'":'):'')+'['+line);/*缩进'[' 然后换行*/  
                        for (var i=0;i<value.length;i++)   
                            notify(i,value[i],i==value.length-1,indent,false);   
                        draw.push(tab+']'+(isLast?line:(','+line)));/*缩进']'换行,若非尾元素则添加逗号*/  
                    }else   if(value&&typeof value=='object'){/*处理对象*/  
                            draw.push(tab+(formObj?('"'+name+'":'):'')+'{'+line);/*缩进'{' 然后换行*/  
                            var len=0,i=0;   
                            for(var key in value)len++;   
                            for(var key in value)notify(key,value[key],++i==len,indent,true);   
                            draw.push(tab+'}'+(isLast?line:(','+line)));/*缩进'}'换行,若非尾元素则添加逗号*/  
                        }else{   
                                if(typeof value=='string')value='"'+value+'"';   
                                draw.push(tab+(formObj?('"'+name+'":'):'')+value+(isLast?'':',')+line);   
                        };   
                };   
                var isLast=true,indent=0;   
                notify('',data,isLast,indent,false);   
                return draw.join('');   
            } 

            //获取json预览
            function json_preview(){
                var json_str = test();
                console.log(json_str);
                json_str = jsonformat(json_str);
                $('#json-preview').text(json_str);
                return false;
            }

            //json预览
            $(function(){
                json_preview();
                $('input').bind('input propertychange', function() {  
                    json_preview();
                });
                $('select').bind('propertychange click', function() {  
                    json_preview();
                }); 
            })
                
            function test() {
                var arr = getElements("xinwangform");
                var rs = new Object();
                rs['COD'] = "102";
                rs['MSG'] = "0";
                rs['Key'] = new Object();
                rs['Key']['code'] = "100"; 
                rs['Key']['num'] = "1"; 
                rs['Key']['data'] = new Object();
                rs['Key']['data']['postParams'] = Array();
                var count = 0;
                for(var i in arr) {
                    rs['Key']['data']['postParams'][count] = new Object();
                    rs['Key']['data']['postParams'][count]["key"] = i ;
                    rs['Key']['data']['postParams'][count]["vaule"] = arr[i].replace(/"/g, '\\"');
                    count++;
                }

                rs['Key']['data']['url'] = $("#xinwangform").attr("action");    

                var str = JSON.stringify(rs);
                return str;
            }
            function getElements(formId) {  
                var form = document.getElementById(formId);  
                var obj = new Object();   
                for (var j = 0; j < form.length; j++){
                    if(form.elements[j].name != "button") {
                        obj[form.elements[j].name] = form.elements[j].value;
                    }
                } 
                return obj;  
            }
        </script>
    </body>
</html>
