@extends('layouts.admin.main')
@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="{{url('admin')}}">首页</a>
        <a href="{{url('admin/course')}}">课程管理</a>
        <a>
          <cite>课程列表</cite></a>
      </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so">
                <input type="text" name="username" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </form>
        </div>
        <xblock>
            <button class="layui-btn" onclick="x_admin_show('添加标签','{{url('admin/course/create')}}','40%','60%')"><i
                        class="layui-icon"></i>添加
            </button>
            <span class="x-right" style="line-height:40px">共有数据：88 条</span>
        </xblock>
        <table class="layui-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>课程名</th>
                <th>标签</th>
                <th>封面</th>
                <th>查看视频</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if(count($course_list)>0)
                @foreach($course_list as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->title}}</td>
                        <td><label class="layui-btn layui-btn-xs">{{$item->tag->name}}</label></td>
                        <td><img src="{{$item->img}}" alt="" style="width:50px;height:50px;"></td>
                        <td>
                            <button class="layui-btn layui-btn-primary layui-btn-sm">查看</button>
                        </td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a onclick="tag_del(this,'{{$item->id}}')">删除</a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <script>
        var layer;
        layui.use(['layer'], function () {
            layer = layui.layer
        })

        function tag_del(obj, id) {
            layer.confirm('确认要删除吗？', {
                btn: ['确定', '取消']//按钮
            }, function (index) {
                $.ajax({
                    type: 'delete',
                    url: '{{url('admin/tag/')}}' + '/' + id,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            layer.msg('删除成功', {icon: 1, time: 2000});
                            setTimeout(function () {
                                layer.close(index);
                                location.reload();
                            }, 2000)
                        } else {
                            layer.msg('删除成功')
                        }
                    }
                })
            });
        }
    </script>
@endsection