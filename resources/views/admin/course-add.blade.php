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

            <fieldset class="layui-elem-field layui-field-title">
                <legend>视频管理</legend>
                <div class="layui-form-item">
                    <div class="layui-card">
                        <div class="layui-card-body">
                            <div class="form-group " id="aetherupload-wrapper" ><!--组件最外部需要有一个名为aetherupload-wrapper的id，用以包装组件-->
                                <label>文件1(带回调)：</label>
                                <div class="controls" >
                                    <input type="file" id="file"  onchange="aetherupload(this,'file').success(someCallback).upload()"/><!--需要有一个名为file的id，用以标识上传的文件，aetherupload(file,group)中第二个参数为分组名，success方法可用于声名上传成功后的回调方法名-->
                                    <div class="progress " style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 200px;">
                                        <div id="progressbar" style="background:blue;height:6px;width:0;"></div><!--需要有一个名为progressbar的id，用以标识进度条-->
                                    </div>
                                    <span style="font-size:12px;color:#aaa;" id="output"></span><!--需要有一个名为output的id，用以标识提示信息-->
                                    <input type="hidden" name="file1" id="savedpath" ><!--需要有一个名为savedpath的id，用以标识文件保存路径的表单字段，还需要一个任意名称的name-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button class="layui-btn" lay-filter="add" lay-submit="">
                    保存数据
                </button>
            </div>
        </form>
    </div>
    <script src="{{ URL::asset('js/spark-md5.min.js') }}"></script><!--需要引入spark-md5.min.js-->
    <script src="//cdn.bootcss.com/jquery/2.2.3/jquery.min.js"></script><!--需要引入jquery.min.js-->
    <script src="{{ URL::asset('js/aetherupload.js') }}"></script><!--需要引入aetherupload.js-->
    <script>
        // success(callback)中声名的回调方法需在此定义，参数callback可为任意名称，此方法将会在上传完成后被调用
        // 可使用this对象获得fileName,fileSize,uploadBaseName,uploadExt,subDir,group,savedPath等属性的值
        someCallback = function(){
            // Example
           alert(this.fileName)
        }

    </script>
@endsection