@extends('layouts.admin.main')
@section('content')
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <input type="hidden" name="_method" value="PUT">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>标签名:
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" required="" lay-verify="name"
                           autocomplete="off" class="layui-input" value="{{$tag->name}}" placeholder="请输入标签名">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button class="layui-btn" lay-filter="add" lay-submit="">
                    修改
                </button>
            </div>
        </form>
    </div>
    <script>


        layui.use(['form', 'layer'], function () {
            $ = layui.jquery;

            var form = layui.form, layer = layui.layer;

            //自定义验证规则
            form.verify({
                name: function (value) {
                    if (value.length < 2) {
                        return '标签名至少2个字符啊';
                    }
                }
            });
            //监听提交
            form.on('submit(add)', function (data) {
                console.log(data.field);
                data.field['_token'] = '{{csrf_token()}}'
                //发异步，把数据提交给php
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/tag/'.$tag->id)}}",
                    data: data.field,
                    success: function (res) {
                        if (res.code == 200) {
                            layer.msg('修改成功', {icon: 1, time: 2000});
                            var index = parent.layer.getFrameIndex(window.name);
                            setTimeout(function () {
                                layer.close(index);
                                window.parent.location.reload();
                            }, 2000)
                        } else {
                            layer.msg('修改失败')
                        }
                    }
                });
                return false;
            });
        });
    </script>
    <script>var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();</script>
@endsection