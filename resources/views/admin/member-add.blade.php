@extends('layouts.admin.main')
@section('content')
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">
                    <span class="x-red">*</span>用户名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="name" name="name" required="" lay-verify="name"
                           autocomplete="off" class="layui-input" placeholder="请输入用户名">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>将会成为您唯一的登入名
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>昵称
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_username" name="username" required="" lay-verify="nikename"
                           autocomplete="off" class="layui-input" placeholder="请输入昵称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">性别</label>
                <div class="layui-input-block">
                    <input type="radio" name="sex" value="0" title="男">
                    <input type="radio" name="sex" value="1" title="女" checked>
                </div>
            </div>
            <div class="layui-form-item">
                <input type="hidden" value="" name="photo" id="photo_val" lay-verify="photo">
                <label class="layui-form-label"><span class="x-red">*</span> 形象展示图</label>
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
                <label for="L_pass" class="layui-form-label">
                    <span class="x-red">*</span>密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_pass" name="password" required="" lay-verify="pass"
                           autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    6到16个字符
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                    <span class="x-red">*</span>确认密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_repass" name="repassword" required="" lay-verify="repass"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button class="layui-btn" lay-filter="add" lay-submit="">
                    增加
                </button>
            </div>
        </form>
    </div>
    <script>


        layui.use(['form', 'layer'], function () {
            $ = layui.jquery;

            var form = layui.form, layer = layui.layer;

            layui.use('upload', function () {
                upload = layui.upload;
                upload.render({
                    elem: '#photo'
                    , url: '{{url('admin/member/photo')}}'
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
            })
            //自定义验证规则
            form.verify({
                name: function (value) {
                    if (value.length < 5) {
                        return '昵称至少得5个字符啊';
                    }
                }
                , nikename: function (value) {
                    if (value.length < 5) {
                        return '昵称至少得5个字符啊';
                    }
                }
                , pass: [/(.+){6,12}$/, '密码必须6到12位']
                , repass: function (value) {
                    if ($('#L_pass').val() != $('#L_repass').val()) {
                        return '两次密码不一致';
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
                console.log(data);
                //发异步，把数据提交给php
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/member')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        data:data.field
                    },
                    success: function(msg){
                        //alert( "Data Saved: " + msg );
                    }
                });
//            layer.alert("增加成功", {icon: 6},function () {
//                // 获得frame索引
//                var index = parent.layer.getFrameIndex(window.name);
//                //关闭当前frame
//                parent.layer.close(index);
//            });
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