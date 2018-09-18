@extends('layouts.admin.main')
@section('content')
    <style>

        .file-box {
            display: inline-block;
            position: relative;
            padding: 0 18px;
            overflow: hidden;
            height: 38px;
            color: #fff;
            text-align: center;
            background-color: #009688;
            cursor: pointer;
            line-height: 38px;

        }

        .file-btn {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            outline: none;
            background-color: transparent;
            filter: alpha(opacity=0);
            -moz-opacity: 0;
            -khtml-opacity: 0;
            opacity: 0;
            cursor: pointer;
        }
    </style>
    <link href="https://cdn.bootcss.com/select2/4.0.5/css/select2.min.css" rel="stylesheet">
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>课程:
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" required="" lay-verify="name"
                           autocomplete="off" class="layui-input" placeholder="请输入课程名">
                </div>
            </div>
            <div class="layui-form-item">
                <input type="hidden" value="" name="photo" id="photo_val" lay-verify="photo">
                <label class="layui-form-label"><span class="x-red">*</span> 视频封面</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" id="photo">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"></label>
                <div class="layui-input-block" id="upload_result">
                </div>
            </div>
            <div class="layui-form-item">
                <input type="hidden" value="" name="video" id="video_val" lay-verify="video">
                <label class="layui-form-label"><span class="x-red">*</span> 视频:</label>
                <div class="layui-input-block">
                    <div class="file-box">
                        <input type="file" name="file" id="file" class="file-btn">
                        <i class="layui-icon">&#xe67c;</i> 上传视频
                    </div>
                    <br>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span class="x-red">*</span> 选择标签:</label>
                <div class="layui-input-inline">
                    <select id="area" name="tag" class="select2">
                        <option value="" selected="selected">请选择标签</option>
                        @if(count($tag_list)>0)
                            @foreach($tag_list as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button class="layui-btn" lay-filter="add" lay-submit="">
                    保存数据
                </button>
            </div>
        </form>
    </div>
    <script src="https://cdn.bootcss.com/select2/3.4.0/select2.min.js"></script>
    <script>
        //$('#area').select2();
        var arr = [];
        var page = {
            arr: [],
            init: function (callback) {
                $("#file").change($.proxy(this.upload, this, callback));
            },
            upload: function (callback) {
                var file = $("#file")[0].files[0], //文件对象
                    name = file.name, //文件名
                    size = file.size, //总大小
                    succeed = 0;
                var shardSize = 2 * 1024 * 1024, //以2MB为一个分片
                    shardCount = Math.ceil(size / shardSize); //总片数
                var arr = [];
                for (var i = 0; i < shardCount; ++i) {
                    //计算每一片的起始与结束位置
                    var start = i * shardSize,
                        end = Math.min(size, start + shardSize);

                    //构造一个表单，FormData是HTML5新增的
                    var form = new FormData();
                    form.append("data", file.slice(start, end)); //slice方法用于切出文件的一部分
                    form.append("name", name);
                    form.append("total", shardCount); //总片数
                    form.append("index", i + 1); //当前是第几片
                    form.append("_token", "{{csrf_token()}}");
                    //Ajax提交
                    $.ajax({
                        url: '{{url('admin/course/video')}}',
                        type: "POST",
                        data: form,
                        async: false, //异步
                        processData: false, //很重要，告诉jquery不要对form进行处理
                        contentType: false, //很重要，指定为false才能形成正确的Content-Type
                        success: function (res) {
                            ++succeed
                            arr.push(res);
                        }
                    });
                }
                callback && callback(arr)
            }

        };
        layui.use(['form', 'layer', 'element'], function () {
            $ = layui.jquery;
            var form = layui.form, layer = layui.layer, element = layui.element;
            layui.use('upload', function () {
                upload = layui.upload;
                upload.render({
                    elem: '#photo'
                    , url: '{{url('admin/course/img')}}'
                    , before: function (obj) { //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                        layer.load(); //上传loading
                    }
                    , data: {
                        _token: '{{csrf_token()}}'
                    }
                    , done: function (res, index, upload) {
                        layer.closeAll('loading'); //关闭loading
                        if (res.ret == 200) {
                            layer.msg('上传成功');
                            $("#upload_result").empty().append('<img src="' + res.data['url'] + '" style="width: 100px;height:100px;">');
                            $("#photo_val").val(res.data['url'])
                        }
                    }
                });
            });
            page.init(function (res) {
                var url = res[res.length - 1].url
                layer.msg('视频上传成功')
                $("#video_val").val(url);
            });

            form.verify({
                name: function (value) {
                    if (value.length < 2) {
                        return '课程名得2个字符啊';
                    }
                },
                photo: function (value) {
                    if (value.length <= 0) {
                        return '请上传封面图';
                    }
                }
            });
            //监听提交
            form.on('submit(add)', function (data) {
                data.field['_token'] = '{{csrf_token()}}'
                //发异步，把数据提交给php
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/course')}}",
                    data: data.field,
                    success: function (res) {
                        if (res.code == 200) {
                            layer.msg('添加成功',{icon: 1,time: 2000});
                            var index = parent.layer.getFrameIndex(window.name);
                            setTimeout(function(){
                                layer.close(index);
                                window.parent.location.reload();
                            },2000)
                        } else {
                            layer.msg('添加失败')
                        }
                    }
                });
                return false;
            })
        });

    </script>
@endsection