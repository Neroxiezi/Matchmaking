# 一个简单的视频网站

---
Author: Lampxiezi@163.com
Create_time: 2018/9/19

### 前端

pfinaljs 一款简单的 前端UI

### 后端

Laravel5.5 + Mysql

### 截图

- 首页:

![](/public/images/index.png)

- 视频页:
![](/public/images/shiping.png)

- 播放器:
![](/public/images/video.png)

*播放器代码:*

```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script>
        window.pfinaljs = {};
        window.pfinaljs.base = '../';
    </script>
    <script src="../require.js"></script>
    <script src="../config.js"></script>
</head>

<body style="padding: 50px;">
    <video id="my-video" class="video-js vjs-big-play-centered VideoSpeed" controls preload="auto" width="1200" height="550"
        poster="https://tse2.mm.bing.net/th?id=OIP.fy9v0WjvXrB2GIECMWULIAHaFj&pid=Api" data-setup="{}">
        <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
        <source src="http://vjs.zencdn.net/v/oceans.webm" type="video/webm">
        <source src="http://vjs.zencdn.net/v/oceans.ogv" type="video/ogg">
        <p class="vjs-no-js">
            要查看此视频，请启用JavaScript，并考虑升级到web浏览器
            <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
        </p>
    </video>
    <script>
        require(['pfinaljs'], function (pfinaljs) {
            pfinaljs.video('my-video', function (video) {
                video.width(1000);
            })
        })
    </script>
</body>

</html>

```

- 后台登录页:

![](/public/images/login.png)

- 后台主页:

![](/public/images/main.png)

---

项目学习内容:

主要使用了视频切片上传,代码如下:

```javascript
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
```

后端代码:

```php
 public function upload_section(Request $request, $prefix = '/uploads')
    {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $findex = $request->input('index');
        $ftotal = $request->input('total');
        $fdata = $_FILES['data'];
        $fname = mb_convert_encoding($request->input('name'), "gbk", "utf-8");
        $path = $prefix;
        $dir = $path . "/video/";
        $save = $dir . $fname;
        if (!file_exists(public_path($dir))) {
            mkdir(public_path($dir), 0777, true);
        }
        $temp = fopen($fdata["tmp_name"], "r+");
        $filedata = fread($temp, filesize($fdata["tmp_name"]));
        if (file_exists(public_path($dir . "/" . $findex . ".tmp"))) unlink(public_path($dir . "/" . $findex . ".tmp"));
        $tempFile = fopen(public_path($dir . "/" . $findex . ".tmp"), "w+");
        //var_dump($tempFile);
        fwrite($tempFile, $filedata);
        fclose($tempFile);
        fclose($temp);

        @set_time_limit(5 * 60);

        //if (file_exists($save)) @unlink($save);
        for($i=1;$i<=$ftotal;$i++)
        {
            $readData = @fopen(public_path($dir."/".$i.".tmp"),"r+");
            $writeData = @fread($readData,filesize(public_path($dir."/".$i.".tmp")));
            //var_dump($writeData);
            $newFile = @fopen(public_path($save),"a+");
            fwrite($newFile,$writeData);
            if($newFile) fclose($newFile);
            if($readData) fclose($readData);
            @unlink(public_path($dir."/".$i.".tmp"));
        }
        return array("status" => "success", "url" => mb_convert_encoding($save, 'utf-8', 'gbk'));
    }


```
