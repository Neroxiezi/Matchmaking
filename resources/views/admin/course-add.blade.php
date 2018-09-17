@extends('layouts.admin.main')
@section('content')
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
                <label class="layui-form-label">性别</label>
                <div class="layui-input-block">
                    <input type="radio" name="sex" value="0" title="男">
                    <input type="radio" name="sex" value="1" title="女" checked>
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
                <label for="L_repass" class="layui-form-label">
                </label>
                <button class="layui-btn" lay-filter="add" lay-submit="">
                    添加
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
        });
    </script>
@endsection