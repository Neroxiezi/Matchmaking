@extends('layouts.admin.main')
@section('content')
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="{{url('admin')}}">首页</a>
        <a href="{{url('admin/tag')}}">标签管理</a>
        <a>
          <cite>标签列表</cite></a>
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
            <button class="layui-btn" onclick="x_admin_show('添加标签','{{url('admin/tag/create')}}','50%','30%')"><i
                        class="layui-icon"></i>添加
            </button>
            <span class="x-right" style="line-height:40px">共有数据：88 条</span>
        </xblock>
        <table class="layui-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>标签名</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @if(count($tag_list)>0)
                @foreach($tag_list as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a onclick="edit_tag(this,'{{$item->id}}')"><i class="fa fa-adjust"></i> 编辑</a>
                            <a href="">删除</a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <script>
        var layer;
        layui.use('layer', function() {
                layer = layui.layer;;

        })
        function edit_tag(obj, id) {
            layer.open({
                type:1,
                title:'编辑标签',
                content:'123'
            });
        }
    </script>
@endsection